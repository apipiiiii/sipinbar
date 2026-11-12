<?php $b = $barang ?? null; ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="label">Kode Barang</label>
        <input type="text" name="kode_barang" value="<?php echo e(old('kode_barang', $b->kode_barang ?? '')); ?>" required
               class="input">
    </div>
    <div>
        <label class="label">Nama Barang</label>
        <input type="text" name="nama_barang" value="<?php echo e(old('nama_barang', $b->nama_barang ?? '')); ?>" required
               class="input">
    </div>
    <div>
        <label class="label">Kategori</label>
        <select name="kategori_barang_id" required
                class="input">
            <option value="">-- Pilih Kategori --</option>
            <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" class="bg-white" <?php if(old('kategori_barang_id', $b->kategori_barang_id ?? '') == $k->id): echo 'selected'; endif; ?>><?php echo e($k->nama_kategori); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="label">Stok Total</label>
        <input type="number" min="0" name="stok_total" value="<?php echo e(old('stok_total', $b->stok_total ?? 0)); ?>" required
               class="input">
        <?php if($b): ?>
            <p class="text-xs text-slate-500 mt-1.5">Stok tersedia saat ini: <?php echo e($b->stok_tersedia); ?>. Menaikkan/menurunkan stok total akan otomatis menyesuaikan stok tersedia.</p>
        <?php endif; ?>
    </div>
    <div>
        <label class="label">Kondisi</label>
        <select name="kondisi" required
                class="input">
            <?php $__currentLoopData = ['baik' => 'Baik', 'rusak ringan' => 'Rusak Ringan', 'rusak berat' => 'Rusak Berat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php if(old('kondisi', $b->kondisi ?? 'baik') == $val): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="label">Foto Barang (opsional)</label>
        <input type="file" name="foto" accept="image/*"
               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:px-3 file:py-1.5 file:text-xs file:font-semibold">
        <?php if($b?->foto): ?>
            <img src="<?php echo e(asset('storage/'.$b->foto)); ?>" class="mt-2.5 rounded-xl h-16 ring-1 ring-slate-200">
        <?php endif; ?>
    </div>
    <div class="md:col-span-2">
        <label class="label">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
                  class="input"><?php echo e(old('deskripsi', $b->deskripsi ?? '')); ?></textarea>
    </div>
</div>
<div class="mt-6 flex items-center gap-3">
    <button class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk"></i> Simpan
    </button>
    <a href="<?php echo e(route('admin.barang.index')); ?>" class="btn btn-outline">Batal</a>
</div>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/barang/_form.blade.php ENDPATH**/ ?>