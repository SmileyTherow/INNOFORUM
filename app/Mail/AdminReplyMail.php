<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\MessageReply;

class AdminReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageModel;
    public $reply;

    public function __construct(Message $messageModel, MessageReply $reply)
    {
        $this->messageModel = $messageModel;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('[INNOFORUM] Balasan: ' . $this->messageModel->title)
                    ->view('emails.admin_reply')
                    ->with([
                        'message' => $this->messageModel,
                        'reply' => $this->reply,
                    ]);
    }
}
