<?php $__env->startSection('title', 'Verifikasi Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-right-left"></i></span>
    Verifikasi & Transaksi Peminjaman
</h1>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Cari (kode / nama siswa)</label>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Status</label>
            <select name="status" class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
                <option value="" class="bg-base-850">Semua Status</option>
                <?php $__currentLoopData = ['pending'=>'Menunggu Verifikasi','approved'=>'Disetujui','terlambat'=>'Terlambat','rejected'=>'Ditolak','selesai'=>'Selesai','hilang'=>'Hilang (Belum Diganti)','diganti'=>'Hilang (Sudah Diganti)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" class="bg-base-850" <?php if(request('status')==$val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Kode</th><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Barang</th><th class="px-5 py-3">Jumlah</th><th class="px-5 py-3">Tgl Pinjam</th><th class="px-5 py-3">Rencana Kembali</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
            <?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition <?php echo e($p->isTerlambat() ? 'bg-rose-500/10 hover:bg-rose-500/15' : 'hover:bg-white/5'); ?>">
                    <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($p->kode_peminjaman); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($p->siswa->name); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($p->barang->nama_barang); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($p->jumlah); ?></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($p->tanggal_kembali_rencana->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3">
                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
<?php endif; ?>
                        <?php if($p->dendaSaatIni() > 0): ?>
                            <div class="text-xs mt-1 <?php echo e($p->status === 'approved' || ! $p->denda_lunas ? 'text-rose-300' : 'text-emerald-300'); ?>">Denda <?php echo e(\App\Models\Peminjaman::rupiah($p->dendaSaatIni())); ?> &bull; <?php echo e($p->statusDenda()); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="<?php echo e(route('admin.peminjaman.show', $p)); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-3 py-1.5 text-xs font-semibold text-white shadow-glow transition">Kelola</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-slate-500 py-10">Belum ada data peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-white/5"><?php echo e($peminjaman->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/peminjaman/index.blade.php ENDPATH**/ ?>