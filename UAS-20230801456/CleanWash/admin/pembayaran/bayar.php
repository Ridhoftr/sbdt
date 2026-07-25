<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pembayaran";

if (!isset($_GET['id'])) {
    redirect("index.php");
}

$id = $_GET['id'];

$sql = "

SELECT

t.*,

p.nama AS pelanggan,

g.nama AS pegawai

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan = p.id_pelanggan

JOIN pegawai g
ON t.id_pegawai = g.id_pegawai

WHERE t.id_transaksi = ?

";

$stmt = $db->prepare($sql);
$stmt->execute([$id]);

$data = $stmt->fetch();

if (!$data) {
    redirect("index.php");
}

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white">

<h4>

<i class="bi bi-cash-stack"></i>

Pembayaran Transaksi

</h4>

</div>

<div class="card-body">

<form action="store.php" method="POST">

<input
type="hidden"
name="id_transaksi"
value="<?= $data['id_transaksi'] ?>">

<div class="row">

<div class="col-md-6">

<label class="form-label">

Kode Transaksi

</label>

<input
type="text"
class="form-control"
value="<?= $data['kode_transaksi'] ?>"
readonly>

</div>

<div class="col-md-6">

<label class="form-label">

Tanggal

</label>

<input
type="text"
class="form-control"
value="<?= $data['tanggal'] ?>"
readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label class="form-label">

Pelanggan

</label>

<input
type="text"
class="form-control"
value="<?= $data['pelanggan'] ?>"
readonly>

</div>

<div class="col-md-6">

<label class="form-label">

Pegawai

</label>

<input
type="text"
class="form-control"
value="<?= $data['pegawai'] ?>"
readonly>

</div>

</div>

<hr>

<div class="mb-3">

<label class="form-label">

Total Tagihan

</label>

<input
type="text"
class="form-control fw-bold"
value="<?= rupiah($data['total']) ?>"
readonly>

<input
type="hidden"
name="total"
value="<?= $data['total'] ?>">

</div>

<div class="mb-3">

<label class="form-label">

Tanggal Pembayaran

</label>

<input
type="date"
class="form-control"
name="tanggal"
value="<?= date('Y-m-d') ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Metode Pembayaran

</label>

<select
name="metode"
class="form-select"
required>

<option value="">-- Pilih Metode --</option>

<option value="Tunai">Tunai</option>

<option value="Transfer">Transfer</option>

<option value="QRIS">QRIS</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Jumlah Bayar

</label>

<input
type="number"
class="form-control"
id="jumlah"
name="jumlah"
min="<?= $data['total'] ?>"
value="<?= $data['total'] ?>"
required>

<small class="text-muted">

Minimal pembayaran sebesar total tagihan.

</small>

</div>

<hr>

<button
type="submit"
class="btn btn-success">

<i class="bi bi-check-circle"></i>

Simpan Pembayaran

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

document.querySelector("form").addEventListener("submit",function(e){

let total = <?= $data['total'] ?>;

let bayar = parseFloat(document.getElementById("jumlah").value);

if(bayar < total){

e.preventDefault();

Swal.fire({

icon:'warning',

title:'Pembayaran Kurang',

text:'Jumlah pembayaran belum mencukupi.'

});

}

});

</script>

<?php include "../../templates/footer.php"; ?>