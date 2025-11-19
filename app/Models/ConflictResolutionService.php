<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\JadwalReguler;
use App\Models\Peminjaman;

class ConflictResolutionService
{
    /**
     * Memeriksa apakah ada bentrok jadwal untuk ruangan tertentu pada hari dan waktu tertentu
     */
    public function checkConflict($ruangan_id, $hari, $sesi_mulai, $sesi_selesai, $excludePeminjamanId = null)
    {
        // Cek bentrok dengan jadwal reguler
        $conflictReguler = JadwalReguler::where('ruangan_id', $ruangan_id)
            ->where('hari', $hari)
            ->where('status', 'Aktif')
            ->where(function($query) use ($sesi_mulai, $sesi_selesai) {
                $query->where(function($q) use ($sesi_mulai, $sesi_selesai) {
                    $q->whereBetween('sesi_mulai', [$sesi_mulai, $sesi_selesai])
                          ->orWhereBetween('sesi_selesai', [$sesi_mulai, $sesi_selesai])
                          ->orWhere(function($q) use ($sesi_mulai, $sesi_selesai) {
                              $q->where('sesi_mulai', '<=', $sesi_mulai)
                                ->where('sesi_selesai', '>=', $sesi_selesai);
                          });
                });
            })
            ->exists();

        if ($conflictReguler) {
            return [
                'conflict' => true,
                'type' => 'jadwal_reguler',
                'message' => 'Ruangan sudah ada jadwal reguler pada waktu tersebut.',
                'data' => $conflictReguler->first()
            ];
        }

        // Cek bentrok dengan peminjaman lain
        $conflictPeminjaman = Peminjaman::where('ruangan_id', $ruangan_id)
            ->where('status', 'disetujui')
            ->where(function($query) use ($sesi_mulai, $sesi_selesai) {
                $query->whereBetween('waktu_mulai', [$sesi_mulai, $sesi_selesai])
                      ->orWhereBetween('waktu_selesai', [$sesi_mulai, $sesi_selesai])
                      ->orWhere(function($q) use ($sesi_mulai, $sesi_selesai) {
                          $q->where('waktu_mulai', '<=', $sesi_mulai)
                            ->where('waktu_selesai', '>=', $sesi_selesai);
                      });
            })
            ->where('id', '!=', $excludePeminjamanId)
            ->exists();

        if ($conflictPeminjaman) {
            return [
                'conflict' => true,
                'type' => 'peminjaman',
                'message' => 'Ruangan sudah dipinjam pada waktu tersebut.',
                'data' => $conflictPeminjaman->first()
            ];
        }

        // Cek bentrok dengan peminjaman yang sudah disetujui
        $conflictDisetujui = Peminjaman::where('ruangan_id', $ruangan_id)
            ->where('status', 'disetujui')
            ->where(function($query) use ($sesi_mulai, $sesi_selesai) {
                $query->whereBetween('waktu_mulai', [$sesi_mulai, $sesi_selesai])
                      ->orWhereBetween('waktu_selesai', [$sesi_mulai, $sesi_selesai])
                      ->orWhere(function($q) use ($sesi_mulai, $sesi_selesai) {
                          $q->where('waktu_mulai', '<=', $sesi_mulai)
                            ->where('waktu_selesai', '>=', $sesi_selesai);
                      });
            })
            ->exists();

        if ($conflictDisetujui) {
            return [
                'conflict' => true,
                'type' => 'peminjaman_disetujui',
                'message' => 'Ruangan sudah dipinjam dan disetujui pada waktu tersebut.',
                'data' => $conflictDisetujui->first()
            ];
        }

        // Tidak ada bentrok
        return [
            'conflict' => false,
            'type' => 'available',
            'message' => 'Ruangan tersedia pada waktu tersebut.'
        ];
    }

    /**
     * Mendapatkan semua jadwal untuk ruangan tertentu pada hari tertentu
     */
    public function getScheduleByDay($ruangan_id, $hari)
    {
        return JadwalReguler::where('ruangan_id', $ruangan_id)
            ->where('hari', $hari)
            ->where('status', 'Aktif')
            ->orderBy('sesi_mulai')
            ->get();
    }

    /**
     * Mendapatkan semua peminjaman untuk ruangan tertentu pada hari tertentu
     */
    public function getBookingsByDay($ruangan_id, $hari)
    {
        return Peminjaman::where('ruangan_id', $ruangan_id)
            ->whereDate('waktu_mulai', $hari)
            ->where('status', 'disetujui')
            ->orderBy('waktu_mulai')
            ->get();
    }

    /**
     * Mendapatkan semua peminjaman aktif untuk ruangan
     */
    public function getActiveBookings($ruangan_id)
    {
        return Peminjaman::where('ruangan_id', $ruangan_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where('waktu_selesai', '>', now())
            ->orderBy('waktu_mulai')
            ->with(['user'])
            ->get();
    }
}