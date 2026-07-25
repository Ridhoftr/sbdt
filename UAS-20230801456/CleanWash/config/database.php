<?php
/**
 * ==========================================================
 * CLEANWASH LAUNDRY DISTRIBUTED SYSTEM
 * File : config/database.php
 * Fungsi : Konfigurasi Koneksi Database
 * Author : Muhammad Ridho Faturahman
 * ==========================================================
 */

class Database
{
    // Konfigurasi Server Database
    private static $host = "localhost";
    private static $port = "3306";
    private static $username = "root";
    private static $password = "";

    /**
     * ======================================================
     * Koneksi Database Pusat
     * ======================================================
     */
    public static function pusat()
    {
        return self::connect("laundry_pusat");
    }

    /**
     * ======================================================
     * Koneksi Database Cabang Makassar
     * ======================================================
     */
    public static function makassar()
    {
        return self::connect("laundry_makassar");
    }

    /**
     * ======================================================
     * Koneksi Database Cabang Gowa
     * ======================================================
     */
    public static function gowa()
    {
        return self::connect("laundry_gowa");
    }

    /**
     * ======================================================
     * Fungsi Utama Koneksi PDO
     * ======================================================
     */
    private static function connect($dbname)
    {
        try {

            $dsn = "mysql:host=" . self::$host .
                ";port=" . self::$port .
                ";dbname=" . $dbname .
                ";charset=utf8mb4";

            $pdo = new PDO(
                $dsn,
                self::$username,
                self::$password,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ]
            );

            return $pdo;

        } catch (PDOException $e) {

            die("
            <h2>Database Connection Failed</h2>
            <hr>
            <b>Database :</b> {$dbname}<br>
            <b>Error :</b> {$e->getMessage()}
            ");
        }
    }
}