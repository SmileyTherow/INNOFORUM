<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['reporter', 'question', 'comment'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->only(['status', 'admin_message']));
        return redirect()->route('admin.reports.index')->with('success', 'Laporan diupdate!');
    }
}