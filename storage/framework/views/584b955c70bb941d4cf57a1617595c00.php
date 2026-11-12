<?php $__env->startSection('title', 'Data Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-cubes"></i></span>
        Master Data Barang / Inventaris
    </h1>
    <a href="<?php echo e(route('admin.barang.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition">
        <i class="fa-solid fa-plus"></i> Tambah Barang
    </a>
</div>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Cari</label>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama / kode barang"
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kategori</label>
            <select name="kategori_barang_id"
                    class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
                <option value="" class="bg-base-850">Semua Kategori</option>
                <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" class="bg-base-850" <?php if(request('kategori_barang_id')==$k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
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
                    <th class="px-5 py-3">Kode</th>
                    <th class="px-5 py-3">Nama Barang</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Stok</th>
                    <th class="px-5 py-3">Kondisi</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
            <?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-white/5 transition">
                    <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($b->kode_barang); ?></td>
                    <td class="px-5 py-3 text-slate-200"><?php echo e($b->nama_barang); ?></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($b->kategori->nama_kategori ?? '-'); ?></td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset
                            <?php echo e($b->stok_tersedia == 0 ? 'bg-rose-500/10 text-rose-300 ring-rose-400/30' : ($b->stok_tersedia <= 2 ? 'bg-amber-500/10 text-amber-300 ring-amber-400/30' : 'bg-emerald-500/10 text-emerald-300 ring-emerald-400/30')); ?>">
                            <?php echo e($b->stok_tersedia); ?> / <?php echo e($b->stok_total); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e(ucfirst($b->kondisi)); ?></td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="<?php echo e(route('admin.barang.show', $b)); ?>" class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-white/10 text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-eye text-xs"></i></a>
                            <a href="<?php echo e(route('admin.barang.edit', $b)); ?>" class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-white/10 text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="<?php echo e(route('admin.barang.destroy', $b)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-red-400/20 text-red-300 hover:bg-red-500/10 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-slate-500 py-10">Belum ada data barang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-white/5"><?php echo e($barang->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/barang/index.blade.php ENDPATH**/ ?>