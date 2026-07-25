<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";

$db = Database::pusat();

$page = "sinkronisasi";

$sql = "

SELECT *

FROM sinkronisasi_log

ORDER BY waktu_sinkron DESC

";

$data = $db->query($sql)->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white d-flex justify-content-between align-items-center">

<h4>

<i class="bi bi-clock-history"></i>

Riwayat Sinkronisasi

</h4>

<a
href="index.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

</div>

<div class="card-body">

<div class="table-responsive">

<table
id="tableLog"
class="table table-bordered table-striped">

<thead class="table-primary">

<tr>

<th>No</th>

<th>Cabang</th>

<th>Jumlah Data</th>

<th>Status</th>

<th>Keterangan</th>

<th>Waktu</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($data as $row):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= strtoupper($row['asal_cabang']) ?></td>

<td><?= $row['jumlah_data'] ?></td>

<td>

<?php

if($row['status']=="berhasil"){

echo "<span class='badge bg-success'>Berhasil</span>";

}else{

echo "<span class='badge bg-danger'>Gagal</span>";

}

?>

</td>

<td><?= $row['keterangan'] ?></td>

<td><?= $row['waktu_sinkron'] ?></td>

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

$('#tableLog').DataTable({

responsive:true,

pageLength:10,

order:[[5,'desc']],

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