USE laundry_pusat;

-- ===========================================
-- PELANGGAN
-- ===========================================

CREATE TABLE IF NOT EXISTS pelanggan (
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

CREATE TABLE IF NOT EXISTS pegawai (
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

CREATE TABLE IF NOT EXISTS layanan (
    id_layanan INT AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(100) NOT NULL,
    harga_perkg DECIMAL(12,2) NOT NULL,
    estimasi VARCHAR(50),
    status ENUM('aktif','nonaktif') DEFAULT 'aktif'
);

-- ===========================================
-- TRANSAKSI
-- ===========================================

CREATE TABLE IF NOT EXISTS transaksi (
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

    CONSTRAINT fk_transaksi_pelanggan
        FOREIGN KEY (id_pelanggan)
        REFERENCES pelanggan(id_pelanggan),

    CONSTRAINT fk_transaksi_pegawai
        FOREIGN KEY (id_pegawai)
        REFERENCES pegawai(id_pegawai)
);

-- ===========================================
-- DETAIL TRANSAKSI
-- ===========================================

CREATE TABLE IF NOT EXISTS detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_layanan INT,
    berat DECIMAL(5,2),
    harga DECIMAL(12,2),
    subtotal DECIMAL(12,2),

    CONSTRAINT fk_detail_transaksi
        FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE,

    CONSTRAINT fk_detail_layanan
        FOREIGN KEY (id_layanan)
        REFERENCES layanan(id_layanan)
);

-- ===========================================
-- PEMBAYARAN
-- ===========================================

CREATE TABLE IF NOT EXISTS pembayaran (
    id_bayar INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT UNIQUE,
    tanggal DATE,
    metode ENUM('Tunai','Transfer','QRIS'),
    jumlah DECIMAL(12,2),
    status ENUM('Belum Lunas','Lunas'),

    CONSTRAINT fk_pembayaran_transaksi
        FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE
);