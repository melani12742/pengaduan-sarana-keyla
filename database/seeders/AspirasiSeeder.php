<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspirasi;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class AspirasiSeeder extends Seeder
{
    public function run()
    {
        // Ambil user student (role = student)
        $students = User::where('role', 'student')->get();

        // Jika tidak ada student, buat dulu
        if ($students->isEmpty()) {
            $students = User::factory()->count(3)->create(['role' => 'student']);
        }

        // Ambil semua kategori
        $categories = Category::all();

        // Jika tidak ada kategori, buat default
        if ($categories->isEmpty()) {
            $categories = Category::create([
                ['name' => 'Fasilitas Kelas', 'description' => 'Sarana dan prasarana di dalam kelas'],
                ['name' => 'Fasilitas Lab', 'description' => 'Fasilitas laboratorium'],
                ['name' => 'Fasilitas Umum', 'description' => 'Kamar mandi, kantin, mushola'],
                ['name' => 'Kebersihan', 'description' => 'Kebersihan lingkungan sekolah'],
                ['name' => 'Keamanan', 'description' => 'Keamanan sekolah'],
            ]);
        }

        // Data aspirasi contoh
        $aspirasis = [
            [
                'title' => 'AC Kelas Rusak',
                'description' => 'AC di kelas XII IPA 1 tidak berfungsi dengan baik. Suhu ruangan sangat panas dan mengganggu proses belajar mengajar.',
                'status' => 'pending',
                'priority' => 'high',
            ],
            [
                'title' => 'Kursi Belajar Rusak',
                'description' => 'Terdapat 5 kursi di kelas XI IPS 2 yang kakinya patah dan tidak layak pakai. Mohon segera diperbaiki.',
                'status' => 'processing',
                'priority' => 'medium',
            ],
            [
                'title' => 'Lampu Ruang Lab Mati',
                'description' => 'Beberapa lampu di laboratorium komputer mati, sehingga ruangan menjadi gelap dan mengganggu praktikum.',
                'status' => 'completed',
                'priority' => 'medium',
            ],
            [
                'title' => 'Toilet Lantai 3 Bocor',
                'description' => 'Toilet di lantai 3 mengalami kebocoran air sejak 3 hari lalu. Air menggenang dan menyebabkan bau tidak sedap.',
                'status' => 'pending',
                'priority' => 'urgent',
            ],
            [
                'title' => 'Pagar Sekolah Rusak',
                'description' => 'Pagar bagian belakang sekolah mengalami kerusakan dan memungkinkan orang luar masuk dengan mudah. Khawatir akan keamanan.',
                'status' => 'processing',
                'priority' => 'high',
            ],
            [
                'title' => 'Proyektor Rusak',
                'description' => 'Proyektor di ruang multimedia tidak dapat menampilkan gambar dengan jelas. Sudah 2 minggu tidak bisa digunakan.',
                'status' => 'rejected',
                'priority' => 'medium',
            ],
            [
                'title' => 'Kebersihan Kantin',
                'description' => 'Kantin sekolah terlihat kotor dan tidak terawat. Banyak sampah berserakan di area makan.',
                'status' => 'completed',
                'priority' => 'low',
            ],
            [
                'title' => 'Papan Tulis Rusak',
                'description' => 'Papan tulis di kelas X MIPA 1 sudah usang dan tidak bisa digunakan untuk menulis dengan baik. Permukaannya sudah licin.',
                'status' => 'pending',
                'priority' => 'medium',
            ],
            [
                'title' => 'WiFi Sekolah Lemot',
                'description' => 'Jaringan WiFi di area sekolah sangat lambat, terutama saat jam istirahat. Sulit mengakses internet untuk belajar.',
                'status' => 'processing',
                'priority' => 'high',
            ],
            [
                'title' => 'Pohon Tumbang',
                'description' => 'Ada pohon besar di dekat lapangan olahraga yang sudah rapuh dan khawatir tumbang. Mohon segera ditebang.',
                'status' => 'pending',
                'priority' => 'urgent',
            ],
            [
                'title' => 'Pintu Kelas Rusak',
                'description' => 'Pintu kelas XII IPS 1 tidak bisa ditutup dengan baik. Engsel pintu sudah longgar dan mengganggu kenyamanan.',
                'status' => 'processing',
                'priority' => 'medium',
            ],
            [
                'title' => 'Air Keran Mati',
                'description' => 'Air keran di beberapa titik di sekolah tidak mengalir. Siswa kesulitan untuk mengambil air minum.',
                'status' => 'completed',
                'priority' => 'high',
            ],
        ];

        // Loop untuk membuat data
        foreach ($aspirasis as $index => $data) {
            // Pilih student secara bergantian
            $student = $students[$index % count($students)];

            // Pilih kategori secara acak
            $category = $categories->random();

            // Buat tanggal acak (30 hari terakhir)
            $dateReport = Carbon::now()->subDays(rand(1, 30));

            Aspirasi::create([
                'user_id' => $student->id,
                'category_id' => $category->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'date_report' => $dateReport,
                'attachment' => null,
                'created_at' => $dateReport,
                'updated_at' => $dateReport,
            ]);
        }

        // Tambahkan beberapa aspirasi dengan user spesifik
        $keyla = User::where('email', 'keyla@student.com')->first();
        if ($keyla) {
            $category = Category::where('name', 'Fasilitas Kelas')->first();
            Aspirasi::create([
                'user_id' => $keyla->id,
                'category_id' => $category ? $category->id : $categories->first()->id,
                'title' => 'Aspirasi dari Keyla: Meja Belajar Rusak',
                'description' => 'Meja belajar di kelas saya banyak yang goyang dan tidak stabil. Sulit untuk menulis dengan nyaman.',
                'status' => 'pending',
                'priority' => 'medium',
                'date_report' => Carbon::now()->subDays(2),
                'attachment' => null,
            ]);

            Aspirasi::create([
                'user_id' => $keyla->id,
                'category_id' => $categories->where('name', 'Kebersihan')->first()->id ?? $categories->first()->id,
                'title' => 'Aspirasi dari Keyla: Sampah Menumpuk',
                'description' => 'Tempat sampah di belakang kelas sudah penuh dan tidak diangkut selama 3 hari. Bau tidak sedap mulai tercium.',
                'status' => 'processing',
                'priority' => 'high',
                'date_report' => Carbon::now()->subDays(5),
                'attachment' => null,
            ]);
        }
    }
}