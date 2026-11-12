@extends('layouts.user')
@section('title', 'Ajukan Peminjaman')
@section('content')
<div class="mb-6"><h1 class="page-title">Pengajuan Peminjaman</h1><p class="page-sub">Isi formulir berikut untuk meminjam satu barang.</p></div>

@if($peminjamanAktif)
<div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
    <div class="font-semibold flex items-center gap-2 mb-1"><i class="fa-solid fa-circle-info text-yellow-600"></i> Anda hanya dapat meminjam 1 barang</div>
    Peminjaman <a href="{{ route('siswa.peminjaman.show', $peminjamanAktif) }}" class="font-semibold underline">{{ $peminjamanAktif->kode_peminjaman }}</a>
    ({{ $peminjamanAktif->barang->nama_barang ?? '-' }}) masih berjalan. Pengajuan baru bisa dibuat setelah peminjaman tersebut selesai.
</div>
@endif

<div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-[minmax(0,1fr)_320px]">
<div class="card p-5 sm:p-6">
    <form method="POST" action="{{ route('siswa.peminjaman.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="label">Pilih Barang</label>
                <select name="barang_id" required class="input">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangList as $b)
                        <option value="{{ $b->id }}" @selected(old('barang_id', $barangDipilih->id ?? null) == $b->id)>
                            {{ $b->nama_barang }} (Stok tersedia: {{ $b->stok_tersedia }})
                        </option>
                    @endforeach
                </select>
                @if($barangList->isEmpty())
                    <p class="text-xs text-rose-600 mt-1.5">Saat ini tidak ada barang dengan stok tersedia.</p>
                @endif
            </div>
            <div>
                <label class="label">Jumlah</label>
                <input type="text" value="1 unit (maksimal 1 barang)" readonly
                       class="input cursor-not-allowed bg-slate-50 text-slate-500" disabled>
            </div>
            <div>
                <label class="label">Tanggal Pinjam</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required
                       class="input">
            </div>
            <div>
                <label class="label">Rencana Tanggal Kembali</label>
                <input type="date" id="tanggal_kembali_rencana" readonly tabindex="-1"
                       class="input cursor-not-allowed bg-slate-50 text-slate-500" disabled>
                <p class="text-xs text-slate-400 mt-1.5">Otomatis {{ $lamaPinjam }} hari setelah tanggal pinjam.</p>
            </div>
            <div class="md:col-span-2">
                <label class="label">Keperluan Peminjaman</label>
                <textarea name="keperluan" rows="3" required placeholder="Jelaskan keperluan peminjaman barang..."
                          class="input">{{ old('keperluan') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex items-center gap-3">
            <button @disabled($peminjamanAktif) class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan</button>
            <a href="{{ route('siswa.katalog.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
<aside class="card h-fit">
    <div class="card-head"><h2 class="card-title">Ketentuan peminjaman</h2></div>
    <ul class="space-y-3.5 p-5 text-sm text-slate-600">
        <li class="flex gap-3"><i class="fa-solid fa-box mt-0.5 w-4 text-center text-brand-600"></i><span>Setiap siswa hanya dapat meminjam <b class="font-medium text-slate-800">1 barang</b> dalam satu waktu.</span></li>
        <li class="flex gap-3"><i class="fa-regular fa-calendar-check mt-0.5 w-4 text-center text-brand-600"></i><span>Barang harus dikembalikan <b class="font-medium text-slate-800">{{ $lamaPinjam }} hari</b> setelah tanggal pinjam.</span></li>
        <li class="flex gap-3"><i class="fa-solid fa-money-bill-wave mt-0.5 w-4 text-center text-brand-600"></i><span>Keterlambatan dikenai denda: {{ \App\Models\Peminjaman::infoTarifDenda() }}.</span></li>
        <li class="flex gap-3"><i class="fa-solid fa-hand-holding-hand mt-0.5 w-4 text-center text-brand-600"></i><span>Setelah disetujui admin, ambil barang langsung ke petugas sarpras.</span></li>
    </ul>
</aside>
</div>
@push('scripts')
<script>
    (function () {
        var lama = {{ (int) $lamaPinjam }};
        var pinjam = document.getElementById('tanggal_pinjam');
        var kembali = document.getElementById('tanggal_kembali_rencana');
        function hitung() {
            if (!pinjam.value) { kembali.value = ''; return; }
            var p = pinjam.value.split('-');
            var d = new Date(Date.UTC(+p[0], +p[1] - 1, +p[2] + lama));
            kembali.value = d.toISOString().slice(0, 10);
        }
        pinjam.addEventListener('input', hitung);
        hitung();
    })();
</script>
@endpush
@endsection
