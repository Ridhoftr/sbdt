<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "sinkronisasi";

/*
|--------------------------------------------------------------------------
| Jumlah Data Cabang
|--------------------------------------------------------------------------
*/

$jumlahPelanggan = $db->query("
SELECT COUNT(*) FROM pelanggan
")->fetchColumn();

$jumlahPegawai = $db->query("
SELECT COUNT(*) FROM pegawai
")->fetchColumn();

$jumlahTransaksi = $db->query("
SELECT COUNT(*) FROM transaksi
")->fetchColumn();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

<div class="card shadow-sm">

<div class="card-header bg-white">

<h4>

<i class="bi bi-arrow-repeat"></i>

Sinkronisasi Database

</h4>

</div>

<div class="card-body">

<div class="alert alert-info">

<b>Cabang Aktif :</b>

<?= strtoupper($_SESSION['cabang']) ?>

</div>

<div class="row">

<div class="col-md-4">

<div class="card text-center border-primary">

<div class="card-body">

<h1>

<?= $jumlahPelanggan ?>

</h1>

<h5>Pelanggan</h5>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center border-success">

<div class="card-body">

<h1>

<?= $jumlahPegawai ?>

</h1>

<h5>Pegawai</h5>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center border-warning">

<div class="card-body">

<h1>

<?= $jumlahTransaksi ?>

</h1>

<h5>Transaksi</h5>

</div>

</div>

</div>

</div>

<hr>

<div class="d-grid gap-2">

<a
href="proses.php"
class="btn btn-success btn-lg">

<i class="bi bi-arrow-repeat"></i>

Sinkronisasi Sekarang

</a>

<a
href="log.php"
class="btn btn-secondary">

<i class="bi bi-clock-history"></i>

Riwayat Sinkronisasi

</a>

</div>

</div>

</div>

</div>

<?php include "../../templates/footer.php"; ?>