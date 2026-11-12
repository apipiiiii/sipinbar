<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Penyedia data grafik dashboard. Semua angka dihitung langsung dari database
 * (tidak ada data contoh); class ini hanya merangkum hasil query agar siap dipakai Chart.js.
 */
class ChartData
{
    public const LABEL_STATUS = [
        'pending' => 'Menunggu verifikasi',
        'disetujui' => 'Menunggu penyerahan',
        'approved' => 'Sedang dipinjam',
        'pengembalian' => 'Pengembalian ke petugas',
        'dicek_petugas' => 'Konfirmasi admin',
        'selesai' => 'Selesai',
        'rejected' => 'Ditolak',
        'hilang' => 'Hilang',
        'diganti' => 'Sudah diganti',
    ];

    public const WARNA_STATUS = [
        'pending' => '#CA8A04',
        'disetujui' => '#0284C7',
        'approved' => 'rgb(var(--b600))',
        'pengembalian' => '#E8A33D',
        'dicek_petugas' => '#78716C',
        'selesai' => '#059669',
        'rejected' => '#E11D48',
        'hilang' => '#9F1239',
        'diganti' => '#34D399',
    ];

    /** Jumlah transaksi per status dari query peminjaman yang diberikan. */
    public static function distribusiStatus($query): array
    {
        $rows = (clone $query)->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        $keys = array_values(array_filter(array_keys(self::LABEL_STATUS), fn ($k) => ($rows[$k] ?? 0) > 0));

        return [
            'labels' => array_map(fn ($k) => self::LABEL_STATUS[$k], $keys),
            'data' => array_map(fn ($k) => (int) $rows[$k], $keys),
            'colors' => array_map(fn ($k) => self::WARNA_STATUS[$k], $keys),
        ];
    }

    /**
     * Tren bulanan: jumlah pengajuan (created_at) dan jumlah selesai (tanggal_kembali_aktual).
     * $buat = fungsi yang mengembalikan query peminjaman baru (mis. sudah difilter per siswa).
     */
    public static function trenBulanan(callable $buat, int $bulan = 6): array
    {
        $labels = $pengajuan = $selesai = [];

        for ($i = $bulan - 1; $i >= 0; $i--) {
            $awal = Carbon::now()->startOfMonth()->subMonths($i);
            $akhir = $awal->copy()->endOfMonth();

            $labels[] = $awal->translatedFormat('M Y');
            $pengajuan[] = $buat()->whereBetween('created_at', [$awal, $akhir])->count();
            $selesai[] = $buat()->where('status', 'selesai')
                ->whereBetween('tanggal_kembali_aktual', [$awal->toDateString(), $akhir->toDateString()])
                ->count();
        }

        return compact('labels', 'pengajuan', 'selesai');
    }

    /** Jumlah kejadian per hari untuk satu kolom timestamp (mis. tanggal_diserahkan) selama N hari terakhir. */
    public static function harian(callable $buat, string $kolom, int $hari = 7): array
    {
        $data = [];

        for ($i = $hari - 1; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $data[] = $buat()->whereDate($kolom, $tgl->toDateString())->count();
        }

        return $data;
    }

    public static function labelHari(int $hari = 7): array
    {
        $out = [];
        for ($i = $hari - 1; $i >= 0; $i--) {
            $out[] = Carbon::today()->subDays($i)->translatedFormat('D, d M');
        }

        return $out;
    }
}
