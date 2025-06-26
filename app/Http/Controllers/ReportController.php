<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Question;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // User melaporkan pertanyaan/komentar
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
            'question_id' => 'nullable|exists:questions,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        Report::create([
            'reporter_id' => Auth::id(),
            'question_id' => $request->question_id,
            'comment_id' => $request->comment_id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Laporan berhasil dikirim, akan ditinjau admin.');
    }

    // Admin: daftar laporan
    public function index()
    {
        $reports = Report::with(['reporter', 'question', 'comment'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    // Admin: update status & kirim notifikasi ke pelapor
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewed,ignored,resolved',
            'admin_message' => 'nullable|string',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_message' => $request->admin_message,
        ]);

        // === NOTIFIKASI KE PELAPOR ===
        \App\Models\Notification::create([
            'user_id' => $report->reporter_id,
            'type' => 'report_status',
            'data' => [
                'report_id' => $report->id,
                'status' => $report->status,
                'message' => 'Status laporanmu: ' . $report->status . ($request->admin_message ? ' - ' . $request->admin_message : '')
            ]
        ]);

        return back()->with('success', 'Status laporan & pesan peringatan diperbarui.');
    }
}