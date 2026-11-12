<?php $__env->startSection('title', 'Tambah Barang'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6"><h1 class="page-title">Tambah Barang</h1><p class="page-sub">Lengkapi data barang inventaris baru.</p></div>
<div class="card max-w-4xl p-5 sm:p-6">
    <form method="POST" action="<?php echo e(route('admin.barang.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.barang._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/admin/barang/create.blade.php ENDPATH**/ ?>