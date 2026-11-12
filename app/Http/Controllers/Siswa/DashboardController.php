<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Support\ChartData;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total_pengajuan' => Peminjaman::where('user_id', $userId)->count(),
            'pending' => Peminjaman::where('user_id', $userId)->status('pending')->count(),
            'approved' => Peminjaman::where('user_id', $userId)->whereIn('status', ['approved', 'pengembalian', 'dicek_petugas'])->count(),
            'selesai' => Peminjaman::where('user_id', $userId)->status('selesai')->count(),
            'barang_tersedia' => Barang::where('stok_tersedia', '>', 0)->count(),
        ];

        $terlambatList = Peminjaman::with('barang')
            ->where('user_id', $userId)
            ->terlambat()
            ->orderBy('tanggal_kembali_rencana')
            ->get();

        $hilangList = Peminjaman::with('barang')
            ->where('user_id', $userId)
            ->status('hilang')
            ->get();

        $stats['terlambat'] = $terlambatList->count();
        $stats['denda_berjalan'] = (int) $terlambatList->sum(fn ($p) => $p->dendaSaatIni());
        $stats['denda_belum_lunas'] = (int) Peminjaman::where('user_id', $userId)
            ->whereIn('status', ['pengembalian', 'dicek_petugas', 'selesai', 'hilang', 'diganti'])
            ->where('denda_telat', '>', 0)
            ->where('denda_lunas', false)
            ->sum('denda_telat');

        $riwayatTerbaru = Peminjaman::with('barang')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Peminjaman yang sedang berjalan (maksimal 1 karena siswa hanya boleh meminjam 1 barang)
        $aktif = Peminjaman::with('barang')
            ->where('user_id', $userId)
            ->whereIn('status', Peminjaman::STATUS_AKTIF)
            ->latest()
            ->first();

        // ---- Data grafik (hanya milik siswa yang login) ----
        $chart = [
            'tren' => ChartData::trenBulanan(fn () => Peminjaman::where('user_id', $userId), 6),
            'status' => ChartData::distribusiStatus(Peminjaman::where('user_id', $userId)),
        ];

        return view('siswa.dashboard.index', compact('stats', 'riwayatTerbaru', 'terlambatList', 'hilangList', 'aktif', 'chart'));
    }
}
