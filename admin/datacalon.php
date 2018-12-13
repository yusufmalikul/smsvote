<?php

if (isset($_POST['submit'])) {
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
    upload_foto($_FILES['foto']);
  }
  $no = $_POST['no'];
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $warna = $_POST['warna'];

  $stmt = $pdo->prepare("INSERT INTO tbl_data_calon (no, nim, nama, alamat, warna, foto)
                          VALUES(?, ?, ?, ?, ?, ?)");
  $stmt->execute([$no, $nim, $nama, $alamat, $warna, $_FILES['foto']['name']]);
}

$stmt = $pdo->query("SELECT * FROM tbl_data_calon");
$lastno = $pdo->query("SELECT MAX(no) FROM tbl_data_calon")->fetchColumn();

?>
<h2>Data calon</h2>
<input id="btndatabaru" class="btn btn-primary" type="button" name="tambah" value="Tambah Data Baru">
<div class="form-group col-xs-12">
  <form id="databaru" enctype="multipart/form-data" action="" method="post" style="display:none">
    <br>
    <label for="">No.</label><input class="form-control" type="number" name="no" value="<?= ++$lastno;?>">
    <label for="">Foto</label><input class="form-control" type="file" name="foto" value="">
    <label for="">Warna</label><input class="form-control" type="color" name="warna" value="#000000" required><br>
    <label for="">Nim</label><input class="form-control" type="number" name="nim" value="" required>
    <label for="">Nama</label><input class="form-control" type="text" name="nama" value="" required>
    <label for="">Alamat</label><input class="form-control" type="text" name="alamat" value="" required><br>
    <input class="btn btn-primary" type="submit" name="submit" value="Simpan"> <a href="" onclick="">Batal</a>
  </form>
</div>
<table class="table">
  <thead>
    <tr>
      <th>No.</th><th>Warna</th><th>NIM</th><th>Nama</th><th>Alamat</th><th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php

    while ($data = $stmt->fetch()) {
      ?>
        <tr>
          <td><?= $data['no'];?></td>
          <td><svg width="15" height="15">
            <rect width="15" height="15" fill="<?= $data['warna'];?>">
          </svg></td>
          <td><?= $data['nim'];?></td>
          <td><?= $data['nama'];?></td>
          <td><?= $data['alamat'];?></td>
          <td><a href="<?= site_url()."/admin/index.php?page=datacalon-edit&id=".$data['id'];?>">Ubah</a> -
          <a href="#" class="hapus" data-id="<?= $data['id'];?>">Hapus</a></td>
        </tr>
      <?php
    }

    ?>
  </tbody>
</table>
