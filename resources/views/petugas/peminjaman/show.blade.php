@extends('layouts.petugas')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="page-title">
        {{ $peminjaman->kode_peminjaman }}
    </h1>
    <x-status-badge :color="$peminjaman->badgeColor()" :label="$peminjaman->labelStatus()" class="text-sm" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
    <div class="lg:col-span-7">
        <div class="card p-5 sm:p-6">
            <h2 class="card-title mb-4">Informasi Peminjaman</h2>
            <dl class="divide-y divide-slate-100 text-sm">
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Siswa</dt><dd class="text-slate-800 text-right">{{ $peminjaman->siswa->name }} @if($peminjaman->siswa->kelas) ({{ $peminjaman->siswa->kelas }}) @endif</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Barang</dt><dd class="text-slate-800 text-right">{{ $peminjaman->barang->nama_barang }} <span class="text-slate-500">({{ $peminjaman->barang->kode_barang }})</span></dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kategori</dt><dd class="text-slate-800 text-right">{{ optional($peminjaman->barang->kategori)->nama_kategori }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Jumlah</dt><dd class="text-slate-800 text-right">{{ $peminjaman->jumlah }} unit</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Pinjam</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Rencana Kembali</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keperluan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->keperluan }}</dd></div>
                @if($peminjaman->verifikator)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Disetujui Admin</dt><dd class="text-slate-800 text-right">{{ $peminjaman->verifikator->name }} pada {{ optional($peminjaman->tanggal_verifikasi)->format('d/m/Y H:i') }}</dd></div>
                @endif
                @if($peminjaman->catatan_admin)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Admin</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_admin }}</dd></div>
                @endif
                @if($peminjaman->petugasPenyerah)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diserahkan Oleh</dt><dd class="text-slate-800 text-right">{{ $peminjaman->petugasPenyerah->name }} pada {{ optional($peminjaman->tanggal_diserahkan)->format('d/m/Y H:i') }}</dd></div>
                @endif
                @if($peminjaman->catatan_penyerahan)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Penyerahan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_penyerahan }}</dd></div>
                @endif
                @if($peminjaman->tanggal_pengembalian_diajukan)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Siswa Mengembalikan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->tanggal_pengembalian_diajukan->format('d/m/Y H:i') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Siswa</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_siswa ?? '-' }}</dd></div>
                @endif
                @if($peminjaman->petugasPenerima)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diterima Oleh</dt><dd class="text-slate-800 text-right">{{ $peminjaman->petugasPenerima->name }} pada {{ optional($peminjaman->tanggal_diterima_petugas)->format('d/m/Y H:i') }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kondisi Saat Kembali</dt><dd class="text-slate-800 text-right">{{ ucfirst($peminjaman->kondisi_kembali) }}</dd></div>
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Petugas</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_petugas ?? '-' }}</dd></div>
                @endif
                @if($peminjaman->isTerlambat() || (int) $peminjaman->denda_telat > 0)
                <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keterlambatan</dt><dd class="text-rose-700 font-semibold text-right">{{ $peminjaman->hariTelatSaatIni() }} hari</dd></div>
                @endif
            </dl>
            <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-outline btn-sm mt-5">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="lg:col-span-5 space-y-5">
        @if($peminjaman->isTerlambat())
        <div class="rounded-2xl border border-rose-300 bg-rose-50 p-5 text-sm text-rose-800 flex items-start gap-3">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-700"></i>
            <div><div class="font-bold text-rose-700">Terlambat {{ $peminjaman->hariTerlambat() }} hari</div><div>Ingatkan siswa untuk segera mengembalikan barang.</div></div>
        </div>
        @endif

        @if($peminjaman->status === 'disetujui')
        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-brand-700 text-sm mb-1 flex items-center gap-2"><i class="fa-solid fa-hand-holding-hand"></i> Konfirmasi Penyerahan Barang</h2>
            <p class="text-xs text-slate-500 mb-3">Admin sudah menyetujui. Serahkan <b class="text-slate-800">{{ $peminjaman->jumlah }} unit {{ $peminjaman->barang->nama_barang }}</b> kepada {{ $peminjaman->siswa->name }}, lalu konfirmasi di bawah.</p>
            <form method="POST" action="{{ route('petugas.peminjaman.serahkan', $peminjaman) }}" onsubmit="return confirm('Konfirmasi barang sudah diserahkan ke siswa?')">
                @csrf @method('PATCH')
                <label class="label">Catatan (opsional)</label>
                <textarea name="catatan_penyerahan" rows="2" placeholder="Contoh: Kondisi barang baik, lengkap dengan aksesori."
                          class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 outline-none transition mb-3"></textarea>
                <button class="btn w-full bg-brand-600 text-white hover:bg-brand-700 transition"><i class="fa-solid fa-check"></i> Barang Sudah Diserahkan</button>
            </form>
        </div>
        @endif

        @if($peminjaman->status === 'pengembalian')
        <div class="card p-5 sm:p-6">
            <h2 class="font-bold text-emerald-700 text-sm mb-1 flex items-center gap-2"><i class="fa-solid fa-rotate-left"></i> Konfirmasi Penerimaan Barang</h2>
            <p class="text-xs text-slate-500 mb-3">Siswa menyatakan sudah mengembalikan barang. Periksa fisik barang, catat kondisinya, lalu konfirmasi. Setelah itu admin yang menyelesaikan pengembalian.</p>
            <form method="POST" action="{{ route('petugas.peminjaman.terima', $peminjaman) }}" onsubmit="return confirm('Konfirmasi barang sudah diterima dari siswa?')">
                @csrf @method('PATCH')
                <label class="label">Kondisi Barang Saat Dikembalikan</label>
                <select name="kondisi_kembali" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 outline-none transition mb-3">
                    @foreach(['baik' => 'Baik', 'rusak ringan' => 'Rusak Ringan', 'rusak berat' => 'Rusak Berat'] as $v => $l)
                        <option value="{{ $v }}" @selected(old('kondisi_kembali') === $v)>{{ $l }}</option>
                    @endforeach
                </select>
                <label class="label">Catatan Petugas (opsional)</label>
                <textarea name="catatan_petugas" rows="2"
                          class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 outline-none transition mb-3">{{ old('catatan_petugas') }}</textarea>
                <button class="btn w-full bg-emerald-600 text-white hover:bg-emerald-700 transition"><i class="fa-solid fa-check"></i> Barang Sudah Diterima</button>
            </form>
        </div>
        @endif

        @if(! in_array($peminjaman->status, ['disetujui', 'pengembalian']))
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500 flex items-start gap-2.5">
            <i class="fa-solid fa-circle-info mt-0.5"></i>
            <span>
                @if($peminjaman->status === 'approved') Barang sedang dipinjam siswa. Tidak ada tindakan sampai siswa mengajukan pengembalian.
                @elseif($peminjaman->status === 'dicek_petugas') Konfirmasi Anda sudah tercatat. Menunggu konfirmasi akhir dari admin.
                @else Tidak ada tindakan yang diperlukan dari petugas.
                @endif
            </span>
        </div>
        @endif
    </div>
</div>
@endsection
