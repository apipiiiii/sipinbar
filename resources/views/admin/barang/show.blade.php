@extends('layouts.admin')
@section('title', 'Detail Barang')
@section('content')
<h1 class="page-title mb-6">
    Detail Barang: {{ $barang->nama_barang }}
</h1>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-5">
        <div class="card p-5 sm:p-6">
            @if($barang->foto)
                <img src="{{ asset('storage/'.$barang->foto) }}" class="w-full rounded-xl mb-4 ring-1 ring-slate-200">
            @endif
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="flex justify-between py-2"><dt class="text-slate-500">Kode</dt><dd class="text-slate-800 font-medium">{{ $barang->kode_barang }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Kategori</dt><dd class="text-slate-800 font-medium">{{ $barang->kategori->nama_kategori ?? '-' }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Stok Total</dt><dd class="text-slate-800 font-medium">{{ $barang->stok_total }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Stok Tersedia</dt><dd class="text-slate-800 font-medium">{{ $barang->stok_tersedia }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Kondisi</dt><dd class="text-slate-800 font-medium">{{ ucfirst($barang->kondisi) }}</dd></div>
                <div class="flex justify-between py-2 gap-4"><dt class="text-slate-500 shrink-0">Deskripsi</dt><dd class="text-slate-800 text-right">{{ $barang->deskripsi ?? '-' }}</dd></div>
            </dl>
            <div class="mt-5 flex gap-2">
                <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-outline btn-sm">Kembali</a>
            </div>
        </div>
    </div>
    <div class="lg:col-span-7">
        <div class="card">
            <div class="p-5 sm:p-6 border-b border-slate-200"><h2 class="card-title">Riwayat Peminjaman Barang Ini</h2></div>
            <div class="overflow-x-auto">
                <table class="tbl">
                    <thead><tr>
                        <th>Kode</th><th>Siswa</th><th>Jumlah</th><th>Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($barang->peminjaman as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="font-medium text-slate-800">{{ $p->kode_peminjaman }}</td>
                            <td class="text-slate-600">{{ $p->siswa->name ?? '-' }}</td>
                            <td class="text-slate-600">{{ $p->jumlah }}</td>
                            <td><x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum pernah dipinjam.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
