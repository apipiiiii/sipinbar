# SIPINBAR — Sistem Informasi Peminjaman Barang & Inventaris

Aplikasi web untuk mendigitalisasi proses peminjaman alat/inventaris di SMK Negeri 5 Surakarta, dibangun menggunakan **Laravel 10**. Proyek ini dibuat berdasarkan **Dokumen Analisis Kebutuhan Project RPL - SIPINBAR**.

## ✅ Pemenuhan Persyaratan Teknis & Fitur

| No | Persyaratan | Status | Keterangan |
|----|-------------|--------|------------|
| 1 | Framework Laravel | ✅ | Laravel 10 (PHP 8.1+) |
| 2 | Migration & Seeder | ✅ | `database/migrations`, `database/seeders` |
| 3 | Multi-user / RBAC (min. 2 role) | ✅ | Role `admin`, `petugas` & `siswa` via `App\Http\Middleware\RoleMiddleware` |
| 4 | UI/UX Responsif | ✅ | Bootstrap 5 (mobile & desktop friendly, sidebar collapsible) |
| 5a | Autentikasi (login, logout, daftar akun siswa, profil/password) | ✅ | `Auth\LoginController`, `Auth\RegisterController`, `ProfileController` |
| 5b | Master Data (Pengguna & Data Pendukung) | ✅ | CRUD User, Kategori Barang, Barang |
| 5c | Transaksi Utama (ajukan / verifikasi / pengembalian) | ✅ | `Siswa\PeminjamanController`, `Admin\PeminjamanController` |
| 5d | Dashboard & Laporan (tabel + export PDF/Excel) | ✅ | `Admin\LaporanController` (DomPDF & Maatwebsite Excel) |

## 🧩 Struktur Role & Alur Kerja

- **Admin**: mengelola master data (user, kategori, barang), menetapkan **petugas untuk tiap kategori**, memverifikasi pengajuan (setujui/tolak), memberi **konfirmasi akhir pengembalian** (stok otomatis bertambah), serta melihat & mengekspor laporan rekap.
- **Petugas**: satu petugas bertanggung jawab atas satu kategori barang. Petugas hanya **mengonfirmasi penyerahan barang ke siswa** dan **penerimaan barang yang dikembalikan** (sekaligus mencatat kondisinya), dan hanya untuk barang pada kategori yang ia ampu.
- **Siswa / User**: mendaftar akun sendiri, melihat katalog barang & stok, mengajukan peminjaman, **mengajukan pengembalian**, memantau status, mengelola profil & password.

### Alur peminjaman (bertahap)

`Siswa mengajukan` → `Admin menyetujui` → `Petugas mengonfirmasi barang diserahkan` → **Sedang Dipinjam**

| Status | Arti | Yang bertindak berikutnya |
|--------|------|---------------------------|
| `pending` | Siswa mengajukan | Admin (setujui / tolak) |
| `disetujui` | Admin setuju, stok dipesan | Petugas kategori (konfirmasi penyerahan) |
| `approved` | Barang sudah diserahkan = **Sedang Dipinjam** | Siswa (kembalikan) |
| `pengembalian` | Siswa mengembalikan, denda keterlambatan dikunci | Petugas (terima & periksa kondisi) |
| `dicek_petugas` | Petugas sudah menerima | Admin (konfirmasi akhir) |
| `selesai` | Admin mengonfirmasi, **stok bertambah** | - |

Status lain: `rejected`, `hilang`, `diganti` (barang hilang, seperti sebelumnya).

> Admin **tidak bisa menyetujui** pengajuan jika kategori barangnya belum punya petugas. Atur di menu **Kategori Barang**.

### Daftar akun
Halaman `/register` hanya membuat akun **siswa** (NIS, kelas, email, kata sandi). Role dipaksa `siswa` di server, sehingga tidak bisa dimanipulasi dari formulir. Akun **admin & petugas** hanya dapat dibuat oleh admin lewat menu **Data Pengguna**.

## ⚙️ Instalasi (Lokal / XAMPP / Laragon)

1. **Ekstrak proyek** dan masuk ke folder:
   ```bash
   cd sipinbar-laravel
   ```

2. **Install dependency PHP** (butuh Composer & PHP ≥ 8.1):
   ```bash
   composer install
   ```

3. **Salin file environment**:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database di `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sipinbar
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Buat database `sipinbar` terlebih dahulu di MySQL/phpMyAdmin.

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan migration & seeder**:
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symbolic link storage** (agar foto barang tampil):
   ```bash
   php artisan storage:link
   ```

7. **Jalankan server development**:
   ```bash
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000` di browser.

## 🔑 Akun Demo (hasil Seeder)

| Role  | Email                                   | Password  |
|-------|------------------------------------------|-----------|
| Admin | admin@sipinbar.sch.id                    | admin123  |
| Petugas (Alat Laboratorium) | petugas.lab@sipinbar.sch.id        | petugas123 |
| Petugas (Alat Olahraga)     | petugas.olahraga@sipinbar.sch.id   | petugas123 |
| Petugas (Alat Elektronik)   | petugas.elektronik@sipinbar.sch.id | petugas123 |
| Petugas (Perkakas Bengkel)  | petugas.bengkel@sipinbar.sch.id    | petugas123 |
| Siswa | rafif.bari@siswa.sipinbar.sch.id         | siswa123  |
| Siswa | ahmad.fauzan@siswa.sipinbar.sch.id       | siswa123  |
| Siswa | siti.nurhaliza@siswa.sipinbar.sch.id     | siswa123  |

> ⚠️ Segera ganti password akun default ini melalui menu **Profil & Kata Sandi** setelah login pertama kali di lingkungan produksi.

## 📦 Package Tambahan yang Digunakan

- `barryvdh/laravel-dompdf` — export laporan ke PDF
- `maatwebsite/excel` — export laporan ke Excel (.xlsx)

Kedua package ini akan otomatis terpasang saat menjalankan `composer install` karena sudah didaftarkan di `composer.json`.

## 📁 Struktur Penting

```
app/
├── Http/Controllers/Admin/   → Controller sisi Admin (dashboard, master data, verifikasi, laporan)
├── Http/Controllers/Petugas/ → Controller sisi Petugas (dashboard, konfirmasi penyerahan/penerimaan)
├── Http/Controllers/Siswa/   → Controller sisi Siswa (dashboard, katalog, pengajuan, pengembalian)
├── Http/Controllers/Auth/    → Login & pendaftaran akun siswa
├── Http/Middleware/RoleMiddleware.php → RBAC middleware
├── Models/                   → User, KategoriBarang, Barang, Peminjaman
├── Exports/PeminjamanExport.php → Export Excel
database/
├── migrations/                → Skema tabel
├── seeders/                   → Data awal (admin, siswa, kategori, barang)
resources/views/
├── layouts/app.blade.php      → Layout utama responsif (sidebar + navbar)
├── admin/                     → Semua view sisi admin
├── petugas/                   → Semua view sisi petugas
├── siswa/                     → Semua view sisi siswa
```

## 🛠️ Troubleshooting

- **Error `SQLSTATE[HY000] [1049] Unknown database`** → pastikan database `sipinbar` sudah dibuat di MySQL sebelum migrate.
- **Foto barang tidak muncul** → jalankan `php artisan storage:link`.
- **Export PDF/Excel gagal** → pastikan sudah `composer install` sehingga package `barryvdh/laravel-dompdf` & `maatwebsite/excel` terpasang.
- **Halaman blank / 500 error** → cek `storage/logs/laravel.log`, pastikan permission folder `storage` dan `bootstrap/cache` writable (`chmod -R 775 storage bootstrap/cache` di Linux/Mac).

---
Dibuat untuk memenuhi Dokumen Analisis Kebutuhan Project RPL — SIPINBAR, SMK Negeri 5 Surakarta.


---

## ▶️ Cara Cepat Menjalankan (Windows)

1. Nyalakan **MySQL** (XAMPP/Laragon → Start).
2. Klik dua kali **`run.bat`** — otomatis membuat database, migrasi, mengisi data awal (hanya jika masih kosong), lalu menjalankan server dan membuka browser.

## ⏰ Denda Keterlambatan & 📦 Barang Hilang

- Peminjaman yang melewati tanggal rencana kembali ditandai **merah** + denda. Tarif diatur di `.env`:
  `DENDA_TELAT=5000` dan `DENDA_TELAT_PER_HARI=true` (ubah ke `false` untuk denda sekali bayar).
- Siswa dapat **melapor barang hilang** dari detail peminjaman. Admin mengelola di menu **Barang Hilang**: tandai *Sudah Diganti* (stok bertambah), lalu data boleh dihapus.

## 🔄 Upgrade dari Versi Sebelumnya (database sudah berisi data)

Jalankan `run.bat` (atau `php artisan migrate`). Migrasi `2024_02_01_000000_add_petugas_role_and_confirmation_flow` akan menambah role `petugas`, kolom `petugas_id` pada kategori, status & kolom konfirmasi baru. Data lama tetap aman: peminjaman berstatus `approved` otomatis dianggap **Sedang Dipinjam**.
Jika belum ada petugas sama sekali, `run.bat` memasang 4 akun petugas demo sekali (satu per kategori awal). Kategori buatan sendiri perlu ditetapkan petugasnya lewat menu **Kategori Barang**.

## 👷 Database Petugas & Aturan Peminjaman Siswa

- Tabel **`petugas`** (migrasi `2024_03_01_000000_create_petugas_table`) menyimpan profil petugas: NIP, nama, no. HP, alamat, jabatan, status aktif. Terhubung ke akun login di tabel `users` lewat `user_id`. Petugas yang sudah ada otomatis disalin saat `php artisan migrate`, dan tabel ini ikut diperbarui setiap admin menambah/mengubah pengguna berperan petugas.
- Siswa hanya boleh **1 peminjaman aktif** dan jumlahnya selalu **1 unit**.
- **Rencana tanggal kembali otomatis** = tanggal pinjam + 3 hari (ubah lewat `.env`: `LAMA_PINJAM_HARI=3`).
- Menu sidebar "Ajukan Peminjaman" dihapus; pengajuan dilakukan dari **Katalog Barang** (tombol Ajukan).

## 🎨 Desain Antarmuka (v2)

- **Satu tema terang** untuk Admin, Petugas, dan Siswa. Warna & komponen didefinisikan sekali di `resources/views/layouts/partials/head.blade.php` (warna utama `brand` = ungu pekat; kelas bersama `.card`, `.btn`, `.input`, `.tbl`, dll.).
- **Tata letak per role:** Admin = sidebar berkelompok + dashboard analitik; Petugas = rail ikon ringkas + dashboard antrian kerja; Siswa = navbar atas (tab bawah di HP) + dashboard peminjaman pribadi.
- **Grafik** memakai Chart.js (CDN) dan data asli dari database lewat `app/Support/ChartData.php` — tidak ada data contoh.
- Layout: `layouts/admin`, `layouts/petugas`, `layouts/user` (semua turunan `layouts/base`), halaman masuk/daftar memakai `layouts/auth`.
- Dukungan internet diperlukan saat pertama memuat (Tailwind, Font Awesome, Chart.js, Inter via CDN).

## 🔔 Notifikasi & Penyempurnaan (v3)

- **Lonceng notifikasi** di navbar semua role. Peringatan (terlambat, barang hilang, denda, jatuh tempo, pengajuan menunggu, stok menipis, dll.) tidak lagi berupa banner di dashboard, tetapi dikumpulkan di `app/Support/Notifikasi.php` per role dan dihitung langsung dari data (tanpa tabel baru). Status "sudah dibaca" disimpan di browser.
- **Toast** untuk pesan sukses/gagal (hilang otomatis), banner sambutan pada dashboard, tombol **Tambah** cepat di header Admin.
- Admin: **tab status dengan jumlah** pada Verifikasi Peminjaman. Siswa: kartu katalog dengan bar stok, dan tombol **Cetak bukti** pada detail peminjaman.

## 🍊 Penyegaran Desain (v5)

- **Warna utama baru:** oranye terakota (`brand`) dengan netral hangat (stone). Warna peringatan memakai kuning agar tidak tertukar dengan warna utama. Semua warna diatur di `layouts/partials/head.blade.php` (tema), `chart-setup.blade.php` dan `app/Support/ChartData.php` (grafik).
- **Pencarian menu cepat** dengan `Ctrl/⌘ + K` untuk semua role.
- **Agenda jatuh tempo 7 hari** di dashboard Admin dan Petugas; **cincin progres** masa pinjam di dashboard Siswa; sapaan sesuai jam; angka ringkasan menghitung naik.
- Katalog: filter **Tersedia saja**. Login: tombol lihat kata sandi. Tombol submit otomatis nonaktif saat memproses (cegah kirim ganda). Halaman error 403/404/419/429/500/503 bertema.

## ✨ Pembaruan v6

- **Halaman depan publik** (`/`) dengan data asli (statistik, ketersediaan barang, kategori); pengguna yang sudah login langsung diarahkan ke dashboard.
- **Notifikasi otomatis:** lonceng mengecek `GET /notifikasi` tiap 60 detik, lalu menampilkan toast dan badge saat ada notifikasi baru.
- **Aktivitas terbaru** di dashboard Admin (`app/Support/AktivitasFeed.php`, dari catatan waktu peminjaman).
- **Sidebar Admin bisa dilipat**, **warna aksen bisa dipilih** (Profil → Tampilan), **tabel interaktif** (urut kolom, filter cepat, header menempel, kepadatan baris).
- Animasi masuk bertahap, skeleton pada grafik, bar progres terisi, lonceng bergoyang, dan confetti saat pengajuan/pengembalian berhasil.
