<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $categories = Category::withCount('questions')
            ->orderByDesc('questions_count')
            ->get();

        // Siapkan top 5 dan sisa kategori untuk partial
        $topCategories = $categories->take(5);
        $remainingCategories = $categories->slice(5);

        $selectedCategory = null;
        if ($categorySlug) {
            if (is_numeric($categorySlug)) {
                $selectedCategory = Category::find((int) $categorySlug);
            } else {
                if (Schema::hasColumn('categories', 'slug')) {
                    $selectedCategory = Category::where('slug', $categorySlug)->first();
                }
                if (!$selectedCategory) {
                    if (is_numeric($categorySlug)) {
                        $selectedCategory = Category::find((int) $categorySlug);
                    } else {
                        // tetap null jika tidak ditemukan
                        $selectedCategory = null;
                    }
                }
            }
        }

        // Ambil filter atau search jika ada
        $query = Question::with(['user', 'hashtags', 'category'])
            ->withCount(['comments', 'likes']);

        // (Opsional) filter berdasarkan tab/filter jika ada (terbaru, terbanyak, dsb)
        if ($request->filter === 'terbanyak') {
            $query->orderByDesc('comments_count');
        } elseif ($request->filter === 'baru-dijawab') {
            $query->whereHas('comments')->orderByDesc('updated_at');
        } elseif ($request->filter === 'belum-dijawab') {
            $query->doesntHave('comments')->orderByDesc('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        // Ambil top 5 user berdasarkan poin
        $topUsers = User::withCount(['comments', 'questions'])
            ->get()
            ->map(function ($user) {
                // Hitung total like komentar user
                $user->like_count = $user->comments->sum(function ($c) {
                    return $c->likes->count();
                });
                return $user;
            })
            ->sortByDesc('points')
            ->take(5);

        // search
        if ($request->has('search') && trim($request->search) !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%");
            });
        }

        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory->id);
        }

        // PAGINATE dan pertahankan query string
        $questions = $query->paginate(10)->appends($request->only(['filter','search','category']));

        // popular tags dummy
        $popularTags = ['laravel','tailwind','php','javascript','react','vue','css','html','mysql','api','auth','livewire'];

        // === Tambahkan: Ambil notifikasi terbaru (10) untuk user login ===
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->take(10)
                ->get();
            $global_notifications = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->orderByDesc('created_at')
                ->get();
        } else {
            $notifications = [];
            $global_notifications = [];
        }
        return view('dashboard', compact(
            'questions',
            'popularTags',
            'notifications',
            'global_notifications',
            'topUsers',
            'topCategories',
            'remainingCategories',
            'selectedCategory'
        ));
    }

    public function adminDashboard(Request $request)
    {
        return view('admin.dashboard');
    }
}
