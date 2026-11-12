<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.partials.chart-setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
    $rp = fn ($n) => \App\Models\Peminjaman::rupiah($n);
    $persenTersedia = $stats['total_stok'] > 0 ? round($stats['stok_tersedia'] / $stats['total_stok'] * 100) : 0;
?>

<?php echo $__env->make('layouts.partials.hero', [
    'nama' => explode(' ', trim(auth()->user()->name))[0],
    'subtitle' => $stats['pending'].' pengajuan menunggu verifikasi · '.$stats['dipinjam_transaksi'].' peminjaman sedang berjalan · '.$stats['stok_tersedia'].' dari '.$stats['total_stok'].' unit barang tersedia.',
    'actions' => [
        ['Verifikasi Pengajuan', route('admin.peminjaman.index', ['status' => 'pending']), 'fa-clipboard-check', true],
        ['Laporan & Rekap', route('admin.laporan.index'), 'fa-file-lines', false],
    ],
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="mb-6 grid grid-cols-2 gap-4 xl:grid-cols-4">
    <a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'pending'])); ?>" class="card block p-5 transition hover:border-slate-300">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Menunggu verifikasi</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-50 text-yellow-700"><i class="fa-solid fa-hourglass-half text-xs"></i></span>
        </div>
        <div class="kpi-value"><?php echo e($stats['pending']); ?></div>
        <div class="kpi-note">
            <?php if($stats['konfirmasi_kembali'] > 0): ?> + <?php echo e($stats['konfirmasi_kembali']); ?> pengembalian menunggu konfirmasi <?php else: ?> Pengajuan siswa baru <?php endif; ?>
        </div>
    </a>
    <a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'approved'])); ?>" class="card block p-5 transition hover:border-slate-300">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Sedang dipinjam</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700"><i class="fa-solid fa-right-left text-xs"></i></span>
        </div>
        <div class="kpi-value"><?php echo e($stats['dipinjam']); ?> <span class="text-sm font-normal text-slate-500">unit</span></div>
        <div class="kpi-note"><?php echo e($stats['dipinjam_transaksi']); ?> transaksi aktif</div>
    </a>
    <a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'terlambat'])); ?>" class="card block p-5 transition hover:border-slate-300 <?php echo e($stats['terlambat'] > 0 ? 'border-rose-300' : ''); ?>">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Terlambat</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-700"><i class="fa-solid fa-triangle-exclamation text-xs"></i></span>
        </div>
        <div class="kpi-value <?php echo e($stats['terlambat'] > 0 ? 'text-rose-700' : ''); ?>"><?php echo e($stats['terlambat']); ?></div>
        <div class="kpi-note">Denda berjalan <?php echo e($rp($stats['denda_berjalan'])); ?></div>
    </a>
    <a href="<?php echo e(route('admin.hilang.index')); ?>" class="card block p-5 transition hover:border-slate-300 <?php echo e($stats['hilang'] > 0 ? 'border-rose-300' : ''); ?>">
        <div class="flex items-center justify-between">
            <span class="kpi-label">Barang hilang</span>
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-700"><i class="fa-solid fa-box-open text-xs"></i></span>
        </div>
        <div class="kpi-value <?php echo e($stats['hilang'] > 0 ? 'text-rose-700' : ''); ?>"><?php echo e($stats['hilang']); ?> <span class="text-sm font-normal text-slate-500">unit</span></div>
        <div class="kpi-note">Belum diganti &bull; <?php echo e($stats['hilang_kasus']); ?> laporan</div>
    </a>
</div>


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
        <div class="card-head"><h2 class="card-title">Komposisi status</h2><span class="text-xs text-slate-500"><?php echo e(array_sum($chart['status']['data'])); ?> transaksi</span></div>
        <div class="card-body">
            <?php if(array_sum($chart['status']['data']) > 0): ?>
                <div class="mx-auto h-44 w-44"><canvas id="chStatus"></canvas></div>
                <ul class="mt-4 space-y-1.5 text-sm">
                    <?php $__currentLoopData = $chart['status']['labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center justify-between gap-3">
                            <span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 rounded-sm" style="background: <?php echo e($chart['status']['colors'][$i]); ?>"></span><?php echo e($lbl); ?></span>
                            <span class="font-semibold text-slate-900"><?php echo e($chart['status']['data'][$i]); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="py-16 text-center text-sm text-slate-400">Belum ada data peminjaman.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="mb-6 grid grid-cols-1 gap-5 lg:grid-cols-3">
    <div class="card">
        <div class="card-head"><h2 class="card-title">Barang paling sering dipinjam</h2></div>
        <div class="card-body">
            <?php if(count($chart['topBarang']['data'])): ?>
                <div class="h-56"><canvas id="chTop"></canvas></div>
            <?php else: ?>
                <p class="py-16 text-center text-sm text-slate-400">Belum ada data peminjaman.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2 class="card-title">Stok per kategori</h2></div>
        <div class="card-body">
            <?php if(count($chart['stokKategori']['labels'])): ?>
                <div class="h-56"><canvas id="chStok"></canvas></div>
            <?php else: ?>
                <p class="py-16 text-center text-sm text-slate-400">Belum ada kategori.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-head"><h2 class="card-title">Ringkasan inventaris</h2></div>
        <div class="card-body">
            <div class="mb-1 flex items-baseline justify-between">
                <span class="text-sm text-slate-600">Ketersediaan unit</span>
                <span class="text-sm font-semibold text-slate-900"><?php echo e($stats['stok_tersedia']); ?> / <?php echo e($stats['total_stok']); ?></span>
            </div>
            <div class="mb-5 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-brand-600" style="width: <?php echo e($persenTersedia); ?>%"></div></div>
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Jenis barang</dt><dd class="font-semibold text-slate-900"><?php echo e($stats['total_barang']); ?></dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Sudah dikembalikan</dt><dd class="font-semibold text-slate-900"><?php echo e($stats['dikembalikan']); ?> unit &middot; <?php echo e($stats['dikembalikan_transaksi']); ?> transaksi</dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Selesai bulan ini</dt><dd class="font-semibold text-slate-900"><?php echo e($stats['selesai_bulan_ini']); ?></dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Denda belum lunas</dt><dd class="font-semibold <?php echo e($stats['denda_belum_lunas'] > 0 ? 'text-yellow-700' : 'text-slate-900'); ?>"><?php echo e($rp($stats['denda_belum_lunas'])); ?></dd></div>
                <div class="flex justify-between py-2.5"><dt class="text-slate-500">Siswa terdaftar</dt><dd class="font-semibold text-slate-900"><?php echo e($stats['total_siswa']); ?></dd></div>
            </dl>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
    <div class="card xl:col-span-8">
        <div class="card-head">
            <h2 class="card-title">Pengajuan peminjaman terbaru</h2>
            <a href="<?php echo e(route('admin.peminjaman.index')); ?>" class="link text-xs">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="tbl">
                <thead><tr><th>Kode</th><th>Siswa</th><th>Barang</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $peminjamanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="font-medium text-slate-900"><?php echo e($p->kode_peminjaman); ?></td>
                        <td><?php echo e($p->siswa->name); ?></td>
                        <td><?php echo e($p->barang->nama_barang); ?></td>
                        <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $p->badgeColor(),'label' => $p->labelStatus()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->labelStatus())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></td>
                        <td class="text-right"><a href="<?php echo e(route('admin.peminjaman.show', $p)); ?>" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data peminjaman.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginala95cf02f6cbe4fb46405f8203cc8fec3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala95cf02f6cbe4fb46405f8203cc8fec3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feed-aktivitas','data' => ['feed' => $feed,'class' => 'xl:col-span-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('feed-aktivitas'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['feed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feed),'class' => 'xl:col-span-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala95cf02f6cbe4fb46405f8203cc8fec3)): ?>
<?php $attributes = $__attributesOriginala95cf02f6cbe4fb46405f8203cc8fec3; ?>
<?php unset($__attributesOriginala95cf02f6cbe4fb46405f8203cc8fec3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala95cf02f6cbe4fb46405f8203cc8fec3)): ?>
<?php $component = $__componentOriginala95cf02f6cbe4fb46405f8203cc8fec3; ?>
<?php unset($__componentOriginala95cf02f6cbe4fb46405f8203cc8fec3); ?>
<?php endif; ?>
</div>

<div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
    <div class="card">
        <div class="card-head">
            <h2 class="card-title">Stok menipis</h2>
            <a href="<?php echo e(route('admin.barang.index')); ?>" class="link text-xs">Data barang</a>
        </div>
        <ul class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $barangMenipis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="flex items-center justify-between gap-3 px-5 py-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-slate-900"><?php echo e($b->nama_barang); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($b->kode_barang); ?></p>
                    </div>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset <?php echo e($b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20'); ?>"><?php echo e($b->stok_tersedia); ?>/<?php echo e($b->stok_total); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="px-5 py-10 text-center text-sm text-slate-400">Semua stok aman.</li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if (isset($component)) { $__componentOriginalf649e0d506d8650e67e6b84bec258e95 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf649e0d506d8650e67e6b84bec258e95 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.agenda-jatuh-tempo','data' => ['agenda' => $agenda]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('agenda-jatuh-tempo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['agenda' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($agenda)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf649e0d506d8650e67e6b84bec258e95)): ?>
<?php $attributes = $__attributesOriginalf649e0d506d8650e67e6b84bec258e95; ?>
<?php unset($__attributesOriginalf649e0d506d8650e67e6b84bec258e95); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf649e0d506d8650e67e6b84bec258e95)): ?>
<?php $component = $__componentOriginalf649e0d506d8650e67e6b84bec258e95; ?>
<?php unset($__componentOriginalf649e0d506d8650e67e6b84bec258e95); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    (function () {
        var C = <?php echo json_encode($chart, 15, 512) ?>;

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

        <?php if(array_sum($chart['status']['data']) > 0): ?>
        SP.doughnut('chStatus', C.status);
        <?php endif; ?>

        <?php if(count($chart['topBarang']['data'])): ?>
        new Chart(document.getElementById('chTop'), {
            type: 'bar',
            data: { labels: C.topBarang.labels, datasets: [{ label: 'Kali dipinjam', data: C.topBarang.data, backgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 22 }] },
            options: { indexAxis: 'y', scales: { x: SP.intOnly, y: SP.noGrid }, plugins: { legend: { display: false } } }
        });
        <?php endif; ?>

        <?php if(count($chart['stokKategori']['labels'])): ?>
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
        <?php endif; ?>
    })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>