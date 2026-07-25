<?php
require_once "config/database.php";
require_once "config/session.php";

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: admin/dashboard.php");
    exit;
}

// =========================================
// PROSES LOGIN
// =========================================

$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $cabang   = trim($_POST['cabang']);

    // Validasi input
    if ($username == "" || $password == "" || $cabang == "") {
        $error = "Semua field harus diisi.";
    } else {

        // Menentukan koneksi database
        switch ($cabang) {

            case "pusat":
                $db = Database::pusat();
                break;

            case "makassar":
                $db = Database::makassar();
                break;

            case "gowa":
                $db = Database::gowa();
                break;

            default:
                $db = null;
                break;
        }

        if ($db) {

            $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";

            $stmt = $db->prepare($sql);

            $stmt->execute([$username]);

            $user = $stmt->fetch();

            if ($user) {

                if (password_verify($password, $user['password'])) {

                    $_SESSION['login'] = true;

                    $_SESSION['id_user'] = $user['id_user'];

                    $_SESSION['nama'] = $user['nama'];

                    $_SESSION['username'] = $user['username'];

                    $_SESSION['role'] = $user['role'];

                    $_SESSION['status'] = $user['status'];

                    $_SESSION['cabang'] = $cabang;

                    header("Location: admin/dashboard.php");

                    exit;

                } else {

                    $error = "Password salah.";

                }

            } else {

                $error = "Username tidak ditemukan.";

            }

        } else {

            $error = "Database tidak ditemukan.";

        }

    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CleanWash Laundry</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{

            background: linear-gradient(135deg,#0d6efd,#0dcaf0);

            height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .login-card{

            width:430px;

            border:none;

            border-radius:20px;

            box-shadow:0 15px 35px rgba(0,0,0,.25);

            padding:35px;

            background:white;

        }

        .logo{

            width:90px;

            height:90px;

            border-radius:50%;

            background:#0d6efd;

            color:white;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:40px;

            margin:auto;

            margin-bottom:15px;

        }

        .btn-login{

            width:100%;

            height:50px;

            font-weight:600;

            border-radius:10px;

        }

        .input-group-text{

            cursor:pointer;

        }

        .footer{

            text-align:center;

            margin-top:20px;

            color:#777;

            font-size:13px;

        }

    </style>

</head>

<body>

<div class="card login-card">

    <div class="logo">

        <i class="bi bi-basket2-fill"></i>

    </div>

    <h3 class="text-center fw-bold">

        CleanWash

    </h3>

    <p class="text-center text-muted">

        Laundry Management System

    </p>

    <form action="login.php" method="POST">

        <?php if ($error != "") : ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <?= $error; ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

    <?php endif; ?>

    <div class="mb-3">

        <label class="form-label">

            Username

        </label>

        <input
            type="text"
            name="username"
            class="form-control"
            required>

    </div>

        <div class="mb-3">

            <label class="form-label">

                Password

            </label>

            <div class="input-group">

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required>

                <span
                    class="input-group-text"
                    onclick="togglePassword()">

                    <i class="bi bi-eye" id="iconEye"></i>

                </span>

            </div>

        </div>

        <div class="mb-4">

            <label class="form-label">

                Pilih Cabang

            </label>

            <select
                class="form-select"
                name="cabang"
                required>

                <option value="">

                    -- Pilih Cabang --

                </option>

                <option value="pusat">

                    Kantor Pusat

                </option>

                <option value="makassar">

                    Cabang Makassar

                </option>

                <option value="gowa">

                    Cabang Gowa

                </option>

            </select>

        </div>

        <button
            class="btn btn-primary btn-login"
            type="submit"
            name="login">

            <i class="bi bi-box-arrow-in-right"></i>

            Login

        </button>

    </form>

    <div class="footer">

        CleanWash Laundry Distributed System

        <br>

        © 2026

    </div>

</div>

<script>

function togglePassword(){

    let pass=document.getElementById("password");

    let eye=document.getElementById("iconEye");

    if(pass.type==="password"){

        pass.type="text";

        eye.classList.remove("bi-eye");

        eye.classList.add("bi-eye-slash");

    }else{

        pass.type="password";

        eye.classList.remove("bi-eye-slash");

        eye.classList.add("bi-eye");

    }

}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>