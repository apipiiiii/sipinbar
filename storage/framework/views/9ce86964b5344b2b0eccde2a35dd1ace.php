<?php $__env->startSection('shell'); ?>
<?php if(auth()->guard()->check()): ?>
<?php
    $roleLabel = 'Siswa';
    $menu = [
        ['siswa.dashboard', 'Dashboard', 'fa-chart-pie', 'siswa.dashboard'],
        ['siswa.katalog.index', 'Katalog', 'fa-list-check', 'siswa.katalog.*'],
        ['siswa.peminjaman.index', 'Riwayat', 'fa-clock-rotate-left', 'siswa.peminjaman.index|siswa.peminjaman.show|siswa.peminjaman.create'],
    ];
    $cocok = fn ($pola) => collect(explode('|', $pola))->contains(fn ($p) => request()->routeIs($p));
?>

<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-14 max-w-6xl items-center gap-6 px-4 lg:px-8">
        <a href="<?php echo e(route('siswa.dashboard')); ?>" class="flex items-center gap-2.5">
            <?php echo $__env->make('layouts.partials.brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <span class="text-sm font-semibold tracking-tight text-slate-900">SIPINBAR</span>
        </a>

        <nav class="hidden items-center gap-1 md:flex">
            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$rt, $label, $icon, $pola]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($rt)); ?>" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition <?php echo e($cocok($pola) ? 'bg-brand-50 font-medium text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                    <i class="fa-solid <?php echo e($icon); ?> text-[13px] <?php echo e($cocok($pola) ? 'text-brand-600' : 'text-slate-400'); ?>"></i><?php echo e($label); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="ml-auto flex items-center gap-1.5">
            <?php echo $__env->make('layouts.partials.palette-trigger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('layouts.partials.notif', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="relative">
                <button type="button" data-dd-toggle="sp-user-pop" class="flex items-center gap-2 rounded-lg p-1 pr-2 transition hover:bg-slate-50">
                    <?php echo $__env->make('layouts.partials.user-chip', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                </button>
                <div id="sp-user-pop" class="absolute right-0 top-full z-50 mt-2 hidden w-52 rounded-xl border border-slate-200 bg-white p-1.5 shadow-pop">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fa-solid fa-user-gear w-4 text-center text-slate-400"></i> Profil & Kata Sandi</a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                        <?php echo csrf_field(); ?>
                        <button class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-700"><i class="fa-solid fa-right-from-bracket w-4 text-center text-slate-400"></i> Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>

<main class="mx-auto w-full max-w-6xl px-4 py-6 pb-24 lg:px-8 md:pb-8">
    <?php echo $__env->make('layouts.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php if(auth()->guard()->check()): ?>
<?php
    $paletteItems = [
        ['Dashboard', route('siswa.dashboard'), 'fa-chart-pie', 'Menu'],
        ['Katalog barang', route('siswa.katalog.index'), 'fa-list-check', 'Menu'],
        ['Riwayat peminjaman', route('siswa.peminjaman.index'), 'fa-clock-rotate-left', 'Menu'],
        ['Ajukan peminjaman', route('siswa.peminjaman.create'), 'fa-plus', 'Aksi cepat'],
        ['Profil & kata sandi', route('profile.edit'), 'fa-user-gear', 'Akun'],
    ];
?>
<?php echo $__env->make('layouts.partials.palette', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<nav class="fixed inset-x-0 bottom-0 z-30 grid grid-cols-4 border-t border-slate-200 bg-white md:hidden">
    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$rt, $label, $icon, $pola]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($rt)); ?>" class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium <?php echo e($cocok($pola) ? 'text-brand-700' : 'text-slate-500'); ?>">
            <i class="fa-solid <?php echo e($icon); ?> text-base"></i><?php echo e($label); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('profile.edit')); ?>" class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium <?php echo e(request()->routeIs('profile.*') ? 'text-brand-700' : 'text-slate-500'); ?>">
        <i class="fa-solid fa-user-gear text-base"></i>Profil
    </a>
</nav>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/user.blade.php ENDPATH**/ ?>