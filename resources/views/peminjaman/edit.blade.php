@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Peminjaman</h1>
    <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('peminjaman.update', $peminjaman) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="ruangan_id" class="form-label">Pilih Ruangan</label>
                <select class="form-select @error('ruangan_id') is-invalid @enderror" 
                        id="ruangan_id" name="ruangan_id" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" 
                                {{ old('ruangan_id', $peminjaman->ruangan_id) == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} orang)
                        </option>
                    @endforeach
                </select>
                @error('ruangan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                               id="waktu_mulai" name="waktu_mulai" 
                               value="{{ old('waktu_mulai', $peminjaman->waktu_mulai->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                               id="waktu_selesai" name="waktu_selesai" 
                               value="{{ old('waktu_selesai', $peminjaman->waktu_selesai->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan Peminjaman</label>
                <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                          id="keperluan" name="keperluan" rows="4" required>{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                @error('keperluan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                    <option value="menunggu" {{ old('status', $peminjaman->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ old('status', $peminjaman->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ old('status', $peminjaman->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ old('status', $peminjaman->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                          id="catatan" name="catatan" rows="3">{{ old('catatan', $peminjaman->catatan) }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Pastikan waktu yang dipilih tidak bentrok dengan peminjaman lain.
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection