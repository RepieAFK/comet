@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Petugas</h1>
    <div>
        <a href="{{ route('laporan.index') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel me-2"></i>Export Laporan
        </a>
        <a href="{{ route('jadwal.index') }}" class="btn btn-info btn-sm ms-2">
            <i class="fas fa-calendar me-2"></i>Lihat Jadwal
        </a>
    </div>
</div>

<!-- Alert untuk Menunggu Persetujuan -->
@if($menungguPersetujuan > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Peringatan!</strong> Ada {{ $menungguPersetujuan }} peminjaman yang menunggu persetujuan Anda.
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-warning ms-2">Lihat Sekarang</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Ruangan Tersedia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ruanganTersedia }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2 stat-card danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Ruangan Tidak Tersedia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ruanganTidakTersedia }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menungguPersetujuan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Peminjaman Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanHariIni->count() }}</div>
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
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Breakdown Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Peminjaman Minggu Ini</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="mingguanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Peringatan Ruangan Padat -->
@if($ruanganPadat->count() > 0)
    <div class="card shadow mb-4 border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Peringatan Ruangan dengan Jadwal Padat (7 Hari ke Depan)
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Ruangan</th>
                            <th>Jadwal Aktif</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruanganPadat as $ruangan)
                            <tr>
                                <td>{{ $ruangan->nama_ruangan }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $ruangan->peminjamans_count }} jadwal</span>
                                </td>
                                <td>{{ $ruangan->kapasitas }} orang</td>
                                <td>
                                    <span class="badge bg-{{ $ruangan->status == 'tersedia' ? 'success' : 'danger' }}">
                                        {{ ucfirst($ruangan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Peminjaman Hari Ini -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Peminjaman Hari Ini</h6>
    </div>
    <div class="card-body">
        @if($peminjamanHariIni->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                            <th>Peminjam</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanHariIni as $peminjaman)
                            <tr>
                                <td>
    {{ $peminjaman->waktu_mulai ? \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') : '-' }}
    -
    {{ $peminjaman->waktu_selesai ? \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') : '-' }}
</td>

                                <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ Str::limit($peminjaman->keperluan, 30) }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($peminjaman->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Tidak ada peminjaman untuk hari ini.</p>
        @endif
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

    // Status Breakdown Chart
    const statusCtx = document.getElementById('statusChart');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: @json(collect($statusBreakdown)->pluck('status')->map(fn($status) => ucfirst($status))),
            datasets: [{
                data: @json(collect($statusBreakdown)->pluck('total')),
                backgroundColor: [
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                    'rgb(153, 102, 255)'
                ]
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
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

    // Statistik Mingguan
    const mingguanCtx = document.getElementById('mingguanChart');
    new Chart(mingguanCtx, {
        type: 'bar',
        data: {
            labels: @json(collect($statistikMingguan)->pluck('day')),
            datasets: [{
                label: 'Total Peminjaman',
                data: @json(collect($statistikMingguan)->pluck('peminjaman')),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
            }, {
                label: 'Disetujui',
                data: @json(collect($statistikMingguan)->pluck('disetujui')),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: true,
                    caretPadding: 10,
                }
            }
        }
    });
</script>
@endsection