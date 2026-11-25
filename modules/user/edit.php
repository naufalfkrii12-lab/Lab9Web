<?php
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    setFlash('gagal', 'ID pengguna tidak valid.');
    redirect('user/list');
}

$pdo = getConnection();
$stmt = $pdo->prepare('SELECT id, nama, email FROM users WHERE id = :id');
$stmt->execute([':id' => $id]);
$user = $stmt->fetch();
if (!$user) {
    setFlash('gagal', 'Pengguna tidak ditemukan.');
    redirect('user/list');
}

$nama  = $user['nama'];
$email = $user['email'];
$galat = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $galat[] = 'Token keamanan tidak valid. Muat ulang halaman.';
    } else {
        $nama  = trim((string) ($_POST['nama'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));

        if ($nama === '' || mb_strlen($nama) > 100) $galat[] = 'Nama wajib diisi (maksimal 100 karakter).';
        if (!validasiEmail($email) || mb_strlen($email) > 100) $galat[] = 'Email tidak valid.';

        if (!$galat) {
            try {
                $upd = $pdo->prepare('UPDATE users SET nama = :nama, email = :email WHERE id = :id');
                $upd->execute([':nama' => $nama, ':email' => $email, ':id' => $id]);
                setFlash('sukses', 'Data pengguna berhasil diperbarui.');
                redirect('user/list');
            } catch (PDOException $ex) {
                if ($ex->getCode() === '23000') {
                    $galat[] = 'Email sudah dipakai pengguna lain.';
                } else {
                    error_log($ex->getMessage());
                    $galat[] = 'Gagal memperbarui data.';
                }
            }
        }
    }
}
?>
<section class="content">
    <h2>Ubah Pengguna</h2>
    <?php foreach ($galat as $g): ?>
        <div class="alert alert-error"><?= e($g) ?></div>
    <?php endforeach; ?>
    <form method="post" action="<?= e(url('user/edit', ['id' => $id])) ?>">
        <?= csrfField() ?>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($nama) ?>" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="100" value="<?= e($email) ?>" required>
        <button type="submit">Perbarui</button>
        <a class="btn btn-secondary" href="<?= e(url('user/list')) ?>">Batal</a>
    </form>
</section>
