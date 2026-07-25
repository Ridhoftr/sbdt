<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "laporan";

/*
|--------------------------------------------------------------------------
| Filter
|--------------------------------------------------------------------------
*/

$tglAwal  = $_GET['tgl_awal'] ?? "";
$tglAkhir = $_GET['tgl_akhir'] ?? "";
$status   = $_GET['status'] ?? "";
$bayar    = $_GET['bayar'] ?? "";

$sql = "

SELECT

t.*,

p.nama AS pelanggan,

g.nama AS pegawai

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan=p.id_pelanggan

JOIN pegawai g
ON t.id_pegawai=g.id_pegawai

WHERE 1=1

";

$params = [];

if($tglAwal!=""){

    $sql.=" AND t.tanggal>=? ";

    $params[]=$tglAwal;

}

if($tglAkhir!=""){

    $sql.=" AND t.tanggal<=? ";

    $params[]=$tglAkhir;

}

if($status!=""){

    $sql.=" AND t.status=? ";

    $params[]=$status;

}

if($bayar!=""){

    $sql.=" AND t.status_pembayaran=? ";

    $params[]=$bayar;

}


$sql.=" ORDER BY t.id_transaksi DESC ";

$stmt=$db->prepare($sql);

$stmt->execute($params);

$data=$stmt->fetchAll();

$totalPendapatan=0;

foreach($data as $d){

    $totalPendapatan+=$d['total'];

}

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <h4 class="mb-0">

                Laporan Transaksi

            </h4>

        </div>
        
    <div class="card-body">
        
        <!-- FILTER -->
        <form method="GET" class="row mb-4">

            <div class="col-md-2">

                <input
                    type="date"
                    name="tgl_awal"
                    class="form-control"
                    value="<?= $tglAwal ?>">

            </div>

            <div class="col-md-2">

                <input
                    type="date"
                    name="tgl_akhir"
                    class="form-control"
                    value="<?= $tglAkhir ?>">

            </div>

            <div class="col-md-2">

                <select
                    name="status"
                    class="form-select">

                    <option value="">Semua Status</option>
                    <option
                    value="Diproses"
                    <?= $status=="Diproses" ? "selected" : "" ?>>

                    Diproses

                    </option>

                    <option
                    value="Selesai"
                    <?= $status=="Selesai" ? "selected" : "" ?>>

                    Selesai

                    </option>

                    <option
                    value="Diambil"
                    <?= $status=="Diambil" ? "selected" : "" ?>>

                    Diambil

                    </option>

                </select>

            </div>

            <div class="col-md-2">

                <select
                    name="bayar"
                    class="form-select">

                    <option value="">Semua Pembayaran</option>

                    <option
                    value="Belum Lunas"
                    <?= $bayar=="Belum Lunas" ? "selected" : "" ?>>

                    Belum Lunas

                    </option>

                    <option
                    value="Lunas"
                    <?= $bayar=="Lunas" ? "selected" : "" ?>>

                    Lunas

                    </option>

                </select>

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    Filter

                </button>

            </div>

            <div class="col-md-2">

                <a
                    href="index.php"
                    class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

       </form>

        <!-- CARD RINGKASAN -->
        <div class="row mb-3">

            <div class="col-md-4">

                <div class="card border-success">

                    <div class="card-body">

                        <h6>
                            <i class="bi bi-receipt"></i>

                            Total Transaksi
                        </h6>

                        <h2><?= count($data) ?></h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-primary">

                    <div class="card-body">

                        <h6>
                            <i class="bi bi-cash-stack"></i>

                            Total Pendapatan
                        </h6>

                        <h3><?= rupiah($totalPendapatan) ?></h3>

                    </div>

                </div>

            </div>

        </div>

        <!-- TABEL LAPORAN -->
        <div class="table-responsive">

            <table id="tableLaporan" class="table table-bordered table-striped table-hover align-middle">

                <thead class="table-primary">

                    <tr>
                        <th>No</th>

                        <th>Kode</th>

                        <th>Tanggal</th>

                        <th>Pelanggan</th>

                        <th>Pegawai</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th>Pembayaran</th>

                    </tr>

                    </thead>

                    <tbody>

                        <?php

                        if(count($data)>0):

                        $no=1;

                        foreach($data as $row):


                        ?>

                    <tr>

                        <td class="text-center"><?= $no++ ?></td>

                        <td><?= $row['kode_transaksi'] ?></td>

                        <td 
                        class="text-center"
                        data-order="<?= $row['tanggal'] ?>">>

                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>

                        </td>

                        <td><?= $row['pelanggan'] ?></td>

                        <td><?= $row['pegawai'] ?></td>

                        <td class="text-end">

                        <?= rupiah($row['total']) ?>

                        </td>

                        <td>
                            <?php
                            
                            if($row['status']=="Diproses"){

                                echo "<span class='badge bg-warning text-dark'>Diproses</span>";

                                }elseif($row['status']=="Selesai"){

                                    echo "<span class='badge bg-info'>Selesai</span>";

                                    }else{

                                        echo "<span class='badge bg-success'>Diambil</span>";

                                }

                            ?>

                        </td>

                        <td>

                            <?php

                            if($row['status_pembayaran']=="Lunas"){

                                echo "<span class='badge bg-success'>Lunas</span>";

                                }else{

                                    echo "<span class='badge bg-danger'>Belum Lunas</span>";

                                }

                            ?>

                        </td>

                    </tr>

                    <?php endforeach; 
                    
                        else:
                        
                        ?>

                        <tr>

                        <td colspan="8" class="text-center">

                        Tidak ada data.

                        </td>

                        </tr>

                        <?php endif; ?>

                    </tbody>

            </table>

        </div>

    </div>

</div>

</div>

<script>

    $(document).ready(function(){

        $('#tableLaporan').DataTable({

        responsive:true,

        autoWidth:false,

        order:[[2,'desc']],

        pageLength:10,

        lengthMenu:[
            [10,25,50,-1],
            [10,25,50,"Semua"]
        ],

        dom:'Bfrtip',

        buttons:[

            'copy',

            'excel',

            'csv',

            'pdf',

            'print'

            ]

        });

    });

</script>

<?php include "../../templates/footer.php"; ?>