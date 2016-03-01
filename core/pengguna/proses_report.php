<?php
include 'config/application.php';
// require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
// require_once __DIR__ . '/../../utility/ExcelReader.php';
require_once __DIR__ . '/../../utility/PHPExcel.php';
    $object = new PHPExcel();

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
  // case 'laporan':
  //   // require_once 'Classes/PHPExcel.php';
  //   // Create new PHPExcel object
  //    
  //   // Set properties
  //   // $object->getProperties()->setCreator("Tempo")
  //   //                ->setLastModifiedBy("Tempo")
  //   //                ->setCategory("Approve by ");
  //   // Add some data
  //   $object->getActiveSheet()->getColumnDimension('A')->setWidth(50);
  //   $object->getActiveSheet()->getColumnDimension('B')->setWidth(30);
  //   $object->getActiveSheet()->getColumnDimension('C')->setWidth(30);
  //   $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
  //   $object->getActiveSheet()->getColumnDimension('E')->setWidth(30);
  //   $object->getActiveSheet()->getColumnDimension('F')->setWidth(30);
  //   $object->getActiveSheet()->mergeCells('A1:F1');
  //   $object->getActiveSheet()->mergeCells('A2:F2');
  //   $object->setActiveSheetIndex(0)
  //               ->setCellValue('A1', 'Rekap Berita Approved by : '.$_GET['user'])
  //               ->setCellValue('A4', 'Judul')
  //               ->setCellValue('B4', 'Uploader')
  //               ->setCellValue('C4', 'Approve Date')
  //               ->setCellValue('D4', 'Delay Date')
  //               ->setCellValue('E4', 'Drop Date')
  //               ->setCellValue('F4', 'Post Edit Date');
  //    
  //   //add data
  //   $counter=5;
  //   $ex = $object->setActiveSheetIndex(0);
  //   // while($d=mysql_fetch_array($q)){
  //   //            
  //   //           $time_approve='-';
  //   //           $time_delay='-';
  //   //           $time_drop='-';
  //   //           $time_passed='-';
  //   //            
  //   //            
  //   //           $status=$d['approved_status'];
  //   //           $date=$d['date'];
  //   //           if($status==1){
  //   //             $time_approve=$date;
  //   //           }
  //   //           else if($status==2){
  //   //             $time_delay=$date;
  //   //           }
  //   //           else if($status==3){
  //   //             $time_drop=$date;
  //   //           }
  //   //           else if($status==4){
  //   //             $time_passed=$date;
  //   //           }
  //   //           $ex->setCellValue("A".$counter,$d['judul']);
  //   //           $ex->setCellValue("B".$counter,$d['sender']);
  //   //           $ex->setCellValue("C".$counter,"$time_approve");
  //   //           $ex->setCellValue("D".$counter,"$time_delay");
  //   //           $ex->setCellValue("E".$counter,"$time_drop");
  //   //           $ex->setCellValue("F".$counter,"$time_passed");
  //   //           $counter=$counter+1;
  //   //            
  //   // }    
  //    
  //   // Rename sheet
  //   $object->getActiveSheet()->setTitle('Detail_approve_');
  //    
  //    
  //   // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  //   $object->setActiveSheetIndex(0);
  //    
  //    
  //   // Redirect output to a client’s web browser (Excel2007)
  //   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  //   header('Content-Disposition: attachment;filename="Detail_approve.xlsx"');
  //   header('Cache-Control: max-age=0');
  //    
  //   $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
  //   $objWriter->save();
  //   exit;
  //   break;
  default:
    
    echo $kdakun;
  break;
}
?>
