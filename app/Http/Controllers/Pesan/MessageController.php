<?php

namespace App\Http\Controllers\Pesan;

use App\Events\MessageSent;
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
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'] ?? null,
            'attachment' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        // update last_message_at
        $conversation->update(['last_message_at' => $message->created_at]);

        // load relations
        $message->load('sender');

        // Broadcast event to conversation channel
        broadcast(new MessageSent($message))->toOthers();

        // Notify recipient (database + broadcast via Notification)
        $recipient = $conversation->users()->where('users.id', '<>', $user->id)->first();
        if ($recipient) {
            $recipient->notify(new PrivateMessageReceived($message));
        }

        // Prepare payload with ISO8601 timestamps for JS compatibility
        $payload = [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'sender' => [
                'id' => $message->sender->id,
                'name' => $message->sender->name,
                'avatar' => $message->sender->avatar ? asset('storage/'.$message->sender->avatar) : null,
            ],
            'body' => $message->body,
            'attachment' => $message->attachment ? asset('storage/'.$message->attachment) : null,
            'attachment_type' => $message->attachment_type,
            'created_at' => $message->created_at?->toIso8601String(),
        ];

        return response()->json(['message' => $payload], 201);
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