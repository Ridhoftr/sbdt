# 🧺 CleanWash Laundry
### Sistem Informasi Laundry Berbasis Basis Data Terdistribusi

CleanWash Laundry merupakan aplikasi berbasis web yang dikembangkan sebagai implementasi konsep **Basis Data Terdistribusi**. Sistem ini memungkinkan setiap cabang mengelola data secara mandiri menggunakan database lokal, kemudian melakukan sinkronisasi ke database pusat untuk kebutuhan monitoring dan pelaporan.

---

# 📌 Fitur Utama

## Cabang

- Login Admin
- Dashboard
- Manajemen Pelanggan
- Manajemen Pegawai
- Manajemen Layanan
- Manajemen Transaksi
- Pembayaran
- Laporan Transaksi
- Sinkronisasi Data ke Pusat

---

## Pusat

- Dashboard Monitoring
- Data Seluruh Cabang
- Monitoring Sinkronisasi
- Rekapitulasi Data Cabang

---

# 🏗 Arsitektur Sistem

```
Cabang Makassar
        │
        │
        ▼
 Database Lokal
        │
        │ Sinkronisasi
        ▼
 Database Pusat
        ▲
        │ Sinkronisasi
        │
 Database Lokal
        ▲
Cabang Gowa
```

Setiap cabang memiliki database sendiri sehingga tetap dapat beroperasi secara mandiri meskipun koneksi ke pusat terputus.

---

# 📂 Struktur Project

```
CleanWash/

│
├── admin/
│   ├── dashboard.php
│   ├── pelanggan/
│   ├── pegawai/
│   ├── layanan/
│   ├── transaksi/
│   ├── pembayaran/
│   ├── laporan/
│   └── sinkronisasi/
│
├── config/
│   ├── auth.php
│   ├── connection.php
│   ├── helper.php
│   ├── config_makassar.php
│   └── config_gowa.php
│
├── templates/
│
├── assets/
│
├── database/
│
└── README.md
```

---

# 🗄 Database

Project menggunakan tiga database MySQL.

| Database | Fungsi |
|----------|---------|
| laundry_makassar | Database Cabang Makassar |
| laundry_gowa | Database Cabang Gowa |
| laundry_pusat | Database Pusat |

---

# 🔄 Mekanisme Sinkronisasi

1. Admin melakukan login pada cabang.
2. Seluruh transaksi disimpan pada database lokal.
3. Admin menekan tombol **Sinkronisasi**.
4. Data dikirim ke database pusat.
5. Database pusat menyimpan data berdasarkan asal cabang.
6. Dashboard pusat menampilkan data seluruh cabang.

---

# 💻 Teknologi

- PHP Native
- MySQL
- PDO
- Bootstrap 5
- Bootstrap Icons
- jQuery
- DataTables
- Chart.js
- XAMPP

---

# 📋 Modul

- Dashboard
- Login
- Pelanggan
- Pegawai
- Layanan
- Transaksi
- Detail Transaksi
- Pembayaran
- Laporan
- Sinkronisasi
- Dashboard Pusat

---

# 🚀 Cara Menjalankan

## 1. Clone Project

```bash
git clone https://github.com/username/CleanWash.git
```

---

## 2. Import Database

Import:

```
laundry_makassar.sql
laundry_gowa.sql
laundry_pusat.sql
```

menggunakan phpMyAdmin.

---

## 3. Konfigurasi Database

Sesuaikan file konfigurasi pada folder:

```
config/
```

Contoh:

```php
define('DB_HOST','localhost');
define('DB_NAME','laundry_makassar');
define('DB_USER','root');
define('DB_PASS','');
```

---

## 4. Jalankan

Aktifkan:

- Apache
- MySQL

menggunakan XAMPP.

Kemudian buka:

```
http://localhost/CleanWash
```

---

# 📸 Tampilan Sistem

- Login
- Dashboard
- Data Pelanggan
- Data Pegawai
- Data Layanan
- Transaksi
- Pembayaran
- Laporan
- Sinkronisasi
- Dashboard Pusat

---

# 🎯 Tujuan Project

Project ini dibuat untuk memenuhi tugas mata kuliah **Basis Data Terdistribusi** dengan mengimplementasikan konsep:

- Distributed Database
- Database Fragmentation
- Distributed Transaction
- Data Synchronization
- Centralized Monitoring

---

**Muhammad Ridho Faturahman - 20230801456**

Program Studi Teknik Informatika

Universitas Esa Unggul

---
