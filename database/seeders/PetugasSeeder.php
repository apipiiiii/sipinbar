<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Satu akun petugas untuk setiap kategori barang awal. Aman dijalankan berulang.
 */
class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = [
            ['kategori' => 'Alat Laboratorium', 'name' => 'Budi Santoso (Lab)', 'email' => 'petugas.lab@sipinbar.sch.id', 'nip' => 'PTG-001'],
            ['kategori' => 'Alat Olahraga', 'name' => 'Sri Wahyuni (Olahraga)', 'email' => 'petugas.olahraga@sipinbar.sch.id', 'nip' => 'PTG-002'],
            ['kategori' => 'Alat Elektronik', 'name' => 'Agus Prasetyo (Elektronik)', 'email' => 'petugas.elektronik@sipinbar.sch.id', 'nip' => 'PTG-003'],
            ['kategori' => 'Perkakas Bengkel', 'name' => 'Dwi Haryanto (Bengkel)', 'email' => 'petugas.bengkel@sipinbar.sch.id', 'nip' => 'PTG-004'],
        ];

        foreach ($petugas as $p) {
            $kategori = KategoriBarang::where('nama_kategori', $p['kategori'])->first();
            if (! $kategori) {
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('petugas123'),
                    'role' => 'petugas',
                    'nis_nip' => $p['nip'],
                    'no_hp' => '0812345600'.substr($p['nip'], -2),
                    'alamat' => 'SMK Negeri 5 Surakarta',
                ]
            );

            Petugas::sinkronDariUser($user);
            $kategori->update(['petugas_id' => $user->id]);
        }
    }
}
