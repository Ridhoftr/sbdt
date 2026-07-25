<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    redirect("index.php");
}

$idTransaksi = $_POST['id_transaksi'];
$tanggal     = $_POST['tanggal'];
$metode      = $_POST['metode'];
$jumlah      = $_POST['jumlah'];
$total       = $_POST['total'];

try {

    /*
    |--------------------------------------------------------------------------
    | Mulai Transaction
    |--------------------------------------------------------------------------
    */

    $db->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Ambil Data Transaksi
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        SELECT *
        FROM transaksi
        WHERE id_transaksi = ?
    ");

    $stmt->execute([$idTransaksi]);

    $transaksi = $stmt->fetch();

    if (!$transaksi) {
        throw new Exception("Transaksi tidak ditemukan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Sudah Lunas?
    |--------------------------------------------------------------------------
    */

    if ($transaksi['status_pembayaran'] == "Lunas") {
        throw new Exception("Transaksi sudah dibayar.");
    }

    /*
    |--------------------------------------------------------------------------
    | Validasi Jumlah Pembayaran
    |--------------------------------------------------------------------------
    */

    if ($jumlah < $total) {
        throw new Exception("Jumlah pembayaran kurang.");
    }

    /*
    |--------------------------------------------------------------------------
    | Cek Data Pembayaran
    |--------------------------------------------------------------------------
    */

    $cek = $db->prepare("
        SELECT COUNT(*) 
        FROM pembayaran
        WHERE id_transaksi=?
    ");

    $cek->execute([$idTransaksi]);

    if ($cek->fetchColumn() > 0) {
        throw new Exception("Pembayaran sudah pernah dilakukan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Pembayaran
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        INSERT INTO pembayaran
        (
            id_transaksi,
            tanggal,
            metode,
            jumlah,
            status
        )
        VALUES
        (
            ?,?,?,?,
            'Lunas'
        )
    ");

    $stmt->execute([

        $idTransaksi,

        $tanggal,

        $metode,

        $jumlah

    ]);

    /*
    |--------------------------------------------------------------------------
    | Update Status Pembayaran
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare("
        UPDATE transaksi
        SET status_pembayaran='Lunas'
        WHERE id_transaksi=?
    ");

    $stmt->execute([$idTransaksi]);

    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $db->commit();

    header("Location:index.php?success=Pembayaran berhasil disimpan");

    exit;

} catch (Exception $e) {

    if ($db->inTransaction()) {
        $db->rollBack();
    }

    header("Location:index.php?error=" . urlencode($e->getMessage()));

    exit;
}