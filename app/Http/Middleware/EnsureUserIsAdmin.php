<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * Memeriksa beberapa kemungkinan struktur role tanpa memanggil method yang tidak ada.
     * - Jika users.role adalah string: cek 'admin'
     * - Jika users.role adalah relasi object (Role model): cek ->name == 'admin'
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized (admin only)'], 403);
            }
            abort(403, 'Unauthorized (admin only).');
        }

        // 1) Jika users.role adalah string (mis. 'admin', 'mahasiswa', 'dosen')
        if (isset($user->role) && is_string($user->role)) {
            if (strtolower($user->role) === 'admin') {
                return $next($request);
            }
        }

        // 2) Jika users.role adalah relasi (object) dengan property 'name'
        if (isset($user->role) && is_object($user->role) && isset($user->role->name)) {
            if (strtolower($user->role->name) === 'admin') {
                return $next($request);
            }
        }

        // Tidak memenuhi syarat => tolak
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized (admin only)'], 403);
        }
        abort(403, 'Unauthorized (admin only).');
    }
}
