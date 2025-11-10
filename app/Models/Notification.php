<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function getCleanMessageAttribute()
    {
        $data = $this->data;
        
        // Jika data adalah string JSON, decode
        if (is_string($data) && json_decode($data) !== null) {
            $data = json_decode($data, true);
        }
        
        // Handle berbagai format data
        if (is_array($data)) {
            // Format 1: Private message (seperti di screenshot)
            if (isset($data['type']) && $data['type'] === 'private_message' && isset($data['message'])) {
                $messageData = $data['message'];
                if (isset($messageData['sender']['name']) && isset($messageData['body'])) {
                    return $messageData['sender']['name'] . ': ' . $messageData['body'];
                }
            }
            
            // Format 2: Direct chat message
            if (isset($data['body']) && isset($data['sender']['name'])) {
                return $data['sender']['name'] . ': ' . $data['body'];
            }
            
            // Format 3: Data dengan field message langsung
            if (isset($data['message']) && is_string($data['message'])) {
                return $data['message'];
            }
            
            // Format 4: Data dengan excerpt
            if (isset($data['excerpt']) && is_string($data['excerpt'])) {
                return $data['excerpt'];
            }
            
            // Format 5: Data dengan title
            if (isset($data['title']) && is_string($data['title'])) {
                return $data['title'];
            }
            
            // Fallback: tampilkan type atau default
            return $data['type'] ?? 'Pesan baru';
        }
        
        // Jika data adalah string biasa
        if (is_string($data)) {
            return $data;
        }
        
        return 'Notifikasi baru';
    }

    // Untuk dropdown dengan limit
    public function getShortMessageAttribute()
    {
        return \Illuminate\Support\Str::limit($this->clean_message, 80);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}