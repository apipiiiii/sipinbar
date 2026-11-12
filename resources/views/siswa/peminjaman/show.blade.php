@extends('layouts.user')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="page-title">
        Detail Peminjaman: {{ $peminjaman->kode_peminjaman }}
    </h1>
    <div class="flex items-center gap-2">
        <x-status-badge :color="$peminjaman->badgeColor()" :label="$peminjaman->labelStatus()" class="text-sm" />
        @if(in_array($peminjaman->status, ['disetujui', 'approved', 'pengembalian', 'dicek_petugas', 'selesai']))
            <button type="button" onclick="window.print()" class="btn btn-outline btn-sm no-print"><i class="fa-solid fa-print text-xs"></i> Cetak bukti</button>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-[minmax(0,1fr)_320px]">
<div class="card p-5 sm:p-6">
    <dl class="divide-y divide-slate-100 text-sm">
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Barang</dt><dd class="text-slate-800 font-medium text-right">{{ $peminjaman->barang->nama_barang }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Jumlah</dt><dd class="text-slate-800 font-medium text-right">{{ $peminjaman->jumlah }} unit</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Pinjam</dt><dd class="text-slate-800 font-medium text-right">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Rencana Kembali</dt><dd class="text-slate-800 font-medium text-right">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Keperluan</dt><dd class="text-slate-800 text-right">{{ $peminjaman->keperluan }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Petugas Kategori</dt><dd class="text-slate-800 text-right">{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? '-' }} <span class="text-slate-400">({{ optional($peminjaman->barang->kategori)->nama_kategori }})</span></dd></div>
        @if($peminjaman->status === 'pending')
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Status</dt><dd class="text-slate-800 text-right">Pengajuan Anda sedang menunggu verifikasi admin.</dd></div>
        @endif
        @if($peminjaman->petugasPenyerah)
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diserahkan Oleh</dt><dd class="text-slate-800 text-right">{{ $peminjaman->petugasPenyerah->name }} pada {{ optional($peminjaman->tanggal_diserahkan)->format('d/m/Y H:i') }}</dd></div>
        @endif
        @if($peminjaman->status === 'rejected')
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Alasan Ditolak</dt><dd class="text-rose-600 text-right">{{ $peminjaman->catatan_admin }}</dd></div>
        @endif
        @if(in_array($peminjaman->status, ['disetujui', 'approved', 'pengembalian', 'dicek_petugas', 'selesai']))
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Catatan Admin</dt><dd class="text-slate-800 text-right">{{ $peminjaman->catatan_admin ?? '-' }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Diverifikasi Oleh</dt><dd class="text-slate-800 text-right">{{ $peminjaman->verifikator->name ?? '-' }}</dd></div>
        @endif
        @if(in_array($peminjaman->status, ['pengembalian', 'dicek_petugas', 'selesai']))
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Tanggal Dikembalikan</dt><dd class="text-slate-800 text-right">{{ optional($peminjaman->tanggal_kembali_aktual)->format('d F Y') }}</dd></div>
        <div class="flex justify-between gap-4 py-2.5"><dt class="text-slate-500 shrink-0">Kondisi Saat Kembali</dt><dd class="text-slate-800 text-right">{{ $peminjaman->kondisi_kembali ? ucfirst($peminjaman->kondisi_kembali) : 'Belum diperiksa petugas' }}</dd></div>
        @endif
    </dl>

    @if($peminjaman->status === 'disetujui')
    <div class="mt-5 rounded-lg border border-brand-200 bg-brand-50 p-4 text-sm text-brand-800 flex items-start gap-3">
        <i class="fa-solid fa-hand-holding-hand mt-0.5 text-brand-500"></i>
        <div>
            <div class="font-bold">Pengajuan disetujui admin</div>
            <div>Silakan ambil barang di petugas <b>{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? 'sarpras' }}</b>. Status akan berubah menjadi "Sedang Dipinjam" setelah petugas mengonfirmasi penyerahan.</div>
        </div>
    </div>
    @endif

    @if($peminjaman->status === 'pengembalian')
    <div class="mt-5 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800 flex items-start gap-3">
        <i class="fa-solid fa-hourglass-half mt-0.5 text-yellow-500"></i>
        <div>
            <div class="font-bold">Menunggu konfirmasi petugas</div>
            <div>Serahkan barang ke petugas <b>{{ optional(optional($peminjaman->barang->kategori)->petugas)->name ?? 'sarpras' }}</b>. Petugas akan memeriksa kondisi barang, lalu admin menyelesaikan pengembalian.</div>
        </div>
    </div>
    @endif

    @if($peminjaman->status === 'dicek_petugas')
    <div class="mt-5 rounded-lg border border-brand-200 bg-brand-50 p-4 text-sm text-brand-800 flex items-start gap-3">
        <i class="fa-solid fa-user-check mt-0.5 text-brand-500"></i>
        <div>
            <div class="font-bold">Barang sudah diterima petugas</div>
            <div>Petugas {{ optional($peminjaman->petugasPenerima)->name }} telah memeriksa barang (kondisi: {{ ucfirst($peminjaman->kondisi_kembali) }}). Tinggal menunggu konfirmasi akhir dari admin.</div>
        </div>
    </div>
    @endif

    @if($peminjaman->isTerlambat())
    <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-500"></i>
        <div>
            <div class="font-bold">Anda terlambat {{ $peminjaman->hariTerlambat() }} hari!</div>
            <div>Segera kembalikan barang ke petugas sarpras. Denda saat ini <b>{{ \App\Models\Peminjaman::rupiah($peminjaman->dendaSaatIni()) }}</b> ({{ \App\Models\Peminjaman::infoTarifDenda() }}).</div>
        </div>
    </div>
    @endif

    @if($peminjaman->status === 'hilang')
    <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 flex items-start gap-3">
        <i class="fa-solid fa-box-open mt-0.5 text-rose-500"></i>
        <div>
            <div class="font-bold">Barang dilaporkan hilang</div>
            <div>Anda wajib mengganti dengan barang baru yang sama ({{ $peminjaman->jumlah }} unit {{ $peminjaman->barang->nama_barang }}). Serahkan barang pengganti ke petugas sarpras.</div>
            @if($peminjaman->barangHilang)<div class="mt-1 text-rose-600">Dilaporkan: {{ $peminjaman->barangHilang->tanggal_hilang->format('d F Y') }} &mdash; {{ $peminjaman->barangHilang->keterangan }}</div>@endif
        </div>
    </div>
    @endif

    @if($peminjaman->status === 'diganti')
    <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 flex items-start gap-3">
        <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500"></i>
        <div>
            <div class="font-bold">Barang hilang sudah diganti</div>
            <div>Barang pengganti telah diterima petugas sarpras pada {{ optional($peminjaman->tanggal_kembali_aktual)->format('d F Y') }}.</div>
        </div>
    </div>
    @endif

    @if(in_array($peminjaman->status, ['selesai', 'hilang', 'diganti']) && (int) $peminjaman->denda_telat > 0)
    <div class="mt-5 rounded-lg border {{ $peminjaman->denda_lunas ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-yellow-200 bg-yellow-50 text-yellow-800' }} p-4 text-sm flex items-start gap-3">
        <i class="fa-solid fa-money-bill-wave mt-0.5"></i>
        <div>
            <div class="font-bold">Denda keterlambatan: {{ \App\Models\Peminjaman::rupiah((int) $peminjaman->denda_telat) }} ({{ $peminjaman->denda_lunas ? 'Lunas' : 'Belum Lunas' }})</div>
            <div>Terlambat {{ $peminjaman->hari_telat }} hari.@if(! $peminjaman->denda_lunas) Silakan bayar denda ke petugas sarpras.@endif</div>
        </div>
    </div>
    @endif

    @if($peminjaman->status === 'approved')
    <div class="mt-5 rounded-lg border border-slate-200 p-4">
        <h3 class="text-sm font-bold text-slate-800 mb-1 flex items-center gap-2"><i class="fa-solid fa-rotate-left text-brand-500"></i> Kembalikan Barang</h3>
        <p class="text-xs text-slate-500 mb-3">Klik tombol di bawah saat Anda menyerahkan barang kembali. Pengembalian harus dikonfirmasi petugas, lalu admin.</p>
        <form method="POST" action="{{ route('siswa.peminjaman.kembalikan', $peminjaman) }}"
              onsubmit="return confirm('Ajukan pengembalian {{ $peminjaman->barang->nama_barang }} ({{ $peminjaman->jumlah }} unit)? Pastikan barang diserahkan ke petugas.')">
            @csrf
            <textarea name="catatan_siswa" rows="2" placeholder="Catatan untuk petugas (opsional), misalnya kondisi barang."
                      class="input mb-2">{{ old('catatan_siswa') }}</textarea>
            <button class="btn btn-primary btn-sm"><i class="fa-solid fa-rotate-left"></i> Kembalikan Barang</button>
        </form>
    </div>

    <div class="mt-5 rounded-lg border border-slate-200 p-4">
        <h3 class="text-sm font-bold text-slate-800 mb-1 flex items-center gap-2"><i class="fa-solid fa-box-open text-rose-500"></i> Barang Hilang?</h3>
        <p class="text-xs text-slate-500 mb-3">Jika barang pinjaman hilang, laporkan di sini. Anda wajib menggantinya dengan barang baru yang sama.</p>
        <form method="POST" action="{{ route('siswa.peminjaman.hilang', $peminjaman) }}"
              onsubmit="return confirm('Laporkan {{ $peminjaman->barang->nama_barang }} ({{ $peminjaman->jumlah }} unit) hilang? Anda wajib menggantinya dengan barang baru.')">
            @csrf
            <textarea name="keterangan" rows="2" required placeholder="Ceritakan kronologi hilangnya barang (kapan & di mana)."
                      class="input mb-1">{{ old('keterangan') }}</textarea>
            @error('keterangan')<p class="text-xs text-rose-600 mb-2">{{ $message }}</p>@enderror
            <button class="btn btn-sm mt-2 bg-rose-600 text-white hover:bg-rose-700"><i class="fa-solid fa-triangle-exclamation"></i> Laporkan Barang Hilang</button>
        </form>
    </div>
    @endif

    <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-outline btn-sm mt-5">Kembali ke Riwayat</a>
</div>
<x-riwayat-proses :p="$peminjaman" />
</div>
@endsection
