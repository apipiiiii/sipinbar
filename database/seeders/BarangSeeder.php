<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $lab = KategoriBarang::where('nama_kategori', 'Alat Laboratorium')->first();
        $olahraga = KategoriBarang::where('nama_kategori', 'Alat Olahraga')->first();
        $elektronik = KategoriBarang::where('nama_kategori', 'Alat Elektronik')->first();
        $bengkel = KategoriBarang::where('nama_kategori', 'Perkakas Bengkel')->first();

        $barang = [
            ['kategori_barang_id' => $lab->id, 'kode_barang' => 'LAB-001', 'nama_barang' => 'Mikroskop Digital', 'stok_total' => 5, 'stok_tersedia' => 5],
            ['kategori_barang_id' => $lab->id, 'kode_barang' => 'LAB-002', 'nama_barang' => 'Multimeter Digital', 'stok_total' => 10, 'stok_tersedia' => 10],
            ['kategori_barang_id' => $olahraga->id, 'kode_barang' => 'OR-001', 'nama_barang' => 'Bola Basket', 'stok_total' => 8, 'stok_tersedia' => 8],
            ['kategori_barang_id' => $olahraga->id, 'kode_barang' => 'OR-002', 'nama_barang' => 'Net Voli', 'stok_total' => 3, 'stok_tersedia' => 3],
            ['kategori_barang_id' => $elektronik->id, 'kode_barang' => 'EL-001', 'nama_barang' => 'Proyektor', 'stok_total' => 4, 'stok_tersedia' => 4],
            ['kategori_barang_id' => $elektronik->id, 'kode_barang' => 'EL-002', 'nama_barang' => 'Laptop Praktik', 'stok_total' => 15, 'stok_tersedia' => 15],
            ['kategori_barang_id' => $bengkel->id, 'kode_barang' => 'BK-001', 'nama_barang' => 'Bor Listrik', 'stok_total' => 6, 'stok_tersedia' => 6],
            ['kategori_barang_id' => $bengkel->id, 'kode_barang' => 'BK-002', 'nama_barang' => 'Toolkit Set', 'stok_total' => 12, 'stok_tersedia' => 12],
        ];

        foreach ($barang as $b) {
            Barang::updateOrCreate(['kode_barang' => $b['kode_barang']], $b);
        }
    }
}
