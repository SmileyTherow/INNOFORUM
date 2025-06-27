<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Password Anda')
                    ->view('emails.password_confirmation')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                    ]);
    }
}