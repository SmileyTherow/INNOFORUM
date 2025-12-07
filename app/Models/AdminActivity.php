<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'admin_name',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_id');
    }

    public function subject()
    {
        if ($this->subject_type && $this->subject_id) {
            try {
                $class = $this->subject_type;
                if (class_exists($class)) {
                    return $this->belongsTo($class, 'subject_id');
                }
            } catch (\Throwable $e) {
            }
        }
        return null;
    }
}
