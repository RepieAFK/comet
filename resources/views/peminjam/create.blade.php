@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ajukan Peminjaman Ruangan</h1>
</div>

<div class="card">
    <div class="card-body">
        <!-- Perhatikan method="POST" dan action dengan benar -->
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf <!-- Token CSRF WAJIB -->
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ruangan_id" class="form-label">Pilih Ruangan</label>
                        <select class="form-select @error('ruangan_id') is-invalid @enderror" 
                                id="ruangan_id" name="ruangan_id" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" 
                                        {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                               id="tanggal" name="tanggal" value="{{ old('tanggal') }}" 
                               min="{{ $minDate }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="sesi" class="form-label">Pilih Sesi</label>
                        <div class="row">
                            @foreach($sesi as $s)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sesi" id="sesi{{ $s }}" value="{{ $s }}" @if(old('sesi') == $s) checked @endif required>
                                        <label class="form-check-label" for="sesi{{ $s }}">
                                            Sesi {{ $s }} <br>
                                            <small>{{ \Carbon\Carbon::createFromTime(7,0)->addMinutes(($s-1)*45)->format('H:i') }} - {{ \Carbon\Carbon::createFromTime(7,0)->addMinutes(($s-1)*45 + 45)->format('H:i') }}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('sesi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan Peminjaman</label>
                <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                          id="keperluan" name="keperluan" rows="4" required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Pastikan ruangan dan waktu yang dipilih tidak bentrok dengan jadwal lain. Jadwal hanya berlaku Senin - Jumat.
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
            </div>
        </form>
    </div>
</div>
@endsection