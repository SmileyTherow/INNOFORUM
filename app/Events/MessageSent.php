<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     // Menyimpan instance pesan yang dikirim
    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message; // Simpan pesan agar bisa dibroadcast
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id, // ID pesan
            'conversation_id' => $this->message->conversation_id, // ID percakapan

            // informasi pengirim
            'sender' => [
                'id' => $this->message->sender->id ?? $this->message->sender_id,
                'name' => $this->message->sender->name ?? null,
            ],

            // isi pesan
            'body' => $this->message->body,
            'attachment' => $this->message->attachment ? asset('storage/' . $this->message->attachment) : null,
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}
