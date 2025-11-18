<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Notification;
use App\Services\AdminActivityLogger;

class AdminCommentController extends Controller
{
    public function latest() { return view('admin.comments.latest'); }

    public function index()
    {
        // Ambil komentar beserta relasi user + pertanyaannya
        $comments = Comment::with(['question', 'user'])->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function notify(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'message' => 'required|string|max:500'
        ]);

        // Ambil komentar berdasarkan ID
        $comment = Comment::find($request->comment_id);
        $user = $comment->user;

        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        // siapkan link langsung ke comment di thread
        $threadId = $comment->question_id ?? ($comment->question->id ?? null);
        $link = null;
        try {
            if ($threadId) {
                $link = route('questions.show', $threadId) . '#comment-' . $comment->id;
            }
        } catch (\Exception $e) {
            $link = null;
        }

        // Buat notifikasi untuk user
        Notification::create([
            'user_id' => $user->id,
            'type' => 'admin_report',
            'data' => [
                'comment_id' => $comment->id,
                'thread_id' => $threadId,
                'message' => $request->message,
                'from_admin' => true,
                'link' => $link,
            ],
            'is_read' => false,
        ]);

        // log admin activity
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'admin_warn_comment',
                "Memberi peringatan pada komentar #{$comment->id}: \"" . \Illuminate\Support\Str::limit($request->message, 150) . "\"",
                ['type' => 'Comment', 'id' => $comment->id],
                ['warning' => \Illuminate\Support\Str::limit($request->message, 150)]
            );
        }

        return back()->with('success', 'Pesan notifikasi berhasil dikirim!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        // Log activity if admin removed it
        if (Auth::check() && Auth::user()->role === 'admin') {

            // Simpan log aktivitas admin
            AdminActivityLogger::log(
                'delete_comment',
                "Menghapus komentar #{$id}",
                ['type' => 'Comment','id' => $id],
                []
            );
        }

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    public function reported()
    {
        // Ambil komentar yang memiliki laporan
        $reportedComments = Comment::with(['user', 'reports', 'question'])
            ->whereHas('reports')
            ->paginate(20);

        return view('admin.comments.reported', compact('reportedComments'));
    }
}
