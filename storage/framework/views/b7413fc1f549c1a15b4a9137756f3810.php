<?php $__env->startSection('title', 'Ajukan Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-plus"></i></span>
    Form Pengajuan Peminjaman Barang
</h1>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-6 max-w-3xl">
    <form method="POST" action="<?php echo e(route('siswa.peminjaman.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Barang</label>
                <select name="barang_id" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
                    <option value="">-- Pilih Barang --</option>
                    <?php $__currentLoopData = $barangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id); ?>" <?php if(old('barang_id', $barangDipilih->id ?? null) == $b->id): echo 'selected'; endif; ?>>
                            <?php echo e($b->nama_barang); ?> (Stok tersedia: <?php echo e($b->stok_tersedia); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php if($barangList->isEmpty()): ?>
                    <p class="text-xs text-rose-600 mt-1.5">Saat ini tidak ada barang dengan stok tersedia.</p>
                <?php endif; ?>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jumlah</label>
                <input type="number" name="jumlah" min="1" value="<?php echo e(old('jumlah', 1)); ?>" required
                       class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="<?php echo e(old('tanggal_pinjam', now()->format('Y-m-d'))); ?>" min="<?php echo e(now()->format('Y-m-d')); ?>" required
                       class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Rencana Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" value="<?php echo e(old('tanggal_kembali_rencana')); ?>" min="<?php echo e(now()->format('Y-m-d')); ?>" required
                       class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keperluan Peminjaman</label>
                <textarea name="keperluan" rows="3" required placeholder="Jelaskan keperluan peminjaman barang..."
                          class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition"><?php echo e(old('keperluan')); ?></textarea>
            </div>
        </div>
        <div class="mt-6 flex items-center gap-3">
            <button class="inline-flex items-center gap-2 rounded-xl bg-ocean-600 hover:bg-ocean-700 px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition"><i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan</button>
            <a href="<?php echo e(route('siswa.katalog.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/siswa/peminjaman/create.blade.php ENDPATH**/ ?>