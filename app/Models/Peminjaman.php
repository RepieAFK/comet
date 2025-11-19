<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // Pastikan ini benar (dengan 's')

    protected $fillable = [
        'user_id',
        'ruangan_id',
        'tanggal',
        'sesi',
        'keperluan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    // Helper untuk mendapatkan nama sesi
    public function getSesiNameAttribute()
    {
        $sesiStart = (7 * 60) + ($this->sesi - 1) * 45; // Menit dari 07:00
        $jam = floor($sesiStart / 60);
        $menit = $sesiStart % 60;
        return sprintf('%02d:%02d - %02d:%02d', $jam, $menit, $jam, $menit + 45);
    }
}