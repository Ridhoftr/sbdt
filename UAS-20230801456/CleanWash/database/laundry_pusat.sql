-- ===========================================================
-- DATABASE : laundry_pusat
-- CleanWash Laundry Distributed System
-- ===========================================================

CREATE DATABASE laundry_pusat
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE laundry_pusat;

-- ===========================================================
-- TABLE USERS
-- ===========================================================

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('pusat') NOT NULL DEFAULT 'pusat',
    status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- TABLE CABANG
-- ===========================================================

CREATE TABLE cabang (
    id_cabang INT AUTO_INCREMENT PRIMARY KEY,
    kode_cabang VARCHAR(10) NOT NULL UNIQUE,
    nama_cabang VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- TABLE PELANGGAN GLOBAL
-- ===========================================================

CREATE TABLE pelanggan_global (
    id_global INT AUTO_INCREMENT PRIMARY KEY,
    asal_cabang VARCHAR(20) NOT NULL,
    id_pelanggan INT NOT NULL,
    kode_pelanggan VARCHAR(20),
    nama VARCHAR(100),
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- TABLE PEGAWAI GLOBAL
-- ===========================================================

CREATE TABLE pegawai_global (
    id_global INT AUTO_INCREMENT PRIMARY KEY,
    asal_cabang VARCHAR(20) NOT NULL,
    id_pegawai INT NOT NULL,
    nama VARCHAR(100),
    jabatan VARCHAR(50),
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- TABLE TRANSAKSI GLOBAL
-- ===========================================================

CREATE TABLE transaksi_global (
    id_global INT AUTO_INCREMENT PRIMARY KEY,
    asal_cabang VARCHAR(20) NOT NULL,
    id_transaksi INT NOT NULL,
    kode_transaksi VARCHAR(30),
    nama_pelanggan VARCHAR(100),
    nama_pegawai VARCHAR(100),
    tanggal DATE,
    subtotal DECIMAL(12,2),
    diskon DECIMAL(12,2),
    total DECIMAL(12,2),
    status VARCHAR(30),
    status_pembayaran VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- TABLE LOG SINKRONISASI
-- ===========================================================

CREATE TABLE sinkronisasi_log (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    asal_cabang VARCHAR(20),
    jumlah_data INT,
    status ENUM('berhasil','gagal'),
    keterangan TEXT,
    waktu_sinkron TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================================
-- DUMMY DATA CABANG
-- ===========================================================

INSERT INTO cabang
(kode_cabang,nama_cabang,alamat,telepon)
VALUES
('CB001','Makassar','Jl. Perintis Kemerdekaan','041112345'),
('CB002','Gowa','Jl. Sultan Hasanuddin','041145678');