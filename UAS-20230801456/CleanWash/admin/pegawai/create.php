<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pegawai";

/*
|--------------------------------------------------------------------------
| Generate Kode Pegawai Otomatis
|--------------------------------------------------------------------------
*/

$stmt = $db->query("
SELECT kode_pegawai
FROM pegawai
ORDER BY id_pegawai DESC
LIMIT 1
");

$data = $stmt->fetch();

if($data){

    $angka = (int) substr($data['kode_pegawai'], -4);

    $angka++;

}else{

    $angka = 1;

}

$kodePegawai =
    "PGW-" .
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

                Tambah Pegawai

            </h4>

        </div>

        <div class="card-body">

            <form action="store.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Kode Pegawai

                    </label>

                    <input
                        type="text"
                        name="kode_pegawai"
                        class="form-control"
                        value="<?= $kodePegawai ?>"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nama Pegawai

                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Jabatan

                    </label>

                    <select
                        name="jabatan"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Kasir">Kasir</option>
                        <option value="Operator Laundry">Operator Laundry</option>
                        <option value="Kurir">Kurir</option>
                        <option value="Supervisor">Supervisor</option>

                    </select>

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