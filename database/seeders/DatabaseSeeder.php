<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriBarangSeeder::class,
            PetugasSeeder::class,
            BarangSeeder::class,
            PeminjamanSeeder::class,
        ]);
    }
}
