<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "transaksi";

if(!isset($_GET['id'])){

    header("Location:index.php");
    exit;

}

$id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| Ambil Header Transaksi
|--------------------------------------------------------------------------
*/

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

    header("Location:index.php?error=Data tidak ditemukan");
    exit;

}

/*
|--------------------------------------------------------------------------
| Detail Layanan
|--------------------------------------------------------------------------
*/

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

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white">

<h4>

Detail Transaksi

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<table class="table table-borderless">

<tr>

<th width="170">

Kode Transaksi

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

<tr>

<th>Pegawai</th>

<td><?= htmlspecialchars($trx['pegawai']) ?></td>

</tr>

</table>

</div>

<div class="col-md-6">

<table class="table table-borderless">

<tr>

<th width="180">

Status Laundry

</th>

<td>

<?php

if($trx['status']=="Diproses"){

echo '<span class="badge bg-warning">Diproses</span>';

}elseif($trx['status']=="Selesai"){

echo '<span class="badge bg-success">Selesai</span>';

}else{

echo '<span class="badge bg-primary">Diambil</span>';

}

?>

</td>

</tr>

<tr>

<th>Status Pembayaran</th>

<td>

<?php

if($trx['status_pembayaran']=="Lunas"){

echo '<span class="badge bg-success">Lunas</span>';

}else{

echo '<span class="badge bg-danger">Belum Lunas</span>';

}

?>

</td>

</tr>

<tr>

<th>Subtotal</th>

<td><?= rupiah($trx['subtotal']) ?></td>

</tr>

<tr>

<th>Diskon</th>

<td><?= rupiah($trx['diskon']) ?></td>

</tr>

<tr>

<th>Total</th>

<td>

<strong class="text-primary">

<?= rupiah($trx['total']) ?>

</strong>

</td>

</tr>

</table>

</div>

</div>

<hr>

<h5>

Daftar Layanan

</h5>

<div class="table-responsive">

<table class="table table-bordered table-striped">

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

</div>

<div class="mt-3">

<a
href="index.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

<a
href="print.php?id=<?= $trx['id_transaksi'] ?>"
class="btn btn-success">

<i class="bi bi-printer"></i>

Print Nota

</a>

</div>

</div>

</div>

</div>

<?php include "../../templates/footer.php"; ?>