<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['feed']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['feed']); ?>
<?php foreach (array_filter((['feed']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div <?php echo e($attributes->merge(['class' => 'card'])); ?>>
    <div class="card-head">
        <div>
            <h2 class="card-title">Aktivitas terbaru</h2>
            <p class="text-xs text-slate-500">Jejak proses peminjaman</p>
        </div>
    </div>
    <?php if(count($feed) === 0): ?>
        <p class="px-5 py-10 text-center text-sm text-slate-400"><i class="fa-regular fa-clock mb-2 block text-2xl"></i>Belum ada aktivitas.</p>
    <?php else: ?>
        <ol class="px-5 py-4">
            <?php $__currentLoopData = $feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="relative flex gap-3 <?php echo e($loop->last ? '' : 'pb-4'); ?>">
                    <?php if (! ($loop->last)): ?><span class="absolute left-[13px] top-7 h-[calc(100%-14px)] w-px bg-slate-200"></span><?php endif; ?>
                    <span class="relative inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-<?php echo e($a['warna']); ?>-50 text-<?php echo e($a['warna']); ?>-600 ring-4 ring-white"><i class="fa-solid <?php echo e($a['ikon']); ?> text-[10px]"></i></span>
                    <div class="min-w-0 pt-0.5">
                        <a href="<?php echo e(route('admin.peminjaman.show', $a['peminjaman'])); ?>" class="block text-sm leading-snug text-slate-600 hover:text-slate-900">
                            <b class="font-medium text-slate-900"><?php echo e($a['pelaku']); ?></b> <?php echo e($a['kalimat']); ?>

                        </a>
                        <p class="mt-0.5 text-xs text-slate-400" title="<?php echo e($a['waktu']->format('d M Y H:i')); ?>"><?php echo e($a['waktu']->diffForHumans()); ?></p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/components/feed-aktivitas.blade.php ENDPATH**/ ?>