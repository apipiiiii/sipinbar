<?php $isAdmin = auth()->user()->isAdmin(); ?>

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold <?php echo e($isAdmin ? 'text-white' : 'text-slate-900'); ?> flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl inline-flex items-center justify-center <?php echo e($isAdmin ? 'bg-cyan-500/10 text-cyan-300 ring-1 ring-cyan-400/20' : 'bg-ocean-50 text-ocean-600'); ?>"><i class="fa-solid fa-user-gear"></i></span>
    Profil & Pengaturan Akun
</h1>

<?php
    $cardClass = $isAdmin
        ? 'rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6'
        : 'bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-6';
    $labelClass = $isAdmin ? 'block text-sm font-semibold text-slate-300 mb-1.5' : 'block text-sm font-semibold text-slate-700 mb-1.5';
    $inputClass = $isAdmin
        ? 'w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition'
        : 'w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition';
    $headingClass = $isAdmin ? 'font-bold text-white text-sm mb-4' : 'font-bold text-slate-900 text-sm mb-4';
    $primaryBtn = $isAdmin
        ? 'inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition'
        : 'inline-flex items-center gap-2 rounded-xl bg-ocean-600 hover:bg-ocean-700 px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition';
    $outlineBtn = $isAdmin
        ? 'inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-white/5 transition'
        : 'inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition';
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <div class="<?php echo e($cardClass); ?>">
        <h2 class="<?php echo e($headingClass); ?>">Informasi Profil</h2>
        <form method="POST" action="<?php echo e(route('profile.update')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required class="<?php echo e($inputClass); ?>">
            </div>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required class="<?php echo e($inputClass); ?>">
            </div>
            <?php if($user->isSiswa()): ?>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">Kelas</label>
                <input type="text" name="kelas" value="<?php echo e(old('kelas', $user->kelas)); ?>" class="<?php echo e($inputClass); ?>">
            </div>
            <?php endif; ?>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">No. HP</label>
                <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $user->no_hp)); ?>" class="<?php echo e($inputClass); ?>">
            </div>
            <div class="mb-5">
                <label class="<?php echo e($labelClass); ?>">Alamat</label>
                <textarea name="alamat" rows="2" class="<?php echo e($inputClass); ?>"><?php echo e(old('alamat', $user->alamat)); ?></textarea>
            </div>
            <button class="<?php echo e($primaryBtn); ?>"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
        </form>
    </div>

    <div class="<?php echo e($cardClass); ?>">
        <h2 class="<?php echo e($headingClass); ?>">Ubah Kata Sandi</h2>
        <form method="POST" action="<?php echo e(route('profile.password')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" required class="<?php echo e($inputClass); ?>">
            </div>
            <div class="mb-4">
                <label class="<?php echo e($labelClass); ?>">Kata Sandi Baru</label>
                <input type="password" name="password" required minlength="6" class="<?php echo e($inputClass); ?>">
            </div>
            <div class="mb-5">
                <label class="<?php echo e($labelClass); ?>">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" required minlength="6" class="<?php echo e($inputClass); ?>">
            </div>
            <button class="<?php echo e($outlineBtn); ?>"><i class="fa-solid fa-key"></i> Perbarui Kata Sandi</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($isAdmin ? 'layouts.admin' : 'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/profile/edit.blade.php ENDPATH**/ ?>