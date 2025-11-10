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
        $start = $this->start_date ? $this->start_date->toDateString() : null;
        $end = $this->end_date ? $this->end_date->toDateString() : $start;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $start,
            'end' => $end,
            'start_date' => $start,
            'end_date' => $end,
            'description' => $this->description,
            'color' => $this->color ?? 'blue',
            'url' => url('/kalender/event/' . $this->id),
            'created_by' => $this->created_by,
            'is_published' => (bool) $this->is_published,
        ];
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
