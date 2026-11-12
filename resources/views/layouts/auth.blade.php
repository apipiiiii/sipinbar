<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.head')
</head>
<body class="min-h-screen bg-white">
<div class="grid min-h-screen lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">

    {{-- Panel identitas --}}
    <aside class="bg-panel hidden flex-col justify-between p-12 text-white lg:flex">
        <span class="deco-ico" style="top:12%;right:10%;width:56px;height:56px;--r:8deg"><i class="fa-solid fa-flask"></i></span>
        <span class="deco-ico" style="top:46%;right:6%;width:48px;height:48px;--r:-6deg;animation-delay:-2s"><i class="fa-solid fa-laptop"></i></span>
        <span class="deco-ico" style="bottom:20%;right:16%;width:60px;height:60px;--r:5deg;animation-delay:-4s"><i class="fa-solid fa-futbol"></i></span>
        <span class="deco-ico" style="bottom:8%;left:42%;width:44px;height:44px;--r:-8deg;animation-delay:-1s"><i class="fa-solid fa-book"></i></span>
        <div class="flex items-center gap-2.5">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700"><i class="fa-solid fa-boxes-stacked text-sm"></i></span>
            <span class="text-base font-semibold tracking-tight">SIPINBAR</span>
        </div>

        <div class="max-w-md">
            <h1 class="text-3xl font-semibold leading-tight tracking-tight">Peminjaman barang sekolah, tercatat rapi dari pengajuan sampai pengembalian.</h1>
            <p class="mt-4 text-sm leading-relaxed text-brand-200">Siswa mengajukan peminjaman, admin memverifikasi, dan petugas sarpras mengonfirmasi serah-terima barang, semuanya dalam satu sistem.</p>

            <ul class="mt-8 space-y-3 text-sm text-brand-100">
                <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check mt-0.5 text-brand-300"></i> Stok barang diperbarui otomatis setiap transaksi</li>
                <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check mt-0.5 text-brand-300"></i> Pengingat batas kembali dan perhitungan denda keterlambatan</li>
                <li class="flex items-start gap-3"><i class="fa-solid fa-circle-check mt-0.5 text-brand-300"></i> Laporan peminjaman siap cetak untuk admin</li>
            </ul>
        </div>

        <p class="text-xs text-brand-300">&copy; {{ date('Y') }} SIPINBAR &middot; SMK Negeri 5 Surakarta</p>
    </aside>

    {{-- Form --}}
    <main class="bg-hero flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-[440px] rounded-2xl border border-slate-200 bg-white/90 p-7 shadow-pop backdrop-blur sm:p-9">
            <div class="mb-8 flex items-center gap-2.5 lg:hidden">
                @include('layouts.partials.brand')
                <span class="text-base font-semibold tracking-tight text-slate-900">SIPINBAR</span>
            </div>
            @yield('form')
        </div>
    </main>
</div>
</body>
</html>
