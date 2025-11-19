@extends('layouts.app')

@section('title', 'Manajemen Jadwal Reguler')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Jadwal Reguler</h1>
    <a href="{{ route('jadwal_reguler.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus fa-sm me-2"></i>Tambah Jadwal
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Reguler</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>Sesi</th>
                        <th>Kegiatan</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalReguler as $jadwal)
                        <tr>
                            <td>{{ $jadwal->ruangan->nama_ruangan }}</td>
                            <td>{{ $jadwal->hari }}</td>
                            <td>Sesi {{ $jadwal->sesi }}</td>
                            <td>{{ $jadwal->kegiatan }}</td>
                            <td>{{ $jadwal->user->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('jadwal_reguler.edit', $jadwal) }}" class="btn btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jadwal_reguler.destroy', $jadwal) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada jadwal reguler</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection