<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20">
            <i class="fa-solid fa-gauge"></i>
        </span>
        Dashboard Admin / Petugas Sarpras
    </h1>
    <span class="text-sm text-slate-400"><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Barang</span>
            <span class="h-8 w-8 rounded-lg bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center"><i class="fa-solid fa-cubes text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-white"><?php echo e($stats['total_barang']); ?></div>
        <div class="text-xs text-slate-400 mt-1"><?php echo e($stats['total_stok']); ?> unit total &bull; <?php echo e($stats['stok_tersedia']); ?> tersedia</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Sedang Dipinjam</span>
            <span class="h-8 w-8 rounded-lg bg-violet-500/10 text-violet-300 inline-flex items-center justify-center"><i class="fa-solid fa-right-left text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-violet-300"><?php echo e($stats['dipinjam']); ?></div>
        <div class="text-xs text-slate-400 mt-1">unit &bull; <?php echo e($stats['dipinjam_transaksi']); ?> transaksi aktif</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Sudah Dikembalikan</span>
            <span class="h-8 w-8 rounded-lg bg-emerald-500/10 text-emerald-300 inline-flex items-center justify-center"><i class="fa-solid fa-rotate-left text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-emerald-300"><?php echo e($stats['dikembalikan']); ?></div>
        <div class="text-xs text-slate-400 mt-1">unit &bull; <?php echo e($stats['dikembalikan_transaksi']); ?> transaksi selesai</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Menunggu Verifikasi</span>
            <span class="h-8 w-8 rounded-lg bg-amber-500/10 text-amber-300 inline-flex items-center justify-center"><i class="fa-solid fa-hourglass-half text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-amber-300"><?php echo e($stats['pending']); ?></div>
        <div class="text-xs text-slate-400 mt-1"></div>
        <a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'pending'])); ?>" class="text-xs text-cyan-300 hover:text-cyan-200 font-medium mt-1 inline-flex items-center gap-1">Lihat pengajuan <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
    </div>
    <div class="rounded-2xl border <?php echo e($stats['terlambat'] > 0 ? 'border-rose-500/40' : 'border-white/5'); ?> bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Terlambat</span>
            <span class="h-8 w-8 rounded-lg bg-rose-500/10 text-rose-300 inline-flex items-center justify-center"><i class="fa-solid fa-triangle-exclamation text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold <?php echo e($stats['terlambat'] > 0 ? 'text-rose-300' : 'text-white'); ?>"><?php echo e($stats['terlambat']); ?></div>
        <div class="text-xs text-slate-400 mt-1">Denda berjalan: <?php echo e(\App\Models\Peminjaman::rupiah($stats['denda_berjalan'])); ?></div>
        <a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'terlambat'])); ?>" class="text-xs text-cyan-300 hover:text-cyan-200 font-medium mt-1 inline-flex items-center gap-1">Lihat yang terlambat <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
    </div>
    <div class="rounded-2xl border <?php echo e($stats['hilang'] > 0 ? 'border-rose-500/40' : 'border-white/5'); ?> bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Barang Hilang</span>
            <span class="h-8 w-8 rounded-lg bg-rose-500/10 text-rose-300 inline-flex items-center justify-center"><i class="fa-solid fa-box-open text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold <?php echo e($stats['hilang'] > 0 ? 'text-rose-300' : 'text-white'); ?>"><?php echo e($stats['hilang']); ?></div>
        <div class="text-xs text-slate-400 mt-1">unit belum diganti &bull; <?php echo e($stats['hilang_kasus']); ?> laporan</div>
        <a href="<?php echo e(route('admin.hilang.index')); ?>" class="text-xs text-cyan-300 hover:text-cyan-200 font-medium mt-1 inline-flex items-center gap-1">Kelola barang hilang <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Denda Belum Lunas</span>
            <span class="h-8 w-8 rounded-lg bg-amber-500/10 text-amber-300 inline-flex items-center justify-center"><i class="fa-solid fa-money-bill-wave text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-amber-300 !text-2xl"><?php echo e(\App\Models\Peminjaman::rupiah($stats['denda_belum_lunas'])); ?></div>
        <div class="text-xs text-slate-400 mt-1">Tercatat, belum dibayar siswa</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Siswa Terdaftar</span>
            <span class="h-8 w-8 rounded-lg bg-sky-500/10 text-sky-300 inline-flex items-center justify-center"><i class="fa-solid fa-users text-xs"></i></span>
        </div>
        <div class="text-3xl font-extrabold text-white"><?php echo e($stats['total_siswa']); ?></div>
        <div class="text-xs text-slate-400 mt-1">Selesai bulan ini: <?php echo e($stats['selesai_bulan_ini']); ?></div>
    </div>
</div>

<?php if($terlambatList->isNotEmpty()): ?>
<div class="rounded-2xl border border-rose-500/30 bg-rose-500/5 backdrop-blur shadow-card mb-6">
    <div class="p-5 sm:p-6 border-b border-rose-500/20 flex flex-wrap items-center justify-between gap-2">
        <h2 class="font-bold text-rose-300 text-sm flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> Peringatan: <?php echo e($terlambatList->count()); ?> peminjaman terlambat dikembalikan</h2>
        <span class="text-xs text-slate-400">Tarif denda: <?php echo e(\App\Models\Peminjaman::infoTarifDenda()); ?></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Kode</th><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Barang</th><th class="px-5 py-3">Seharusnya Kembali</th><th class="px-5 py-3">Terlambat</th><th class="px-5 py-3">Denda</th><th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-500/10">
            <?php $__currentLoopData = $terlambatList->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-rose-500/5 transition">
                    <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($t->kode_peminjaman); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($t->siswa->name); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($t->barang->nama_barang); ?> <span class="text-slate-500">(<?php echo e($t->jumlah); ?>)</span></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($t->tanggal_kembali_rencana->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3 font-semibold text-rose-300"><?php echo e($t->hariTerlambat()); ?> hari</td>
                    <td class="px-5 py-3 font-semibold text-rose-300"><?php echo e(\App\Models\Peminjaman::rupiah($t->dendaSaatIni())); ?></td>
                    <td class="px-5 py-3 text-right"><a href="<?php echo e(route('admin.peminjaman.show', $t)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-rose-400/30 px-3 py-1.5 text-xs font-semibold text-rose-300 hover:bg-rose-500/10 transition">Kelola</a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php if($terlambatList->count() > 5): ?>
    <div class="px-5 py-3 border-t border-rose-500/20 text-xs"><a href="<?php echo e(route('admin.peminjaman.index', ['status' => 'terlambat'])); ?>" class="text-cyan-300 hover:text-cyan-200 font-medium">Lihat semua <?php echo e($terlambatList->count()); ?> peminjaman terlambat &rarr;</a></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card">
        <div class="p-5 sm:p-6 border-b border-white/5">
            <h2 class="font-bold text-white text-sm">Pengajuan Peminjaman Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Kode</th>
                        <th class="px-5 py-3">Siswa</th>
                        <th class="px-5 py-3">Barang</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                <?php $__empty_1 = true; $__currentLoopData = $peminjamanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($p->kode_peminjaman); ?></td>
                        <td class="px-5 py-3 text-slate-300"><?php echo e($p->siswa->name); ?></td>
                        <td class="px-5 py-3 text-slate-300"><?php echo e($p->barang->nama_barang); ?></td>
                        <td class="px-5 py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $p->badgeColor(),'label' => $p->labelStatus(),'dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->labelStatus()),'dark' => true]); ?>
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
                            <a href="<?php echo e(route('admin.peminjaman.show', $p)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-white/10 px-3 py-1.5 text-xs font-semibold text-slate-300 hover:bg-white/5 transition">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-slate-500 py-8">Belum ada data peminjaman.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
        <h2 class="font-bold text-white text-sm mb-4">Stok Barang Menipis</h2>
        <ul class="space-y-2.5">
            <?php $__empty_1 = true; $__currentLoopData = $barangMenipis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="flex items-center justify-between rounded-xl bg-white/5 px-3.5 py-2.5">
                    <span class="text-sm text-slate-200"><?php echo e($b->nama_barang); ?></span>
                    <span class="text-xs font-semibold rounded-full bg-amber-500/10 text-amber-300 ring-1 ring-amber-400/20 px-2.5 py-1"><?php echo e($b->stok_tersedia); ?>/<?php echo e($b->stok_total); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-sm text-slate-500 py-3">Tidak ada data.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>