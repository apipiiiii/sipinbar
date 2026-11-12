@extends('layouts.admin')
@section('title', 'Data Barang')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Data Barang</h1><p class="page-sub">Kelola inventaris dan stok barang sekolah.</p></div>
    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Barang
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-end">
        <div>
            <label class="label">Cari</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama / kode barang"
                   class="input">
        </div>
        <div>
            <label class="label">Kategori</label>
            <select name="kategori_barang_id"
                    class="input">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $k)
                    <option value="{{ $k->id }}" class="bg-white" @selected(request('kategori_barang_id')==$k->id)>{{ $k->nama_kategori }}</option>
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($barang as $b)
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800">{{ $b->kode_barang }}</td>
                    <td class="text-slate-800">{{ $b->nama_barang }}</td>
                    <td class="text-slate-500">{{ $b->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $b->stok_tersedia == 0 ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($b->stok_tersedia <= 2 ? 'bg-yellow-50 text-yellow-700 ring-yellow-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200') }}">
                            {{ $b->stok_tersedia }} / {{ $b->stok_total }}
                        </span>
                    </td>
                    <td class="text-slate-500">{{ ucfirst($b->kondisi) }}</td>
                    <td class="text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="{{ route('admin.barang.show', $b) }}" class="btn btn-outline btn-icon" title="Detail"><i class="fa-solid fa-eye text-xs"></i></a>
                            <a href="{{ route('admin.barang.edit', $b) }}" class="btn btn-outline btn-icon" title="Ubah"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.barang.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data barang.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $barang->links() }}</div>
</div>
@endsection
