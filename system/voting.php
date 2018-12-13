<?php
// SELECT ID, TextDecoded, SenderNumber FROM `inbox` WHERE TextDecoded LIKE 'pilih 1 %' AND SUBSTRING(TextDecoded,9,12) >= 130631100001 AND SUBSTRING(TextDecoded,9,12) <= 160631100131 GROUP BY SenderNumber

require_once '../config.php';
$stmt = $pdo->query("SELECT COUNT(*) FROM tbl_data_calon");
$jumlah_calon = $stmt->fetchColumn();
for ($i=1; $i <= $jumlah_calon; $i++) {
  $stmt = $pdo->query("SELECT ID, TextDecoded, SenderNumber FROM `inbox` WHERE
                      TextDecoded LIKE 'pilih $i %' AND SUBSTRING(TextDecoded,9,12) >= 130631100001 AND
                      SUBSTRING(TextDecoded,9,12) <= 160631100131 GROUP BY SenderNumber");
  $data = $stmt->fetchAll();
  $jumlah_suara = count($data);
  $stmt = $pdo->query("UPDATE tbl_data_calon SET jumlah_suara = $jumlah_suara WHERE no = $i");
}

if (isset($_GET['redirect'])) {
  header('location:../admin?revote=yes');
}
if (isset($_GET['home'])) {
  header('location:'.site_url());
}
?>
