<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = User::siswa()->first();
        $admin = User::admin()->first();
        $barang = Barang::first();

        if (!$siswa || !$barang) {
            return;
        }

        Peminjaman::updateOrCreate(
            ['kode_peminjaman' => 'PJM-CONTOH-0001'],
            [
                'user_id' => $siswa->id,
                'barang_id' => $barang->id,
                'jumlah' => 1,
                'tanggal_pinjam' => now()->subDays(5),
                'tanggal_kembali_rencana' => now()->addDays(2),
                'keperluan' => 'Praktik mata pelajaran produktif RPL',
                'status' => 'approved',
                'catatan_admin' => 'Disetujui, harap dikembalikan tepat waktu.',
                'diverifikasi_oleh' => $admin?->id,
                'tanggal_verifikasi' => now()->subDays(4),
            ]
        );

        // Contoh peminjaman TERLAMBAT (untuk mencoba peringatan & denda)
        $barang2 = Barang::skip(1)->first() ?? $barang;

        Peminjaman::updateOrCreate(
            ['kode_peminjaman' => 'PJM-CONTOH-0002'],
            [
                'user_id' => $siswa->id,
                'barang_id' => $barang2->id,
                'jumlah' => 1,
                'tanggal_pinjam' => now()->subDays(10),
                'tanggal_kembali_rencana' => now()->subDays(3),
                'keperluan' => 'Contoh peminjaman terlambat',
                'status' => 'approved',
                'catatan_admin' => 'Disetujui.',
                'diverifikasi_oleh' => $admin?->id,
                'tanggal_verifikasi' => now()->subDays(9),
            ]
        );
    }
}
