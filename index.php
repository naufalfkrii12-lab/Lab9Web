<?php
/**
 * index.php - Titik masuk aplikasi + router sederhana (whitelist).
 * Praktikum 9 PHP Modular | Naufal Fikri | NIM 312510350
 */
ob_start();            // buffer output agar redirect setelah POST tetap bisa dilakukan
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

// Daftar rute yang diizinkan (whitelist): 'nama-rute' => file yang dimuat
$routes = [
    'dashboard'         => __DIR__ . '/views/dashboard.php',
    'profil'            => __DIR__ . '/views/profil.php',
    'kontak'            => __DIR__ . '/views/kontak.php',
    'latihan/function'  => __DIR__ . '/views/latihan_function.php',
    'user/list'         => __DIR__ . '/modules/user/list.php',
    'user/add'          => __DIR__ . '/modules/user/add.php',
    'user/edit'         => __DIR__ . '/modules/user/edit.php',
    'user/delete'       => __DIR__ . '/modules/user/delete.php',
];

// Judul halaman untuk setiap rute
$titles = [
    'dashboard'        => 'Dashboard',
    'profil'           => 'Profil',
    'kontak'           => 'Kontak',
    'latihan/function' => 'Latihan Function',
    'user/list'        => 'Data Pengguna',
    'user/add'         => 'Tambah Pengguna',
    'user/edit'        => 'Ubah Pengguna',
    'user/delete'      => 'Hapus Pengguna',
    '404'              => 'Halaman Tidak Ditemukan',
];

$page = $_GET['page'] ?? 'dashboard';
if (is_string($page) && trim($page) === '') {
    $page = 'dashboard';           // parameter kosong -> dashboard
}

// Validasi: harus string dan terdaftar pada whitelist
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page = '404';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

$pageTitle = $titles[$page] ?? 'Aplikasi';

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';
ob_end_flush();
