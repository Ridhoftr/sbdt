<div class="sidebar">

    <h3>
        <i class="bi bi-basket2-fill"></i><br>
        CleanWash
    </h3>

    <a href="<?= base_url('admin/dashboard.php')?>"
       class="<?= ($page == 'dashboard') ? 'active' : ''; ?>">

        <i class="bi bi-speedometer2"></i>
        <span> Dashboard</span>

    </a>

    <a href="<?= base_url('admin/pelanggan/index.php') ?>"
       class="<?= ($page =='pelanggan') ? 'active' : ''; ?>">

        <i class="bi bi-people-fill"></i>
        <span> Pelanggan</span>

    </a>

    <a href="<?= base_url('admin/pegawai/index.php') ?>"
        class="<?= ($page=="pegawai")?'active':'' ?>">

        <i class="bi bi-people-fill"></i>
        <span>Pegawai</span>

    </a>

    <a href="<?= base_url('admin/layanan/index.php')?>"
       class="<?= ($page == 'layanan') ? 'active' : ''; ?>">

        <i class="bi bi-box-seam"></i>
        <span> Layanan</span>

    </a>

    <a href="<?= base_url('admin/transaksi/index.php')?>"
       class="<?= ($page == 'transaksi') ? 'active' : ''; ?>">

        <i class="bi bi-basket"></i>
        <span> Transaksi</span>

    </a>

    <a href="<?= base_url('admin/pembayaran/index.php') ?>"
        class="<?= ($page=="pembayaran") ? "active" : "" ?>">

        <i class="bi bi-cash-stack"></i>
        <span>Pembayaran</span>

    </a>

    <a href="<?= base_url('admin/sinkronisasi/index.php')?>"
       class="<?= ($page == 'sinkronisasi') ? 'active' : ''; ?>">

        <i class="bi bi-arrow-repeat"></i>
        <span> Sinkronisasi</span>

    </a>

    <a href="<?= base_url('admin/pembayaran/index.php')?>"
       class="<?= ($page == 'pembayaran') ? 'active' : ''; ?>">

        <i class="bi bi-cash-stack"></i>
        <span> Pembayaran</span>

    </a>

    <a href="<?= base_url('admin/laporan/index.php')?>"
       class="<?= ($page == 'laporan') ? 'active' : ''; ?>">

        <i class="bi bi-bar-chart-fill"></i>
        <span> Laporan</span>

    </a>

    <hr class="text-white">

    <a href="../logout.php">

        <i class="bi bi-box-arrow-right"></i>
        <span> Logout</span>

    </a>

</div>