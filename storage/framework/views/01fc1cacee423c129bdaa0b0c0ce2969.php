<?php $__env->startSection('title', 'Data Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Data Barang</h1><p class="page-sub">Kelola inventaris dan stok barang sekolah.</p></div>
    <a href="<?php echo e(route('admin.barang.create')); ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Barang
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="label">Cari</label>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama / kode barang"
                   class="input">
        </div>
        <div>
            <label class="label">Kategori</label>
            <select name="kategori_barang_id"
                    class="input">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" class="bg-white" <?php if(request('kategori_barang_id')==$k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800"><?php echo e($b->kode_barang); ?></td>
                    <td class="text-slate-800"><?php echo e($b->nama_barang); ?></td>
                    <td class="text-slate-500"><?php echo e($b->kategori->nama_kategori ?? '-'); ?></td>
                    <td>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset <?php echo e($b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($b->stok_tersedia <= 2 ? 'bg-yellow-50 text-yellow-700 ring-yellow-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200')); ?>">
                            <?php echo e($b->stok_tersedia); ?> / <?php echo e($b->stok_total); ?>

                        </span>
                    </td>
                    <td class="text-slate-500"><?php echo e(ucfirst($b->kondisi)); ?></td>
                    <td class="text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="<?php echo e(route('admin.barang.show', $b)); ?>" class="btn btn-outline btn-icon" title="Detail"><i class="fa-solid fa-eye text-xs"></i></a>
                            <a href="<?php echo e(route('admin.barang.edit', $b)); ?>" class="btn btn-outline btn-icon" title="Ubah"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="<?php echo e(route('admin.barang.destroy', $b)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data barang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200"><?php echo e($barang->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/barang/index.blade.php ENDPATH**/ ?>