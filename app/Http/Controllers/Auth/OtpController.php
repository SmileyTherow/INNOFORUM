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
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        // Contoh validasi OTP (sesuaikan dengan logika Anda)
        if ($request->otp !== session('otp_code')) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Bersihkan session OTP
        session()->forget('otp_code');

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Verifikasi OTP berhasil!');
    }
}