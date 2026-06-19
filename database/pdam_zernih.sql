CREATE DATABASE IF NOT EXISTS pdam_zernih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pdam_zernih;

DROP VIEW IF EXISTS v_pendapatan_pdam;
DROP TABLE IF EXISTS tagihan;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS karyawan;
DROP TABLE IF EXISTS pelanggan;

CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    no_rek VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kategori ENUM('RT','ID','IP') NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE karyawan (
    id_karyawan INT AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) NOT NULL
);

CREATE TABLE `user` (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','kasir') DEFAULT 'admin'
);

CREATE TABLE tagihan (
    id_tagihan INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT NOT NULL,
    periode DATE NOT NULL,
    tgl_tagih DATE NOT NULL,
    hpka INT NOT NULL DEFAULT 2000,
    adm INT NOT NULL,
    mbl INT NOT NULL,
    mbi INT NOT NULL,
    pemakaian INT NOT NULL,
    tagihan INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tagihan_pelanggan FOREIGN KEY (id_pelanggan)
        REFERENCES pelanggan(id_pelanggan)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO pelanggan (id_pelanggan, no_rek, nama, kategori, no_hp, alamat) VALUES
(1, '12.1', 'Rahman', 'RT', '081234567001', 'Padang'),
(2, '12.2', 'UNP', 'ID', '081234567002', 'Padang'),
(3, '12.3', 'RS M. Jamil', 'IP', '081234567003', 'Padang'),
(4, '12.4', 'Intan', 'RT', '081234567004', 'Padang'),
(5, '12.5', 'Fadli', 'RT', '081234567005', 'Padang');

INSERT INTO karyawan (nik, nama, jabatan) VALUES
('5512', 'Rezky Subrata', 'Kasir');

INSERT INTO `user` (nama, username, password, role) VALUES
('Administrator', 'admin', '$2y$12$KdrbcCUnWUHSGsZ8fxJ8ie1cdDMIIK0mEcdQvVTmI1KzEJJhTI./6', 'admin');

INSERT INTO tagihan (id_pelanggan, periode, tgl_tagih, hpka, adm, mbl, mbi, pemakaian, tagihan) VALUES
(1, '2025-05-01', '2025-04-12', 2000, 10000, 200, 210, 10, 30000),
(2, '2025-05-01', '2025-04-14', 2000, 20000, 90, 200, 110, 240000),
(3, '2025-05-01', '2025-04-10', 2000, 15000, 1000, 1200, 200, 415000),
(4, '2025-05-01', '2025-04-22', 2000, 10000, 0, 210, 210, 430000),
(5, '2025-05-01', '2025-04-25', 2000, 10000, 100, 128, 28, 66000),
(1, '2025-06-01', '2025-05-12', 2000, 10000, 210, 224, 14, 38000),
(2, '2025-06-01', '2025-05-14', 2000, 20000, 200, 325, 125, 270000),
(3, '2025-06-01', '2025-05-10', 2000, 15000, 1200, 1430, 230, 475000),
(4, '2025-06-01', '2025-05-22', 2000, 10000, 210, 405, 195, 400000),
(5, '2025-06-01', '2025-05-25', 2000, 10000, 128, 150, 22, 54000),
(1, '2025-07-01', '2025-06-12', 2000, 10000, 224, 240, 16, 42000),
(2, '2025-07-01', '2025-06-14', 2000, 20000, 325, 450, 125, 270000),
(3, '2025-07-01', '2025-06-10', 2000, 15000, 1430, 1645, 215, 445000);

CREATE VIEW v_pendapatan_pdam AS
SELECT
    t.id_tagihan,
    t.periode,
    t.tgl_tagih,
    p.no_rek,
    p.nama,
    p.kategori,
    t.hpka,
    t.adm,
    t.mbl,
    t.mbi,
    t.pemakaian,
    t.tagihan AS total_tagihan
FROM tagihan t
JOIN pelanggan p ON p.id_pelanggan = t.id_pelanggan;
