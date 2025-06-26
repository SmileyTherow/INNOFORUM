<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'discussion_hashtags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
