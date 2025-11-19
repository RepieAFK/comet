@extends('layouts.app')

@section('title', 'Jadwal Peminjaman')

@section('content')
<div class="container-fluid p-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Jadwal Peminjaman</h1>
            <p class="text-muted mb-0">Menampilkan semua jadwal peminjaman ruangan</p>
        </div>
        <div>
            <a href="{{ route('jadwal_reguler.index') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-calendar-plus me-2"></i>Atur Jadwal Reguler
            </a>
        </div>
    </div>

    <!-- Schedule Card -->
    <div class="card shadow mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-primary px-3 py-2">
                    <i class="fas fa-info-circle me-1"></i>{{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered m-0">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="15%">Ruangan & Lokasi</th>
                            <th width="15%">Peminjam</th>
                            <th width="12%">Hari</th>
                            <th width="12%">Sesi</th>
                            <th width="12%">Waktu</th>
                            <th width="15%">Keperluan</th>
                            <th width="8%">Status</th>
                            <th class="text-center" width="6%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = $peminjamanByHariSesi ?? [];
                            $groupedData = [];
                            
                            // Group by date for better organization
                            foreach ($data as $key => $peminjamanList) {
                                $peminjaman = $peminjamanList[0];
                                $dateKey = $peminjaman->waktu_mulai->format('Y-m-d');
                                
                                if (!isset($groupedData[$dateKey])) {
                                    $groupedData[$dateKey] = [
                                        'date' => $peminjaman->waktu_mulai,
                                        'bookings' => []
                                    ];
                                }
                                $groupedData[$dateKey]['bookings'][] = [
                                    'key' => $key,
                                    'list' => $peminjamanList
                                ];
                            }
                            
                            ksort($groupedData);
                        @endphp
                        
                        @if(count($data) > 0)
                            @foreach($groupedData as $dateGroup)
                                @php
                                    $isToday = $dateGroup['date']->isToday();
                                @endphp
                                
                                <!-- Date Section Header -->
                                <tr class="bg-light border-top-2 border-dark">
                                    <td colspan="9" class="fw-bold py-2 px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas {{ $isToday ? 'fa-calendar-check text-success' : 'fa-calendar-alt text-primary' }}"></i>
                                            <span class="fs-6">
                                                {{ $dateGroup['date']->format('l, d F Y') }}
                                                @if($isToday)
                                                    <span class="badge bg-success ms-2">HARI INI</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                
                                @foreach($dateGroup['bookings'] as $booking)
                                    @php
                                        $sesiKey = explode('-', $booking['key']);
                                        $sesiNum = count($sesiKey) > 1 ? $sesiKey[1] : 'N/A';
                                        $sesiList = getSesiList();
                                        $sesiTime = $sesiNum !== 'N/A' && isset($sesiList[$sesiNum]) ? $sesiList[$sesiNum] : ['N/A', 'N/A'];
                                        $peminjaman = $booking['list'][0];
                                        
                                        // Status badge styling
                                        $status = $peminjaman->status ?? 'pending';
                                        $statusClasses = [
                                            'disetujui' => 'bg-success',
                                            'ditolak' => 'bg-danger',
                                            'selesai' => 'bg-info',
                                            'menunggu' => 'bg-warning',
                                            'batal' => 'bg-secondary'
                                        ];
                                        $statusClass = $statusClasses[$status] ?? 'bg-secondary';
                                        
                                        // Icon based on status
                                        $statusIcon = match($status) {
                                            'disetujui' => 'check-circle',
                                            'ditolak' => 'times-circle',
                                            'selesai' => 'flag-checkered',
                                            'menunggu' => 'clock',
                                            'batal' => 'ban',
                                            default => 'question-circle'
                                        };
                                    @endphp
                                    
                                    <tr data-id="{{ $peminjaman->id }}" 
                                        class="{{ $isToday ? 'table-warning' : '' }}"
                                        style="transition: all 0.2s ease;">
                                        <td class="text-center fw-bold">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-primary">
                                                    {{ $peminjaman->ruangan->nama_ruangan ?? 'N/A' }}
                                                </span>
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $peminjaman->ruangan->lokasi ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 30px; height: 30px;">
                                                    {{ strtoupper(substr($peminjaman->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $peminjaman->user->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $peminjaman->user->email ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                {{ $peminjaman->waktu_mulai->format('l') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="badge bg-gradient-primary text-white px-3 py-2 mb-1">
                                                    Sesi {{ $sesiNum }}
                                                </span>
                                                <small class="text-muted text-center">
                                                    {{ $sesiTime[0] ?? 'N/A' }} - {{ $sesiTime[1] ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="fw-semibold">
                                                    {{ $peminjaman->waktu_mulai->format('H:i') }}
                                                </div>
                                                <div class="text-muted small">→</div>
                                                <div class="fw-semibold">
                                                    {{ $peminjaman->waktu_selesai->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative" style="max-width: 200px;">
                                                @if(is_array($peminjaman->keperluan))
                                                    @foreach(explode(', ', implode(', ', $peminjaman->keperluan)) as $item)
                                                        <span class="badge bg-light text-dark me-1 mb-1">
                                                            {{ trim($item) }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="badge bg-light text-dark px-2 py-1">
                                                        {{ $peminjaman->keperluan ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="badge {{ $statusClass }} px-3 py-2 mb-1">
                                                    <i class="fas fa-{{ $statusIcon }} me-1"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $peminjaman->waktu_mulai->diffForHumans() }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical btn-group-sm" role="group">
                                                <a href="{{ route('peminjaman.show', $peminjaman) }}" 
                                                   class="btn btn-outline-primary btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" 
                                                       class="btn btn-outline-warning btn-sm"
                                                       data-bs-toggle="tooltip" 
                                                       data-bs-placement="top" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('peminjaman.destroy', $peminjaman) }}" 
                                                          method="POST" 
                                                          class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                class="btn btn-outline-danger btn-sm delete-btn"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Hapus"
                                                                data-id="{{ $peminjaman->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle bg-light p-4 mb-3">
                                            <i class="fas fa-calendar-times fa-3x text-muted"></i>
                                        </div>
                                        <h5 class="text-muted mb-2">Tidak Ada Jadwal</h5>
                                        <p class="text-muted mb-0 text-center" style="max-width: 400px;">
                                            Tidak ada peminjaman ruangan yang terdaftar untuk saat ini. 
                                            Silakan buat peminjaman baru atau periksa kembali nanti.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Enhanced delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const form = this.closest('.delete-form');
            
            if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini? Tindakan ini tidak dapat dibatalkan.')) {
                form.submit();
            }
        });
    });

    // Add hover effects for better UX
    document.querySelectorAll('tr[data-id]').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});
</script>
@endsection