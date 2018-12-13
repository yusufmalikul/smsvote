<?php

if (isset($_POST['submit'])) {
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
    upload_foto($_FILES['foto'], $_POST['foto']);
    $foto_change = true;
  } else {
    $foto_change = false;
  }

  $id = $_POST['id'];
  $no = $_POST['no'];
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $warna = $_POST['warna'];

  if ($foto_change) {
    $stmt = $pdo->prepare("UPDATE tbl_data_calon SET foto = ? WHERE id = ?");
    $stmt->execute([$_FILES['foto']['name'], $id]);
  }

  $stmt = $pdo->prepare("UPDATE tbl_data_calon SET no = ?, nim = ?, nama = ?, alamat = ?, warna = ? WHERE id = ?");
  $stmt->execute([$no, $nim, $nama, $alamat, $warna, $id]);

  if ($stmt->errorCode() == 0) {
    $message = "Perubahan berhasil disimpan.";
  } else {
    $message = "Error ".$stmt->errorCode();
  }

}

$stmt = $pdo->prepare("SELECT * FROM tbl_data_calon WHERE id = ?");
$stmt->execute([$_GET['id']]);
$data = $stmt->fetch();
?>
<h2>Ubah Data Calon</h2>
<div class="form-group col-xs-12">
<form class="" enctype="multipart/form-data" action="" method="post">
  <input type="hidden" name="id" value="<?= $data['id'];?>">
  <input type="hidden" name="foto" value="<?= $data['foto'];?>">
  <img class="img-edit" src="../uploads/<?= $data['foto'];?>" alt="">
  <input class="form-control" type="file" name="foto" value="">
  <label for="">No</label><input class="form-control" type="number" name="no" value="<?= $data['no'];?>" required>
  <label for="">Warna</label><input class="form-control" type="color" name="warna" value="<?= $data['warna'];?>" required>
  <label for="">Nim</label><input class="form-control" type="number" name="nim" value="<?= $data['nim'];?>" required>
  <label for="">Nama</label><input class="form-control" type="text" name="nama" value="<?= $data['nama'];?>" required>
  <label for="">Alamat</label><input class="form-control" type="text" name="alamat" value="<?= $data['alamat'];?>" required><br>
  <?php if (isset($message)) echo $message ."<br><br>"; ?>
  <input class="btn btn-primary" type="submit" name="submit" value="Simpan"> <a href="<?= site_url()."/admin/?page=datacalon";?>">Batal</a>
</div>
</form>
