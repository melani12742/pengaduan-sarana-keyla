<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'nama_kategori',
        'icon',
    ];

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'category_id');
    }
}