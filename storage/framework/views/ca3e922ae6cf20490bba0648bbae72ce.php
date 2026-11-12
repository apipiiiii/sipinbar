
<?php
    $jumlahNotif = count(\App\Support\Notifikasi::untuk(auth()->user()));
    $jam = (int) now()->format('G');
    $salam = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $judul = $title ?? ($salam.', '.($nama ?? ''));
?>
<section class="mb-6 rounded-xl bg-brand-700 text-white">
    <div class="flex flex-col gap-5 p-5 sm:p-6 md:flex-row md:items-center md:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold tracking-tight sm:text-2xl"><?php echo e($judul); ?></h1>
            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-brand-100"><?php echo e($subtitle); ?></p>
            <?php if($jumlahNotif > 0): ?>
                <button type="button" data-dd-toggle="sp-notif-pop" class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white transition hover:bg-white/20">
                    <i class="fa-regular fa-bell"></i> <?php echo e($jumlahNotif); ?> notifikasi aktif
                </button>
            <?php endif; ?>
        </div>
        <?php if(!empty($actions)): ?>
        <div class="flex flex-wrap gap-2">
            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $url, $ikon, $utama]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($url); ?>" class="btn <?php echo e($utama ? 'bg-white text-brand-800 hover:bg-brand-50' : 'border border-white/25 text-white hover:bg-white/10'); ?>"><i class="fa-solid <?php echo e($ikon); ?> text-xs"></i> <?php echo e($label); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/hero.blade.php ENDPATH**/ ?>