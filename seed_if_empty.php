<?php
// Isi data awal (akun demo, kategori, barang, contoh peminjaman) HANYA jika tabel users masih kosong,
// supaya data yang sudah kamu ubah tidak tertimpa setiap kali run.bat dijalankan.
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (\App\Models\User::count() === 0) {
    $kernel->call('db:seed', ['--force' => true]);
    echo "Data awal berhasil dimasukkan.\n";
} else {
    echo "Data sudah ada, seeder utama dilewati.\n";

    // Database lama (sebelum role petugas ada): pasang akun petugas demo satu kali,
    // hanya jika belum ada petugas sama sekali dan sudah ada kategori barang.
    if (\App\Models\User::where('role', 'petugas')->count() === 0 && \App\Models\KategoriBarang::count() > 0) {
        $kernel->call('db:seed', ['--class' => 'PetugasSeeder', '--force' => true]);
        echo "Akun petugas demo ditambahkan (petugas.lab@sipinbar.sch.id / petugas123 dst).\n";
    }
}
