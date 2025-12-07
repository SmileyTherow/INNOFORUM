<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AdminActivityLogger;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        // Fitur pencarian user berdasarkan nama, email atau username
        $query = User::query();
        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%')
                    ->orWhere('username', 'like', '%' . $request->q . '%');
            });
        }

        $query->where('role', '!=', 'admin'); // Admin tidak ditampilkan dalam daftar user

        if (app()->environment('local')) {
            Log::info('DEBUG - sample user attributes: ', $query->first() ? $query->first()->toArray() : []);
        }


        $users = $query->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users',
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user ke database
        $user = User::create([
            'username' => $validatedData['username'],
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'role'     => $validatedData['role'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Log activity admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'create_user',
                "Membuat user #{$user->id}",
                ['type'=>'User','id'=>$user->id],
                []
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // ADMIN: Detail user tertentu
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // ADMIN: Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // ADMIN: Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Validasi input update
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users,email,' . $id,
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        // Update data user
        $user->username = $validatedData['username'];
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];
        $user->role     = $validatedData['role'];
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();

        // log aktifitas admin update
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'update_user',
                "Mengupdate data user #{$user->id}",
                ['type'=>'User','id'=>$user->id],
                ['changes' => array_keys($validatedData)]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Log aktivitas admin saat menghapus user
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'delete_user',
                "Menghapus user #{$id}",
                ['type'=>'User','id'=>$id],
                []
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus (soft delete).');
    }

    public function reported() {
        return view('admin.users.reported');
    }

    // Hapus nama & email (tidak hapus user di database)
    public function deleteFields($id)
    {
        // Set semua data pribadi menjadi null
        $user = User::findOrFail($id);
        $user->name = null;
        $user->email = null;
        $user->photo = null;
        $user->password = null;
        $user->prodi = null;
        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Nama & email user berhasil dihapus!');
    }

    // Form kirim notifikasi
    public function notifyForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.notify', compact('user'));
    }

    // Kirim notifikasi ke user
    public function sendNotification(Request $request, $id)
    {
        $request->validate(['message' => 'required|string|max:255']);
        $user = User::findOrFail($id);

        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'admin_message',
            'data' => (['message' => $request->message]),
            'is_read' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Notifikasi terkirim!');
    }

    // ADMIN: Tambah user baru hanya dengan username
    public function addUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
        ]);

        $user = new \App\Models\User();
        $user->username = $request->username;
        $user->save();

        return back()->with('success', 'Username berhasil ditambahkan!');
    }
}
