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
    // tampilkan form
    public function show()
    {
        return view('auth.passwords.forgot');
    }

    // proses kirim kode
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower($request->email);
        $cacheLastKey = "pw_reset_last_sent:{$email}";
        $cacheCountKey = "pw_reset_sent_count_hour:{$email}";

        // Interval minimal antara pengiriman (60 detik)
        $lastSentTimestamp = Cache::get($cacheLastKey, 0);
        if ($lastSentTimestamp && (time() - (int)$lastSentTimestamp) < 60) {
            return back()->with('status', __('passwords.sent_generic'));
        }

        // Maksimal pengiriman per jam (5)
        $sentCount = Cache::get($cacheCountKey, 0);
        if ($sentCount >= 5) {
            return back()->with('status', __('passwords.sent_generic'));
        }

        $user = User::where('email', $email)->first();

        // Selalu tampilkan pesan yang sama untuk menghindari enumerasi akun
        $genericResponse = redirect()->route('password.verify')->with('status', __('passwords.sent_generic'));

        // Jika pengguna tidak ditemukan, tetap perbarui penghitung untuk mencegah penyalahgunaan, lalu respon dengan pesan umum
        if (! $user) {
            Cache::put($cacheLastKey, time(), 3600);
            Cache::put($cacheCountKey, $sentCount + 1, 3600);
            return $genericResponse;
        }

        // generate kode 6-digit
        try {
            $code = (string) random_int(100000, 999999);
        } catch (\Throwable $e) {
            $code = str_pad((string) mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }

        // Hash token sebelum menyimpan
        $hash = Hash::make($code);
        $ttlMinutes = 10;
        $expiresAt = now()->addMinutes($ttlMinutes);

        // Simpan kode reset baru (boleh lebih dari satu, verifikasi akan menggunakan yang terbaru yang valid)
        PasswordResetCode::create([
            'email' => $email,
            'token_hash' => $hash,
            'expires_at' => $expiresAt,
            'attempts' => 0,
            'locked_until' => null,
        ]);

        // perbarui penghitung cache SEBELUM mengembalikan
        Cache::put($cacheLastKey, time(), 3600);
        Cache::put($cacheCountKey, $sentCount + 1, 3600);

        // debug log (sementara - hapus di produksi)
        Log::info("DEBUG PW-RESET: code={$code} email={$email}");

        // antrian notifikasi (jika koneksi antrian adalah database, worker harus berjalan)
        $user->notify(new PasswordResetCodeNotification($code, $ttlMinutes));

        // Redirect ke halaman verifikasi agar pengguna tahu langkah selanjutnya
        return redirect()->route('password.verify')->with('status', __('passwords.sent_generic'));
    }
}
