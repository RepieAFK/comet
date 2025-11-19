@extends('layouts.app')

@section('title', 'Jadwal Ruangan')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Ruangan</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
    <a href="{{ route('jadwal_reguler.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus fa-sm me-2"></i>Tambah Jadwal Reguler
    </a>
    @endif
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="jadwalTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="reguler-tab" data-bs-toggle="tab" data-bs-target="#reguler" type="button" role="tab" aria-controls="reguler" aria-selected="true">Jadwal Reguler</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="peminjaman-tab" data-bs-toggle="tab" data-bs-target="#peminjaman" type="button" role="tab" aria-controls="peminjaman" aria-selected="false">Jadwal Peminjaman Minggu Ini</button>
    </li>
</ul>

<div class="tab-content" id="jadwalTabContent">
    <!-- Jadwal Reguler Tab -->
    <div class="tab-pane fade show active" id="reguler" role="tabpanel" aria-labelledby="reguler-tab">
        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Ruangan / Hari</th>
                                <th colspan="5" class="text-center">Senin - Jumat</th>
                            </tr>
                            <tr>
                                <th class="text-center">Senin</th>
                                <th class="text-center">Selasa</th>
                                <th class="text-center">Rabu</th>
                                <th class="text-center">Kamis</th>
                                <th class="text-center">Jumat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangans as $ruangan)
                            <tr>
                                <td class="align-middle fw-bold">{{ $ruangan->nama_ruangan }}</td>
                                @foreach($hari as $h)
                                <td>
                                    @for($i = 1; $i <= 12; $i++)
                                        @php
                                            $key = $ruangan->id . '-' . $h . '-' . $i;
                                            $jadwal = $jadwalRegulers->get($key);
                                        @endphp
                                        @if($jadwal)
                                            <div class="alert alert-info p-1 mb-1" style="font-size: 0.75rem;">
                                                <strong>Sesi {{ $i }}</strong><br>
                                                {{ $jadwal->kegiatan }}
                                            </div>
                                        @else
                                            <div class="text-muted p-1 mb-1" style="font-size: 0.75rem;">Sesi {{ $i }} - Kosong</div>
                                        @endif
                                    @endfor
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Peminjaman Tab -->
    <div class="tab-pane fade" id="peminjaman" role="tabpanel" aria-labelledby="peminjaman-tab">
        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Ruangan / Tanggal</th>
                                @php
                                    $startOfWeek = now()->startOfWeek();
                                    $dates = [];
                                    for($i = 0; $i < 5; $i++) {
                                        $dates[] = $startOfWeek->copy()->addDays($i);
                                    }
                                @endphp
                                @foreach($dates as $date)
                                <th colspan="12" class="text-center">{{ $date->format('d M') }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($dates as $date)
                                    @for($i = 1; $i <= 12; $i++)
                                        <th class="text-center" style="font-size: 0.7rem;">{{ $i }}</th>
                                    @endfor
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangans as $ruangan)
                            <tr>
                                <td class="align-middle fw-bold">{{ $ruangan->nama_ruangan }}</td>
                                @foreach($dates as $date)
                                    @for($i = 1; $i <= 12; $i++)
                                        @php
                                            $key = $ruangan->id . '-' . $date->format('Y-m-d') . '-' . $i;
                                            $peminjaman = $peminjamans->get($key);
                                        @endphp
                                        <td class="text-center p-1" style="font-size: 0.7rem;">
                                            @if($peminjaman)
                                                <div class="alert alert-warning p-1 mb-0" style="font-size: 0.6rem; cursor: pointer;" 
                                                     title="{{ $peminjaman->user->name }} - {{ $peminjaman->keperluan }}">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @else
                                                <div class="text-muted">-</div>
                                            @endif
                                        </td>
                                    @endfor
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection