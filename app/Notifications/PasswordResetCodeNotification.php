<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;
    protected $ttlMinutes;

    public function __construct(string $code, int $ttlMinutes = 10)
    {
        $this->code = $code;
        $this->ttlMinutes = $ttlMinutes;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('🔐 Kode Reset Password - ' . config('app.name','Aplikasi kami' ))
        ->view ('emails.password-reset', [
            'code' => $this->code,
            'ttlMinutes' => $this->ttlMinutes
        ]);
}
}
