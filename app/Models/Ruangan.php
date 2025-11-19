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

    public function isAvailableForRegular($hari, $sesi)
    {
        return !$this->jadwalRegulers()
            ->where('hari', $hari)
            ->where('sesi', $sesi)
            ->exists();
    }

    public function isAvailableForBooking($tanggal, $sesi)
    {
        // Cek bentrok dengan jadwal reguler
        $hari = \Carbon\Carbon::parse($tanggal)->isoFormat('dddd');
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        
        $hari = $hariIndonesia[$hari] ?? null;
        
        if ($hari === null || $hari === 'Sabtu' || $hari === 'Minggu') {
            return false; // Tidak ada jadwal reguler di akhir pekan
        }
        
        if ($this->jadwalRegulers()->where('hari', $hari)->where('sesi', $sesi)->exists()) {
            return false;
        }
        
        // Cek bentrok dengan peminjaman lain yang disetujui
        return !$this->peminjamans()
            ->where('status', 'disetujui')
            ->where('tanggal', $tanggal)
            ->where('sesi', $sesi)
            ->exists();
    }
}