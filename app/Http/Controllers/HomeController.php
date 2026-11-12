<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/** Halaman depan publik. Pengguna yang sudah login langsung diarahkan ke dashboard sesuai role. */
class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->dashboardRoute());
        }

        $stat = [
            'jenis' => Barang::count(),
            'tersedia' => (int) Barang::sum('stok_tersedia'),
            'selesai' => Peminjaman::whereIn('status', ['selesai', 'diganti'])->count(),
            'siswa' => User::where('role', 'siswa')->count(),
        ];

        $barang = Barang::with('kategori')->where('stok_tersedia', '>', 0)->orderByDesc('stok_tersedia')->take(6)->get();
        $kategori = KategoriBarang::withCount('barang')->orderBy('nama_kategori')->get();

        return view('home', compact('stat', 'barang', 'kategori'));
    }
}
