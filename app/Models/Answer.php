<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'content',
    ];

    /**
     * Relasi ke User
     * Satu jawaban dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Pertanyaan
     * Satu jawaban terkait dengan satu pertanyaan
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
