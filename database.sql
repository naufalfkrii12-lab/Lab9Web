-- Database untuk Praktikum 9 PHP Modular (Naufal Fikri - 312510350)
CREATE DATABASE IF NOT EXISTS db_latihan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_latihan;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (nama, email) VALUES
('Naufal Fikri', 'naufal.fikri@example.com'),
('Rina Putri', 'rina@example.com'),
('Budi Santoso', 'budi@example.com');
