<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'prioritas',
        'tanggal_aspirasi',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_aspirasi' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function umpanBalik()
    {
        return $this->hasOne(UmpanBalik::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'proses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'proses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }
}