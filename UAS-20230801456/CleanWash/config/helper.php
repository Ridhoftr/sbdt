<?php

/**
 * ==========================================================
 * HELPER
 * ==========================================================
 */

function base_url($path = "")
{
    return "http://localhost/CleanWash/" . $path;
}

function redirect($url)
{
    header("Location: " . $url);
    exit;
}

function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

function currentDate()
{
    return date("Y-m-d");
}

function currentDateTime()
{
    return date("Y-m-d H:i:s");
}

function currentCabang()
{
    return $_SESSION['cabang'] ?? null;
}