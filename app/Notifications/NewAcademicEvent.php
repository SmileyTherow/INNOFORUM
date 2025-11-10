<?php

namespace App\Notifications;

use App\Models\AcademicEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAcademicEvent extends Notification
{
    use Queueable;

    public $event;

    public function __construct(AcademicEvent $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database']; // Bisa tambahkan 'broadcast', 'mail' jika mau
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'calendar_event',
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'start_date' => $this->event->start_date,
            'color' => $this->event->color,
        ];
    }
}