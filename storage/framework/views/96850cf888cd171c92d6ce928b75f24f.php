<div class="flex items-center gap-2.5">
    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?></span>
    <div class="hidden sm:block leading-tight min-w-0">
        <p class="text-sm font-medium text-slate-900 truncate max-w-[160px]"><?php echo e(auth()->user()->name); ?></p>
        <p class="text-[11px] text-slate-500"><?php echo e($roleLabel); ?></p>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/user-chip.blade.php ENDPATH**/ ?>