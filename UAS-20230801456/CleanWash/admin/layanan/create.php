<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "layanan";

/*
|--------------------------------------------------------------------------
| Generate Kode Layanan
|--------------------------------------------------------------------------
*/

$query = $db->query("
    SELECT MAX(id_layanan) AS terakhir
    FROM layanan
");

$data = $query->fetch();

$no = ($data['terakhir'] ?? 0) + 1;

$kode = "LYN" . str_pad($no, 4, "0", STR_PAD_LEFT);

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <h4 class="mb-0">

                Tambah Layanan

            </h4>

        </div>

        <div class="card-body">

            <form action="store.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Kode Layanan

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="kode_layanan"
                        value="<?= $kode ?>"
                        readonly>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nama Layanan

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="nama_layanan"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Harga per Kg

                    </label>

                    <input
                        type="number"
                        class="form-control"
                        name="harga_perkg"
                        min="0"
                        step="1000"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Estimasi

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="estimasi"
                        placeholder="Contoh : 2 Hari"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Status

                    </label>

                    <select
                        class="form-select"
                        name="status"
                        required>

                        <option value="aktif">

                            Aktif

                        </option>

                        <option value="nonaktif">

                            Nonaktif

                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

<?php include "../../templates/footer.php"; ?>