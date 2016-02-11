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

$id = $data[3];

$kdakun = $report->get_kd_akun($id);

$param  = explode("-", $data[3]);
$id = $param[0];
// $penerima = str_replace("%20"," ",$param[1]);
$format = $param[2];
switch ($data[2]) {
  case 'cetak_dok':
    $report->cetak_dok($id,$param[1],$format);
  break;
  case 'Rincian_Biaya_PD':

    $report->rincian_biaya_PD($data[3]);
  break;
  case 'pengajuan_UMK':
    $report->pengajuan_UMK($data[3]);
  break;
  case '522151':
    $report->Kuitansi_Honor_Uang_Saku($data_pengguna);
  break;
  case 'Kuitansi_Honorarium':
    $id = $data[3];
    $report->Kuitansi_Honor_Uang_Saku($id);
  break;
  case 'Kuitansi_Honorarium':
    $id = $data[3];
    $report->Kuitansi_Honor_Uang_Saku($id);
  break;
  case 'SPPD':
    $report->SPPD($data_pengguna);
  break;
  case 'SPP':
    $report->SPP($data_pengguna);
  break;
  case 'SPTB':
    $kode_akun = $purifier->purify($_POST['kode-akun']);
    $kode_satker = $purifier->purify($_POST[kode_satker]);
    $nama_satker = $purifier->purify($_POST[nama_satker]);
    $tanggal_DIPA = $purifier->purify($_POST[tanggal_DIPA]);
    $no_DIPA = $purifier->purify($_POST[no_DIPA]);
    $klasifikasi_MA = $purifier->purify($_POST[klasifikasi_MA]); // Klasifikasi Mata Anggaran
    $data = array(
      "kode_satker"  => $kode_satker,
      "nama_satker"  => $nama_satker,
      "tanggal_DIPA" => $tanggal_DIPA,
      "no_DIPA"      => $no_DIPA,
      "klasifikasi_MA"=> $klasifikasi_MA
    );
    $report->SPTB($kode_akun);
  break;
  case 'Rincian_Permintaan_Pengeluaran':
    $kode_mak = $purifier->purify($_POST['kode-mak']);
    $report->Rincian_Permintaan_Pengeluaran($kode_mak);
  break;
  default:
    
    echo $kdakun;
  break;
}
?>
