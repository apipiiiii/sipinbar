@echo off
title SIPINBAR
cd /d "%~dp0"
echo ==============================================
echo   SIPINBAR - setup otomatis dan jalankan server
echo ==============================================
echo.

where php >nul 2>nul
if errorlevel 1 goto nophp

echo [1/5] Menyiapkan database...
php setup_db.php
if errorlevel 1 goto gagal

echo.
echo [2/5] Membersihkan cache...
php artisan config:clear >nul
php artisan view:clear >nul

echo [3/5] Migrasi tabel...
php artisan migrate --force
if errorlevel 1 goto gagal

echo.
echo [4/5] Data awal...
php seed_if_empty.php
if errorlevel 1 goto gagal

echo.
echo [5/5] Menjalankan server...
php artisan storage:link >nul 2>nul
echo.
echo Buka: http://127.0.0.1:8000/login
echo   Admin : admin@sipinbar.sch.id / admin123
echo   Petugas: petugas.lab@sipinbar.sch.id / petugas123
echo   Siswa : rafif.bari@siswa.sipinbar.sch.id / siswa123
echo Tekan Ctrl+C untuk menghentikan server.
echo.
start "" http://127.0.0.1:8000/login
php artisan serve
goto selesai

:nophp
echo PHP tidak ditemukan. Jalankan file ini dari terminal XAMPP/Laragon,
echo atau tambahkan folder php ke PATH Windows.
goto selesai

:gagal
echo.
echo Ada langkah yang GAGAL. Baca pesan error di atas.

:selesai
pause
