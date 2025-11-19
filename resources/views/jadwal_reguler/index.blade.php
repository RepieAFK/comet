@extends('layouts.app')

@section('title', 'Jadwal Ruangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Jadwal Ruangan</h3>

    @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
        <a href="{{ route('jadwal_reguler.create') }}" class="btn btn-primary btn-sm">
            + Tambah Jadwal Reguler
        </a>
    @endif
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#reguler">Jadwal Reguler</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#peminjaman">Peminjaman Minggu Ini</a>
    </li>
</ul>

<div class="tab-content mt-3">

    {{-- ==================== JADWAL REGULER ==================== --}}
    <div class="tab-pane fade show active" id="reguler">

        <div class="card">
            <div class="card-header">
                <strong>Jadwal Reguler</strong>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ruangan</th>
                            @foreach($hari as $h)
                                <th class="text-center">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ruangans as $ruangan)
                        <tr>
                            <td>{{ $ruangan->nama_ruangan }}</td>

                            @foreach($hari as $h)
                                <td>
                                    @php $ada = false; @endphp

                                    @for($sesi = 1; $sesi <= 12; $sesi++)
                                        @php
                                            $key = $ruangan->id.'-'.$h.'-'.$sesi;
                                            $jadwal = $jadwalRegulers->get($key);
                                        @endphp

                                        @if($jadwal)
                                            <div class="small mb-1">
                                                <strong>Sesi {{ $sesi }}</strong><br>
                                                {{ $jadwal->kegiatan }}
                                            </div>
                                            @php $ada = true; @endphp
                                        @endif
                                    @endfor

                                    @if(!$ada)
                                        <span class="text-muted small">Kosong</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    {{-- ==================== JADWAL PEMINJAMAN ==================== --}}
    <div class="tab-pane fade" id="peminjaman">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <strong>Jadwal Peminjaman Minggu Ini</strong>
                <small>
                    {{ now()->startOfWeek()->format('d M') }} -
                    {{ now()->endOfWeek()->format('d M Y') }}
                </small>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ruangan</th>
                            @foreach($dates as $date)
                                <th>{{ $date->format('d-m-Y') }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ruangans as $ruangan)
                        <tr>
                            <td>{{ $ruangan->nama_ruangan }}</td>

                            @foreach($dates as $date)
                                <td>
                                    @php $ada = false; @endphp

                                    @for($sesi = 1; $sesi <= 12; $sesi++)
                                        @php
                                            $k = $ruangan->id.'-'.$date->format("Y-m-d").'-'.$sesi;
                                            $pinjam = $peminjamans->get($k);
                                        @endphp

                                        @if($pinjam)
                                            <div class="small mb-1">
                                                <strong>Sesi {{ $sesi }}</strong><br>
                                                {{ $pinjam->keperluan }}<br>
                                                <span class="text-muted">{{ $pinjam->user->name }}</span>
                                            </div>
                                            @php $ada = true; @endphp
                                        @endif
                                    @endfor

                                    @if(!$ada)
                                        <span class="text-muted small">Kosong</span>
                                    @endif
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
@endsection
