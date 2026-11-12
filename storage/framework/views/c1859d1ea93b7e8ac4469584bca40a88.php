<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['agenda', 'url' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['agenda', 'url' => null]); ?>
<?php foreach (array_filter((['agenda', 'url' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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
            <h2 class="card-title">Jatuh tempo 7 hari ke depan</h2>
            <p class="text-xs text-slate-500">Barang yang harus kembali dalam waktu dekat</p>
        </div>
    </div>
    <?php if($agenda->isEmpty()): ?>
        <p class="px-5 py-9 text-center text-sm text-slate-400"><i class="fa-regular fa-calendar-check mb-2 block text-2xl"></i>Tidak ada yang jatuh tempo.</p>
    <?php else: ?>
        <ul class="divide-y divide-slate-100">
            <?php $__currentLoopData = $agenda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $tgl = $p->tanggal_kembali_rencana;
                    $hari = $tgl->isToday() ? 'Hari ini' : ($tgl->isTomorrow() ? 'Besok' : $tgl->translatedFormat('D, d M'));
                    $mendesak = $tgl->isToday() || $tgl->isTomorrow();
                ?>
                <li class="flex items-center gap-3 px-5 py-3">
                    <span class="inline-flex h-10 w-10 shrink-0 flex-col items-center justify-center rounded-lg <?php echo e($mendesak ? 'bg-yellow-50 text-yellow-800' : 'bg-slate-100 text-slate-600'); ?>">
                        <span class="text-sm font-semibold leading-none"><?php echo e($tgl->format('d')); ?></span>
                        <span class="text-[9px] font-medium uppercase leading-none mt-0.5"><?php echo e($tgl->translatedFormat('M')); ?></span>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-medium text-slate-900"><?php echo e($p->barang->nama_barang); ?></span>
                        <span class="block truncate text-xs text-slate-500"><?php echo e($p->siswa->name); ?></span>
                    </span>
                    <span class="whitespace-nowrap text-xs font-medium <?php echo e($mendesak ? 'text-yellow-700' : 'text-slate-500'); ?>"><?php echo e($hari); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/components/agenda-jatuh-tempo.blade.php ENDPATH**/ ?>