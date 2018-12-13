<?php

function site_url() {
  return SITE_URL;
}

function asset_url() {
  return site_url().'/assets';
}

function upload_foto($foto, $oldfoto = null) {
  // Upload foto Start ----------------------------------------------
  // Handle uploaded image file
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($foto['name']);
  $uploadOK = true;
  $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

  $check = getimagesize($foto['tmp_name']);
  if ($check !== false) {
    // file ok
  } else {
    // file not ok
    $uploadOK = false;
  }

  // Only allow image file extension
  if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
    $uploadOK = false;
  }

  if (!$uploadOK) {
    die("File not allowed!");
  }
  if ($oldfoto != null) {
    // Delete old foto
    unlink('../uploads/'.$oldfoto);
  }
  if (move_uploaded_file($foto['tmp_name'], $target_file)) {
    // file uploaded successfully;
  } else {
    die("Error when uploading file");
  }
  // Upload foto End ----------------------------------------------
}

function checkLogin(){
  if ($_SESSION['username'] != 'admin') {
    header('location:'.site_url().'/admin/login.php');
  }
}

?>
