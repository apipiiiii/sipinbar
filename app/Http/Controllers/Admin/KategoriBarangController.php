<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $kategori = KategoriBarang::with('petugas')->withCount('barang')
            ->when($request->filled('q'), fn ($q) => $q->where('nama_kategori', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create', ['petugasList' => $this->petugasList()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori_barangs,nama_kategori'],
            'keterangan' => ['nullable', 'string'],
            'petugas_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'petugas')],
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori barang berhasil ditambahkan.');
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('admin.kategori.edit', ['kategori' => $kategori, 'petugasList' => $this->petugasList()]);
    }

    public function update(Request $request, KategoriBarang $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori_barangs,nama_kategori,'.$kategori->id],
            'keterangan' => ['nullable', 'string'],
            'petugas_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'petugas')],
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori barang berhasil diperbarui.');
    }

    public function destroy(KategoriBarang $kategori)
    {
        if ($kategori->barang()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data barang.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori barang berhasil dihapus.');
    }

    /** Daftar akun petugas untuk dropdown penetapan petugas kategori. */
    private function petugasList()
    {
        return User::petugas()->orderBy('name')->get(['id', 'name', 'email']);
    }
}
