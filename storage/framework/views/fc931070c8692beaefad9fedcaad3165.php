<!DOCTYPE html>
<html lang="id">
<head>
    <?php echo $__env->make('layouts.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="min-h-screen bg-slate-50">
<main class="mx-auto flex min-h-screen max-w-md flex-col items-center justify-center px-6 text-center">
    <span class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-brand-600 text-white"><i class="fa-solid fa-boxes-stacked"></i></span>
    <p class="text-sm font-semibold tracking-wider text-brand-700"><?php echo $__env->yieldContent('code'); ?></p>
    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900"><?php echo $__env->yieldContent('heading'); ?></h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-500"><?php echo $__env->yieldContent('message'); ?></p>
    <div class="mt-7 flex flex-wrap items-center justify-center gap-2">
        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary"><i class="fa-solid fa-house text-xs"></i> Ke beranda</a>
        <button type="button" onclick="history.length > 1 ? history.back() : (location.href='<?php echo e(url('/')); ?>')" class="btn btn-outline"><i class="fa-solid fa-arrow-left text-xs"></i> Kembali</button>
    </div>
    <p class="mt-10 text-xs text-slate-400">SIPINBAR &middot; SMK Negeri 5 Surakarta</p>
</main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/errors/layout.blade.php ENDPATH**/ ?>