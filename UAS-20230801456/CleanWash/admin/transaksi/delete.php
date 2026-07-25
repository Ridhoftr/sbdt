<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

/*
|--------------------------------------------------------------------------
| Validasi ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {

    header("Location:index.php?error=ID transaksi tidak ditemukan");
    exit;

}

$id = intval($_GET['id']);

try {

    /*
    |--------------------------------------------------------------------------
    | Cek Data
    |--------------------------------------------------------------------------
    */

    $cek = $db->prepare("
        SELECT id_transaksi
        FROM transaksi
        WHERE id_transaksi = ?
    ");

    $cek->execute([$id]);

    if ($cek->rowCount() == 0) {

        header("Location:index.php?error=Data transaksi tidak ditemukan");
        exit;

    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Transaksi
    |--------------------------------------------------------------------------
    */

    $hapus = $db->prepare("
        DELETE FROM transaksi
        WHERE id_transaksi = ?
    ");

    $hapus->execute([$id]);

    header("Location:index.php?success=Transaksi berhasil dihapus");
    exit;

} catch (PDOException $e) {

    header("Location:index.php?error=" . urlencode($e->getMessage()));
    exit;

}