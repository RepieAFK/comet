@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Peminjaman</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('laporan.print') }}" method="GET" target="_blank">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" name="start_date" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               id="end_date" name="end_date" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-print me-2"></i>Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <hr>

        <form action="{{ route('laporan.export') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="start_date_excel" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('start_date_excel') is-invalid @enderror" 
                               id="start_date_excel" name="start_date" required>
                        @error('start_date_excel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="end_date_excel" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control @error('end_date_excel') is-invalid @enderror" 
                               id="end_date_excel" name="end_date" required>
                        @error('end_date_excel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-file-excel me-2"></i>Export Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i>
            Pilih rentang tanggal untuk mencetak atau mengekspor laporan peminjaman.
        </div>
    </div>
</div>
@endsection