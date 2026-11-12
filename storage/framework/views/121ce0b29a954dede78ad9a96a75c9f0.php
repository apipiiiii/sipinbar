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
    $map = [
        'warning'   => 'amber',
        'primary'   => 'blue',
        'danger'    => 'rose',
        'success'   => 'emerald',
        'secondary' => 'slate',
        'dark'      => 'violet',
        'info'      => 'cyan',
    ];
    $c = $map[$color] ?? 'slate';
    $classes = $dark
        ? "bg-{$c}-500/10 text-{$c}-300 ring-{$c}-400/30"
        : "bg-{$c}-50 text-{$c}-700 ring-{$c}-600/20";
?>
<span <?php echo e($attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset whitespace-nowrap $classes"])); ?>>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span><?php echo e($label); ?>

</span>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/components/status-badge.blade.php ENDPATH**/ ?>