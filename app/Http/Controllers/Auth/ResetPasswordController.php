<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function show(Request $request)
    {
        // Require prior verification
        if (! session('password_reset_verified') || ! session('password_reset_email')) {
            return redirect()->route('password.forgot')->withErrors(['email' => __('passwords.please_request')]);
        }

        $email = session('password_reset_email');

        return view('auth.passwords.reset', ['email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if (! session('password_reset_verified') || session('password_reset_email') !== strtolower($request->email)) {
            return redirect()->route('password.forgot')->withErrors(['email' => __('passwords.please_request')]);
        }

        $email = strtolower($request->email);
        $recordId = session('password_reset_id');

        $record = PasswordResetCode::where('id', $recordId)
            ->where('email', $email)
            ->first();

        if (! $record || $record->isExpired() || $record->isLocked()) {
            return redirect()->route('password.forgot')->withErrors(['email' => __('passwords.invalid_or_expired')]);
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            // Should not happen, but handle gracefully
            return redirect()->route('password.forgot')->withErrors(['email' => __('passwords.invalid_or_expired')]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // remove all reset records for this email
        PasswordResetCode::where('email', $email)->delete();

        // clear session flags
        session()->forget(['password_reset_verified','password_reset_email','password_reset_id','password_reset_verified_at']);

        return redirect()->route('login')->with('status', __('passwords.reset_success'));
    }
}
