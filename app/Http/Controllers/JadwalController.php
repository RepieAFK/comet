<?php

namespace App\Http\Controllers;

use App\Models\JadwalReguler;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
{
    $ruangans = Ruangan::all();
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $sesi = range(1, 12);
    
    // Ambil semua jadwal reguler
    $jadwalRegulers = JadwalReguler::with('ruangan')->get()
        ->keyBy(function($item) {
            return $item->ruangan_id . '-' . $item->hari . '-' . $item->sesi;
        });

    // Ambil semua peminjaman yang disetujui untuk minggu ini
    $startOfWeek = now()->startOfWeek()->format('Y-m-d');
    $endOfWeek = now()->endOfWeek()->format('Y-m-d');
    
    $peminjamans = Peminjaman::with(['ruangan', 'user'])
        ->where('status', 'disetujui')
        ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
        ->get()
        ->keyBy(function($item) {
    return $item->ruangan_id . '-' . $item->tanggal->format('Y-m-d') . '-' . $item->sesi;
});

    // =====================================
    // Tambahkan DATES untuk kebutuhan tabel
    // =====================================
    $start = now()->startOfWeek();
    $dates = [];
    for ($i = 0; $i < 5; $i++) { // Senin-Jumat
        $dates[] = $start->copy()->addDays($i)->format('Y-m-d');
    }
    $dates = [];
$start = now()->startOfWeek();
for ($i = 0; $i < 7; $i++) {
    $dates[] = $start->copy()->addDays($i);
}

    return view('jadwal.index', compact(
        'ruangans',
        'hari',
        'sesi',
        'jadwalRegulers',
        'peminjamans',
        'dates' // <<< FIX TERPENTING
    ));
}


    // Fitur Tambahan: Quick Availability Check
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
        ]);

        $ruangan = Ruangan::findOrFail($request->ruangan_id);
        $sesiList = range(1, 12);
        $availableSesi = [];

        foreach ($sesiList as $sesi) {
            if ($ruangan->isAvailableForBooking($request->tanggal, $sesi)) {
                $availableSesi[] = $sesi;
            }
        }

        return response()->json([
            'available_sesi' => $availableSesi,
            'total_sesi' => count($availableSesi),
        ]);
    }
}