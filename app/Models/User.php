<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'username',       // Username pengguna
        'role',           // Role pengguna (admin, mahasiswa, dosen)
        'name',           // Nama pengguna
        'email',          // Email pengguna
        'password',       // Password (hashed)
        'prodi',          // Program studi (khusus mahasiswa)
        'mata_kuliah',    // Mata kuliah (khusus dosen, tambahkan jika ada di DB)
        'avatar',         // Path ke avatar (legacy)
        'photo',          // Path ke foto profil user (BARU)
        'email_verified_at', // Email verified timestamp
        'otp_code',       // Kode OTP
        'otp_expired_at', // Waktu OTP kadaluarsa
    ];

    protected $hidden = [
        'password',       // Password disembunyikan
        'remember_token', // Token remember me disembunyikan
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
}