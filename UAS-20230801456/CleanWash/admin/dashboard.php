<?php

require_once "../config/auth.php";
require_once "../config/helper.php";
require_once "../config/connection.php";

$page = "dashboard";

/*
|--------------------------------------------------------------------------
| Statistik Dashboard
|--------------------------------------------------------------------------
*/

// Total Pelanggan
$stmt = $db->query("SELECT COUNT(*) AS total FROM pelanggan");
$totalPelanggan = $stmt->fetch()['total'];

// Total Pegawai
$stmt = $db->query("SELECT COUNT(*) AS total FROM pegawai");
$totalPegawai = $stmt->fetch()['total'];

// Total Layanan
$stmt = $db->query("SELECT COUNT(*) AS total FROM layanan");
$totalLayanan = $stmt->fetch()['total'];

// Total Transaksi
$stmt = $db->query("SELECT COUNT(*) AS total FROM transaksi");
$totalTransaksi = $stmt->fetch()['total'];

// Total Pendapatan
$stmt = $db->query("SELECT COALESCE(SUM(total),0) AS total FROM transaksi");
$totalPendapatan = $stmt->fetch()['total'];

// Grafik Pendatan Bulanan
$chartData = [];

for ($i = 1; $i <= 12; $i++) {

    $stmt = $db->prepare("
        SELECT COALESCE(SUM(total),0) AS total
        FROM transaksi
        WHERE MONTH(tanggal)=?
    ");

    $stmt->execute([$i]);

    $chartData[] = (int)$stmt->fetch()['total'];
}

/*
|--------------------------------------------------------------------------
| Status Laundry
|--------------------------------------------------------------------------
*/

$diproses = $db->query("
SELECT COUNT(*)
FROM transaksi
WHERE status='Diproses'
")->fetchColumn();

$selesai = $db->query("
SELECT COUNT(*)
FROM transaksi
WHERE status='Selesai'
")->fetchColumn();

$diambil = $db->query("
SELECT COUNT(*)
FROM transaksi
WHERE status='Diambil'
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| Status Pembayaran
|--------------------------------------------------------------------------
*/

$lunas = $db->query("
SELECT COUNT(*)
FROM transaksi
WHERE status_pembayaran='Lunas'
")->fetchColumn();

$belumLunas = $db->query("
SELECT COUNT(*)
FROM transaksi
WHERE status_pembayaran='Belum Lunas'
")->fetchColumn();

/*
|--------------------------------------------------------------------------
| Top 5 Layanan
|--------------------------------------------------------------------------
*/

$topLayanan = $db->query("
SELECT

l.nama_layanan,

COUNT(dt.id_layanan) AS jumlah

FROM detail_transaksi dt

JOIN layanan l
ON dt.id_layanan=l.id_layanan

GROUP BY dt.id_layanan

ORDER BY jumlah DESC

LIMIT 5
")->fetchAll();

/*
|--------------------------------------------------------------------------
| 5 Transaksi Terbaru
|--------------------------------------------------------------------------
*/

$transaksiTerbaru = $db->query("
SELECT

t.kode_transaksi,

p.nama,

t.total,

t.status,

t.status_pembayaran

FROM transaksi t

JOIN pelanggan p
ON t.id_pelanggan=p.id_pelanggan

ORDER BY t.id_transaksi DESC

LIMIT 5
")->fetchAll();

include "../templates/header.php";
include "../templates/sidebar.php";
include "../templates/navbar.php";

?>

<div class="content">

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Total Pelanggan</h6>

                            <h2><?= $totalPelanggan ?></h2>

                        </div>

                        <div class="card-icon text-primary">

                            <i class="bi bi-people-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Total Pegawai</h6>

                            <h2><?= $totalPegawai ?></h2>

                        </div>

                        <div class="card-icon text-success">

                            <i class="bi bi-person-badge-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Total Transaksi</h6>

                            <h2><?= $totalTransaksi ?></h2>

                        </div>

                        <div class="card-icon text-warning">

                            <i class="bi bi-basket-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Pendapatan</h6>

                            <h2><?= rupiah($totalPendapatan) ?></h2>

                        </div>

                        <div class="card-icon text-danger">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Total Layanan</h6>

                            <h2><?= $totalLayanan ?></h2>

                        </div>

                        <div class="card-icon text-info">

                            <i class="bi bi-box-seam"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card card-dashboard border-warning">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Diproses</h6>

                            <h2><?= $diproses ?></h2>

                        </div>

                        <div class="card-icon text-warning">

                            <i class="bi bi-hourglass-split"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card card-dashboard border-info">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Selesai</h6>

                            <h2><?= $selesai ?></h2>

                        </div>

                        <div class="card-icon text-info">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card card-dashboard border-success">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6>Diambil</h6>

                            <h2><?= $diambil ?></h2>

                        </div>

                        <div class="card-icon text-success">

                            <i class="bi bi-bag-check-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- Grafik Pendapatan -->

        <div class="col-lg-8 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <h5 class="mb-3">

                        <i class="bi bi-bar-chart-fill"></i>

                        Pendapatan Bulanan

                    </h5>

                    <canvas id="chartPendapatan"></canvas>

                </div>

            </div>

        </div>

        <!-- Status Laundry -->

        <div class="col-lg-4 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <h5 class="mb-3">

                        <i class="bi bi-pie-chart-fill"></i>

                        Status Laundry

                    </h5>

                    <canvas id="chartStatus"></canvas>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

    <!-- Status Pembayaran -->

    <div class="col-lg-4 mb-4">

        <div class="card card-dashboard">

            <div class="card-body">

                <h5 class="mb-3">

                    <i class="bi bi-wallet2"></i>

                    Status Pembayaran

                </h5>

                <canvas id="chartPembayaran"></canvas>

            </div>

        </div>

    </div>

        <!-- Top Layanan -->

        <div class="col-lg-8 mb-4">

            <div class="card card-dashboard">

                <div class="card-body">

                    <h5 class="mb-3">

                        <i class="bi bi-star-fill"></i>

                        Top 5 Layanan Terlaris

                    </h5>

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">

                            <thead class="table-primary">

                                <tr>

                                    <th width="60">No</th>

                                    <th>Nama Layanan</th>

                                    <th width="180">Jumlah Digunakan</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php

                            if(count($topLayanan)>0):

                            $no=1;

                            foreach($topLayanan as $row):

                            ?>

                            <tr>

                                <td><?= $no++ ?></td>

                                <td><?= $row['nama_layanan'] ?></td>

                                <td><?= $row['jumlah'] ?> kali</td>

                            </tr>

                            <?php

                            endforeach;

                            else:

                            ?>

                            <tr>

                                <td colspan="3" class="text-center">

                                    Belum ada data.

                                </td>

                            </tr>

                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="card card-dashboard">

            <div class="card-body">

                <h5 class="mb-3">

                    <i class="bi bi-clock-history"></i>

                    5 Transaksi Terbaru

                </h5>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-primary">

                            <tr>

                                <th>Kode</th>

                                <th>Pelanggan</th>

                                <th>Total</th>

                                <th>Status Laundry</th>

                                <th>Pembayaran</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                        if(count($transaksiTerbaru)>0):

                        foreach($transaksiTerbaru as $row):

                        ?>

                        <tr>

                            <td>

                                <?= $row['kode_transaksi'] ?>

                            </td>

                            <td>

                                <?= $row['nama'] ?>

                            </td>

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

                        <?php

                        endforeach;

                        else:

                        ?>

                        <tr>

                            <td colspan="5" class="text-center">

                                Belum ada transaksi.

                            </td>

                        </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('chartPendapatan');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [

            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'

        ],

        datasets: [{

            label: 'Pendapatan (Rp)',

            data: <?= json_encode($chartData); ?>

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: true

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});

const statusCtx = document.getElementById('chartStatus');

new Chart(statusCtx,{

    type:'pie',

    data:{

        labels:[

            'Diproses',

            'Selesai',

            'Diambil'

        ],

        datasets:[{

            data:[

                <?= $diproses ?>,

                <?= $selesai ?>,

                <?= $diambil ?>

            ]

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                position:'bottom'

            }

        }

    }

});

const pembayaranCtx = document.getElementById('chartPembayaran');

new Chart(pembayaranCtx,{

    type:'pie',

    data:{

        labels:[

            'Lunas',

            'Belum Lunas'

        ],

        datasets:[{

            data:[

                <?= $lunas ?>,

                <?= $belumLunas ?>

            ]

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                position:'bottom'

            }

        }

    }

});

</script>

<?php

include "../templates/footer.php";

?>