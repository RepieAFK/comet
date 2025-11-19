<?php

namespace App\Http\Controllers;

use App\Exports\PeminjamanExport;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return Excel::download(
            new PeminjamanExport($request->start_date, $request->end_date . ' 23:59:59'),
            'laporan_peminjaman_' . $request->start_date . '_sampai_' . $request->end_date . '.xlsx'
        );
    }

    // Fitur Cetak Langsung
    public function print(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date . ' 23:59:59';

        $peminjamans = Peminjaman::with(['user', 'ruangan'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.print', compact('peminjamans', 'startDate', 'endDate'));
    }
}