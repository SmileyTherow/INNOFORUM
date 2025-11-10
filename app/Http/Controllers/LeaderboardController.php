<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'all'); // default: all time

        // Ambil awal & akhir periode
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

        // Query user dengan count periode
        $users = User::with(['comments', 'questions'])
            ->withCount([
                'comments as comments_in_period' => function ($q) use ($start, $end) {
                    if ($start && $end) $q->whereBetween('created_at', [$start, $end]);
                },
                'questions as questions_in_period' => function ($q) use ($start, $end) {
                    if ($start && $end) $q->whereBetween('created_at', [$start, $end]);
                },
            ])
            ->get()
            ->map(function ($user) use ($start, $end) {
                // Like hanya dari komentar dalam periode
                $user->like_count_in_period = $user->comments
                    ->filter(function($c) use ($start, $end) {
                        if ($start && $end) return $c->created_at >= $start && $c->created_at <= $end;
                        return true;
                    })
                    ->sum(fn($c) => $c->likes->count());
                $user->join_date = $user->created_at->translatedFormat('M Y');
                return $user;
            });

        // Urutkan sesuai periode
        $users = $users->sortByDesc(function($user) use ($periode) {
            if ($periode === 'week' || $periode === 'month') {
                return $user->comments_in_period + $user->questions_in_period + $user->like_count_in_period;
            } else {
                return $user->points;
            }
        })->values();

        return view('leaderboard', [
            'topUsers' => $users,
            'periode' => $periode
        ]);
    }
}
