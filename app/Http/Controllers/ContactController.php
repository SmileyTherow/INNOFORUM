<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'title'   => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Simpan ke database (messages)
        $message = Message::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'title'   => $validated['title'],
            'body'    => $validated['message'],
            'is_read' => false,
            'status'  => 'open',
        ]);

        // Kirim email ke admin
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

    public function guestSend(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'context'   => 'required|string|max:100',
            'reference' => 'nullable|string|max:120',
            'message'   => 'required|string|max:2000',
        ]);

        // Simpan pesan sebagai guest (user_id = null)
        $message = Message::create([
            'user_id'   => null,
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'title'     => $validated['context'],
            'body'      => $validated['message'],
            'is_read'   => false,
            'status'    => 'open',
            'reference' => $validated['reference'] ?? null,
        ]);

        // Kirim email ke admin tentang pesan guest
        Mail::send('emails.contact', [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'title' => '[Guest] ' . $validated['context'] . ($validated['reference'] ? ' - ' . $validated['reference'] : ''),
            'pesan' => $validated['message'],
        ], function($mail) use ($validated) {
            $mail->to('fortech.forumteknologi@gmail.com')
                ->subject('[INNOFORUM Guest] ' . $validated['context'])
                ->replyTo($validated['email'], $validated['name']);
        });

        // Kembali dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah dikirim. Admin akan menghubungi melalui email.');
    }
}
