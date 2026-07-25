-- ==========================================================
-- DATABASE : laundry_gowa
-- CLEANWASH LAUNDRY DISTRIBUTED SYSTEM
-- ==========================================================


CREATE DATABASE laundry_gowa
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE laundry_gowa;

-- ===========================================
-- USERS
-- ===========================================

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('gowa') NOT NULL DEFAULT 'gowa',
    status ENUM('aktif','nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================
-- PELANGGAN
-- ===========================================

CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    kode_pelanggan VARCHAR(20) UNIQUE,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================
-- PEGAWAI
-- ===========================================

CREATE TABLE pegawai (
    id_pegawai INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50),
    telepon VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================
-- LAYANAN
-- ===========================================

CREATE TABLE layanan (
    id_layanan INT AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(100) NOT NULL,
    harga_perkg DECIMAL(12,2) NOT NULL,
    estimasi VARCHAR(50),
    status ENUM('aktif','nonaktif') DEFAULT 'aktif'
);

-- ===========================================
-- TRANSAKSI
-- ===========================================

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    kode_transaksi VARCHAR(30) UNIQUE,
    id_pelanggan INT,
    id_pegawai INT,
    tanggal DATE,
    subtotal DECIMAL(12,2),
    diskon DECIMAL(12,2),
    total DECIMAL(12,2),
    status ENUM('Diproses','Selesai','Diambil') DEFAULT 'Diproses',
    status_pembayaran ENUM('Belum Lunas','Lunas') DEFAULT 'Belum Lunas',

    FOREIGN KEY (id_pelanggan)
        REFERENCES pelanggan(id_pelanggan),

    FOREIGN KEY (id_pegawai)
        REFERENCES pegawai(id_pegawai)
);

-- ===========================================
-- DETAIL TRANSAKSI
-- ===========================================

CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_layanan INT,
    berat DECIMAL(5,2),
    harga DECIMAL(12,2),
    subtotal DECIMAL(12,2),

    FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE,

    FOREIGN KEY (id_layanan)
        REFERENCES layanan(id_layanan)
);

-- ===========================================
-- PEMBAYARAN
-- ===========================================

CREATE TABLE pembayaran (
    id_bayar INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT UNIQUE,
    tanggal DATE,
    metode ENUM('Tunai','Transfer','QRIS'),
    jumlah DECIMAL(12,2),
    status ENUM('Belum Lunas','Lunas'),

    FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE
);