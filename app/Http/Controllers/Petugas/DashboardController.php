<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Support\ChartData;

class DashboardController extends Controller
{
    public function index()
    {
        $petugas = auth()->user();
        $id = $petugas->id;

        $kategori = $petugas->kategoriDiampu()->withCount('barang')->orderBy('nama_kategori')->get();

        $stats = [
            'perlu_serah' => Peminjaman::untukPetugas($id)->status('disetujui')->count(),
            'perlu_terima' => Peminjaman::untukPetugas($id)->status('pengembalian')->count(),
            'dipinjam' => Peminjaman::untukPetugas($id)->status('approved')->count(),
            'menunggu_admin' => Peminjaman::untukPetugas($id)->status('dicek_petugas')->count(),
        ];

        $tugas = Peminjaman::with(['siswa', 'barang'])
            ->untukPetugas($id)
            ->whereIn('status', ['disetujui', 'pengembalian'])
            ->oldest('updated_at')
            ->take(10)
            ->get();

        // ---- Data grafik (hanya kategori yang diampu petugas ini) ----
        $buat = fn () => Peminjaman::untukPetugas($id);

        $stokKategori = $petugas->kategoriDiampu()
            ->withSum('barang', 'stok_total')
            ->withSum('barang', 'stok_tersedia')
            ->orderBy('nama_kategori')
            ->get();

        $chart = [
            'harian' => [
                'labels' => ChartData::labelHari(7),
                'diserahkan' => ChartData::harian($buat, 'tanggal_diserahkan', 7),
                'diterima' => ChartData::harian($buat, 'tanggal_diterima_petugas', 7),
            ],
            'status' => ChartData::distribusiStatus($buat()),
            'stokKategori' => [
                'labels' => $stokKategori->pluck('nama_kategori')->all(),
                'tersedia' => $stokKategori->map(fn ($k) => (int) $k->barang_sum_stok_tersedia)->all(),
                'dipinjam' => $stokKategori->map(fn ($k) => max(0, (int) $k->barang_sum_stok_total - (int) $k->barang_sum_stok_tersedia))->all(),
            ],
        ];

        $kategoriIds = $kategori->pluck('id');
        $barangMenipis = Barang::whereIn('kategori_barang_id', $kategoriIds)
            ->where('stok_tersedia', '<=', 2)
            ->orderBy('stok_tersedia')
            ->take(6)
            ->get();

        // Agenda: peminjaman kategori saya yang jatuh tempo 7 hari ke depan
        $agenda = Peminjaman::untukPetugas($id)->with(['siswa', 'barang'])
            ->where('status', 'approved')
            ->whereBetween('tanggal_kembali_rencana', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->orderBy('tanggal_kembali_rencana')
            ->take(8)
            ->get();

        return view('petugas.dashboard.index', compact('kategori', 'stats', 'tugas', 'chart', 'barangMenipis', 'agenda'));
    }
}
