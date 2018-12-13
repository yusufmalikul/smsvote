<?php
if (isset($_GET['id'])) {
  require_once '../config.php';
  $stmt = $pdo->prepare("DELETE FROM tbl_data_calon WHERE id = ?");
  $stmt->execute([$_GET['id']]);
}
header('location:'.site_url().'/admin/?page=datacalon');
?>
