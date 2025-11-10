<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'email', 'title', 'body', 'is_read', 'status'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function replies()
    {
        return $this->hasMany(MessageReply::class)->orderBy('created_at', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
