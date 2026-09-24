<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',        // ✅ TAMBAH
        'kelas',       // ✅ TAMBAH
        'no_telepon',
        'alamat',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class, 'admin_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }
}