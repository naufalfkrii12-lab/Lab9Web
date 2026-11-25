<?php
// Penghapusan hanya lewat POST + token CSRF (bukan lewat URL GET).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    setFlash('gagal', 'Penghapusan hanya dapat dilakukan melalui tombol Hapus.');
    redirect('user/list');
}
if (!csrfValid()) {
    setFlash('gagal', 'Token keamanan tidak valid.');
    redirect('user/list');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    setFlash('gagal', 'ID pengguna tidak valid.');
    redirect('user/list');
}

try {
    $stmt = getConnection()->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    if ($stmt->rowCount() > 0) {
        setFlash('sukses', 'Pengguna berhasil dihapus.');
    } else {
        setFlash('gagal', 'Pengguna tidak ditemukan.');
    }
} catch (PDOException $ex) {
    error_log($ex->getMessage());
    setFlash('gagal', 'Gagal menghapus data.');
}
redirect('user/list');
