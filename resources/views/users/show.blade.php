@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail User: {{ $user->name }}</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- User Details Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi User</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Lengkap</div>
                    <div class="col-md-8">{{ $user->name }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Email</div>
                    <div class="col-md-8">{{ $user->email }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Role</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $user->role == 'administrator' ? 'danger' : ($user->role == 'petugas' ? 'warning' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nomor Induk</div>
                    <div class="col-md-8">{{ $user->nomor_induk }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nomor Telepon</div>
                    <div class="col-md-8">{{ $user->telepon ?? '-' }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Bergabung</div>
                    <div class="col-md-8">{{ $user->created_at->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
            </div>
            <div class="card-body">
                @if($recentPeminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPeminjaman as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                                        <td>{{ $peminjaman->waktu_mulai->format('d M Y') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $peminjaman->status }}">
                                                {{ ucfirst($peminjaman->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">User ini belum pernah melakukan peminjaman.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Stats Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Peminjaman
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPeminjaman }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        @if($user->id != Auth::user()->id)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Edit User
                </a>
                
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                        <i class="fas fa-trash me-1"></i> Hapus User
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection