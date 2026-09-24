<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'aspirasi_id',
        'user_id',
        'comment',
        'is_anonymous',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonim';
        }
        return $this->user->name ?? 'Unknown';
    }
}