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

$id         = intval($_POST['id_layanan']);
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

    empty($id) ||
    empty($nama) ||
    empty($harga) ||
    empty($estimasi) ||
    empty($status)

){

    header("Location:edit.php?id=".$id."&error=Semua data wajib diisi.");
    exit;

}

/*
|--------------------------------------------------------------------------
| Update Data
|--------------------------------------------------------------------------
*/

$sql = "

UPDATE layanan

SET

nama_layanan=?,
harga_perkg=?,
estimasi=?,
status=?

WHERE id_layanan=?

";

$stmt = $db->prepare($sql);

$update = $stmt->execute([

    $nama,
    $harga,
    $estimasi,
    $status,
    $id

]);

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

if($update){

    header("Location:index.php?success=Data layanan berhasil diupdate");

}else{

    header("Location:edit.php?id=".$id."&error=Data gagal diupdate");

}

exit;

?>