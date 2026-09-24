<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Student
        User::create([
            'name' => 'Keyla Putri',
            'email' => 'keyla@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}