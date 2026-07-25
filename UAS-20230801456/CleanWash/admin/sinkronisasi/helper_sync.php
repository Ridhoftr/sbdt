<?php

require_once "../../config/database.php";

/*
|--------------------------------------------------------------------------
| Koneksi Database Pusat
|--------------------------------------------------------------------------
*/

$pusat = Database::pusat();

/*
|--------------------------------------------------------------------------
| Sinkron Pelanggan
|--------------------------------------------------------------------------
*/

function syncPelanggan($dbCabang, $dbPusat, $asalCabang)
{
    $sql = "
    SELECT *
    FROM pelanggan
    ";

    $stmt = $dbCabang->query($sql);

    $jumlah = 0;

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $insert = "

        INSERT INTO pelanggan
        (
            asal_cabang,
            id_pelanggan,
            kode_pelanggan,
            nama,
            telepon
        )

        VALUES
        (?,?,?,?,?)

        ON DUPLICATE KEY UPDATE

        kode_pelanggan=VALUES(kode_pelanggan),
        nama=VALUES(nama),
        telepon=VALUES(telepon)

        ";

        $dbPusat->prepare($insert)->execute([

            $asalCabang,

            $row['id_pelanggan'],

            $row['kode_pelanggan'],

            $row['nama'],

            $row['telepon']

        ]);

        $jumlah++;

    }

    return $jumlah;
}

/*
|--------------------------------------------------------------------------
| Sinkron Pegawai
|--------------------------------------------------------------------------
*/

function syncPegawai($dbCabang,$dbPusat,$asalCabang)
{

    $stmt = $dbCabang->query("

    SELECT *

    FROM pegawai

    ");

    $jumlah = 0;

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $sql = "

        INSERT INTO pegawai
        (
            asal_cabang,
            id_pegawai,
            nama,
            jabatan,
            telepon
        )

        VALUES
        (?,?,?,?,?)

        ON DUPLICATE KEY UPDATE

        nama=VALUES(nama),

        jabatan=VALUES(jabatan),

        telepon=VALUES(telepon)

        ";

        $dbPusat->prepare($sql)->execute([

            $asalCabang,

            $row['id_pegawai'],

            $row['nama'],

            $row['jabatan'],

            $row['telepon']

        ]);

        $jumlah++;

    }

    return $jumlah;

}

/*
|--------------------------------------------------------------------------
| Sinkron Transaksi
|--------------------------------------------------------------------------
*/

function syncTransaksi($dbCabang,$dbPusat,$asalCabang)
{

    $sql = "

    SELECT *

    FROM transaksi

    ";

    $stmt=$dbCabang->query($sql);

    $jumlah=0;

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        $insert="

        INSERT INTO transaksi
        (
            asal_cabang,
            id_transaksi,
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

        (?,?,?,?,?,?,?,?,?,?,?)

        ON DUPLICATE KEY UPDATE

        kode_transaksi=VALUES(kode_transaksi),

        id_pelanggan=VALUES(id_pelanggan),

        id_pegawai=VALUES(id_pegawai),

        tanggal=VALUES(tanggal),

        subtotal=VALUES(subtotal),

        diskon=VALUES(diskon),

        total=VALUES(total),

        status=VALUES(status),

        status_pembayaran=VALUES(status_pembayaran)

        ";

        $dbPusat->prepare($insert)->execute([

            $asalCabang,

             $row['id_transaksi'],

            $row['kode_transaksi'],

            $row['id_pelanggan'],

            $row['id_pegawai'],

            $row['tanggal'],

            $row['subtotal'],

            $row['diskon'],

            $row['total'],

            $row['status'],

            $row['status_pembayaran']

        ]);

        $jumlah++;

    }

    return $jumlah;

}

/*
|--------------------------------------------------------------------------
| Simpan Log Sinkronisasi
|--------------------------------------------------------------------------
*/

function simpanLog($dbPusat,$asalCabang,$jumlah,$status,$keterangan)
{

    $sql="

    INSERT INTO sinkronisasi_log

    (

    asal_cabang,

    jumlah_data,

    status,

    keterangan

    )

    VALUES

    (?,?,?,?)

    ";

    $dbPusat->prepare($sql)->execute([

        $asalCabang,

        $jumlah,

        $status,

        $keterangan

    ]);

}

/*
|--------------------------------------------------------------------------
| Sinkron Hapus Pelanggan
|--------------------------------------------------------------------------
*/

function hapusPelangganTidakAktif($dbCabang,$dbPusat,$asalCabang)
{

    $ids=[];

    $stmt=$dbCabang->query("
    SELECT id_pelanggan
    FROM pelanggan
    ");

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        $ids[]=$row['id_pelanggan'];

    }

    if(count($ids)>0){

        $placeholder=implode(",",array_fill(0,count($ids)," ? "));

        $sql="

        DELETE

        FROM pelanggan

        WHERE asal_cabang=?

        AND id_pelanggan NOT IN ($placeholder)

        ";

        $param=array_merge([$asalCabang],$ids);

    }else{

        $sql="

        DELETE

        FROM pelanggan

        WHERE asal_cabang=?

        ";

        $param=[$asalCabang];

    }

    $dbPusat->prepare($sql)->execute($param);

}

/*
|--------------------------------------------------------------------------
| Sinkron Hapus Pegawai
|--------------------------------------------------------------------------
*/

function hapusPegawaiTidakAktif($dbCabang,$dbPusat,$asalCabang)
{

    $ids=[];

    $stmt=$dbCabang->query("
    SELECT id_pegawai
    FROM pegawai
    ");

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        $ids[]=$row['id_pegawai'];

    }

    if(count($ids)>0){

        $placeholder=implode(",",array_fill(0,count($ids)," ? "));

        $sql="

        DELETE

        FROM pegawai

        WHERE asal_cabang=?

        AND id_pegawai NOT IN ($placeholder)

        ";

        $param=array_merge([$asalCabang],$ids);

    }else{

        $sql="

        DELETE

        FROM pegawai

        WHERE asal_cabang=?

        ";

        $param=[$asalCabang];

    }

    $dbPusat->prepare($sql)->execute($param);

}

/*
|--------------------------------------------------------------------------
| Sinkron Hapus Transaksi
|--------------------------------------------------------------------------
*/

function hapusTransaksiTidakAktif($dbCabang,$dbPusat,$asalCabang)
{

    $ids=[];

    $stmt=$dbCabang->query("
    SELECT id_transaksi
    FROM transaksi
    ");

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        $ids[]=$row['id_transaksi'];

    }

    if(count($ids)>0){

        $placeholder=implode(",",array_fill(0,count($ids)," ? "));

        $sql="

        DELETE

        FROM transaksi

        WHERE asal_cabang=?

        AND id_transaksi NOT IN ($placeholder)

        ";

        $param=array_merge([$asalCabang],$ids);

    }else{

        $sql="

        DELETE

        FROM transaksi

        WHERE asal_cabang=?

        ";

        $param=[$asalCabang];

    }

    $dbPusat->prepare($sql)->execute($param);

}