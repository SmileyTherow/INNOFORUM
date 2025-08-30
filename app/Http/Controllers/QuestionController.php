<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function __construct()
    {
        // Hanya mahasiswa/dosen yang boleh buat, edit, hapus, like, dsb
        $this->middleware(function ($request, $next) {
            $allowed = ['mahasiswa', 'dosen'];
            // Cek hanya untuk route tertentu (tidak semua)
            $restrict = ['create', 'store', 'edit', 'update', 'destroy', 'like'];
            if (in_array($request->route()->getActionMethod(), $restrict)) {
                if (!in_array(Auth::user()->role ?? '', $allowed)) {
                    abort(403, 'Akses khusus mahasiswa/dosen.');
                }
            }
            return $next($request);
        })->except(['index', 'show', 'search', 'byHashtag', 'byTag', 'byUser']);
    }

    public function index(Request $request)
    {
        $sort = $request->query('sort', 'recent');
        $query = Question::with(['user', 'hashtags', 'comments', 'likes']);

        switch ($sort) {
            case 'most_answered':
                $query->withCount('comments')->orderByDesc('comments_count');
                break;
            case 'unanswered':
                $query->doesntHave('comments')->latest();
                break;
            default:
                $query->latest();
                break;
        }

        $questions = $query->paginate(10)->appends(['sort' => $sort]);
        $hashtags = Hashtag::orderBy('name')->get();

        // Statistik & sidebar
        $stat = [
            'total_questions' => \App\Models\Question::count(),
            'total_comments'  => \App\Models\Comment::count(),
            'total_users'     => \App\Models\User::count(),
            'total_likes'     => DB::table('question_likes')->count(),
        ];
        $top_users = \App\Models\User::withCount('questions')
            ->orderByDesc('questions_count')->take(5)->get();
        $top_liked_users = \App\Models\User::with(['questions' => function($q) {
                $q->withCount('likes');
            }])->get()
            ->sortByDesc(function($user) {
                return $user->questions->sum('likes_count');
            })->take(5);

        return view('questions.index', compact(
            'questions', 'sort', 'hashtags',
            'stat', 'top_users', 'top_liked_users'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $questions = Question::with(['user', 'hashtags', 'comments', 'likes'])
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['q' => $keyword]);

        $hashtags = Hashtag::orderBy('name')->get();

        $stat = [
            'total_questions' => \App\Models\Question::count(),
            'total_comments'  => \App\Models\Comment::count(),
            'total_users'     => \App\Models\User::count(),
            'total_likes'     => DB::table('question_likes')->count(),
        ];
        $top_users = \App\Models\User::withCount('questions')
            ->orderByDesc('questions_count')->take(5)->get();
        $top_liked_users = \App\Models\User::with(['questions' => function($q) {
                $q->withCount('likes');
            }])->get()
            ->sortByDesc(function($user) {
                return $user->questions->sum('likes_count');
            })->take(5);

        // sort = search untuk highlight tab pencarian
        return view('questions.index', compact(
            'questions', 'hashtags', 'stat', 'top_users', 'top_liked_users', 'keyword'
        ))->with('sort', 'search');
    }

    public function create()
    {
        $hashtags = Hashtag::orderBy('name')->get();
        return view('questions.create', compact('hashtags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'hashtags' => 'nullable|array',
            'hashtags.*' => 'exists:hashtags,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Proses upload gambar
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $filename = 'question_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->storeAs('public/question_images', $filename);
                $imagePaths[] = $filename;
            }
        }

        $question = Question::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'images' => $imagePaths,
        ]);
        $question->hashtags()->sync($request->hashtags ?? []);
        return redirect()->route('dashboard')->with('success', 'Thread berhasil dibuat.');return redirect()->route('dashboard')->with('success', 'Thread berhasil dihapus.');

    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'hashtags' => 'nullable|array',
            'hashtags.*' => 'exists:hashtags,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array'
        ]);

        $imagePaths = $question->images ?? [];
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $img) {
                $idx = array_search($img, $imagePaths);
                if ($idx !== false) {
                    if (Storage::exists('public/question_images/' . $img)) {
                        Storage::delete('public/question_images/' . $img);
                    }
                    unset($imagePaths[$idx]);
                }
            }
            $imagePaths = array_values($imagePaths);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $filename = 'question_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                $img->storeAs('public/question_images', $filename);
                $imagePaths[] = $filename;
            }
        }

        $question->update([
            'title' => $request->title,
            'content' => $request->content,
            'images' => $imagePaths,
        ]);
        $question->hashtags()->sync($request->hashtags ?? []);

        return redirect()->route('questions.show', $question->id)->with('success', 'Thread berhasil diupdate.');
    }

    public function show($id)
    {
        $question = Question::with(['user', 'comments.user', 'hashtags', 'likes'])->findOrFail($id);
        $hashtags = Hashtag::orderBy('name')->get();
        return view('questions.show', compact('question', 'hashtags'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }
        $hashtags = Hashtag::orderBy('name')->get();
        $selectedHashtags = $question->hashtags->pluck('id')->toArray();
        return view('questions.edit', compact('question', 'hashtags', 'selectedHashtags'));
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }
        if ($question->images) {
            foreach ($question->images as $img) {
                if (Storage::exists('public/question_images/' . $img)) {
                    Storage::delete('public/question_images/' . $img);
                }
            }
        }
        $question->hashtags()->detach();
        $question->delete();

        return redirect()->route('dashboard')->with('success', 'Thread berhasil dihapus.');
    }

    public function byHashtag($id)
    {
        $hashtag = Hashtag::findOrFail($id);
        $questions = $hashtag->questions()->with(['user', 'hashtags', 'comments', 'likes'])->latest()->paginate(10);
        $hashtags = Hashtag::orderBy('name')->get();
        $sort = 'hashtag';

        $stat = [
            'total_questions' => \App\Models\Question::count(),
            'total_comments'  => \App\Models\Comment::count(),
            'total_users'     => \App\Models\User::count(),
            'total_likes'     => DB::table('question_likes')->count(),
        ];
        $top_users = \App\Models\User::withCount('questions')
            ->orderByDesc('questions_count')->take(5)->get();
        $top_liked_users = \App\Models\User::with(['questions' => function($q) {
                $q->withCount('likes');
            }])->get()
            ->sortByDesc(function($user) {
                return $user->questions->sum('likes_count');
            })->take(5);

        return view('questions.index', compact(
            'questions', 'sort', 'hashtags', 'hashtag', 'stat', 'top_users', 'top_liked_users'
        ));
    }

    public function like($id)
    {
        $question = Question::findOrFail($id);
        $user = Auth::user();

        if ($question->likes()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Kamu sudah like thread ini.');
        }

        $question->likes()->attach($user->id);
        if ($question->user_id !== $user->id) {
            \App\Models\Notification::create([
                'user_id' => $question->user_id,
                'type' => 'like',
                'data' => [
                    'question_id' => $question->id,
                    'by_user_id' => $user->id,
                    'message' => $user->name . ' menyukai pertanyaanmu'
                ]
            ]);
        }

        return back()->with('success', 'Thread berhasil di-like.');
    }

    public function byTag($name)
    {
        $hashtag = Hashtag::where('name', $name)->firstOrFail();
        $questions = $hashtag->questions()->with(['user', 'hashtags', 'comments', 'likes'])->latest()->paginate(10);

        $hashtags = Hashtag::orderBy('name')->get();
        $sort = 'byTag';
        $filter_info = "Tag: #$name";

        $stat = [
            'total_questions' => Question::count(),
            'total_comments'  => \App\Models\Comment::count(),
            'total_users'     => \App\Models\User::count(),
            'total_likes'     => DB::table('question_likes')->count(),
        ];
        $top_users = \App\Models\User::withCount('questions')
            ->orderByDesc('questions_count')->take(5)->get();
        $top_liked_users = \App\Models\User::with(['questions' => function($q) {
                $q->withCount('likes');
            }])->get()
            ->sortByDesc(function($user) {
                return $user->questions->sum('likes_count');
            })->take(5);

        return view('questions.index', compact(
            'questions', 'sort', 'hashtags', 'stat',
            'top_users', 'top_liked_users', 'filter_info'
        ));
    }

    public function byUser($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        $questions = $user->questions()->with(['user', 'hashtags', 'comments', 'likes'])->latest()->paginate(10);

        $hashtags = Hashtag::orderBy('name')->get();
        $sort = 'byUser';
        $filter_info = "User: $user->name";

        $stat = [
            'total_questions' => Question::count(),
            'total_comments'  => \App\Models\Comment::count(),
            'total_users'     => \App\Models\User::count(),
            'total_likes'     => DB::table('question_likes')->count(),
        ];
        $top_users = \App\Models\User::withCount('questions')
            ->orderByDesc('questions_count')->take(5)->get();
        $top_liked_users = \App\Models\User::with(['questions' => function($q) {
                $q->withCount('likes');
            }])->get()
            ->sortByDesc(function($user) {
                return $user->questions->sum('likes_count');
            })->take(5);

        return view('questions.index', compact(
            'questions', 'sort', 'hashtags', 'stat',
            'top_users', 'top_liked_users', 'filter_info'
        ));
    }
}
