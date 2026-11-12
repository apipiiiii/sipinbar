@extends('layouts.user')
@section('title', $barang->nama_barang)
@section('content')
<a href="{{ route('siswa.katalog.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left text-xs"></i> Katalog</a>
<div class="mb-6">
    <h1 class="page-title">{{ $barang->nama_barang }}</h1>
    <p class="page-sub">{{ $barang->kategori->nama_kategori ?? 'Tanpa kategori' }} &bull; {{ $barang->kode_barang }}</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-5">
        @if($barang->foto)
            <img src="{{ asset('storage/'.$barang->foto) }}" class="w-full rounded-xl border border-slate-200 object-cover">
        @else
            <div class="flex h-64 w-full items-center justify-center rounded-xl border border-slate-200 bg-slate-100">
                <i class="fa-solid fa-box text-5xl text-slate-300"></i>
            </div>
        @endif
    </div>
    <div class="lg:col-span-7">
        <div class="card p-5 sm:p-6">
            @php
                $persen = $barang->stok_total > 0 ? round($barang->stok_tersedia / $barang->stok_total * 100) : 0;
                $warna = $barang->stok_tersedia == 0 ? 'bg-rose-500' : ($barang->stok_tersedia <= 2 ? 'bg-yellow-500' : 'bg-brand-600');
            @endphp
            <div class="mb-5 rounded-lg bg-slate-50 p-4">
                <div class="mb-2 flex items-baseline justify-between">
                    <span class="text-sm text-slate-500">Ketersediaan</span>
                    <span class="text-sm font-semibold text-slate-900">{{ $barang->stok_tersedia }} <span class="font-normal text-slate-400">dari {{ $barang->stok_total }} unit</span></span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-slate-200"><div class="h-full rounded-full {{ $warna }}" style="width: {{ $persen }}%"></div></div>
            </div>
            <dl class="divide-y divide-slate-100 text-sm mb-5">
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Kondisi</dt><dd class="text-slate-800 font-medium">{{ ucfirst($barang->kondisi) }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Deskripsi</dt><dd class="text-slate-800 text-right">{{ $barang->deskripsi ?? '-' }}</dd></div>
            </dl>
            <div class="flex gap-2">
                <a href="{{ route('siswa.peminjaman.create', ['barang_id' => $barang->id]) }}"
                   class="btn btn-primary {{ $barang->stok_tersedia==0 ? 'pointer-events-none opacity-50' : '' }}">
                    <i class="fa-solid fa-plus"></i> Ajukan Peminjaman Barang Ini
                </a>
                            </div>
        </div>
    </div>
</div>
@endsection
