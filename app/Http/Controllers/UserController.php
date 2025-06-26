<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        $likeCount = 0;

        return view('profile.edit', compact('user', 'threadCount', 'commentCount', 'likeCount'));
    }

    // Update profil (sendiri)
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

        // Redirect ke halaman edit dengan pesan sukses
        return redirect()->route('profile.edit', $id)->with('success', 'Profil berhasil diperbarui.');
    }

    // Hapus foto profil
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
        $user = User::with(['profile', 'questions', 'comments'])->withCount(['questions', 'comments'])->findOrFail($id);

        // Ambil thread dan komentar milik user
        $threads = $user->questions()->latest()->get();
        $comments = $user->comments()->latest()->get();
        $threadCount = $user->questions_count ?? $user->questions()->count();
        $commentCount = $user->comments_count ?? $user->comments()->count();
        $likeCount = 0; // Isi dengan perhitungan like jika ada relasinya

        return view('users.profile', compact('user', 'threads', 'comments', 'threadCount', 'commentCount', 'likeCount'));
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

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'angkatan' => $request->angkatan ?? null,
                'bio'      => $request->bio,
            ]
        );

        return redirect()->route('login')->with('success', 'Profil berhasil dilengkapi. Silakan login untuk melanjutkan.');
    }
}