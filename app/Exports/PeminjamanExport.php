<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

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
            $query->whereBetween('waktu_mulai', [$this->startDate, $this->endDate]);
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
            'Waktu Mulai',
            'Waktu Selesai',
            'Keperluan',
            'Status',
            'Catatan',
            'Tanggal Pengajuan',
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->id,
            $peminjaman->user->name,
            $peminjaman->user->nomor_induk,
            $peminjaman->ruangan->nama_ruangan,
            $peminjaman->waktu_mulai->format('d-m-Y H:i'),
            $peminjaman->waktu_selesai->format('d-m-Y H:i'),
            $peminjaman->keperluan,
            ucfirst($peminjaman->status),
            $peminjaman->catatan ?? '-',
            $peminjaman->created_at->format('d-m-Y H:i'),
        ];
    }
}