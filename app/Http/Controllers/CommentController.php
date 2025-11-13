<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\AdminActivityLogger;

class CommentController extends Controller
{
    public function __construct()
    {
        // Hanya mahasiswa/dosen yang boleh komentar & like
        $this->middleware(function ($request, $next) {
            $allowed = ['mahasiswa', 'dosen'];
            $restrict = ['store', 'like', 'destroy', 'edit', 'update'];
            if (in_array($request->route()->getActionMethod(), $restrict)) {
                if (!in_array(Auth::user()->role ?? '', $allowed)) {
                    abort(403, 'Akses khusus mahasiswa/dosen.');
                }
            }
            return $next($request);
        });
    }

    // Store comment (dengan upload gambar & mention)
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reply_to_comment_id' => 'nullable|integer|exists:comments,id'
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $filename = 'comment_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->storeAs('public/comment_images', $filename);
        }

        $comment = Comment::create([
            'question_id' => $request->question_id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'image' => $filename,
        ]);

        // pastikan relations tersedia
        $comment->load('question', 'user');

        // notifikasi ke owner question (jika commenter bukan owner)
        $question = $comment->question;
        if ($question && $question->user_id && $question->user_id != $comment->user_id) {
            \App\Models\Notification::create([
                'user_id' => $question->user_id,
                'type' => 'comment_posted',
                'data' => [
                    'thread_id' => $comment->question_id,
                    'comment_id' => $comment->id,
                    'message' => 'Ada komentar baru: ' . Str::limit($comment->content, 150),
                    'from_user_id' => $comment->user_id,
                    'link' => route('questions.show', $comment->question_id) . '#comment-' . $comment->id,
                ],
                'is_read' => false,
            ]);
        }

        // jika ini balasan ke comment tertentu dan pemilik komentar berbeda, notifikasi ke pemilik komentar
        $replyToId = $request->input('reply_to_comment_id') ?? null;
        if ($replyToId) {
            $parentComment = Comment::find($replyToId);
            if ($parentComment && $parentComment->user_id && $parentComment->user_id != $comment->user_id) {
                \App\Models\Notification::create([
                    'user_id' => $parentComment->user_id,
                    'type' => 'comment_reply',
                    'data' => [
                        'thread_id' => $comment->question_id,
                        'comment_id' => $comment->id,
                        'message' => 'Balasan untuk komentar Anda: ' . Str::limit($comment->content, 150),
                        'from_user_id' => $comment->user_id,
                        'link' => route('questions.show', $comment->question_id) . '#comment-' . $comment->id,
                    ],
                    'is_read' => false,
                ]);
            }
        }

        // Log jika admin yang membuat komentar
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'admin_comment',
                "Membuat komentar pada pertanyaan #{$comment->question_id}: \"" . Str::limit($comment->content,150) . "\"",
                ['type'=>'Question','id'=>$comment->question_id],
                ['comment_id' => $comment->id]
            );
        }

        // === Penambahan Poin dan Badge (tetap seperti sebelumnya) ===
        $user = \App\Models\User::find(Auth::id());
        if ($user) {
            $user->increment('points', 5); // Tambah 5 poin untuk komentar

            if ($user->comments()->count() >= 50) {
                $badge = \App\Models\Badge::where('name', 'Active Commenter')->first();
                if ($badge && !$user->badges->contains($badge->id)) {
                    $user->badges()->attach($badge->id, ['awarded_at' => now()]);
                }
            }

            $likeCount = $user->comments()->withCount('likes')->get()->sum('likes_count');
            if ($likeCount >= 100) {
                $badge = \App\Models\Badge::where('name', 'Top Contributor')->first();
                if ($badge && !$user->badges->contains($badge->id)) {
                    $user->badges()->attach($badge->id, ['awarded_at' => now()]);
                }
            }
        }

        // === NOTIFIKASI MENTION ===
        preg_match_all('/@([a-zA-Z0-9_]+)/', $request->input('content'), $matches);
        $usernames = $matches[1] ?? [];
        foreach ($usernames as $username) {
            $mentionedUser = \App\Models\User::where('username', $username)->first();
            if ($mentionedUser && $mentionedUser->id !== Auth::id()) {
                \App\Models\Notification::create([
                    'user_id' => $mentionedUser->id,
                    'type' => 'mention',
                    'data' => [
                        'comment_id' => $comment->id,
                        'question_id' => $comment->question_id,
                        'by_user_id' => Auth::id(),
                        'by_name' => Auth::user()->name,
                        'message' => Auth::user()->name . ' mention kamu di komentar',
                        'link' => route('questions.show', $comment->question_id) . '#comment-' . $comment->id,
                    ],
                    'is_read' => false,
                ]);
            }
        }

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    // Like comment
    public function like($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();

        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Kamu sudah like komentar ini.');
        }

        $comment->likes()->attach($user->id);

        // Notifikasi ke author komentar jika bukan dirinya sendiri
        if ($comment->user_id !== $user->id) {
            \App\Models\Notification::create([
                'user_id' => $comment->user_id,
                'type' => 'comment_like',
                'data' => [
                    'comment_id' => $comment->id,
                    'by_user_id' => $user->id,
                    'message' => $user->name . ' menyukai komentarmu'
                ]
            ]);
        }

        return back()->with('success', 'Komentar berhasil di-like.');
    }

    // Edit comment
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }
        return view('comments.edit', compact('comment'));
    }

    // Update comment
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Optional: handle image update
        if ($request->hasFile('image')) {
            // delete old image
            if ($comment->image && Storage::exists('public/comment_images/' . $comment->image)) {
                Storage::delete('public/comment_images/' . $comment->image);
            }
            $img = $request->file('image');
            $filename = 'comment_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->storeAs('public/comment_images', $filename);
            $comment->image = $filename;
        }

        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('questions.show', $comment->question_id)->with('success', 'Komentar berhasil diupdate.');
    }

    // Hapus comment beserta gambar jika ada
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($comment->image && Storage::exists('public/comment_images/' . $comment->image)) {
            Storage::delete('public/comment_images/' . $comment->image);
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function index(Request $request)
    {
        $query = Comment::with(['user', 'question'])
            ->latest();

        // Fitur pencarian
        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', '%'.$search.'%')
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('question', function($q) use ($search) {
                    $q->where('title', 'like', '%'.$search.'%')
                        ->orWhere('content', 'like', '%'.$search.'%');
                });
            });
        }

        $comments = $query->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }
}
