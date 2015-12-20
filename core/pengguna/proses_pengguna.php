<?php
include 'config/application.php';

$sess_id    = $_SESSION['user_id'];
$name       = $purifier->purify($_POST[name]);
$username   = $purifier->purify($_POST[username]);
$password   = $utility->sha512($_POST[password]);
// $hash_pass  = $utility->sha512($_POST[hash_pass]);
$email      = $purifier->purify($_POST[email]);
$level      = $purifier->purify($_POST[level]);
$status     = $purifier->purify($_POST[status]);

$data_pengguna = array(
  "nama"       => $nama,
  "username"   => $username,
  "password"   => $password,
  "email"      => $email,
  "level"      => $level,
  "status"     => $status
);

switch ($process) {
  case 'add':
    $pengguna->insertPengguna($data_pengguna);
    $utility->load("content/adduser","Success! Data berhasil ditambahkan");
  break;
  case 'edt':
    $pengguna->updatePengguna($data_pengguna);
    $utility->location_goto("content/setting");
  break;
  case 'del':
    $pengguna->deletePengguna($hapuspengguna);
    $utility->location_goto("content/setting");
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
