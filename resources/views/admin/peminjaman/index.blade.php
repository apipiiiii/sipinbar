@extends('layouts.admin')
@section('title', 'Verifikasi Peminjaman')
@section('content')
<div class="mb-6"><h1 class="page-title">Verifikasi Peminjaman</h1><p class="page-sub">Proses pengajuan dan pantau seluruh transaksi peminjaman.</p></div>

@php
    $tab = [
        '' => 'Semua', 'pending' => 'Perlu verifikasi', 'disetujui' => 'Menunggu penyerahan', 'approved' => 'Dipinjam',
        'terlambat' => 'Terlambat', 'pengembalian' => 'Pengembalian', 'dicek_petugas' => 'Konfirmasi akhir', 'selesai' => 'Selesai',
    ];
    $aktifTab = (string) request('status', '');
@endphp
<div class="mb-4 flex gap-2 overflow-x-auto pb-1">
    @foreach($tab as $val => $label)
        <a href="{{ route('admin.peminjaman.index', array_filter(['status' => $val, 'q' => request('q')])) }}"
           class="inline-flex shrink-0 items-center gap-2 rounded-full border px-3.5 py-1.5 text-sm transition {{ $aktifTab === (string) $val ? 'border-brand-600 bg-brand-600 font-medium text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:text-slate-900' }}">
            {{ $label }}
            <span class="rounded-full px-1.5 text-[11px] font-semibold {{ $aktifTab === (string) $val ? 'bg-white/20 text-white' : ($val === 'terlambat' && $hitung[$val] > 0 ? 'bg-rose-100 text-rose-700' : ($val === 'pending' && $hitung[$val] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-500')) }}">{{ $hitung[$val] }}</span>
        </a>
    @endforeach
</div>

<form class="relative mb-5 max-w-md">
    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode atau nama siswa..." class="input pl-9">
</form>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th><th>Siswa</th><th>Barang</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Status</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($peminjaman as $p)
                <tr class="transition {{ $p->isTerlambat() ? 'bg-rose-50 hover:bg-rose-100' : 'hover:bg-slate-50' }}">
                    <td class="font-medium text-slate-800">{{ $p->kode_peminjaman }}</td>
                    <td class="text-slate-600">{{ $p->siswa->name }}</td>
                    <td class="text-slate-600">{{ $p->barang->nama_barang }}</td>
                    <td class="text-slate-600">{{ $p->jumlah }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td>
                        <x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" />
                        @if($p->dendaSaatIni() > 0)
                            <div class="text-xs mt-1 {{ $p->status === 'approved' || ! $p->denda_lunas ? 'text-rose-700' : 'text-emerald-700' }}">Denda {{ \App\Models\Peminjaman::rupiah($p->dendaSaatIni()) }} &bull; {{ $p->statusDenda() }}</div>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.peminjaman.show', $p) }}" class="btn btn-primary btn-sm">Kelola</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $peminjaman->links() }}</div>
</div>
@endsection
