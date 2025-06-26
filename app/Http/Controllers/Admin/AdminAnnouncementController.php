<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
         // 1. Tambah ke tabel pengumuman
        $announcement = Announcement::create([
            'title'   => $request->title,
            'content' => $request->content,
        ]);
        // 2. Kirim notifikasi ke semua user (kecuali admin)
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'announcement',
                'data' => [
                    'announcement_id' => $announcement->id,
                    'title'           => $request->title,
                    'content'         => $request->content,
                    'message'         => 'Ada pengumuman baru: ' . $request->title,
                ],
                'is_read' => false,
            ]);
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dikirim ke semua user!');
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
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content
        ]);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
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