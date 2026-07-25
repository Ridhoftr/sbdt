<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pelanggan";

/*
|--------------------------------------------------------------------------
| Generate Kode Pelanggan Otomatis
|--------------------------------------------------------------------------
*/

$stmt = $db->query("
SELECT kode_pelanggan
FROM pelanggan
ORDER BY id_pelanggan DESC
LIMIT 1
");

$data = $stmt->fetch();

if ($data) {

    $angka = (int) substr($data['kode_pelanggan'], -4);

    $angka++;

} else {

    $angka = 1;

}

$kodePelanggan =
    "PLG-" .
    KODE_CABANG .
    "-" .
    str_pad($angka,4,"0",STR_PAD_LEFT);

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                Tambah Pelanggan

            </h4>

        </div>

        <div class="card-body">

            <form action="store.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Kode Pelanggan

                    </label>

                    <input
                        type="text"
                        name="kode_pelanggan"
                        class="form-control"
                        value="<?= $kodePelanggan ?>"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nama Pelanggan

                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nomor Telepon

                    </label>

                    <input
                        type="text"
                        name="telepon"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Alamat

                    </label>

                    <textarea
                        name="alamat"
                        rows="4"
                        class="form-control"
                        required></textarea>

                </div>

                <div class="text-end">

                    <a
                        href="index.php"
                        class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Kembali

                    </a>

                    <button
                        class="btn btn-primary"
                        type="submit">

                        <i class="bi bi-save"></i>

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include "../../templates/footer.php"; ?>