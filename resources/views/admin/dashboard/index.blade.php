@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
@include('layouts.partials.chart-setup')
@php
    $rp = fn ($n) => \App\Models\Peminjaman::rupiah($n);
    $persenTersedia = $stats['total_stok'] > 0 ? round($stats['stok_tersedia'] / $stats['total_stok'] * 100) : 0;
@endphp

@include('layouts.partials.hero', [
    'nama' => explode(' ', trim(auth()->user()->name))[0],
    'subtitle' => $stats['pending'].' pengajuan menunggu verifikasi · '.$stats['dipinjam_transaksi'].' peminjaman sedang berjalan · '.$stats['stok_tersedia'].' dari '.$stats['total_stok'].' unit barang tersedia.',
    'actions' => [
        ['Verifikasi Pengajuan', route('admin.peminjaman.index', ['status' => 'pending']), 'fa-clipboard-check', true],
        ['Laporan & Rekap', route('admin.laporan.index'), 'fa-file-lines', false],
    ],
])

{{-- Indikator utama --}}
<div class="mb-6 grid grid-cols-2 gap-4 xl:grid-cols-4">
    <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}" class="card block p-5 transition hover:border-slate-300">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Menunggu verifikasi</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-50 text-yellow-700"><i class="fa-solid fa-hourglass-half text-xs"></i></span>
        </div>
        <div class="kpi-value">{{ $stats['pending'] }}</div>
        <div class="kpi-note">
            @if($stats['konfirmasi_kembali'] > 0) + {{ $stats['konfirmasi_kembali'] }} pengembalian menunggu konfirmasi @else Pengajuan siswa baru @endif
        </div>
    </a>
    <a href="{{ route('admin.peminjaman.index', ['status' => 'approved']) }}" class="card block p-5 transition hover:border-slate-300">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Sedang dipinjam</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700"><i class="fa-solid fa-right-left text-xs"></i></span>
        </div>
        <div class="kpi-value">{{ $stats['dipinjam'] }} <span class="text-sm font-normal text-slate-500">unit</span></div>
        <div class="kpi-note">{{ $stats['dipinjam_transaksi'] }} transaksi aktif</div>
    </a>
    <a href="{{ route('admin.peminjaman.index', ['status' => 'terlambat']) }}" class="card block p-5 transition hover:border-slate-300 {{ $stats['terlambat'] > 0 ? 'border-rose-300' : '' }}">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Terlambat</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-700"><i class="fa-solid fa-triangle-exclamation text-xs"></i></span>
        </div>
        <div class="kpi-value {{ $stats['terlambat'] > 0 ? 'text-rose-700' : '' }}">{{ $stats['terlambat'] }}</div>
        <div class="kpi-note">Denda berjalan {{ $rp($stats['denda_berjalan']) }}</div>
    </a>
    <a href="{{ route('admin.hilang.index') }}" class="card block p-5 transition hover:border-slate-300 {{ $stats['hilang'] > 0 ? 'border-rose-300' : '' }}">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Barang hilang</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-700"><i class="fa-solid fa-box-open text-xs"></i></span>
        </div>
        <div class="kpi-value {{ $stats['hilang'] > 0 ? 'text-rose-700' : '' }}">{{ $stats['hilang'] }} <span class="text-sm font-normal text-slate-500">unit</span></div>
        <div class="kpi-note">Belum diganti &bull; {{ $stats['hilang_kasus'] }} laporan</div>
    </a>
</div>

{{-- Grafik utama --}}
<div class="mb-6 grid grid-cols-1 gap-5 xl:grid-cols-12">
    <div class="card xl:col-span-8">
        <div class="card-head">
            <div>
                <h2 class="card-title">Tren peminjaman</h2>
                <p class="text-xs text-slate-500">Pengajuan masuk dan peminjaman selesai, 6 bulan terakhir</p>
            </div>
        </div>
        <div class="card-body"><div class="h-64"><canvas id="chTren"></canvas></div></div>
    </div>

    <div class="card xl:col-span-4">
        <div class="card-head"><h2 class="card-title">Komposisi status</h2><span class="text-xs text-slate-500">{{ array_sum($chart['status']['data']) }} transaksi</span></div>
        <div class="card-body">
            @if(array_sum($chart['status']['data']) > 0)
                <div class="mx-auto h-44 w-44"><canvas id="chStatus"></canvas></div>
                <ul class="mt-4 space-y-1.5 text-sm">
                    @foreach($chart['status']['labels'] as $i => $lbl)
                        <li class="flex items-center justify-between gap-3">
                            <span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 rounded-sm" style="background: {{ $chart['status']['colors'][$i] }}"></span>{{ $lbl }}</span>
                            <span class="font-semibold text-slate-900">{{ $chart['status']['data'][$i] }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="py-16 text-center text-sm text-slate-400">Belum ada data peminjaman.</p>
            @endif
        </div>
    </div>
</div>

<div class="mb-6 grid grid-cols-1 gap-5 lg:grid-cols-3">
    <div class="card">
        <div class="card-head"><h2 class="card-title">Barang paling sering dipinjam</h2></div>
        <div class="card-body">
            @if(count($chart['topBarang']['data']))
                <div class="h-56"><canvas id="chTop"></canvas></div>
            @else
                <p class="py-16 text-center text-sm text-slate-400">Belum ada data peminjaman.</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2 class="card-title">Stok per kategori</h2></div>
        <div class="card-body">
            @if(count($chart['stokKategori']['labels']))
                <div class="h-56"><canvas id="chStok"></canvas></div>
            @else
                <p class="py-16 text-center text-sm text-slate-400">Belum ada kategori.</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2 class="card-title">Ringkasan inventaris</h2></div>
        <div class="card-body">
            <div class="mb-1 flex items-baseline justify-between">
                <span class="text-sm text-slate-600">Ketersediaan unit</span>
                <span class="text-sm font-semibold text-slate-900">{{ $stats['stok_tersedia'] }} / {{ $stats['total_stok'] }}</span>
            </div>
            <div class="mb-5 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-brand-600" style="width: {{ $persenTersedia }}%"></div></div>
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Jenis barang</dt><dd class="font-semibold text-slate-900">{{ $stats['total_barang'] }}</dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Sudah dikembalikan</dt><dd class="font-semibold text-slate-900">{{ $stats['dikembalikan'] }} unit &middot; {{ $stats['dikembalikan_transaksi'] }} transaksi</dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Selesai bulan ini</dt><dd class="font-semibold text-slate-900">{{ $stats['selesai_bulan_ini'] }}</dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Denda belum lunas</dt><dd class="font-semibold {{ $stats['denda_belum_lunas'] > 0 ? 'text-yellow-700' : 'text-slate-900' }}">{{ $rp($stats['denda_belum_lunas']) }}</dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Siswa terdaftar</dt><dd class="font-semibold text-slate-900">{{ $stats['total_siswa'] }}</dd></div>
            </dl>
        </div>
    </div>
</div>

{{-- Aktivitas terbaru --}}
<div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
    <div class="card xl:col-span-8">
        <div class="card-head">
            <h2 class="card-title">Pengajuan peminjaman terbaru</h2>
            <a href="{{ route('admin.peminjaman.index') }}" class="link text-xs">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="tbl">
                <thead><tr><th>Kode</th><th>Siswa</th><th>Barang</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($peminjamanTerbaru as $p)
                    <tr>
                        <td class="font-medium text-slate-900">{{ $p->kode_peminjaman }}</td>
                        <td>{{ $p->siswa->name }}</td>
                        <td>{{ $p->barang->nama_barang }}</td>
                        <td><x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" /></td>
                        <td class="text-right"><a href="{{ route('admin.peminjaman.show', $p) }}" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data peminjaman.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-feed-aktivitas :feed="$feed" class="xl:col-span-4" />
</div>

<div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Stok menipis</h2>
            <a href="{{ route('admin.barang.index') }}" class="link text-xs">Data barang</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($barangMenipis as $b)
                <li class="flex items-center justify-between gap-3 px-5 py-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-slate-900">{{ $b->nama_barang }}</p>
                        <p class="text-xs text-slate-500">{{ $b->kode_barang }}</p>
                    </div>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20' }}">{{ $b->stok_tersedia }}/{{ $b->stok_total }}</span>
                </li>
            @empty
                <li class="px-5 py-10 text-center text-sm text-slate-400">Semua stok aman.</li>
            @endforelse
        </ul>
    </div>
    <x-agenda-jatuh-tempo :agenda="$agenda" />
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var C = @json($chart);

        new Chart(document.getElementById('chTren'), {
            type: 'bar',
            data: {
                labels: C.tren.labels,
                datasets: [
                    { type: 'bar', label: 'Pengajuan', data: C.tren.pengajuan, backgroundColor: SP.brandSoft, hoverBackgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 36, order: 2 },
                    { type: 'line', label: 'Selesai', data: C.tren.selesai, borderColor: SP.emerald, backgroundColor: SP.emerald, tension: .3, pointRadius: 3, borderWidth: 2, order: 1 }
                ]
            },
            options: { scales: { y: SP.intOnly, x: SP.noGrid }, plugins: { legend: { position: 'top', align: 'end' } } }
        });

        @if(array_sum($chart['status']['data']) > 0)
        SP.doughnut('chStatus', C.status);
        @endif

        @if(count($chart['topBarang']['data']))
        new Chart(document.getElementById('chTop'), {
            type: 'bar',
            data: { labels: C.topBarang.labels, datasets: [{ label: 'Kali dipinjam', data: C.topBarang.data, backgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 22 }] },
            options: { indexAxis: 'y', scales: { x: SP.intOnly, y: SP.noGrid }, plugins: { legend: { display: false } } }
        });
        @endif

        @if(count($chart['stokKategori']['labels']))
        new Chart(document.getElementById('chStok'), {
            type: 'bar',
            data: {
                labels: C.stokKategori.labels,
                datasets: [
                    { label: 'Tersedia', data: C.stokKategori.tersedia, backgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 28 },
                    { label: 'Dipinjam', data: C.stokKategori.dipinjam, backgroundColor: SP.brandSoft, borderRadius: 4, maxBarThickness: 28 }
                ]
            },
            options: { scales: { x: Object.assign({ stacked: true }, SP.noGrid), y: Object.assign({ stacked: true }, SP.intOnly) }, plugins: { legend: { position: 'bottom' } } }
        });
        @endif
    })();
</script>
@endpush
