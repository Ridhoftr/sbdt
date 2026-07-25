USE laundry_pusat;

-- ======================================
-- DUMMY DATA PELANGGAN
-- ======================================
INSERT INTO pelanggan (kode_pelanggan,nama,alamat,telepon) VALUES
('PLG0001','Andi Saputra','Makassar','081234567801'),
('PLG0002','Budi Santoso','Makassar','081234567802'),
('PLG0003','Citra Lestari','Gowa','081234567803'),
('PLG0004','Dewi Anggraini','Makassar','081234567804'),
('PLG0005','Eko Prasetyo','Gowa','081234567805'),
('PLG0006','Fajar Nugroho','Makassar','081234567806'),
('PLG0007','Gina Maharani','Makassar','081234567807'),
('PLG0008','Hendra Wijaya','Gowa','081234567808'),
('PLG0009','Indah Permata','Makassar','081234567809'),
('PLG0010','Joko Susilo','Gowa','081234567810');

-- ======================================
-- DUMMY DATA PEGAWAI
-- ======================================
INSERT INTO pegawai (nama,jabatan,telepon,alamat) VALUES
('Ridwan','Kasir','081111111111','Makassar'),
('Nur Aisyah','Operator','081111111112','Makassar'),
('Rahmat','Kurir','081111111113','Makassar'),
('Yusuf','Kasir','081111111114','Gowa'),
('Fitri','Operator','081111111115','Gowa');

-- ======================================
-- DUMMY DATA LAYANAN
-- ======================================
INSERT INTO layanan (nama_layanan,harga_perkg,estimasi,status) VALUES
('Cuci Kering',7000,'2 Hari','aktif'),
('Cuci Setrika',9000,'2 Hari','aktif'),
('Setrika Saja',5000,'1 Hari','aktif'),
('Express',15000,'6 Jam','aktif'),
('Bed Cover',25000,'2 Hari','aktif');

-- ======================================
-- DUMMY DATA TRANSAKSI
-- ======================================
INSERT INTO transaksi
(kode_transaksi,id_pelanggan,id_pegawai,tanggal,subtotal,diskon,total,status,status_pembayaran)
VALUES

('TRX0001',1,1,'2026-01-10',7000,0,7000,'Selesai','Lunas'),
('TRX0002',2,2,'2026-02-12',18000,0,18000,'Selesai','Lunas'),
('TRX0003',3,3,'2026-03-18',25000,0,25000,'Selesai','Lunas'),
('TRX0004',4,1,'2026-04-08',30000,2000,28000,'Selesai','Lunas'),
('TRX0005',5,2,'2026-05-02',35000,0,35000,'Diproses','Belum Lunas'),
('TRX0006',6,3,'2026-06-11',12000,0,12000,'Selesai','Lunas'),
('TRX0007',7,1,'2026-07-09',50000,5000,45000,'Selesai','Lunas'),
('TRX0008',8,2,'2026-08-13',27000,0,27000,'Diproses','Belum Lunas'),
('TRX0009',9,3,'2026-09-15',45000,0,45000,'Selesai','Lunas'),
('TRX0010',10,1,'2026-10-20',20000,0,20000,'Selesai','Lunas');

-- ======================================
-- DUMMY DATA DETAIL TRANSAKSI
-- ======================================
INSERT INTO detail_transaksi
(id_transaksi,id_layanan,berat,harga,subtotal)
VALUES

(1,1,1,7000,7000),
(2,2,2,9000,18000),
(3,5,1,25000,25000),
(4,4,2,15000,30000),
(5,2,4,9000,36000),
(6,3,2,6000,12000),
(7,4,3,15000,45000),
(8,2,3,9000,27000),
(9,4,3,15000,45000),
(10,2,2,10000,20000);

-- ======================================
-- DUMMY DATA PEMBAYARAN
-- ======================================
INSERT INTO pembayaran
(id_transaksi,tanggal,metode,jumlah,status)
VALUES

(1,'2026-01-10','Tunai',7000,'Lunas'),
(2,'2026-02-12','QRIS',18000,'Lunas'),
(3,'2026-03-18','Transfer',25000,'Lunas'),
(4,'2026-04-08','Tunai',28000,'Lunas'),
(6,'2026-06-11','QRIS',12000,'Lunas'),
(7,'2026-07-09','Transfer',45000,'Lunas'),
(9,'2026-09-15','Tunai',45000,'Lunas'),
(10,'2026-10-20','QRIS',20000,'Lunas');