<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // 1. Halaman validasi NIM/NIGM
    public function showNimForm()
    {
        session()->forget(['validated_nim', 'username']);
        return view('auth.nim_or_nigm');
    }

    // 2. Proses validasi NIM/NIGM
    public function validateNim(Request $request)
    {
        $request->validate([
            'nim_or_nigm' => ['required', 'string', 'max:20'],
        ]);

        if ($request->nim_or_nigm == '404039582') {
            return redirect('/admin/login');
        }

        if ($request->nim_or_nigm == '285930404') {
            return redirect('/admin/login');
        }

        $user = User::where('username', $request->nim_or_nigm)->first();

        if ($user) {
            session(['validated_nim' => $user->username, 'username' => $user->username]);
            if ($user->name && $user->email && $user->password) {
                return redirect()->route('login')->with('success', 'Akun ditemukan, silakan login.');
            } else {
                if ($user->role === 'mahasiswa') {
                    return redirect()->route('register.mahasiswa')->with('info', 'Silakan lengkapi data registrasi mahasiswa.');
                } elseif ($user->role === 'dosen') {
                    return redirect()->route('register.dosen')->with('info', 'Silakan lengkapi data registrasi dosen.');
                } else {
                    return back()->withErrors(['nim_or_nigm' => 'Role pengguna tidak valid.']);
                }
            }
        }
        return back()->withErrors(['nim_or_nigm' => 'NIM/NIDM tidak ditemukan di sistem.']);
    }

    // 3. Halaman register mahasiswa
    public function showMahasiswaRegisterPage()
    {
        $username = session('username');
        if (!$username) {
            return redirect()->route('nim.form')->with('error', 'Silakan validasi NIM/NIGM terlebih dahulu.');
        }
        // GANTI view ke login_register_mahasiswa agar sesuai dengan file kamu!
        return view('auth.login_register_mahasiswa', compact('username'));
    }

    // 4. Halaman register dosen
    public function showDosenRegisterPage()
    {
        $username = session('username');
        if (!$username) {
            return redirect()->route('nim.form')->with('error', 'Silakan validasi NIM/NIGM terlebih dahulu.');
        }
        return view('auth.login_register_dosen', compact('username'));
    }

    // 5. Halaman login (wajib sudah validated_nim)
    public function showLoginForm()
    {
        if (!session('validated_nim')) {
            return redirect()->route('nim.form')->with('error', 'Silakan validasi NIM/NIGM terlebih dahulu.');
        }
        // GANTI view ke login_register_mahasiswa agar sesuai dengan file kamu!
        return view('auth.login_register_mahasiswa');
    }

    // 6. Proses registrasi (kini generate OTP & kirim email)
    public function register(Request $request)
    {
        $username = session('username');
        if (!$username) {
            return redirect()->route('nim.form')->with('error', 'Session username tidak ditemukan. Silakan validasi ulang.');
        }

        $user = User::where('username', $username)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan. Silakan validasi ulang NIM/NIGM.');
        }

        if ($user->name && $user->email && $user->password) {
            return back()->with('error', 'Akun Anda sudah terdaftar. Silakan login.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'password' => 'required|string|min:6|confirmed',
            'prodi' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath  = null;
        if ($request->hasFile('photo')) {
            $photoPath  = $request->file('photo')->storeAs('photo',  'public');
        }

        // Generate kode OTP 6 digit
        $otpCode = random_int(100000, 999999);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'gender' => $validatedData['gender'],
            'password' => Hash::make($validatedData['password']),
            'prodi' => $validatedData['prodi'],
            'photo' => $photoPath,
            'otp_code' => $otpCode,
            'otp_expired_at' => now()->addMinutes(5),
            'email_verified_at' => null,
        ]);

        // Kirim email OTP
        Mail::to($user->email)->send(new UserOtpMail($otpCode));

        session()->forget(['username']);

        // Redirect ke halaman verifikasi OTP
        return redirect()->route('user.otp.form', ['email' => $user->email]);
    }

    // 7. Halaman verifikasi OTP user
    public function showUserOtpForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.user_otp', compact('email'));
    }

    // 8. Proses verifikasi OTP user
    public function verifyUserOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek expired
        if (!$user->otp_code || now()->gt($user->otp_expired_at)) {
            return back()->with('error', 'Kode OTP sudah kadaluarsa. Silakan klik "Kirim Ulang OTP".');
        }

        if ($user->otp_code == $request->otp_code) {
            $user->email_verified_at = now();
            $user->otp_code = null;
            $user->otp_expired_at = null;
            $user->save();

            return redirect()->route('profile.complete', ['user_id' => $user->id])
                ->with('success', 'Verifikasi berhasil. Silakan lengkapi profil Anda.');
        } else {
            return back()->with('error', 'Kode OTP salah.');
        }
    }

    // 8b. Kirim ulang OTP
    public function resendUserOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }
        $otpCode = random_int(100000, 999999);
        $user->otp_code = $otpCode;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();
        Mail::to($user->email)->send(new UserOtpMail($otpCode));
        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    // 9. Proses login
    public function login(Request $request)
    {
        if (!session('validated_nim')) {
            return redirect()->route('nim.form')->with('error', 'Silakan validasi NIM/NIGM terlebih dahulu.');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek email sudah diverifikasi
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !$user->email_verified_at) {
            return back()->withErrors([
                'email' => 'Email belum diverifikasi.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session()->forget(['validated_nim', 'username']);
            return redirect()->route('dashboard')->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 10. Halaman login admin (jika dibutuhkan)
    public function showAdminLoginPage()
    {
        return view('auth.login_admin');
    }

    // ========== FUNGSI PROFIL USER ==========

    // Form edit profil (sendiri)
    public function edit($id)
    {
        if (Auth::id() != $id) abort(403);
        $user = User::with('profile')->findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    // Update profil (sendiri)
    public function update(Request $request, $id)
    {
        if (Auth::id() != $id) abort(403);
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'required_with:password',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'angkatan' => 'nullable|string|max:10',
            'bio'      => 'nullable|string|max:500'
        ]);

        $user->username = $validatedData['username'];
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];

        if ($user->role === 'mahasiswa') {
            $user->prodi = $request->input('prodi');
            $user->mata_kuliah = null;
        } elseif ($user->role === 'dosen') {
            $user->mata_kuliah = $request->input('prodi');
            $user->prodi = null;
        }

        if ($request->filled('password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('photo', $filename, 'public');
            if ($user->photo && Storage::exists('photo/' . $user->photo)) {
                Storage::delete('photo/' . $user->photo);
            }
            $user->photo = $filename;
        }
        $user->save();

        // Update/buat profil user (angkatan, bio)
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'angkatan' => $request->input('angkatan'),
                'bio'      => $request->input('bio')
            ]
        );

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

    // Tampilkan profil publik
    public function show($id)
    {
        $user = User::with(['profile', 'questions', 'comments'])->withCount(['questions', 'comments'])->findOrFail($id);
        return view('users.profile', compact('user'));
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

        $rules = ['bio' => 'nullable|string|max:500'];
        if ($user->role === 'mahasiswa') $rules['angkatan'] = 'required|string|max:10';
        $rules['links'] = 'nullable|array|max:3';
        $rules['links.*.url'] = 'nullable|string|max:2048';
        $rules['links.*.label'] = 'nullable|string|max:100';

        $request->validate($rules);

        // save profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'angkatan' => $request->input('angkatan'),
                'bio' => $request->input('bio'),
            ]
        );

        // save social links (delete lalu create)
        $links = $request->input('links', []);
        $user->socialLinks()->delete();

        $toCreate = [];
        foreach ($links as $i => $link) {
            $raw = trim($link['url'] ?? '');
            if ($raw === '') continue;

            $url = $raw;
            if (!preg_match('~^https?://~i', $url) && strpos($url, '@') === false) {
                $url = 'https://' . $url;
            }

            $type = $this->detectSocialType($url);

            $toCreate[] = [
                'type' => $type,
                'url' => $url,
                'label' => $link['label'] ?? null,
                'order' => $i,
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($toCreate)) {
            $user->socialLinks()->createMany($toCreate);
        }

        return redirect()->route('login')->with('success', 'Profil berhasil dilengkapi. Silakan login untuk melanjutkan.');
    }
}
