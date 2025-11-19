@extends('layouts.app')

@section('title', 'Tambah Jadwal Reguler')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Reguler</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Jadwal Reguler</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('jadwal_reguler.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ruangan_id" class="form-label">Ruangan</label>
                        <select class="form-select @error('ruangan_id') is-invalid @enderror" name="ruangan_id" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <select class="form-select @error('hari') is-invalid @enderror" name="hari" required>
                            <option value="">-- Pilih Hari --</option>
                            @foreach($hari as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                        @error('hari')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sesi" class="form-label">Sesi</label>
                        <select class="form-select @error('sesi') is-invalid @enderror" name="sesi" required>
                            <option value="">-- Pilih Sesi --</option>
                            @foreach($sesi as $s)
                                <option value="{{ $s }}" {{ old('sesi') == $s ? 'selected' : '' }}>Sesi {{ $s }} ({{ \Carbon\Carbon::createFromTime(7,0)->addMinutes(($s-1)*45)->format('H:i') }})</option>
                            @endforeach
                        </select>
                        @error('sesi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" name="kegiatan" value="{{ old('kegiatan') }}" placeholder="Contoh: Matematika Dasar" required>
                @error('kegiatan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection