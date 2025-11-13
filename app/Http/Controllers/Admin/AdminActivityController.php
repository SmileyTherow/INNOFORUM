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
        // Per-page optional (default 25, max 100)
        $perPage = (int) $request->get('per_page', 25);
        $perPage = $perPage <= 0 ? 25 : min(100, $perPage);

        // Basic query, eager load relasi admin
        $query = AdminActivity::with('admin')->orderByDesc('created_at');

        // Filter by admin
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by target_type (sesuaikan nama kolom kalau beda)
        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        // Global search q: description, admin_name, ip_address, metadata (fallback LIKE)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qr) use ($q) {
                $qr->where('description', 'like', "%{$q}%")
                   ->orWhere('admin_name', 'like', "%{$q}%")
                   ->orWhere('ip_address', 'like', "%{$q}%")
                   // Metadata: jika kolom metadata adalah JSON, and gunakan DB JSON functions kalau perlu.
                   // Di banyak kasus, melakukan LIKE pada kolom JSON bekerja juga (tergantung driver).
                   ->orWhere('metadata', 'like', "%{$q}%");
            });
        }

        // Paginate with query string so filter params persist
        $activities = $query->paginate($perPage)->withQueryString();

        // Ambil list admin untuk dropdown filter (asumsi role field 'admin')
        $admins = User::where('role', 'admin')->orderBy('name')->get();

        // Ambil daftar action unik (exclude null)
        $actions = AdminActivity::whereNotNull('action')->distinct()->orderBy('action')->pluck('action');

        return view('admin.activities.index', compact('activities', 'admins', 'actions'));
    }
}
