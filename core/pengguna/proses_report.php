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
  case 'table':
  break;
  case 'Rincian_Biaya_PD':
    $report->rincian_biaya_PD($data_pengguna);
  break;
  case 'Kuitansi_Honor_Uang_Saku':
    $report->Kuitansi_Honor_Uang_Saku($data_pengguna);
  break;
  case 'Kuitansi_Honorarium':
    $report->Kuitansi_Honorarium($data_pengguna);
  break;
  case 'SPPD':
    $report->SPPD($data_pengguna);
  break;
  case 'SPTB':
    $report->SPTB($data_pengguna);
  break;case 'Rincian_Permintaan_Pengeluaran':
    $report->Rincian_Permintaan_Pengeluaran($data_pengguna);
  break;
  default:
    
  break;
}
?>
