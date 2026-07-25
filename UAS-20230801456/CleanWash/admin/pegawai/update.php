<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

/*
|--------------------------------------------------------------------------
| Validasi
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header("Location: index.php");

    exit;

}

$id = (int) $_POST['id'];

$nama = sanitize($_POST['nama']);

$telepon = sanitize($_POST['telepon']);

$alamat = sanitize($_POST['alamat']);

if ($nama == "" || $telepon == "" || $alamat == "") {

    header("Location: edit.php?id=$id&error=Semua field wajib diisi");

    exit;

}

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

$sql = "
UPDATE pegawai
SET
nama=?,
jabatan=?,
telepon=?,
alamat=?
WHERE id_pegawai=?
";

$stmt = $db->prepare($sql);

$stmt->execute([

$nama,

$jabatan,

$telepon,

$alamat,

$id

]);

header("Location: index.php?success=Data pegawai berhasil diupdate");

exit;