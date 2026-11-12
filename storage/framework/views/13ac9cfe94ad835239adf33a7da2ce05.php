<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.partials.chart-setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
    $rp = fn ($n) => \App\Models\Peminjaman::rupiah($n);
    $namaDepan = explode(' ', trim(auth()->user()->name))[0];

    $langkah = ['Diajukan', 'Disetujui', 'Dipinjam', 'Dikembalikan'];
    $posisi = $aktif ? match ($aktif->status) {
        'pending' => 0, 'disetujui' => 1, 'approved' => 2, default => 3,
    } : null;
    $sisaHari = ($aktif && $aktif->status === 'approved')
        ? (int) now()->startOfDay()->diffInDays($aktif->tanggal_kembali_rencana->copy()->startOfDay(), false)
        : null;
    // Progres waktu pinjam untuk cincin: hari yang sudah berjalan dibanding total masa pinjam
    $totalHari = $aktif ? max(1, (int) $aktif->tanggal_pinjam->copy()->startOfDay()->diffInDays($aktif->tanggal_kembali_rencana->copy()->startOfDay())) : 1;
    $berjalan = $aktif ? min($totalHari, max(0, (int) $aktif->tanggal_pinjam->copy()->startOfDay()->diffInDays(now()->startOfDay(), false))) : 0;
    $keliling = 2 * M_PI * 26;
?>

<?php echo $__env->make('layouts.partials.hero', [
    'nama' => $namaDepan,
    'subtitle' => $aktif
        ? 'Anda sedang meminjam '.$aktif->barang->nama_barang.'. Pantau tahapan dan batas pengembaliannya di bawah.'
        : 'Siap meminjam barang? Telusuri katalog dan ajukan peminjaman dalam beberapa langkah.',
    'actions' => [
        ['Ajukan Peminjaman', route('siswa.peminjaman.create'), 'fa-plus', true],
        ['Lihat Katalog', route('siswa.katalog.index'), 'fa-list-check', false],
    ],
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-5">
    
    <div class="card lg:col-span-3">
        <div class="card-head">
            <h2 class="card-title">Peminjaman saat ini</h2>
            <?php if($aktif): ?><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $aktif->badgeColor(),'label' => $aktif->labelStatus()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($aktif->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($aktif->labelStatus())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?><?php endif; ?>
        </div>
        <div class="card-body">
        <?php if($aktif): ?>
            <div class="mb-5 flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="truncate text-lg font-semibold text-slate-900"><?php echo e($aktif->barang->nama_barang); ?></p>
                    <p class="text-sm text-slate-500"><?php echo e($aktif->kode_peminjaman); ?> &bull; <?php echo e($aktif->jumlah); ?> unit</p>
                </div>
                <?php if($sisaHari !== null): ?>
                    <?php
                        $warnaRing = $sisaHari < 0 ? '#E11D48' : ($sisaHari <= 1 ? '#CA8A04' : 'rgb(var(--b600))');
                        $isi = $keliling * ($sisaHari < 0 ? 1 : $berjalan / $totalHari);
                    ?>
                    <div class="relative h-[68px] w-[68px] shrink-0" title="<?php echo e($berjalan); ?> dari <?php echo e($totalHari); ?> hari">
                        <svg viewBox="0 0 64 64" class="h-full w-full -rotate-90">
                            <circle cx="32" cy="32" r="26" fill="none" stroke="#E7E5E4" stroke-width="6"/>
                            <circle cx="32" cy="32" r="26" fill="none" style="stroke: <?php echo e($warnaRing); ?>" stroke-width="6" stroke-linecap="round" stroke-dasharray="<?php echo e(round($isi, 1)); ?> <?php echo e(round($keliling, 1)); ?>"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center leading-none">
                            <span class="text-lg font-semibold <?php echo e($sisaHari < 0 ? 'text-rose-700' : 'text-slate-900'); ?>"><?php echo e(abs($sisaHari)); ?></span>
                            <span class="mt-0.5 text-[9px] font-medium text-slate-500"><?php echo e($sisaHari < 0 ? 'hari telat' : 'hari lagi'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            
            <ol class="mb-5 grid grid-cols-4 gap-2">
                <?php $__currentLoopData = $langkah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="mb-2 h-1.5 rounded-full <?php echo e($i < $posisi ? 'bg-brand-600' : ($i === $posisi ? 'bg-brand-400' : 'bg-slate-200')); ?>"></div>
                        <p class="text-xs <?php echo e($i <= $posisi ? 'font-semibold text-slate-900' : 'text-slate-400'); ?>"><?php echo e($nama); ?></p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>

            <dl class="mb-5 grid grid-cols-2 gap-4 text-sm">
                <div><dt class="text-xs text-slate-500">Tanggal pinjam</dt><dd class="font-medium text-slate-900"><?php echo e($aktif->tanggal_pinjam->format('d M Y')); ?></dd></div>
                <div><dt class="text-xs text-slate-500">Batas pengembalian</dt><dd class="font-medium text-slate-900"><?php echo e($aktif->tanggal_kembali_rencana->format('d M Y')); ?></dd></div>
            </dl>
            <a href="<?php echo e(route('siswa.peminjaman.show', $aktif)); ?>" class="btn btn-outline">Lihat detail <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
        <?php else: ?>
            <div class="py-6 text-center">
                <span class="mx-auto mb-3 inline-flex h-11 w-11 items-center justify-center rounded-full bg-brand-50 text-brand-600"><i class="fa-solid fa-box-open"></i></span>
                <p class="font-medium text-slate-900">Anda sedang tidak meminjam barang</p>
                <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Ada <?php echo e($stats['barang_tersedia']); ?> jenis barang yang tersedia. Setiap siswa dapat meminjam 1 barang dalam satu waktu.</p>
                <a href="<?php echo e(route('siswa.katalog.index')); ?>" class="btn btn-primary mt-4">Telusuri katalog</a>
            </div>
        <?php endif; ?>
        </div>
    </div>

    
    <div class="grid grid-cols-2 gap-4 lg:col-span-2">
        <div class="card flex flex-col justify-between p-4">
            <span class="kpi-label">Total pengajuan</span>
            <span class="kpi-value"><?php echo e($stats['total_pengajuan']); ?></span>
        </div>
        <div class="card flex flex-col justify-between p-4">
            <span class="kpi-label">Menunggu verifikasi</span>
            <span class="kpi-value text-yellow-700"><?php echo e($stats['pending']); ?></span>
        </div>
        <div class="card flex flex-col justify-between p-4">
            <span class="kpi-label">Sedang dipinjam</span>
            <span class="kpi-value text-brand-700"><?php echo e($stats['approved']); ?></span>
        </div>
        <div class="card flex flex-col justify-between p-4">
            <span class="kpi-label">Selesai</span>
            <span class="kpi-value text-emerald-700"><?php echo e($stats['selesai']); ?></span>
        </div>
    </div>
</div>

<?php if($stats['total_pengajuan'] > 0): ?>
<div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-5">
    <div class="card lg:col-span-3">
        <div class="card-head"><h2 class="card-title">Aktivitas peminjaman saya</h2><span class="text-xs text-slate-500">6 bulan terakhir</span></div>
        <div class="card-body"><div class="h-48"><canvas id="chTren"></canvas></div></div>
    </div>
    <div class="card lg:col-span-2">
        <div class="card-head"><h2 class="card-title">Status pengajuan</h2></div>
        <div class="card-body">
            <div class="flex items-center gap-5">
                <div class="h-32 w-32 shrink-0"><canvas id="chStatus"></canvas></div>
                <ul class="min-w-0 flex-1 space-y-1.5 text-sm">
                    <?php $__currentLoopData = $chart['status']['labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center justify-between gap-2">
                            <span class="flex min-w-0 items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 shrink-0 rounded-sm" style="background: <?php echo e($chart['status']['colors'][$i]); ?>"></span><span class="truncate"><?php echo e($lbl); ?></span></span>
                            <span class="font-semibold text-slate-900"><?php echo e($chart['status']['data'][$i]); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-head">
        <h2 class="card-title">Riwayat terbaru</h2>
        <a href="<?php echo e(route('siswa.peminjaman.index')); ?>" class="link text-xs">Lihat semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead><tr><th>Kode</th><th>Barang</th><th>Tgl pinjam</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $riwayatTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="font-medium text-slate-900"><?php echo e($r->kode_peminjaman); ?></td>
                    <td><?php echo e($r->barang->nama_barang); ?></td>
                    <td class="text-slate-500"><?php echo e($r->tanggal_pinjam->format('d/m/Y')); ?></td>
                    <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $r->badgeColor(),'label' => $r->labelStatus()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r->labelStatus())]); ?>
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
                    <td class="text-right"><a href="<?php echo e(route('siswa.peminjaman.show', $r)); ?>" class="btn btn-outline btn-sm">Detail</a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Anda belum pernah mengajukan peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php if($stats['total_pengajuan'] > 0): ?>
<?php $__env->startPush('scripts'); ?>
<script>
    (function () {
        var C = <?php echo json_encode($chart, 15, 512) ?>;
        new Chart(document.getElementById('chTren'), {
            type: 'bar',
            data: {
                labels: C.tren.labels,
                datasets: [
                    { label: 'Diajukan', data: C.tren.pengajuan, backgroundColor: SP.brandSoft, hoverBackgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 30 },
                    { label: 'Selesai', data: C.tren.selesai, backgroundColor: SP.brand, borderRadius: 4, maxBarThickness: 30 }
                ]
            },
            options: { scales: { y: SP.intOnly, x: SP.noGrid }, plugins: { legend: { position: 'top', align: 'end' } } }
        });
        SP.doughnut('chStatus', C.status);
    })();
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/siswa/dashboard/index.blade.php ENDPATH**/ ?>