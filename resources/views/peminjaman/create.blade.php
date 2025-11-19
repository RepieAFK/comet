@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ajukan Peminjaman Ruangan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjamanForm">
            @csrf
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
                            <div class="invalid-feedback">{{ $message }}</div>
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Pilih Sesi (Bisa lebih dari satu)</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Pilih</th>
                                        <th>Sesi</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sesi as $s)
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input sesi-checkbox" type="checkbox" name="sesi[]" value="{{ $s }}" id="sesi{{ $s }}">
                                            </div>
                                        </td>
                                        <td><label for="sesi{{ $s }}" class="mb-0">Sesi {{ $s }}</label></td>
                                        <td>{{ \Carbon\Carbon::createFromTime(7,0)->addMinutes(($s-1)*45)->format('H:i') }} - {{ \Carbon\Carbon::createFromTime(7,0)->addMinutes(($s-1)*45 + 45)->format('H:i') }}</td>
                                        <td class="sesi-status" data-sesi="{{ $s }}">
                                            <span class="badge bg-secondary">Cek ketersediaan</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <small class="text-muted">Centang sesi yang ingin Anda pinjam pada tanggal tersebut.</small>
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Anda dapat memilih lebih dari satu sesi. Pastikan ruangan dan waktu yang dipilih tidak bentrok dengan jadwal lain. Jadwal hanya berlaku Senin - Jumat.
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">Ajukan Peminjaman</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('ruangan_id').addEventListener('change', function() {
        checkAvailability();
    });

    document.getElementById('tanggal').addEventListener('change', function() {
        checkAvailability();
    });

    function checkAvailability() {
        const ruanganId = document.getElementById('ruangan_id').value;
        const tanggal = document.getElementById('tanggal').value;
        
        if (!ruanganId || !tanggal) {
            // Reset status semua sesi
            document.querySelectorAll('.sesi-status').forEach(el => {
                el.innerHTML = '<span class="badge bg-secondary">Cek ketersediaan</span>';
            });
            return;
        }
        
        // Update status untuk setiap sesi
        document.querySelectorAll('.sesi-checkbox').forEach(checkbox => {
            const sesi = checkbox.value;
            const statusEl = checkbox.closest('tr').querySelector('.sesi-status');
            
            fetch(`{{ route('api.check-availability') }}?ruangan_id=${ruanganId}&tanggal=${tanggal}`)
                .then(response => response.json())
                .then(data => {
                    if (data.available_sesi.includes(parseInt(sesi))) {
                        statusEl.innerHTML = '<span class="badge bg-success">Tersedia</span>';
                        checkbox.disabled = false;
                    } else {
                        statusEl.innerHTML = '<span class="badge bg-danger">Tidak Tersedia</span>';
                        checkbox.disabled = true;
                        checkbox.checked = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusEl.innerHTML = '<span class="badge bg-warning">Error</span>';
                });
        });
    }

    // Validasi minimal satu sesi dipilih
    document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.sesi-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Anda harus memilih minimal satu sesi.');
            return false;
        }
    });
</script>
@endsection