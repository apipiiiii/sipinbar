<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SIPINBAR'); ?> | Admin</title>
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
                        base: { 900:'#0b1120', 850:'#0f172a', 800:'#131c30', 700:'#1b2537', 600:'#26324a' },
                        cyan: { 300:'#67e8f9', 400:'#22d3ee', 500:'#06b6d4', 600:'#0891b2' },
                        violet: { 300:'#c4b5fd', 400:'#a78bfa', 500:'#8b5cf6', 600:'#7c3aed' },
                    },
                    boxShadow: {
                        glow: '0 0 0 1px rgba(34,211,238,.15), 0 8px 24px -8px rgba(34,211,238,.25)',
                        card: '0 4px 18px -6px rgba(0,0,0,.4)',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0b1120; background-image: radial-gradient(circle at 15% 0%, rgba(34,211,238,.06), transparent 40%), radial-gradient(circle at 85% 15%, rgba(139,92,246,.07), transparent 40%); }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #26324a; border-radius: 999px; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen font-sans text-slate-200 antialiased">

<?php if(auth()->guard()->check()): ?>
<button id="sp-menu-btn" type="button" onclick="document.getElementById('sp-sidebar').classList.toggle('-translate-x-full'); document.getElementById('sp-overlay').classList.toggle('hidden')" class="lg:hidden fixed top-4 left-4 z-40 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-base-800 ring-1 ring-white/10 text-slate-300 shadow-card">
    <i class="fa-solid fa-bars"></i>
</button>
<div id="sp-overlay" onclick="document.getElementById('sp-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')" class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

<aside id="sp-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full lg:translate-x-0 transition-transform duration-200 bg-base-850/95 backdrop-blur border-r border-white/5 flex flex-col">
    <div class="h-16 flex items-center gap-2.5 px-5 border-b border-white/5">
        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 flex items-center justify-center text-white shadow-glow">
            <i class="fa-solid fa-boxes-stacked text-sm"></i>
        </div>
        <div class="leading-tight">
            <p class="font-extrabold text-white tracking-tight">SIPINBAR</p>
            <p class="text-[11px] text-slate-400 font-medium tracking-wide">ADMIN PANEL</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Menu Utama</p>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-gauge w-4 text-center <?php echo e(request()->routeIs('admin.dashboard') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.peminjaman.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.peminjaman.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-right-left w-4 text-center <?php echo e(request()->routeIs('admin.peminjaman.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Verifikasi Peminjaman
        </a>
        <?php ($jumlahHilang = \App\Models\BarangHilang::where('status', 'belum_diganti')->count()); ?>
        <a href="<?php echo e(route('admin.hilang.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.hilang.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-box-open w-4 text-center <?php echo e(request()->routeIs('admin.hilang.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Barang Hilang
            <?php if($jumlahHilang > 0): ?><span class="ml-auto rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold px-2 py-0.5"><?php echo e($jumlahHilang); ?></span><?php endif; ?>
        </a>
        <a href="<?php echo e(route('admin.barang.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.barang.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-cubes w-4 text-center <?php echo e(request()->routeIs('admin.barang.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Data Barang
        </a>
        <a href="<?php echo e(route('admin.kategori.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.kategori.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-tags w-4 text-center <?php echo e(request()->routeIs('admin.kategori.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Kategori Barang
        </a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.users.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-users w-4 text-center <?php echo e(request()->routeIs('admin.users.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Data Pengguna
        </a>
        <a href="<?php echo e(route('admin.laporan.index')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('admin.laporan.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-file-lines w-4 text-center <?php echo e(request()->routeIs('admin.laporan.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Laporan & Rekap
        </a>

        <p class="px-3 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Akun</p>
        <a href="<?php echo e(route('profile.edit')); ?>" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs('profile.*') ? 'bg-white/5 text-cyan-300 ring-1 ring-cyan-400/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'); ?>">
            <i class="fa-solid fa-user-gear w-4 text-center <?php echo e(request()->routeIs('profile.*') ? 'text-cyan-400' : 'text-slate-500 group-hover:text-slate-300'); ?>"></i> Profil & Kata Sandi
        </a>
    </nav>

    <div class="p-3 border-t border-white/5">
        <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">
            <div class="h-9 w-9 shrink-0 rounded-full bg-gradient-to-br from-cyan-400 to-violet-500 flex items-center justify-center text-white text-sm font-bold">
                <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                <p class="text-xs text-slate-400">Admin / Sarpras</p>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                <?php echo csrf_field(); ?>
                <button title="Logout" class="h-8 w-8 inline-flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
<?php endif; ?>

<div class="<?php echo e(auth()->check() ? 'lg:pl-64' : ''); ?>">
    <?php if(auth()->guard()->check()): ?>
    <header class="sticky top-0 z-20 h-16 bg-base-850/80 backdrop-blur border-b border-white/5 flex items-center justify-end px-4 lg:px-8">
        <div class="flex items-center gap-3">
            <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-violet-500/10 px-3 py-1 text-xs font-semibold text-violet-300 ring-1 ring-violet-400/20">
                <i class="fa-solid fa-shield-halved text-[10px]"></i> Admin / Petugas Sarpras
            </span>
            <span class="text-sm font-semibold text-white"><?php echo e(auth()->user()->name); ?></span>
        </div>
    </header>
    <?php endif; ?>

    <main class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto">
        <?php if(session('success')): ?>
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
                <i class="fa-solid fa-circle-check mt-0.5"></i>
                <p class="flex-1"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm text-red-300">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <p class="flex-1"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="mb-5 rounded-xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm text-red-300">
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
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/layouts/admin.blade.php ENDPATH**/ ?>