<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';
?>
<section class="content">
    <h2>Latihan Function</h2>
    <ul>
        <li>36,5 &deg;C = <?php echo konversiCelciusKeFahrenheit(36.5); ?> &deg;F</li>
        <li>Nilai 88 = predikat <?php echo tentukanStatusNilai(88); ?></li>
        <li>Total belanja 4 x Rp 25.000 = <?php echo formatRupiah(hitungTotal(25000, 4)); ?></li>
    </ul>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
