<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    redirect("index.php");
}

$kode      = trim($_POST['kode_pegawai']);
$nama      = trim($_POST['nama']);
$jabatan   = trim($_POST['jabatan']);
$telepon   = trim($_POST['telepon']);
$alamat    = trim($_POST['alamat']);

$sql = "INSERT INTO pegawai
(
    kode_pegawai,
    nama,
    jabatan,
    telepon,
    alamat
)
VALUES
(
    ?,?,?,?,?
)";

$stmt = $db->prepare($sql);

$save = $stmt->execute([
    $kode,
    $nama,
    $jabatan,
    $telepon,
    $alamat
]);

if($save){

    header("Location:index.php?success=Data pegawai berhasil ditambahkan");

}else{

    header("Location:create.php?error=Data gagal disimpan");

}