<?php $__env->startSection('title', 'Daftar'); ?>

<?php $__env->startSection('form'); ?>
<h2 class="text-2xl font-semibold tracking-tight text-slate-900">Daftar akun siswa</h2>
<p class="mt-1 mb-6 text-sm text-slate-500">Buat akun untuk meminjam barang inventaris sekolah. Pendaftaran ini khusus untuk siswa.</p>

<?php if($errors->any()): ?>
    <div class="mb-5 space-y-0.5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($error); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
    <?php echo csrf_field(); ?>
    <div>
        <label class="label">Nama Lengkap</label>
        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus placeholder="Nama sesuai data sekolah" class="input">
    </div>
    <div>
        <label class="label">Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="nama@email.com" class="input">
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="label">NIS</label>
            <input type="text" name="nis_nip" value="<?php echo e(old('nis_nip')); ?>" required placeholder="Nomor Induk Siswa" class="input">
        </div>
        <div>
            <label class="label">Kelas</label>
            <input type="text" name="kelas" value="<?php echo e(old('kelas')); ?>" required placeholder="Contoh: XII RPL B" class="input">
        </div>
    </div>
    <div>
        <label class="label">No. HP <span class="font-normal text-slate-400">(opsional)</span></label>
        <input type="text" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="08xxxxxxxxxx" class="input">
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="label">Kata Sandi</label>
            <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="input">
        </div>
        <div>
            <label class="label">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi kata sandi" class="input">
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-full py-2.5"><i class="fa-solid fa-user-plus"></i> Daftar</button>
</form>

<p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="link">Masuk</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/auth/register.blade.php ENDPATH**/ ?>