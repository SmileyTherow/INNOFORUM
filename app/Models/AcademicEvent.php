<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AcademicEvent extends Model
{
    use HasFactory;

    protected $table = 'academic_events';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'color',
        'created_by',
        'is_published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopeInMonth($query, int $year, int $month)
    {
        // Hitung tanggal pertama dan terakhir bulan tersebut
        $first = Carbon::create($year, $month, 1)->startOfDay();
        $last = $first->copy()->endOfMonth()->endOfDay();

        return $query->whereDate('start_date', '<=', $last->toDateString())
            ->where(function ($q) use ($first) {
                $q->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $first->toDateString());
            });
    }

    public function toCalendarArray(): array
    {
        // Format tanggal untuk kalender
        $start = $this->start_date ? $this->start_date->toDateString() : null;

        if ($this->end_date) {
            $end = $this->end_date->toDateString();
        } elseif ($this->start_date) {
            $end = $this->start_date->toDateString();
        } else {
            $end = null;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $start,
            'end_date' => $end,
            'start' => $start,
            'end' => $end,
            'color' => $this->color ?? 'blue',
            'is_published' => (bool) $this->is_published,
            'created_by' => $this->created_by,
            'url' => url('/kalender/event/' . $this->id),
        ];
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
