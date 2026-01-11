<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;

class Conversation extends Model
{
    protected $fillable = [
        'is_group',
        'user_a_id',
        'user_b_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'conversation_user')
            ->withTimestamps()
            ->withPivot('last_read_at', 'muted');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class)->latest('created_at');
    }

    public static function findOrCreateOneOnOne(int $a, int $b): self
    {
        // Pastikan tidak membuat percakapan dengan diri sendiri
        if ($a === $b) {
            abort(400, 'Cannot create conversation with yourself.');
        }

        [$userA, $userB] = $a < $b ? [$a, $b] : [$b, $a];

        return DB::transaction(function () use ($userA, $userB) {
            $conversation = self::where('user_a_id', $userA)
                ->where('user_b_id', $userB)
                ->first();

            if ($conversation) {
                return $conversation;
            }

            $conversation = self::create([
                'is_group' => false,
                'user_a_id' => $userA,
                'user_b_id' => $userB,
            ]);

            $conversation->users()->attach([$userA, $userB]);
            return $conversation;
        });
    }
}
