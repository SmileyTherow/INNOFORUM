<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminActivity::with('admin')->orderByDesc('created_at');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qr) use ($q) {
                $qr->where('description', 'like', "%{$q}%")
                    ->orWhere('admin_name', 'like', "%{$q}%")
                    ->orWhereJsonContains('metadata', $q);
            });
        }

        $activities = $query->paginate(25)->withQueryString();

        // ambil list admin untuk filter dropdown
        $admins = \App\Models\User::where('role', 'admin')->orderBy('name')->get();

        // unique action list
        $actions = AdminActivity::select('action')->distinct()->pluck('action');

        return view('admin.activities.index', compact('activities', 'admins', 'actions'));
    }
}
