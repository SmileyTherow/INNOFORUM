<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 25);
        $perPage = $perPage <= 0 ? 25 : min(100, $perPage);

        // Query dasar: ambil data aktivitas admin, sertakan relasi 'admin', urutkan terbaru terlebih dahulu
        $query = AdminActivity::with('admin')->orderByDesc('created_at');

        // Filter berdasarkan admin tertentu
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        // Filter berdasarkan aksi tertentu (create, update, delete, dll.)
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan tipe target (model yang dipengaruhi)
        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

         // Filter pencarian global (mencari pada description, admin_name, ip_address, metadata)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qr) use ($q) {
                $qr->where('description', 'like', "%{$q}%")
                    ->orWhere('admin_name', 'like', "%{$q}%")
                    ->orWhere('ip_address', 'like', "%{$q}%")
                    ->orWhere('metadata', 'like', "%{$q}%");
            });
        }

        $activities = $query->paginate($perPage)->withQueryString();

        // Ambil list admin untuk dropdown filter di view
        $admins = User::where('role', 'admin')->orderBy('name')->get();

        // Ambil daftar action unik untuk dropdown filter di view
        $actions = AdminActivity::whereNotNull('action')->distinct()->orderBy('action')->pluck('action');

        return view('admin.activities.index', compact('activities', 'admins', 'actions'));
    }
}
