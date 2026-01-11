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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        // Simpan pengumuman ke DB
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            // Kolom lain kalau ada
        ]);
        // Kirim notif ke semua user (kecuali admin)
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'announcement',
                'data' => [
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'message' => $announcement->content,
                ],
                'is_read' => false,
            ]);
        }
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman & notifikasi berhasil dikirim!');
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
            'content' => 'required|string|max:500',
        ]);

        // Kirim notifikasi ke semua user (kecuali admin)
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'announcement',
                'data' => [
                    'title' => $request->title,
                    'content' => $request->content,
                    'message' => $request->content,
                ],
                'is_read' => false,
            ]);
        }
        return back()->with('notif_success', 'Pesan berhasil dikirim ke semua user!');
    }
}
