@extends('layouts.app')

@section('title', 'Peminjam Dashboard')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Peminjam</h1>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus fa-sm me-2"></i>Ajukan Peminjaman
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Peminjaman
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPeminjaman }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Persetujuan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanMenunggu }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Disetujui
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanDisetujui }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2 stat-card secondary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanSelesai }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-flag-checkered fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Peminjaman Aktif -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peminjaman Aktif Saya</h6>
            </div>
            <div class="card-body">
                @if($peminjamanAktif->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Sesi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamanAktif as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                                        <td>{{ $peminjaman->tanggal->format('d M Y') }}</td>
                                        <td>Sesi {{ $peminjaman->sesi }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Anda tidak memiliki peminjaman aktif.</p>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Ajukan Peminjaman Baru</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Rekomendasi Ruangan -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekomendasi Ruangan</h6>
            </div>
            <div class="card-body">
                @foreach($rekomendasiRuangan as $ruangan)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                        <div>
                            <div class="fw-bold">{{ $ruangan->nama_ruangan }}</div>
                            <small class="text-muted">{{ $ruangan->kapasitas }} orang</small>
                        </div>
                        <a href="{{ route('peminjaman.create') }}?ruangan={{ $ruangan->id }}" class="btn btn-sm btn-outline-primary">
                            Pinjam
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Ruangan Tersedia -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ruangan Tersedia untuk Dipinjam</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($ruanganTersedia->take(6) as $ruangan)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($ruangan->foto)
                                    <img src="{{ asset('uploads/ruangan/' . $ruangan->foto) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $ruangan->nama_ruangan }}">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-door-open fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ $ruangan->nama_ruangan }}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="fas fa-users me-1"></i> {{ $ruangan->kapasitas }} orang<br>
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $ruangan->lokasi }}
                                        </small>
                                    </p>
                                    <a href="{{ route('peminjaman.create') }}?ruangan={{ $ruangan->id }}" class="btn btn-sm btn-primary w-100">
                                        Pinjam Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($ruanganTersedia->count() > 6)
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-outline-primary">Lihat Semua Ruangan</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Peminjaman Saya</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ruangan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatPeminjaman as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                                    <td>{{ $peminjaman->tanggal->format('d M Y') }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection