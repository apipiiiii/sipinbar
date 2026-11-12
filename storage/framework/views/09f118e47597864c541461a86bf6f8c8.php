<?php $b = $barang ?? null; ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Kode Barang</label>
        <input type="text" name="kode_barang" value="<?php echo e(old('kode_barang', $b->kode_barang ?? '')); ?>" required
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Barang</label>
        <input type="text" name="nama_barang" value="<?php echo e(old('nama_barang', $b->nama_barang ?? '')); ?>" required
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Kategori</label>
        <select name="kategori_barang_id" required
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
            <option value="" class="bg-base-850">-- Pilih Kategori --</option>
            <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" class="bg-base-850" <?php if(old('kategori_barang_id', $b->kategori_barang_id ?? '') == $k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Stok Total</label>
        <input type="number" min="0" name="stok_total" value="<?php echo e(old('stok_total', $b->stok_total ?? 0)); ?>" required
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
        <?php if($b): ?>
            <p class="text-xs text-slate-500 mt-1.5">Stok tersedia saat ini: <?php echo e($b->stok_tersedia); ?>. Menaikkan/menurunkan stok total akan otomatis menyesuaikan stok tersedia.</p>
        <?php endif; ?>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Kondisi</label>
        <select name="kondisi" required
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
            <?php $__currentLoopData = ['baik' => 'Baik', 'rusak ringan' => 'Rusak Ringan', 'rusak berat' => 'Rusak Berat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" class="bg-base-850" <?php if(old('kondisi', $b->kondisi ?? 'baik') == $val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Foto Barang (opsional)</label>
        <input type="file" name="foto" accept="image/*"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-300 file:mr-3 file:rounded-lg file:border-0 file:bg-cyan-500/10 file:text-cyan-300 file:px-3 file:py-1.5 file:text-xs file:font-semibold">
        <?php if($b?->foto): ?>
            <img src="<?php echo e(asset('storage/'.$b->foto)); ?>" class="mt-2.5 rounded-xl h-16 ring-1 ring-white/10">
        <?php endif; ?>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
                  class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition"><?php echo e(old('deskripsi', $b->deskripsi ?? '')); ?></textarea>
    </div>
</div>
<div class="mt-6 flex items-center gap-3">
    <button class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition">
        <i class="fa-solid fa-floppy-disk"></i> Simpan
    </button>
    <a href="<?php echo e(route('admin.barang.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 transition">Batal</a>
</div>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/barang/_form.blade.php ENDPATH**/ ?>