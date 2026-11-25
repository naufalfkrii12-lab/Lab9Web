<?php
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function e(string $nilai): string
{
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

function tampilkanSalam() {
    echo "Selamat belajar PHP modular!";
}

function sapaPengguna($nama) {
    echo "Halo, " . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
}

function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}

function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

// ----- Latihan function -----
function konversiCelciusKeFahrenheit($c) {
    return ($c * 9 / 5) + 32;
}

function tentukanStatusNilai($nilai) {
    if ($nilai >= 85) return 'A';
    if ($nilai >= 70) return 'B';
    if ($nilai >= 55) return 'C';
    if ($nilai >= 40) return 'D';
    return 'E';
}

function hitungTotal($harga, $jumlah) {
    return $harga * $jumlah;
}
