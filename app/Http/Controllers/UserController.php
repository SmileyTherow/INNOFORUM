<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\BadgeService;

class UserController extends Controller
{
    // Form edit profil (sendiri)
    public function edit($id)
    {
        if (Auth::id() != $id) abort(403);

        // Pastikan relasi profile sudah dimuat
        $user = User::with('profile')->findOrFail($id);

        // Statistik
        $threadCount = $user->questions()->count();
        $commentCount = $user->comments()->count();

        // Hitungan like: termasuk like pada questions dan like pada comments milik user
        $totalQuestionLikes = DB::table('question_likes')
            ->join('questions', 'questions.id', '=', 'question_likes.question_id')
            ->where('questions.user_id', $id)
            ->count();

        $totalCommentLikes = DB::table('comment_likes')
            ->join('comments', 'comments.id', '=', 'comment_likes.comment_id')
            ->where('comments.user_id', $id)
            ->count();

        $likeCount = $totalQuestionLikes + $totalCommentLikes;

        return view('profile.edit', compact('user', 'threadCount', 'commentCount', 'likeCount'));
    }

    public function update(Request $request, $id)
    {
        // Cek user yang login
        if (Auth::id() != $id) abort(403);

        // Ambil user
        $user = User::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users,email,' . $id,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'prodi'    => 'required|string|max:255',
            'angkatan' => 'nullable|string|max:10',
            'bio'      => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Isi data user
        $user->username = $validatedData['username'];
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];
        $user->prodi    = $validatedData['prodi'];
        $user->gender   = $validatedData['gender'];

        Log::info('USER DATA', $user->toArray());
        Log::info('REQUEST DATA', $request->all());

        // Update password jika diisi
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Update foto profil jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('photo', $filename, 'public');

            if ($user->photo && Storage::exists('photo/' . $user->photo)) {
                Storage::delete('photo/' . $user->photo);
            }
            $user->photo = $filename;
        }

        // Simpan perubahan user
        $user->save();

        // Update/buat profil user (angkatan, bio, prodi jika ingin di profile, tapi default di user)
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'angkatan' => $request->input('angkatan'),
                'bio'      => $request->input('bio'),
            ]
        );

        // ===== TAMBAHKAN INI UNTUK PROCESS SOCIAL LINKS =====
        $links = $request->input('links', []);

        Log::info('Update Profile - Social Links Input:', $links); // Debug

        // Hapus social links yang lama
        $user->socialLinks()->delete();

        // Simpan social links yang baru
        foreach ($links as $i => $link) {
            $url = trim($link['url'] ?? '');
            if (empty($url)) continue;

            // Normalize URL
            if (!preg_match('~^https?://~i', $url)) {
                $url = 'https://' . $url;
            }

            // Auto-detect type
            $type = $this->detectSocialMediaType($url);

            $user->socialLinks()->create([
                'type' => $type,
                'url' => $url,
                'label' => $link['label'] ?? null,
                'order' => $i,
                'visible' => true,
            ]);

            Log::info("Updated social link: {$type} - {$url}"); // Debug
        }
        // ===== END SOCIAL LINKS =====

        return redirect()->route('profile.edit', $id)->with('success', 'Profil berhasil diperbarui.');
    }

    public function deletePhoto($id)
    {
        if (Auth::id() != $id && Auth::user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);
        if ($user->photo && Storage::exists('photo/' . $user->photo)) {
            Storage::delete('photo/' . $user->photo);
        }
        $user->photo = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    // Tampilkan profil publik user
    public function show($id)
    {
        $user = User::with([
            'profile',
            'questions',
            'comments',
            'badges',
            'socialLinks' => function($query) {
                $query->where('visible', true)->orderBy('order');
            }
        ])->withCount(['questions', 'comments'])->findOrFail($id);

        // Ambil thread dan komentar milik user
        $threads = $user->questions()->latest()->get();
        $comments = $user->comments()->latest()->get();
        $threadCount = $user->questions_count ?? $user->questions()->count();
        $commentCount = $user->comments_count ?? $user->comments()->count();

        // Hitungan like: masukkan likes pada questions dan likes pada comments milik user
        $totalQuestionLikes = DB::table('question_likes')
            ->join('questions', 'questions.id', '=', 'question_likes.question_id')
            ->where('questions.user_id', $id)
            ->count();

        $totalCommentLikes = DB::table('comment_likes')
            ->join('comments', 'comments.id', '=', 'comment_likes.comment_id')
            ->where('comments.user_id', $id)
            ->count();

        $likeCount = $totalQuestionLikes + $totalCommentLikes;

        $badgeService = app(BadgeService::class);
        $responderFile = $badgeService->determineBadgeFilename('responder', $user->answer_points ?? 0);
        $likeFile = $badgeService->determineBadgeFilename('like', $user->like_points ?? 0);

        return view('users.profile', compact('user', 'threads', 'comments', 'threadCount', 'commentCount', 'likeCount'))->with([
            'responderFile' => $responderFile,
            'likeFile' => $likeFile,
        ]);
    }

    // ========== LENGKAPI PROFIL (SETELAH OTP, SEBELUM LOGIN) ==========
    public function showCompleteProfileForm($user_id)
    {
        $user = User::findOrFail($user_id);
        // Jika profil sudah lengkap, redirect ke login
        if ($user->profile && $user->profile->angkatan && $user->profile->bio) {
            return redirect()->route('login');
        }
        return view('auth.complete-profile', compact('user'));
    }

    public function submitCompleteProfile(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        if ($user->role === 'mahasiswa') {
            $request->validate([
                'angkatan' => 'required|numeric|digits:4',
                'bio'      => 'nullable|string|max:500',
            ]);
        } else {
            $request->validate([
                'bio'      => 'nullable|string|max:500',
            ]);
        }

        // Simpan profil dasar
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'angkatan' => $request->angkatan ?? null,
                'bio'      => $request->bio,
            ]
        );

        // ===== TAMBAHKAN INI UNTUK PROCESS SOCIAL LINKS =====
        $links = $request->input('links', []);

        Log::info('Complete Profile - Social Links Input:', $links); // Debug

        // Hapus social links yang lama jika ada
        $user->socialLinks()->delete();

        // Simpan social links yang baru
        foreach ($links as $i => $link) {
            $url = trim($link['url'] ?? '');
            if (empty($url)) continue;

            // Normalize URL
            if (!preg_match('~^https?://~i', $url)) {
                $url = 'https://' . $url;
            }

            // Auto-detect type
            $type = $this->detectSocialMediaType($url);

            $user->socialLinks()->create([
                'type' => $type,
                'url' => $url,
                'label' => $link['label'] ?? null,
                'order' => $i,
                'visible' => true,
            ]);

            Log::info("Created social link: {$type} - {$url}"); // Debug
        }
        // ===== END SOCIAL LINKS =====

        return redirect()->route('login')->with('success', 'Profil berhasil dilengkapi. Silakan login untuk melanjutkan.');
    }

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
            'google' => '/google|gmail|docs\.google|drive\.google|share\.google/',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $url)) {
                return $type;
            }
        }

        return 'other';
    }
}
