<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['color' => 'secondary', 'label' => '', 'dark' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['color' => 'secondary', 'label' => '', 'dark' => false]); ?>
<?php foreach (array_filter((['color' => 'secondary', 'label' => '', 'dark' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    // Satu gaya terang untuk semua role. Parameter "dark" dipertahankan agar pemanggilan lama tetap valid.
    $map = [
        'warning'   => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
        'primary'   => 'bg-brand-50 text-brand-700 ring-brand-600/20',
        'danger'    => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'success'   => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'secondary' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
        'dark'      => 'bg-slate-100 text-slate-700 ring-slate-500/30',
        'info'      => 'bg-sky-50 text-sky-700 ring-sky-600/20',
    ];
    $classes = $map[$color] ?? $map['secondary'];
?>
<span <?php echo e($attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset whitespace-nowrap $classes"])); ?>>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span><?php echo e($label); ?>

</span>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/components/status-badge.blade.php ENDPATH**/ ?>