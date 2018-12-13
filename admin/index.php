<?php
require_once "../config.php";
session_start();
checkLogin();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="<?= asset_url(); ?>/css/bootstrap.min.css">
    <script src="<?= asset_url(); ?>/js/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= asset_url(); ?>/js/Chart.min.js"></script>
    <script src="<?= asset_url(); ?>/js/chart.js" charset="utf-8"></script>
    <script src="<?= asset_url(); ?>/js/script-admin.js" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= asset_url()."/css/admin-style.css";?>" media="screen" title="no title">
    <script type="text/javascript">
      <?php
        $hapusdatacalon = site_url()."/admin/hapusdatacalon.php";
        echo "var hapusdatacalon = \"". $hapusdatacalon. "\";";
      ?>
    </script>
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Halaman admin</h1>
      </header>
      <nav>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : null;
        ?>
        <a href="<?= site_url().'/admin';?>" <?php if ($page == 'index' OR $page == null) echo "class=\"current-nav\"";?>>Beranda</a> |
        <a href="<?= site_url().'/admin/?page=datacalon';?>" <?php if ($page == 'datacalon') echo "class=\"current-nav\"";?>>Data Calon Ketum</a> |
        <a href="<?= site_url().'/admin/?page=pengaturan';?>" <?php if ($page == 'pengaturan') echo "class=\"current-nav\"";?>>Pengaturan</a> |
        <a href="<?= site_url().'/admin/logout.php';?>">Logout</a>
      </nav>
      <main>
        <?php
        if ($page == 'datacalon') {
          include_once "datacalon.php";
        } else if ($page == 'datacalon-edit') {
          include_once 'datacalon-edit.php';
        } else if ($page == 'pengaturan') {
          include_once 'pengaturan.php';
        } else {
          if (isset($_GET['revote'])) {
            echo "<script>alert(\"Perhitungan selesai! Silahkan cek halaman perolehan suara.\")</script>";
          }
          include_once "beranda.php";
        }

        ?>
      </main>
      <footer>&copy; SIPSMS Kelompok SI B</footer>
    </div>
  </body>
</html>
