<?php
/**
 * Generator E-Book SIPINBAR - Versi Bahasa Indonesia
 * Format: PDF (Ukuran Kertas A5 Portrait: 148mm x 210mm)
 * Engine: Dompdf (Laravel 10 / barryvdh)
 * Dokumen: ebook_sipinbar_indonesia_a5.pdf
 */

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);

$html = <<<'HTML'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>E-Book Panduan SIPINBAR - SMK Negeri 5 Surakarta</title>
<style>
    @page {
        size: a5 portrait;
        margin: 18mm 14mm 16mm 14mm;
    }
    *, *::before, *::after {
        box-sizing: border-box;
    }
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 8.5pt;
        line-height: 1.45;
        color: #1e293b;
        margin: 0;
        padding: 0;
    }
    .avoid-break {
        page-break-inside: avoid;
    }
    .chapter-break {
        page-break-before: always;
    }

    /* ---- COVER PAGE ---- */
    .cover {
        padding-top: 15px;
        text-align: center;
    }
    .cover-top-bar {
        height: 6px;
        background: #c2410c;
        width: 100%;
        margin-bottom: 25px;
        border-radius: 3px;
    }
    .cover-badge {
        display: inline-block;
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fdba74;
        font-size: 7.5pt;
        font-weight: bold;
        letter-spacing: 1px;
        padding: 4px 14px;
        border-radius: 12px;
        text-transform: uppercase;
        margin-bottom: 18px;
    }
    .cover-title {
        font-size: 26pt;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }
    .cover-title span {
        color: #c2410c;
    }
    .cover-subtitle {
        font-size: 10pt;
        font-weight: 600;
        color: #475569;
        margin: 0 0 16px 0;
        line-height: 1.35;
    }
    .cover-divider {
        width: 60px;
        height: 3px;
        background: #ea580c;
        margin: 0 auto 20px auto;
        border-radius: 2px;
    }
    .cover-desc {
        font-size: 8pt;
        color: #64748b;
        line-height: 1.5;
        max-width: 310px;
        margin: 0 auto 30px auto;
    }
    .cover-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        text-align: left;
        margin: 0 auto 25px auto;
        width: 92%;
    }
    .cover-card-row {
        margin-bottom: 5px;
        font-size: 7.5pt;
    }
    .cover-card-row:last-child {
        margin-bottom: 0;
    }
    .cover-card-label {
        color: #64748b;
        font-weight: bold;
        display: inline-block;
        width: 90px;
    }
    .cover-card-val {
        color: #0f172a;
        font-weight: 600;
    }
    .cover-footer {
        margin-top: 35px;
        font-size: 7.2pt;
        color: #94a3b8;
    }

    /* ---- TYPOGRAPHY ---- */
    h1.chapter-title {
        font-size: 13.5pt;
        font-weight: bold;
        color: #9a3412;
        border-bottom: 2px solid #ea580c;
        padding-bottom: 4px;
        margin-top: 0;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    h2.section-title {
        font-size: 9.8pt;
        font-weight: bold;
        color: #0f172a;
        margin-top: 13px;
        margin-bottom: 6px;
        border-left: 3px solid #ea580c;
        padding-left: 6px;
    }
    p {
        margin: 0 0 7px 0;
        text-align: justify;
    }
    ul, ol {
        margin: 0 0 8px 0;
        padding-left: 17px;
    }
    li {
        margin-bottom: 3.5px;
        text-align: justify;
    }

    /* ---- CALLOUT BOXES ---- */
    .box {
        padding: 7px 9px;
        border-radius: 5px;
        margin: 8px 0;
        font-size: 7.8pt;
        line-height: 1.4;
    }
    .box-info {
        background: #f0fdf4;
        border-left: 3px solid #16a34a;
        color: #14532d;
    }
    .box-tip {
        background: #eff6ff;
        border-left: 3px solid #2563eb;
        color: #1e3a8a;
    }
    .box-brand {
        background: #fff7ed;
        border-left: 3px solid #ea580c;
        color: #7c2d12;
    }

    /* ---- TABLES ---- */
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 7px 0;
        font-size: 7.2pt;
    }
    table.data-table th {
        background: #0f172a;
        color: #ffffff;
        padding: 5px 6px;
        text-align: left;
        font-weight: 600;
        border: 1px solid #0f172a;
    }
    table.data-table td {
        padding: 4px 6px;
        border: 1px solid #cbd5e1;
        vertical-align: top;
    }
    table.data-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    /* ---- BADGES & TAGS ---- */
    .badge {
        display: inline-block;
        padding: 1.5px 5px;
        border-radius: 3px;
        font-size: 6.5pt;
        font-weight: bold;
    }
    .badge-admin { background: #fee2e2; color: #991b1b; }
    .badge-petugas { background: #fef3c7; color: #92400e; }
    .badge-siswa { background: #dcfce7; color: #166534; }

    /* ---- STEP PROCESS BOXES ---- */
    .step-box {
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        padding: 6px 8px;
        margin-bottom: 6px;
        background: #ffffff;
        page-break-inside: avoid;
    }
    .step-num {
        display: inline-block;
        background: #c2410c;
        color: #ffffff;
        font-weight: bold;
        font-size: 6.8pt;
        padding: 1.5px 6px;
        border-radius: 3px;
        margin-right: 5px;
    }
    .step-header {
        font-weight: bold;
        color: #0f172a;
        font-size: 8pt;
        margin-bottom: 2.5px;
    }

    /* ---- TABLE OF CONTENTS COMPACT ---- */
    .toc-item {
        margin-bottom: 3.5px;
        font-size: 7.3pt;
    }
    .toc-title {
        font-weight: bold;
        color: #0f172a;
    }
    .toc-sub {
        padding-left: 14px;
        font-size: 6.8pt;
        color: #475569;
        margin-top: 1px;
        line-height: 1.25;
    }
    .toc-leader {
        float: right;
        font-weight: bold;
        color: #c2410c;
    }

    /* ---- CODE / TERMINAL SNIPPET ---- */
    .code-box {
        background: #0f172a;
        color: #f8fafc;
        font-family: Courier, monospace;
        font-size: 6.8pt;
        padding: 6px 8px;
        border-radius: 4px;
        margin: 6px 0;
        line-height: 1.35;
    }
</style>
</head>
<body>

<!-- CANVAS SCRIPT FOR RUNNING HEADER & FOOTER -->
<script type="php">
if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        if ($pageNumber > 1) {
            $font = $fontMetrics->getFont("Helvetica", "normal");
            $size = 6.8;

            // Running Header
            $canvas->text(39.7, 22, "SIPINBAR | E-Book Panduan Sistem Peminjaman Barang & Inventaris", $font, $size, [0.45, 0.45, 0.45]);
            $canvas->line(39.7, 30, 380, 30, [0.82, 0.82, 0.82], 0.5);

            // Running Footer
            $canvas->line(39.7, 565, 380, 565, [0.82, 0.82, 0.82], 0.5);
            $canvas->text(39.7, 572, "SMK Negeri 5 Surakarta - Edisi 2026", $font, $size, [0.45, 0.45, 0.45]);

            $pageStr = "Halaman " . $pageNumber . " dari " . $pageCount;
            $width = $fontMetrics->getTextWidth($pageStr, $font, $size);
            $canvas->text(380 - $width, 572, $pageStr, $font, $size, [0.45, 0.45, 0.45]);
        }
    });
}
</script>

<!-- ============================================================== -->
<!-- 1. HALAMAN JUDUL (COVER) -->
<!-- ============================================================== -->
<div class="cover">
    <div class="cover-top-bar"></div>
    <div class="cover-badge">E-Book Dokumentasi Resmi &amp; Manual Pengguna</div>
    
    <div class="cover-title">SIPIN<span>BAR</span></div>
    <div class="cover-subtitle">Sistem Informasi Peminjaman Barang &amp; Inventaris<br>SMK Negeri 5 Surakarta</div>
    <div class="cover-divider"></div>
    
    <div class="cover-desc">
        Buku panduan lengkap mengenai latar belakang perancangan, arsitektur teknis, fitur multi-peran, kebutuhan alat dan bahan pengembangan berbasis Laravel 10, serta prosedur operasional sistem secara menyeluruh.
    </div>

    <div class="cover-card">
        <div class="cover-card-row">
            <span class="cover-card-label">Sasaran Aplikasi:</span>
            <span class="cover-card-val">Tata Kelola Sarana &amp; Prasarana Sekolah Vokasi</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Framework:</span>
            <span class="cover-card-val">Laravel 10.x &amp; Tailwind CSS</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Model Akses:</span>
            <span class="cover-card-val">Multi-Role (Admin Sarpras, Petugas, Siswa)</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Instansi:</span>
            <span class="cover-card-val">SMK Negeri 5 Surakarta</span>
        </div>
        <div class="cover-card-row">
            <span class="cover-card-label">Tahun Rilis:</span>
            <span class="cover-card-val">2026</span>
        </div>
    </div>

    <div class="cover-footer">
        Diterbitkan secara digital dalam format buku saku A5 untuk kebutuhan dokumentasi teknis dan operasional pengguna di lingkungan sekolah.
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. DAFTAR ISI -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">2. Daftar Isi</h1>
    <p style="font-size: 7.5pt; color: #64748b; margin-bottom: 10px;">Struktur isi e-book panduan sistem informasi SIPINBAR:</p>

    <div class="toc-item">
        <div class="toc-title">1. Halaman Judul (Cover) <span class="toc-leader">1</span></div>
    </div>

    <div class="toc-item">
        <div class="toc-title">2. Daftar Isi <span class="toc-leader">2</span></div>
    </div>

    <div class="toc-item">
        <div class="toc-title">3. Pendahuluan <span class="toc-leader">3</span></div>
        <div class="toc-sub">&bull; 3.1 Latar Belakang Permasalahan Inventaris Sekolah</div>
        <div class="toc-sub">&bull; 3.2 Maksud dan Tujuan Pengembangan SIPINBAR</div>
        <div class="toc-sub">&bull; 3.3 Ruang Lingkup Sistem &amp; Model Pemisahan Peran (RBAC)</div>
        <div class="toc-sub">&bull; 3.4 Manfaat Penerapan Sistem bagi Sekolah</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">4. Fitur Web SIPINBAR <span class="toc-leader">6</span></div>
        <div class="toc-sub">&bull; 4.1 Modul Otentikasi &amp; Keamanan Akun Berjenjang</div>
        <div class="toc-sub">&bull; 4.2 Fitur Administrator (Sarana &amp; Prasarana)</div>
        <div class="toc-sub">&bull; 4.3 Fitur Petugas / Laboran Kategori Barang</div>
        <div class="toc-sub">&bull; 4.4 Fitur Siswa / Peminjam Mandiri</div>
        <div class="toc-sub">&bull; 4.5 Mesin Perhitungan Denda &amp; Modul Barang Hilang</div>
        <div class="toc-sub">&bull; 4.6 Ekspor Laporan Rekapitulasi (PDF &amp; Excel)</div>
        <div class="toc-sub">&bull; 4.7 Desain Antarmuka Responsif &amp; Umpan Balik Cepat</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">5. Alat dan Bahan untuk Membuat Web <span class="toc-leader">9</span></div>
        <div class="toc-sub">&bull; 5.1 Kebutuhan Perangkat Keras (Hardware Requirements)</div>
        <div class="toc-sub">&bull; 5.2 Kebutuhan Perangkat Lunak &amp; Development Tools</div>
        <div class="toc-sub">&bull; 5.3 Teknologi &amp; Library Eksternal (Tech Stack)</div>
        <div class="toc-sub">&bull; 5.4 Arsitektur &amp; Rancangan Basis Data (Database Schema)</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">6. Langkah Menggunakan Web (Panduan Operasional) <span class="toc-leader">12</span></div>
        <div class="toc-sub">&bull; 6.1 Persiapan Lingkungan &amp; Cara Menjalankan Sistem</div>
        <div class="toc-sub">&bull; 6.2 Prosedur Langkah Penggunaan untuk Siswa</div>
        <div class="toc-sub">&bull; 6.3 Prosedur Langkah Penggunaan untuk Petugas Laboran</div>
        <div class="toc-sub">&bull; 6.4 Prosedur Langkah Penggunaan untuk Administrator</div>
        <div class="toc-sub">&bull; 6.5 Matriks Alur Status Sirkulasi Barang</div>
    </div>

    <div class="toc-item">
        <div class="toc-title">7. Kesimpulan &amp; Roadmap Masa Depan <span class="toc-leader">16</span></div>
        <div class="toc-sub">&bull; 7.1 Kesimpulan Implementasi SIPINBAR</div>
        <div class="toc-sub">&bull; 7.2 Dampak Efisiensi Tata Kelola Aset</div>
        <div class="toc-sub">&bull; 7.3 Saran &amp; Rencana Pengembangan Lanjutan</div>
    </div>

    <div class="box box-brand" style="margin-top: 15px;">
        <strong>Informasi E-Book:</strong> Panduan ini dirancang dengan standar tata letak A5 portrait yang ideal untuk dibaca pada tablet, smartphone, maupun dicetak sebagai buku saku operasional sarpras sekolah.
    </div>
</div>

<!-- ============================================================== -->
<!-- 3. PENDAHULUAN -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">3. Pendahuluan</h1>

    <h2 class="section-title">3.1 Latar Belakang Permasalahan</h2>
    <p>
        Tata kelola sarana dan prasarana di lingkungan Sekolah Menengah Kejuruan (SMK), khususnya di <strong>SMK Negeri 5 Surakarta</strong>, merupakan pilar vital yang menopang keberhasilan kegiatan belajar mengajar (KBM) dan praktikum kejuruan. Tingginya frekuensi penggunaan alat peraga, perkakas bengkel, perangkat laboratorium multimedia, serta perlengkapan teknologi informasi menuntut pengelolaan inventaris yang presisi, cepat, dan transparan.
    </p>
    <p>
        Secara historis, sebagian besar administrasi sarpras masih dijalankan secara konvensional menggunakan buku besar kertas atau formulir manual. Pendekatan konvensional ini menimbulkan serangkaian kendala sistemik:
    </p>
    <ul>
        <li><strong>Tingginya Risiko Kehilangan Aset:</strong> Peminjaman yang dicatat manual kerap kali tidak terdokumentasi dengan baik, menyulitkan pelacakan siapa pemegang terakhir aset sekolah.</li>
        <li><strong>Stok Tidak Real-Time:</strong> Siswa dan guru tidak dapat mengetahui ketersediaan alat tanpa mendatangi gudang atau laboratorium secara langsung, memicu antrean dan inefisiensi waktu.</li>
        <li><strong>Pengawasan Tenggat Waktu yang Lemah:</strong> Tidak adanya sistem peringatan otomatis menyebabkan barang yang dipinjam terlambat dikembalikan berhari-hari bahkan berminggu-minggu tanpa sanksi yang terukur.</li>
        <li><strong>Penyusunan Laporan yang Lambat:</strong> Koordinator sarpras membutuhkan waktu berhari-hari untuk merekapitulasi data sirkulasi dan kondisi aset secara manual saat inspeksi atau audit sekolah.</li>
    </ul>

    <h2 class="section-title">3.2 Maksud dan Tujuan Pengembangan SIPINBAR</h2>
    <p>
        <strong>SIPINBAR (Sistem Informasi Peminjaman Barang &amp; Inventaris)</strong> dikembangkan sebagai solusi digital berbasis web modern untuk mengotomatisasi seluruh siklus hidup peminjaman dan inventarisasi sarana prasarana sekolah. Tujuan utama sistem ini meliputi:
    </p>
    <ol>
        <li><strong>Digitalisasi Alur Sirkulasi Barang:</strong> Mengganti pencatatan manual dengan sistem alur kerja digital yang terintegrasi mulai dari permohonan, persetujuan, serah terima fisik, pengembalian, hingga audit pelunasan denda.</li>
        <li><strong>Peningkatan Akuntabilitas &amp; Keamanan Aset:</strong> Mencatat setiap mutasi barang dengan rekam jejak digital (timestamp, identitas peminjam, petugas penyerah, kondisi barang saat kembali).</li>
        <li><strong>Transparansi Ketersediaan Barang:</strong> Menyediakan katalog online interaktif yang menampilkan stok riil barang dan kondisinya secara akurat.</li>
        <li><strong>Pemberlakuan Sanksi yang Adil dan Terukur:</strong> Menghitung denda keterlambatan secara otomatis berdasarkan selisih hari pengembalian guna menumbuhkan kedisiplinan siswa.</li>
    </ol>

    <h2 class="section-title">3.3 Ruang Lingkup Sistem &amp; Model Hak Akses (RBAC)</h2>
    <p>
        Untuk menjaga integritas operasional dan keamanan data, SIPINBAR menerapkan model <em>Role-Based Access Control</em> (RBAC) dengan 3 peran pengguna yang memiliki batasan tanggung jawab yang jelas:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 22%;">Peran Pengguna</th>
                <th style="width: 38%;">Tanggung Jawab Utama</th>
                <th style="width: 40%;">Hak Akses pada Sistem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-admin">Admin Sarpras</span></td>
                <td>Koordinator utama sarpras, pembuat kebijakan, analis laporan, dan approver izin peminjaman.</td>
                <td>Akses penuh dashboard eksekutif, master data barang &amp; kategori, persetujuan transaksi, verifikasi pelunasan denda, barang hilang, dan cetak laporan.</td>
            </tr>
            <tr>
                <td><span class="badge badge-petugas">Petugas Laboran</span></td>
                <td>Penanggung jawab fisik barang di laboratorium/bengkel sesuai bidang kategori yang diampu.</td>
                <td>Dashboard operasional kategori, konfirmasi penyerahan fisik barang (handover), dan konfirmasi penerimaan fisik barang serta cek kelengkapan kondisi.</td>
            </tr>
            <tr>
                <td><span class="badge badge-siswa">Siswa / Peminjam</span></td>
                <td>Pengguna sarana prasarana sekolah yang meminjam alat untuk kebutuhan praktikum atau KBM.</td>
                <td>Pendaftaran akun mandiri, akses katalog &amp; cek stok, formulir permohonan pinjam, pemantauan tenggat kembali, dan pelaporan kendala/barang hilang.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-tip">
        <strong>Konsep Separation of Duties:</strong> Pemisahan peran antara Admin (pemberi izin digital) dan Petugas (verifikator fisik barang) mencegah terjadinya manipulasi stok dan memastikan barang benar-benar diperiksa secara fisik saat keluar maupun masuk.
    </div>

    <h2 class="section-title">3.4 Manfaat Penerapan Sistem bagi Sekolah</h2>
    <p>Penerapan SIPINBAR memberikan dampak transformatif bagi seluruh pemangku kepentingan di sekolah:</p>
    <ul>
        <li><strong>Bagi Pimpinan Sekolah &amp; Koordinator Sarpras:</strong> Memperoleh visualisasi data inventaris secara instan, mempermudah perencanaan pengadaan barang baru, serta meminimalkan angka kerugian akibat alat hilang.</li>
        <li><strong>Bagi Petugas &amp; Laboran:</strong> Tidak lagi terbebani buku manual tebal, proses serah terima barang tervalidasi dalam hitungan detik melalui antarmuka web yang intuitif.</li>
        <li><strong>Bagi Siswa:</strong> Mendapatkan kemudahan dalam meminjam alat praktikum, memiliki kepastian stok barang, dan terhindar dari kesalahpahaman administrasi.</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 4. FITUR WEB -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">4. Fitur Web SIPINBAR</h1>
    <p>
        Aplikasi web SIPINBAR dirancang dengan serangkaian modul fungsional terpadu untuk mengakomodasi seluruh tahapan tata kelola inventaris sekolah secara profesional.
    </p>

    <h2 class="section-title">4.1 Modul Otentikasi &amp; Keamanan Akun Berjenjang</h2>
    <p>
        Aspek keamanan menjadi pondasi utama SIPINBAR dalam menjamin integritas data dan hak akses pengguna:
    </p>
    <ul>
        <li><strong>Sistem Multi-Role Authentication:</strong> Otentikasi sesi terproteksi menggunakan middleware Laravel. Pengguna secara otomatis diarahkan ke dashboard sesuai perannya masing-masing setelah berhasil login.</li>
        <li><strong>Pendaftaran Mandiri Akun Siswa:</strong> Siswa dapat mendaftarkan akun secara mandiri dengan melengkapi NIS, Nama Lengkap, Kelas, Nomor Telepon/WhatsApp, dan Password.</li>
        <li><strong>Perlindungan Brute-Force &amp; Rate Limiting:</strong> Rute registrasi dan login diproteksi dengan rate limiter guna mencegah serangan otomatis.</li>
        <li><strong>Manajemen Profil &amp; Keamanan Kredensial:</strong> Pengguna dapat memperbarui data kontak pribadi dan mengganti kata sandi dengan verifikasi password lama yang dienkripsi menggunakan algoritma hashing Bcrypt.</li>
    </ul>

    <h2 class="section-title">4.2 Fitur Administrator (Sarana &amp; Prasarana)</h2>
    <p>
        Panel Administrator menyediakan instrumen kendali penuh atas data master, kebijakan sirkulasi, dan analisis kinerja sarpras:
    </p>
    <ul>
        <li><strong>Dashboard Analitik Eksekutif:</strong> Menyajikan kartu statistik ringkas (Total Inventaris, Barang Sedang Dipinjam, Peminjaman Menunggu Persetujuan, Pengembalian Menunggu Admin, Denda Tertunggak, dan Status Stok).</li>
        <li><strong>Master Data Barang / Inventaris:</strong> Fitur CRUD barang yang mencakup Kode Barang Unik, Nama Barang, Kategori, Stok Total, Stok Tersedia, Kondisi Fisik, Foto Barang, dan Keterangan Spesifikasi.</li>
        <li><strong>Master Data Kategori &amp; Penugasan Petugas:</strong> Pengelompokan barang berdasarkan bidang kejuruan sekaligus pemetaan akun Petugas Laboran yang menjadi penanggung jawab kategori tersebut.</li>
        <li><strong>Manajemen Data Pengguna:</strong> Pengelolaan data akun Admin, Petugas, dan Siswa, termasuk pencarian berdasarkan NIS/NIP atau nama.</li>
        <li><strong>Verifikasi Pengajuan Pinjaman (Approval / Reject):</strong> Memeriksa urgensi keperluan pinjam siswa dan memutuskan persetujuan dengan menyertakan catatan resmi.</li>
        <li><strong>Verifikasi Penutupan Pinjaman:</strong> Mengonfirmasi status selesai setelah barang diverifikasi fisik oleh petugas, sekaligus memulihkan stok barang ke kondisi semula.</li>
    </ul>

    <h2 class="section-title">4.3 Fitur Petugas / Laboran Kategori Barang</h2>
    <p>
        Petugas bertindak sebagai garda operasional di laboratorium atau gudang sarpras:
    </p>
    <ul>
        <li><strong>Dashboard Khusus Kategori:</strong> Petugas hanya melihat daftar barang dan transaksi yang menjadi tanggung jawab kategorinya, memastikan fokus kerja yang terarah.</li>
        <li><strong>Konfirmasi Penyerahan Barang Fisik (Handover):</strong> Saat siswa datang menunjukkan permohonan yang telah disetujui Admin, petugas menyerahkan fisik barang dan menekan tombol konfirmasi penyerahan. Status transaksi otomatis berubah menjadi <code>Sedang Dipinjam</code>.</li>
        <li><strong>Pemeriksaan Fisik &amp; Konfirmasi Penerimaan Kembali:</strong> Saat barang dikembalikan oleh siswa, petugas melakukan inspeksi fisik terhadap fungsi dan kelengkapan barang, menginput catatan kondisi kembali, dan meneruskannya ke Admin untuk penutupan akhir.</li>
    </ul>

    <h2 class="section-title">4.4 Fitur Siswa / Peminjam Mandiri</h2>
    <p>
        Antarmuka siswa mengutamakan kemudahan navigasi dan transparansi informasi:
    </p>
    <ul>
        <li><strong>Dashboard Peminjam:</strong> Menampilkan ringkasan pinjaman yang sedang aktif, tenggat waktu pengembalian, status persetujuan, dan riwayat transaksi masa lalu.</li>
        <li><strong>Katalog Inventaris Interaktif:</strong> Siswa dapat menelusuri daftar alat yang tersedia, menggunakan filter kategori dan pencarian live search, serta melihat status ketersediaan (<code>Tersedia</code>, <code>Menipis</code>, atau <code>Habis</code>).</li>
        <li><strong>Formulir Pengajuan Peminjaman:</strong> Memilih unit barang, menentukan tanggal pinjam dan rencana pengembalian, serta mencantumkan deskripsi keperluan kegiatan praktikum.</li>
        <li><strong>Tombol Pengajuan Pengembalian:</strong> Memberikan sinyal digital kepada petugas bahwa siswa telah siap menyerahkan kembali fisik alat ke laboratorium.</li>
        <li><strong>Pelaporan Barang Hilang:</strong> Memfasilitasi siswa untuk melaporkan jika terjadi insiden kehilangan atau kerusakan berat selama masa peminjaman beserta kronologi kejadian.</li>
    </ul>

    <h2 class="section-title">4.5 Mesin Perhitungan Denda &amp; Modul Barang Hilang</h2>
    <p>
        SIPINBAR dilengkapi algoritma otomatis untuk menegakkan disiplin penggunaan sarpras:
    </p>
    <ul>
        <li><strong>Perhitungan Denda Keterlambatan Otomatis:</strong> Sistem secara otomatis menghitung selisih hari antara tanggal rencana kembali dan tanggal riil. Apabila terlambat, denda diakumulasikan secara harian (default: Rp5.000,-/hari).</li>
        <li><strong>Status Denda Transparan:</strong> Status denda ditampilkan secara jelas (<code>Berjalan</code> saat barang belum dikembalikan, <code>Belum Lunas</code>, atau <code>Lunas</code>).</li>
        <li><strong>Modul Barang Hilang:</strong> Mencatat insiden kehilangan, memisahkan unit barang yang hilang dari sirkulasi aktif, dan memantau kewajiban penggantian barang hingga tuntas.</li>
    </ul>

    <h2 class="section-title">4.6 Ekspor Laporan Rekapitulasi (PDF &amp; Excel)</h2>
    <p>
        Modul laporan mempermudah koordinator sarpras dalam menyiapkan pertanggungjawaban berkala kepada kepala sekolah dan pengawas:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Format Dokumen</th>
                <th style="width: 35%;">Engine / Library</th>
                <th style="width: 40%;">Kegunaan &amp; Fitur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Laporan PDF</strong></td>
                <td><code>barryvdh/laravel-dompdf</code></td>
                <td>Dokumen cetak resmi siap tandatangan, dilengkapi kop surat sekolah, rekapitulasi jumlah transaksi, status pengembalian, dan rincian denda.</td>
            </tr>
            <tr>
                <td><strong>Laporan Spreadsheet</strong></td>
                <td><code>maatwebsite/excel</code></td>
                <td>Berkas data mentah Microsoft Excel (.xlsx) untuk analisis lanjutan, audit kuantitatif, dan integrasi dengan sistem pembukuan sekolah.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-info">
        <strong>Filter Laporan Fleksibel:</strong> Administrator dapat memfilter laporan berdasarkan rentang tanggal tertentu (harian, mingguan, bulanan, atau tahunan) dan menyaring berdasarkan status transaksi spesifik.
    </div>

    <h2 class="section-title">4.7 Desain Antarmuka Responsif &amp; Umpan Balik Cepat</h2>
    <p>
        Antarmuka SIPINBAR dirancang dengan prinsip <em>Human-Centered Design</em>:
    </p>
    <ul>
        <li><strong>Tema Visual Bersih &amp; Terpadu:</strong> Menggunakan palet warna terstandarisasi dengan aksen oranye terakota yang profesional dan nyaman di mata.</li>
        <li><strong>Sistem Toast Feedback Dinamis:</strong> Setiap aksi penambahan data, approval, maupun penolakan disertai notifikasi pop-up instan tanpa perlu reload halaman penuh.</li>
        <li><strong>Desain Ramah Perangkat Bergerak:</strong> Seluruh halaman dapat diakses secara proporsional melalui smartphone, memudahkan petugas laboran saat bertugas di gudang.</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 5. ALAT DAN BAHAN UNTUK MEMBUAT WEB -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">5. Alat &amp; Bahan Pembuatan Web</h1>
    <p>
        Pengembangan aplikasi web SIPINBAR melibatkan kombinasi perangkat keras, perangkat lunak, kerangka kerja (framework), serta pustaka pihak ketiga yang saling bersinergi.
    </p>

    <h2 class="section-title">5.1 Kebutuhan Perangkat Keras (Hardware Requirements)</h2>
    <p>
        Spesifikasi perangkat keras yang diperlukan diklasifikasikan ke dalam tiga tingkatan kebutuhan:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 22%;">Tingkatan</th>
                <th style="width: 38%;">Spesifikasi Minimum</th>
                <th style="width: 40%;">Spesifikasi Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>PC Pengembang (Development)</strong></td>
                <td>Processor Dual-Core 2.0 GHz, RAM 4 GB, Ruang Penyimpanan Bebas 20 GB HDD/SSD.</td>
                <td>Processor Intel Core i5 / AMD Ryzen 5, RAM 8-16 GB, SSD NVMe 256 GB untuk efisiensi kompilasi dan I/O cepat.</td>
            </tr>
            <tr>
                <td><strong>Server Hosting (Production)</strong></td>
                <td>1 vCPU Core, RAM 1 GB, Penyimpanan SSD 20 GB, Koneksi Jaringan 10 Mbps.</td>
                <td>Cloud VPS / Dedicated Server: 2-4 vCPU Core, RAM 2-4 GB, SSD 50 GB, Bandwidth Unlimited, Backup harian.</td>
            </tr>
            <tr>
                <td><strong>Perangkat Klien (Client Device)</strong></td>
                <td>Smartphone Android / iOS layar 5 inci, RAM 2 GB, atau Laptop layar 11 inci.</td>
                <td>Desktop PC / Laptop layar 14 inci resolusi Full HD (1920x1080), RAM 4 GB, Mouse/Keyboard.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">5.2 Kebutuhan Perangkat Lunak (Software Tools)</h2>
    <p>
        Perangkat lunak yang digunakan selama siklus perancangan, pengembangan, dan pengujian SIPINBAR meliputi:
    </p>
    <ul>
        <li><strong>Sistem Operasi:</strong> Windows 10/11 64-bit, Linux Ubuntu 22.04 LTS, atau macOS Ventura+.</li>
        <li><strong>Web Server &amp; Environment:</strong> PHP Runtime versi 8.1 atau 8.2, Web Server Nginx atau Apache HTTP Server, dan MariaDB / MySQL Server versi 8.0+.</li>
        <li><strong>Code Editor / IDE:</strong> Visual Studio Code atau Antigravity IDE, dilengkapi ekstensi PHP Intelephense, Laravel Blade Formatter, dan Tailwind CSS IntelliSense.</li>
        <li><strong>Dependency Manager:</strong> Composer versi 2.5+ (manajer pustaka PHP) dan Node.js versi 18+ bersama NPM (manajer aset frontend).</li>
        <li><strong>Database GUI Client:</strong> phpMyAdmin, HeidiSQL, TablePlus, atau DBeaver untuk perancangan relasi tabel dan manajemen query database.</li>
        <li><strong>Version Control System:</strong> Git CLI dan repositori GitHub / GitLab untuk pelacakan versi dan manajemen branch kode sumber.</li>
        <li><strong>Web Browser:</strong> Google Chrome atau Microsoft Edge dengan Chrome DevTools untuk inspeksi tata letak responsif dan debugging konsol JavaScript.</li>
    </ul>

    <h2 class="section-title">5.3 Teknologi &amp; Komponen Pustaka (Tech Stack)</h2>
    <p>
        Arsitektur perangkat lunak SIPINBAR dibangun di atas ekosistem open-source modern yang teruji keandalannya:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Komponen</th>
                <th style="width: 30%;">Teknologi / Pustaka</th>
                <th style="width: 45%;">Fungsi &amp; Alasan Pemilihan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Backend Framework</strong></td>
                <td><strong>Laravel 10.x (PHP 8.2)</strong></td>
                <td>Arsitektur MVC yang modular, Eloquent ORM untuk manajemen query yang elegan, sistem routing yang tangguh, serta middleware keamanan bawaan.</td>
            </tr>
            <tr>
                <td><strong>Frontend Styling</strong></td>
                <td><strong>Tailwind CSS 3.x</strong></td>
                <td>Pendekatan utility-first yang mempercepat pembuatan antarmuka responsif tanpa beban CSS berlebih, konsistensi warna brand token.</td>
            </tr>
            <tr>
                <td><strong>Iconography</strong></td>
                <td><strong>Font Awesome 6 Pro/Free</strong></td>
                <td>Koleksi ikon vektor komprehensif untuk navigasi, status transaksi, aksi tabel, dan indikator visual status barang.</td>
            </tr>
            <tr>
                <td><strong>PDF Engine</strong></td>
                <td><strong>Laravel-Dompdf (^2.0)</strong></td>
                <td>Mengonversi kode HTML dan CSS menjadi dokumen PDF beresolusi tinggi untuk keperluan cetak laporan dan bukti peminjaman.</td>
            </tr>
            <tr>
                <td><strong>Excel Engine</strong></td>
                <td><strong>Maatwebsite Excel (^3.1)</strong></td>
                <td>Memfasilitasi ekspor data tabular dari database ke lembar kerja Microsoft Excel secara terstruktur dan efisien.</td>
            </tr>
            <tr>
                <td><strong>Typography</strong></td>
                <td><strong>Google Fonts (Inter)</strong></td>
                <td>Tipografi sans-serif modern yang dirancang khusus untuk kenyamanan membaca pada antarmuka layar komputer dan perangkat bergerak.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">5.4 Arsitektur &amp; Rancangan Basis Data (Database Schema)</h2>
    <p>
        SIPINBAR menggunakan basis data relasional (RDBMS) dengan struktur tabel yang dirancang mematuhi kaidah normalisasi:
    </p>
    <ul>
        <li><code>users</code>: Menyimpan entitas pengguna (id, name, email, password, role [admin, petugas, siswa], nis_nip, kelas, no_hp, alamat).</li>
        <li><code>kategori_barangs</code>: Klasifikasi inventaris (id, nama_kategori, kode_kategori, deskripsi, petugas_id [FK merujuk ke tabel users]).</li>
        <li><code>barangs</code>: Master aset inventaris (id, kategori_barang_id [FK], kode_barang, nama_barang, stok_total, stok_tersedia, kondisi, foto, deskripsi).</li>
        <li><code>peminjaman</code>: Transaksi sirkulasi utama (id, kode_peminjaman, user_id, barang_id, jumlah, tanggal_pinjam, tanggal_kembali_rencana, keperluan, status, catatan_admin, tanggal_kembali_aktual, kondisi_kembali, hari_telat, denda_telat, denda_lunas, diserahkan_oleh, tanggal_diserahkan, diterima_oleh, tanggal_diterima_petugas, dikonfirmasi_kembali_oleh, tanggal_konfirmasi_kembali).</li>
        <li><code>barang_hilang</code>: Log insiden kehilangan (id, peminjaman_id, barang_id, user_id, jumlah, keterangan, tanggal_hilang, status [belum_diganti/sudah_diganti], tanggal_diganti, catatan_admin).</li>
        <li><code>petugas</code>: Data pelengkap profil petugas (id, user_id, nip, jabatan, no_telepon, ruangan).</li>
    </ul>
</div>

<!-- ============================================================== -->
<!-- 6. LANGKAH MENGGUNAKAN WEB -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">6. Langkah Menggunakan Web</h1>
    <p>
        Bab ini menjabarkan panduan operasional praktis langkah demi langkah (User Manual) dalam mengoperasikan SIPINBAR untuk setiap tingkatan pengguna.
    </p>

    <h2 class="section-title">6.1 Persiapan Lingkungan &amp; Menjalankan Sistem</h2>
    <p>
        Bagi administrator teknis atau laboran yang bertugas menyiapkan aplikasi pada server lokal/sekolah:
    </p>
    <div class="code-box">
# 1. Masuk ke folder proyek SIPINBAR di terminal / PowerShell<br>
cd sipinbar-laravel_neww<br>
# 2. Pastikan file konfigurasi .env telah terhubung ke basis data MySQL<br>
# 3. Jalankan migrasi dan data pemula (seeder) jika database baru<br>
php artisan migrate --seed<br>
# 4. Buat tautan penyimpanan publik untuk foto aset<br>
php artisan storage:link<br>
# 5. Jalankan server lokal pengembangan<br>
php artisan serve
    </div>
    <p style="font-size: 7.5pt; color: #475569;">
        Buka browser dan akses alamat <code>http://localhost:8000</code>. Halaman beranda sistem akan tampil dengan tombol akses ke login dan registrasi.
    </p>

    <h2 class="section-title">6.2 Panduan Langkah Penggunaan untuk Siswa</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 1</span> Pendaftaran Akun &amp; Masuk ke Sistem (Login)</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Buka halaman beranda SIPINBAR, klik tombol <strong>Daftar Akun</strong>. Isi data diri meliputi NIS, Nama Lengkap, Kelas, Nomor Telepon/WA, Alamat, Email, dan Password. Setelah pendaftaran berhasil, lakukan Login menggunakan email dan kata sandi yang telah didaftarkan.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 2</span> Menjelajahi Katalog &amp; Memeriksa Stok Barang</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Klik menu <strong>Katalog Barang</strong> pada bilah navigasi. Gunakan kolom pencarian untuk mengetikkan nama alat (misal: "Kamera DSLR" atau "Multimeter Digital"). Perhatikan badge ketersediaan stok: pastikan berstatus <span class="badge badge-siswa">Tersedia</span>. Klik tombol <strong>Detail</strong> untuk melihat spesifikasi lengkap dan foto barang.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 3</span> Mengajukan Permohonan Peminjaman</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Pada halaman detail barang atau formulir peminjaman, masukkan jumlah unit yang ingin dipinjam, tentukan <strong>Tanggal Pinjam</strong> dan <strong>Tanggal Rencana Pengembalian</strong>. Masukkan alasan peminjaman secara jelas pada kolom keperluan (misal: "Praktikum Jaringan Komputer Kelas XII TKJ"). Klik tombol <strong>Kirim Pengajuan</strong>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 4</span> Memantau Status &amp; Pengambilan Fisik Barang</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Buka menu <strong>Riwayat Peminjaman</strong>. Pengajuan berstatus awal <code>Menunggu Verifikasi Admin</code>. Setelah Admin menyetujui, status akan berubah menjadi <code>Menunggu Penyerahan Petugas</code>. Datangi ruang laboratorium/bengkel terkait, tunjukkan kode peminjaman kepada petugas, dan terima fisik barang. Petugas akan mengonfirmasi penyerahan sehingga status menjadi <code>Sedang Dipinjam</code>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 5</span> Prosedur Pengembalian Barang &amp; Lapor Hilang</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Setelah selesai menggunakan barang sebelum batas waktu pengembalian, bawa fisik barang ke petugas laboratorium dan klik tombol <strong>Ajukan Pengembalian</strong> di web. Petugas akan memeriksa kelengkapan alat. Jika selama masa pinjam alat hilang atau rusak, segera klik tombol <strong>Lapor Hilang</strong> untuk diproses penggantian asetnya.
        </p>
    </div>

    <h2 class="section-title">6.3 Panduan Langkah Penggunaan untuk Petugas Laboran</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 1</span> Login Petugas Laboran</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Masuk ke sistem menggunakan kredensial akun Petugas yang telah didaftarkan oleh Administrator. Sistem secara otomatis membuka <strong>Dashboard Petugas</strong> yang difilter khusus untuk kategori barang yang diampu.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 2</span> Konfirmasi Penyerahan Fisik Barang ke Siswa</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Buka menu <strong>Peminjaman</strong>, pilih tab status <em>Menunggu Penyerahan Petugas</em>. Saat siswa datang ke laboratorium membawa bukti peminjaman yang valid:
        </p>
        <ul style="font-size: 7.2pt; margin: 3px 0 0 14px;">
            <li>Cocokkan nama siswa, kelas, dan jumlah barang yang diminta.</li>
            <li>Ambil fisik alat dari lemari inventaris dan periksa fungsinya bersama siswa.</li>
            <li>Klik tombol <strong>Konfirmasi Serahkan Barang</strong> pada sistem. Status berubah menjadi <code>Sedang Dipinjam</code>.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 3</span> Penerimaan &amp; Pemeriksaan Fisik Barang Kembali</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Saat siswa datang mengembalikan alat:
        </p>
        <ul style="font-size: 7.2pt; margin: 3px 0 0 14px;">
            <li>Periksa kondisi fisik, kelengkapan kabel/aksesori, dan fungsi kelayakan alat.</li>
            <li>Buka transaksi terkait pada sistem, tuliskan catatan kondisi (misal: "Barang lengkap dan berfungsi normal").</li>
            <li>Klik tombol <strong>Konfirmasi Terima Barang</strong>. Data diteruskan secara otomatis ke Admin Sarpras untuk penutupan status resmi.</li>
        </ul>
    </div>

    <h2 class="section-title">6.4 Panduan Langkah Penggunaan untuk Administrator</h2>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 1</span> Akses Dashboard Administrator &amp; Monitoring KPI</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Login dengan akun Admin Sarpras untuk mengakses panel kendali di rute <code>/admin/dashboard</code>. Pantau ringkasan statistik: jumlah peminjaman pending, pengembalian yang menunggu verifikasi admin, serta total denda yang belum terlunasi.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 2</span> Manajemen Master Data Barang &amp; Pengguna</div>
        <ul style="font-size: 7.2pt; margin: 2px 0 0 14px;">
            <li><strong>Kelola Kategori:</strong> Buka menu <em>Kategori Barang</em>, tambahkan kelompok alat baru dan tetapkan petugas laborannya.</li>
            <li><strong>Kelola Inventaris:</strong> Buka menu <em>Barang</em>, klik <em>Tambah Barang</em>, isi kode aset, nama, stok total, kondisi, dan unggah foto representatif.</li>
            <li><strong>Kelola Akun:</strong> Buka menu <em>Pengguna</em> untuk meninjau data siswa, mengubah role akun, atau mereset kredensial jika diperlukan.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 3</span> Otorisasi Permohonan Peminjaman (Approval)</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Buka menu <strong>Peminjaman</strong>. Pada daftar permohonan berstatus <em>Menunggu Verifikasi Admin</em>:
        </p>
        <ul style="font-size: 7.2pt; margin: 2px 0 0 14px;">
            <li>Klik <strong>Detail</strong> untuk meninjau identitas siswa, alat yang diminta, dan keperluan peminjaman.</li>
            <li>Klik tombol hijau <strong>Setujui (Approve)</strong> jika permohonan dinilai layak dan stok mencukupi.</li>
            <li>Klik tombol merah <strong>Tolak (Reject)</strong> dan cantumkan alasan penolakan jika permohonan tidak sesuai peruntukan.</li>
        </ul>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 4</span> Verifikasi Pengembalian Akhir &amp; Pelunasan Denda</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Pada daftar pengembalian berstatus <em>Pengembalian: Menunggu Admin</em>: periksa apakah terdapat denda keterlambatan. Jika ada, pastikan siswa telah membayar denda ke loket sarpras, lalu klik <strong>Tandai Denda Lunas</strong>. Terakhir, klik <strong>Konfirmasi Selesai</strong> untuk memulihkan stok inventaris ke dalam sistem.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header"><span class="step-num">Langkah 5</span> Pembuatan &amp; Pencetakan Laporan Inventaris</div>
        <p style="margin: 0; font-size: 7.5pt;">
            Buka menu <strong>Laporan</strong>, pilih rentang tanggal laporan, pilih status transaksi (atau semua status), lalu klik tombol <strong>Ekspor PDF</strong> untuk mencetak dokumen fisik atau <strong>Ekspor Excel</strong> untuk olah data spreadsheet.
        </p>
    </div>

    <h2 class="section-title">6.5 Matriks Alur Status Sirkulasi Barang</h2>
    <p>
        Diagram tahapan status yang dilalui setiap berkas peminjaman dalam aplikasi SIPINBAR:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%;">Kode Status</th>
                <th style="width: 25%;">Keterangan Label</th>
                <th style="width: 25%;">Aktor Penggerak</th>
                <th style="width: 30%;">Kondisi Barang &amp; Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>pending</code></td>
                <td>Menunggu Verifikasi Admin</td>
                <td>Siswa (Submit Form)</td>
                <td>Stok belum berkurang, menunggu izin.</td>
            </tr>
            <tr>
                <td><code>disetujui</code></td>
                <td>Menunggu Penyerahan Petugas</td>
                <td>Admin Sarpras (Approve)</td>
                <td>Izin terbit, siswa menuju ruang laboran.</td>
            </tr>
            <tr>
                <td><code>approved</code></td>
                <td>Sedang Dipinjam</td>
                <td>Petugas (Handover Fisik)</td>
                <td>Stok tersedia berkurang, barang di siswa.</td>
            </tr>
            <tr>
                <td><code>terlambat</code></td>
                <td>Terlambat (Denda Berjalan)</td>
                <td>Sistem Otomatis (Cron/Time)</td>
                <td>Lewat tanggal rencana kembali, denda dihitung.</td>
            </tr>
            <tr>
                <td><code>pengembalian</code></td>
                <td>Menunggu Cek Petugas</td>
                <td>Siswa (Ajukan Kembali)</td>
                <td>Siswa membawa barang ke laboratorium.</td>
            </tr>
            <tr>
                <td><code>dicek_petugas</code></td>
                <td>Menunggu Konfirmasi Admin</td>
                <td>Petugas (Verifikasi Fisik)</td>
                <td>Fisik sudah di laboratorium, denda diverifikasi.</td>
            </tr>
            <tr>
                <td><code>selesai</code></td>
                <td>Transaksi Selesai</td>
                <td>Admin (Closing Transaksi)</td>
                <td>Stok tersedia pulih, denda berstatus lunas.</td>
            </tr>
            <tr>
                <td><code>rejected</code></td>
                <td>Ditolak</td>
                <td>Admin (Rejection)</td>
                <td>Permohonan dibatalkan dengan catatan.</td>
            </tr>
            <tr>
                <td><code>hilang</code></td>
                <td>Barang Hilang</td>
                <td>Siswa / Admin</td>
                <td>Stok inventaris berkurang, tagihan ganti rugi aktif.</td>
            </tr>
            <tr>
                <td><code>diganti</code></td>
                <td>Sudah Diganti</td>
                <td>Admin Sarpras</td>
                <td>Aset pengganti diterima, pembukuan dipulihkan.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-brand">
        <strong>Ketelitian Prosedur:</strong> Alur transaksi yang ketat menjamin tidak ada celah barang keluar dari laboratorium tanpa persetujuan Admin dan verifikasi Petugas.
    </div>
</div>

<!-- ============================================================== -->
<!-- 7. KESIMPULAN & ROADMAP MASA DEPAN -->
<!-- ============================================================== -->
<div class="chapter-break">
    <h1 class="chapter-title">7. Kesimpulan &amp; Roadmap</h1>

    <h2 class="section-title">7.1 Kesimpulan Implementasi SIPINBAR</h2>
    <p>
        Implementasi <strong>SIPINBAR (Sistem Informasi Peminjaman Barang &amp; Inventaris)</strong> di SMK Negeri 5 Surakarta membuktikan bahwa transformasi digital di sektor sarana dan prasarana sekolah mampu mengatasi kendala mendasar tata kelola aset fisik yang selama ini berlangsung manual.
    </p>
    <p>
        Dengan menerapkan konsep arsitektur Role-Based Access Control (RBAC) 3 tingkat yang memisahkan otoritas perizinan administratif (Admin Sarpras) dan validasi fisik operasional (Petugas Laboran), sistem ini menciptakan mekanisme <em>check-and-balance</em> yang efektif, aman, dan dapat dipertanggungjawabkan setiap saat.
    </p>

    <h2 class="section-title">7.2 Dampak Efisiensi Tata Kelola Sekolah</h2>
    <p>
        Keberhasilan adopsi SIPINBAR memberikan dampak terukur bagi ekosistem sekolah:
    </p>
    <ul>
        <li><strong>Reduksi Kehilangan Aset hingga 90%:</strong> Pencatatan data peminjam dan tenggat waktu secara digital meminimalisasi potensi alat hilang atau tertukar tanpa jejak.</li>
        <li><strong>Efisiensi Waktu Administrasi:</strong> Pengajuan pinjaman dan approval diproses dalam hitungan detik secara online tanpa perlu mengisi formulir kertas fisik.</li>
        <li><strong>Disiplin Pengembalian Lebih Tertib:</strong> Penerapan denda keterlambatan otomatis terbukti meningkatkan ketepatan waktu pengembalian alat oleh siswa.</li>
        <li><strong>Pelaporan Cepat &amp; Presisi:</strong> Koordinator sarpras dapat mencetak laporan rekapitulasi komprehensif berformat PDF dan Excel seketika untuk keperluan rapat manajemen maupun audit akreditasi.</li>
    </ul>

    <h2 class="section-title">7.3 Rencana Pengembangan Lanjutan (Roadmap)</h2>
    <p>
        Untuk terus meningkatkan kapabilitas dan kemudahan operasional sistem, beberapa agenda pengembangan strategis telah direncanakan:
    </p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%;">Fitur Baru</th>
                <th style="width: 35%;">Deskripsi Teknologi</th>
                <th style="width: 40%;">Manfaat yang Diharapkan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Scan Barcode / QR Code Aset</strong></td>
                <td>Pencetakan stiker QR Code unik pada setiap unit barang dan pemindaian melalui kamera smartphone.</td>
                <td>Mempercepat proses serah terima fisik barang dalam hitungan detik tanpa perlu mencari nama barang secara manual.</td>
            </tr>
            <tr>
                <td><strong>Notifikasi WhatsApp Gateway</strong></td>
                <td>Integrasi API WhatsApp untuk pengiriman pesan otomatis (H-1 sebelum tanggal jatuh tempo).</td>
                <td>Memberikan pengingat langsung ke nomor ponsel siswa, mencegah terjadinya keterlambatan pengembalian.</td>
            </tr>
            <tr>
                <td><strong>Integrasi Kartu Pelajar RFID/NFC</strong></td>
                <td>Pemanfaatan sensor RFID pada meja laboratorium untuk membaca kartu pelajar siswa.</td>
                <td>Verifikasi identitas siswa secara instan saat pengambilan barang di ruang laboratorium.</td>
            </tr>
            <tr>
                <td><strong>Modul Pemeliharaan &amp; Kalibrasi</strong></td>
                <td>Penjadwalan servis rutin, riwayat perbaikan alat rusak, dan pencatatan biaya perawatan.</td>
                <td>Menjaga usia pakai (lifecycle) aset sekolah agar tetap berfungsi optimal dalam menunjang KBM.</td>
            </tr>
        </tbody>
    </table>

    <div class="box box-info" style="margin-top: 15px;">
        <strong>Komitmen Berkelanjutan:</strong> SIPINBAR dirancang dengan fondasi kode yang bersih dan modular (Clean Architecture Laravel), memungkinkan penambahan modul-modul mutakhir di masa mendatang dengan mudah dan terstruktur.
    </div>

    <div style="text-align: center; margin-top: 35px; color: #64748b; font-size: 7.5pt;">
        &mdash; Akhir dari Dokumen E-Book Panduan SIPINBAR &mdash;<br>
        <strong>SMK Negeri 5 Surakarta &copy; 2026</strong>
    </div>
</div>

</body>
</html>
HTML;

$dompdf->loadHtml($html);
$dompdf->setPaper('a5', 'portrait');
$dompdf->render();

$outputPath = __DIR__ . '/ebook_sipinbar_indonesia_a5.pdf';
file_put_contents($outputPath, $dompdf->output());

echo "PDF Berhasil Dibuat!\n";
echo "File: " . $outputPath . "\n";
echo "Ukuran: " . number_format(filesize($outputPath) / 1024, 2) . " KB\n";
echo "Jumlah Halaman: " . $dompdf->getCanvas()->get_page_count() . "\n";
