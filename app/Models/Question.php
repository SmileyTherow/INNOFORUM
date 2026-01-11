<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category_id',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    // Relasi user pembuat pertanyaan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke hashtag (many to many)
    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'hashtag_question');
    }

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke likes (many to many dengan users)
    public function likes()
    {
        return $this->belongsToMany(User::class, 'question_likes', 'question_id', 'user_id')->withTimestamps();
    }

    // Relasi ke jawaban
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\Report::class, 'question_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
