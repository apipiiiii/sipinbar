<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah status baru: hilang (dilaporkan hilang) & diganti (hilang sudah diganti barang baru)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('pending','approved','rejected','selesai','hilang','diganti') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->unsignedInteger('hari_telat')->default(0)->after('catatan_pengembalian');
            $table->unsignedInteger('denda_telat')->default(0)->after('hari_telat');
            $table->boolean('denda_lunas')->default(false)->after('denda_telat');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['hari_telat', 'denda_telat', 'denda_lunas']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::table('peminjaman')->whereIn('status', ['hilang', 'diganti'])->update(['status' => 'selesai']);
            DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('pending','approved','rejected','selesai') NOT NULL DEFAULT 'pending'");
        }
    }
};
