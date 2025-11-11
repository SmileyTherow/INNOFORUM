<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Announcement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalThreads = Question::count();
        $totalCategories = Category::count();
        $totalComments = Comment::count();
        $totalAnnouncements = Announcement::count();

        // 12 bulan terakhir untuk query & label grafik
        $monthsQuery = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse()->values();

        $monthsLabel = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths($i)->isoFormat('MMM Y');
        })->reverse()->values();

        $usersPerMonth = $monthsQuery->map(function ($month) {
            return User::where('role', '!=', 'admin')
                ->whereBetween('created_at', [
                    Carbon::parse($month . '-01')->startOfMonth(),
                    Carbon::parse($month . '-01')->endOfMonth()
                ])->count();
        });

        $threadsPerMonth = $monthsQuery->map(function ($month) {
            return Question::whereBetween('created_at', [
                Carbon::parse($month . '-01')->startOfMonth(),
                Carbon::parse($month . '-01')->endOfMonth()
            ])->count();
        });

        $commentsPerMonth = $monthsQuery->map(function ($month) {
            return Comment::whereBetween('created_at', [
                Carbon::parse($month . '-01')->startOfMonth(),
                Carbon::parse($month . '-01')->endOfMonth()
            ])->count();
        });

        // Kategori thread teraktif (top 5)
        $topCategories = Category::withCount('questions')
            ->orderByDesc('questions_count')
            ->take(5)
            ->get();

        $usersQuery = User::where('role', '!=', 'admin');
        if ($request->filled('q')) {
            $q = $request->q;
            $usersQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }
        $users = $usersQuery->orderByDesc('created_at')->paginate(10);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalThreads',
            'totalCategories',
            'totalComments',
            'totalAnnouncements',
            'users',
            'monthsLabel',
            'usersPerMonth',
            'threadsPerMonth',
            'commentsPerMonth',
            'topCategories'
        ));
    }
}
