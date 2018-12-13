<?php require_once "config.php";

// check countdown
$stmt = $pdo->query("SELECT jam_berakhir, menit_berakhir FROM tbl_pengaturan")->fetch();
$hour_end = $stmt['jam_berakhir'];
$minute_end = $stmt['menit_berakhir'];
$hour_now = date('H');
$minute_now = date('i');

$second_end = $hour_end * 3600 + $minute_end * 60;
$second_now = $hour_now * 3600 + $minute_now * 60;
$diff = $second_end - $second_now;

if ($diff > 0) {
  $stmt = $pdo->query("UPDATE tbl_pengaturan SET voting_aktif = 'true'");
  $voting_aktif = true;
} else {
  $stmt = $pdo->query("UPDATE tbl_pengaturan SET voting_aktif = 'false'");
  $voting_aktif = false;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SMS Vote</title>
    <link rel="stylesheet" href="<?= asset_url(); ?>/css/bootstrap.min.css">
    <script src="<?= asset_url(); ?>/js/jquery.min.js"></script>
    <script src="<?= asset_url(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= asset_url(); ?>/js/Chart.min.js"></script>
    <script src="<?= asset_url(); ?>/js/chart.js" charset="utf-8"></script>
    <script src="<?= asset_url(); ?>/js/script.js" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= asset_url()."/css/style.css";?>" media="screen" title="no title">
    <meta http-equiv="refresh" content="">
    <meta http-equiv="pragma" content="no-cache">
    <script type="text/javascript">
      <?php
      $stmt = $pdo->query("SELECT jam_berakhir, menit_berakhir FROM tbl_pengaturan")->fetch();
      $hour_end = $stmt['jam_berakhir'];
      $minute_end = $stmt['menit_berakhir'];
      echo "var hour_end = \"".$hour_end."\";";
      echo "var minute_end = \"".$minute_end."\";";
      echo "var voting_aktif = \"".$voting_aktif."\";";
      echo "var voting = \"".site_url()."/system/voting.php?home=true\";";
      ?>
    </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 vote-chart text-center">
          <div class="vote-chart2">
            <canvas id="pie_chart" width="200" height="200"></canvas>
          </div>
          <script type="text/javascript">
          <?php
          $stmt = $pdo->query("SELECT COUNT(*) AS jumlah_calon FROM tbl_data_calon");
          $jumlah_calon = $stmt->fetch()['jumlah_calon'];
          $stmt = $pdo->query("SELECT * FROM tbl_data_calon ORDER BY no ASC");
          $i = 0;
          $total = 0;
          $warnaBG = "[";
          $labels = "[";
          while ($data = $stmt->fetch()) {
            $jumlah_suara[$i] = $data['jumlah_suara'];
            $total += $jumlah_suara[$i];
            $warnaBG .= "'".$data['warna']."'";
            $labels .= "'".$data['nama']."'";
            if ($i < $jumlah_calon-1) {
              $warnaBG .= ", ";
              $labels .= ", ";
            }
            $i++;
          }
          $warnaBG .= "]";
          $labels .= "]";
          echo "label = ".$labels.";\n";
          echo "warnaBG = ".$warnaBG.";\n";
          echo "warnaHover = ".$warnaBG.";\n";
          // Generate javascript array
          echo"jumlah_suara = [";
          for ($i=0; $i < $jumlah_calon; $i++) {
            $persen_suara[$i] = $jumlah_suara[$i] / $total * 100;
            echo $jumlah_suara[$i];
            if ($i < $jumlah_calon-1) {
              echo ", ";
            }
          }
          echo "];\n";
          ?>
          // startChart() diimplementasikan di chart.js
          startChart();
          </script>
        </div>
        <div class="col-md-6 vote-candidate">
          <table class="vote-table">
            <?php
            $stmt = $pdo->query("SELECT * FROM tbl_data_calon ORDER BY no ASC");
            $i = 0;
            while ($data = $stmt->fetch()) {
              ?>
              <tr>
                <td class="col-md-1 vote-number"><?= $data['no'];?></td>
                <td class="col-md-4"><img class="img-responsive img-circle vote-photo" src="./uploads/<?= $data['foto'];?>" alt=""></td>
                <td class="col-md-4"><?= $data['nama'];?></td>
                <td class="vote-counter col-md-3"><span class="vote-persentage"><?= number_format($persen_suara[$i], 2);?>%</span><br><span class="vote-count"><?= $data['jumlah_suara'];?> Suara</span></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </table>
          <a href="<?= site_url().'/admin';?>" target="_blank">Login Admin</a>
        </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <?php
        $sms_center = $pdo->query("SELECT no_sms_center FROM tbl_pengaturan")->fetchColumn();
        ?>
        <br>
        <?php
        if ($voting_aktif) {
          ?>
          <p class="format-sms text-center">Format SMS voting: Ketik PILIH (SPASI) NO CALON (SPASI) NIM Anda<br>
            Misal: PILIH <?= $jumlah_calon+1;?> 140631100132<br>
          Kirim ke SMS Center <?= $sms_center;?></p>
          <?php
        } else {
          echo "<p class=\"countdown-finish\">Waktu sudah habis. Silahkan refresh halaman ini secara manual jika perolehan suara tidak tampil.</p>";
        }
        ?>
        <p class="countdown"></p>
      </div>
    </div>
  </body>
</html>
