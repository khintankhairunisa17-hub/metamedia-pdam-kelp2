# Sistem Informasi Rekening Air PDAM Zernih

Project PHP, JavaScript AJAX/JSON, dan MySQL untuk mengelola rekening air pelanggan PDAM.

## Fitur

- Login dan logout
- Dashboard ringkasan pendapatan
- CRUD data pelanggan
- Input meter air bulanan
- Hitung otomatis pemakaian dan tagihan
- Searching dan pagination tagihan
- Cetak rekening per pelanggan per bulan
- Cetak laporan pendapatan per periode
- Cetak laporan pendapatan per tahun
- Cetak laporan pendapatan tertinggi
- Grafik pendapatan bulanan

## Instalasi

1. Salin folder project ini ke direktori `htdocs`.
2. Buat database MySQL bernama `pdam_zernih`.
3. Import file `database/pdam_zernih.sql` melalui phpMyAdmin atau MySQL CLI.
4. Sesuaikan koneksi database di `config/database.php` jika diperlukan.
5. Buka `http://localhost/REKENING%20AIR%20PDAM/` di browser.

## Akun Login

- Username: `admin`
- Password: `admin123`

## Struktur

- `index.php` halaman login
- `dashboard.php` halaman utama
- `pelanggan.php` CRUD pelanggan
- `tagihan.php` input dan daftar tagihan
- `laporan.php` halaman laporan
- `api/` endpoint JSON AJAX
- `print/` halaman cetak
- `database/pdam_zernih.sql` script database
- `docs/analisis-sistem.md` dokumen analisis singkat
