<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicEvent;
use App\Models\User;
use App\Notifications\EventCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AdminActivityLogger;

class AcademicEventController extends Controller
{
    public function __construct()
    {
        // Pastikan route admin memakai middleware auth + admin
    }

    public function index()
    {
        return view('calendar.index');
    }

    public function apiIndex(Request $request)
    {
        $month = $request->get('month'); // format yyyy-mm

        if ($month) {
            if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
                return response()->json(['error' => 'Format month harus yyyy-mm'], 422);
            }
            [$year, $m] = explode('-', $month);
            $year = (int)$year;
            $m = (int)$m;
            if ($m < 1 || $m > 12) {
                return response()->json(['error' => 'Bulan tidak valid'], 422);
            }
            $events = AcademicEvent::inMonth($year, $m)
                ->where('is_published', true)
                ->get();
        } else {
            $now = now();
            $events = AcademicEvent::inMonth($now->year, $now->month)
                ->where('is_published', true)
                ->get();
        }

        return response()->json($events->map->toCalendarArray()->values());
    }

    public function adminApiIndex(Request $request)
    {
        $month = $request->get('month');

        if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
            [$year, $m] = explode('-', $month);
            $year = (int)$year;
            $m = (int)$m;
            if ($m < 1 || $m > 12) {
                return response()->json(['error' => 'Bulan tidak valid'], 422);
            }
            $events = AcademicEvent::inMonth($year, $m)->orderBy('start_date')->get();
        } else {
            $now = now();
            $events = AcademicEvent::inMonth($now->year, $now->month)->orderBy('start_date')->get();
        }

        return response()->json($events->map->toCalendarArray()->values());
    }

    public function adminIndex()
    {
        $events = AcademicEvent::orderBy('start_date', 'asc')->paginate(25);
        return view('admin.academic_events.index', compact('events'));
    }

    // store method yang aman: hanya akan buat event jika model ada
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        if (!class_exists(\App\Models\AcademicEvent::class)) {
            // log bahwa admin mencoba membuat event tapi model tidak tersedia
            if (Auth::check() && Auth::user()->role === 'admin') {
                AdminActivityLogger::log(
                    'create_event_failed',
                    "Mencoba membuat event (model AcademicEvent tidak ditemukan): \"" . \Illuminate\Support\Str::limit($request->title,150) . "\"",
                    null,
                    ['title' => $request->title]
                );
            }
            return back()->with('error', 'Model AcademicEvent tidak tersedia. Hubungi dev.');
        }

        $event = \App\Models\AcademicEvent::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        if (Auth::check() && Auth::user()->role === 'admin') {
            AdminActivityLogger::log(
                'create_event',
                "Membuat event kalender: \"" . \Illuminate\Support\Str::limit($request->title,150) . "\"",
                ['type'=>'Event','id'=>$event->id],
                ['start' => $request->start, 'end' => $request->end]
            );
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function update(Request $request, AcademicEvent $academicEvent)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'nullable|string|max:32',
            'is_published' => 'nullable|boolean',
        ]);

        $data['is_published'] = true;

        $academicEvent->update($data);

        return response()->json([
            'success' => true,
            'event' => $academicEvent->toCalendarArray()
        ]);
    }

    public function destroy(AcademicEvent $academicEvent)
    {
        $academicEvent->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $event = AcademicEvent::findOrFail($id);

        return view('calendar.show', ['event' => $event]);
    }
}
