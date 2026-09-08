<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspirasi_id',
        'admin_id',
        'isi_umpan_balik',
        'lampiran',
        'jenis',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}