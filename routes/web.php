<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangHilangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriBarangController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\KatalogController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjamanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman utama & Autentikasi
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Menyajikan file upload (foto barang, dll) langsung dari storage/app/public.
// Berfungsi walau `php artisan storage:link` gagal / tidak dijalankan (mis. di Windows tanpa admin).
Route::get('/storage/{path}', function (string $path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    abort_unless($disk->exists($path), 404);
    return response()->file($disk->path($path), ['Cache-Control' => 'public, max-age=86400']);
})->where('path', '.*')->name('storage.media');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    // Pendaftaran akun mandiri (hanya membuat akun siswa)
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Notifikasi (JSON) untuk lonceng di navbar semua role
    Route::get('/notifikasi', NotifikasiController::class)->name('notifikasi.index');

    // Redirect umum setelah login, diarahkan sesuai role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return redirect()->route($user->dashboardRoute());
    })->name('dashboard');

    // Profil & ganti password (berlaku untuk semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Area ADMIN / Petugas Sarpras
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Master Data: Pengguna
    Route::resource('users', UserController::class)->except(['show']);

    // Master Data: Kategori Barang (data pendukung)
    Route::resource('kategori', KategoriBarangController::class)->except(['show']);

    // Master Data: Barang / Inventaris
    Route::resource('barang', BarangController::class);

    // Transaksi: Verifikasi & Pengembalian Peminjaman
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::patch('/peminjaman/{peminjaman}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{peminjaman}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::patch('/peminjaman/{peminjaman}/kembali', [AdminPeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
    Route::patch('/peminjaman/{peminjaman}/lunas', [AdminPeminjamanController::class, 'lunas'])->name('peminjaman.lunas');

    // Barang hilang: daftar, tandai sudah diganti, hapus (setelah diganti)
    Route::get('/hilang', [BarangHilangController::class, 'index'])->name('hilang.index');
    Route::patch('/hilang/{hilang}/diganti', [BarangHilangController::class, 'diganti'])->name('hilang.diganti');
    Route::delete('/hilang/{hilang}', [BarangHilangController::class, 'destroy'])->name('hilang.destroy');

    // Dashboard & Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
});

/*
|--------------------------------------------------------------------------
| Area PETUGAS (satu petugas per kategori barang)
| Mengonfirmasi penyerahan barang ke siswa & penerimaan barang kembali.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PetugasPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::patch('/peminjaman/{peminjaman}/serahkan', [PetugasPeminjamanController::class, 'serahkan'])->name('peminjaman.serahkan');
    Route::patch('/peminjaman/{peminjaman}/terima', [PetugasPeminjamanController::class, 'terima'])->name('peminjaman.terima');
});

/*
|--------------------------------------------------------------------------
| Area SISWA / User
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Katalog barang & ketersediaan stok
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/katalog/{barang}', [KatalogController::class, 'show'])->name('katalog.show');

    // Transaksi: Pengajuan peminjaman & riwayat
    Route::get('/peminjaman', [SiswaPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [SiswaPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [SiswaPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [SiswaPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [SiswaPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/{peminjaman}/hilang', [SiswaPeminjamanController::class, 'laporHilang'])->name('peminjaman.hilang');
});
