# 🧺 CleanWash

<p align="center">
  <b>Sistem Informasi Laundry Multi Cabang Berbasis Web</b><br>
  <i>Implementasi Database Terdistribusi</i>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Native-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white">
  <img src="https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white">
</p>

---

## 📖 Deskripsi

**CleanWash** merupakan Sistem Informasi Laundry Multi Cabang berbasis web yang menerapkan konsep **Database Terdistribusi**.

Setiap cabang menggunakan **database lokal** untuk menjalankan operasional sehari-hari. Seluruh data kemudian disinkronkan ke **database pusat** sehingga administrator dapat melakukan monitoring dan pelaporan secara terpusat.

---

## ✨ Fitur

| Admin Cabang | Admin Pusat |
|---------------|-------------|
| 📊 Dashboard | 📊 Dashboard Monitoring |
| 👥 Kelola Pelanggan | 👥 Monitoring Data Cabang |
| 👨‍💼 Kelola Pegawai | 💳 Monitoring Pembayaran |
| 🧺 Kelola Layanan | 📦 Monitoring Transaksi |
| 📝 Transaksi Laundry | 📈 Grafik Pendapatan |
| 💰 Pembayaran | |
| 📄 Laporan | |
| 🔄 Sinkronisasi Data | |

---

## 🛠️ Teknologi

- PHP Native
- MySQL
- Bootstrap 5
- jQuery
- DataTables
- Chart.js
- XAMPP

---

## 🗄️ Database

```text
laundry_makassar
laundry_gowa
laundry_pusat
```

---

## 🚀 Cara Menjalankan

1. Jalankan **Apache** dan **MySQL** pada XAMPP.
2. Import database:
   - `laundry_makassar.sql`
   - `laundry_gowa.sql`
   - `laundry_pusat.sql`
3. Letakkan project pada folder:

```text
htdocs/CleanWash
```

4. Jalankan melalui browser:

**Admin Cabang**

```text
http://localhost/CleanWash/admin
```

**Admin Pusat**

```text
http://localhost/CleanWash/pusat
```

---

## 🏗️ Arsitektur Sistem

```text
Cabang Makassar      Cabang Gowa
(Database Lokal)    (Database Lokal)
        │                  │
        └──── Sinkronisasi ────┐
                               │
                        Database Pusat
                               │
                      Dashboard Monitoring
```

---

## 👨‍🎓 Informasi Mahasiswa

| Keterangan | Informasi |
|------------|-----------|
| **Nama** | Muhammad Ridho Faturahman |
| **Program Studi** | Teknik Informatika |
| **Universitas** | Universitas Esa Unggul |
| **Mata Kuliah** | Sistem Basis Data Terdistribusi |

---

<p align="center">
  Dibuat sebagai implementasi proyek mata kuliah <b>Sistem Basis Data Terdistribusi</b><br>
  © 2026 Muhammad Ridho Faturahman
</p>