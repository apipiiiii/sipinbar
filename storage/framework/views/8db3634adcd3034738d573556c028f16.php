<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SIPINBAR'); ?> | Sistem Informasi Peminjaman Barang & Inventaris</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        ocean: { 50:'#eff8ff',100:'#dbeffe',200:'#bfe4fe',300:'#93d3fd',400:'#5fb9fa',500:'#3a9df3',600:'#2378e8',700:'#1c60d3',800:'#1e4fac',900:'#1f4487' },
                        mint: { 50:'#effef7',100:'#d8fdec',200:'#b4f9da',300:'#7ff1bf',400:'#42e19c',500:'#1cc987',600:'#12a56e',700:'#12835b',800:'#13674b',900:'#12543f' },
                    },
                    boxShadow: {
                        soft: '0 2px 10px -2px rgba(16,24,40,.06), 0 1px 3px -1px rgba(16,24,40,.06)',
                        softlg: '0 12px 32px -8px rgba(16,24,40,.12)',
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

<?php if(auth()->guard()->check()): ?>
<button id="sp-menu-btn" type="button" onclick="document.getElementById('sp-sidebar').classList.toggle('-translate-x-full'); document.getElementById('sp-overlay').classList.toggle('hidden')" class="lg:hidden fixed top-4 left-4 z-40 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-soft ring-1 ring-slate-200">
    <i class="fa-solid fa-bars text-slate-600"></i>
</button>
<div id="sp-overlay" onclick="document.getElementById('sp-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')" class="hidden fixed inset-0 bg-slate-900/30 z-30 lg:hidden"></div>

<aside id="sp-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full lg:translate-x-0 transition-transform duration-200 bg-white border-r border-slate-100 flex flex-col">
    <div class="h-16 flex items-center gap-2.5 px-5 border-b border-slate-100">
        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-ocean-500 to-mint-500 flex items-center justify-center text-white shadow-soft">
            <i class="fa-solid fa-boxes-stacked text-sm"></i>
        </div>
        <div class="leading-tight">
            <p class="font-extrabold text-slate-900 tracking-tight">SIPINBAR</p>
            <p class="text-[11px] text-slate-400 font-medium">Peminjaman Barang</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Menu Utama</p>
        <a href="<?php echo e(route('siswa.dashboard')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('siswa.dashboard') ? 'bg-ocean-50 text-ocean-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <i class="fa-solid fa-gauge w-4 text-center <?php echo e(request()->routeIs('siswa.dashboard') ? 'text-ocean-600' : 'text-slate-400 group-hover:text-slate-600'); ?>"></i> Dashboard
        </a>
        <a href="<?php echo e(route('siswa.katalog.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('siswa.katalog.*') ? 'bg-ocean-50 text-ocean-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <i class="fa-solid fa-list-check w-4 text-center <?php echo e(request()->routeIs('siswa.katalog.*') ? 'text-ocean-600' : 'text-slate-400 group-hover:text-slate-600'); ?>"></i> Katalog Barang
        </a>
        <a href="<?php echo e(route('siswa.peminjaman.create')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('siswa.peminjaman.create') ? 'bg-ocean-50 text-ocean-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <i class="fa-solid fa-square-plus w-4 text-center <?php echo e(request()->routeIs('siswa.peminjaman.create') ? 'text-ocean-600' : 'text-slate-400 group-hover:text-slate-600'); ?>"></i> Ajukan Peminjaman
        </a>
        <a href="<?php echo e(route('siswa.peminjaman.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('siswa.peminjaman.index') || request()->routeIs('siswa.peminjaman.show') ? 'bg-ocean-50 text-ocean-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <i class="fa-solid fa-clock-rotate-left w-4 text-center <?php echo e(request()->routeIs('siswa.peminjaman.index') || request()->routeIs('siswa.peminjaman.show') ? 'text-ocean-600' : 'text-slate-400 group-hover:text-slate-600'); ?>"></i> Riwayat Peminjaman
        </a>

        <p class="px-3 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Akun</p>
        <a href="<?php echo e(route('profile.edit')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('profile.*') ? 'bg-ocean-50 text-ocean-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'); ?>">
            <i class="fa-solid fa-user-gear w-4 text-center <?php echo e(request()->routeIs('profile.*') ? 'text-ocean-600' : 'text-slate-400 group-hover:text-slate-600'); ?>"></i> Profil & Kata Sandi
        </a>
    </nav>

    <div class="p-3 border-t border-slate-100">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
            <div class="h-9 w-9 shrink-0 rounded-full bg-gradient-to-br from-ocean-400 to-mint-400 flex items-center justify-center text-white text-sm font-bold">
                <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-slate-800 truncate"><?php echo e(auth()->user()->name); ?></p>
                <p class="text-xs text-slate-400">Siswa</p>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                <?php echo csrf_field(); ?>
                <button title="Logout" class="h-8 w-8 inline-flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
<?php endif; ?>

<div class="<?php echo e(auth()->check() ? 'lg:pl-64' : ''); ?>">
    <?php if(auth()->guard()->check()): ?>
    <header class="sticky top-0 z-20 h-16 bg-white/80 backdrop-blur border-b border-slate-100 flex items-center justify-end px-4 lg:px-8">
        <div class="flex items-center gap-3">
            <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-mint-50 px-3 py-1 text-xs font-semibold text-mint-700">
                <i class="fa-solid fa-circle text-[6px]"></i> Siswa
            </span>
            <span class="text-sm font-semibold text-slate-700"><?php echo e(auth()->user()->name); ?></span>
        </div>
    </header>
    <?php endif; ?>

    <main class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto">
        <?php if(session('success')): ?>
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-mint-200 bg-mint-50 px-4 py-3 text-sm text-mint-800">
                <i class="fa-solid fa-circle-check mt-0.5 text-mint-500"></i>
                <p class="flex-1"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>
                <p class="flex-1"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Terdapat kesalahan input:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/layouts/user.blade.php ENDPATH**/ ?>