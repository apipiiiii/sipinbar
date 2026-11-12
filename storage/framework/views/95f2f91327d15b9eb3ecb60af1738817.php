<?php $__env->startSection('title', 'Dashboard Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-gauge"></i></span>
        Selamat Datang, <?php echo e(auth()->user()->name); ?>!
    </h1>
    <a href="<?php echo e(route('siswa.peminjaman.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-ocean-600 hover:bg-ocean-700 px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition">
        <i class="fa-solid fa-plus"></i> Ajukan Peminjaman
    </a>
</div>

<?php if($terlambatList->isNotEmpty()): ?>
<div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-700">
    <div class="font-bold flex items-center gap-2 mb-2"><i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Peringatan: <?php echo e($terlambatList->count()); ?> peminjaman Anda terlambat dikembalikan!</div>
    <ul class="space-y-1.5 mb-2">
        <?php $__currentLoopData = $terlambatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="flex flex-wrap items-center justify-between gap-2">
            <span><b><?php echo e($t->barang->nama_barang); ?></b> (<?php echo e($t->kode_peminjaman); ?>) &mdash; terlambat <?php echo e($t->hariTerlambat()); ?> hari, denda <?php echo e(\App\Models\Peminjaman::rupiah($t->dendaSaatIni())); ?></span>
            <a href="<?php echo e(route('siswa.peminjaman.show', $t)); ?>" class="text-xs font-semibold underline">Lihat detail</a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <div class="text-xs">Total denda berjalan <b><?php echo e(\App\Models\Peminjaman::rupiah($stats['denda_berjalan'])); ?></b> &bull; Tarif: <?php echo e(\App\Models\Peminjaman::infoTarifDenda()); ?>. Segera kembalikan barang ke petugas sarpras.</div>
</div>
<?php endif; ?>

<?php if($hilangList->isNotEmpty()): ?>
<div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-700">
    <div class="font-bold flex items-center gap-2 mb-2"><i class="fa-solid fa-box-open text-rose-500"></i> Anda memiliki <?php echo e($hilangList->count()); ?> barang hilang yang belum diganti</div>
    <ul class="space-y-1.5 mb-2">
        <?php $__currentLoopData = $hilangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="flex flex-wrap items-center justify-between gap-2">
            <span>Ganti dengan barang baru: <b><?php echo e($h->barang->nama_barang); ?></b> (<?php echo e($h->jumlah); ?> unit) &mdash; <?php echo e($h->kode_peminjaman); ?></span>
            <a href="<?php echo e(route('siswa.peminjaman.show', $h)); ?>" class="text-xs font-semibold underline">Lihat detail</a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <div class="text-xs">Serahkan barang pengganti ke petugas sarpras.</div>
</div>
<?php endif; ?>

<?php if($stats['denda_belum_lunas'] > 0): ?>
<div class="mb-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800 flex items-center gap-2.5">
    <i class="fa-solid fa-money-bill-wave"></i>
    <span>Denda keterlambatan yang belum Anda bayar: <b><?php echo e(\App\Models\Peminjaman::rupiah($stats['denda_belum_lunas'])); ?></b>. Silakan bayar ke petugas sarpras.</span>
</div>
<?php endif; ?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Pengajuan</span>
            <span class="h-8 w-8 rounded-lg bg-slate-50 text-slate-500 inline-flex items-center justify-center"><i class="fa-solid fa-file-lines text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900"><?php echo e($stats['total_pengajuan']); ?></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Menunggu Verifikasi</span>
            <span class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 inline-flex items-center justify-center"><i class="fa-solid fa-hourglass-half text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-amber-600"><?php echo e($stats['pending']); ?></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Sedang Dipinjam</span>
            <span class="h-8 w-8 rounded-lg bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-right-left text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-ocean-600"><?php echo e($stats['approved']); ?></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Barang Tersedia</span>
            <span class="h-8 w-8 rounded-lg bg-mint-50 text-mint-600 inline-flex items-center justify-center"><i class="fa-solid fa-box text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-mint-600"><?php echo e($stats['barang_tersedia']); ?></div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft">
    <div class="p-5 sm:p-6 border-b border-slate-100">
        <h2 class="font-bold text-slate-900 text-sm">Riwayat Peminjaman Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Kode</th><th class="px-5 py-3">Barang</th><th class="px-5 py-3">Tgl Pinjam</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $riwayatTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="px-5 py-3 font-medium text-slate-800"><?php echo e($r->kode_peminjaman); ?></td>
                    <td class="px-5 py-3 text-slate-600"><?php echo e($r->barang->nama_barang); ?></td>
                    <td class="px-5 py-3 text-slate-500"><?php echo e($r->tanggal_pinjam->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
                    <td class="px-5 py-3 text-right">
                        <a href="<?php echo e(route('siswa.peminjaman.show', $r)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Detail</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-slate-400 py-10">Anda belum pernah mengajukan peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/siswa/dashboard/index.blade.php ENDPATH**/ ?>