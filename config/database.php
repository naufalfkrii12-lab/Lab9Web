<?php
/**
 * config/database.php - satu-satunya tempat konfigurasi koneksi database.
 * Koneksi dibuat saat dibutuhkan lewat getConnection() (PDO).
 */
const DB_HOST = 'localhost';
const DB_NAME = 'db_latihan';
const DB_USER = 'root';
const DB_PASS = '';

function getConnection(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    } catch (PDOException $e) {
        // Detail error tidak ditampilkan kepada pengguna
        error_log($e->getMessage());
        http_response_code(500);
        exit('Terjadi kesalahan pada koneksi database. Pastikan MySQL aktif dan database.sql sudah diimpor.');
    }
    return $pdo;
}
