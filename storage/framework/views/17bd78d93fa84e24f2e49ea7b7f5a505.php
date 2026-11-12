<?php $__env->startSection('title', 'Verifikasi Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6"><h1 class="page-title">Verifikasi Peminjaman</h1><p class="page-sub">Proses pengajuan dan pantau seluruh transaksi peminjaman.</p></div>

<?php
    $tab = [
        '' => 'Semua', 'pending' => 'Perlu verifikasi', 'disetujui' => 'Menunggu penyerahan', 'approved' => 'Dipinjam',
        'terlambat' => 'Terlambat', 'pengembalian' => 'Pengembalian', 'dicek_petugas' => 'Konfirmasi akhir', 'selesai' => 'Selesai',
    ];
    $aktifTab = (string) request('status', '');
?>
<div class="mb-4 flex gap-2 overflow-x-auto pb-1">
    <?php $__currentLoopData = $tab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.peminjaman.index', array_filter(['status' => $val, 'q' => request('q')]))); ?>"
           class="inline-flex shrink-0 items-center gap-2 rounded-full border px-3.5 py-1.5 text-sm transition <?php echo e($aktifTab === (string) $val ? 'border-brand-600 bg-brand-600 font-medium text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:text-slate-900'); ?>">
            <?php echo e($label); ?>

            <span class="rounded-full px-1.5 text-[11px] font-semibold <?php echo e($aktifTab === (string) $val ? 'bg-white/20 text-white' : ($val === 'terlambat' && $hitung[$val] > 0 ? 'bg-rose-100 text-rose-700' : ($val === 'pending' && $hitung[$val] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-500'))); ?>"><?php echo e($hitung[$val]); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<form class="relative mb-5 max-w-md">
    <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
    <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari kode atau nama siswa..." class="input pl-9">
</form>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th><th>Siswa</th><th>Barang</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Status</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition <?php echo e($p->isTerlambat() ? 'bg-rose-50 hover:bg-rose-100' : 'hover:bg-slate-50'); ?>">
                    <td class="font-medium text-slate-800"><?php echo e($p->kode_peminjaman); ?></td>
                    <td class="text-slate-600"><?php echo e($p->siswa->name); ?></td>
                    <td class="text-slate-600"><?php echo e($p->barang->nama_barang); ?></td>
                    <td class="text-slate-600"><?php echo e($p->jumlah); ?></td>
                    <td class="text-slate-500"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                    <td class="text-slate-500"><?php echo e($p->tanggal_kembali_rencana->format('d/m/Y')); ?></td>
                    <td>
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
                            <div class="text-xs mt-1 <?php echo e($p->status === 'approved' || ! $p->denda_lunas ? 'text-rose-700' : 'text-emerald-700'); ?>">Denda <?php echo e(\App\Models\Peminjaman::rupiah($p->dendaSaatIni())); ?> &bull; <?php echo e($p->statusDenda()); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <a href="<?php echo e(route('admin.peminjaman.show', $p)); ?>" class="btn btn-primary btn-sm">Kelola</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200"><?php echo e($peminjaman->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/peminjaman/index.blade.php ENDPATH**/ ?>