<?php $__env->startSection('title', 'Detail Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-ocean-50 text-ocean-600 inline-flex items-center justify-center"><i class="fa-solid fa-file-lines"></i></span>
        Detail Peminjaman: <?php echo e($peminjaman->kode_peminjaman); ?>

    </h1>
    <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $peminjaman->badgeColor(),'label' => $peminjaman->labelStatus(),'class' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($peminjaman->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($peminjaman->labelStatus()),'class' => 'text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-6 max-w-3xl">
    <dl class="divide-y divide-slate-100 text-sm">
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Barang</dt><dd class="text-slate-800 font-medium text-right"><?php echo e($peminjaman->barang->nama_barang); ?></dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Jumlah</dt><dd class="text-slate-800 font-medium text-right"><?php echo e($peminjaman->jumlah); ?> unit</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Pinjam</dt><dd class="text-slate-800 font-medium text-right"><?php echo e($peminjaman->tanggal_pinjam->format('d F Y')); ?></dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Rencana Kembali</dt><dd class="text-slate-800 font-medium text-right"><?php echo e($peminjaman->tanggal_kembali_rencana->format('d F Y')); ?></dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keperluan</dt><dd class="text-slate-800 text-right"><?php echo e($peminjaman->keperluan); ?></dd></div>
        <?php if($peminjaman->status === 'pending'): ?>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Status</dt><dd class="text-slate-800 text-right">Pengajuan Anda sedang menunggu verifikasi admin.</dd></div>
        <?php endif; ?>
        <?php if($peminjaman->status === 'rejected'): ?>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Alasan Ditolak</dt><dd class="text-rose-600 text-right"><?php echo e($peminjaman->catatan_admin); ?></dd></div>
        <?php endif; ?>
        <?php if($peminjaman->status === 'approved'): ?>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Admin</dt><dd class="text-slate-800 text-right"><?php echo e($peminjaman->catatan_admin ?? '-'); ?></dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diverifikasi Oleh</dt><dd class="text-slate-800 text-right"><?php echo e($peminjaman->verifikator->name ?? '-'); ?></dd></div>
        <?php endif; ?>
        <?php if($peminjaman->status === 'selesai'): ?>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Kembali Aktual</dt><dd class="text-slate-800 text-right"><?php echo e(optional($peminjaman->tanggal_kembali_aktual)->format('d F Y')); ?></dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kondisi Saat Kembali</dt><dd class="text-slate-800 text-right"><?php echo e(ucfirst($peminjaman->kondisi_kembali)); ?></dd></div>
        <?php endif; ?>
    </dl>

    <?php if($peminjaman->isTerlambat()): ?>
    <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-500"></i>
        <div>
            <div class="font-bold">Anda terlambat <?php echo e($peminjaman->hariTerlambat()); ?> hari!</div>
            <div>Segera kembalikan barang ke petugas sarpras. Denda saat ini <b><?php echo e(\App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni())); ?></b> (<?php echo e(\App\Models\Peminjaman::infoTarifDenda()); ?>).</div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($peminjaman->status === 'hilang'): ?>
    <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 flex items-start gap-3">
        <i class="fa-solid fa-box-open mt-0.5 text-rose-500"></i>
        <div>
            <div class="font-bold">Barang dilaporkan hilang</div>
            <div>Anda wajib mengganti dengan barang baru yang sama (<?php echo e($peminjaman->jumlah); ?> unit <?php echo e($peminjaman->barang->nama_barang); ?>). Serahkan barang pengganti ke petugas sarpras.</div>
            <?php if($peminjaman->barangHilang): ?><div class="mt-1 text-rose-600">Dilaporkan: <?php echo e($peminjaman->barangHilang->tanggal_hilang->format('d F Y')); ?> &mdash; <?php echo e($peminjaman->barangHilang->keterangan); ?></div><?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($peminjaman->status === 'diganti'): ?>
    <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 flex items-start gap-3">
        <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500"></i>
        <div>
            <div class="font-bold">Barang hilang sudah diganti</div>
            <div>Barang pengganti telah diterima petugas sarpras pada <?php echo e(optional($peminjaman->tanggal_kembali_aktual)->format('d F Y')); ?>.</div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(in_array($peminjaman->status, ['selesai', 'hilang', 'diganti']) && (int) $peminjaman->denda_telat > 0): ?>
    <div class="mt-5 rounded-xl border <?php echo e($peminjaman->denda_lunas ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-800'); ?> p-4 text-sm flex items-start gap-3">
        <i class="fa-solid fa-money-bill-wave mt-0.5"></i>
        <div>
            <div class="font-bold">Denda keterlambatan: <?php echo e(\App\Models\Peminjaman::rupiah((int) $peminjaman->denda_telat)); ?> (<?php echo e($peminjaman->denda_lunas ? 'Lunas' : 'Belum Lunas'); ?>)</div>
            <div>Terlambat <?php echo e($peminjaman->hari_telat); ?> hari.<?php if(! $peminjaman->denda_lunas): ?> Silakan bayar denda ke petugas sarpras.<?php endif; ?></div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($peminjaman->status === 'approved'): ?>
    <div class="mt-5 rounded-xl border border-slate-200 p-4">
        <h3 class="text-sm font-bold text-slate-800 mb-1 flex items-center gap-2"><i class="fa-solid fa-box-open text-rose-500"></i> Barang Hilang?</h3>
        <p class="text-xs text-slate-500 mb-3">Jika barang pinjaman hilang, laporkan di sini. Anda wajib menggantinya dengan barang baru yang sama.</p>
        <form method="POST" action="<?php echo e(route('siswa.peminjaman.hilang', $peminjaman)); ?>"
              onsubmit="return confirm('Laporkan <?php echo e($peminjaman->barang->nama_barang); ?> (<?php echo e($peminjaman->jumlah); ?> unit) hilang? Anda wajib menggantinya dengan barang baru.')">
            <?php echo csrf_field(); ?>
            <textarea name="keterangan" rows="2" required placeholder="Ceritakan kronologi hilangnya barang (kapan & di mana)."
                      class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-rose-400 focus:ring-4 focus:ring-rose-400/10 outline-none transition mb-1"><?php echo e(old('keterangan')); ?></textarea>
            <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-600 mb-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <button class="mt-2 inline-flex items-center gap-2 rounded-xl bg-rose-600 hover:bg-rose-700 px-4 py-2 text-xs font-semibold text-white transition"><i class="fa-solid fa-triangle-exclamation"></i> Laporkan Barang Hilang</button>
        </form>
    </div>
    <?php endif; ?>

    <a href="<?php echo e(route('siswa.peminjaman.index')); ?>" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Kembali ke Riwayat</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/siswa/peminjaman/show.blade.php ENDPATH**/ ?>