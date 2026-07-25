<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pegawai";

/*
|--------------------------------------------------------------------------
| Data Pegawai
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM pegawai
ORDER BY id_pegawai DESC
";

$stmt = $db->query($sql);

$pegawai = $stmt->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">

                    Data Pegawai

                </h4>

                <a href="create.php" class="btn btn-primary">

                    <i class="bi bi-plus-circle"></i>

                    Tambah Pegawai

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                id="tablePegawai"
                    class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">

                    <tr>

                        <th width="60">No</th>

                        <th>Kode</th>

                        <th>Nama</th>

                        <th>Jabatan</th>

                        <th>Telepon</th>

                        <th>Alamat</th>

                        <th width="170">Aksi</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    if(count($pegawai)>0):

                    $no = 1;

                    foreach($pegawai as $row):

                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td><?= $row['kode_pegawai'] ?></td>

                        <td><?= $row['nama'] ?></td>

                        <td>

                            <span class="badge bg-primary">

                            <?= $row['jabatan'] ?>

                            </span>

                        </td>

                        <td><?= $row['telepon'] ?></td>

                        <td><?= $row['alamat'] ?></td>

                        <td>

                            <a
                                href="edit.php?id=<?= $row['id_pegawai'] ?>"
                                class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <button
                                class="btn btn-danger btn-sm btn-delete"
                                data-id="<?= $row['id_pegawai'] ?>">

                                <i class="bi bi-trash"></i>

                            </button>

                        </td>

                    </tr>

                    <?php

                    endforeach;

                    else:

                    ?>

                    <tr>

                        <td colspan="6" class="text-center">

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

document.querySelectorAll(".btn-delete").forEach(function(button){

    button.addEventListener("click",function(){

        let id=this.dataset.id;

        Swal.fire({

            title:'Hapus Data?',

            text:'Data pegawai akan dihapus.',

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

    $('#tablePegawai').DataTable({

        responsive:{
            details:true
        },

        autoWidth:false,

        order:[[1,'asc']],

         columnDefs:[
            {
                orderable:false,
                targets:[5]
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