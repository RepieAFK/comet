@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

@if($user->isAdmin() || $user->isPetugas())
    <!-- Admin/Petugas Dashboard -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalRuangan }}</h4>
                            <p>Total Ruangan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-door-open fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalPeminjaman }}</h4>
                            <p>Total Peminjaman</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $peminjamanMenunggu }}</h4>
                            <p>Menunggu Persetujuan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $peminjamanHariIni }}</h4>
                            <p>Peminjaman Hari Ini</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Peminjam Dashboard -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalPeminjaman }}</h4>
                            <p>Total Peminjaman</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $peminjamanMenunggu }}</h4>
                            <p>Menunggu Persetujuan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $peminjamanDisetujui }}</h4>
                            <p>Disetujui</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-bg-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $peminjamanSelesai }}</h4>
                            <p>Selesai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-flag-checkered fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Recent Peminjaman -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Peminjaman Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if($user->isAdmin() || $user->isPetugas())
                            <th>Peminjam</th>
                        @endif
                        <th>Ruangan</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPeminjaman as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->id }}</td>
                            @if($user->isAdmin() || $user->isPetugas())
                                <td>{{ $peminjaman->user->name }}</td>
                            @endif
                            <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                            <td>{{ $peminjaman->waktu_mulai->format('d M Y H:i') }}</td>
                            <td>{{ $peminjaman->waktu_selesai->format('d M Y H:i') }}</td>
                            <td>
                                <span class="status-badge status-{{ $peminjaman->status }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $user->isAdmin() || $user->isPetugas() ? '7' : '6' }}" class="text-center">
                                Belum ada data peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection