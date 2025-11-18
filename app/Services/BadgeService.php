<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Badge;

class BadgeService
{
    // Hitung jumlah pertanyaan unik yang sudah dikomentari user
    public function computeAnswerPoints(int $userId): int
    {
        return (int) DB::table('comments')
            ->where('user_id', $userId)
            ->distinct('question_id')
            ->count('question_id');
    }

    // Hitung total like yang diterima user (questions + comments)
    // Sesuai keputusan: self-like dihitung
    public function computeLikePoints(int $userId): int
    {
        $questionLikes = (int) DB::table('question_likes')
            ->join('questions', 'questions.id', '=', 'question_likes.question_id')
            ->where('questions.user_id', $userId)
            ->count();

        $commentLikes = (int) DB::table('comment_likes')
            ->join('comments', 'comments.id', '=', 'comment_likes.comment_id')
            ->where('comments.user_id', $userId)
            ->count();

        return $questionLikes + $commentLikes;
    }

    // kembalikan level: bronze|silver|gold|null
    public function determineBadgeLevel(int $count): ?string
    {
        if ($count >= 1000) return 'gold';
        if ($count >= 500) return 'silver';
        if ($count >= 100) return 'bronze';
        return null;
    }

    // untuk menyesuaikan nama file berdasarkan type dan level (image file naming)
    public function determineBadgeFilename(string $type, int $count): ?string
    {
        $level = $this->determineBadgeLevel($count);
        if (!$level) return null;

        // contoh nama file: like_bronze.jpg atau responder_bronze.jpg
        return "{$type}_{$level}.jpg";
    }

    /**
     * Update kolom users.answer_points, users.like_points, users.points
     * lalu sinkronisasi badge (attach/detach).
     *
     * Fungsi ini mendukung dua bentuk schema badges:
     *  - schema baru: badges memiliki kolom `type` dan `threshold` (dipakai untuk pemilihan badge)
     *  - schema lama: badges tidak punya kolom type/threshold; kita cari badge berdasarkan nama
     */
    public function updateUserPointsAndBadges(int $userId): array
    {
        $user = User::findOrFail($userId);

        $answerPoints = $this->computeAnswerPoints($userId);
        $likePoints = $this->computeLikePoints($userId);
        $totalPoints = $answerPoints + $likePoints;

        $user->answer_points = $answerPoints;
        $user->like_points = $likePoints;
        $user->points = $totalPoints; // preserve compatibility
        $user->save();

        // sinkron badge: jika tabel badges punya kolom 'type' dan 'threshold' pakai itu,
        // jika tidak, fallback ke pencocokan nama badge.
        if (Schema::hasColumn('badges', 'type') && Schema::hasColumn('badges', 'threshold')) {
            $this->syncBadgeForTypeWithThreshold($user, 'responder', $answerPoints);
            $this->syncBadgeForTypeWithThreshold($user, 'like', $likePoints);
        } else {
            // fallback: cari badge berdasarkan nama (Anda sudah punya kolom 'icon' di DB)
            $this->syncBadgeForTypeByName($user, 'responder', $answerPoints);
            $this->syncBadgeForTypeByName($user, 'like', $likePoints);
        }

        return [
            'answer_points' => $answerPoints,
            'like_points' => $likePoints,
            'total_points' => $totalPoints,
            'answer_badge' => $this->determineBadgeFilename('responder', $answerPoints),
            'like_badge' => $this->determineBadgeFilename('like', $likePoints),
        ];
    }

    // Jika tabel badges memiliki kolom type + threshold
    protected function syncBadgeForTypeWithThreshold(User $user, string $type, int $count)
    {
        $badge = Badge::where('type', $type)
            ->where('threshold', '<=', $count)
            ->orderByDesc('threshold')
            ->first();

        // detach semua badge type ini yang user punya
        $existing = $user->badges()->where('type', $type)->get();
        foreach ($existing as $b) {
            $user->badges()->detach($b->id);
        }

        if ($badge) {
            $user->badges()->attach($badge->id, ['awarded_at' => now()]);
        }
    }

    // Fallback: sinkron berdasarkan nama badge (untuk schema lama)
    // Nama badge yang dicari: untuk type 'like' => "Pencerah Bronze/Silver/Gold"
    //                         untuk type 'responder' => "Penjawab Bronze/Silver/Gold"
    protected function syncBadgeForTypeByName(User $user, string $type, int $count)
    {
        // tentukan level yang cocok sekarang
        $level = $this->determineBadgeLevel($count);

        // nama prefix untuk type
        $prefix = $type === 'like' ? 'Pencerah' : 'Penjawab';

        // detach semua badges yang cocok prefix ini dulu (downgrade/upgrade)
        $existing = $user->badges()->where('name', 'like', $prefix . '%')->get();
        foreach ($existing as $b) {
            $user->badges()->detach($b->id);
        }

        if (!$level) {
            // tidak ada badge yang harus dipasang
            return;
        }

        $badgeName = $prefix . ' ' . ucfirst($level); // ex: "Pencerah Bronze" atau "Penjawab Silver"
        $badge = Badge::where('name', $badgeName)->first();

        if ($badge) {
            $user->badges()->attach($badge->id, ['awarded_at' => now()]);
        }
    }
}
