<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminLoginController extends Controller
{
    /**
     * Tampilkan form OTP admin
     */
    public function showOtpForm()
    {
        return view('auth.otp_admin');
    }

    /**
     * Verifikasi OTP admin dari database (tabel users kolom otp_code)
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required'
        ]);

        // Cari user dengan role admin dan otp_code sesuai input
        $admin = User::where('role', 'admin')
            ->where('otp_code', $request->otp_code)
            ->first();

        if ($admin) {
            // Set session bahwa OTP sudah tervalidasi, lanjut ke login admin
            session(['otp_validated' => true]);
            return redirect()->route('login.admin');
        }

        return back()->with('error', 'OTP salah atau tidak valid');
    }

    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        if (!session('otp_validated')) {
            return redirect()->route('otp.admin');
        }
        return view('auth.login_admin');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user admin
        $user = User::where('username', $request->username)
                    ->where('role', 'admin')
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            // Hapus session otp_validated karena sudah login
            session()->forget('otp_validated');
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Auth::logout();
        session()->forget('otp_validated');
        return redirect('/');
    }
}