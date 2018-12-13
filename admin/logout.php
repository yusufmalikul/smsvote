<?php
require_once '../config.php';
session_start();
unset($_SESSION['username']);
session_destroy();
header('location:'.site_url());
?>
