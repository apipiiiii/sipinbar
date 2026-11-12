@extends('layouts.base')

@section('shell')
@php
    $perluAksiAdmin = \App\Models\Peminjaman::whereIn('status', ['pending', 'dicek_petugas'])->count();
    $jumlahHilang   = \App\Models\BarangHilang::where('status', 'belum_diganti')->count();

    // [route, label, ikon, pola route aktif, badge, warna badge]
    $menu = [
        'Operasional' => [
            ['admin.dashboard', 'Dashboard', 'fa-chart-pie', 'admin.dashboard', 0, ''],
            ['admin.peminjaman.index', 'Verifikasi Peminjaman', 'fa-clipboard-check', 'admin.peminjaman.*', $perluAksiAdmin, 'bg-yellow-100 text-yellow-800'],
            ['admin.hilang.index', 'Barang Hilang', 'fa-box-open', 'admin.hilang.*', $jumlahHilang, 'bg-rose-100 text-rose-700'],
        ],
        'Master Data' => [
            ['admin.barang.index', 'Data Barang', 'fa-cubes', 'admin.barang.*', 0, ''],
            ['admin.kategori.index', 'Kategori Barang', 'fa-tags', 'admin.kategori.*', 0, ''],
            ['admin.users.index', 'Data Pengguna', 'fa-users', 'admin.users.*', 0, ''],
        ],
        'Laporan' => [
            ['admin.laporan.index', 'Laporan & Rekap', 'fa-file-lines', 'admin.laporan.*', 0, ''],
        ],
    ];
    $roleLabel = 'Administrator';
@endphp

<div id="sp-overlay" onclick="spMenu(false)" class="hidden fixed inset-0 z-30 bg-slate-900/40 lg:hidden"></div>

<aside id="sp-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:translate-x-0">
    <div class="sb-brand flex h-14 items-center gap-2.5 border-b border-slate-100 px-5">
        @include('layouts.partials.brand')
        <div class="sb-label min-w-0 flex-1 leading-tight">
            <p class="text-sm font-semibold tracking-tight text-slate-900">SIPINBAR</p>
            <p class="text-[11px] text-slate-500">Panel Admin</p>
        </div>
    </div>

    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-4">
        @foreach($menu as $grup => $items)
            <div>
                <p class="sb-group-title mb-1.5 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $grup }}</p>
                <div class="space-y-0.5">
                @foreach($items as [$rt, $label, $icon, $pola, $badge, $badgeCls])
                    @php $aktif = request()->routeIs($pola); @endphp
                    <a href="{{ route($rt) }}" title="{{ $label }}" class="sb-item group flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition {{ $aktif ? 'bg-brand-50 font-medium text-brand-700 shadow-[inset_3px_0_0_0_rgb(var(--b600))]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid {{ $icon }} w-4 text-center text-[13px] {{ $aktif ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                        <span class="sb-label flex-1 truncate">{{ $label }}</span>
                        @if($badge > 0)<span class="sb-badge rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $badgeCls }}">{{ $badge }}</span>@endif
                    </a>
                @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="space-y-0.5 border-t border-slate-100 p-3">
        <button type="button" id="sp-sb-toggle" title="Lipat / bentangkan menu" onclick="spCollapse()" class="sb-item hidden w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 lg:flex">
            <i class="fa-solid fa-angles-left w-4 text-center text-[13px] text-slate-400 transition-transform"></i> <span class="sb-label">Lipat menu</span>
        </button>
        <a href="{{ route('profile.edit') }}" title="Profil & Kata Sandi" class="sb-item flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('profile.*') ? 'bg-brand-50 font-medium text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-user-gear w-4 text-center text-[13px] {{ request()->routeIs('profile.*') ? 'text-brand-600' : 'text-slate-400' }}"></i> <span class="sb-label">Profil & Kata Sandi</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button title="Keluar" class="sb-item flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-rose-50 hover:text-rose-700">
                <i class="fa-solid fa-right-from-bracket w-4 text-center text-[13px] text-slate-400"></i> <span class="sb-label">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<div id="sp-main-wrap" class="lg:pl-64">
    <header class="sticky top-0 z-20 flex h-14 items-center gap-3 border-b border-slate-200 bg-white px-4 lg:px-8">
        <button type="button" onclick="spMenu(true)" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <p class="hidden text-sm text-slate-500 sm:block"><i class="fa-regular fa-calendar mr-1.5 text-slate-400"></i>{{ now()->translatedFormat('l, d F Y') }}</p>
        <p class="text-sm font-semibold text-slate-900 sm:hidden">@yield('title', 'SIPINBAR')</p>
        <div class="ml-auto flex items-center gap-1.5">
            @include('layouts.partials.palette-trigger')
            {{-- Aksi cepat --}}
            <div class="relative">
                <button type="button" data-dd-toggle="sp-quick" class="btn btn-primary btn-sm hidden sm:inline-flex"><i class="fa-solid fa-plus text-[10px]"></i> Tambah <i class="fa-solid fa-chevron-down text-[9px] opacity-70"></i></button>
                <button type="button" data-dd-toggle="sp-quick" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-white sm:hidden" aria-label="Tambah"><i class="fa-solid fa-plus text-sm"></i></button>
                <div id="sp-quick" class="absolute right-0 top-full z-50 mt-2 hidden w-52 rounded-xl border border-slate-200 bg-white p-1.5 shadow-pop">
                    <a href="{{ route('admin.barang.create') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fa-solid fa-cubes w-4 text-center text-slate-400"></i> Barang baru</a>
                    <a href="{{ route('admin.kategori.create') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fa-solid fa-tags w-4 text-center text-slate-400"></i> Kategori baru</a>
                    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fa-solid fa-user-plus w-4 text-center text-slate-400"></i> Pengguna baru</a>
                </div>
            </div>
            @include('layouts.partials.notif')
            <span class="mx-1 hidden h-6 w-px bg-slate-200 sm:block"></span>
            @include('layouts.partials.user-chip')
        </div>
    </header>

    <main class="mx-auto w-full max-w-[1400px] px-4 py-6 lg:px-8">
        @include('layouts.partials.flash')
        @yield('content')
    </main>
</div>

@php
    $paletteItems = collect($menu)->flatMap(fn ($items, $grup) => collect($items)->map(fn ($i) => [$i[1], route($i[0]), $i[2], $grup]))->values()->all();
    $paletteItems = array_merge($paletteItems, [
        ['Tambah barang baru', route('admin.barang.create'), 'fa-plus', 'Aksi cepat'],
        ['Tambah kategori baru', route('admin.kategori.create'), 'fa-plus', 'Aksi cepat'],
        ['Tambah pengguna baru', route('admin.users.create'), 'fa-user-plus', 'Aksi cepat'],
        ['Profil & kata sandi', route('profile.edit'), 'fa-user-gear', 'Akun'],
    ]);
@endphp
@include('layouts.partials.palette')

<script>
    function spCollapse() {
        var d = document.documentElement, lipat = d.getAttribute('data-sb') !== 'collapsed';
        if (lipat) d.setAttribute('data-sb', 'collapsed'); else d.removeAttribute('data-sb');
        try { localStorage.setItem('sp_sb', lipat ? '1' : '0'); } catch (e) {}
    }
    function spMenu(open) {
        document.getElementById('sp-sidebar').classList.toggle('-translate-x-full', !open);
        document.getElementById('sp-overlay').classList.toggle('hidden', !open);
    }
</script>
@endsection
