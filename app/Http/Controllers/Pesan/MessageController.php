<?php

namespace App\Http\Controllers\Pesan;

use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Notifications\PrivateMessageReceived;
use App\Services\AdminActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat_messages', 'public');
            $attachmentType = $file->getClientMimeType();
        }

        $message = ChatMessage::create([
            'conversation_id'  => $conversation->id,
            'sender_id'        => $user->id,
            'body'             => $validated['body'] ?? null,
            'attachment'       => $attachmentPath,
            'attachment_type'  => $attachmentType,
        ]);

        // perbarui last_message_at dengan aman
        $conversation->update(['last_message_at' => $message->created_at]);

        if (method_exists($message, 'sender')) {
            $message->load('sender');
        }

        // cari penerima (user lain di conversation)
        $recipientUser = $conversation->users()->where('users.id', '!=', $user->id)->first();

        if ($recipientUser) {

            try {
                $recipientUser->notify(new PrivateMessageReceived($message));
            } catch (\Throwable $e) {
            }
        }

        if (Auth::check() && Auth::user()->role === 'admin') {
            $summary = Str::limit($message->body ?? '', 100);
            AdminActivityLogger::log(
                'reply_private_message',
                "Membalas percakapan #{$message->conversation_id}: \"{$summary}\"",
                ['type' => 'Conversation', 'id' => $message->conversation_id],
                ['summary' => $summary, 'message_id' => $message->id]
            );
        }

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
        }

        $payload = [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'sender' => [
                'id' => $message->sender->id ?? $user->id,
                'name' => $message->sender->name ?? $user->name,
                'avatar' => $message->sender->avatar ? asset('storage/' . $message->sender->avatar) : null,
            ],
            'body' => $message->body,
            'attachment' => $message->attachment ? asset('storage/' . $message->attachment) : null,
            'attachment_type' => $message->attachment_type,
            'created_at' => $message->created_at?->toIso8601String(),
        ];

        return response()->json(['message' => $payload], 201);
    }

    // Update (edit) message
    public function update(Request $request, Conversation $conversation, ChatMessage $message)
    {
        $user = $request->user();

        // pemeriksaan otorisasi
        if ($message->conversation_id != $conversation->id) {
            abort(404);
        }
        if ($message->sender_id != $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'nullable|string|max:2000',
        ]);

        $old = $message->body;
        $message->body = $validated['body'] ?? $message->body;
        $message->save();

        if (method_exists($message, 'sender')) {
            $message->load('sender');
        }

        try {
            broadcast(new MessageUpdated($message))->toOthers();
        } catch (\Throwable $e) {}

        // jika admin mengedit, catat aktivitas
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'edit_private_message',
                "Mengedit pesan #{$message->id} pada percakapan #{$conversation->id}",
                ['type' => 'Conversation', 'id' => $conversation->id],
                ['message_id' => $message->id, 'old' => Str::limit($old, 80), 'new' => Str::limit($message->body, 80)]
            );
        }

        return response()->json(['message' => $message], 200);
    }

    // Hapus message
    public function destroy(Request $request, Conversation $conversation, ChatMessage $message)
    {
        $user = $request->user();

        if ($message->conversation_id != $conversation->id) {
            abort(404);
        }
        if ($message->sender_id != $user->id) {
            abort(403);
        }

        // hard delete
        $messageId = $message->id;
        $message->delete();

        try {
            broadcast(new MessageDeleted($conversation->id, $messageId))->toOthers();
        } catch (\Throwable $e) {}

        // jika admin menghapus, catat aktivitas
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'delete_private_message',
                "Menghapus pesan #{$messageId} pada percakapan #{$conversation->id}",
                ['type' => 'Conversation', 'id' => $conversation->id],
                ['message_id' => $messageId]
            );
        }

        return response()->json(['ok' => true], 200);
    }

    public function markRead(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $conversation->users()->updateExistingPivot($user->id, ['last_read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
