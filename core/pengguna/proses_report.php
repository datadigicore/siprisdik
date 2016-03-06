<?php
include 'config/application.php';
// require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
// require_once __DIR__ . '/../../utility/ExcelReader.php';
require_once './utility/PHPExcel.php';
require_once './utility/PHPExcel/IOFactory.php';

$sess_id    = $_SESSION['user_id'];
$direktorat = $_SESSION['direktorat'];

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
  case 'chart_pie':
    $report->getChartRKAKL();
  break;
  case 'Rincian_Biaya_PD':

    $report->rincian_biaya_PD($data[3]);
  break;
  case 'pengajuan_UMK':
    $report->pengajuan_UMK($data[3]);
  break;

  case 'rincian_kebutuhan_dana':
    $report->rincian_kebutuhan_dana($data[3]);
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
    $kode_mak = $purifier->purify($_POST['kode-mak']);
    $direktorat = $purifier->purify($_POST['direktorat']);
    $month = explode("-", $_POST['bulan']);
    $bulan = $month[0];
    $bulan_kata = $month[1];
    $report->SPP($direktorat, $bulan, $_POST,$kode_mak, $bulan_kata);
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
    $report->SPTB($kode_akun, $_POST['direktorat']);
  break;
  case 'Rincian_Permintaan_Pengeluaran':
    $kode_mak = $purifier->purify($_POST['kode-mak']);
    $direktorat = $purifier->purify($_POST['direktorat']);
    $month = explode("-", $_POST['bulan']);
    $bulan = $month[0];
    $bulan_kata = $month[1];
    // print_r($bulan);
    $report->Rincian_Permintaan_Pengeluaran($kode_mak, $direktorat, $bulan, $bulan_kata);
    // $report->rincian_kebutuhan_dana($direktorat);
  break;
  case 'Daya_Serap':
    $direktorat = $purifier->purify($_POST['direktorat']);
    $bulan = $purifier->purify($_POST['bulan']);
    $report->realisasi_daya_serap($direktorat, $bulan);
  break;
  case 'Rekap_Daya_Serap':
    $direktorat = $purifier->purify($_POST['direktorat']);
    $bulan = $purifier->purify($_POST['bulan']);
    // echo $direktorat." ".$bulan;
    $report->rekap_realisasi_daya_serap($direktorat, $bulan);
  break;
  case 'Rekap_Total':
    $direktorat = $purifier->purify($_POST['direktorat']);
    $bulan = $purifier->purify($_POST['bulan']);
    // echo $direktorat." ".$bulan;
    $report->rekap_total($direktorat, $bulan);
  break;
  case 'serapan':
    $direktorat = $purifier->purify($_POST['direktorat']);
    $bulan = $purifier->purify($_POST['bulan']);
    // echo $direktorat." ".$bulan;
    $report->serapan($direktorat, $bulan);
   break;
  default:
    
    echo $kdakun;
  break;
}
?>
