<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    protected $fillable = ['aspirasi_id', 'user_id'];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}