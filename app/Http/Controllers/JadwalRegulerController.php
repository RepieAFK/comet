<?php

namespace App\Http\Controllers;

use App\Models\JadwalReguler;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalRegulerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator,petugas');
    }

    public function index()
{
    $ruangans = Ruangan::with('jadwalRegulers')->get();
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $sesi = range(1, 12);

    // Jadwal reguler
    $jadwalRegulers = JadwalReguler::with('ruangan')->get()
        ->keyBy(function($item) {
            return $item->ruangan_id . '-' . $item->hari . '-' . $item->sesi;
        });

    // Tambahkan peminjaman yang disetujui
    $peminjamans = \App\Models\Peminjaman::with(['ruangan', 'user'])
        ->where('status', 'disetujui')
        ->get()
        ->keyBy(function($item) {
            return $item->ruangan_id . '-' . $item->tanggal . '-' . $item->sesi;
        });

    return view('jadwal.reguler_index', compact(
        'ruangans',
        'hari',
        'sesi',
        'jadwalRegulers',
        'peminjamans'
    ));
}


    public function create()
    {
        $ruangans = Ruangan::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $sesi = range(1, 12);

        return view('jadwal.reguler_create', compact('ruangans', 'hari', 'sesi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'sesi' => 'required|integer|min:1|max:12',
            'kegiatan' => 'required|string|max:255',
        ]);

        $ruangan = Ruangan::findOrFail($request->ruangan_id);
        if (!$ruangan->isAvailableForRegular($request->hari, $request->sesi)) {
            return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain yang sudah ada.');
        }

        JadwalReguler::create([
            'ruangan_id' => $request->ruangan_id,
            'hari' => $request->hari,
            'sesi' => $request->sesi,
            'kegiatan' => $request->kegiatan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('jadwal.reguler_index')->with('success', 'Jadwal reguler berhasil ditambahkan.');
    }

    public function edit(JadwalReguler $jadwalReguler)
    {
        $ruangans = Ruangan::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $sesi = range(1, 12);

        return view('jadwal.reguler_edit', compact('jadwalReguler', 'ruangans', 'hari', 'sesi'));
    }

    public function update(Request $request, JadwalReguler $jadwalReguler)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'sesi' => 'required|integer|min:1|max:12',
            'kegiatan' => 'required|string|max:255',
        ]);

        $ruangan = Ruangan::findOrFail($request->ruangan_id);
        
        // Cek konflik, kecuali dengan dirinya sendiri
        $conflict = JadwalReguler::where('ruangan_id', $request->ruangan_id)
            ->where('hari', $request->hari)
            ->where('sesi', $request->sesi)
            ->where('id', '!=', $jadwalReguler->id)
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain yang sudah ada.');
        }

        $jadwalReguler->update($request->all());

        return redirect()->route('jadwal.reguler.index')->with('success', 'Jadwal reguler berhasil diperbarui.');
    }

    public function destroy(JadwalReguler $jadwalReguler)
    {
        $jadwalReguler->delete();
        return redirect()->route('jadwal.reguler.index')->with('success', 'Jadwal reguler berhasil dihapus.');
    }
}