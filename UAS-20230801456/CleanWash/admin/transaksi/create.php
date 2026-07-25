<?php

require_once "../../config/auth.php";
require_once "../../config/helper.php";
require_once "../../config/connection.php";

$page = "transaksi";

/*
|--------------------------------------------------------------------------
| Generate Kode Transaksi
|--------------------------------------------------------------------------
*/

$query = $db->query("
    SELECT kode_transaksi
    FROM transaksi
    ORDER BY id_transaksi DESC
    LIMIT 1
");

$data = $query->fetch();

if ($data) {

    $angka = (int) substr($data['kode_transaksi'], -4);

    $angka++;

} else {

    $angka = 1;

}

$kode = "TRX-" . KODE_CABANG . "-" . str_pad($angka, 4, "0", STR_PAD_LEFT);

/*
|--------------------------------------------------------------------------
| Data Pelanggan
|--------------------------------------------------------------------------
*/

$pelanggan = $db->query("
SELECT *
FROM pelanggan
ORDER BY nama ASC
")->fetchAll();

/*
|--------------------------------------------------------------------------
| Data Pegawai
|--------------------------------------------------------------------------
*/

$pegawai = $db->query("
SELECT *
FROM pegawai
ORDER BY nama ASC
")->fetchAll();

/*
|--------------------------------------------------------------------------
| Data Layanan
|--------------------------------------------------------------------------
*/

$layanan = $db->query("
SELECT *
FROM layanan
WHERE status='aktif'
ORDER BY nama_layanan ASC
")->fetchAll();

include "../../templates/header.php";
include "../../templates/sidebar.php";
include "../../templates/navbar.php";

?>

<div class="content">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <h4 class="mb-0">

                Tambah Transaksi

            </h4>

        </div>

    <div class="card-body">

        <form action="store.php" method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Kode Transaksi

                </label>

                <input
                    type="text"
                    class="form-control"
                    name="kode_transaksi"
                    value="<?= $kode ?>"
                    readonly>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Tanggal

                </label>

                <input
                    type="date"
                    class="form-control"
                    name="tanggal"
                    value="<?= date('Y-m-d') ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Pelanggan

                </label>

                <select
                    class="form-select"
                    name="id_pelanggan"
                    required>

                <option value="">

                -- Pilih Pelanggan --

                </option>

                    <?php foreach($pelanggan as $row): ?>

                    <option value="<?= $row['id_pelanggan']?>">

                    <?= $row['kode_pelanggan']?> -
                    <?= $row['nama']?>

                </option>

                <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Pegawai

                </label>

                <select
                    class="form-select"
                    name="id_pegawai"
                    required>

                <option value="">

                -- Pilih Pegawai --

                </option>

                <?php foreach($pegawai as $row): ?>

                <option value="<?= $row['id_pegawai']?>">

                <?= $row['nama']?>

                </option>

                <?php endforeach; ?>

                </select>

            </div>

            <hr>

            <h5 class="mb-3">

                Detail Layanan

            </h5>

            <div class="row">

                <div class="col-md-5">

                    <label class="form-label">

                        Layanan

                    </label>

                    <select
                        id="layanan"
                        class="form-select">

                        <option value="">

                            -- Pilih Layanan --

                        </option>

                        <?php foreach($layanan as $row): ?>

                            <option
                                value="<?= $row['id_layanan'] ?>"
                                data-harga="<?= $row['harga_perkg'] ?>">

                                <?= $row['nama_layanan'] ?>
                                -
                                Rp <?= number_format($row['harga_perkg'],0,',','.') ?>/Kg

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-3">

                    <label class="form-label">

                        Berat (Kg)

                    </label>

                    <input
                        type="number"
                        id="berat"
                        class="form-control"
                        min="0.1"
                        step="0.1"
                        required>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <button
                        type="button"
                        class="btn btn-success w-100"
                        onclick="tambahLayanan()">

                        <i class="bi bi-plus-circle"></i>

                        Tambah

                    </button>

                </div>

            </div>

            <hr>

            <div class="table-responsive">

            <table class="table table-bordered" id="detailTable">

                <thead class="table-primary">

                <tr>

                    <th>No</th>

                    <th>Layanan</th>

                    <th>Harga/Kg</th>

                    <th>Berat</th>

                    <th>Subtotal</th>

                    <th width="80">

                        Aksi

                    </th>

                </tr>

                </thead>

                <tbody>

                </tbody>

            </table>

            </div>

            <div class="row justify-content-end">

                <div class="col-md-4">

                    <table class="table">

                        <tr>

                            <th>Subtotal</th>

                            <td>

                                <input
                                    type="text"
                                    id="subtotal"
                                    name="subtotal"
                                    class="form-control"
                                    value="0"
                                    readonly>

                            </td>

                        </tr>

                        <tr>

                            <th>Diskon</th>

                            <td>

                                <input
                                    type="number"
                                    name="diskon"
                                    id="diskon"
                                    class="form-control"
                                    value="0">

                            </td>

                        </tr>

                        <tr>

                            <th>Total</th>

                            <td>

                                <input
                                    type="text"
                                    id="total"
                                    name="total"
                                    class="form-control"
                                    value="0"
                                    readonly>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label">

                        Status Laundry

                    </label>

                    <select
                        class="form-select"
                        name="status"
                        required>

                        <option value="Diproses">

                            Diproses

                        </option>

                        <option value="Selesai">

                            Selesai

                        </option>

                        <option value="Diambil">

                            Diambil

                        </option>

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label">

                        Status Pembayaran

                    </label>

                    <select
                        class="form-select"
                        name="status_pembayaran"
                        required>

                        <option value="Belum Lunas">

                            Belum Lunas

                        </option>

                        <option value="Lunas">

                            Lunas

                        </option>

                    </select>

                </div>

            </div>

            <hr>

                <button
                    class="btn btn-primary"
                    type="submit">

                    <i class="bi bi-save"></i>

                    Simpan Transaksi

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    Kembali

                </a>

                </form>

            </div>

        </div>

    </div>

<script>

let nomor = 1;

let grandSubtotal = 0;

function tambahLayanan(){

    let layanan = document.getElementById("layanan");

    let berat = document.getElementById("berat");

    if(layanan.value=="" || berat.value=="" || parseFloat(berat.value)<=0){

        Swal.fire(
            'Peringatan',
            'Silakan pilih layanan dan isi berat.',
            'warning'
        );

        return;

    }

    let id = layanan.value;

    let nama = layanan.options[layanan.selectedIndex].text;

    let harga = parseFloat(
        layanan.options[layanan.selectedIndex].dataset.harga
    );

    let kg = parseFloat(berat.value);

    let subtotal = harga * kg;

    grandSubtotal += subtotal;

    tambahBaris(
        id,
        nama,
        harga,
        kg,
        subtotal
    );

    hitungTotal();

    layanan.selectedIndex = 0;

    berat.value = "";

}

function tambahBaris(id,nama,harga,kg,subtotal){

    let tbody = document.querySelector("#detailTable tbody");

    let row = `

<tr>

<td>${nomor}</td>

<td>${nama}</td>

<td>${formatRupiah(harga)}</td>

<td>${kg}</td>

<td>${formatRupiah(subtotal)}</td>

<td>

<button
type="button"
class="btn btn-danger btn-sm"
onclick="hapusBaris(this,${subtotal})">

<i class="bi bi-trash"></i>

</button>

<input
type="hidden"
name="id_layanan[]"
value="${id}">

<input
type="hidden"
name="harga[]"
value="${harga}">

<input
type="hidden"
name="berat[]"
value="${kg}">

<input
type="hidden"
name="subtotal_detail[]"
value="${subtotal}">

</td>

</tr>

`;

    tbody.insertAdjacentHTML("beforeend",row);

    nomor++;

}

function hapusBaris(button,subtotal){

    button.closest("tr").remove();

    grandSubtotal -= subtotal;

    hitungTotal();

}
function hitungTotal(){

    let diskon = parseFloat(

        document.getElementById("diskon").value

    ) || 0;

    let total = grandSubtotal - diskon;

    if(total < 0){

        total = 0;

    }

    document.getElementById("subtotal").value = grandSubtotal;

    document.getElementById("total").value = grandSubtotal - diskon;

}

document.getElementById("diskon").addEventListener(

"keyup",

function(){

    hitungTotal();

}

);

function formatRupiah(angka){

    return "Rp " + Number(angka).toLocaleString("id-ID");

}

</script>

<?php include "../../templates/footer.php"; ?>