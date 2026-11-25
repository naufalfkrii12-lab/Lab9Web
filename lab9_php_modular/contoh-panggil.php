<?php
require_once __DIR__ . '/helpers.php';
echo formatRupiah(150000) . "<br>";
echo e('<script>alert("uji")</script>') . "<br>";
tampilkanSalam(); echo "<br>";
sapaPengguna("Rina"); echo "<br>";
echo "Luas: " . hitungLuasPersegiPanjang(8, 5) . "<br>";
echo "Diskon 10%: " . formatRupiah(hitungDiskon(200000)) . "<br>";
echo "Diskon 15%: " . formatRupiah(hitungDiskon(200000, 15)) . "<br>";
