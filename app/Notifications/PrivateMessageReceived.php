<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PrivateMessageReceived extends Notification
{
    use Queueable;

    protected $payload;

    public function __construct($message)
    {
        if (is_object($message) && isset($message->id)) {
            $this->payload = [
                'id' => $message->id,
                'conversation_id' => $message->conversation_id,
                'sender' => [
                    'id' => $message->sender->id ?? $message->sender_id,
                    'name' => $message->sender->name ?? null,
                ],
                'body' => $message->body,
                'created_at' => $message->created_at?->toIso8601String() ?? now()->toIso8601String(),
            ];
        } else {
            $this->payload = (array) $message;
            if (!isset($this->payload['created_at'])) {
                $this->payload['created_at'] = now()->toIso8601String();
            }
        }
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'private_message',
            'message' => $this->payload,
            'text' => $this->payload['body'] ? \Illuminate\Support\Str::limit($this->payload['body'], 180) : 'Gambar',
            'sender_id' => $this->payload['sender']['id'] ?? null,
            'conversation_id' => $this->payload['conversation_id'] ?? null,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => $this->toDatabase($notifiable),
        ]);
    }
}
