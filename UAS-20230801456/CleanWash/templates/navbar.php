<div class="topbar">

    <div>

        <h4 class="mb-0 fw-bold">
            <?= ucfirst($page); ?>
        </h4>

        <small class="text-muted">
            CleanWash Laundry Management System
        </small>

    </div>

    <div class="d-flex align-items-center">

        <div class="text-end me-3">

            <strong>

                <?= $_SESSION['nama']; ?>

            </strong>

            <br>

            <small class="text-muted">

                <?= ucfirst($_SESSION['role']); ?>

            </small>

        </div>

        <div
            class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
            style="width:45px;height:45px;">

            <i class="bi bi-person-fill"></i>

        </div>

    </div>

</div>