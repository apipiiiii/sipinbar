<?php $u = $user ?? null; ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Lengkap</label>
        <input type="text" name="name" value="<?php echo e(old('name', $u->name ?? '')); ?>" required
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Email</label>
        <input type="email" name="email" value="<?php echo e(old('email', $u->email ?? '')); ?>" required
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Role</label>
        <select name="role" required
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
            <option value="siswa" class="bg-base-850" <?php if(old('role', $u->role ?? '') == 'siswa'): echo 'selected'; endif; ?>>Siswa</option>
            <option value="admin" class="bg-base-850" <?php if(old('role', $u->role ?? '') == 'admin'): echo 'selected'; endif; ?>>Admin / Petugas Sarpras</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">NIS / NIP</label>
        <input type="text" name="nis_nip" value="<?php echo e(old('nis_nip', $u->nis_nip ?? '')); ?>"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Kelas (khusus siswa)</label>
        <input type="text" name="kelas" value="<?php echo e(old('kelas', $u->kelas ?? '')); ?>" placeholder="Contoh: XII RPL B"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">No. HP</label>
        <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $u->no_hp ?? '')); ?>"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-300 mb-1.5"><?php echo e($u ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi'); ?></label>
        <input type="password" name="password" <?php echo e($u ? '' : 'required'); ?> minlength="6"
               class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-300 mb-1.5">Alamat</label>
        <textarea name="alamat" rows="2"
                  class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition"><?php echo e(old('alamat', $u->alamat ?? '')); ?></textarea>
    </div>
</div>
<div class="mt-6 flex items-center gap-3">
    <button class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 transition">Batal</a>
</div>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/users/_form.blade.php ENDPATH**/ ?>