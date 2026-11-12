@extends('layouts.user')
@section('title', 'Riwayat Peminjaman')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Riwayat Peminjaman</h1><p class="page-sub">Semua pengajuan dan peminjaman yang pernah Anda lakukan.</p></div>
    <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Ajukan Peminjaman
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[minmax(0,320px)_auto] gap-3 items-end">
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="">Semua Status</option>
                @foreach(\App\Models\Peminjaman::daftarStatus() as $val=>$label)
                    <option value="{{ $val }}" @selected(request('status')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Kode</th><th>Barang</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Status</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($peminjaman as $p)
                <tr class="transition {{ $p->isTerlambat() ? 'bg-rose-50 hover:bg-rose-100/70' : 'hover:bg-slate-50/60' }}">
                    <td class="font-medium text-slate-800">{{ $p->kode_peminjaman }}</td>
                    <td class="text-slate-600">{{ $p->barang->nama_barang }}</td>
                    <td class="text-slate-600">{{ $p->jumlah }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td>
                        <x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" />
                        @if($p->dendaSaatIni() > 0)
                            <div class="text-xs mt-1 font-medium {{ $p->status === 'approved' || ! $p->denda_lunas ? 'text-rose-600' : 'text-emerald-600' }}">Denda {{ \App\Models\Peminjaman::rupiah($p->dendaSaatIni()) }} &bull; {{ $p->statusDenda() }}</div>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('siswa.peminjaman.show', $p) }}" class="btn btn-outline btn-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada riwayat peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-100">{{ $peminjaman->links() }}</div>
</div>
@endsection
