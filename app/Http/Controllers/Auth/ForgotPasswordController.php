<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    // show form
    public function show()
    {
        return view('auth.passwords.forgot');
    }

    // process send code
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower($request->email);
        $cacheLastKey = "pw_reset_last_sent:{$email}";
        $cacheCountKey = "pw_reset_sent_count_hour:{$email}";

        // Minimal interval between sends (60s)
        $lastSentTimestamp = Cache::get($cacheLastKey, 0);
        if ($lastSentTimestamp && (time() - (int)$lastSentTimestamp) < 60) {
            return back()->with('status', __('passwords.sent_generic'));
        }

        // Max per hour (5)
        $sentCount = Cache::get($cacheCountKey, 0);
        if ($sentCount >= 5) {
            return back()->with('status', __('passwords.sent_generic'));
        }

        $user = User::where('email', $email)->first();

        // Always show same message to avoid account enumeration
        $genericResponse = redirect()->route('password.verify')->with('status', __('passwords.sent_generic'));

        // If user not found, still update counters to prevent abuse, then respond generic
        if (! $user) {
            Cache::put($cacheLastKey, time(), 3600);
            Cache::put($cacheCountKey, $sentCount + 1, 3600);
            return $genericResponse;
        }

        // generate 6-digit code
        try {
            $code = (string) random_int(100000, 999999);
        } catch (\Throwable $e) {
            $code = str_pad((string) mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }

        // Hash token before storing
        $hash = Hash::make($code);
        $ttlMinutes = 10;
        $expiresAt = now()->addMinutes($ttlMinutes);

        // Store new reset code (multiple allowed, verify will use latest valid)
        PasswordResetCode::create([
            'email' => $email,
            'token_hash' => $hash,
            'expires_at' => $expiresAt,
            'attempts' => 0,
            'locked_until' => null,
        ]);

        // update cache counters BEFORE returning
        Cache::put($cacheLastKey, time(), 3600);
        Cache::put($cacheCountKey, $sentCount + 1, 3600);

        // debug log (temporary - hapus di production)
        Log::info("DEBUG PW-RESET: code={$code} email={$email}");

        // queue notification (if queue connection is database, worker must run)
        $user->notify(new PasswordResetCodeNotification($code, $ttlMinutes));

        // Redirect to verify page so user tahu langkah selanjutnya
        return redirect()->route('password.verify')->with('status', __('passwords.sent_generic'));
    }
}