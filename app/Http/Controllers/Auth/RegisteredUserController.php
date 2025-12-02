<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6','confirmed'],
        ]);

        // buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Simpan id user ke session supaya OtpController bisa menemukan user saat verifikasi
        session(['register_user_id' => $user->id]);

        // Kirim OTP sesuai mekanisme project (email/SMS)
        return redirect()->route('register.verify-otp', ['email' => $user->email])->with('success','Akun dibuat. Cek email untuk kode OTP.');
    }
}
