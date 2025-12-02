<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyPasswordCodeController extends Controller
{
    public function show()
    {
        return view('auth.passwords.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $email = strtolower($request->email);
        $inputCode = $request->code;

        $record = PasswordResetCode::where('email', $email)
            ->orderByDesc('created_at')
            ->first();

        if (! $record) {
            return back()->withErrors(['code' => __('passwords.invalid_or_expired')]);
        }

        if ($record->isLocked()) {
            return back()->withErrors(['code' => __('passwords.too_many_attempts_locked', ['minutes' => $record->locked_until->diffInMinutes(now())])]);
        }

        // Cek kadaluarsa
        if ($record->isExpired()) {
            return back()->withErrors(['code' => __('passwords.invalid_or_expired')]);
        }

        // Verifikasi kode yang di-hash
        if (! Hash::check($inputCode, $record->token_hash)) {
            $record->attempts = $record->attempts + 1;
            if ($record->attempts >= 3) {
                // kunci selama 15 menit
                $record->locked_until = now()->addMinutes(15);
            }
            $record->save();

            return back()->withErrors(['code' => __('passwords.invalid_or_expired')]);
        }

        // success — tandai session dan izinkan reset
        session([
            'password_reset_verified' => true,
            'password_reset_email' => $email,
            'password_reset_id' => $record->id,
            'password_reset_verified_at' => now()->toDateTimeString(),
        ]);

        return redirect()->route('password.reset.form')->with('status', __('passwords.code_verified'));
    }
}
