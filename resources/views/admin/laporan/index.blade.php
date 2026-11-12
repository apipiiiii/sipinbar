@extends('layouts.admin')
@section('title', 'Laporan & Rekapitulasi')
@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div><h1 class="page-title">Laporan & Rekap</h1><p class="page-sub">Rekapitulasi transaksi peminjaman, dapat dicetak atau diekspor.</p></div>
    <div class="flex gap-2">
        <a href="{{ route('admin.laporan.export.pdf', request()->query()) }}" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
        <a href="{{ route('admin.laporan.export.excel', request()->query()) }}" class="btn border border-emerald-200 bg-white text-emerald-700 hover:bg-emerald-50"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
    </div>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="">Semua Status</option>
                @foreach(\App\Models\Peminjaman::daftarStatus() as $val=>$label)
                    <option value="{{ $val }}" @selected(request('status')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" class="input">
        </div>
        <div>
            <label class="label">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="input">
        </div>
        <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-5">
    <div class="card p-4 text-center">
        <div class="text-2xl font-semibold text-slate-900">{{ $rekap['total'] }}</div><div class="text-xs text-slate-500 mt-1">Total</div>
    </div>
    <div class="card p-4 text-center">
        <div class="text-2xl font-semibold text-yellow-700">{{ $rekap['pending'] }}</div><div class="text-xs text-slate-500 mt-1">Pending</div>
    </div>
    <div class="card p-4 text-center">
        <div class="text-2xl font-semibold text-brand-700">{{ $rekap['approved'] }}</div><div class="text-xs text-slate-500 mt-1">Dalam Proses / Dipinjam</div>
    </div>
    <div class="card p-4 text-center">
        <div class="text-2xl font-semibold text-rose-700">{{ $rekap['rejected'] }}</div><div class="text-xs text-slate-500 mt-1">Ditolak</div>
    </div>
    <div class="card p-4 text-center">
        <div class="text-2xl font-semibold text-emerald-700">{{ $rekap['selesai'] }}</div><div class="text-xs text-slate-500 mt-1">Selesai</div>
    </div>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th><th>Siswa</th><th>Barang</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Status</th><th>Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($data as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800">{{ $p->kode_peminjaman }}</td>
                    <td class="text-slate-600">{{ $p->siswa->name ?? '-' }}</td>
                    <td class="text-slate-600">{{ $p->barang->nama_barang ?? '-' }}</td>
                    <td class="text-slate-600">{{ $p->jumlah }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td><x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" /></td>
                    <td class="{{ $p->dendaSaatIni() > 0 ? 'text-rose-700' : 'text-slate-500' }}">{{ $p->dendaSaatIni() > 0 ? \App\Models\Peminjaman::rupiah($p->dendaSaatIni()).' ('.$p->statusDenda().')' : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Tidak ada data untuk filter ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $data->links() }}</div>
</div>
@endsection
