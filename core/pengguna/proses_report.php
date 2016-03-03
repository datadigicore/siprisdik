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
  case 'laporan_bulanan_TA':
    $report->getRkaklFull();
    $objectExcel->setActiveSheetIndex(0); 
    $rowCount = 1; 
    $objectExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Firstname');
    $objectExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Lastname');
    $objectExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Branch');
    $objectExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Gender');
    $objectExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Mobileno');
    $objectExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'Email');
    while($row = mysql_fetch_array($result)){ 
    $rowCount++;
    $objectExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['0']);
    $objectExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['1']);
    $objectExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['2']);
    $objectExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['3']);
    $objectExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['4']);
    $objectExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['5']);
    } 
    $objWriter = new PHPExcel_Writer_Excel2007($objectExcel); 
    $objWriter->save('some_excel_file.xlsx');
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
    $kode_mak = $purifier->purify($_POST['kode-mak']);
    $direktorat = $purifier->purify($_POST['direktorat']);
    $bulan = $purifier->purify($_POST['bulan']);
    $report->SPP($direktorat, $bulan, $_POST,$kode_mak);
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
    $bulan = $purifier->purify($_POST['bulan']);
    $report->Rincian_Permintaan_Pengeluaran($kode_mak, $direktorat, $bulan);
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
