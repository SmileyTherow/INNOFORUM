<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'all');

        if ($periode === 'week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        } elseif ($periode === 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } else {
            $start = null;
            $end = null;
        }

        $perPage = 10;
        $page = (int) $request->get('page', 1);

        if ($periode === 'all') {
            // Hanya user dengan points > 0 (urutan menurun), paginated otomatis
            $users = User::with(['comments', 'questions'])
                ->where('points', '>', 0)
                ->orderByDesc('points')
                ->paginate($perPage);
        } else {
            // Ambil semua user, hitung point pada periode, filter yg > 0, urut, lalu paginate manual
            $userCollection = User::with(['comments', 'questions'])
                ->get()
                ->map(function ($user) use ($start, $end) {
                    $user->comments_in_period = $user->comments
                        ->whereBetween('created_at', [$start, $end])
                        ->count();
                    $user->questions_in_period = $user->questions
                        ->whereBetween('created_at', [$start, $end])
                        ->count();
                    $user->like_count_in_period = $user->comments
                        ->whereBetween('created_at', [$start, $end])
                        ->sum(fn($c) => $c->likes->count());
                    
                    // hitung point periode
                    $user->period_points = $user->comments_in_period + $user->questions_in_period + $user->like_count_in_period;
                    return $user;
                })
                ->filter(fn($user) => $user->period_points > 0) // hanya user dengan point > 0 di periode
                ->sortByDesc('period_points')
                ->values();

            $users = new LengthAwarePaginator(
                $userCollection->forPage($page, $perPage),
                $userCollection->count(),
                $perPage,
                $page,
                ['path' => url()->current(), 'query' => $request->query()]
            );
        }

        return view('leaderboard', [
            'users' => $users,
            'periode' => $periode
        ]);
    }
}