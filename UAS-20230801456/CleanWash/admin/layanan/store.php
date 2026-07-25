<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

/*
|--------------------------------------------------------------------------
| Hanya menerima request POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location:index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Ambil Data Form
|--------------------------------------------------------------------------
*/

$kode       = trim($_POST['kode_layanan']);
$nama       = trim($_POST['nama_layanan']);
$harga      = trim($_POST['harga_perkg']);
$estimasi   = trim($_POST['estimasi']);
$status     = trim($_POST['status']);

/*
|--------------------------------------------------------------------------
| Validasi
|--------------------------------------------------------------------------
*/

if (
    empty($kode) ||
    empty($nama) ||
    empty($harga) ||
    empty($estimasi) ||
    empty($status)
){

    header("Location:create.php?error=Semua data wajib diisi.");
    exit;

}

/*
|--------------------------------------------------------------------------
| Simpan Data
|--------------------------------------------------------------------------
*/

$sql = "

INSERT INTO layanan
(
    kode_layanan,
    nama_layanan,
    harga_perkg,
    estimasi,
    status
)

VALUES
(
    ?,?,?,?,?
)

";

$stmt = $db->prepare($sql);

$simpan = $stmt->execute([

    $kode,
    $nama,
    $harga,
    $estimasi,
    $status

]);

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

if($simpan){

    header("Location:index.php?success=Data layanan berhasil ditambahkan");

}else{

    header("Location:create.php?error=Data layanan gagal disimpan");

}

exit;

?>