<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "layanan";

/*
|--------------------------------------------------------------------------
| Data Layanan
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM layanan
ORDER BY id_layanan DESC
";

$stmt = $db->query($sql);

$layanan = $stmt->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">

                    Data Layanan

                </h4>

                <a href="create.php" class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Tambah Layanan

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                    id="tableLayanan"
                    class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">

                    <tr>

                        <th width="60">No</th>

                        <th>Kode</th>

                        <th>Nama Layanan</th>

                        <th>Harga / Kg</th>

                        <th>Estimasi</th>

                        <th>Status</th>

                        <th width="170">Aksi</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php if(count($layanan)>0): ?>

                        <?php $no=1; ?>

                        <?php foreach($layanan as $row): ?>

                        <tr>

                            <td><?= $no++ ?></td>

                            <td><?= $row['kode_layanan'] ?></td>

                            <td><?= $row['nama_layanan'] ?></td>

                            <td><?= rupiah($row['harga_perkg']) ?></td>

                            <td><?= $row['estimasi'] ?></td>

                            <td>

                                <?php if($row['status']=="aktif"): ?>

                                    <span class="badge bg-success">

                                        Aktif

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">

                                        Nonaktif

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="edit.php?id=<?= $row['id_layanan'] ?>"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <button
                                    class="btn btn-danger btn-sm btn-delete"
                                    data-id="<?= $row['id_layanan'] ?>">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="text-center">

                                Belum ada data layanan.

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

document.querySelectorAll(".btn-delete").forEach(function(button){

    button.addEventListener("click",function(){

        let id=this.dataset.id;

        Swal.fire({

            title:'Hapus Data?',

            text:'Data layanan akan dihapus.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonText:'Ya, Hapus',

            cancelButtonText:'Batal',

            confirmButtonColor:'#dc3545'

        }).then((result)=>{

            if(result.isConfirmed){

                window.location='delete.php?id='+id;

            }

        });

    });

});

</script>

<script>

$(document).ready(function(){

    $('#tableLayanan').DataTable({

        responsive:{
            details:true
        },

        autoWidth:false,

        order:[[1,'asc']],

        columnDefs:[
            {
                orderable:false,
                targets:[6]
            }
        ],

        pageLength:10,

        dom:'Bfrtip',

        buttons:[

            {
                extend:'copy',
                text:'<i class="bi bi-copy"></i> Copy',
                className:'btn btn-secondary'
            },

            {
                extend:'excel',
                text:'<i class="bi bi-file-earmark-excel"></i> Excel',
                className:'btn btn-success'
            },

            {
                extend:'csv',
                text:'<i class="bi bi-filetype-csv"></i> CSV',
                className:'btn btn-info'
            },

            {
                extend:'pdf',
                text:'<i class="bi bi-file-earmark-pdf"></i> PDF',
                className:'btn btn-danger'
            },

            {
                extend:'print',
                text:'<i class="bi bi-printer"></i> Print',
                className:'btn btn-primary'
            }

        ],

        language:{

            search:"Cari :",

            lengthMenu:"Tampilkan _MENU_ data",

            info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            zeroRecords:"Data tidak ditemukan",

            paginate:{

                first:"Awal",

                last:"Akhir",

                next:"→",

                previous:"←"

            }

        }

    });

});

</script>

<?php include "../../templates/footer.php"; ?>