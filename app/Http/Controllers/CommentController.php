<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            'content' => $request->content,
            'image' => $filename,
        ]);

        // === NOTIFIKASI JAWABAN (untuk owner pertanyaan) ===
        $question = Question::find($request->question_id);
        if ($question && $question->user_id !== Auth::id()) {
            \App\Models\Notification::create([
                'user_id' => $question->user_id,
                'type' => 'answer',
                'data' => [
                    'question_id' => $question->id,
                    'by_user_id' => Auth::id(),
                    'comment_id' => $comment->id,
                    'message' => Auth::user()->name . ' menjawab pertanyaanmu'
                ]
            ]);
        }

        // === NOTIFIKASI MENTION ===
        preg_match_all('/@([a-zA-Z0-9_]+)/', $request->content, $matches);
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
                        'message' => Auth::user()->name . ' mention kamu di komentar'
                    ]
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

        $comment->content = $request->content;
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