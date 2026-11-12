@extends('layouts.admin')
@section('title', 'Data Barang Hilang')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Barang Hilang</h1><p class="page-sub">Catatan barang hilang dan status penggantiannya.</p></div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="card p-5 {{ $rekap['belum'] > 0 ? 'border-rose-300' : '' }}">
        <div class="kpi-label mb-1">Belum Diganti</div>
        <div class="text-3xl font-semibold {{ $rekap['belum'] > 0 ? 'text-rose-700' : 'text-slate-900' }}">{{ $rekap['belum'] }}</div>
        <div class="text-xs text-slate-500 mt-1">laporan &bull; {{ $rekap['belum_unit'] }} unit</div>
    </div>
    <div class="card p-5">
        <div class="kpi-label mb-1">Sudah Diganti</div>
        <div class="text-3xl font-semibold text-emerald-700">{{ $rekap['sudah'] }}</div>
        <div class="text-xs text-slate-500 mt-1">bisa dihapus dari daftar</div>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-500 flex items-start gap-2.5">
        <i class="fa-solid fa-circle-info mt-0.5"></i>
        <span>Siswa wajib mengganti dengan barang baru yang sama. Setelah barang pengganti diterima, klik <b class="text-slate-800">Sudah Diganti</b> (stok otomatis bertambah), lalu data boleh dihapus.</span>
    </div>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="label">Cari (kode / siswa / barang)</label>
            <input type="text" name="q" value="{{ request('q') }}"
                   class="input">
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="">Semua Status</option>
                <option value="belum_diganti" @selected(request('status')=='belum_diganti')>Belum Diganti</option>
                <option value="sudah_diganti" @selected(request('status')=='sudah_diganti')>Sudah Diganti</option>
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
                    <th>Kode Pinjam</th><th>Siswa</th><th>Barang</th><th>Jumlah</th><th>Tgl Lapor</th><th>Keterangan</th><th>Status</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($hilang as $h)
                <tr class="transition {{ $h->sudahDiganti() ? 'hover:bg-slate-50' : 'bg-rose-50 hover:bg-rose-100' }}">
                    <td class="font-medium text-slate-800">
                        <a href="{{ route('admin.peminjaman.show', $h->peminjaman_id) }}" class="hover:text-brand-800">{{ $h->peminjaman->kode_peminjaman }}</a>
                    </td>
                    <td class="text-slate-600">{{ $h->siswa->name }} @if($h->siswa->kelas)<span class="text-slate-500">({{ $h->siswa->kelas }})</span>@endif</td>
                    <td class="text-slate-600">{{ $h->barang->nama_barang }}</td>
                    <td class="text-slate-600">{{ $h->jumlah }}</td>
                    <td class="text-slate-500">{{ $h->tanggal_hilang->format('d/m/Y') }}</td>
                    <td class="text-slate-500 max-w-xs">{{ $h->keterangan }}</td>
                    <td>
                        @if($h->sudahDiganti())
                            <x-status-badge color="success" label="Sudah Diganti" />
                            <div class="text-xs text-slate-500 mt-1">{{ optional($h->tanggal_diganti)->format('d/m/Y') }}</div>
                        @else
                            <x-status-badge color="danger" label="Belum Diganti" />
                        @endif
                    </td>
                    <td class="text-right whitespace-nowrap">
                        @if(! $h->sudahDiganti())
                            <form method="POST" action="{{ route('admin.hilang.diganti', $h) }}" class="inline"
                                  onsubmit="return confirm('Barang pengganti sudah diterima? Stok {{ $h->barang->nama_barang }} akan bertambah {{ $h->jumlah }} unit.')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm bg-emerald-600 text-white hover:bg-emerald-700"><i class="fa-solid fa-check"></i> Sudah Diganti</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.hilang.destroy', $h) }}" class="inline"
                                  onsubmit="return confirm('Hapus data barang hilang ini dari daftar?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Tidak ada data barang hilang.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $hilang->links() }}</div>
</div>
@endsection
