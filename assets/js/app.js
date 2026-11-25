// Placeholder JavaScript aplikasi (Praktikum 9 - PHP Modular).
// Hilangkan otomatis pesan flash setelah 5 detik.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.alert-success').forEach(function (el) {
        setTimeout(function () { el.style.display = 'none'; }, 5000);
    });
});
