<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $conversationId;
    public $messageId;

    public function __construct($conversationId, $messageId)
    {
        $this->conversationId = $conversationId; // simpan ID percakapan
        $this->messageId = $messageId; // simpan ID pesan yg di hapus
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->conversationId);
    }

    public function broadcastWith()
    {
        return [
            'action' => 'deleted',
            'message_id' => $this->messageId,
        ];
    }
}
