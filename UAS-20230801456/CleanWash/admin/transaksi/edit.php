<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "transaksi";

if (!isset($_GET['id'])) {
    header("Location:index.php");
    exit;
}

$id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| Data Transaksi
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM transaksi
WHERE id_transaksi = ?
";

$stmt = $db->prepare($sql);
$stmt->execute([$id]);

$trx = $stmt->fetch();

if (!$trx) {
    header("Location:index.php?error=Data tidak ditemukan");
    exit;
}

/*
|--------------------------------------------------------------------------
| Data Pelanggan
|--------------------------------------------------------------------------
*/

$pelanggan = $db->query("
SELECT *
FROM pelanggan
ORDER BY nama
")->fetchAll();

/*
|--------------------------------------------------------------------------
| Data Pegawai
|--------------------------------------------------------------------------
*/

$pegawai = $db->query("
SELECT *
FROM pegawai
ORDER BY nama
")->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white">

<h4>Edit Transaksi</h4>

</div>

<div class="card-body">

<form action="update.php" method="POST">

<input
type="hidden"
name="id_transaksi"
value="<?= $trx['id_transaksi'] ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Kode Transaksi

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($trx['kode_transaksi']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Tanggal

</label>

<input
type="date"
class="form-control"
name="tanggal"
value="<?= $trx['tanggal'] ?>"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">

Pelanggan

</label>

<select
class="form-select"
name="id_pelanggan"
required>

<?php foreach($pelanggan as $row): ?>

<option
value="<?= $row['id_pelanggan'] ?>"
<?= $trx['id_pelanggan']==$row['id_pelanggan'] ? 'selected' : '' ?>>

<?= htmlspecialchars($row['kode_pelanggan']) ?>

-

<?= htmlspecialchars($row['nama']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Pegawai

</label>

<select
class="form-select"
name="id_pegawai"
required>

<?php foreach($pegawai as $row): ?>

<option
value="<?= $row['id_pegawai'] ?>"
<?= $trx['id_pegawai']==$row['id_pegawai'] ? 'selected' : '' ?>>

<?= htmlspecialchars($row['nama']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<hr>

<h5>Ringkasan Transaksi</h5>

<div class="row">

<div class="col-md-4">

<label class="form-label">

Subtotal

</label>

<input
type="text"
class="form-control"
value="<?= rupiah($trx['subtotal']) ?>"
readonly>

</div>

<div class="col-md-4">

<label class="form-label">

Diskon

</label>

<input
type="number"
class="form-control"
name="diskon"
id="diskon"
value="<?= $trx['diskon'] ?>"
min="0">

</div>

<div class="col-md-4">

<label class="form-label">

Total

</label>

<input
type="text"
class="form-control"
id="total"
value="<?= $trx['total'] ?>"
readonly>

</div>

</div>

<hr>

<div class="row">

<div class="col-md-6">

<label class="form-label">

Status Laundry

</label>

<select
class="form-select"
name="status">

<option
value="Diproses"
<?= $trx['status']=="Diproses"?"selected":"" ?>>

Diproses

</option>

<option
value="Selesai"
<?= $trx['status']=="Selesai"?"selected":"" ?>>

Selesai

</option>

<option
value="Diambil"
<?= $trx['status']=="Diambil"?"selected":"" ?>>

Diambil

</option>

</select>

</div>

<div class="col-md-6">

<label class="form-label">

Status Pembayaran

</label>

<select
class="form-select"
name="status_pembayaran">

<option
value="Belum Lunas"
<?= $trx['status_pembayaran']=="Belum Lunas"?"selected":"" ?>>

Belum Lunas

</option>

<option
value="Lunas"
<?= $trx['status_pembayaran']=="Lunas"?"selected":"" ?>>

Lunas

</option>

</select>

</div>

</div>

<hr>

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update

</button>

<a
href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<script>

let subtotal = <?= $trx['subtotal'] ?>;

document.getElementById("diskon").addEventListener("input",function(){

    let diskon = parseFloat(this.value) || 0;

    let total = subtotal - diskon;

    if(total < 0){

        total = 0;

    }

    document.getElementById("total").value = total;

});

</script>

<?php include "../../templates/footer.php"; ?>