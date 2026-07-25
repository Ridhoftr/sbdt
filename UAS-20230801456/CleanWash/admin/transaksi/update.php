<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

/*
|--------------------------------------------------------------------------
| Validasi Request
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location:index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Ambil Data
|--------------------------------------------------------------------------
*/

$id = intval($_POST['id_transaksi']);

$id_pelanggan = intval($_POST['id_pelanggan']);

$id_pegawai = intval($_POST['id_pegawai']);

$tanggal = $_POST['tanggal'];

$diskon = floatval($_POST['diskon']);

$status = $_POST['status'];

$status_pembayaran = $_POST['status_pembayaran'];

try {

    /*
    |--------------------------------------------------------------------------
    | Mulai Transaction
    |--------------------------------------------------------------------------
    */

    $db->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Ambil Subtotal Lama
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("

    SELECT subtotal

    FROM transaksi

    WHERE id_transaksi = ?

    ");

    $stmt->execute([$id]);

    $trx = $stmt->fetch();

    if (!$trx) {

        throw new Exception("Transaksi tidak ditemukan.");

    }

    $subtotal = $trx['subtotal'];

    /*
    |--------------------------------------------------------------------------
    | Hitung Total Baru
    |--------------------------------------------------------------------------
    */

    $total = $subtotal - $diskon;

    if ($total < 0) {

        $total = 0;

    }

    /*
    |--------------------------------------------------------------------------
    | Update Transaksi
    |--------------------------------------------------------------------------
    */

    $sql = "

    UPDATE transaksi

    SET

    id_pelanggan = ?,

    id_pegawai = ?,

    tanggal = ?,

    diskon = ?,

    total = ?,

    status = ?,

    status_pembayaran = ?

    WHERE id_transaksi = ?

    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([

        $id_pelanggan,

        $id_pegawai,

        $tanggal,

        $diskon,

        $total,

        $status,

        $status_pembayaran,

        $id

    ]);

    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $db->commit();

    header("Location:index.php?success=Transaksi berhasil diperbarui");

    exit;

} catch (Exception $e) {

    $db->rollBack();

    header("Location:index.php?error=" . urlencode($e->getMessage()));

    exit;

}