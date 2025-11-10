<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileCompletionController extends Controller
{
    /**
     * Tampilkan form lengkapi profil.
     * Tidak memakai middleware auth di sini karena user belum login — kita mengidentifikasi user via session('register_user_id').
     */
    public function show()
    {
        $userId = session('register_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session pendaftaran tidak ditemukan. Silakan login atau daftar ulang.');
        }

        $user = User::find($userId);
        if (!$user) {
            // Jika user hilang, clear session dan arahkan ulang
            session()->forget('register_user_id');
            return redirect()->route('register')->with('error', 'Akun tidak ditemukan. Silakan daftar ulang.');
        }

        // Load socialLinks relation jika ada
        $user->load('socialLinks');

        return view('profile.complete', compact('user'));
    }

    /**
     * Simpan profil dasar (bio, program studi/angkatan/matkul bila ada) dan social links.
     * Setelah berhasil disimpan, hapus session('register_user_id') dan arahkan user ke halaman login.
     */
    public function update(Request $request)
    {
        $userId = session('register_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session pendaftaran tidak ditemukan. Silakan login atau daftar ulang.');
        }

        $user = User::find($userId);
        if (!$user) {
            session()->forget('register_user_id');
            return redirect()->route('register')->with('error', 'Akun tidak ditemukan. Silakan daftar ulang.');
        }

        // Validasi profil dasar
        $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
            'angkatan' => ['nullable', 'string', 'max:10'], // jika mahasiswa
        ]);

        // Simpan profil dasar
        if ($request->filled('bio')) {
            $user->bio = $request->bio;
        }

        if ($user->role === 'mahasiswa' && $request->filled('angkatan')) {
            $user->angkatan = $request->angkatan;
        }

        $user->save();

        // Proses social links
        $links = $request->input('links', []);

        // Hapus yang lama
        $user->socialLinks()->delete();

        // Simpan yang baru
        foreach ($links as $i => $link) {
            $url = trim($link['url'] ?? '');
            if (empty($url)) continue;

            // Auto-detect type dari URL
            $type = $this->detectSocialMediaType($url);

            // Normalize URL
            if (!preg_match('~^https?://~i', $url)) {
                $url = 'https://' . $url;
            }

            $user->socialLinks()->create([
                'type' => $type,
                'url' => $url,
                'label' => $link['label'] ?? null,
                'order' => $i,
                'visible' => true,
            ]);
        }

        session()->forget('register_user_id');
        return redirect()->route('login')->with('status', 'Profil disimpan. Silakan login untuk melanjutkan.');
    }

    /**
     * Deteksi tipe social media dari URL
     */
    private function detectSocialMediaType($url): string
    {
        $url = strtolower($url);

        $patterns = [
            'instagram' => '/instagram|instagr\.am/',
            'github' => '/github/',
            'facebook' => '/facebook|fb\.me/',
            'linkedin' => '/linkedin/',
            'twitter' => '/twitter|t\.co/',
            'youtube' => '/youtube|youtu\.be/',
            'tiktok' => '/tiktok/',
            'whatsapp' => '/whatsapp/',
            'telegram' => '/telegram|t\.me/',
            'discord' => '/discord/',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $url)) {
                return $type;
            }
        }

        return 'other';
    }
}
