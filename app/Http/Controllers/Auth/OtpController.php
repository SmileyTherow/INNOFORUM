<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    /**
     * Menampilkan form OTP.
     */
    public function showForm()
    {
        return view('auth.otp');
    }

    /**
     * Memproses verifikasi OTP.
     * Tidak melakukan Auth::login() — user tetap belum login.
     * Setelah OTP valid, redirect ke halaman lengkapi profil (complete-profile).
     * Mengandalkan session('register_user_id') yang disimpan waktu registrasi.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        if ($request->otp !== session('otp_code')) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Bersihkan session OTP
        session()->forget('otp_code');

        // Pastikan kita punya id user yang sedang daftar
        $userId = session('register_user_id');

        if (!$userId) {
            // fallback: jika email dikirim di form, coba cari user berdasarkan email
            if ($request->filled('email')) {
                $user = \App\Models\User::where('email', $request->input('email'))->first();
                if ($user) {
                    session(['register_user_id' => $user->id]);
                    $userId = $user->id;
                }
            }
        }

        if (!$userId) {
            // Tidak ada info siapa yang mendaftar — arahkan ke register ulang
            return redirect()->route('register')->with('error', 'Proses verifikasi gagal — silakan daftar ulang.');
        }

        // Redirect ke halaman lengkapi profil (user belum login)
        return redirect()->route('profile.complete')->with('success', 'Verifikasi OTP berhasil — silakan lengkapi profil Anda (opsional).');
    }
}
