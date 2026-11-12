<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIPINBAR</title>
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
                        ocean: { 400:'#5fb9fa',500:'#3a9df3',600:'#2378e8',700:'#1c60d3',800:'#1e4fac',900:'#1f4487' },
                        mint: { 400:'#42e19c',500:'#1cc987' },
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen font-sans bg-slate-50">
<div class="min-h-screen grid lg:grid-cols-2">

    
    <div class="hidden lg:flex relative flex-col justify-between overflow-hidden bg-gradient-to-br from-ocean-800 via-ocean-700 to-ocean-900 p-12 text-white">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-mint-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 h-72 w-72 rounded-full bg-ocean-400/20 blur-3xl"></div>

        <div class="relative z-10 flex items-center gap-2.5">
            <div class="h-10 w-10 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center ring-1 ring-white/20">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <span class="text-lg font-extrabold tracking-tight">SIPINBAR</span>
        </div>

        <div class="relative z-10 max-w-md">
            <h1 class="text-3xl font-extrabold leading-tight mb-4">Kelola peminjaman barang & inventaris sekolah dengan lebih mudah.</h1>
            <p class="text-ocean-100/90 text-sm leading-relaxed">Satu platform terpadu untuk siswa mengajukan peminjaman dan petugas sarpras memverifikasi, melacak stok, serta mencetak laporan secara real-time.</p>

            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white/10 backdrop-blur p-4 ring-1 ring-white/10">
                    <i class="fa-solid fa-bolt text-mint-300 mb-2"></i>
                    <p class="text-xs text-ocean-50/80">Proses cepat</p>
                </div>
                <div class="rounded-2xl bg-white/10 backdrop-blur p-4 ring-1 ring-white/10">
                    <i class="fa-solid fa-shield-halved text-mint-300 mb-2"></i>
                    <p class="text-xs text-ocean-50/80">Terverifikasi</p>
                </div>
                <div class="rounded-2xl bg-white/10 backdrop-blur p-4 ring-1 ring-white/10">
                    <i class="fa-solid fa-chart-line text-mint-300 mb-2"></i>
                    <p class="text-xs text-ocean-50/80">Laporan real-time</p>
                </div>
            </div>
        </div>

        <p class="relative z-10 text-xs text-ocean-100/60">&copy; <?php echo e(date('Y')); ?> SIPINBAR &mdash; SMK Negeri 5 Surakarta</p>
    </div>

    
    <div class="flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-sm">
            <div class="lg:hidden flex items-center gap-2.5 mb-8 justify-center">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-ocean-500 to-mint-500 flex items-center justify-center text-white">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">SIPINBAR</span>
            </div>

            <h2 class="text-2xl font-extrabold text-slate-900 mb-1">Selamat datang kembali</h2>
            <p class="text-sm text-slate-500 mb-7">Sistem Informasi Peminjaman Barang & Inventaris &mdash; SMK Negeri 5 Surakarta</p>

            <?php if(session('success')): ?>
                <div class="mb-5 rounded-xl border border-mint-200 bg-mint-50 px-4 py-3 text-sm text-mint-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               placeholder="nama@sipinbar.sch.id"
                               class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" name="password" required
                               placeholder="Masukkan kata sandi"
                               class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-ocean-500 focus:ring-4 focus:ring-ocean-500/10 outline-none transition">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-ocean-600 focus:ring-ocean-500/30">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-ocean-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-ocean-600/20 hover:bg-ocean-700 transition">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <div class="mt-6 rounded-xl bg-slate-50 border border-slate-100 px-4 py-3 text-xs text-slate-500 leading-relaxed">
                <p class="font-semibold text-slate-600 mb-1">Akun demo</p>
                Admin: admin@sipinbar.sch.id / admin123<br>
                Siswa: rafif.bari@siswa.sipinbar.sch.id / siswa123
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/auth/login.blade.php ENDPATH**/ ?>