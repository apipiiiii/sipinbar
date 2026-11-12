<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sipinbar.sch.id'],
            [
                'name' => 'Admin Sarpras',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nis_nip' => '198501012010011001',
                'no_hp' => '081234567890',
                'alamat' => 'SMK Negeri 5 Surakarta',
            ]
        );

        $siswa = [
            ['name' => 'Rafif Bari', 'nis' => '2324001', 'kelas' => 'XII RPL B'],
            ['name' => 'Ahmad Fauzan', 'nis' => '2324002', 'kelas' => 'XII RPL A'],
            ['name' => 'Siti Nurhaliza', 'nis' => '2324003', 'kelas' => 'XI RPL A'],
        ];

        foreach ($siswa as $s) {
            User::updateOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $s['name'])).'@siswa.sipinbar.sch.id'],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('siswa123'),
                    'role' => 'siswa',
                    'nis_nip' => $s['nis'],
                    'kelas' => $s['kelas'],
                    'no_hp' => '08'.rand(1000000000, 9999999999),
                ]
            );
        }
    }
}
