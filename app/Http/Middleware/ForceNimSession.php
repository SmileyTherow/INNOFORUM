<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceNimSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('validated_nim')) {
            return redirect()->route('nim.form')->with('error', 'Silakan validasi NIM/NIGM terlebih dahulu.');
        }
        return $next($request);
    }
}