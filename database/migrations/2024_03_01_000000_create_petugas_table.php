<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Database PETUGAS: data profil petugas sarpras (satu baris per akun petugas).
 * Akun login tetap di tabel users (role = petugas); tabel ini menyimpan data kepetugasannya.
 * Petugas yang sudah ada di tabel users otomatis disalin ke tabel ini.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nip', 50)->nullable()->unique();
            $table->string('nama');
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('jabatan')->default('Petugas Sarpras');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Salin petugas yang sudah terdaftar di tabel users
        $now = now();
        $rows = DB::table('users')->where('role', 'petugas')->get()->map(fn ($u) => [
            'user_id' => $u->id,
            'nip' => $u->nis_nip,
            'nama' => $u->name,
            'no_hp' => $u->no_hp,
            'alamat' => $u->alamat,
            'jabatan' => 'Petugas Sarpras',
            'aktif' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        if ($rows) {
            DB::table('petugas')->insert($rows);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
