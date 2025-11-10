<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'message_id', 'user_id', 'body', 'via_email'
    ];

    protected $casts = [
        'via_email' => 'boolean',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
