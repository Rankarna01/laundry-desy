<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'), // passwordnya 'password'
            'role' => 'admin',
        ]);

        // 2. Akun Karyawan
        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        // 3. Akun Pelanggan/Pengguna
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'user@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'pengguna',
        ]);
    }
}
