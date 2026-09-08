<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class);
    }

    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class, 'admin_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuest()
    {
        return $this->role === 'guest' || $this->role === 'user';
    }
}