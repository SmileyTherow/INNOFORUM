<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDosenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['mahasiswa', 'dosen'])) {
            return $next($request);
        }

        // Jika bukan mahasiswa atau dosen, redirect ke halaman utama
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}