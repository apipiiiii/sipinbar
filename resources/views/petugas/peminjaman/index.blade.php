@extends('layouts.petugas')
@section('title', 'Konfirmasi Barang')
@section('content')
<div class="mb-6"><h1 class="page-title">Konfirmasi Barang</h1><p class="page-sub">Serahkan barang ke siswa dan terima pengembalian untuk kategori Anda.</p></div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="label">Cari (kode / nama siswa)</label>
            <input type="text" name="q" value="{{ request('q') }}"
                   class="input">
        </div>
        <div>
            <label class="label">Tampilkan</label>
            <select name="tampil" class="input">
                @foreach($filter as $val => $label)
                    <option value="{{ $val }}" @selected($tampil === $val)>{{ $label }}</option>
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
                    <th>Kode</th><th>Siswa</th><th>Barang</th><th>Jumlah</th><th>Rencana Kembali</th><th>Status</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($peminjaman as $p)
                <tr class="transition {{ $p->isTerlambat() ? 'bg-rose-50 hover:bg-rose-100' : 'hover:bg-slate-50' }}">
                    <td class="font-medium text-slate-800">{{ $p->kode_peminjaman }}</td>
                    <td class="text-slate-600">{{ $p->siswa->name }}@if($p->siswa->kelas)<div class="text-xs text-slate-500">{{ $p->siswa->kelas }}</div>@endif</td>
                    <td class="text-slate-600">{{ $p->barang->nama_barang }}<div class="text-xs text-slate-500">{{ optional($p->barang->kategori)->nama_kategori }}</div></td>
                    <td class="text-slate-600">{{ $p->jumlah }}</td>
                    <td class="text-slate-500">{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td><x-status-badge :color="$p->badgeColor()" :label="$p->labelStatus()" /></td>
                    <td class="text-right">
                        <a href="{{ route('petugas.peminjaman.show', $p) }}" class="btn btn-sm {{ in_array($p->status, ['disetujui', 'pengembalian']) ? 'btn-primary' : 'btn-outline' }}">{{ in_array($p->status, ['disetujui', 'pengembalian']) ? 'Proses' : 'Detail' }}</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Tidak ada data untuk ditampilkan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $peminjaman->links() }}</div>
</div>
@endsection
