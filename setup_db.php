<?php
// Membuat database (jika belum ada) berdasarkan isi .env. Dipakai oleh run.bat
$env = [];
foreach (file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if ($line[0] === '#' || strpos($line, '=') === false) continue;
    [$k, $v] = explode('=', $line, 2);
    $env[trim($k)] = trim($v, " \t\"'");
}
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$name = $env['DB_DATABASE'] ?? 'sipinbar';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$name' siap.\n";
} catch (Throwable $e) {
    echo "GAGAL konek ke MySQL ($host:$port): ".$e->getMessage()."\n";
    echo "=> Pastikan MySQL sudah di-Start (XAMPP/Laragon) dan DB_PORT/DB_USERNAME/DB_PASSWORD di file .env benar.\n";
    exit(1);
}
