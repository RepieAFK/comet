@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    <div>
        <a href="{{ route('laporan.index') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel me-2"></i>Export Laporan
        </a>
        <a href="{{ route('jadwal.index') }}" class="btn btn-info btn-sm ms-2">
            <i class="fas fa-calendar me-2"></i>Lihat Jadwal
        </a>
    </div>
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
                            Total Ruangan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRuangan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-closed fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUser }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Peminjaman Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanHariIni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Peminjaman 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="peminjamanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi User</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="userRoleChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    @foreach($userRoles as $role)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ $loop->iteration == 1 ? '#4e73df' : ($loop->iteration == 2 ? '#1cc88a' : '#36b9cc') }}"></i> {{ ucfirst($role->role) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Peminjaman</h6>
            </div>
            <div class="card-body">
                @foreach($statusBreakdown as $status)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="small text-gray-500">{{ ucfirst($status->status) }}</div>
                        </div>
                        <div class="small text-gray-500">{{ $status->total }}</div>
                    </div>
                    <div class="progress mb-3" style="height: 5px;">
                        <div class="progress-bar bg-{{ $status->status == 'disetujui' ? 'success' : ($status->status == 'ditolak' ? 'danger' : ($status->status == 'selesai' ? 'secondary' : 'warning')) }}" role="progressbar" style="width: {{ ($status->total / max($totalPeminjaman, 1)) * 100 }}%"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ruangan Terpopuler</h6>
            </div>
            <div class="card-body">
                @foreach($ruanganTerpopuler as $ruangan)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="font-weight-bold">{{ $ruangan->nama_ruangan }}</div>
                        </div>
                        <div class="text-right">
                            <div class="small text-gray-500">{{ $ruangan->total }}x dipinjam</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPeminjaman as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->id }}</td>
                            <td>{{ $peminjaman->user->name }}</td>
                            <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                            <td>{{ $peminjaman->tanggal ? $peminjaman->tanggal->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ $peminjaman->status }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Jadwal Hari Ini Widget -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Hari Ini ({{ now()->format('l, d F Y') }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todaySchedule as $schedule)
                        <tr>
                            <td>{{ $schedule->ruangan->nama_ruangan }}</td>
                             <td>
    {{ $peminjaman->waktu_mulai ? \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') : '-' }}
    -
    {{ $peminjaman->waktu_selesai ? \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') : '-' }}
</td>
                            <td>{{ $schedule->user->name }}</td>
                            <td><span class="badge bg-success">{{ $schedule->keperluan }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada jadwal untuk hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#858796';

    // Area Chart Example
    const ctx = document.getElementById('peminjamanChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json(collect($peminjamanChart)->pluck('date')),
            datasets: [{
                label: 'Jumlah Peminjaman',
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: @json(collect($peminjamanChart)->pluck('count')),
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2, 4],
                    }
                },
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    caretPadding: 10,
                }
            }
        }
    });

    // Pie Chart Example
    const userRoleCtx = document.getElementById('userRoleChart');
    new Chart(userRoleCtx, {
        type: 'doughnut',
        data: {
            labels: @json(collect($userRoles)->pluck('role')->map(fn($role) => ucfirst($role))),
            datasets: [{
                data: @json(collect($userRoles)->pluck('total')),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    caretPadding: 10,
                }
            },
            cutoutPercentage: 80,
        }
    });
</script>
@endsection