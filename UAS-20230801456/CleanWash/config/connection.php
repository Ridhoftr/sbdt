<?php

/**
 * ==========================================================
 * CLEANWASH LAUNDRY DISTRIBUTED SYSTEM
 * File : config/connection.php
 * Fungsi : Memilih koneksi database sesuai cabang login
 * ==========================================================
 */

require_once "database.php";
require_once "session.php";
require_once "config.php";

try {

    $db = new PDO(
        "mysql:host=" . DB_HOST .
        ";dbname=" . DB_NAME .
        ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );

    $db->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Koneksi gagal : " . $e->getMessage());

}

if (!isset($_SESSION['cabang'])) {

    header("Location: ../login.php");

    exit;

}

switch ($_SESSION['cabang']) {

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

        die("Database tidak ditemukan.");

}