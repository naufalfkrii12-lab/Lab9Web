<?php
$pdo = getConnection();
try {
    $users = $pdo->query('SELECT id, nama, email, created_at FROM users ORDER BY id DESC')->fetchAll();
} catch (PDOException $ex) {
    error_log($ex->getMessage());
    $users = [];
    echo '<div class="alert alert-error">Tabel users belum tersedia. Impor database.sql terlebih dahulu.</div>';
}
?>
<section class="content">
    <h2>Data Pengguna</h2>
    <p><a class="btn" href="<?= e(url('user/add')) ?>">+ Tambah Pengguna</a></p>
    <div class="table-wrap">
    <table class="data">
        <thead>
            <tr><th>No</th><th>Nama</th><th>Email</th><th>Dibuat</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php if (!$users): ?>
            <tr><td colspan="5">Belum ada data pengguna.</td></tr>
        <?php endif; ?>
        <?php foreach ($users as $i => $u): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= e($u['nama']) ?></td>
                <td><?= e($u['email']) ?></td>
                <td><?= e($u['created_at']) ?></td>
                <td class="aksi">
                    <a class="btn btn-small" href="<?= e(url('user/edit', ['id' => $u['id']])) ?>">Ubah</a>
                    <form method="post" action="<?= e(url('user/delete')) ?>" class="inline"
                          onsubmit="return confirm('Hapus pengguna ini?');">
                        <?= csrfField() ?>
                        <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                        <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>
