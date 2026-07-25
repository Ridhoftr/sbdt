<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "layanan";

/*
|--------------------------------------------------------------------------
| Ambil ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {

    header("Location:index.php");
    exit;

}

$id = intval($_GET['id']);

/*
|--------------------------------------------------------------------------
| Ambil Data
|--------------------------------------------------------------------------
*/

$sql = "

SELECT *

FROM layanan

WHERE id_layanan = ?

LIMIT 1

";

$stmt = $db->prepare($sql);

$stmt->execute([$id]);

$layanan = $stmt->fetch();

if (!$layanan) {

    header("Location:index.php?error=Data layanan tidak ditemukan");
    exit;

}

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <h4 class="mb-0">

                Edit Layanan

            </h4>

        </div>

        <div class="card-body">

            <form action="update.php" method="POST">

                <input
                    type="hidden"
                    name="id_layanan"
                    value="<?= $layanan['id_layanan'] ?>">

                <div class="mb-3">

                    <label class="form-label">

                        Kode Layanan

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= $layanan['kode_layanan'] ?>"
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
                        value="<?= htmlspecialchars($layanan['nama_layanan']) ?>"
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
                        value="<?= $layanan['harga_perkg'] ?>"
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
                        value="<?= htmlspecialchars($layanan['estimasi']) ?>"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Status

                    </label>

                    <select
                        class="form-select"
                        name="status">

                        <option
                            value="aktif"
                            <?= $layanan['status']=="aktif" ? "selected" : "" ?>>

                            Aktif

                        </option>

                        <option
                            value="nonaktif"
                            <?= $layanan['status']=="nonaktif" ? "selected" : "" ?>>

                            Nonaktif

                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Update

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