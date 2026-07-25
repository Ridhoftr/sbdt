<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";
require_once "helper_sync.php";

/*
|--------------------------------------------------------------------------
| Cabang Aktif
|--------------------------------------------------------------------------
*/

$asalCabang = $_SESSION['cabang'];

$dbCabang = $db;
$dbPusat  = Database::pusat();

try{

    /*
    |--------------------------------------------------------------------------
    | Mulai Transaction
    |--------------------------------------------------------------------------
    */

    $dbPusat->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Sinkronisasi
    |--------------------------------------------------------------------------
    */

    $pelanggan = syncPelanggan(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    $pegawai = syncPegawai(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    $transaksi = syncTransaksi(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    /*
    |--------------------------------------------------------------------------
    | Sinkronisasi Penghapusan Data
    |--------------------------------------------------------------------------
    */

    hapusPelangganTidakAktif(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    hapusPegawaiTidakAktif(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    hapusTransaksiTidakAktif(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    /*
    |--------------------------------------------------------------------------
    | Hapus Data Yang Sudah Tidak Ada
    |--------------------------------------------------------------------------
    */

    /*
    hapusPelangganTidakAda(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    hapusPegawaiTidakAda(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );

    hapusTransaksiTidakAda(
        $dbCabang,
        $dbPusat,
        $asalCabang
    );
    */

    /*
    |--------------------------------------------------------------------------
    | Total Data
    |--------------------------------------------------------------------------
    */

    $total = $pelanggan + $pegawai + $transaksi;

    /*
    |--------------------------------------------------------------------------
    | Simpan Log
    |--------------------------------------------------------------------------
    */

    simpanLog(

        $dbPusat,

        $asalCabang,

        $total,

        "berhasil",

        "Sinkronisasi berhasil."

    );

    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $dbPusat->commit();

    header("Location:index.php?success=Sinkronisasi berhasil");

    exit;

}catch(Exception $e){

    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    if($dbPusat->inTransaction()){

        $dbPusat->rollBack();

    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Log Error
    |--------------------------------------------------------------------------
    */

    simpanLog(

        $dbPusat,

        $asalCabang,

        0,

        "gagal",

        $e->getMessage()

    );

    header(

        "Location:index.php?error=" .

        urlencode($e->getMessage())

    );

    exit;

}