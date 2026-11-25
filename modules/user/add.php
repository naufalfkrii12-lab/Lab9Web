<?php
$nama = $email = '';
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
                $stmt = getConnection()->prepare('INSERT INTO users (nama, email) VALUES (:nama, :email)');
                $stmt->execute([':nama' => $nama, ':email' => $email]);
                setFlash('sukses', 'Pengguna berhasil ditambahkan.');
                redirect('user/list');
            } catch (PDOException $ex) {
                if ($ex->getCode() === '23000') {
                    $galat[] = 'Email sudah terdaftar.';
                } else {
                    error_log($ex->getMessage());
                    $galat[] = 'Gagal menyimpan data.';
                }
            }
        }
    }
}
?>
<section class="content">
    <h2>Tambah Pengguna</h2>
    <?php foreach ($galat as $g): ?>
        <div class="alert alert-error"><?= e($g) ?></div>
    <?php endforeach; ?>
    <form method="post" action="<?= e(url('user/add')) ?>">
        <?= csrfField() ?>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($nama) ?>" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="100" value="<?= e($email) ?>" required>
        <button type="submit">Simpan</button>
        <a class="btn btn-secondary" href="<?= e(url('user/list')) ?>">Batal</a>
    </form>
</section>
