@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Ruangan</h1>
    <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Ruangan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kode Ruangan</div>
                    <div class="col-md-8">{{ $ruangan->kode_ruangan }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Ruangan</div>
                    <div class="col-md-8">{{ $ruangan->nama_ruangan }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kapasitas</div>
                    <div class="col-md-8">{{ $ruangan->kapasitas }} orang</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Lokasi</div>
                    <div class="col-md-8">{{ $ruangan->lokasi }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $ruangan->status == 'tersedia' ? 'success' : 'danger' }}">
                            {{ ucfirst($ruangan->status) }}
                        </span>
                    </div>
                </div>
                
                @if($ruangan->deskripsi)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Deskripsi</div>
                    <div class="col-md-8">{{ $ruangan->deskripsi }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if($ruangan->foto)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Foto Ruangan</h5>
            </div>
            <div class="card-body p-0">
                <img src="{{ asset('uploads/ruangan/' . $ruangan->foto) }}" 
                     class="img-fluid" alt="{{ $ruangan->nama_ruangan }}">
            </div>
        </div>
        @endif
        
        @if(auth()->user()->isAdmin())
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('ruangan.edit', $ruangan) }}" class="btn btn-warning btn-sm w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                
                <form action="{{ route('ruangan.destroy', $ruangan) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin?')">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection