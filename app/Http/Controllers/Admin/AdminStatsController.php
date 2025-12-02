<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Question;
use App\Models\Category;
use App\Models\Comment;
use Carbon\Carbon;

class AdminStatsController extends Controller
{
    public function index()
    {
        // Data statistik
        $monthsQuery = collect(range(0, 11))->map(fn($i) => now()->subMonths($i)->format('Y-m'))->reverse()->values();
        $monthsLabel = collect(range(0, 11))->map(fn($i) => now()->subMonths($i)->isoFormat('MMM Y'))->reverse()->values();

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

        $topCategories = Category::withCount('questions')
            ->orderByDesc('questions_count')
            ->take(5)
            ->get();

        // Data Pie/Donut Chart
        $threadsPerCategory = Category::withCount('questions')->get();
        $categoryNames = $threadsPerCategory->pluck('name');
        $threadCounts  = $threadsPerCategory->pluck('questions_count');

        return view('admin.stats.index', compact(
            'monthsLabel',
            'usersPerMonth',
            'threadsPerMonth',
            'commentsPerMonth',
            'topCategories',
            'categoryNames',
            'threadCounts'
        ));
    }
}
