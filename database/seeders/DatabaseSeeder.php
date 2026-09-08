<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Aspirasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        $admin = User::create([
            'name' => 'Admin Keyla',
            'email' => 'admin@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1',
        ]);

        // Buat Guest/User
        $guest1 = User::create([
            'name' => 'Guest User',
            'email' => 'guest@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Guest No. 1',
        ]);

        $guest2 = User::create([
            'name' => 'Sarah Putri',
            'email' => 'sarah@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Mawar No. 5',
        ]);

        // Buat Kategori
        $kategori = [
            ['nama_kategori' => 'Sarana Olahraga', 'icon' => 'fa-football'],
            ['nama_kategori' => 'Kelas & Ruang Belajar', 'icon' => 'fa-chalkboard'],
            ['nama_kategori' => 'Toilet & Kebersihan', 'icon' => 'fa-toilet'],
            ['nama_kategori' => 'Laboratorium', 'icon' => 'fa-flask'],
            ['nama_kategori' => 'Perpustakaan', 'icon' => 'fa-book'],
            ['nama_kategori' => 'Kantin', 'icon' => 'fa-utensils'],
            ['nama_kategori' => 'Parkir', 'icon' => 'fa-parking'],
            ['nama_kategori' => 'Lainnya', 'icon' => 'fa-ellipsis-h'],
        ];

        foreach ($kategori as $kat) {
            Kategori::create($kat);
        }

        // Buat Aspirasi contoh
        Aspirasi::create([
            'user_id' => $guest1->id,
            'kategori_id' => 1,
            'judul' => 'Lapangan Basket Retak',
            'deskripsi' => 'Lapangan basket di bagian timur mengalami retak-retak yang membahayakan siswa saat bermain.',
            'lokasi' => 'Lapangan Basket Timur',
            'status' => 'proses',
            'prioritas' => 'tinggi',
        ]);

        Aspirasi::create([
            'user_id' => $guest2->id,
            'kategori_id' => 2,
            'judul' => 'AC Ruang Kelas X IPA Rusak',
            'deskripsi' => 'AC di ruang kelas X IPA 1 tidak berfungsi dengan baik, suhu ruangan sangat panas.',
            'lokasi' => 'Ruang X IPA 1',
            'status' => 'pending',
            'prioritas' => 'sedang',
        ]);

        Aspirasi::create([
            'user_id' => $guest1->id,
            'kategori_id' => 3,
            'judul' => 'Toilet Lantai 2 Tidak Ada Air',
            'deskripsi' => 'Toilet di lantai 2 gedung utama tidak ada air mengalir sejak 3 hari lalu.',
            'lokasi' => 'Toilet Lantai 2',
            'status' => 'selesai',
            'prioritas' => 'tinggi',
            'tanggal_selesai' => now(),
        ]);
    }
}