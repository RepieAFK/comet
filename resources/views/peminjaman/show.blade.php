@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Peminjaman</h1>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">ID Peminjaman</div>
                    <div class="col-md-8">{{ $peminjaman->id }}</div>
                </div>
                
                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Peminjam</div>
                    <div class="col-md-8">{{ $peminjaman->user->name }} ({{ $peminjaman->user->nomor_induk }})</div>
                </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Ruangan</div>
                    <div class="col-md-8">{{ $peminjaman->ruangan->nama_ruangan }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Lokasi</div>
                    <div class="col-md-8">{{ $peminjaman->ruangan->lokasi }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Waktu Mulai</div>
                    <div class="col-md-8">{{ $peminjaman->tanggal ? $peminjaman->tanggal->format('d-m-Y') : '-' }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Waktu Selesai</div>
                    <div class="col-md-8">{{ $peminjaman->tanggal ? $peminjaman->tanggal->addHours($peminjaman->waktu_selesai)->format('d-m-Y H:i') : '-' }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Keperluan</div>
                    <div class="col-md-8">{{ $peminjaman->keperluan }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        <span class="status-badge status-{{ $peminjaman->status }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                </div>
                
                @if($peminjaman->catatan)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Catatan</div>
                    <div class="col-md-8">{{ $peminjaman->catatan }}</div>
                </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Pengajuan</div>
                    <div class="col-md-8">{{ $peminjaman->created_at->format('d F Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if($peminjaman->ruangan->foto)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Foto Ruangan</h5>
            </div>
            <div class="card-body p-0">
                <img src="{{ asset('uploads/ruangan/' . $peminjaman->ruangan->foto) }}" 
                     class="img-fluid" alt="{{ $peminjaman->ruangan->nama_ruangan }}">
            </div>
        </div>
        @endif
        
        @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                @if($peminjaman->status == 'menunggu')
                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" class="btn btn-warning btn-sm w-100 mb-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    
                    <form action="{{ route('peminjaman.approve', $peminjaman) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <textarea name="catatan" class="form-control" placeholder="Catatan (opsional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-check me-1"></i> Setujui
                        </button>
                    </form>
                    
                    <form action="{{ route('peminjaman.reject', $peminjaman) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <textarea name="catatan" class="form-control" placeholder="Alasan penolakan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-times me-1"></i> Tolak
                        </button>
                    </form>
                @endif
                
                @if(in_array($peminjaman->status, ['menunggu', 'disetujui']))
                    <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin?')">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection