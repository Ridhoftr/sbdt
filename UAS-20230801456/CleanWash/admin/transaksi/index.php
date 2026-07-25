<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "transaksi";

/*
|--------------------------------------------------------------------------
| Data Transaksi
|--------------------------------------------------------------------------
*/

$sql = "

SELECT

transaksi.*,

pelanggan.nama AS pelanggan,

pegawai.nama AS pegawai

FROM transaksi

JOIN pelanggan
ON transaksi.id_pelanggan = pelanggan.id_pelanggan

JOIN pegawai
ON transaksi.id_pegawai = pegawai.id_pegawai

ORDER BY transaksi.id_transaksi DESC

";

$stmt = $db->query($sql);

$transaksi = $stmt->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white">

<div class="d-flex justify-content-between align-items-center">

<h4 class="mb-0">

Data Transaksi

</h4>

<a
href="create.php"
class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Tambah Transaksi

</a>

</div>

</div>

<div class="card-body">

<div class="table-responsive">

<table
id="tableTransaksi"
class="table table-bordered table-striped table-hover align-middle">

<thead class="table-dark">

<tr>

<th>No</th>

<th>Kode</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Pegawai</th>

<th>Total</th>

<th>Status</th>

<th>Pembayaran</th>

<th width="170">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($transaksi as $row):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['kode_transaksi'] ?></td>

<td><?= date('d-m-Y',strtotime($row['tanggal'])) ?></td>

<td><?= htmlspecialchars($row['pelanggan']) ?></td>

<td><?= htmlspecialchars($row['pegawai']) ?></td>

<td><?= rupiah($row['total']) ?></td>

<td>

<?php

if($row['status']=="Diproses"){

echo '<span class="badge bg-warning">Diproses</span>';

}elseif($row['status']=="Selesai"){

echo '<span class="badge bg-success">Selesai</span>';

}else{

echo '<span class="badge bg-primary">Diambil</span>';

}

?>

</td>

<td>

<?php

if($row['status_pembayaran']=="Lunas"){

echo '<span class="badge bg-success">Lunas</span>';

}else{

echo '<span class="badge bg-danger">Belum Lunas</span>';

}

?>

</td>

<td>

<a
href="detail.php?id=<?= $row['id_transaksi'] ?>"
class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a
href="edit.php?id=<?= $row['id_transaksi'] ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil-square"></i>

</a>

<button
class="btn btn-danger btn-sm btn-delete"
data-id="<?= $row['id_transaksi'] ?>">

<i class="bi bi-trash"></i>

</button>

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

document.querySelectorAll(".btn-delete").forEach(function(btn){

btn.addEventListener("click",function(){

let id=this.dataset.id;

Swal.fire({

title:"Hapus Transaksi?",

text:"Data transaksi akan dihapus.",

icon:"warning",

showCancelButton:true,

confirmButtonText:"Ya",

cancelButtonText:"Batal",

confirmButtonColor:"#dc3545"

}).then((result)=>{

if(result.isConfirmed){

window.location="delete.php?id="+id;

}

});

});

});

$(document).ready(function(){

$('#tableTransaksi').DataTable({

responsive:true,

autoWidth:false,

pageLength:10,

order:[[1,'desc']],

columnDefs:[

{

orderable:false,

targets:[8]

}

],

dom:'Bfrtip',

buttons:[

{

extend:'copy',

text:'<i class="bi bi-copy"></i> Copy',

className:'btn btn-secondary'

},

{

extend:'excel',

text:'<i class="bi bi-file-earmark-excel"></i> Excel',

className:'btn btn-success'

},

{

extend:'csv',

text:'CSV',

className:'btn btn-info'

},

{

extend:'pdf',

text:'PDF',

className:'btn btn-danger'

},

{

extend:'print',

text:'Print',

className:'btn btn-primary'

}

],

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