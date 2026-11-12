<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #222; }
        h2, h4 { margin: 0; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 2px solid #333; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: left; }
        th { background: #eee; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 10px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h4>LAPORAN REKAPITULASI PEMINJAMAN BARANG</h4>
        <h4>SIPINBAR - SMK Negeri 5 Surakarta</h4>
        <p>Periode: {{ $periode }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Kondisi Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
        @forelse($data as $i => $p)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->kode_peminjaman }}</td>
                <td>{{ $p->siswa->name ?? '-' }}</td>
                <td>{{ $p->siswa->kelas ?? '-' }}</td>
                <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $p->jumlah }}</td>
                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                <td>{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d/m/Y') : '-' }}</td>
                <td>{{ $p->labelStatus() }}</td>
                <td>{{ $p->kondisi_kembali ? ucfirst($p->kondisi_kembali) : '-' }}</td>
                <td>{{ $p->dendaSaatIni() > 0 ? \App\Models\Peminjaman::rupiah($p->dendaSaatIni()).' ('.$p->statusDenda().')' : '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="12" class="text-center">Tidak ada data.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total data: {{ $data->count() }} transaksi
    </div>
</body>
</html>
