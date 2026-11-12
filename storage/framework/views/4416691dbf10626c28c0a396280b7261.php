<?php $__env->startSection('title', 'Katalog Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6"><h1 class="page-title">Katalog Barang</h1><p class="page-sub">Telusuri barang dan cek ketersediaan stok.</p></div>

<form class="mb-5 flex flex-col gap-2 sm:flex-row">
    <div class="relative flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama barang..." class="input pl-9">
    </div>
    <select name="kategori_barang_id" class="input sm:w-60" onchange="this.form.submit()">
        <option value="">Semua kategori</option>
        <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($k->id); ?>" <?php if(request('kategori_barang_id')==$k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600 transition hover:border-slate-300 has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50 has-[:checked]:text-brand-800">
        <input type="checkbox" name="tersedia" value="1" <?php if(request()->boolean('tersedia')): echo 'checked'; endif; ?> onchange="this.form.submit()" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500/30"> Tersedia saja
    </label>
    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass text-xs"></i> Cari</button>
</form>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
<?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $persen = $b->stok_total > 0 ? round($b->stok_tersedia / $b->stok_total * 100) : 0;
        $warna = $b->stok_tersedia == 0 ? 'bg-rose-500' : ($b->stok_tersedia <= 2 ? 'bg-yellow-500' : 'bg-brand-600');
    ?>
    <div class="card group flex flex-col overflow-hidden transition duration-200 hover:-translate-y-0.5 hover:shadow-pop">
        <a href="<?php echo e(route('siswa.katalog.show', $b)); ?>" class="relative block">
            <?php if($b->foto): ?>
                <img src="<?php echo e(asset('storage/'.$b->foto)); ?>" alt="<?php echo e($b->nama_barang); ?>" class="h-40 w-full object-cover <?php echo e($b->stok_tersedia == 0 ? 'opacity-60' : ''); ?>">
            <?php else: ?>
                <div class="flex h-40 w-full items-center justify-center bg-slate-100"><i class="fa-solid fa-box text-3xl text-slate-300"></i></div>
            <?php endif; ?>
            <span class="absolute left-3 top-3 rounded-md bg-white px-2 py-0.5 text-[11px] font-medium text-slate-700 shadow-soft"><?php echo e($b->kategori->nama_kategori ?? 'Tanpa kategori'); ?></span>
            <?php if($b->stok_tersedia == 0): ?>
                <span class="absolute right-3 top-3 rounded-md bg-rose-600 px-2 py-0.5 text-[11px] font-semibold text-white">Habis</span>
            <?php endif; ?>
        </a>
        <div class="flex flex-1 flex-col p-4">
            <h3 class="font-semibold leading-snug text-slate-900"><?php echo e($b->nama_barang); ?></h3>
            <p class="mb-3 text-xs text-slate-400"><?php echo e($b->kode_barang); ?></p>

            <div class="mb-4">
                <div class="mb-1.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Tersedia</span>
                    <span class="font-semibold text-slate-800"><?php echo e($b->stok_tersedia); ?> <span class="font-normal text-slate-400">/ <?php echo e($b->stok_total); ?></span></span>
                </div>
                <div class="h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full <?php echo e($warna); ?>" style="width: <?php echo e($persen); ?>%"></div></div>
            </div>

            <div class="mt-auto flex gap-2">
                <a href="<?php echo e(route('siswa.katalog.show', $b)); ?>" class="btn btn-outline btn-sm flex-1">Detail</a>
                <a href="<?php echo e(route('siswa.peminjaman.create', ['barang_id' => $b->id])); ?>"
                   class="btn btn-primary btn-sm flex-1 <?php echo e($b->stok_tersedia==0 ? 'pointer-events-none opacity-50' : ''); ?>">Ajukan</a>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full py-16 text-center text-slate-400"><i class="fa-regular fa-face-frown mb-2 block text-2xl"></i>Tidak ada barang ditemukan.</div>
<?php endif; ?>
</div>
<div class="mt-5"><?php echo e($barang->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/siswa/katalog/index.blade.php ENDPATH**/ ?>