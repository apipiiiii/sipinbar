<?php
    $layout = auth()->user()->isPetugas() ? 'layouts.petugas' : (auth()->user()->isSiswa() ? 'layouts.user' : 'layouts.admin');
?>

<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="page-title">Profil & Pengaturan Akun</h1>
    <p class="page-sub">Perbarui data diri dan kata sandi Anda.</p>
</div>

<?php
    $cardClass = 'card p-5 sm:p-6';
    $labelClass = 'label';
    $inputClass = 'input';
    $headingClass = 'card-title mb-4';
    $primaryBtn = 'btn btn-primary';
    $outlineBtn = 'btn btn-outline';
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

<div class="<?php echo e($cardClass); ?> mt-5">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h2 class="card-title">Tampilan</h2>
            <p class="mt-0.5 text-sm text-slate-500">Pilih warna aksen aplikasi. Pilihan tersimpan di perangkat ini dan hanya berlaku untuk akun Anda di browser ini.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5" id="sp-accent-picker">
            <?php $__currentLoopData = ['terakota' => ['Terakota', '#BF4A0C'], 'magenta' => ['Magenta', '#A21CAF'], 'indigo' => ['Indigo', '#4F46E5'], 'grafit' => ['Grafit', '#44403C']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => [$nama, $hex]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-accent="<?php echo e($kode); ?>" class="group flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition hover:border-slate-300">
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full text-white" style="background: <?php echo e($hex); ?>"><i class="fa-solid fa-check text-[9px] opacity-0 transition group-aria-pressed:opacity-100"></i></span>
                    <?php echo e($nama); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-4 rounded-lg bg-slate-50 p-4">
        <span class="text-xs font-medium text-slate-500">Pratinjau</span>
        <span class="btn btn-primary pointer-events-none">Tombol utama</span>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>Sedang dipinjam</span>
        <div class="h-2 w-40 overflow-hidden rounded-full bg-slate-200"><div class="h-full w-2/3 rounded-full bg-brand-600"></div></div>
        <a class="link pointer-events-none">Tautan</a>
    </div>
</div>

<script>
    (function () {
        var tombol = document.querySelectorAll('#sp-accent-picker [data-accent]');
        function tandai() {
            var aktif = document.documentElement.getAttribute('data-accent') || 'terakota';
            tombol.forEach(function (b) {
                var on = b.getAttribute('data-accent') === aktif;
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
                b.classList.toggle('border-brand-600', on);
                b.classList.toggle('bg-brand-50', on);
                b.querySelector('i').style.opacity = on ? 1 : 0;
            });
        }
        tombol.forEach(function (b) {
            b.addEventListener('click', function () {
                var k = b.getAttribute('data-accent');
                if (k === 'terakota') document.documentElement.removeAttribute('data-accent'); else document.documentElement.setAttribute('data-accent', k);
                try { k === 'terakota' ? localStorage.removeItem('sp_accent') : localStorage.setItem('sp_accent', k); } catch (e) {}
                tandai();
            });
        });
        tandai();
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/profile/edit.blade.php ENDPATH**/ ?>