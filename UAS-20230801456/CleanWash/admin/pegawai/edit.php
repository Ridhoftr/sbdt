<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pegawai";

/*
|--------------------------------------------------------------------------
| Validasi ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {

    header("Location: index.php");

    exit;

}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| Ambil Data Pegawai
|--------------------------------------------------------------------------
*/

$stmt = $db->prepare("
SELECT *
FROM pegawai
WHERE id_pegawai=?
LIMIT 1
");

$stmt->execute([$id]);

$pegawai = $stmt->fetch();

if (!$pegawai) {

    header("Location: index.php?error=Data tidak ditemukan");

    exit;

}

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4 class="mb-0">

                Edit Pegawai

            </h4>

        </div>

        <div class="card-body">

            <form action="update.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $pegawai['id_pegawai'] ?>">

        <div class="mb-3">

            <label class="form-label">

                Kode Pegawai

            </label>

            <input
                type="text"
                class="form-control"
                value="<?= $pegawai['kode_pegawai'] ?>"
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
                value="<?= htmlspecialchars($pegawai['nama']) ?>"
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

                Telepon

            </label>

            <input
                type="text"
                name="telepon"
                class="form-control"
                value="<?= htmlspecialchars($pegawai['telepon']) ?>"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Alamat

            </label>

            <textarea
                name="alamat"
                class="form-control"
                rows="4"
                required><?= htmlspecialchars($pegawai['alamat']) ?></textarea>

        </div>

        <div class="text-end">

            <a
                href="index.php"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Kembali

            </a>

            <button
                type="submit"
                class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Update

            </button>

        </div>

    </form>

</div>

</div>

</div>

<?php include "../../templates/footer.php"; ?>