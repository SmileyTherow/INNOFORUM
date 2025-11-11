<?php

namespace App\Services;

use App\Models\AdminActivity;
use Illuminate\Support\Facades\Auth;

class AdminActivityLogger
{
    /**
     * Log aktivitas admin cepat.
     *
     * @param  string       $action
     * @param  string|null  $description
     * @param  array|null   $subject    // ['type' => 'Comment', 'id' => 12] atau null
     * @param  array        $metadata
     * @param  \App\Models\User|null $admin
     * @return \App\Models\AdminActivity|null
     */
    public static function log(string $action, ?string $description = null, ?array $subject = null, array $metadata = [], $admin = null)
    {
        $user = $admin ?? Auth::user();
        if (!$user) {
            // jika tidak ada admin terautentikasi, kita tidak log
            return null;
        }

        // hanya log jika user role admin
        if (!isset($user->role) || $user->role !== 'admin') {
            return null;
        }

        $subjectType = $subject['type'] ?? null;
        $subjectId = $subject['id'] ?? null;

        $activity = AdminActivity::create([
            'admin_id' => $user->id,
            'admin_name' => $user->name ?? ($user->username ?? 'admin'),
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'metadata' => $metadata ?: null,
        ]);

        return $activity;
    }
}
