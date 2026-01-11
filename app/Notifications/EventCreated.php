<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\AcademicEvent;
use Illuminate\Notifications\Messages\DatabaseMessage;

class EventCreated extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(AcademicEvent $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Acara Baru: ' . $this->event->title,
            'message' => "Acara \"{$this->event->title}\" akan berlangsung pada {$this->event->start_date->toDateString()}" . ($this->event->end_date ? " s/d {$this->event->end_date->toDateString()}" : ''),
            'event_id' => $this->event->id,
            'color' => $this->event->color,
            'start_date' => $this->event->start_date?->toDateString(),
            'end_date' => $this->event->end_date?->toDateString(),
            'url' => route('calendar.event.show', $this->event->id)
        ];
    }
}
