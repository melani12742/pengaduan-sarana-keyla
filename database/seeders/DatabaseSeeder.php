<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Aspirasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. BUAT USER
        // ============================================

        $admin1 = User::create([
            'name' => 'Admin Keyla',
            'email' => 'admin@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1',
        ]);

        $admin2 = User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Pendidikan No. 1',
        ]);

        // ✅ GUEST 1 — DENGAN NISN & KELAS
        $guest1 = User::create([
            'name' => 'Guest User',
            'email' => 'guest@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'nisn' => '0012345678',
            'kelas' => 'XII IPA 1',
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Guest No. 1',
        ]);

        // ✅ GUEST 2 — DENGAN NISN & KELAS
        $guest2 = User::create([
            'name' => 'Sarah Putri',
            'email' => 'sarah@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'nisn' => '0012345679',
            'kelas' => 'XII IPS 2',
            'no_telepon' => '081234567893',
            'alamat' => 'Jl. Mawar No. 5',
        ]);

        // ✅ GUEST 3 — DENGAN NISN & KELAS
        $guest3 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@keyla.com',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'nisn' => '0012345680',
            'kelas' => 'XI IPA 1',
            'no_telepon' => '081234567894',
            'alamat' => 'Jl. Melati No. 10',
        ]);

        // ============================================
        // 2. BUAT KATEGORI
        // ============================================

        $kategoriData = [
            ['nama_kategori' => 'Sarana Olahraga', 'icon' => 'fa-football'],
            ['nama_kategori' => 'Kelas & Ruang Belajar', 'icon' => 'fa-chalkboard'],
            ['nama_kategori' => 'Toilet & Kebersihan', 'icon' => 'fa-toilet'],
            ['nama_kategori' => 'Laboratorium', 'icon' => 'fa-flask'],
            ['nama_kategori' => 'Perpustakaan', 'icon' => 'fa-book'],
            ['nama_kategori' => 'Kantin', 'icon' => 'fa-utensils'],
            ['nama_kategori' => 'Parkir', 'icon' => 'fa-parking'],
            ['nama_kategori' => 'Lainnya', 'icon' => 'fa-ellipsis-h'],
        ];

        foreach ($kategoriData as $kat) {
            Category::create($kat);
        }

        // ============================================
        // 3. BUAT ASPIRASI — DENGAN NISN & KELAS
        // ============================================

        $aspirasis = [
            [
                'user_id' => $guest1->id,
                'nisn' => $guest1->nisn,
                'kelas' => $guest1->kelas,
                'category_id' => 1,
                'judul' => 'Lapangan Basket Retak',
                'deskripsi' => 'Lapangan basket di bagian timur mengalami retak-retak yang membahayakan siswa saat bermain.',
                'lokasi' => 'Lapangan Basket Timur',
                'status' => 'dalam_perbaikan',
                'prioritas' => 'tinggi',
                'tanggal_selesai' => null,
            ],
            [
                'user_id' => $guest2->id,
                'nisn' => $guest2->nisn,
                'kelas' => $guest2->kelas,
                'category_id' => 2,
                'judul' => 'AC Ruang Kelas X IPA Rusak',
                'deskripsi' => 'AC di ruang kelas X IPA 1 tidak berfungsi dengan baik, suhu ruangan sangat panas.',
                'lokasi' => 'Ruang X IPA 1',
                'status' => 'menunggu',
                'prioritas' => 'sedang',
                'tanggal_selesai' => null,
            ],
            [
                'user_id' => $guest1->id,
                'nisn' => $guest1->nisn,
                'kelas' => $guest1->kelas,
                'category_id' => 3,
                'judul' => 'Toilet Lantai 2 Tidak Ada Air',
                'deskripsi' => 'Toilet di lantai 2 gedung utama tidak ada air mengalir sejak 3 hari lalu.',
                'lokasi' => 'Toilet Lantai 2',
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'tanggal_selesai' => now(),
            ],
            [
                'user_id' => $guest3->id,
                'nisn' => $guest3->nisn,
                'kelas' => $guest3->kelas,
                'category_id' => 4,
                'judul' => 'Mikroskop Rusak',
                'deskripsi' => '3 unit mikroskop di laboratorium biologi tidak bisa digunakan karena lensanya pecah.',
                'lokasi' => 'Lab Biologi',
                'status' => 'menunggu',
                'prioritas' => 'sedang',
                'tanggal_selesai' => null,
            ],
            [
                'user_id' => $guest3->id,
                'nisn' => $guest3->nisn,
                'kelas' => $guest3->kelas,
                'category_id' => 5,
                'judul' => 'Buku Hilang di Perpustakaan',
                'deskripsi' => 'Beberapa buku referensi hilang dari rak perpustakaan. Mohon dilakukan inventarisasi ulang.',
                'lokasi' => 'Perpustakaan Lantai 1',
                'status' => 'dalam_perbaikan',
                'prioritas' => 'rendah',
                'tanggal_selesai' => null,
            ],
        ];

        foreach ($aspirasis as $data) {
            Aspirasi::create($data);
        }

        // ============================================
        // 4. INFORMASI
        // ============================================

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📊 Total Users: ' . User::count());
        $this->command->info('📂 Total Categories: ' . Category::count());
        $this->command->info('📝 Total Aspirasis: ' . Aspirasi::count());
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('   Admin 1: admin@keyla.com / password123');
        $this->command->info('   Admin 2: admin@sekolah.com / password');
        $this->command->info('   Guest 1: guest@keyla.com / password123');
        $this->command->info('   Guest 2: sarah@keyla.com / password123');
        $this->command->info('   Guest 3: budi@keyla.com / password123');
    }
}