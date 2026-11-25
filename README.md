# Lab9Web - Praktikum 9: PHP Modular

| | |
|---|---|
| **Nama** | Naufal Fikri |
| **NIM** | 312510350 |
| **Mata Kuliah** | Pemrograman Web |
| **Topik** | Modularisasi Program, Function, Template, dan Routing |

## Tujuan Project
Menerapkan modularisasi pada aplikasi PHP: template bersama (header/footer), function helper,
struktur direktori berdasarkan tanggung jawab, serta routing sederhana berbasis whitelist
yang diintegrasikan dengan aplikasi CRUD database (tabel `users`).

## Kebutuhan Perangkat
- PHP 8.0 atau lebih baru (ekstensi PDO MySQL aktif)
- MySQL / MariaDB
- Web server lokal Apache (XAMPP / Laragon) atau `php -S`
- Browser dan Visual Studio Code



## Struktur Direktori
```
Lab9Web/
├── index.php                  # titik masuk + router (whitelist)
├── .htaccess                  # URL rewrite (opsional)
├── database.sql               # skema & data awal
├── config/
│   └── database.php           # satu-satunya konfigurasi koneksi (PDO)
├── views/
│   ├── header.php  footer.php # template bersama
│   ├── dashboard.php  profil.php  kontak.php
│   ├── latihan_function.php   # demo function
│   └── 404.php
├── helpers/
│   └── functions.php          # function umum (e, formatRupiah, hitungDiskon, validasiEmail, ringkasTeks, CSRF, flash, dll.)
├── modules/
│   ├── user/ list.php add.php edit.php delete.php
│   └── auth/                  # disiapkan untuk materi autentikasi
├── assets/ css/ js/
├── lab9_php_modular/          # latihan bagian C - E (include, template, function)
└── screenshots/               # tempat screenshot laporan
```

## Daftar Rute
| Rute (`?page=`) | File | Keterangan |
|---|---|---|
| `dashboard` (default) | views/dashboard.php | Ringkasan data |
| `profil` | views/profil.php | Profil mahasiswa |
| `kontak` | views/kontak.php | Form kontak + validasi |
| `latihan/function` | views/latihan_function.php | Demo function helper |
| `user/list` | modules/user/list.php | Daftar pengguna |
| `user/add` | modules/user/add.php | Tambah pengguna |
| `user/edit&id=N` | modules/user/edit.php | Ubah pengguna |
| `user/delete` | modules/user/delete.php | Hapus (hanya POST + CSRF) |
| *lainnya* | views/404.php | Status HTTP 404 |

Dengan `.htaccess` aktif, `/Lab9Web/user/list` juga diteruskan ke `index.php?page=user/list`.

## Fitur Keamanan
- Router memakai **whitelist**; input `page` tidak pernah digabung langsung menjadi path file.
- Query memakai **prepared statements** PDO.
- Output di-escape dengan `e()` (htmlspecialchars).
- Tambah/ubah/hapus lewat **POST** dengan **token CSRF**.
- Detail error koneksi database hanya masuk ke log, tidak ditampilkan ke pengguna.

## Langkah Praktikum (ringkas)
1. Uji `include` vs `require` (`lab9_php_modular/uji-include.php`, `uji-require.php`).
2. Membuat template `header.php`/`footer.php` dan halaman `home`, `about`, `kontak`.
3. Membuat function (parameter, return, type declaration, nilai default) dan memindahkannya ke `helpers.php`.
4. Menyusun struktur direktori modular (bagian F).
5. Membuat router whitelist + halaman 404 (bagian G).
6. Menambahkan `.htaccess` (bagian H, opsional).
7. Refactor CRUD pengguna ke `modules/user/` dengan koneksi tunggal di `config/` (bagian I).
8. Tantangan mandiri: menu aktif, helper flash message, URL rewrite.

## Kendala dan Solusi
| Kendala | Solusi |
|---|---|
| `Failed opening required` | Gunakan `__DIR__` untuk membentuk path file. |
| `Cannot redeclare function` | Muat file function dengan `require_once`. |
| CSS tidak tampil saat memakai URL rewrite | Path aset dibuat absolut lewat function `asset()`. |
| Redirect setelah POST gagal (headers already sent) | Gunakan output buffering `ob_start()` di `index.php`. |
| URL rewrite tidak bekerja | Aktifkan `mod_rewrite` dan `AllowOverride All` pada Apache. |
