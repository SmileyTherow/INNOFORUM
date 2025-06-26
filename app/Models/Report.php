<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id', 'question_id', 'comment_id', 'reason', 'description', 'status'
    ];

    public function reporter()
    {
        return $this->belongsTo(\App\Models\User::class, 'reporter_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}