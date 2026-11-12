<?php $__env->startSection('title', 'Tambah Pengguna'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5 mb-6">
    <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-user-plus"></i></span>
    Tambah Pengguna Baru
</h1>
<div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
    <form method="POST" action="<?php echo e(route('admin.users.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.users._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/users/create.blade.php ENDPATH**/ ?>