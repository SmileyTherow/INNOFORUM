<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\UserSocialLink;


class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'username',
        'role',
        'name',
        'email',
        'password',
        'gender',
        'prodi',
        'mata_kuliah',
        'avatar',
        'photo',
        'email_verified_at',
        'otp_code',
        'otp_expired_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expired_at'    => 'datetime',
        'deleted_at'        => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedQuestions()
    {
        return $this->belongsToMany(Question::class, 'question_likes')->withTimestamps();
    }

    public function totalQuestionLikes()
    {
        return $this->questions()->withCount('likes')->get()->sum('likes_count');
    }

    public function profile()
    {
        return $this->hasOne(\App\Models\UserProfile::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withTimestamps();
    }

    public function isAdmin(): bool
    {
        if (isset($this->role) && is_string($this->role)) {
            if (strtolower($this->role) === 'admin') {
                return true;
            }
        }

        try {
            $roleRel = $this->role;
            if (is_object($roleRel) && isset($roleRel->name)) {
                return strtolower($roleRel->name) === 'admin';
            }
        } catch (\Throwable $e) {
        }

        return false;
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
            ->withTimestamps()
            ->withPivot('last_read_at', 'muted');
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function unreadConversationsCount(): int
    {
        return DB::table('conversation_user')
            ->join('conversations', 'conversation_user.conversation_id', '=', 'conversations.id')
            ->where('conversation_user.user_id', $this->id)
            ->where(function ($q) {
                $q->whereNull('conversation_user.last_read_at')
                ->orWhereColumn('conversation_user.last_read_at', '<', 'conversations.last_message_at');
            })
            ->count();
    }

    public function socialLinks()
    {
        return $this->hasMany(UserSocialLink::class)->orderBy('order');
    }

    public function scopeWithVisibleSocialLinks($query)
    {
        return $query->with(['socialLinks' => function($q) {
            $q->where('visible', true)->orderBy('order');
        }]);
    }
}
