<?php

// config.php
// FIle konfigurasi
// berisi konfigurasi database dan pengaturan dasar situs

// change to ~E_ALL for production site
error_reporting(E_ALL);
ini_set('display_errors', 1);
// set date.timezone in php.ini if this doesn't work
date_default_timezone_get("Asia/Jakarta");

// -------------------- Mulai edit dari sini --------------------
// Database details
$host     = 'localhost';
$db       = 'smsvote';
$user     = 'root';
$pass     = '';
$charset  = 'utf8';
// Alamat situs
define ('SITE_URL', 'http://localhost/smsvote');
// -------------------- Berhenti edit dar sini --------------------

// Establish database connection
// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
  PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC
];
$pdo = new PDO($dsn, $user, $pass, $opt);

require_once 'system/functions.php';

?>
