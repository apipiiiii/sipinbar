<?php $__env->startSection('title', 'Detail Barang'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-cube"></i></span>
    Detail Barang: <?php echo e($barang->nama_barang); ?>

</h1>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-5">
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <?php if($barang->foto): ?>
                <img src="<?php echo e(asset('storage/'.$barang->foto)); ?>" class="w-full rounded-xl mb-4 ring-1 ring-white/10">
            <?php endif; ?>
            <dl class="divide-y divide-white/5 text-sm">
                <div class="flex justify-between py-2"><dt class="text-slate-400">Kode</dt><dd class="text-slate-200 font-medium"><?php echo e($barang->kode_barang); ?></dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-400">Kategori</dt><dd class="text-slate-200 font-medium"><?php echo e($barang->kategori->nama_kategori ?? '-'); ?></dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-400">Stok Total</dt><dd class="text-slate-200 font-medium"><?php echo e($barang->stok_total); ?></dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-400">Stok Tersedia</dt><dd class="text-slate-200 font-medium"><?php echo e($barang->stok_tersedia); ?></dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-400">Kondisi</dt><dd class="text-slate-200 font-medium"><?php echo e(ucfirst($barang->kondisi)); ?></dd></div>
                <div class="flex justify-between py-2 gap-4"><dt class="text-slate-400 shrink-0">Deskripsi</dt><dd class="text-slate-200 text-right"><?php echo e($barang->deskripsi ?? '-'); ?></dd></div>
            </dl>
            <div class="mt-5 flex gap-2">
                <a href="<?php echo e(route('admin.barang.edit', $barang)); ?>" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-3.5 py-2 text-xs font-semibold text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-pen"></i> Edit</a>
                <a href="<?php echo e(route('admin.barang.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-3.5 py-2 text-xs font-semibold text-slate-300 hover:bg-white/5 transition">Kembali</a>
            </div>
        </div>
    </div>
    <div class="lg:col-span-7">
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card">
            <div class="p-5 sm:p-6 border-b border-white/5"><h2 class="font-bold text-white text-sm">Riwayat Peminjaman Barang Ini</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead><tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Kode</th><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Jumlah</th><th class="px-5 py-3">Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-white/5">
                    <?php $__empty_1 = true; $__currentLoopData = $barang->peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($p->kode_peminjaman); ?></td>
                            <td class="px-5 py-3 text-slate-300"><?php echo e($p->siswa->name ?? '-'); ?></td>
                            <td class="px-5 py-3 text-slate-300"><?php echo e($p->jumlah); ?></td>
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
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="text-center text-slate-500 py-8">Belum pernah dipinjam.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/barang/show.blade.php ENDPATH**/ ?>