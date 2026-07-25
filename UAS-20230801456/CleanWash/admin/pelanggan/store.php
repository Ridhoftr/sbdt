<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

/*
|--------------------------------------------------------------------------
| Ambil Data Form
|--------------------------------------------------------------------------
*/

$kode = sanitize($_POST['kode_pelanggan']);
$nama = sanitize($_POST['nama']);
$telepon = sanitize($_POST['telepon']);
$alamat = sanitize($_POST['alamat']);

/*
|--------------------------------------------------------------------------
| Validasi
|--------------------------------------------------------------------------
*/

if ($nama == "" || $telepon == "" || $alamat == "") {

    header("Location: create.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| Simpan Data
|--------------------------------------------------------------------------
*/

$sql = "
INSERT INTO pelanggan
(
kode_pelanggan,
nama,
telepon,
alamat
)
VALUES
(
?,
?,
?,
?
)
";

$stmt = $db->prepare($sql);

$stmt->execute([

    $kode,

    $nama,

    $telepon,

    $alamat

]);

header("Location: index.php?success=Data pelanggan berhasil ditambahkan");

exit;