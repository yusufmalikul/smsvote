<?php
require_once "../config.php";
session_start();
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $pdo->prepare("SELECT username FROM tbl_admin WHERE username = ? AND password = ?");
  $stmt->execute([$username, md5($password)]);
  // $row = $stmt->fetchColumn();
  if ($stmt->fetchColumn()){
    $_SESSION['username'] = "admin";
    header('location:'.site_url().'/admin');
  } else {
    $message = "Username atau password salah!";
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="<?= asset_url(); ?>/css/bootstrap.min.css">
    <script src="<?= asset_url(); ?>/js/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= asset_url(); ?>/js/Chart.min.js"></script>
    <script src="<?= asset_url(); ?>/js/chart.js" charset="utf-8"></script>
    <script src="<?= asset_url(); ?>/js/script-admin.js" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= asset_url()."/css/admin-style.css";?>" media="screen" title="no title">
  </head>
  <body>
    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-4">
        <h2>Login Admin SIPSMS</h2>
        <form class="" action="" method="post">
          <table cellspacing="3">
            <tr>
              <td>Username</td><td><input type="text" name="username" value="" required></td>
            </tr>
            <tr>
              <td>Password</td><td><input type="password" name="password" value="" required></td>
            </tr>
            <tr>
              <td></td><td><input type="submit" name="submit" value="Login"></td>
            </tr>
          </table>
        </form>
        <?php
        if (isset($message)) {
          echo "<br>".$message;
        }
        ?>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </body>
</html>
