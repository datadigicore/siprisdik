<?php
  require_once './config/application.php';
  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $temp_path = explode($PROSES_REQUEST,$path);
  $elements = explode('/', $temp_path[1]);
  $data = array_filter($elements);

  $direk = array( '5696' => 'Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti',
              '5697' => 'Pengembangan Kelembagaan Perguruan Tinggi',
              '5698' => 'Pembinaan Kelembagaan Perguruan Tinggi',
              '5699' => 'Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan',
              '5700' => 'Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya',
            );
  
  if (count($data) == 0){
    include "./index.php";
  }
  else {
    switch ($data[1]) {
      case 'user':
        $process = $data[2]; 
        include "./core/pengguna/proses_pengguna.php";
      break;
      case 'report':
        $process = $data[2]; 
        include "./core/pengguna/proses_report.php";
      break;
      case 'rkakl':
        $process = $data[2]; 
        include "./core/rkakl/proses_rkakl.php";
      break;
      case 'rab':
        $process = $data[2]; 
        include "./core/rab/proses_rab.php";
      break;
      case 'rab_rinci':
        $process = $data[2]; 
        include "./core/rab/proses_rab_rinci.php";
      break;
      case 'rab51':
        $process = $data[2]; 
        include "./core/rab/proses_rab51.php";
        break;
      case 'example':
        if ($data[2] == "hapusexample") {
          $hapusdata = $purifier->purify($data[3]);
        }
        else if ($data[2] == "anotherexample") {
          $publishdata = $purifier->purify($data[3]);
          $publishvalue = $purifier->purify($data[4]);
        }
        include "./core/today/proses_today.php";
      break;
      default:
        header('HTTP/1.1 404 Not Found');
        include "view/404.php";
      break;
    }
  }
?>
