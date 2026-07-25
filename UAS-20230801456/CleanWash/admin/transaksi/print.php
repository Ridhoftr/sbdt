<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

if(!isset($_GET['id'])){
    header("Location:index.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "

SELECT

t.*,

p.nama AS pelanggan,
p.telepon,
p.alamat,

pg.nama AS pegawai

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan = p.id_pelanggan

JOIN pegawai pg
ON t.id_pegawai = pg.id_pegawai

WHERE t.id_transaksi=?

";

$stmt = $db->prepare($sql);
$stmt->execute([$id]);

$trx = $stmt->fetch();

if(!$trx){
    die("Data transaksi tidak ditemukan.");
}

$sql = "

SELECT

d.*,

l.nama_layanan

FROM detail_transaksi d

JOIN layanan l
ON d.id_layanan=l.id_layanan

WHERE d.id_transaksi=?

";

$stmt = $db->prepare($sql);
$stmt->execute([$id]);

$detail = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Print Nota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

    background:#ececec;
    font-family:Poppins,Arial,sans-serif;

}

.nota{

    width:850px;
    margin:30px auto;
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.15);

}

.header{

    text-align:center;
    border-bottom:2px solid #000;
    padding-bottom:15px;
    margin-bottom:20px;

}

.header h2{

    margin:0;

}

.header p{

    margin:0;

}

.table td,
.table th{

    vertical-align:middle;

}

.total{

    font-size:20px;
    font-weight:bold;

}

.action{

    width:850px;
    margin:20px auto;
    text-align:center;

}

@media print{

    body{

        background:white;

    }

    .action{

        display:none;

    }

    .nota{

        width:100%;
        margin:0;
        box-shadow:none;
        border:none;

    }

}

</style>

</head>

<body>

<div class="action">

<button
onclick="window.print()"
class="btn btn-success">

🖨 Print

</button>

<a
href="detail.php?id=<?= $trx['id_transaksi'] ?>"
class="btn btn-secondary">

Kembali

</a>

</div>

<div class="nota">

<div class="header">

<h2>

CleanWash Laundry

</h2>

<p>

Jl. Sultan Alauddin, Makassar

</p>

<p>

Telp : 0411-123456

</p>

</div>

<div class="row">

<div class="col-md-6">

<table class="table table-borderless">

<tr>

<th width="170">

Kode

</th>

<td><?= htmlspecialchars($trx['kode_transaksi']) ?></td>

</tr>

<tr>

<th>Tanggal</th>

<td><?= date('d-m-Y',strtotime($trx['tanggal'])) ?></td>

</tr>

<tr>

<th>Pelanggan</th>

<td><?= htmlspecialchars($trx['pelanggan']) ?></td>

</tr>

<tr>

<th>Telepon</th>

<td><?= htmlspecialchars($trx['telepon']) ?></td>

</tr>

<tr>

<th>Alamat</th>

<td><?= htmlspecialchars($trx['alamat']) ?></td>

</tr>

</table>

</div>

<div class="col-md-6">

<table class="table table-borderless">

<tr>

<th width="170">

Pegawai

</th>

<td><?= htmlspecialchars($trx['pegawai']) ?></td>

</tr>

<tr>

<th>Status Laundry</th>

<td><?= htmlspecialchars($trx['status']) ?></td>

</tr>

<tr>

<th>Status Bayar</th>

<td><?= htmlspecialchars($trx['status_pembayaran']) ?></td>

</tr>

</table>

</div>

</div>

<hr>

<h5>

Detail Layanan

</h5>

<table class="table table-bordered">

<thead class="table-primary">

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

foreach($detail as $row):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($row['nama_layanan']) ?></td>

<td><?= rupiah($row['harga']) ?></td>

<td><?= $row['berat'] ?> Kg</td>

<td><?= rupiah($row['subtotal']) ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<div class="row justify-content-end">

<div class="col-md-5">

<table class="table">

<tr>

<th>

Subtotal

</th>

<td>

<?= rupiah($trx['subtotal']) ?>

</td>

</tr>

<tr>

<th>

Diskon

</th>

<td>

<?= rupiah($trx['diskon']) ?>

</td>

</tr>

<tr class="table-primary">

<th class="total">

TOTAL

</th>

<td class="total">

<?= rupiah($trx['total']) ?>

</td>

</tr>

</table>

</div>

</div>

<div class="text-center mt-5">

<h5>

Terima Kasih

</h5>

<p>

Telah menggunakan layanan CleanWash Laundry.

</p>

<p>

Semoga hari Anda menyenangkan.

</p>

</div>

</div>

</body>

</html>