<?php
/**
 * ==========================================================
 * CLEANWASH LAUNDRY DISTRIBUTED SYSTEM
 * File : config/session.php
 * Fungsi : Manajemen Session
 * ==========================================================
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Session Timeout (30 Menit)
|--------------------------------------------------------------------------
*/

$timeout = 1800;

if (isset($_SESSION['LAST_ACTIVITY'])) {

    if ((time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {

        session_unset();

        session_destroy();

        header("Location: ../login.php?expired=1");
        exit;
    }
}

$_SESSION['LAST_ACTIVITY'] = time();

/*
|--------------------------------------------------------------------------
| Regenerate Session ID setiap 10 menit
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['CREATED'])) {

    $_SESSION['CREATED'] = time();

} elseif (time() - $_SESSION['CREATED'] > 600) {

    session_regenerate_id(true);

    $_SESSION['CREATED'] = time();
}