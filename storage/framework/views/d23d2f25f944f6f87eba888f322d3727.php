<?php $__env->startSection('title', 'Data Barang Hilang'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-rose-500/10 text-rose-300 inline-flex items-center justify-center ring-1 ring-rose-400/20"><i class="fa-solid fa-box-open"></i></span>
        Data Barang Hilang
    </h1>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="rounded-2xl border <?php echo e($rekap['belum'] > 0 ? 'border-rose-500/40' : 'border-white/5'); ?> bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Belum Diganti</div>
        <div class="text-3xl font-extrabold <?php echo e($rekap['belum'] > 0 ? 'text-rose-300' : 'text-white'); ?>"><?php echo e($rekap['belum']); ?></div>
        <div class="text-xs text-slate-400 mt-1">laporan &bull; <?php echo e($rekap['belum_unit']); ?> unit</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur p-5 shadow-card">
        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Sudah Diganti</div>
        <div class="text-3xl font-extrabold text-emerald-300"><?php echo e($rekap['sudah']); ?></div>
        <div class="text-xs text-slate-400 mt-1">bisa dihapus dari daftar</div>
    </div>
    <div class="rounded-2xl border border-white/5 bg-white/5 p-5 text-sm text-slate-400 flex items-start gap-2.5">
        <i class="fa-solid fa-circle-info mt-0.5"></i>
        <span>Siswa wajib mengganti dengan barang baru yang sama. Setelah barang pengganti diterima, klik <b class="text-slate-200">Sudah Diganti</b> (stok otomatis bertambah), lalu data boleh dihapus.</span>
    </div>
</div>

<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Cari (kode / siswa / barang)</label>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                   class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Status</label>
            <select name="status" class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
                <option value="" class="bg-base-850">Semua Status</option>
                <option value="belum_diganti" class="bg-base-850" <?php if(request('status')=='belum_diganti'): echo 'selected'; endif; ?>>Belum Diganti</option>
                <option value="sudah_diganti" class="bg-base-850" <?php if(request('status')=='sudah_diganti'): echo 'selected'; endif; ?>>Sudah Diganti</option>
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
                    <th class="px-5 py-3">Kode Pinjam</th><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Barang</th><th class="px-5 py-3">Jumlah</th><th class="px-5 py-3">Tgl Lapor</th><th class="px-5 py-3">Keterangan</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
            <?php $__empty_1 = true; $__currentLoopData = $hilang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition <?php echo e($h->sudahDiganti() ? 'hover:bg-white/5' : 'bg-rose-500/10 hover:bg-rose-500/15'); ?>">
                    <td class="px-5 py-3 font-medium text-slate-200">
                        <a href="<?php echo e(route('admin.peminjaman.show', $h->peminjaman_id)); ?>" class="hover:text-cyan-300"><?php echo e($h->peminjaman->kode_peminjaman); ?></a>
                    </td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($h->siswa->name); ?> <?php if($h->siswa->kelas): ?><span class="text-slate-500">(<?php echo e($h->siswa->kelas); ?>)</span><?php endif; ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($h->barang->nama_barang); ?></td>
                    <td class="px-5 py-3 text-slate-300"><?php echo e($h->jumlah); ?></td>
                    <td class="px-5 py-3 text-slate-400"><?php echo e($h->tanggal_hilang->format('d/m/Y')); ?></td>
                    <td class="px-5 py-3 text-slate-400 max-w-xs"><?php echo e($h->keterangan); ?></td>
                    <td class="px-5 py-3">
                        <?php if($h->sudahDiganti()): ?>
                            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => 'success','label' => 'Sudah Diganti','dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'success','label' => 'Sudah Diganti','dark' => true]); ?>
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
                            <div class="text-xs text-slate-500 mt-1"><?php echo e(optional($h->tanggal_diganti)->format('d/m/Y')); ?></div>
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => 'danger','label' => 'Belum Diganti','dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'danger','label' => 'Belum Diganti','dark' => true]); ?>
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
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-right whitespace-nowrap">
                        <?php if(! $h->sudahDiganti()): ?>
                            <form method="POST" action="<?php echo e(route('admin.hilang.diganti', $h)); ?>" class="inline"
                                  onsubmit="return confirm('Barang pengganti sudah diterima? Stok <?php echo e($h->barang->nama_barang); ?> akan bertambah <?php echo e($h->jumlah); ?> unit.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition"><i class="fa-solid fa-check"></i> Sudah Diganti</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('admin.hilang.destroy', $h)); ?>" class="inline"
                                  onsubmit="return confirm('Hapus data barang hilang ini dari daftar?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="inline-flex items-center gap-1.5 rounded-lg border border-rose-400/30 text-rose-300 hover:bg-rose-500/10 px-3 py-1.5 text-xs font-semibold transition"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-slate-500 py-10">Tidak ada data barang hilang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-white/5"><?php echo e($hilang->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/hilang/index.blade.php ENDPATH**/ ?>