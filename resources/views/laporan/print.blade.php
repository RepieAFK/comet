<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>LAPORAN PEMINJAMAN RUANGAN</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengajuan</th>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal Pinjam</th>
                <th>Sesi</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $index => $peminjaman)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $peminjaman->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $peminjaman->user->name }}</td>
                <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                <td>{{ $peminjaman->tanggal->format('d/m/Y') }}</td>
                <td class="text-center">{{ $peminjaman->sesi }}</td>
                <td>{{ $peminjaman->keperluan }}</td>
                <td class="text-center">{{ ucfirst($peminjaman->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Di cetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>