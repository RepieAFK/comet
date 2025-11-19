@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2">Data Peminjaman</h1>
    @if(auth()->user()->isPeminjam())
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Ajukan Peminjaman
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                            <th>Peminjam</th>
                        @endif
                        <th>Ruangan</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->id }}</td>
                            @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                <td>{{ $peminjaman->user->name }}</td>
                            @endif
                            <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->addHours($peminjaman->waktu_selesai)->format('d-m-Y H:i') }}</td>
                            <td>{{ Str::limit($peminjaman->keperluan, 50) }}</td>
                            <td>
                                <span class="status-badge status-{{ $peminjaman->status }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if((auth()->user()->isAdmin() || auth()->user()->isPetugas()) && $peminjaman->status == 'menunggu')
                                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if((auth()->user()->isAdmin() || auth()->user()->isPetugas()) && in_array($peminjaman->status, ['menunggu', 'disetujui']))
                                    <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isPetugas() ? '8' : '7' }}" class="text-center">
                                Belum ada data peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection