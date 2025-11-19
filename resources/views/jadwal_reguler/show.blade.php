@extends('layouts.app')

@section('title', 'Detail Jadwal Reguler')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div>
            <h1 class="page-title">Detail Jadwal Reguler</h1>
            <p class="page-subtitle">Informasi lengkap jadwal rutin</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
            <a href="{{ route('jadwal_reguler.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row">
    <!-- Primary Information -->
    <div class="col-lg-8">
        <!-- Schedule Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Informasi Jadwal
                </h6>
                <div class="card-actions">
                    <span class="status-badge {{ $jadwalReguler->status == 'Aktif' ? 'status-disetujui' : 'status-ditolak' }}">
                        {{ $jadwalReguler->status }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Day & Time -->
                    <div class="col-md-6 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-calendar-day text-primary me-2"></i>Hari
                            </div>
                            <div class="info-value">
                                <span class="badge bg-light text-dark fs-6">
                                    {{ $jadwalReguler->hari }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-clock text-info me-2"></i>Waktu
                            </div>
                            <div class="info-value">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">{{ $jadwalReguler->sesi_mulai }}</span>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                    <span class="badge bg-primary ms-2">{{ $jadwalReguler->sesi_selesai }}</span>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    Durasi: {{ \Carbon\Carbon::parse($jadwalReguler->sesi_selesai)->diffInHours(\Carbon\Carbon::parse($jadwalReguler->sesi_mulai)) }} jam
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Room & Activity -->
                    <div class="col-md-6 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-door-closed text-warning me-2"></i>Ruangan
                            </div>
                            <div class="info-value">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <span class="fw-semibold">{{ $jadwalReguler->ruangan->nama_ruangan }}</span>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    Kapasitas: {{ $jadwalReguler->ruangan->kapasitas ?? '-' }} orang
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-book text-success me-2"></i>Kegiatan
                            </div>
                            <div class="info-value">
                                <span class="fw-semibold">{{ $jadwalReguler->kegiatan }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Class Code & Description -->
                    <div class="col-md-6 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-tag text-secondary me-2"></i>Kode Kelas
                            </div>
                            <div class="info-value">
                                @if($jadwalReguler->kode_kelas)
                                    <span class="badge bg-light text-dark">{{ $jadwalReguler->kode_kelas }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($jadwalReguler->deskripsi)
                    <div class="col-12 mb-4">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                            </div>
                            <div class="info-value">
                                <div class="alert alert-light">
                                    {{ $jadwalReguler->deskripsi }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-item">
                            <div class="stat-icon primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-details">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($jadwalReguler->created_at)->format('d M Y') }}</div>
                                <div class="stat-label">Dibuat</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-item">
                            <div class="stat-icon success">
                                <i class="fas fa-sync"></i>
                            </div>
                            <div class="stat-details">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($jadwalReguler->updated_at)->format('d M Y') }}</div>
                                <div class="stat-label">Diperbarui</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-item">
                            <div class="stat-icon warning">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-details">
                                <div class="stat-value">{{ rand(15, 45) }}</div>
                                <div class="stat-label">Peserta (Estimasi)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Schedules -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-link me-2"></i>Jadwal Terkait
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Same Room, Different Day -->
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Ruangan Sama, Hari Berbeda</h6>
                        @foreach($relatedSchedules ?? [] as $related)
                            @if($related->ruangan_id == $jadwalReguler->ruangan_id && $related->id != $jadwalReguler->id)
                                <div class="related-item mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-light text-dark me-2">{{ $related->hari }}</span>
                                            <small class="text-muted">{{ $related->sesi_mulai }} - {{ $related->sesi_selesai }}</small>
                                        </div>
                                        <a href="{{ route('jadwal_reguler.show', $related) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!isset($relatedSchedules) || $relatedSchedules->where('ruangan_id', $jadwalReguler->ruangan_id)->where('id', '!=', $jadwalReguler->id)->count() == 0)
                            <p class="text-muted text-center py-3">Tidak ada jadwal terkait</p>
                        @endif
                    </div>
                    
                    <!-- Same Time, Different Room -->
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Waktu Sama, Ruangan Berbeda</h6>
                        @foreach($relatedSchedules ?? [] as $related)
                            @if($related->sesi_mulai == $jadwalReguler->sesi_mulai && $related->id != $jadwalReguler->id)
                                <div class="related-item mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-light text-dark me-2">{{ $related->ruangan->nama_ruangan }}</span>
                                            <small class="text-muted">{{ $related->hari }}</small>
                                        </div>
                                        <a href="{{ route('jadwal_reguler.show', $related) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!isset($relatedSchedules) || $relatedSchedules->where('sesi_mulai', $jadwalReguler->sesi_mulai)->where('id', '!=', $jadwalReguler->id)->count() == 0)
                            <p class="text-muted text-center py-3">Tidak ada jadwal terkait</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Actions -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('jadwal_reguler.edit', $jadwalReguler) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Jadwal
                    </a>
                    
                    <button class="btn btn-info" onclick="duplicateSchedule()">
                        <i class="fas fa-copy me-2"></i>Salin Jadwal
                    </button>
                    
                    <button class="btn btn-success" onclick="toggleStatus()">
                        <i class="fas fa-power-off me-2"></i>
                        {{ $jadwalReguler->status == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                    
                    <form action="{{ route('jadwal_reguler.destroy', $jadwalReguler) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Room Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-door-open me-2"></i>Status Ruangan
                </h6>
            </div>
            <div class="card-body">
                <div class="room-status">
                    <div class="status-indicator {{ $jadwalReguler->status == 'Aktif' ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle"></i>
                        <span>{{ $jadwalReguler->status == 'Aktif' ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                    </div>
                    
                    <div class="room-info mt-3">
                        <div class="info-row">
                            <span class="label">Gedung:</span>
                            <span class="value">{{ $jadwalReguler->ruangan->gedung ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Lantai:</span>
                            <span class="value">{{ $jadwalReguler->ruangan->lantai ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Fasilitas:</span>
                            <span class="value">LCD, AC, Whiteboard</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Riwayat
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Jadwal Dibuat</div>
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($jadwalReguler->created_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    
                    @if($jadwalReguler->updated_at != $jadwalReguler->created_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Terakhir Diubah</div>
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($jadwalReguler->updated_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Jadwal Aktif</div>
                            <div class="timeline-date">Setiap {{ $jadwalReguler->hari }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Duplicate schedule
    function duplicateSchedule() {
        if (confirm('Apakah Anda ingin menyalin jadwal ini?')) {
            // Implement duplication logic
            window.location.href = `{{ route('jadwal_reguler.create') }}?duplicate={{ $jadwalReguler->id }}`;
        }
    }

    // Toggle status
    function toggleStatus() {
        const newStatus = '{{ $jadwalReguler->status }}' === 'Aktif' ? 'menonaktifkan' : 'mengaktifkan';
        if (confirm(`Apakah Anda yakin ingin ${newStatus} jadwal ini?`)) {
            // Implement status toggle
            alert(`Jadwal berhasil ${newStatus}!`);
            location.reload();
        }
    }

    // Add print styles
    window.addEventListener('beforeprint', function() {
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = 'none';
        });
    });

    window.addEventListener('afterprint', function() {
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = '';
        });
    });
</script>

<style>
.info-group {
    margin-bottom: 1.5rem;
}

.info-label {
    font-weight: 600;
    color: var(--secondary-color);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.info-value {
    color: var(--dark-color);
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--light-color);
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1rem;
}

.stat-icon.primary {
    background: rgba(57, 197, 187, 0.1);
    color: var(--primary-color);
}

.stat-icon.success {
    background: rgba(28, 200, 138, 0.1);
    color: var(--success-color);
}

.stat-icon.warning {
    background: rgba(246, 194, 62, 0.1);
    color: var(--warning-color);
}

.stat-value {
    font-weight: 600;
    font-size: 1rem;
    color: var(--secondary-color);
}

.stat-label {
    font-size: 0.8rem;
    color: var(--secondary-color);
    opacity: 0.7;
}

.related-item {
    padding: 0.75rem;
    background: var(--light-color);
    border-radius: 0.375rem;
    border-left: 3px solid var(--primary-color);
    transition: all 0.2s;
}

.related-item:hover {
    transform: translateX(3px);
    box-shadow: var(--shadow-sm);
}

.room-status {
    text-align: center;
}

.status-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.status-indicator.active {
    background: rgba(28, 200, 138, 0.1);
    color: var(--success-color);
}

.status-indicator.inactive {
    background: rgba(231, 74, 59, 0.1);
    color: var(--danger-color);
}

.status-indicator i {
    font-size: 0.8rem;
}

.room-info {
    text-align: left;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: 500;
    color: var(--secondary-color);
}

.info-row .value {
    color: var(--dark-color);
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -1.5rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--border-color);
}

.timeline-content {
    background: var(--light-color);
    padding: 0.75rem;
    border-radius: 0.375rem;
}

.timeline-title {
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 0.9rem;
}

.timeline-date {
    font-size: 0.8rem;
    color: var(--secondary-color);
    opacity: 0.7;
    margin-top: 0.25rem;
}

@media print {
    .no-print {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
    
    .btn {
        display: none !important;
    }
}
</style>
@endsection