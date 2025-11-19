<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isPetugas()) {
            return $this->petugasDashboard();
        } else {
            return $this->peminjamDashboard();
        }
    }

    private function adminDashboard()
{
    // Overview System
    $totalRuangan = Ruangan::count();
    $totalUser = User::count();
    $totalPeminjaman = Peminjaman::count();
    
    // Statistik Peminjaman
    $peminjamanBulanIni = Peminjaman::whereMonth('created_at', now()->month)->count();
    $peminjamanHariIni = Peminjaman::whereDate('created_at', today())->count();
    
    // Distribusi User per Role
    $userRoles = User::select('role', DB::raw('count(*) as total'))
        ->groupBy('role')
        ->get();
    
    // Status Breakdown
    $statusBreakdown = Peminjaman::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get();
    
    // Ruangan Paling Banyak Digunakan
    $ruanganTerpopuler = DB::table('peminjamans')
        ->select('ruangans.nama_ruangan', DB::raw('count(*) as total'))
        ->join('ruangans', 'peminjamans.ruangan_id', '=', 'ruangans.id')
        ->groupBy('ruangans.nama_ruangan')
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();
    
    // Peminjaman Terbaru
    $recentPeminjaman = Peminjaman::with(['user', 'ruangan'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // User Terbaru
    $newUsers = User::orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // 🔥 Jadwal hari ini — FIX ERROR 🔥
    $todaySchedule = Peminjaman::with(['user', 'ruangan'])
        ->whereDate('tanggal', today())
        ->orderBy('sesi')
        ->get();
    
    // Grafik Peminjaman 7 Hari Terakhir
    $peminjamanChart = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $count = Peminjaman::whereDate('created_at', $date)->count();
        $peminjamanChart[] = [
            'date' => now()->subDays($i)->format('d M'),
            'count' => $count
        ];
    }
    
    return view('dashboard.admin', compact(
        'totalRuangan',
        'totalUser', 
        'totalPeminjaman',
        'peminjamanBulanIni',
        'peminjamanHariIni',
        'userRoles',
        'statusBreakdown',
        'ruanganTerpopuler',
        'recentPeminjaman',
        'newUsers',
        'peminjamanChart',
        'todaySchedule' // 🔥 dikirim ke view
    ));
}

    private function petugasDashboard()
{
    // Status Breakdown
    $statusBreakdown = Peminjaman::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get();
    
    // Jumlah Menunggu Persetujuan
    $menungguPersetujuan = Peminjaman::where('status', 'menunggu')->count();
    
    // Status Ruangan
    $ruanganTersedia = Ruangan::where('status', 'tersedia')->count();
    $ruanganTidakTersedia = Ruangan::where('status', 'tidak_tersedia')->count();
    
    // Peringatan Ruangan Padat
    $ruanganPadat = Ruangan::withCount(['peminjamans' => function($query) {
            $query->where('status', 'disetujui')
                  ->whereBetween('tanggal', [now(), now()->addDays(7)]);
        }])
        ->having('peminjamans_count', '>=', 5)
        ->get();
    
    // Peminjaman Hari Ini
    $peminjamanHariIni = Peminjaman::whereDate('tanggal', today())
        ->where('status', 'disetujui')
        ->with(['user', 'ruangan'])
        ->orderBy('sesi')
        ->get();

    // 🔥 Tambahkan ini biar error hilang 🔥
    $todaySchedule = Peminjaman::with(['user', 'ruangan'])
        ->whereDate('tanggal', today())
        ->where('status', 'disetujui')
        ->orderBy('sesi')
        ->get();

    // Statistik Mingguan
    $statistikMingguan = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $statistikMingguan[] = [
            'day' => $date->format('D'),
            'peminjaman' => Peminjaman::whereDate('tanggal', $date)->count(),
            'disetujui' => Peminjaman::whereDate('tanggal', $date)->where('status', 'disetujui')->count(),
        ];
    }

    return view('dashboard.petugas', compact(
        'statusBreakdown',
        'menungguPersetujuan',
        'ruanganTersedia',
        'ruanganTidakTersedia',
        'ruanganPadat',
        'peminjamanHariIni',
        'todaySchedule',    // 🔥 WAJIB DIKIRIM
        'statistikMingguan'
    ));
}


    private function peminjamDashboard()
    {
        $userId = Auth::id();
        
        // Statistik Peminjaman User
        $totalPeminjaman = Peminjaman::where('user_id', $userId)->count();
        $peminjamanMenunggu = Peminjaman::where('user_id', $userId)->where('status', 'menunggu')->count();
        $peminjamanDisetujui = Peminjaman::where('user_id', $userId)->where('status', 'disetujui')->count();
        $peminjamanSelesai = Peminjaman::where('user_id', $userId)->where('status', 'selesai')->count();
        
        // Ruangan Tersedia untuk Dipinjam
        $ruanganTersedia = Ruangan::where('status', 'tersedia')->get();
        
        // Peminjaman Aktif - PERBAIKAN DI SINI
        $peminjamanAktif = Peminjaman::with('ruangan')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where('tanggal', '>=', today()) // Perbaikan: gunakan tanggal bukan waktu_selesai
            ->orderBy('tanggal') // Perbaikan: urutkan berdasarkan tanggal
            ->orderBy('sesi') // Perbaikan: tambahkan urutan berdasarkan sesi
            ->get();
        
        // Riwayat Peminjaman
        $riwayatPeminjaman = Peminjaman::with('ruangan')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Rekomendasi Ruangan (paling sering dipinjam)
        $rekomendasiRuangan = DB::table('peminjamans')
            ->select('ruangans.*', DB::raw('count(*) as total_peminjaman'))
            ->join('ruangans', 'peminjamans.ruangan_id', '=', 'ruangans.id')
            ->where('ruangans.status', 'tersedia')
            ->groupBy('ruangans.id')
            ->orderBy('total_peminjaman', 'desc')
            ->limit(3)
            ->get();
        
        return view('dashboard.peminjam', compact(
            'totalPeminjaman',
            'peminjamanMenunggu',
            'peminjamanDisetujui',
            'peminjamanSelesai',
            'ruanganTersedia',
            'peminjamanAktif',
            'riwayatPeminjaman',
            'rekomendasiRuangan'
        ));
    }
}