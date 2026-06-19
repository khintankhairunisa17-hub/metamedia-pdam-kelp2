# Analisis Sistem PDAM Zernih

## Kebutuhan Sistem

PDAM membutuhkan sistem informasi untuk mencatat pelanggan, input meter air bulanan, menghitung tagihan rekening air, serta mencetak laporan pendapatan.

## Proses Bisnis

1. Petugas login ke aplikasi.
2. Petugas mengelola data pelanggan dan kategori pelanggan.
3. Petugas input meter bulan lalu dan meter bulan ini.
4. Sistem menghitung pemakaian dengan rumus `MBI - MBL`.
5. Sistem menghitung tagihan dengan rumus `(Pemakaian x HPKA) + Adm`.
6. Petugas mencetak rekening pelanggan dan laporan pendapatan.

## Kategori Pelanggan

| Kode | Kategori | Biaya Administrasi |
| --- | --- | --- |
| RT | Rumah Tangga | Rp10.000 |
| ID | Industri | Rp20.000 |
| IP | Instansi Pemerintah | Rp15.000 |

## Entitas Database

- `pelanggan`: menyimpan nomor rekening, nama, kategori, nomor HP, dan alamat.
- `tagihan`: menyimpan periode, tanggal tagih, meter, pemakaian, HPKA, adm, dan tagihan.
- `karyawan`: menyimpan data kasir/petugas.
- `user`: menyimpan akun login aplikasi.

## Relasi

- Satu pelanggan memiliki banyak tagihan.
- Satu user digunakan untuk login petugas.
- Karyawan digunakan sebagai identitas kasir pada laporan.
