<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    protected function decodedData(): array
    {
        $data = $this->data;

        if (is_array($data)) {
            return $data;
        }

        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return ['raw' => $data];
        }

        return [];
    }

    public function getCleanMessageAttribute()
    {
        $data = $this->decodedData();

        // 1) jika tipe explicit private_message
        if (
            (isset($data['type']) && $data['type'] === 'private_message') ||
            (isset($data['message']) && is_array($data['message']) && (isset($data['message']['type']) && $data['message']['type'] === 'private_message'))
        ) {
            $message = is_array($data['message']) ? $data['message'] : [];
            $senderName = null;
            if (!empty($message['sender'])) {
                if (is_string($message['sender'])) {
                    $senderName = $message['sender'];
                } elseif (is_array($message['sender']) && !empty($message['sender']['name'])) {
                    $senderName = $message['sender']['name'];
                }
            } elseif (!empty($data['sender'])) {
                if (is_string($data['sender'])) $senderName = $data['sender'];
                elseif (is_array($data['sender']) && !empty($data['sender']['name'])) $senderName = $data['sender']['name'];
            }

            $body = null;
            if (!empty($message['body']) && is_string($message['body'])) {
                $body = $message['body'];
            } elseif (!empty($data['body']) && is_string($data['body'])) {
                $body = $data['body'];
            } elseif (!empty($message['message']) && is_string($message['message'])) {
                $body = $message['message'];
            }

            if ($senderName && $body) {
                return trim($senderName . ': ' . $body);
            } elseif ($body) {
                return trim($body);
            }
        }

        // 2) prioritas umum untuk teks
        if (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['body'])) {
            return trim($data['message']['body']);
        }
        if (!empty($data['text']) && is_string($data['text'])) {
            return trim($data['text']);
        }
        if (!empty($data['message']) && is_string($data['message'])) {
            return trim($data['message']);
        }
        if (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['message'])) {
            return trim($data['message']['message']);
        }
        if (!empty($data['body']) && is_string($data['body'])) {
            return trim($data['body']);
        }
        if (!empty($data['reply_body']) && is_string($data['reply_body'])) {
            return trim($data['reply_body']);
        }
        if (!empty($data['excerpt']) && is_string($data['excerpt'])) {
            return trim($data['excerpt']);
        }
        if (!empty($data['title']) && is_string($data['title'])) {
            return trim($data['title']);
        }

        // 3) cari first string field dalam data
        foreach ($data as $k => $v) {
            if (is_string($v) && $v !== '') {
                return trim($v);
            }
            if (is_array($v) && !empty($v['body']) && is_string($v['body'])) {
                return trim($v['body']);
            }
            if (is_array($v) && !empty($v['message']) && is_string($v['message'])) {
                return trim($v['message']);
            }
        }

        // 4) fallback: jika ada raw
        if (!empty($data['raw']) && is_string($data['raw'])) {
            return trim($data['raw']);
        }

        // 5) jika tidak ada apa-apa, kembalikan default
        return 'Notifikasi baru';
    }

    public function getSafeMessageAttribute()
    {
        $text = $this->clean_message ?? null;

        if (is_array($text)) {
            // encode minimal jika masih array
            $text = json_encode($text);
        }

        if ($text === null || $text === '') {
            $text = 'Notifikasi baru';
        }

        return (string) $text;
    }

    public function getIsFromAdminAttribute()
    {
        if ($this->type && stripos($this->type, 'admin') !== false) return true;

        $data = $this->decodedData();

        if (!empty($data['from_admin']) || !empty($data['is_admin'])) return true;
        if (!empty($data['from']) && strtolower((string)$data['from']) === 'admin') return true;
        if (!empty($data['sender']) && (is_string($data['sender']) && strtolower($data['sender']) === 'admin')) return true;
        if (!empty($data['sender']) && is_array($data['sender']) && !empty($data['sender']['name']) && strtolower($data['sender']['name']) === 'admin') return true;

        return false;
    }

    public function getLinkAttribute()
    {
        $data = $this->decodedData();

        if (!is_array($data)) return null;

        if (!empty($data['link']) && is_string($data['link'])) return $data['link'];

        if (!empty($data['conversation_id'])) {
            try {
                return route('pesan.index') . '?conv=' . $data['conversation_id'];
            } catch (\Exception $e) {
                // fallback
            }
        }
        if (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['conversation_id'])) {
            try {
                return route('pesan.index') . '?conv=' . $data['message']['conversation_id'];
            } catch (\Exception $e) {
            }
        }

        if (!empty($data['message_id'])) {
            try {
                if (Auth::check() && Auth::user()->role === 'admin') {
                    return route('admin.messages.show', $data['message_id']);
                } else {
                    return route('pesan.index') . '?msg=' . $data['message_id'];
                }
            } catch (\Exception $e) {
            }
        }

        if (!empty($data['thread_id']) && !empty($data['comment_id'])) {
            try {
                return route('questions.show', $data['thread_id']) . '#comment-' . $data['comment_id'];
            } catch (\Exception $e) {
            }
        }
        if (!empty($data['thread_id']) && !empty($data['answer_id'])) {
            try {
                return route('questions.show', $data['thread_id']) . '#answer-' . $data['answer_id'];
            } catch (\Exception $e) {
            }
        }
        if (!empty($data['thread_id'])) {
            try {
                return route('questions.show', $data['thread_id']);
            } catch (\Exception $e) {
            }
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
