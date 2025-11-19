<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isPetugas()) {
            $peminjamans = Peminjaman::with(['user', 'ruangan'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('sesi', 'asc')
                ->paginate(10);
        } else {
            $peminjamans = Peminjaman::with(['ruangan'])
                ->where('user_id', $user->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('sesi', 'asc')
                ->paginate(10);
        }
        
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        if (!Auth::user()->isPeminjam()) {
            abort(403, 'Unauthorized action.');
        }
        
        $ruangans = Ruangan::where('status', 'tersedia')->get();
        $sesi = range(1, 12);
        $minDate = now()->format('Y-m-d');
        
        return view('peminjaman.create', compact('ruangans', 'sesi', 'minDate'));
    }

    public function store(Request $request)
{
    if (!Auth::user()->isPeminjam()) {
        abort(403, 'Unauthorized action.');
    }
    
    $request->validate([
        'ruangan_id' => 'required|exists:ruangans,id',
        'tanggal' => 'required|date|after_or_equal:today',
        'sesi' => 'required|array|min:1', // Validasi sebagai array
        'sesi.*' => 'integer|between:1,12', // Validasi setiap elemen array
        'keperluan' => 'required|string|max:1000',
    ]);

    $ruangan = Ruangan::findOrFail($request->ruangan_id);
    $tanggal = $request->tanggal;
    $sesiList = $request->sesi;

    // Cek ketersediaan untuk setiap sesi
    foreach ($sesiList as $sesi) {
        if (!$ruangan->isAvailableForBooking($tanggal, $sesi)) {
            return back()->withInput()->with('error', "Ruangan tidak tersedia pada Sesi {$sesi}. Jadwal mungkin bentrok.");
        }
    }

    // Buat peminjaman untuk setiap sesi yang dipilih
    $peminjamanIds = [];
    foreach ($sesiList as $sesi) {
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'ruangan_id' => $request->ruangan_id,
            'tanggal' => $tanggal,
            'sesi' => $sesi,
            'keperluan' => $request->keperluan,
            'status' => 'menunggu',
        ]);
        $peminjamanIds[] = $peminjaman->id;
    }

    return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dikirim untuk ' . count($peminjamanIds) . ' sesi.');
}

    public function show(Peminjaman $peminjaman)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin() && !$user->isPetugas() && $peminjaman->user_id !== $user->id) {
            abort(403);
        }
        
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $ruangans = Ruangan::where('status', 'tersedia')->get();
        $sesi = range(1, 12);
        return view('peminjaman.edit', compact('peminjaman', 'ruangans', 'sesi'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'sesi' => 'required|integer|min:1|max:12',
            'keperluan' => 'required|string|max:1000',
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Cek konflik jika ruangan, tanggal, atau sesi berubah
        if ($peminjaman->ruangan_id != $request->ruangan_id || 
            $peminjaman->tanggal != $request->tanggal || 
            $peminjaman->sesi != $request->sesi) {
            
            $ruangan = Ruangan::findOrFail($request->ruangan_id);
            
            if (!$ruangan->isAvailableForBooking($request->tanggal, $request->sesi)) {
                return back()->withInput()->with('error', 'Ruangan tidak tersedia pada waktu yang dipilih. Jadwal mungkin bentrok.');
            }
        }

        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'disetujui') {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang sudah disetujui.');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function approve(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'disetujui',
            'catatan' => request('catatan'),
        ]);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Peminjaman $peminjaman)
    {
        $request = request();
        
        $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }
}