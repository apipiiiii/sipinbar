<?php $__env->startSection('title', 'Detail Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-extrabold text-white flex items-center gap-2.5">
        <span class="h-9 w-9 rounded-xl bg-cyan-500/10 text-cyan-300 inline-flex items-center justify-center ring-1 ring-cyan-400/20"><i class="fa-solid fa-right-left"></i></span>
        Detail Peminjaman: <?php echo e($peminjaman->kode_peminjaman); ?>

    </h1>
    <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['color' => $peminjaman->badgeColor(),'label' => $peminjaman->labelStatus(),'dark' => true,'class' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($peminjaman->badgeColor()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($peminjaman->labelStatus()),'dark' => true,'class' => 'text-sm']); ?>
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

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-7">
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <h2 class="font-bold text-white text-sm mb-4">Informasi Pengajuan</h2>
            <dl class="divide-y divide-white/5 text-sm">
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Siswa</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->siswa->name); ?> <?php if($peminjaman->siswa->kelas): ?> (<?php echo e($peminjaman->siswa->kelas); ?>) <?php endif; ?></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Barang</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->barang->nama_barang); ?> <span class="text-slate-500">(<?php echo e($peminjaman->barang->kode_barang); ?>)</span></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Jumlah</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->jumlah); ?> unit</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Tanggal Pinjam</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->tanggal_pinjam->format('d F Y')); ?></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Rencana Kembali</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->tanggal_kembali_rencana->format('d F Y')); ?></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Keperluan</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->keperluan); ?></dd></div>
                <?php if($peminjaman->verifikator): ?>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Diverifikasi Oleh</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->verifikator->name); ?> pada <?php echo e(optional($peminjaman->tanggal_verifikasi)->format('d/m/Y H:i')); ?></dd></div>
                <?php endif; ?>
                <?php if($peminjaman->catatan_admin): ?>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Catatan Admin</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->catatan_admin); ?></dd></div>
                <?php endif; ?>
                <?php if($peminjaman->status === 'selesai'): ?>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Tanggal Kembali Aktual</dt><dd class="text-slate-200 text-right"><?php echo e(optional($peminjaman->tanggal_kembali_aktual)->format('d F Y')); ?></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Kondisi Saat Kembali</dt><dd class="text-slate-200 text-right"><?php echo e(ucfirst($peminjaman->kondisi_kembali)); ?></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Catatan Pengembalian</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->catatan_pengembalian ?? '-'); ?></dd></div>
                <?php endif; ?>
                <?php if($peminjaman->isTerlambat() || (int) $peminjaman->denda_telat > 0): ?>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Keterlambatan</dt><dd class="text-rose-300 font-semibold text-right"><?php echo e($peminjaman->hariTelatSaatIni()); ?> hari</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Denda</dt><dd class="text-right <?php echo e($peminjaman->denda_lunas ? 'text-emerald-300' : 'text-rose-300'); ?> font-semibold"><?php echo e(\App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni())); ?> <span class="text-xs font-medium">(<?php echo e($peminjaman->statusDenda()); ?>)</span></dd></div>
                <?php endif; ?>
                <?php if($peminjaman->barangHilang): ?>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-400 shrink-0">Laporan Hilang</dt><dd class="text-slate-200 text-right"><?php echo e($peminjaman->barangHilang->tanggal_hilang->format('d F Y')); ?> &mdash; <?php echo e($peminjaman->barangHilang->keterangan); ?></dd></div>
                <?php endif; ?>
            </dl>
            <a href="<?php echo e(route('admin.peminjaman.index')); ?>" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-white/10 px-3.5 py-2 text-xs font-semibold text-slate-300 hover:bg-white/5 transition">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="lg:col-span-5 space-y-5">
        <?php if($peminjaman->isTerlambat()): ?>
        <div class="rounded-2xl border border-rose-500/40 bg-rose-500/10 p-5 text-sm text-rose-200 flex items-start gap-3">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-300"></i>
            <div>
                <div class="font-bold text-rose-300">Terlambat <?php echo e($peminjaman->hariTerlambat()); ?> hari</div>
                <div>Denda saat ini <b><?php echo e(\App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni())); ?></b> (<?php echo e(\App\Models\Peminjaman::infoTarifDenda()); ?>). Denda dikunci saat pengembalian dicatat.</div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($peminjaman->status === 'hilang'): ?>
        <div class="rounded-2xl border border-rose-500/40 bg-rose-500/10 p-5 text-sm text-rose-200 flex items-start gap-3">
            <i class="fa-solid fa-box-open mt-0.5 text-rose-300"></i>
            <div>
                <div class="font-bold text-rose-300">Barang dilaporkan hilang</div>
                <div>Siswa wajib mengganti dengan barang baru. Tandai "sudah diganti" dari halaman Barang Hilang setelah barang pengganti diterima.</div>
                <a href="<?php echo e(route('admin.hilang.index')); ?>" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-300 hover:text-cyan-200">Buka Data Barang Hilang <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
            </div>
        </div>
        <?php endif; ?>

        <?php if(in_array($peminjaman->status, ['selesai', 'hilang', 'diganti']) && (int) $peminjaman->denda_telat > 0 && ! $peminjaman->denda_lunas): ?>
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <h2 class="font-bold text-amber-300 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-money-bill-wave"></i> Denda Keterlambatan</h2>
            <p class="text-sm text-slate-300 mb-3">Siswa terlambat <?php echo e($peminjaman->hari_telat); ?> hari, denda <b><?php echo e(\App\Models\Peminjaman::rupiah((int) $peminjaman->denda_telat)); ?></b> belum dibayar.</p>
            <form method="POST" action="<?php echo e(route('admin.peminjaman.lunas', $peminjaman)); ?>" onsubmit="return confirm('Tandai denda ini sudah dibayar lunas?')">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white transition"><i class="fa-solid fa-check"></i> Tandai Denda Lunas</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if($peminjaman->status === 'pending'): ?>
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <h2 class="font-bold text-cyan-300 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> Setujui Pengajuan</h2>
            <form method="POST" action="<?php echo e(route('admin.peminjaman.approve', $peminjaman)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Catatan (opsional)</label>
                <textarea name="catatan_admin" rows="2" placeholder="Contoh: Silakan ambil di ruang sarpras."
                          class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-400/10 outline-none transition mb-3"></textarea>
                <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-cyan-500 to-violet-500 hover:opacity-90 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition"
                        <?php if($peminjaman->barang->stok_tersedia < $peminjaman->jumlah): ?> disabled <?php endif; ?>>
                    <i class="fa-solid fa-check"></i> Setujui Peminjaman
                </button>
                <?php if($peminjaman->barang->stok_tersedia < $peminjaman->jumlah): ?>
                    <p class="text-xs text-rose-300 mt-2">Stok tersedia (<?php echo e($peminjaman->barang->stok_tersedia); ?>) tidak mencukupi jumlah pengajuan.</p>
                <?php endif; ?>
            </form>
        </div>

        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <h2 class="font-bold text-rose-300 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-xmark"></i> Tolak Pengajuan</h2>
            <form method="POST" action="<?php echo e(route('admin.peminjaman.reject', $peminjaman)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Alasan Penolakan (wajib)</label>
                <textarea name="catatan_admin" rows="2" required placeholder="Contoh: Barang sedang dalam perbaikan."
                          class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-rose-400 focus:ring-4 focus:ring-rose-400/10 outline-none transition mb-3"></textarea>
                <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-rose-400/30 text-rose-300 hover:bg-rose-500/10 px-4 py-2.5 text-sm font-semibold transition"><i class="fa-solid fa-xmark"></i> Tolak Peminjaman</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if($peminjaman->status === 'approved'): ?>
        <div class="rounded-2xl border border-white/5 bg-base-850/60 backdrop-blur shadow-card p-5 sm:p-6">
            <h2 class="font-bold text-emerald-300 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-box-open"></i> Proses Pengembalian Barang</h2>
            <form method="POST" action="<?php echo e(route('admin.peminjaman.kembali', $peminjaman)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kondisi Barang Saat Dikembalikan</label>
                <select name="kondisi_kembali" required class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 outline-none transition mb-3">
                    <option value="baik" class="bg-base-850">Baik</option>
                    <option value="rusak ringan" class="bg-base-850">Rusak Ringan</option>
                    <option value="rusak berat" class="bg-base-850">Rusak Berat</option>
                </select>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Catatan Pengembalian (opsional)</label>
                <textarea name="catatan_pengembalian" rows="2"
                          class="w-full rounded-xl border border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 outline-none transition mb-3"></textarea>
                <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-glow transition"><i class="fa-solid fa-rotate-left"></i> Catat Pengembalian</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if(in_array($peminjaman->status, ['rejected', 'selesai', 'diganti']) && ! ((int) $peminjaman->denda_telat > 0 && ! $peminjaman->denda_lunas)): ?>
        <div class="rounded-2xl border border-white/5 bg-white/5 p-4 text-sm text-slate-400 flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info mt-0.5"></i> Transaksi ini sudah final, tidak ada aksi lanjutan yang diperlukan.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL\sipinbar-laravel_neww\resources\views/admin/peminjaman/show.blade.php ENDPATH**/ ?>