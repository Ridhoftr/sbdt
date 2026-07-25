<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "pelanggan";

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
| Ambil Data Pelanggan
|--------------------------------------------------------------------------
*/

$stmt = $db->prepare("
SELECT *
FROM pelanggan
WHERE id_pelanggan=?
LIMIT 1
");

$stmt->execute([$id]);

$pelanggan = $stmt->fetch();

if (!$pelanggan) {

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

Edit Pelanggan

</h4>

</div>

<div class="card-body">

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $pelanggan['id_pelanggan'] ?>">

<div class="mb-3">

<label class="form-label">

Kode Pelanggan

</label>

<input
type="text"
class="form-control"
value="<?= $pelanggan['kode_pelanggan'] ?>"
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
value="<?= htmlspecialchars($pelanggan['nama']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Telepon

</label>

<input
type="text"
name="telepon"
class="form-control"
value="<?= htmlspecialchars($pelanggan['telepon']) ?>"
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
required><?= htmlspecialchars($pelanggan['alamat']) ?></textarea>

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