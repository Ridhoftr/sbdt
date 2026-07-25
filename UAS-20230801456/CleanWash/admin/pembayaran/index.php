<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pembayaran";

/*
|--------------------------------------------------------------------------
| Data Pembayaran
|--------------------------------------------------------------------------
*/

$sql = "

SELECT

t.*,

p.nama AS pelanggan,

g.nama AS pegawai

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan=p.id_pelanggan

JOIN pegawai g
ON t.id_pegawai=g.id_pegawai

ORDER BY t.id_transaksi DESC

";

$data = $db->query($sql)->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white d-flex justify-content-between">

<h4>

<i class="bi bi-cash-stack"></i>

Data Pembayaran

</h4>

</div>

<div class="card-body">

<div class="table-responsive">

<table
id="tablePembayaran"
class="table table-bordered table-striped">

<thead class="table-primary">

<tr>

<th>No</th>

<th>Kode</th>

<th>Pelanggan</th>

<th>Pegawai</th>

<th>Total</th>

<th>Status</th>

<th width="220">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($data as $row):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['kode_transaksi'] ?></td>

<td><?= $row['pelanggan'] ?></td>

<td><?= $row['pegawai'] ?></td>

<td><?= rupiah($row['total']) ?></td>

<td>

<?php

if($row['status_pembayaran']=="Lunas"){

echo "<span class='badge bg-success'>Lunas</span>";

}else{

echo "<span class='badge bg-warning text-dark'>Belum Lunas</span>";

}

?>

</td>

<td>

<?php if($row['status_pembayaran']=="Belum Lunas"): ?>

<a
href="bayar.php?id=<?= $row['id_transaksi'] ?>"
class="btn btn-success btn-sm">

<i class="bi bi-cash"></i>

Bayar

</a>

<?php endif; ?>

<a
href="detail.php?id=<?= $row['id_transaksi'] ?>"
class="btn btn-primary btn-sm">

<i class="bi bi-eye"></i>

Detail

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

$(document).ready(function(){

$('#tablePembayaran').DataTable({

responsive:true,

pageLength:10,

order:[[1,'desc']],

language:{

search:"Cari :",

lengthMenu:"Tampilkan _MENU_ data",

info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

zeroRecords:"Data tidak ditemukan",

paginate:{

first:"Awal",

last:"Akhir",

next:"→",

previous:"←"

}

}

});

});

</script>

<?php include "../../templates/footer.php"; ?>