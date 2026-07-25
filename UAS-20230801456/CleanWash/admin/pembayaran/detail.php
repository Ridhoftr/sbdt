<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pembayaran";

if (!isset($_GET['id'])) {
    redirect("index.php");
}

$id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| Data Transaksi
|--------------------------------------------------------------------------
*/

$sql = "

SELECT

t.*,

p.nama AS pelanggan,
p.telepon,
p.alamat,

g.nama AS pegawai,

pb.tanggal AS tanggal_bayar,
pb.metode,
pb.jumlah,
pb.status

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan=p.id_pelanggan

JOIN pegawai g
ON t.id_pegawai=g.id_pegawai

LEFT JOIN pembayaran pb
ON t.id_transaksi=pb.id_transaksi

WHERE t.id_transaksi=?

";

$stmt = $db->prepare($sql);
$stmt->execute([$id]);

$transaksi = $stmt->fetch();

if (!$transaksi) {
    redirect("index.php");
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

<div class="card-header bg-white d-flex justify-content-between">

<h4>

<i class="bi bi-receipt"></i>

Detail Pembayaran

</h4>

<a
href="index.php"
class="btn btn-secondary">

Kembali

</a>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<table class="table">

<tr>
<th width="180">Kode Transaksi</th>
<td><?= $transaksi['kode_transaksi'] ?></td>
</tr>

<tr>
<th>Tanggal</th>
<td><?= $transaksi['tanggal'] ?></td>
</tr>

<tr>
<th>Pelanggan</th>
<td><?= $transaksi['pelanggan'] ?></td>
</tr>

<tr>
<th>Telepon</th>
<td><?= $transaksi['telepon'] ?></td>
</tr>

<tr>
<th>Alamat</th>
<td><?= $transaksi['alamat'] ?></td>
</tr>

<tr>
<th>Pegawai</th>
<td><?= $transaksi['pegawai'] ?></td>
</tr>

</table>

</div>

<div class="col-md-6">

<table class="table">

<tr>
<th width="180">Status Laundry</th>
<td>

<?php

if($transaksi['status']=="Diproses"){

echo "<span class='badge bg-warning'>Diproses</span>";

}elseif($transaksi['status']=="Selesai"){

echo "<span class='badge bg-info'>Selesai</span>";

}else{

echo "<span class='badge bg-success'>Diambil</span>";

}

?>

</td>
</tr>

<tr>
<th>Status Pembayaran</th>

<td>

<?php

if($transaksi['status_pembayaran']=="Lunas"){

echo "<span class='badge bg-success'>Lunas</span>";

}else{

echo "<span class='badge bg-danger'>Belum Lunas</span>";

}

?>

</td>

</tr>

<tr>

<th>Tanggal Bayar</th>

<td>

<?= $transaksi['tanggal_bayar'] ?? "-" ?>

</td>

</tr>

<tr>

<th>Metode</th>

<td>

<?= $transaksi['metode'] ?? "-" ?>

</td>

</tr>

<tr>

<th>Jumlah Bayar</th>

<td>

<?= isset($transaksi['jumlah']) ? rupiah($transaksi['jumlah']) : "-" ?>

</td>

</tr>

</table>

</div>

</div>

<hr>

<h5>

Detail Layanan

</h5>

<div class="table-responsive">

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

<td><?= $row['nama_layanan'] ?></td>

<td><?= rupiah($row['harga']) ?></td>

<td><?= $row['berat'] ?> Kg</td>

<td><?= rupiah($row['subtotal']) ?></td>

</tr>

<?php endforeach; ?>

</tbody>

<tfoot>

<tr>

<th colspan="4" class="text-end">

Subtotal

</th>

<th>

<?= rupiah($transaksi['subtotal']) ?>

</th>

</tr>

<tr>

<th colspan="4" class="text-end">

Diskon

</th>

<th>

<?= rupiah($transaksi['diskon']) ?>

</th>

</tr>

<tr>

<th colspan="4" class="text-end">

Total

</th>

<th>

<?= rupiah($transaksi['total']) ?>

</th>

</tr>

</tfoot>

</table>

</div>

<div class="mt-3">

<a
href="cetak.php?id=<?= $transaksi['id_transaksi'] ?>"
target="_blank"
class="btn btn-success">

<i class="bi bi-printer"></i>

Cetak Invoice

</a>

</div>

</div>

</div>

</div>

<?php include "../../templates/footer.php"; ?>