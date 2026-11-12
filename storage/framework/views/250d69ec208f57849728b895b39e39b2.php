
<?php
    $pesanSukses = session('success');
    $rayakan = $pesanSukses && preg_match('/Pengajuan peminjaman berhasil|Pengembalian dicatat|Akun berhasil dibuat/', $pesanSukses);
?>
<?php if(session('success') || session('error')): ?>
<div id="sp-toasts" class="pointer-events-none fixed right-4 top-16 z-[60] flex w-[calc(100vw-2rem)] max-w-sm flex-col gap-2">
    <?php $__currentLoopData = ['success' => ['emerald', 'fa-circle-check'], 'error' => ['rose', 'fa-circle-exclamation']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipe => [$warna, $ikon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($tipe)): ?>
            <div role="status" data-toast <?php if($tipe === 'success' && $rayakan): ?> data-confetti <?php endif; ?> class="pointer-events-auto flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-3.5 shadow-pop">
                <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-<?php echo e($warna); ?>-50 text-<?php echo e($warna); ?>-600"><i class="fa-solid <?php echo e($ikon); ?> text-xs"></i></span>
                <p class="flex-1 pt-0.5 text-sm text-slate-700"><?php echo e(session($tipe)); ?></p>
                <button type="button" onclick="this.closest('[data-toast]').remove()" class="text-slate-400 hover:text-slate-600" aria-label="Tutup"><i class="fa-solid fa-xmark text-xs"></i></button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <p class="mb-1 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Terdapat kesalahan input:</p>
        <ul class="list-disc space-y-0.5 pl-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/flash.blade.php ENDPATH**/ ?>