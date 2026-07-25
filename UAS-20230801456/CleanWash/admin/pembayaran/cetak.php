<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

if(!isset($_GET['id'])){
    die("Data tidak ditemukan.");
}

$id=$_GET['id'];

/*
|--------------------------------------------------------------------------
| Data Transaksi
|--------------------------------------------------------------------------
*/

$sql="

SELECT

t.*,

p.nama AS pelanggan,
p.alamat,
p.telepon,

g.nama AS pegawai,

pb.tanggal AS tanggal_bayar,
pb.metode,
pb.jumlah

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan=p.id_pelanggan

JOIN pegawai g
ON t.id_pegawai=g.id_pegawai

LEFT JOIN pembayaran pb
ON t.id_transaksi=pb.id_transaksi

WHERE t.id_transaksi=?

";

$stmt=$db->prepare($sql);
$stmt->execute([$id]);

$trx=$stmt->fetch();

if(!$trx){
    die("Transaksi tidak ditemukan.");
}

/*
|--------------------------------------------------------------------------
| Detail
|--------------------------------------------------------------------------
*/

$sql="

SELECT

d.*,

l.nama_layanan

FROM detail_transaksi d

JOIN layanan l
ON d.id_layanan=l.id_layanan

WHERE d.id_transaksi=?

";

$stmt=$db->prepare($sql);
$stmt->execute([$id]);

$detail=$stmt->fetchAll();

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Invoice <?= $trx['kode_transaksi'] ?></title>

<style>

body{

font-family:Arial,Helvetica,sans-serif;

margin:30px;

color:#333;

}

.invoice{

max-width:850px;

margin:auto;

border:1px solid #ddd;

padding:30px;

}

.header{

display:flex;

justify-content:space-between;

align-items:center;

border-bottom:2px solid #0d6efd;

padding-bottom:15px;

margin-bottom:20px;

}

.logo{

font-size:28px;

font-weight:bold;

color:#0d6efd;

}

.subtitle{

font-size:13px;

color:#777;

}

table{

width:100%;

border-collapse:collapse;

margin-top:15px;

}

table th{

background:#0d6efd;

color:white;

padding:10px;

}

table td{

padding:10px;

border:1px solid #ddd;

}

.info td{

border:none;

padding:5px;

}

.total{

width:300px;

margin-left:auto;

margin-top:20px;

}

.total td{

padding:8px;

}

.footer{

margin-top:40px;

text-align:center;

font-size:13px;

color:#666;

}

.badge{

display:inline-block;

padding:5px 12px;

background:#198754;

color:white;

border-radius:15px;

font-size:12px;

}

@media print{

button{

display:none;

}

body{

margin:0;

}

.invoice{

border:none;

}

}

</style>

</head>

<body>

<div class="invoice">

<div class="header">

<div>

<div class="logo">

CleanWash Laundry

</div>

<div class="subtitle">

Laundry Management System

</div>

</div>

<div>

<h2>

INVOICE

</h2>

<strong>

<?= $trx['kode_transaksi'] ?>

</strong>

</div>

</div>

<table class="info">

<tr>

<td width="180">

Tanggal

</td>

<td>

<?= $trx['tanggal'] ?>

</td>

</tr>

<tr>

<td>

Pelanggan

</td>

<td>

<?= $trx['pelanggan'] ?>

</td>

</tr>

<tr>

<td>

Telepon

</td>

<td>

<?= $trx['telepon'] ?>

</td>

</tr>

<tr>

<td>

Alamat

</td>

<td>

<?= $trx['alamat'] ?>

</td>

</tr>

<tr>

<td>

Pegawai

</td>

<td>

<?= $trx['pegawai'] ?>

</td>

</tr>

<tr>

<td>

Status Pembayaran

</td>

<td>

<span class="badge">

<?= $trx['status_pembayaran'] ?>

</span>

</td>

</tr>

</table>

<table>

<thead>

<tr>

<th>No</th>

<th>Layanan</th>

<th>Harga/Kg</th>

<th>Berat</th>

<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($detail as $d):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nama_layanan'] ?></td>

<td><?= rupiah($d['harga']) ?></td>

<td><?= $d['berat'] ?> Kg</td>

<td><?= rupiah($d['subtotal']) ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<table class="total">

<tr>

<td>

Subtotal

</td>

<td align="right">

<?= rupiah($trx['subtotal']) ?>

</td>

</tr>

<tr>

<td>

Diskon

</td>

<td align="right">

<?= rupiah($trx['diskon']) ?>

</td>

</tr>

<tr>

<td>

<strong>

TOTAL

</strong>

</td>

<td align="right">

<strong>

<?= rupiah($trx['total']) ?>

</strong>

</td>

</tr>

<tr>

<td>

Metode

</td>

<td align="right">

<?= $trx['metode'] ?: "-" ?>

</td>

</tr>

<tr>

<td>

Jumlah Bayar

</td>

<td align="right">

<?= isset($trx['jumlah']) ? rupiah($trx['jumlah']) : "-" ?>

</td>

</tr>

</table>

<div class="footer">

Terima kasih telah menggunakan layanan

<strong>CleanWash Laundry</strong>

<br><br>

<em>

"Kepuasan pelanggan adalah prioritas kami."

</em>

</div>

<br>

<div style="text-align:center;">

<button onclick="window.print()">

🖨 Cetak Invoice

</button>

</div>

</div>

</body>

</html>