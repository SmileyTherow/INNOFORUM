<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyMail;
use App\Notifications\MessageRepliedNotification;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::with('replies.author')->findOrFail($id);

        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $message = Message::findOrFail($id);

        $reply = MessageReply::create([
            'message_id' => $message->id,
            'user_id'    => Auth::id(),
            'body'       => $request->body,
            'via_email'  => true,
        ]);

        // kirim email ke pengirim
        Mail::to($message->email)->send(new AdminReplyMail($message, $reply));

        // notifikasi in-app jika ada user terdaftar
        if ($message->user) {
            $message->user->notify(new MessageRepliedNotification($reply));
        }

        return redirect()->route('admin.messages.show', $message->id)
            ->with('success', 'Balasan terkirim dan notifikasi dikirim ke pengguna.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete(); // soft delete
        return redirect()->route('admin.messages.index')->with('success', 'Pesan dihapus.');
    }
}
