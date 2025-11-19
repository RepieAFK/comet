<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'ruangan']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peminjam',
            'Nomor Induk',
            'Ruangan',
            'Tanggal Pinjam',
            'Sesi',
            'Waktu (Perkiraan)',
            'Keperluan',
            'Status',
            'Catatan',
            'Tanggal Pengajuan',
        ];
    }

    public function map($peminjaman): array
    {
        // Helper untuk menghitung waktu dari sesi
        $sesiStart = (7 * 60) + ($peminjaman->sesi - 1) * 45;
        $jam = floor($sesiStart / 60);
        $menit = $sesiStart % 60;
        $waktuMulai = sprintf('%02d:%02d', $jam, $menit);
        $waktuSelesai = sprintf('%02d:%02d', $jam, $menit + 45);

        return [
            $peminjaman->id,
            $peminjaman->user->name,
            $peminjaman->user->nomor_induk,
            $peminjaman->ruangan->nama_ruangan,
            $peminjaman->tanggal->format('d-m-Y'),
            $peminjaman->sesi,
            $waktuMulai . ' - ' . $waktuSelesai, // Waktu perkiraan dari sesi
            $peminjaman->keperluan,
            ucfirst($peminjaman->status),
            $peminjaman->catatan ?? '-',
            $peminjaman->created_at->format('d-m-Y H:i'),
        ];
    }
}