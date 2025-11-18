<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    // Menyimpan instance pesan yang di-update
    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message; // Simpan pesan yang telah di-update
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'action' => 'updated',
            // Data pesan yang diperbarui
            'message' => [
                'id' => $this->message->id,
                'conversation_id' => $this->message->conversation_id,
                // Informasi pengirim
                'sender' => [
                    'id' => $this->message->sender->id ?? $this->message->sender_id,
                    'name' => $this->message->sender->name ?? null,
                ],
                // Isi pesan yang sudah di-update
                'body' => $this->message->body,
                'attachment' => $this->message->attachment ? asset('storage/' . $this->message->attachment) : null,
                'attachment_type' => $this->message->attachment_type,
                'created_at' => $this->message->created_at?->toIso8601String(),
            ],
        ];
    }
}
