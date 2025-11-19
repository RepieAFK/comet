<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\JadwalReguler; // Tambahkan ini
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
            'nomor_induk' => 'ADMIN001',
            'telepon' => '08123456789',
        ]);

        // Create Petugas
        User::create([
            'name' => 'Petugas Ruangan',
            'email' => 'petugas@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'nomor_induk' => 'PETUGAS001',
            'telepon' => '08123456788',
        ]);

        // Create Peminjam
        User::create([
            'name' => 'Siswa Peminjam',
            'email' => 'siswa@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'nomor_induk' => 'SISWA001',
            'telepon' => '08123456787',
        ]);

        // Create Ruangan
        $ruangans = [
            [
                'nama_ruangan' => 'Lab Komputer 1',
                'kode_ruangan' => 'LAB001',
                'deskripsi' => 'Laboratorium komputer dengan 30 unit PC',
                'kapasitas' => 30,
                'lokasi' => 'Gedung A Lantai 2',
                'status' => 'tersedia',
            ],
            [
                'nama_ruangan' => 'Ruang Meeting 1',
                'kode_ruangan' => 'RM001',
                'deskripsi' => 'Ruang meeting dengan proyektor dan AC',
                'kapasitas' => 15,
                'lokasi' => 'Gedung B Lantai 1',
                'status' => 'tersedia',
            ],
            [
                'nama_ruangan' => 'Aula Besar',
                'kode_ruangan' => 'AULA001',
                'deskripsi' => 'Aula untuk acara besar dengan kapasitas 200 orang',
                'kapasitas' => 200,
                'lokasi' => 'Gedung Utama Lantai 3',
                'status' => 'tersedia',
            ],
            [
                'nama_ruangan' => 'Ruang Kelas 101',
                'kode_ruangan' => 'RK101',
                'deskripsi' => 'Ruang kelas standar dengan 40 kursi',
                'kapasitas' => 40,
                'lokasi' => 'Gedung C Lantai 1',
                'status' => 'tersedia',
            ],
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }

        // Contoh Jadwal Reguler
        JadwalReguler::create([
            'ruangan_id' => 1, // Lab Komputer 1
            'hari' => 'Senin',
            'sesi' => 1,
            'kegiatan' => 'Algoritma Pemrograman',
            'user_id' => 1, // Admin
        ]);

        JadwalReguler::create([
            'ruangan_id' => 2, // Ruang Meeting 1
            'hari' => 'Rabu',
            'sesi' => 5,
            'kegiatan' => 'Rapat Koordinasi Proyek',
            'user_id' => 1, // Admin
        ]);
    }
}