<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'unread');

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $query = $user->notifications();

        if ($tab === 'read') {
            $query->where('is_read', true);
        } else {
            $query->where('is_read', false);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);
        $count_unread = $user->notifications()->where('is_read', false)->count();

        return view('notifikasi.index', compact('notifications', 'tab', 'count_unread'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notif->is_read = true;
        $notif->save();
        return back()->with('success', 'Notifikasi sudah ditandai dibaca.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi sudah ditandai dibaca.');
    }

    public function destroy($id)
    {
        $notif = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notif->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }
}