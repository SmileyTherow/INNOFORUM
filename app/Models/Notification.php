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

    public function getCleanMessageAttribute()
    {
        $data = $this->data;

        // decode jika string JSON
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if ($decoded !== null) $data = $decoded;
        }

        if (
            isset($data['type']) && $data['type'] === 'private_message' &&
            !empty($data['message']) &&
            is_array($data['message']) &&
            !empty($data['message']['sender']['name']) &&
            !empty($data['message']['body'])
        ) {
            return $data['message']['sender']['name'] . ': ' . $data['message']['body'];
        }

        // Prioritas ambil teks:
        // 1) data['message']['body'] (payload private_message)
        // 2) data['text'] (kadang dipakai)
        // 3) data['message'] (string)
        // 4) data['message']['message'] (nested)
        // 5) data['message'] (jika string)
        // 6) data['reply_body'] / data['body']
        // 7) fallback: excerpt/title/gabungan
        $text = '';

        if (is_array($data)) {
            if (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['body'])) {
                $text = $data['message']['body'];
            } elseif (!empty($data['text']) && is_string($data['text'])) {
                $text = $data['text'];
            } elseif (!empty($data['message']) && is_string($data['message'])) {
                $text = $data['message'];
            } elseif (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['message'])) {
                $text = $data['message']['message'];
            } elseif (!empty($data['body']) && is_string($data['body'])) {
                $text = $data['body'];
            } elseif (!empty($data['reply_body']) && is_string($data['reply_body'])) {
                $text = $data['reply_body'];
            } elseif (!empty($data['excerpt']) && is_string($data['excerpt'])) {
                $text = $data['excerpt'];
            } elseif (!empty($data['title']) && is_string($data['title'])) {
                $text = $data['title'];
            } else {
                // fallback: cari first string field
                foreach ($data as $k => $v) {
                    if (is_string($v)) {
                        $text = $v;
                        break;
                    }
                    if (is_array($v) && !empty($v['body']) && is_string($v['body'])) {
                        $text = $v['body'];
                        break;
                    }
                }
                if (!$text) $text = json_encode($data);
            }
        } else {
            $text = (string) ($data ?? '');
        }

        return trim($text);
    }

    public function getIsFromAdminAttribute()
    {
        if ($this->type && stripos($this->type, 'admin') !== false) return true;

        $data = $this->data;
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if ($decoded !== null) $data = $decoded;
        }

        if (is_array($data)) {
            if (!empty($data['from_admin']) || !empty($data['is_admin'])) return true;
            if (!empty($data['from']) && strtolower($data['from']) === 'admin') return true;
            if (!empty($data['sender']) && (is_string($data['sender']) && strtolower($data['sender']) === 'admin')) return true;
            // jika sender adalah object seperti ['sender' => ['id' => .., 'name' => 'Admin']]
            if (
                !empty($data['sender']) && is_array($data['sender']) && !empty($data['sender']['name']) &&
                strtolower($data['sender']['name']) === 'admin'
            ) return true;
        }

        return false;
    }

    public function getLinkAttribute()
    {
        $data = $this->data;
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if ($decoded !== null) $data = $decoded;
        }

        if (!is_array($data)) return null;

        // jika ada explicit link dari backend, gunakan
        if (!empty($data['link']) && is_string($data['link'])) return $data['link'];

        // 1) private message -> conversation_id atau message.conversation_id
        if (!empty($data['conversation_id'])) {
            try {
                return route('pesan.index') . '?conv=' . $data['conversation_id'];
            } catch (\Exception $e) {
            }
        }
        if (!empty($data['message']) && is_array($data['message']) && !empty($data['message']['conversation_id'])) {
            try {
                return route('pesan.index') . '?conv=' . $data['message']['conversation_id'];
            } catch (\Exception $e) {
            }
        }

        // 2) jika ada message_id (mis. admin messages), link ke admin/messages untuk admin, ke inbox untuk user
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

        // 3) komentar / reply di thread -> thread + anchor
        if (!empty($data['thread_id']) && !empty($data['comment_id'])) {
            try {
                return route('questions.show', $data['thread_id']) . '#comment-' . $data['comment_id'];
            } catch (\Exception $e) {
            }
        }
        // 4) jawaban / reply -> thread + anchor answer-
        if (!empty($data['thread_id']) && !empty($data['answer_id'])) {
            try {
                return route('questions.show', $data['thread_id']) . '#answer-' . $data['answer_id'];
            } catch (\Exception $e) {
            }
        }
        // 5) hanya thread -> link ke thread
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
