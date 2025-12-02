<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminActivityLogger;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10); // Ambil semua pengumuman terbaru, paginasi 10 per halaman
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create'); // Tampilkan form untuk membuat pengumuman baru
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // cek apakah model Announcement ada (antisipasi error sistem)
        if (!class_exists(\App\Models\Announcement::class)) {
            return back()->with('error', 'Model Announcement tidak ditemukan. Hubungi dev.');
        }

        // Simpan data pengumuman ke database
        $announcement = \App\Models\Announcement::create([
            'title' => $request->title,
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        // Mencatat aktivitas admin setelah membuat pengumuman
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'create_announcement',
                "Membuat pengumuman: \"" . \Illuminate\Support\Str::limit($request->title,150) . "\"",
                ['type' => 'Announcement', 'id' => $announcement->id],
                ['announcement_id' => $announcement->id]
            );
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        $announcement = Announcement::findOrFail($id); // Ambil pengumuman terkait
        // Update data pengumuman
        $announcement->update([
            'title' => $request->title,
            'content' => $request->input('content')
        ]);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Cari pengumuman dan hapus
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        // Hapus notifikasi terkait pengumuman tersebut
        \App\Models\Notification::where('type', 'announcement')
            ->where('data->announcement_id', $id)
            ->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.show', compact('announcement'));
    }

    public function notifyAll(Request $request)
    {
         // Validasi input notifikasi
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
        ]);

        // Kirim notifikasi ke semua user (kecuali admin)
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'announcement',
                'data' => [
                    'title' => $request->title,
                    'content' => $request->message,
                    'message' => $request->message,
                ],
                'is_read' => false,
            ]);
        }
        return back()->with('notif_success', 'Pesan berhasil dikirim ke semua user!');
    }
}
