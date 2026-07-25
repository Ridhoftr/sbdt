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

$kode               = trim($_POST['kode_transaksi']);
$tanggal            = trim($_POST['tanggal']);

$id_pelanggan       = intval($_POST['id_pelanggan']);
$id_pegawai         = intval($_POST['id_pegawai']);

$subtotal           = floatval($_POST['subtotal']);
$diskon             = floatval($_POST['diskon']);
$total              = floatval($_POST['total']);

$status             = trim($_POST['status']);
$status_pembayaran  = trim($_POST['status_pembayaran']);

$id_layanan         = $_POST['id_layanan'] ?? [];
$harga              = $_POST['harga'] ?? [];
$berat              = $_POST['berat'] ?? [];
$subtotal_detail    = $_POST['subtotal_detail'] ?? [];

/*
|--------------------------------------------------------------------------
| Validasi
|--------------------------------------------------------------------------
*/

if (

    empty($kode) ||

    empty($tanggal) ||

    empty($id_pelanggan) ||

    empty($id_pegawai)

){

    header("Location:create.php?error=Data transaksi belum lengkap");

    exit;

}

if(count($id_layanan) == 0){

    header("Location:create.php?error=Minimal pilih satu layanan");

    exit;

}

/*
|--------------------------------------------------------------------------
| Simpan Menggunakan Transaction
|--------------------------------------------------------------------------
*/

try{

    $db->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Simpan Tabel Transaksi
    |--------------------------------------------------------------------------
    */

    $sql = "

    INSERT INTO transaksi
    (

        kode_transaksi,

        id_pelanggan,

        id_pegawai,

        tanggal,

        subtotal,

        diskon,

        total,

        status,

        status_pembayaran

    )

    VALUES

    (?,?,?,?,?,?,?,?,?)

    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([

        $kode,

        $id_pelanggan,

        $id_pegawai,

        $tanggal,

        $subtotal,

        $diskon,

        $total,

        $status,

        $status_pembayaran

    ]);

    /*
    |--------------------------------------------------------------------------
    | Ambil ID Transaksi
    |--------------------------------------------------------------------------
    */

    $id_transaksi = $db->lastInsertId();

    /*
    |--------------------------------------------------------------------------
    | Simpan Detail Transaksi
    |--------------------------------------------------------------------------
    */

    $detail = "

    INSERT INTO detail_transaksi
    (

        id_transaksi,

        id_layanan,

        berat,

        harga,

        subtotal

    )

    VALUES

    (?,?,?,?,?)

    ";

    $stmtDetail = $db->prepare($detail);

    foreach($id_layanan as $i => $layanan){

        $stmtDetail->execute([

            $id_transaksi,

            $layanan,

            $berat[$i],

            $harga[$i],

            $subtotal_detail[$i]

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $db->commit();

    header("Location:index.php?success=Transaksi berhasil disimpan");

    exit;

}catch(PDOException $e){

    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    $db->rollBack();

    header("Location:create.php?error=" . urlencode($e->getMessage()));

    exit;

}

?>