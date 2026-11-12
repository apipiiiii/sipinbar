<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangHilang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangHilangController extends Controller
{
    public function index(Request $request)
    {
        $hilang = BarangHilang::with(['peminjaman', 'barang', 'siswa'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->whereHas('siswa', fn ($s) => $s->where('name', 'like', "%{$request->q}%"))
                        ->orWhereHas('barang', fn ($b) => $b->where('nama_barang', 'like', "%{$request->q}%"))
                        ->orWhereHas('peminjaman', fn ($p) => $p->where('kode_peminjaman', 'like', "%{$request->q}%"));
                });
            })
            ->orderByRaw("status = 'sudah_diganti'") // yang belum diganti tampil paling atas
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $rekap = [
            'belum' => BarangHilang::where('status', 'belum_diganti')->count(),
            'belum_unit' => (int) BarangHilang::where('status', 'belum_diganti')->sum('jumlah'),
            'sudah' => BarangHilang::where('status', 'sudah_diganti')->count(),
        ];

        return view('admin.hilang.index', compact('hilang', 'rekap'));
    }

    /** Barang pengganti sudah diterima: stok bertambah, peminjaman ditutup. */
    public function diganti(Request $request, BarangHilang $hilang)
    {
        if ($hilang->sudahDiganti()) {
            return back()->with('error', 'Barang hilang ini sudah ditandai diganti sebelumnya.');
        }

        $request->validate(['catatan_admin' => ['nullable', 'string', 'max:1000']]);

        DB::transaction(function () use ($request, $hilang) {
            $hilang->update([
                'status' => 'sudah_diganti',
                'tanggal_diganti' => now(),
                'catatan_admin' => $request->catatan_admin ?: 'Barang telah diganti dengan barang baru.',
            ]);

            $hilang->peminjaman->update([
                'status' => 'diganti',
                'tanggal_kembali_aktual' => now(),
                'catatan_pengembalian' => 'Barang hilang telah diganti dengan barang baru.',
            ]);

            // Barang pengganti masuk kembali ke stok tersedia
            $hilang->barang->increment('stok_tersedia', $hilang->jumlah);
        });

        return back()->with('success', 'Barang pengganti dicatat, stok telah diperbarui. Data hilang sekarang bisa dihapus.');
    }

    /** Hapus data hilang — hanya jika sudah diganti. */
    public function destroy(BarangHilang $hilang)
    {
        if (! $hilang->sudahDiganti()) {
            return back()->with('error', 'Data tidak bisa dihapus karena barang belum diganti.');
        }

        $hilang->delete();

        return back()->with('success', 'Data barang hilang berhasil dihapus.');
    }
}
