<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada
        $admin = User::where('email', 'admin@sekolah.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Pendidikan No. 1',
            ]);

            $this->command->info('✅ Admin created: admin@sekolah.com / password');
        } else {
            $this->command->info('ℹ️ Admin already exists');
        }
    }
}