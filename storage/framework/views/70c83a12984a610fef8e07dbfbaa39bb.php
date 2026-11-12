<?php $__env->startSection('title', 'Riwayat Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-clock-rotate-left"></i></span>
        Riwayat Peminjaman Saya
    </h1>
    <a href="<?php echo e(route('siswa.peminjaman.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-ocean-600 hover:bg-ocean-700 px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition">
        <i class="fa-solid fa-plus"></i> Ajukan Peminjaman
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-6 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_auto] gap-3 items-end max-w-md">
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Status</label>
            <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = ['pending'=>'Menunggu Verifikasi','approved'=>'Disetujui','terlambat'=>'Terlambat','rejected'=>'Ditolak','selesai'=>'Selesai','hilang'=>'Hilang (Belum Diganti)','diganti'=>'Hilang (Sudah Diganti)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php if(request('status')==$val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Kode</th><th class="px-5 py-3">Barang</th><th class="px-5 py-3">Jumlah</th><th class="px-5 py-3">Tgl Pinjam</th><th class="px-5 py-3">Rencana Kembali</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition <?php echo e($p->isTerlambat() ? 'bg-rose-50 hover:bg-rose-100/70' : 'hover:bg-slate-50/60'); ?>">
                    <td class="px-5 py-3 font-medium text-slate-800"><?php echo e($p->kode_peminjaman); ?></td>
                    <td class="px-5 py-3 text-slate-600"><?php echo e($p->barang->nama_barang); ?></td>
                    <td class="px-5 py-3 text-slate-600"><?php echo e($p->jumlah); ?></td>
                    <td class="px-5 py-3 text-slate-500"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3 text-slate-500"><?php echo e($p->tanggal_kembali_rencana->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3">
                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
<?php endif; ?>
                        <?php if($p->dendaSaatIni() > 0): ?>
                            <div class="text-xs mt-1 font-medium <?php echo e($p->status === 'approved' || ! $p->denda_lunas ? 'text-rose-600' : 'text-emerald-600'); ?>">Denda <?php echo e(\App\Models\Peminjaman::rupiah($p->dendaSaatIni())); ?> &bull; <?php echo e($p->statusDenda()); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="<?php echo e(route('siswa.peminjaman.show', $p)); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Detail</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-slate-400 py-10">Belum ada riwayat peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-100"><?php echo e($peminjaman->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/siswa/peminjaman/index.blade.php ENDPATH**/ ?>