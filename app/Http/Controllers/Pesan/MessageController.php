<?php

namespace App\Http\Controllers\Pesan;

use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Notifications\PrivateMessageReceived;

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

        // update last_message_at safely
        $conversation->update(['last_message_at' => $message->created_at]);

        // load sender relation (safe)
        if (method_exists($message, 'sender')) {
            $message->load('sender');
        }

        // cari penerima (user lain di conversation)
        $recipientUser = $conversation->users()->where('users.id', '!=', $user->id)->first();

        if ($recipientUser) {
            // Simpan notifikasi konsisten
            \App\Models\Notification::create([
                'user_id' => $recipientUser->id,
                'type' => 'private_message',
                'data' => [
                    'message' => [
                        'id' => $message->id,
                        'conversation_id' => $message->conversation_id,
                        'sender' => [
                            'id' => $message->sender->id ?? $user->id,
                            'name' => $message->sender->name ?? $user->name,
                        ],
                        'body' => $message->body,
                        'created_at' => $message->created_at?->toDateTimeString(),
                    ],
                    'text' => $message->body,
                    'sender_id' => $message->sender_id,
                    'conversation_id' => $message->conversation_id,
                    'link' => route('pesan.index') . '?conv=' . $message->conversation_id,
                ],
                'is_read' => false,
            ]);

            // Notify model-based (optional) untuk broadcast / mail jika ada
            try {
                $recipientUser->notify(new PrivateMessageReceived($message));
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // Broadcast realtime ke channel conversation
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            // ignore
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

        // authorization checks
        if ($message->conversation_id != $conversation->id) {
            abort(404);
        }
        if ($message->sender_id != $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'nullable|string|max:2000',
        ]);

        $message->body = $validated['body'] ?? $message->body;
        $message->save();

        // load sender for payload
        if (method_exists($message, 'sender')) {
            $message->load('sender');
        }

        // broadcast event so other participant updates UI
        try {
            broadcast(new MessageUpdated($message))->toOthers();
        } catch (\Throwable $e) {}

        return response()->json(['message' => $message], 200);
    }

    // Delete message
    public function destroy(Request $request, Conversation $conversation, ChatMessage $message)
    {
        $user = $request->user();

        if ($message->conversation_id != $conversation->id) {
            abort(404);
        }
        if ($message->sender_id != $user->id) {
            abort(403);
        }

        // hard delete (atau gunakan soft delete jika model mendukung)
        $messageId = $message->id;
        $message->delete();

        // broadcast event so other participant removes message
        try {
            broadcast(new MessageDeleted($conversation->id, $messageId))->toOthers();
        } catch (\Throwable $e) {}

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
