<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruangan',
        'kode_ruangan',
        'deskripsi',
        'kapasitas',
        'lokasi',
        'status',
        'foto',
    ];

    public function peminjamans()
{
    return $this->hasMany(Peminjaman::class);
}

public function jadwalRegulers()
{
    return $this->hasMany(JadwalReguler::class);
}

    // Cek ketersediaan untuk jadwal reguler
    public function isAvailableForRegular($hari, $sesi)
    {
        return !$this->jadwalRegulers()
            ->where('hari', $hari)
            ->where('sesi', $sesi)
            ->exists();
    }

    // Cek ketersediaan untuk peminjaman
    public function isAvailableForBooking($tanggal, $sesi)
{
    // Cek bentrok jadwal reguler
    $hari = \Carbon\Carbon::parse($tanggal)->translatedFormat('l');

    $hariMap = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
    ];

    $hariIndo = $hariMap[$hari] ?? null;

    $bentrokReguler = $this->jadwalRegulers()
        ->where('hari', $hariIndo)
        ->where('sesi', $sesi)
        ->exists();

    if ($bentrokReguler) {
        return false;
    }

    // Cek bentrok peminjaman lain
    $bentrokPinjam = $this->peminjamans()
        ->where('tanggal', $tanggal)
        ->where('sesi', $sesi)   // <── WAJIB ADA!
        ->where('status', 'disetujui')
        ->exists();

    if ($bentrokPinjam) {
        return false;
    }

    return true;
}
}