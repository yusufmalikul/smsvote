<?php

if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $no = $_POST['no_sms_center'];
  $jam_berakhir = $_POST['jam_berakhir'];
  $menit_berakhir = $_POST['menit_berakhir'];

  $stmt = $pdo->prepare("UPDATE tbl_pengaturan SET no_sms_center = ?, jam_berakhir = ?, menit_berakhir = ? WHERE id = ?");
  $stmt->execute([$no, $jam_berakhir, $menit_berakhir, $id]);


  if ($stmt->errorCode() == 0) {
    $message = "Perubahan berhasil disimpan.";
  } else {
    $message = "Error ".$stmt->errorCode();
  }
}

$pengaturan = $pdo->query("SELECT * FROM tbl_pengaturan")->fetch();

?>

<h2>Pengaturan</h2>
<div class="form-group">
<form class="" action="" method="post">
  <input type="hidden" name="id" value="<?= $pengaturan['id'];?>">
  <label for="">Nomer SMS Center</label>
  <input class="form-control" type="text" name="no_sms_center" value="<?= $pengaturan['no_sms_center'];?>">
  <br>
  <label for="">Waktu voting berakhir (Jam:Menit)</label>
  <div class="row">
    <div class="col-md-4">
      <input class="form-control" type="number" name="jam_berakhir" value="<?= $pengaturan['jam_berakhir'];?>" min="0" max="23">
    </div>
    <div class="col-md-2">
      <input class="form-control" type="number" name="menit_berakhir" value="<?= $pengaturan['menit_berakhir'];?>" min="0" max="59">
    </div>
  </div>
  <br>
  <?php if (isset($message)) echo $message ."<br><br>"; ?>
  <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
</form>
</div>
