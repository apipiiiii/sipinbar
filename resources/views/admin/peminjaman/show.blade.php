@extends('layouts.admin')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="page-title">
        Detail Peminjaman: {{ $peminjaman->kode_peminjaman }}
    </h1>
    <x-status-badge :color="$peminjaman->badgeColor()" :label="$peminjaman->labelStatus()" class="text-sm" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-7">
        <div class="card p-5 sm:p-6">
            <h2 class="card-title mb-4">Informasi Pengajuan</h2>
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Siswa</dt><dd class="text-slate-800 text-right">{{ $peminjaman->siswa->name }} @if($peminjaman->siswa->kelas) ({{ $peminjaman->siswa->kelas }}) @endif</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Barang</dt><dd class="text-slate-800 text-right">{{ $peminjaman->barang->nama_barang }} <span class="text-slate-500">({{ $peminjaman->barang->kode_barang }})</span></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Jumlah</dt><dd class="text-slate-800 text-right">{{ $peminjaman->jumlah }} unit</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Pinjam</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Rencana Kembali</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keperluan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->keperluan }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Petugas Kategori</dt><dd class="text-slate-800 text-right">{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? '-' }} <span class="text-slate-500">({{ optional($peminjaman->barang->kategori)->nama_kategori }})</span></dd></div>
                @if($peminjaman->verifikator)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diverifikasi Oleh</dt><dd class="text-slate-800 text-right">{{ $peminjaman->verifikator->name }} pada {{ optional($peminjaman->tanggal_verifikasi)->format('d/m/Y H:i') }}</dd></div>
                @endif
                @if($peminjaman->catatan_admin)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Admin</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_admin }}</dd></div>
                @endif
                @if($peminjaman->petugasPenyerah)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diserahkan Petugas</dt><dd class="text-slate-800 text-right">{{ $peminjaman->petugasPenyerah->name }} pada {{ optional($peminjaman->tanggal_diserahkan)->format('d/m/Y H:i') }}@if($peminjaman->catatan_penyerahan)<div class="text-xs text-slate-500">{{ $peminjaman->catatan_penyerahan }}</div>@endif</dd></div>
                @endif
                @if($peminjaman->tanggal_pengembalian_diajukan)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Siswa Mengembalikan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_pengembalian_diajukan->format('d/m/Y H:i') }}@if($peminjaman->catatan_siswa)<div class="text-xs text-slate-500">{{ $peminjaman->catatan_siswa }}</div>@endif</dd></div>
                @endif
                @if($peminjaman->petugasPenerima)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diterima Petugas</dt><dd class="text-slate-800 text-right">{{ $peminjaman->petugasPenerima->name }} pada {{ optional($peminjaman->tanggal_diterima_petugas)->format('d/m/Y H:i') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kondisi (menurut petugas)</dt><dd class="text-slate-800 text-right">{{ ucfirst($peminjaman->kondisi_kembali) }}@if($peminjaman->catatan_petugas)<div class="text-xs text-slate-500">{{ $peminjaman->catatan_petugas }}</div>@endif</dd></div>
                @endif
                @if($peminjaman->status === 'selesai')
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Dikonfirmasi Admin</dt><dd class="text-slate-800 text-right">{{ optional($peminjaman->adminPengembalian)->name ?? '-' }} pada {{ optional($peminjaman->tanggal_konfirmasi_kembali)->format('d/m/Y H:i') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Kembali Aktual</dt><dd class="text-slate-800 text-right">{{ optional($peminjaman->tanggal_kembali_aktual)->format('d F Y') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kondisi Saat Kembali</dt><dd class="text-slate-800 text-right">{{ ucfirst($peminjaman->kondisi_kembali) }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Pengembalian</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_pengembalian ?? '-' }}</dd></div>
                @endif
                @if($peminjaman->isTerlambat() || (int) $peminjaman->denda_telat > 0)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keterlambatan</dt><dd class="text-rose-700 font-semibold text-right">{{ $peminjaman->hariTelatSaatIni() }} hari</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Denda</dt><dd class="text-right {{ $peminjaman->denda_lunas ? 'text-emerald-700' : 'text-rose-700' }} font-semibold">{{ \App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni()) }} <span class="text-xs font-medium">({{ $peminjaman->statusDenda() }})</span></dd></div>
                @endif
                @if($peminjaman->barangHilang)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Laporan Hilang</dt><dd class="text-slate-800 text-right">{{ $peminjaman->barangHilang->tanggal_hilang->format('d F Y') }} &mdash; {{ $peminjaman->barangHilang->keterangan }}</dd></div>
                @endif
            </dl>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline btn-sm mt-5">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="lg:col-span-5 space-y-5">
        @if($peminjaman->isTerlambat())
        <div class="rounded-2xl border border-rose-300 bg-rose-50 p-5 text-sm text-rose-800 flex items-start gap-3">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-700"></i>
            <div>
                <div class="font-bold text-rose-700">Terlambat {{ $peminjaman->hariTerlambat() }} hari</div>
                <div>Denda saat ini <b>{{ \App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni()) }}</b> ({{ \App\Models\Peminjaman::infoTarifDenda() }}). Denda dikunci saat siswa mengajukan pengembalian.</div>
            </div>
        </div>
        @endif

        @if($peminjaman->status === 'hilang')
        <div class="rounded-2xl border border-rose-300 bg-rose-50 p-5 text-sm text-rose-800 flex items-start gap-3">
            <i class="fa-solid fa-box-open mt-0.5 text-rose-700"></i>
            <div>
                <div class="font-bold text-rose-700">Barang dilaporkan hilang</div>
                <div>Siswa wajib mengganti dengan barang baru. Tandai "sudah diganti" dari halaman Barang Hilang setelah barang pengganti diterima.</div>
                <a href="{{ route('admin.hilang.index') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800">Buka Data Barang Hilang <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
            </div>
        </div>
        @endif

        @if(in_array($peminjaman->status, ['selesai', 'hilang', 'diganti']) && (int) $peminjaman->denda_telat > 0 && ! $peminjaman->denda_lunas)
        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-yellow-700 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-money-bill-wave"></i> Denda Keterlambatan</h2>
            <p class="text-sm text-slate-600 mb-3">Siswa terlambat {{ $peminjaman->hari_telat }} hari, denda <b>{{ \App\Models\Peminjaman::rupiah((int) $peminjaman->denda_telat) }}</b> belum dibayar.</p>
            <form method="POST" action="{{ route('admin.peminjaman.lunas', $peminjaman) }}" onsubmit="return confirm('Tandai denda ini sudah dibayar lunas?')">
                @csrf @method('PATCH')
                <button class="btn w-full bg-yellow-700 text-white hover:bg-yellow-800 transition"><i class="fa-solid fa-check"></i> Tandai Denda Lunas</button>
            </form>
        </div>
        @endif

        @if($peminjaman->status === 'pending')
        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-brand-700 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-check"></i> Setujui Pengajuan</h2>
            <form method="POST" action="{{ route('admin.peminjaman.approve', $peminjaman) }}">
                @csrf @method('PATCH')
                @php($petugasKategori = optional($peminjaman->barang->kategori)->petugas)
                <p class="text-xs text-slate-500 mb-3">Setelah disetujui, barang diserahkan oleh petugas kategori: <b class="text-slate-800">{{ $petugasKategori->name ?? '(belum ada petugas)' }}</b>.</p>
                <label class="label">Catatan (opsional)</label>
                <textarea name="catatan_admin" rows="2" placeholder="Contoh: Silakan ambil di ruang sarpras."
                          class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 outline-none transition mb-3"></textarea>
                <button class="btn w-full bg-brand-600 text-white hover:bg-brand-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                        @if($peminjaman->barang->stok_tersedia < $peminjaman->jumlah || ! $petugasKategori) disabled @endif>
                    <i class="fa-solid fa-check"></i> Setujui Peminjaman
                </button>
                @if($peminjaman->barang->stok_tersedia < $peminjaman->jumlah)
                    <p class="text-xs text-rose-700 mt-2">Stok tersedia ({{ $peminjaman->barang->stok_tersedia }}) tidak mencukupi jumlah pengajuan.</p>
                @endif
                @if(! $petugasKategori)
                    <p class="text-xs text-rose-700 mt-2">Kategori ini belum memiliki petugas. <a href="{{ route('admin.kategori.index') }}" class="underline">Atur petugas di Kategori Barang</a> terlebih dahulu.</p>
                @endif
            </form>
        </div>

        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-rose-700 text-sm mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-xmark"></i> Tolak Pengajuan</h2>
            <form method="POST" action="{{ route('admin.peminjaman.reject', $peminjaman) }}">
                @csrf @method('PATCH')
                <label class="label">Alasan Penolakan (wajib)</label>
                <textarea name="catatan_admin" rows="2" required placeholder="Contoh: Barang sedang dalam perbaikan."
                          class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/15 outline-none transition mb-3"></textarea>
                <button class="btn btn-danger w-full"><i class="fa-solid fa-xmark"></i> Tolak Peminjaman</button>
            </form>
        </div>
        @endif

        @if($peminjaman->status === 'disetujui')
        <div class="rounded-2xl border border-brand-200 bg-brand-50 p-5 text-sm text-brand-800 flex items-start gap-3">
            <i class="fa-solid fa-hourglass-half mt-0.5 text-brand-700"></i>
            <div>
                <div class="font-bold text-brand-700">Menunggu penyerahan oleh petugas</div>
                <div>Petugas <b>{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? '-' }}</b> perlu mengonfirmasi barang sudah diserahkan ke siswa. Status berubah menjadi "Sedang Dipinjam" setelah itu.</div>
            </div>
        </div>
        @endif

        @if($peminjaman->status === 'approved')
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info mt-0.5 text-slate-500"></i>
            <span>Barang sedang dipinjam siswa. Pengembalian dimulai oleh siswa, lalu dikonfirmasi petugas, baru kemudian Anda konfirmasi di sini.</span>
        </div>
        @endif

        @if($peminjaman->status === 'pengembalian')
        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 text-sm text-yellow-800 flex items-start gap-3">
            <i class="fa-solid fa-hourglass-half mt-0.5 text-yellow-700"></i>
            <div>
                <div class="font-bold text-yellow-700">Menunggu konfirmasi petugas</div>
                <div>Siswa sudah mengembalikan barang. Petugas <b>{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? '-' }}</b> perlu memeriksa & menerima barang terlebih dahulu sebelum Anda dapat mengonfirmasi.</div>
            </div>
        </div>
        @endif

        @if($peminjaman->status === 'dicek_petugas')
        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-emerald-700 text-sm mb-1 flex items-center gap-2"><i class="fa-solid fa-box-open"></i> Konfirmasi Barang Sudah Dikembalikan</h2>
            <p class="text-xs text-slate-500 mb-3">Petugas {{ optional($peminjaman->petugasPenerima)->name }} sudah menerima barang dengan kondisi <b class="text-slate-800">{{ $peminjaman->kondisi_kembali }}</b>. Konfirmasi Anda menyelesaikan transaksi dan menambah stok kembali.</p>
            <form method="POST" action="{{ route('admin.peminjaman.kembali', $peminjaman) }}" onsubmit="return confirm('Konfirmasi barang sudah dikembalikan? Stok akan bertambah.')">
                @csrf @method('PATCH')
                <label class="label">Catatan Pengembalian (opsional)</label>
                <textarea name="catatan_pengembalian" rows="2"
                          class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 outline-none transition mb-3">{{ old('catatan_pengembalian') }}</textarea>
                <button class="btn w-full bg-emerald-600 text-white hover:bg-emerald-700 transition"><i class="fa-solid fa-rotate-left"></i> Konfirmasi Sudah Dikembalikan</button>
            </form>
        </div>
        @endif

        @if(in_array($peminjaman->status, ['rejected', 'selesai', 'diganti']) && ! ((int) $peminjaman->denda_telat > 0 && ! $peminjaman->denda_lunas))
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500 flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info mt-0.5"></i> Transaksi ini sudah final, tidak ada aksi lanjutan yang diperlukan.
        </div>
        @endif
    </div>
</div>
@endsection
