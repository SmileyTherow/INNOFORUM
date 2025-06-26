<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'title'   => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Mail::send('emails.contact', [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'title'   => $validated['title'],
            'pesan'   => $validated['message'],
        ], function($mail) use ($validated) {
            $mail->to('fortech.forumteknologi@gmail.com')
                ->subject('[INNOFORUM] ' . $validated['title'])
                ->replyTo($validated['email'], $validated['name']);
        });

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}