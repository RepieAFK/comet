<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeminjamanResource;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Method ini untuk menampilkan semua peminjaman.
     */
    public function index(Request $request)
    {
        // Ambil user yang sedang login dari token
        $user = $request->user();
        
        if ($user->isAdmin() || $user->isPetugas()) {
            // Jika admin atau petugas, tampilkan semua peminjaman
            $peminjamans = Peminjaman::with(['user', 'ruangan'])->get();
        } else {
            // Jika peminjam, hanya tampilkan peminjaman miliknya sendiri
            $peminjamans = Peminjaman::with(['ruangan'])
                ->where('user_id', $user->id)
                ->get();
        }
        
        // Kembalikan data dalam format koleksi resource
        return PeminjamanResource::collection($peminjamans);
    }

    /**
     * Store a newly created resource in storage.
     * Method ini untuk membuat peminjaman baru.
     */
    public function store(Request $request)
{
    if (!Auth::user()->isPeminjam()) {
        abort(403, 'Unauthorized action.');
    }
    
    $request->validate([
        'ruangan_id' => 'required|exists:ruangans,id',
        'tanggal' => 'required|date|after_or_equal:today',
        'sesi_mulai' => 'required|integer|min:1|max:12',
        'sesi_selesai' => 'required|integer|min:1|max:12|gt:sesi_mulai',
        'keperluan' => 'required|string|max:1000',
    ]);

    $sesiList = getSesiList();
    $tanggal = $request->tanggal;
    
    $waktuMulai = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $sesiList[$request->sesi_mulai][0]);
    $waktuSelesai = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $sesiList[$request->sesi_selesai][1]);

    $ruangan = Ruangan::findOrFail($request->ruangan_id);
    
    if (!$ruangan->isAvailable($waktuMulai, $waktuSelesai)) {
        return back()->withInput()->with('error', 'Ruangan tidak tersedia pada waktu yang dipilih.');
    }

    Peminjaman::create([
        'user_id' => Auth::id(),
        'ruangan_id' => $request->ruangan_id,
        'waktu_mulai' => $waktuMulai,
        'waktu_selesai' => $waktuSelesai,
        'keperluan' => $request->keperluan,
        'status' => 'menunggu',
    ]);

    return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
}

    /**
     * Display the specified resource.
     * Method ini untuk menampilkan detail satu peminjaman.
     */
    public function show(Peminjaman $peminjaman, Request $request)
    {
        // Ambil user yang sedang login
        $user = $request->user();
        
        // Cek otoritas: admin/petugas bisa lihat semua, peminjam hanya miliknya
        if (!$user->isAdmin() && !$user->isPetugas() && $peminjaman->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Kembalikan detail peminjaman
        return new PeminjamanResource($peminjaman->load(['user', 'ruangan']));
    }
}