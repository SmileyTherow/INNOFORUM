<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicEvent;
use App\Models\User;
use App\Notifications\EventCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AcademicEventController extends Controller
{
    public function __construct()
    {
        // Pastikan route admin memakai middleware auth + admin
    }

    /**
     * Public calendar view (user-facing).
     */
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Public API: get events
     */
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

    /**
     * Admin API: return events for admin
     */
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

    /**
     * Admin calendar view (CRUD UI)
     */
    public function adminIndex()
    {
        $events = AcademicEvent::orderBy('start_date', 'asc')->paginate(25);
        return view('admin.academic_events.index', compact('events'));
    }

    /**
     * Store new event (admin)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'nullable|string|max:32',
            'is_published' => 'nullable|boolean',
        ]);

        $data['created_by'] = Auth::id();
        $data['color'] = $data['color'] ?? 'blue';
        $data['is_published'] = true;

        $event = AcademicEvent::create($data);

        try {
            $users = User::all();
            Notification::send($users, new EventCreated($event));
        } catch (\Throwable $e) {
            Log::error('Gagal kirim notifikasi event: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'event' => $event->toCalendarArray(),
            'message' => 'Event created and notifications queued/sent.'
        ], 201);
    }

    /**
     * Update event (admin)
     */
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

    /**
     * Delete event (admin)
     */
    public function destroy(AcademicEvent $academicEvent)
    {
        $academicEvent->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Show single event (public detail page).
     */
    public function show($id)
    {
        $event = AcademicEvent::findOrFail($id);

        return view('calendar.show', ['event' => $event]);
    }
}
