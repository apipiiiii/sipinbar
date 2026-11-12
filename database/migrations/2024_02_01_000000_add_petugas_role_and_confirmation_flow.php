<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan role PETUGAS + alur konfirmasi bertahap:
 *
 *  Peminjaman : pending -> (admin setujui) disetujui -> (petugas serahkan) approved/"Sedang Dipinjam"
 *  Pengembalian: approved -> (siswa kembalikan) pengembalian -> (petugas terima) dicek_petugas -> (admin konfirmasi) selesai
 *
 * Setiap kategori barang memiliki satu petugas (kategori_barangs.petugas_id).
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Role baru "petugas" (khusus MySQL, sama seperti migrasi enum sebelumnya)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','petugas','siswa') NOT NULL DEFAULT 'siswa'");
            DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('pending','disetujui','approved','rejected','pengembalian','dicek_petugas','selesai','hilang','diganti') NOT NULL DEFAULT 'pending'");
        }

        // 2. Satu petugas per kategori barang
        Schema::table('kategori_barangs', function (Blueprint $table) {
            $table->foreignId('petugas_id')->nullable()->after('keterangan')->constrained('users')->nullOnDelete();
        });

        // 3. Jejak konfirmasi di tabel peminjaman
        Schema::table('peminjaman', function (Blueprint $table) {
            // Penyerahan barang ke siswa (oleh petugas)
            $table->foreignId('diserahkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_diserahkan')->nullable();
            $table->text('catatan_penyerahan')->nullable();

            // Siswa mengajukan pengembalian
            $table->timestamp('tanggal_pengembalian_diajukan')->nullable();
            $table->text('catatan_siswa')->nullable();

            // Petugas menerima barang kembali & memeriksa kondisi
            $table->foreignId('diterima_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_diterima_petugas')->nullable();
            $table->text('catatan_petugas')->nullable();

            // Admin mengonfirmasi barang sudah dikembalikan (final)
            $table->foreignId('dikonfirmasi_kembali_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_konfirmasi_kembali')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropConstrainedForeignId('diserahkan_oleh');
            $table->dropConstrainedForeignId('diterima_oleh');
            $table->dropConstrainedForeignId('dikonfirmasi_kembali_oleh');
            $table->dropColumn([
                'tanggal_diserahkan', 'catatan_penyerahan',
                'tanggal_pengembalian_diajukan', 'catatan_siswa',
                'tanggal_diterima_petugas', 'catatan_petugas',
                'tanggal_konfirmasi_kembali',
            ]);
        });

        Schema::table('kategori_barangs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('petugas_id');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::table('peminjaman')->whereIn('status', ['disetujui'])->update(['status' => 'pending']);
            DB::table('peminjaman')->whereIn('status', ['pengembalian', 'dicek_petugas'])->update(['status' => 'approved']);
            DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('pending','approved','rejected','selesai','hilang','diganti') NOT NULL DEFAULT 'pending'");

            DB::table('users')->where('role', 'petugas')->update(['role' => 'admin']);
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','siswa') NOT NULL DEFAULT 'siswa'");
        }
    }
};
