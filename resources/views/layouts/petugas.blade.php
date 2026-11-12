@extends('layouts.base')

@section('shell')
@php
    $tugasPetugas = \App\Models\Peminjaman::untukPetugas(auth()->id())->whereIn('status', ['disetujui', 'pengembalian'])->count();
    $kategoriSaya = auth()->user()->kategoriDiampu()->orderBy('nama_kategori')->pluck('nama_kategori');
    $roleLabel = 'Petugas Sarpras';

    $menu = [
        ['petugas.dashboard', 'Beranda', 'fa-house', 'petugas.dashboard', 0],
        ['petugas.peminjaman.index', 'Tugas', 'fa-hand-holding-hand', 'petugas.peminjaman.*', $tugasPetugas],
        ['profile.edit', 'Profil', 'fa-user-gear', 'profile.*', 0],
    ];
@endphp

{{-- Rail ikon (desktop) --}}
<aside class="fixed inset-y-0 left-0 z-40 hidden w-[84px] flex-col items-center border-r border-slate-200 bg-white py-4 lg:flex">
    <div class="mb-5">@include('layouts.partials.brand')</div>
    <nav class="flex w-full flex-1 flex-col items-center gap-1 px-2">
        @foreach($menu as [$rt, $label, $icon, $pola, $badge])
            @php $aktif = request()->routeIs($pola); @endphp
            <a href="{{ route($rt) }}" title="{{ $label }}" class="relative flex w-full flex-col items-center gap-1 rounded-lg px-1 py-2.5 text-[11px] font-medium transition {{ $aktif ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid {{ $icon }} text-base"></i>
                {{ $label }}
                @if($badge > 0)<span class="absolute right-2 top-1.5 min-w-[18px] rounded-full bg-yellow-600 px-1 text-center text-[10px] font-bold leading-[18px] text-white">{{ $badge }}</span>@endif
            </a>
        @endforeach
    </nav>
    <form action="{{ route('logout') }}" method="POST" class="m-0 w-full px-2">
        @csrf
        <button title="Keluar" class="flex w-full flex-col items-center gap-1 rounded-lg px-1 py-2.5 text-[11px] font-medium text-slate-500 transition hover:bg-rose-50 hover:text-rose-700">
            <i class="fa-solid fa-right-from-bracket text-base"></i> Keluar
        </button>
    </form>
</aside>

<div class="lg:pl-[84px]">
    <header class="sticky top-0 z-20 flex h-14 items-center gap-3 border-b border-slate-200 bg-white px-4 lg:px-8">
        <span class="lg:hidden">@include('layouts.partials.brand')</span>
        <div class="min-w-0 leading-tight">
            <p class="text-sm font-semibold text-slate-900">Panel Petugas</p>
            <p class="truncate text-[11px] text-slate-500">
                @if($kategoriSaya->isNotEmpty()) Mengampu: {{ $kategoriSaya->implode(', ') }} @else Belum ada kategori yang diampu @endif
            </p>
        </div>
        <div class="ml-auto flex items-center gap-1.5">
            @include('layouts.partials.palette-trigger')
            @include('layouts.partials.notif')
            <span class="mx-1 hidden h-6 w-px bg-slate-200 sm:block"></span>
            @include('layouts.partials.user-chip')
        </div>
    </header>

    <main class="mx-auto w-full max-w-[1200px] px-4 py-6 pb-24 lg:px-8 lg:pb-8">
        @include('layouts.partials.flash')
        @yield('content')
    </main>
</div>

@php
    $paletteItems = [
        ['Beranda', route('petugas.dashboard'), 'fa-house', 'Menu'],
        ['Tugas konfirmasi barang', route('petugas.peminjaman.index'), 'fa-hand-holding-hand', 'Menu'],
        ['Semua peminjaman kategori saya', route('petugas.peminjaman.index', ['tampil' => 'semua']), 'fa-list', 'Menu'],
        ['Profil & kata sandi', route('profile.edit'), 'fa-user-gear', 'Akun'],
    ];
@endphp
@include('layouts.partials.palette')

{{-- Tab bawah (mobile) --}}
<nav class="fixed inset-x-0 bottom-0 z-30 grid grid-cols-4 border-t border-slate-200 bg-white lg:hidden">
    @foreach($menu as [$rt, $label, $icon, $pola, $badge])
        @php $aktif = request()->routeIs($pola); @endphp
        <a href="{{ route($rt) }}" class="relative flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium {{ $aktif ? 'text-brand-700' : 'text-slate-500' }}">
            <i class="fa-solid {{ $icon }} text-base"></i>{{ $label }}
            @if($badge > 0)<span class="absolute left-1/2 top-1 ml-2 min-w-[16px] rounded-full bg-yellow-600 px-1 text-center text-[10px] font-bold leading-4 text-white">{{ $badge }}</span>@endif
        </a>
    @endforeach
    <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button class="flex w-full flex-col items-center gap-0.5 py-2 text-[11px] font-medium text-slate-500"><i class="fa-solid fa-right-from-bracket text-base"></i>Keluar</button>
    </form>
</nav>
@endsection
