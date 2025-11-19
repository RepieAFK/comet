<div class="modal-header">
    <h5 class="modal-title">Detail Peminjaman</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <h6>Informasi Peminjam</h6>
            <table class="table table-sm">
                <tr>
                    <td width="30%">ID Peminjaman</td>
                    <td>{{ $peminjaman->id }}</td>
                </tr>
                <tr>
                    <td width="30%">Peminjam</td>
                    <td>{{ $peminjaman->user->name }}</td>
                </tr>
                <tr>
                    <td width="30%">Ruangan</td>
                    <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                </tr>
                <tr>
                    <td width="30%">Waktu Mulai</td>
                    <td>{{ $peminjaman->waktu_mulai->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td width="30%">Waktu Selesai</td>
                    <td>{{ $peminjaman->waktu_selesai->format('d F Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h6>Keperluan</h6>
            <p>{{ $peminjaman->keperluan }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h6>Status</h6>
            <span class="badge bg-{{ $peminjaman->status == 'disetujui' ? 'success' : ($peminjaman->status == 'ditolak' ? 'danger' : 'warning') }}">
                {{ ucfirst($peminjaman->status) }}
            </span>
        </div>
    </div>
</div>