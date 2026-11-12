<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Denda keterlambatan pengembalian
    |--------------------------------------------------------------------------
    | denda_telat          : nominal denda (rupiah)
    | denda_telat_per_hari : true  => nominal dikalikan jumlah hari terlambat
    |                        false => denda tetap sekali bayar (flat)
    | Bisa diubah lewat .env: DENDA_TELAT=5000, DENDA_TELAT_PER_HARI=true
    */
    'denda_telat' => (int) env('DENDA_TELAT', 5000),
    'denda_telat_per_hari' => filter_var(env('DENDA_TELAT_PER_HARI', true), FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Aturan peminjaman siswa
    |--------------------------------------------------------------------------
    | lama_pinjam_hari : tanggal kembali otomatis = tanggal pinjam + N hari
    | Bisa diubah lewat .env: LAMA_PINJAM_HARI=3
    */
    'lama_pinjam_hari' => (int) env('LAMA_PINJAM_HARI', 3),
];
