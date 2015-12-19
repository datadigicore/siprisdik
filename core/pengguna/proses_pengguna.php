<?php
include 'config/application.php';

$sess_id    = $_SESSION['user_id'];
$id    = $purifier->purify($_POST[id]);
$username   = $purifier->purify($_POST[username]);
$password   = $UTILITY->sha512($_POST[password]);
$hash_pass  = $UTILITY->sha512($_POST[hash_pass]);
$email      = $purifier->purify($_POST[email]);
$keterangan = $purifier->purify($_POST[keterangan]);

$data_pengguna = array(
  "id"         => $id,
  "nama"       => $nama,
  "username"   => $username,
  "password"   => $password,
  "email"      => $email,
  "keterangan" => $keterangan
);

$kondisi = $purifier->purify($_POST['kondisi']);
switch ($content) {
  case 'tambah':
    $PENGGUNA->insertPengguna($data_pengguna);
    $UTILITY->location_goto("content/setting");
  break;
  case 'edit':
    $PENGGUNA->updatePengguna($data_pengguna);
    $UTILITY->location_goto("content/setting");
  break;
  case 'hapus':
    $PENGGUNA->deletePengguna($hapuspengguna);
    $UTILITY->location_goto("content/setting");
  break;
  default:
    $UTILITY->location_goto(".");
  break;
}
?>
