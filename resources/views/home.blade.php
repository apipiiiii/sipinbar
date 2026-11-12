<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.head')
    <style>
        .rv { opacity: 0; transform: translateY(18px); transition: opacity .6s cubic-bezier(.2,.7,.2,1), transform .6s cubic-bezier(.2,.7,.2,1); transition-delay: var(--d, 0ms); }
        .rv.on { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) { .rv { opacity: 1; transform: none; transition: none; } }
    </style>
</head>
<body class="bg-white">

{{-- Navigasi --}}
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-14 max-w-6xl items-center gap-6 px-4 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            @include('layouts.partials.brand')
            <span class="text-sm font-semibold tracking-tight text-slate-900">SIPINBAR</span>
        </a>
        <nav class="hidden items-center gap-1 text-sm text-slate-600 md:flex">
            <a href="#cara" class="rounded-lg px-3 py-2 hover:bg-slate-50 hover:text-slate-900">Cara meminjam</a>
            <a href="#barang" class="rounded-lg px-3 py-2 hover:bg-slate-50 hover:text-slate-900">Barang tersedia</a>
            <a href="#peran" class="rounded-lg px-3 py-2 hover:bg-slate-50 hover:text-slate-900">Untuk siapa</a>
        </nav>
        <div class="ml-auto flex items-center gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm hidden sm:inline-flex">Daftar</a>
        </div>
    </div>
</header>

<main>
    {{-- Hero --}}
    <section class="bg-hero overflow-hidden border-b border-slate-200">
        <span class="deco-ico deco-ico-lt hidden lg:flex" style="top:10%;left:46%;width:52px;height:52px;--r:8deg"><i class="fa-solid fa-flask"></i></span>
        <span class="deco-ico deco-ico-lt hidden lg:flex" style="bottom:12%;left:50%;width:46px;height:46px;--r:-6deg;animation-delay:-3s"><i class="fa-solid fa-laptop"></i></span>
        <span class="deco-ico deco-ico-lt hidden lg:flex" style="top:8%;right:4%;width:44px;height:44px;--r:-8deg;animation-delay:-5s"><i class="fa-solid fa-book"></i></span>
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] lg:px-8 lg:py-20">
            <div>
                <p class="rv inline-flex items-center gap-2 rounded-full border border-brand-200 bg-brand-50 px-3 py-1 text-xs font-medium text-brand-800"><i class="fa-solid fa-circle text-[6px] text-brand-500"></i> SMK Negeri 5 Surakarta</p>
                <h1 class="rv mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-slate-900 sm:text-5xl" style="--d:60ms">Pinjam barang sekolah, tanpa antre dan tanpa kertas.</h1>
                <p class="rv mt-5 max-w-xl text-base leading-relaxed text-slate-600" style="--d:120ms">Ajukan peminjaman dari ponsel, pantau statusnya, dan ketahui kapan barang harus kembali. Semua tercatat rapi dari pengajuan sampai pengembalian.</p>
                <div class="rv mt-8 flex flex-wrap gap-3" style="--d:180ms">
                    <a href="{{ route('register') }}" class="btn btn-primary px-5 py-2.5">Daftar sebagai siswa <i class="fa-solid fa-arrow-right text-xs"></i></a>
                    <a href="{{ route('login') }}" class="btn btn-outline px-5 py-2.5">Saya sudah punya akun</a>
                </div>

                <dl class="rv mt-10 grid grid-cols-2 gap-x-8 gap-y-5 sm:grid-cols-4" style="--d:240ms">
                    @foreach([[$stat['jenis'], 'Jenis barang'], [$stat['tersedia'], 'Unit tersedia'], [$stat['selesai'], 'Peminjaman selesai'], [$stat['siswa'], 'Siswa terdaftar']] as [$angka, $label])
                        <div>
                            <dd class="text-2xl font-semibold tracking-tight text-slate-900" data-hitung="{{ $angka }}">{{ $angka }}</dd>
                            <dt class="mt-0.5 text-xs text-slate-500">{{ $label }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Ketersediaan langsung --}}
            <div class="rv card p-5 shadow-pop" style="--d:150ms">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Ketersediaan saat ini</p>
                        <p class="text-xs text-slate-500">Diperbarui otomatis setiap ada transaksi</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Langsung</span>
                </div>
                @forelse($barang->take(4) as $b)
                    @php $persen = $b->stok_total > 0 ? round($b->stok_tersedia / $b->stok_total * 100) : 0; @endphp
                    <div class="border-t border-slate-100 py-3 first:border-0 first:pt-0">
                        <div class="mb-1.5 flex items-center justify-between gap-3">
                            <span class="truncate text-sm font-medium text-slate-800">{{ $b->nama_barang }}</span>
                            <span class="shrink-0 text-xs text-slate-500"><b class="font-semibold text-slate-800">{{ $b->stok_tersedia }}</b> / {{ $b->stok_total }} unit</span>
                        </div>
                        <div class="h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-brand-600" style="width: {{ $persen }}%"></div></div>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-slate-400">Belum ada barang yang tersedia.</p>
                @endforelse
                <a href="{{ route('login') }}" class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-brand-700 hover:underline">Masuk untuk melihat katalog lengkap <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
            </div>
        </div>
    </section>

    {{-- Cara meminjam --}}
    <section id="cara" class="mx-auto max-w-6xl px-4 py-16 lg:px-8">
        <div class="rv max-w-xl">
            <p class="text-sm font-semibold text-brand-700">Cara meminjam</p>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Empat langkah, semuanya terpantau</h2>
        </div>
        <ol class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['fa-paper-plane', 'Ajukan', 'Pilih barang di katalog, lalu kirim pengajuan. Tanggal kembali dihitung otomatis.'],
                ['fa-clipboard-check', 'Diverifikasi', 'Admin memeriksa pengajuan dan menyetujuinya. Anda mendapat notifikasi.'],
                ['fa-hand-holding-hand', 'Ambil barang', 'Datangi petugas sarpras untuk serah-terima barang. Bukti peminjaman bisa dicetak.'],
                ['fa-rotate-left', 'Kembalikan', 'Serahkan barang tepat waktu agar terhindar dari denda keterlambatan.'],
            ] as $i => [$ikon, $judul, $isi])
                <li class="rv card p-5" style="--d: {{ $i * 80 }}ms">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700"><i class="fa-solid {{ $ikon }}"></i></span>
                        <span class="text-sm font-semibold text-slate-300">0{{ $i + 1 }}</span>
                    </div>
                    <h3 class="font-semibold text-slate-900">{{ $judul }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Barang tersedia --}}
    <section id="barang" class="border-y border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-16 lg:px-8">
            <div class="rv flex flex-wrap items-end justify-between gap-4">
                <div class="max-w-xl">
                    <p class="text-sm font-semibold text-brand-700">Katalog</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Barang yang bisa dipinjam</h2>
                </div>
                <a href="{{ route('login') }}" class="link text-sm">Lihat semua di katalog <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
            </div>

            @if($kategori->isNotEmpty())
                <div class="rv mt-6 flex flex-wrap gap-2">
                    @foreach($kategori as $k)
                        <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600">{{ $k->nama_kategori }} <span class="text-slate-400">· {{ $k->barang_count }}</span></span>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($barang as $i => $b)
                    @php
                        $persen = $b->stok_total > 0 ? round($b->stok_tersedia / $b->stok_total * 100) : 0;
                        $warna = $b->stok_tersedia <= 2 ? 'bg-yellow-500' : 'bg-brand-600';
                    @endphp
                    <div class="rv card overflow-hidden" style="--d: {{ ($i % 3) * 80 }}ms">
                        @if($b->foto)
                            <img src="{{ asset('storage/'.$b->foto) }}" alt="{{ $b->nama_barang }}" class="h-40 w-full object-cover">
                        @else
                            <div class="flex h-40 items-center justify-center bg-slate-100"><i class="fa-solid fa-box text-3xl text-slate-300"></i></div>
                        @endif
                        <div class="p-4">
                            <p class="text-[11px] font-medium text-brand-700">{{ $b->kategori->nama_kategori ?? 'Tanpa kategori' }}</p>
                            <h3 class="mt-0.5 font-semibold text-slate-900">{{ $b->nama_barang }}</h3>
                            <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                                <span>Tersedia</span><span><b class="font-semibold text-slate-800">{{ $b->stok_tersedia }}</b> / {{ $b->stok_total }}</span>
                            </div>
                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full {{ $warna }}" style="width: {{ $persen }}%"></div></div>
                            <a href="{{ route('login') }}" class="btn btn-outline btn-sm mt-4 w-full">Masuk untuk meminjam</a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full py-12 text-center text-sm text-slate-400">Belum ada barang yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Untuk siapa --}}
    <section id="peran" class="mx-auto max-w-6xl px-4 py-16 lg:px-8">
        <div class="rv max-w-xl">
            <p class="text-sm font-semibold text-brand-700">Untuk siapa</p>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Satu sistem, tiga peran</h2>
        </div>
        <div class="mt-10 grid gap-5 md:grid-cols-3">
            @foreach([
                ['fa-user-graduate', 'Siswa', 'Telusuri katalog, ajukan peminjaman, pantau tahapan dan batas kembali, serta terima pengingat jatuh tempo.'],
                ['fa-people-carry-box', 'Petugas sarpras', 'Kelola serah-terima barang pada kategori yang diampu, dengan antrian tugas dan agenda jatuh tempo.'],
                ['fa-user-shield', 'Admin', 'Verifikasi pengajuan, kelola data barang dan pengguna, pantau grafik, dan cetak laporan rekap.'],
            ] as $i => [$ikon, $judul, $isi])
                <div class="rv card p-6" style="--d: {{ $i * 80 }}ms">
                    <span class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-700"><i class="fa-solid {{ $ikon }}"></i></span>
                    <h3 class="font-semibold text-slate-900">{{ $judul }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-500">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Ajakan --}}
    <section class="mx-auto max-w-6xl px-4 pb-16 lg:px-8">
        <div class="rv flex flex-col items-start justify-between gap-6 rounded-xl bg-brand-700 p-8 text-white sm:flex-row sm:items-center sm:p-10">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">Siap meminjam barang pertama Anda?</h2>
                <p class="mt-1.5 text-sm text-brand-100">Buat akun siswa dalam satu menit.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('register') }}" class="btn bg-white px-5 py-2.5 text-brand-800 hover:bg-brand-50">Daftar sekarang</a>
                <a href="{{ route('login') }}" class="btn border border-white/25 px-5 py-2.5 text-white hover:bg-white/10">Masuk</a>
            </div>
        </div>
    </section>
</main>

<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-4 py-6 text-xs text-slate-500 sm:flex-row lg:px-8">
        <span>&copy; {{ date('Y') }} SIPINBAR &middot; Sistem Informasi Peminjaman Barang & Inventaris</span>
        <span>SMK Negeri 5 Surakarta</span>
    </div>
</footer>

<script>
    (function () {
        var els = document.querySelectorAll('.rv');
        if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('on'); }); return; }
        var io = new IntersectionObserver(function (list) {
            list.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('on'); io.unobserve(x.target); } });
        }, { threshold: .12 });
        els.forEach(function (e) { io.observe(e); });

        /* Angka statistik naik dari 0 */
        document.querySelectorAll('[data-hitung]').forEach(function (el) {
            var akhir = parseInt(el.getAttribute('data-hitung'), 10);
            if (!akhir || akhir < 2 || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            var mulai = null;
            (function langkah(t) {
                if (mulai === null) mulai = t;
                var p = Math.min((t - mulai) / 900, 1);
                el.textContent = Math.round(akhir * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(langkah);
            })(performance.now());
        });
    })();
</script>
</body>
</html>
