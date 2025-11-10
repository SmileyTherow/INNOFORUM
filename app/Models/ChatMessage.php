<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $table = 'chat_messages'; // gunakan tabel chat_messages agar tidak bentrok dengan admin 'messages'

    protected $fillable = ['conversation_id', 'sender_id', 'body', 'attachment', 'attachment_type', 'metadata'];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Conversation relasi
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Sender relasi (User)
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Helper untuk mendapatkan URL attachment (jika ada)
     */
    public function attachmentUrl(): ?string
    {
        return $this->attachment ? asset('storage/'.$this->attachment) : null;
    }
}
