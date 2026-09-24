<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fasilitas Kelas', 'description' => 'Sarana dan prasarana di dalam kelas'],
            ['name' => 'Fasilitas Lab', 'description' => 'Fasilitas laboratorium komputer dan praktikum'],
            ['name' => 'Fasilitas Umum', 'description' => 'Kamar mandi, kantin, mushola, dll'],
            ['name' => 'Kebersihan', 'description' => 'Masalah terkait kebersihan lingkungan sekolah'],
            ['name' => 'Keamanan', 'description' => 'Masalah terkait keamanan sekolah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}