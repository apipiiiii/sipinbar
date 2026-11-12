<?php $__env->startSection('title', 'Kategori Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Kategori Barang</h1><p class="page-sub">Kelompok barang beserta petugas penanggung jawabnya.</p></div>
    <a href="<?php echo e(route('admin.kategori.create')); ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="flex gap-3">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama kategori..."
               class="input flex-1">
        <button class="btn btn-outline"><i class="fa-solid fa-search"></i></button>
    </form>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead><tr>
                <th>Nama Kategori</th><th>Keterangan</th><th>Petugas</th><th>Jumlah Barang</th><th class="text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800"><?php echo e($k->nama_kategori); ?></td>
                    <td class="text-slate-500"><?php echo e($k->keterangan ?? '-'); ?></td>
                    <td>
                        <?php if($k->petugas): ?>
                            <span class="text-slate-800"><?php echo e($k->petugas->name); ?></span>
                        <?php else: ?>
                            <span class="inline-flex items-center rounded-full bg-yellow-50 text-yellow-700 px-2.5 py-1 text-xs font-semibold ring-1 ring-yellow-200">Belum ada petugas</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="inline-flex items-center rounded-full bg-slate-50 text-slate-600 px-2.5 py-1 text-xs font-semibold ring-1 ring-slate-200"><?php echo e($k->barang_count); ?></span></td>
                    <td class="text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="<?php echo e(route('admin.kategori.edit', $k)); ?>" class="btn btn-outline btn-icon" title="Ubah"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="<?php echo e(route('admin.kategori.destroy', $k)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data kategori.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200"><?php echo e($kategori->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/kategori/index.blade.php ENDPATH**/ ?>