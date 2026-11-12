<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::with('kategori')
            ->when($request->filled('kategori_barang_id'), fn ($q) => $q->where('kategori_barang_id', $request->kategori_barang_id))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('nama_barang', 'like', "%{$request->q}%")
                        ->orWhere('kode_barang', 'like', "%{$request->q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();

        return view('admin.barang.index', compact('barang', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();
        return view('admin.barang.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $validated['stok_tersedia'] = $validated['stok_total'];

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'peminjaman.siswa']);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();
        return view('admin.barang.edit', compact('barang', 'kategoriList'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $this->validated($request, $barang->id);

        $selisih = $validated['stok_total'] - $barang->stok_total;
        $validated['stok_tersedia'] = max(0, $barang->stok_tersedia + $selisih);

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->peminjaman()->whereIn('status', \App\Models\Peminjaman::STATUS_AKTIF)->exists()) {
            return back()->with('error', 'Barang tidak dapat dihapus karena masih ada transaksi aktif.');
        }

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return back()->with('success', 'Data barang berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'kategori_barang_id' => ['required', 'exists:kategori_barangs,id'],
            'kode_barang' => ['required', 'string', 'max:50', Rule::unique('barangs', 'kode_barang')->ignore($ignoreId)],
            'nama_barang' => ['required', 'string', 'max:255'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', Rule::in(['baik', 'rusak ringan', 'rusak berat'])],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
