<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::with('kategori')
            ->when($request->filled('kategori_barang_id'), fn ($q) => $q->where('kategori_barang_id', $request->kategori_barang_id))
            ->when($request->filled('q'), fn ($q) => $q->where('nama_barang', 'like', "%{$request->q}%"))
            ->when($request->boolean('tersedia'), fn ($q) => $q->where('stok_tersedia', '>', 0))
            ->orderBy('nama_barang')
            ->paginate(9)
            ->withQueryString();

        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();

        return view('siswa.katalog.index', compact('barang', 'kategoriList'));
    }

    public function show(Barang $barang)
    {
        return view('siswa.katalog.show', compact('barang'));
    }
}
