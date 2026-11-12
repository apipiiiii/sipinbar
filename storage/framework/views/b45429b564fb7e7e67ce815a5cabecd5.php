<?php $__env->startSection('title', 'Kategori Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-tags"></i></span>
        Kategori Barang (Data Pendukung)
    </h1>
    <a href="<?php echo e(route('admin.kategori.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6 mb-5">
    <form class="flex gap-3">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama kategori..."
               class="flex-1 rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
        <button class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-search"></i></button>
    </form>
</div>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead><tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                <th class="px-5 py-3">Nama Kategori</th><th class="px-5 py-3">Keterangan</th><th class="px-5 py-3">Jumlah Barang</th><th class="px-5 py-3 text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-white/5">
            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-white/5 transition">
                    <td class="px-5 py-3 font-medium text-slate-200"><?php echo e($k->nama_kategori); ?></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($k->keterangan ?? '-'); ?></td>
                    <td class="px-5 py-3"><span class="inline-flex items-center rounded-full bg-white/5 text-slate-300 px-2.5 py-1 text-xs font-semibold ring-1 ring-white/10"><?php echo e($k->barang_count); ?></span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="<?php echo e(route('admin.kategori.edit', $k)); ?>" class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-white/10 text-slate-300 hover:bg-white/5 transition"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="<?php echo e(route('admin.kategori.destroy', $k)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-red-400/20 text-red-300 hover:bg-red-500/10 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-slate-500 py-10">Belum ada data kategori.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-white/5"><?php echo e($kategori->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/kategori/index.blade.php ENDPATH**/ ?>