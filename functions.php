<?php
/**
 * helpers/functions.php - kumpulan function umum yang dipakai banyak modul.
 */

/* ---------- Fallback jika ekstensi mbstring tidak aktif ---------- */

if (!function_exists('mb_strlen')) {
    function mb_strlen(string $s): int { return strlen(utf8_decode($s)); }
}
if (!function_exists('mb_substr')) {
    function mb_substr(string $s, int $start, ?int $len = null): string { return substr($s, $start, $len ?? strlen($s)); }
}

/* ---------- Escaping & format ---------- */

function e(?string $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

function validasiEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $batas = 50): string
{
    $teks = trim($teks);
    if (mb_strlen($teks) <= $batas) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $batas)) . '...';
}

/* ---------- Latihan function (bagian E) ---------- */

function konversiCelciusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

function tentukanStatusNilai(float $nilai): string
{
    if ($nilai >= 85) return 'A (Sangat Baik)';
    if ($nilai >= 70) return 'B (Baik)';
    if ($nilai >= 55) return 'C (Cukup)';
    if ($nilai >= 40) return 'D (Kurang)';
    return 'E (Gagal)';
}

/* ---------- URL & routing ---------- */

function base_path(): string
{
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    return rtrim($dir, '/');
}

function url(string $page = '', array $params = []): string
{
    $url = base_path() . '/index.php';
    $query = [];
    if ($page !== '') {
        $query['page'] = $page;
    }
    $query = array_merge($query, $params);
    if ($query) {
        $url .= '?' . str_replace('%2F', '/', http_build_query($query));
    }
    return $url;
}

function asset(string $path): string
{
    return base_path() . '/assets/' . ltrim($path, '/');
}

function redirect(string $page, array $params = []): void
{
    header('Location: ' . url($page, $params));
    exit;
}

/** Menu aktif: true jika rute saat ini diawali $prefix */
function isActive(string $prefix): string
{
    global $page;
    $page = $page ?? '';
    return (strpos($page, $prefix) === 0) ? 'active' : '';
}

/* ---------- Flash message ---------- */

function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilkanFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $kelas = $f['tipe'] === 'sukses' ? 'alert-success' : 'alert-error';
        echo '<div class="alert ' . $kelas . '">' . e($f['pesan']) . '</div>';
    }
}

/* ---------- CSRF ---------- */

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

function csrfValid(): bool
{
    $kirim = $_POST['csrf'] ?? '';
    return is_string($kirim) && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $kirim);
}
