<?php
require_once '../config.php';
// $id = $pdo->query("SELECT ID FROM `inbox` ORDER BY ID DESC LIMIT 0, 1")->fetchColumn();
// echo $id;

$stmt = $pdo->query("SELECT ID, SenderNumber FROM inbox WHERE TextDecoded LIKE 'pilih %' AND Processed = 'false' AND SUBSTRING(SenderNumber,1,3) = '+62'");

while ($data = $stmt->fetch()) {
  $ID = $data['ID'];
  $pengirim = $data['SenderNumber'];
  $stmt_send = $pdo->query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID)
                            VALUES ('$pengirim', 'Terima kasih telah berpartisipasi. Balas dengan CEK (Spasi) NO CALON ANDA untuk melihat jumlah suara.', '')");
  $pdo->query("UPDATE inbox SET Processed = 'true' WHERE ID = $ID");
}

$stmt = $pdo->query("SELECT ID, SenderNumber, SUBSTRING(TextDecoded, 5, 1) AS no_calon FROM `inbox` WHERE TextDecoded LIKE 'cek %' AND Processed = 'false'");

while ($data = $stmt->fetch()) {
  $ID = $data['ID'];
  $no_calon = $data['no_calon'];
  $pengirim = $data['SenderNumber'];
  $stmt_send = $pdo->prepare("SELECT ID, SenderNumber, TextDecoded, SUBSTRING(TextDecoded, 7, 1) AS no_calon
                            FROM inbox WHERE TextDecoded LIKE 'pilih %' AND SenderNumber = ? AND SUBSTRING(TextDecoded, 7, 1) = ?");
  $stmt_send->execute([$pengirim, $no_calon]);
  if ($stmt_send->rowCount() > 0) {
    $data_send = $stmt_send->fetch();
    $stmt_jumlah_suara = $pdo->query("SELECT nama, jumlah_suara FROM tbl_data_calon WHERE no = $no_calon")->fetch();
    $nama = $stmt_jumlah_suara['nama'];
    $jumlah_suara = $stmt_jumlah_suara['jumlah_suara'];
    $stmt_send2 = $pdo->prepare("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES (?, ?, 'sipsms')");
    $stmt_send2->execute([$pengirim, "Calon nomor $no_calon. $nama. Jumlah suara saat ini $jumlah_suara."]);
    $pdo->query("UPDATE inbox SET Processed = 'true' WHERE ID = $ID");
  }
}

?>
