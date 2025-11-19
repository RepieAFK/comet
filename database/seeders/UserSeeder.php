<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrator
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
            'nomor_induk' => 'ADMIN001',
            'telepon' => '08123456789',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas Ruangan',
            'email' => 'petugas@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'nomor_induk' => 'PETUGAS001',
            'telepon' => '08123456788',
        ]);

        // Peminjam
        User::create([
            'name' => 'Siswa Peminjam',
            'email' => 'siswa@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'nomor_induk' => 'SISWA001',
            'telepon' => '08123456790',
        ]);
    }
}
