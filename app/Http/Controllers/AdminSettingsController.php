<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function show()
    {
        $admin = Auth::user();
        return view('admin.settings', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // Debugging - pastikan ini mengembalikan User model
        if (!($admin instanceof \App\Models\User)) {
            dd('Auth::user() is not User model', get_class($admin));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$admin->id,
            'bio' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'admin_'.$admin->id.'_'.time().'.'.$file->getClientOriginalExtension();
            
            // Simpan file baru
            $path = $file->storeAs('public/photos/admins', $filename);
            
            // Hapus file lama jika ada
            if ($admin->photo) {
                $oldPath = str_replace('storage/', '', $admin->photo);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $admin->photo = 'storage/photos/admins/'.$filename;
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->bio = $validated['bio'];
        
        if (!$admin->save()) {
            return back()->with('error', 'Gagal menyimpan perubahan profil');
        }

        return redirect()->route('admin.settings.show')->with('success', 'Profil admin berhasil diperbarui!');
    }

    public function showResetPassword()
    {
        return view('admin.reset-password');
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $admin->password = Hash::make($validated['new_password']);
        $admin->save();

        return redirect()->route('admin.settings.show')->with('success', 'Password berhasil diganti.');
    }
}