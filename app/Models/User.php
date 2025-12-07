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
        'point',
        'points',
        'answer_points',
        'like_points',
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
        'point' => 'integer',
        'points' => 'integer',
        'answer_point' => 'integer',
        'answer_points' => 'integer',
        'like_point' => 'integer',
        'like_points' => 'integer',
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
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

    public function getTotalLikesAttribute()
    {
        $userId = $this->id;

        $questionLikes = DB::table('question_likes')
            ->join('questions', 'questions.id', '=', 'question_likes.question_id')
            ->where('questions.user_id', $userId)
            ->count();

        $commentLikes = DB::table('comment_likes')
            ->join('comments', 'comments.id', '=', 'comment_likes.comment_id')
            ->where('comments.user_id', $userId)
            ->count();

        return $questionLikes + $commentLikes;
    }

    /* Helper: apakah user aktif */
    public function isActive(): bool
    {
        return (bool) ($this->is_active ?? true);
    }

    /* Scope untuk query user aktif */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
