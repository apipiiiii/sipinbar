<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\BarangHilang;
use App\Models\Peminjaman;
use App\Models\User;
use App\Support\AktivitasFeed;
use App\Support\ChartData;

class DashboardController extends Controller
{
    public function index()
    {
        $terlambatList = Peminjaman::with(['siswa', 'barang'])
            ->terlambat()
            ->orderBy('tanggal_kembali_rencana')
            ->get();

        $stats = [
            // Barang
            'total_barang' => Barang::count(),                                  // jumlah jenis barang
            'total_stok' => (int) Barang::sum('stok_total'),                    // total unit dimiliki
            'stok_tersedia' => (int) Barang::sum('stok_tersedia'),              // unit yang ada di gudang

            // Sedang dipinjam = barang sudah diserahkan petugas & belum dikonfirmasi kembali oleh admin
            // (approved + sedang proses pengembalian oleh siswa/petugas)
            'dipinjam' => (int) Peminjaman::whereIn('status', ['approved', 'pengembalian', 'dicek_petugas'])->sum('jumlah'),  // unit
            'dipinjam_transaksi' => Peminjaman::whereIn('status', ['approved', 'pengembalian', 'dicek_petugas'])->count(),    // transaksi

            // Sudah dikembalikan = peminjaman berstatus "selesai"
            'dikembalikan' => (int) Peminjaman::status('selesai')->sum('jumlah'),
            'dikembalikan_transaksi' => Peminjaman::status('selesai')->count(),

            // Terlambat & denda
            'terlambat' => $terlambatList->count(),
            'denda_berjalan' => (int) $terlambatList->sum(fn ($p) => $p->dendaSaatIni()),
            'denda_belum_lunas' => (int) Peminjaman::whereIn('status', ['pengembalian', 'dicek_petugas', 'selesai', 'hilang', 'diganti'])
                ->where('denda_telat', '>', 0)
                ->where('denda_lunas', false)
                ->sum('denda_telat'),

            // Barang hilang yang belum diganti
            'hilang' => (int) BarangHilang::where('status', 'belum_diganti')->sum('jumlah'),
            'hilang_kasus' => BarangHilang::where('status', 'belum_diganti')->count(),

            'pending' => Peminjaman::status('pending')->count(),
            'konfirmasi_kembali' => Peminjaman::status('dicek_petugas')->count(), // menunggu konfirmasi final admin
            'selesai_bulan_ini' => Peminjaman::status('selesai')
                ->whereMonth('tanggal_kembali_aktual', now()->month)
                ->whereYear('tanggal_kembali_aktual', now()->year)
                ->count(),
            'total_siswa' => User::siswa()->count(),
        ];

        $peminjamanTerbaru = Peminjaman::with(['siswa', 'barang'])
            ->latest()
            ->take(8)
            ->get();

        // Stok menipis: sisa tersedia <= 2 unit (sama dengan aturan "Menipis" di model Barang)
        $barangMenipis = Barang::where('stok_tersedia', '<=', 2)
            ->orderBy('stok_tersedia')
            ->take(5)
            ->get();

        // ---- Data grafik (semua dari database) ----
        $topBarang = Barang::withCount('peminjaman')
            ->whereHas('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        $kategoriStok = KategoriBarang::withSum('barang', 'stok_total')
            ->withSum('barang', 'stok_tersedia')
            ->orderBy('nama_kategori')
            ->get();

        $chart = [
            'tren' => ChartData::trenBulanan(fn () => Peminjaman::query(), 6),
            'status' => ChartData::distribusiStatus(Peminjaman::query()),
            'topBarang' => [
                'labels' => $topBarang->pluck('nama_barang')->all(),
                'data' => $topBarang->pluck('peminjaman_count')->map(fn ($n) => (int) $n)->all(),
            ],
            'stokKategori' => [
                'labels' => $kategoriStok->pluck('nama_kategori')->all(),
                'tersedia' => $kategoriStok->map(fn ($k) => (int) $k->barang_sum_stok_tersedia)->all(),
                'dipinjam' => $kategoriStok->map(fn ($k) => max(0, (int) $k->barang_sum_stok_total - (int) $k->barang_sum_stok_tersedia))->all(),
            ],
        ];

        // Agenda: peminjaman yang jatuh tempo 7 hari ke depan
        $agenda = Peminjaman::with(['siswa', 'barang'])
            ->where('status', 'approved')
            ->whereBetween('tanggal_kembali_rencana', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->orderBy('tanggal_kembali_rencana')
            ->take(8)
            ->get();

        $feed = AktivitasFeed::terbaru(7);

        return view('admin.dashboard.index', compact('stats', 'peminjamanTerbaru', 'barangMenipis', 'terlambatList', 'chart', 'agenda', 'feed'));
    }
}
