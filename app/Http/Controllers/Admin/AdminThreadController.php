<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Question;
use App\Services\AdminActivityLogger;

class AdminThreadController extends Controller
{
    public function index(Request $request) {
        $query = Question::with('user');
        if ($request->q) {
            $query->where('title', 'like', '%' . $request->q . '%')
                ->orWhereHas('user', function($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->q . '%');
                });
        }
        $threads = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.threads.index', compact('threads'));
    }

    public function reported() {
        $reportedThreads = \App\Models\Question::with(['user', 'reports.reporter'])
            ->whereHas('reports')
            ->paginate(20);

        return view('admin.threads.reported', compact('reportedThreads'));
    }

    public function show($id) {
        $thread = \App\Models\Question::with(['user', 'category'])->findOrFail($id);
        return view('admin.threads.show', compact('thread'));
    }

    public function edit($id)
    {
        $thread = \App\Models\Question::findOrFail($id);
        return view('admin.threads.edit', compact('thread'));
    }

    public function update(Request $request, $id)
    {
        $thread = \App\Models\Question::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $thread->update($validated);
        return redirect()->route('admin.threads.show', $thread->id)->with('success', 'Thread berhasil diupdate.');
    }

    public function destroy($id)
    {
        $thread = \App\Models\Question::findOrFail($id);
        $thread->delete();
        return redirect()->route('admin.threads.index')->with('success', 'Thread dihapus.');
    }

    public function notify(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|exists:questions,id',
            'message' => 'required|string|max:500'
        ]);

        $thread = Question::find($request->thread_id);
        if (!$thread || !$thread->user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        Notification::create([
            'user_id' => $thread->user->id,
            'type' => 'admin_warning',
            'data' => [
                'thread_id' => $thread->id,
                'message' => $request->message,
                'from_admin' => true,
                'link' => route('questions.show', $thread->id),
            ],
            'is_read' => false,
        ]);

        // Log activity
        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'admin_warn_thread',
                "Memberi peringatan pada thread #{$thread->id}: \"" . \Illuminate\Support\Str::limit($request->message,150) . "\"",
                ['type'=>'Question','id'=>$thread->id],
                ['warning' => \Illuminate\Support\Str::limit($request->message,150)]
            );
        }

        return back()->with('success', 'Pesan notifikasi berhasil dikirim!');
    }
}
