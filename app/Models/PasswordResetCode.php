<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordResetCode extends Model
{
    protected $table = 'password_reset_codes';

    protected $fillable = [
        'email',
        'token_hash',
        'expires_at',
        'attempts',
        'locked_until',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'locked_until' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lt(now());
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->gt(now());
    }
}
