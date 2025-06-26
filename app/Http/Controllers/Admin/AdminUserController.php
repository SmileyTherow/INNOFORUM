<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // ADMIN: List user (tanpa soft deleted)
    public function index(Request $request)
    {
        $query = \App\Models\User::query();
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                ->orWhere('email', 'like', '%' . $request->q . '%')
                ->orWhere('username', 'like', '%' . $request->q . '%');
            });
        }

        $query->where('role', '!=', 'admin');

        $users = $query->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // ADMIN: Form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // ADMIN: Simpan user baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users',
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'password' => 'required|string|min:6|confirmed',
        ]);
        User::create([
            'username' => $validatedData['username'],
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'role'     => $validatedData['role'],
            'password' => bcrypt($validatedData['password']),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // ADMIN: Detail user
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
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255|unique:users,email,' . $id,
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'password' => 'nullable|string|min:6|confirmed'
        ]);
        $user->username = $validatedData['username'];
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];
        $user->role     = $validatedData['role'];
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    // ADMIN: Soft delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus (soft delete).');
    }

    public function reported() {
        return view('admin.users.reported');
    }

    // Hapus nama & email (tidak hapus user di database)
    public function deleteFields($id)
    {
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

        // Asumsikan kamu punya model Notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'admin_message',
            'data' => json_encode(['message' => $request->message]),
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
        // field lain biarkan null
        $user->save();

        return back()->with('success', 'Username berhasil ditambahkan!');
    }
}