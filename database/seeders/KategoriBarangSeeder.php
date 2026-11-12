<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Alat Laboratorium', 'keterangan' => 'Peralatan praktik laboratorium sekolah'],
            ['nama_kategori' => 'Alat Olahraga', 'keterangan' => 'Peralatan penunjang kegiatan olahraga'],
            ['nama_kategori' => 'Alat Elektronik', 'keterangan' => 'Perangkat elektronik & multimedia'],
            ['nama_kategori' => 'Perkakas Bengkel', 'keterangan' => 'Peralatan bengkel/praktik jurusan'],
        ];

        foreach ($kategori as $k) {
            KategoriBarang::updateOrCreate(['nama_kategori' => $k['nama_kategori']], $k);
        }
    }
}
