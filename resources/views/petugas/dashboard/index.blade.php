@extends('layouts.petugas')
@section('title', 'Beranda Petugas')

@section('content')
@include('layouts.partials.chart-setup')
@php
    $totalTugas = $stats['perlu_serah'] + $stats['perlu_terima'];
    $ringkas = [
        ['Perlu diserahkan', $stats['perlu_serah'], 'fa-hand-holding-hand', 'text-sky-700 bg-sky-50', 'tugas'],
        ['Perlu diterima', $stats['perlu_terima'], 'fa-rotate-left', 'text-yellow-700 bg-yellow-50', 'tugas'],
        ['Sedang dipinjam', $stats['dipinjam'], 'fa-right-left', 'text-brand-700 bg-brand-50', 'approved'],
        ['Menunggu admin', $stats['menunggu_admin'], 'fa-user-clock', 'text-slate-600 bg-slate-100', 'dicek_petugas'],
    ];
@endphp

@include('layouts.partials.hero', [
    'nama' => explode(' ', trim(auth()->user()->name))[0],
    'subtitle' => $kategori->isEmpty()
        ? 'Anda belum ditugaskan ke kategori mana pun. Minta admin menetapkan Anda pada sebuah kategori.'
        : ($totalTugas > 0
            ? 'Ada '.$totalTugas.' tugas konfirmasi yang menunggu Anda pada kategori '.$kategori->pluck('nama_kategori')->implode(', ').'.'
            : 'Tidak ada tugas yang menunggu saat ini. Kategori Anda: '.$kategori->pluck('nama_kategori')->implode(', ').'.'),
    'actions' => [
        ['Buka daftar tugas', route('petugas.peminjaman.index'), 'fa-hand-holding-hand', true],
    ],
])

<div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
    {{-- Kolom utama: antrian kerja --}}
    <div class="space-y-5 xl:col-span-8">
        <div class="card">
            <div class="grid grid-cols-2 divide-x divide-y divide-slate-100 sm:grid-cols-4 sm:divide-y-0">
                @foreach($ringkas as [$label, $val, $icon, $tone, $f])
                    <a href="{{ route('petugas.peminjaman.index', ['tampil' => $f]) }}" class="group block p-4 transition hover:bg-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md {{ $tone }}"><i class="fa-solid {{ $icon }} text-[11px]"></i></span>
                            <span class="text-xs font-medium text-slate-500">{{ $label }}</span>
                        </div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $val }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h2 class="card-title">Antrian konfirmasi</h2>
                <div class="flex items-center gap-3">
                    <form action="{{ route('petugas.peminjaman.index') }}" class="relative hidden sm:block">
                        <input type="hidden" name="tampil" value="semua">
                        <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-[11px] text-slate-400"></i>
                        <input type="text" name="q" placeholder="Cari kode / siswa" class="input !py-1.5 w-44 pl-8 text-xs">
                    </form>
                    <a href="{{ route('petugas.peminjaman.index') }}" class="link text-xs">Lihat semua</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="tbl">
                    <thead><tr><th>Siswa</th><th>Barang</th><th>Tugas</th><th class="text-right">Aksi</th></tr></thead>
                    <tbody>
                    @forelse($tugas as $t)
                        <tr>
                            <td class="text-slate-800">{{ $t->siswa->name }}<div class="text-xs text-slate-500">{{ $t->kode_peminjaman }}</div></td>
                            <td>{{ $t->barang->nama_barang }} <span class="text-slate-400">&times;{{ $t->jumlah }}</span></td>
                            <td>
                                @if($t->status === 'disetujui')
                                    <x-status-badge color="info" label="Serahkan ke siswa" />
                                @else
                                    <x-status-badge color="warning" label="Terima pengembalian" />
                                @endif
                            </td>
                            <td class="text-right"><a href="{{ route('petugas.peminjaman.show', $t) }}" class="btn btn-primary btn-sm">Proses</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-12 text-center text-slate-400"><i class="fa-regular fa-circle-check mb-2 block text-2xl"></i>Tidak ada tugas konfirmasi saat ini.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div class="card">
                <div class="card-head"><h2 class="card-title">Status peminjaman</h2></div>
                <div class="card-body">
                    @if(array_sum($chart['status']['data']) > 0)
                        <div class="flex items-center gap-5">
                            <div class="h-32 w-32 shrink-0"><canvas id="chStatus"></canvas></div>
                            <ul class="min-w-0 flex-1 space-y-1.5 text-sm">
                                @foreach($chart['status']['labels'] as $i => $lbl)
                                    <li class="flex items-center justify-between gap-2">
                                        <span class="flex min-w-0 items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 shrink-0 rounded-sm" style="background: {{ $chart['status']['colors'][$i] }}"></span><span class="truncate">{{ $lbl }}</span></span>
                                        <span class="font-semibold text-slate-900">{{ $chart['status']['data'][$i] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="py-10 text-center text-sm text-slate-400">Belum ada data peminjaman.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-head"><h2 class="card-title">Stok menipis</h2><span class="text-xs text-slate-500">≤ 2 unit tersedia</span></div>
                <ul class="divide-y divide-slate-100">
                    @forelse($barangMenipis as $b)
                        <li class="flex items-center justify-between gap-3 px-5 py-2.5">
                            <span class="truncate text-sm text-slate-800">{{ $b->nama_barang }}</span>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20' }}">{{ $b->stok_tersedia }}/{{ $b->stok_total }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center text-sm text-slate-400">Semua stok aman.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- Kolom samping: aktivitas & kategori --}}
    <div class="space-y-5 xl:col-span-4">
        <div class="card">
            <div class="card-head">
                <div>
                    <h2 class="card-title">Aktivitas 7 hari terakhir</h2>
                    <p class="text-xs text-slate-500">Penyerahan dan penerimaan barang</p>
                </div>
            </div>
            <div class="card-body"><div class="h-52"><canvas id="chHarian"></canvas></div></div>
        </div>

        <x-agenda-jatuh-tempo :agenda="$agenda" />

        <div class="card">
            <div class="card-head"><h2 class="card-title">Kategori yang saya ampu</h2></div>
            @if(count($chart['stokKategori']['labels']))
                <div class="card-body pb-2"><div class="h-44"><canvas id="chStok"></canvas></div></div>
            @endif
            <ul class="divide-y divide-slate-100">
                @forelse($kategori as $k)
                    <li class="flex items-center justify-between gap-3 px-5 py-3">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-medium text-slate-900">{{ $k->nama_kategori }}</div>
                            @if($k->keterangan)<div class="truncate text-xs text-slate-500">{{ $k->keterangan }}</div>@endif
                        </div>
                        <span class="whitespace-nowrap rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">{{ $k->barang_count }} barang</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-slate-400">Belum ada kategori.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var C = @json($chart);

        new Chart(document.getElementById('chHarian'), {
            type: 'bar',
            data: {
                labels: C.harian.labels,
                datasets: [
                    { label: 'Diserahkan', data: C.harian.diserahkan, backgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 14 },
                    { label: 'Diterima', data: C.harian.diterima, backgroundColor: SP.brandSoft, borderRadius: 4, maxBarThickness: 14 }
                ]
            },
            options: { scales: { y: SP.intOnly, x: Object.assign({ ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 7 } }, SP.noGrid) }, plugins: { legend: { position: 'bottom' } } }
        });

        @if(array_sum($chart['status']['data']) > 0)
        SP.doughnut('chStatus', C.status);
        @endif

        @if(count($chart['stokKategori']['labels']))
        new Chart(document.getElementById('chStok'), {
            type: 'bar',
            data: {
                labels: C.stokKategori.labels,
                datasets: [
                    { label: 'Tersedia', data: C.stokKategori.tersedia, backgroundColor: SP.brand, borderRadius: 3, maxBarThickness: 18 },
                    { label: 'Dipinjam', data: C.stokKategori.dipinjam, backgroundColor: SP.brandSoft, borderRadius: 3, maxBarThickness: 18 }
                ]
            },
            options: { indexAxis: 'y', scales: { x: Object.assign({ stacked: true }, SP.intOnly), y: Object.assign({ stacked: true }, SP.noGrid) }, plugins: { legend: { position: 'bottom' } } }
        });
        @endif
    })();
</script>
@endpush
