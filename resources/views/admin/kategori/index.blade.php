@extends('layouts.admin')
@section('title', 'Kategori Barang')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Kategori Barang</h1><p class="page-sub">Kelompok barang beserta petugas penanggung jawabnya.</p></div>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="flex gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..."
               class="input flex-1">
        <button class="btn btn-outline"><i class="fa-solid fa-search"></i></button>
    </form>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead><tr>
                <th>Nama Kategori</th><th>Keterangan</th><th>Petugas</th><th>Jumlah Barang</th><th class="text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($kategori as $k)
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800">{{ $k->nama_kategori }}</td>
                    <td class="text-slate-500">{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        @if($k->petugas)
                            <span class="text-slate-800">{{ $k->petugas->name }}</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-yellow-50 text-yellow-700 px-2.5 py-1 text-xs font-semibold ring-1 ring-yellow-200">Belum ada petugas</span>
                        @endif
                    </td>
                    <td><span class="inline-flex items-center rounded-full bg-slate-50 text-slate-600 px-2.5 py-1 text-xs font-semibold ring-1 ring-slate-200">{{ $k->barang_count }}</span></td>
                    <td class="text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-outline btn-icon" title="Ubah"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data kategori.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $kategori->links() }}</div>
</div>
@endsection
