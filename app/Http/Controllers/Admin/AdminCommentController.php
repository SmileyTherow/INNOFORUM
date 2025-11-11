<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Notification;

class AdminCommentController extends Controller
{
    public function latest()
    {
        return view('admin.comments.latest');
    }

    public function index()
    {
        $comments = \App\Models\Comment::with(['question', 'user'])->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function notify(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'message' => 'required|string|max:500'
        ]);

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

        return back()->with('success', 'Pesan notifikasi berhasil dikirim!');
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    public function reported()
    {
        $reportedComments = \App\Models\Comment::with(['user', 'reports', 'question'])
            ->whereHas('reports')
            ->paginate(20);

        return view('admin.comments.reported', compact('reportedComments'));
    }
}
