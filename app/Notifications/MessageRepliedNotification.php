<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\MessageReply;

class MessageRepliedNotification extends Notification
{
    use Queueable;

    protected $reply;

    public function __construct(MessageReply $reply)
    {
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        // kirim ke database (in-app) dan email
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => $this->reply->message_id,
            'reply_id' => $this->reply->id,
            'excerpt' => substr($this->reply->body, 0, 200),
            'admin_id' => $this->reply->user_id,
        ];
    }

    public function toMail($notifiable)
    {
        $message = $this->reply->message;
        return (new MailMessage)
            ->subject('[INNOFORUM] Balasan terhadap pesan Anda: ' . $message->title)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Admin telah membalas pesan Anda:')
            ->line($this->reply->body)
            ->action('Lihat Pesan', url(route('admin.messages.show', $message->id)))
            ->line('Terima kasih telah menggunakan INNOFORUM!');
    }
}
