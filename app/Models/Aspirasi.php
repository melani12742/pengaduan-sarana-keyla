<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasis';

    protected $fillable = [
        'user_id',
        'nisn',          // ✅ TAMBAH
        'kelas',         // ✅ TAMBAH
        'category_id',
        'judul',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'prioritas',
        'is_anonymous',
        'upvotes_count',
        'tanggal_aspirasi',
        'tanggal_selesai',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'tanggal_aspirasi' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // ============================================
    // RELASI
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    public function umpanBalik()
    {
        return $this->hasMany(UmpanBalik::class)->orderBy('created_at', 'asc');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ============================================
    // ACCESSOR
    // ============================================

    /**
     * Nama tampilan: Anonim atau Nama User
     */
    public function getDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonim';
        }
        return $this->user->name ?? 'Unknown';
    }

    /**
     * URL Foto
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    /**
     * Badge Status
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'warning',
            'ditinjau' => 'info',
            'dalam_perbaikan' => 'primary',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    /**
     * Label Status
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'menunggu' => 'Menunggu',
            'ditinjau' => 'Ditinjau',
            'dalam_perbaikan' => 'Dalam Perbaikan',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    // ============================================
    // ✅ ACCESSOR BARU UNTUK NISN & KELAS
    // ============================================

    /**
     * NISN (dari aspirasi atau user)
     */
    public function getNisnDisplayAttribute()
    {
        return $this->nisn ?? $this->user->nisn ?? '-';
    }

    /**
     * Kelas (dari aspirasi atau user)
     */
    public function getKelasDisplayAttribute()
    {
        return $this->kelas ?? $this->user->kelas ?? '-';
    }

    /**
     * Info Pelapor lengkap (Nama, NISN, Kelas)
     * Jika anonim, tetap tampilkan NISN & Kelas untuk admin
     */
    public function getPelaporInfoAttribute()
    {
        if ($this->is_anonymous) {
            return [
                'nama' => 'Anonim',
                'nisn' => $this->nisn ?? $this->user->nisn ?? '-',
                'kelas' => $this->kelas ?? $this->user->kelas ?? '-',
            ];
        }

        return [
            'nama' => $this->user->name ?? 'Unknown',
            'nisn' => $this->nisn ?? $this->user->nisn ?? '-',
            'kelas' => $this->kelas ?? $this->user->kelas ?? '-',
        ];
    }
}