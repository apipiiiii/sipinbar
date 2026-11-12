<?php

namespace App\Support;

use App\Models\Peminjaman;
use Carbon\Carbon;

/**
 * Feed aktivitas terbaru untuk dashboard admin.
 * Disusun dari catatan waktu yang sudah ada di tabel peminjaman (pengajuan, verifikasi, serah-terima, dst.),
 * jadi tidak perlu tabel log tambahan.
 */
class AktivitasFeed
{
    public static function terbaru(int $batas = 7): array
    {
        $daftar = Peminjaman::with(['siswa', 'barang', 'verifikator', 'petugasPenyerah', 'petugasPenerima'])
            ->orderByDesc('updated_at')
            ->take(30)
            ->get();

        $out = [];

        foreach ($daftar as $p) {
            $siswa = optional($p->siswa)->name ?? 'Siswa';
            $barang = optional($p->barang)->nama_barang ?? 'barang';

            $tambah = function ($waktu, string $pelaku, string $kalimat, string $ikon, string $warna) use (&$out, $p) {
                if (! $waktu) {
                    return;
                }
                $out[] = [
                    'waktu' => Carbon::parse($waktu),
                    'pelaku' => $pelaku,
                    'kalimat' => $kalimat,
                    'ikon' => $ikon,
                    'warna' => $warna,
                    'peminjaman' => $p,
                ];
            };

            $tambah($p->created_at, $siswa, 'mengajukan peminjaman '.$barang, 'fa-paper-plane', 'brand');

            if ($p->status === 'rejected') {
                $tambah($p->tanggal_verifikasi, optional($p->verifikator)->name ?? 'Admin', 'menolak pengajuan '.$siswa.' ('.$barang.')', 'fa-xmark', 'rose');
            } else {
                $tambah($p->tanggal_verifikasi, optional($p->verifikator)->name ?? 'Admin', 'menyetujui pengajuan '.$siswa.' ('.$barang.')', 'fa-check', 'emerald');
            }

            $tambah($p->tanggal_diserahkan, optional($p->petugasPenyerah)->name ?? 'Petugas', 'menyerahkan '.$barang.' kepada '.$siswa, 'fa-hand-holding-hand', 'sky');
            $tambah($p->tanggal_pengembalian_diajukan, $siswa, 'mengajukan pengembalian '.$barang, 'fa-rotate-left', 'yellow');
            $tambah($p->tanggal_diterima_petugas, optional($p->petugasPenerima)->name ?? 'Petugas', 'menerima pengembalian '.$barang.' dari '.$siswa, 'fa-box', 'yellow');
            $tambah($p->tanggal_konfirmasi_kembali, 'Admin', 'mengonfirmasi pengembalian '.$barang.' oleh '.$siswa, 'fa-circle-check', 'emerald');
        }

        usort($out, fn ($a, $b) => $b['waktu']->timestamp <=> $a['waktu']->timestamp);

        return array_slice($out, 0, $batas);
    }
}
