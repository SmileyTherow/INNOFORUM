<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserSocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'url',
        'label',
        'order',
        'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relationship ke User
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
