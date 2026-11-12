<?php $__env->startSection('title', 'Katalog Barang'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-list-check"></i></span>
    Katalog Barang & Ketersediaan Stok
</h1>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-6 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Cari Barang</label>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama barang..."
                   class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kategori</label>
            <select name="kategori_barang_id" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php if(request('kategori_barang_id')==$k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
<?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden flex flex-col">
        <?php if($b->foto): ?>
            <img src="<?php echo e(asset('storage/'.$b->foto)); ?>" class="h-36 w-full object-cover">
        <?php else: ?>
            <div class="h-36 w-full flex items-center justify-center bg-slate-50">
                <i class="fa-solid fa-box text-3xl text-slate-300"></i>
            </div>
        <?php endif; ?>
        <div class="p-4 flex flex-col flex-1">
            <h3 class="font-bold text-slate-900 mb-0.5"><?php echo e($b->nama_barang); ?></h3>
            <p class="text-xs text-slate-400 mb-3"><?php echo e($b->kategori->nama_kategori ?? '-'); ?> &bull; <?php echo e($b->kode_barang); ?></p>
            <span class="inline-flex w-fit items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset mb-3
                <?php echo e($b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-600/20' : ($b->stok_tersedia <= 2 ? 'bg-amber-50 text-amber-700 ring-amber-600/20' : 'bg-mint-50 text-mint-700 ring-mint-600/20')); ?>">
                Stok tersedia: <?php echo e($b->stok_tersedia); ?>

            </span>
            <div class="mt-auto flex gap-2">
                <a href="<?php echo e(route('siswa.katalog.show', $b)); ?>" class="flex-1 text-center rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Detail</a>
                <a href="<?php echo e(route('siswa.peminjaman.create', ['barang_id' => $b->id])); ?>"
                   class="flex-1 text-center rounded-xl px-3 py-2 text-xs font-semibold text-white transition <?php echo e($b->stok_tersedia==0 ? 'bg-slate-300 pointer-events-none' : 'bg-ocean-600 hover:bg-ocean-700'); ?>">Ajukan</a>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full text-center text-slate-400 py-16">Tidak ada barang ditemukan.</div>
<?php endif; ?>
</div>
<div class="mt-5"><?php echo e($barang->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/siswa/katalog/index.blade.php ENDPATH**/ ?>