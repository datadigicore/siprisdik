<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';

switch ($process) {
  case 'import':
    $arr = get_defined_functions();
    // echo "Tes Case";
    // print('<pre>');
    // print_r($_FILES['fileimport']);
    if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
      $path = $_FILES['fileimport']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if($ext != 'xls' && $ext != 'xlsx') {
        echo '<p> Invalid File </p>';
        $invalid = 1;
      }
      else {
        $time = time();
        $target_dir = $path_upload;
        $target_name = basename(date("Ymd-His-\R\K\A\K\L.",$time).$ext);
        $target_file = $target_dir . $target_name;
        $response = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
        if($response) {
          try {
            $objPHPExcel = PHPExcel_IOFactory::load($target_file);
          }
          catch(Exception $e) {
            die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
          }
          $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
          $data_insert = array(
            "tanggal"    => date("Y-m-d H:i:s",$time),
            "filename"   => $path,
            "filesave"   => $target_name,
            "keterangan" => $purifier->purify($_POST['keterangan']),
            "tahun"      => date("Y",$time)
          );
          $rkakl->insertRkakl($data_insert);
          $rkakl->clearRkakl();
          $rkakl->importRkakl($allDataInSheet);
          $utility->load("content/rkakl","success","Data berhasil diimport");
        }
      }
    }
  break;
  case 'table':
    $table = "rkakl_view";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'tanggal',  'dt' => 1 ),
      array( 'db' => 'filename',  'dt' => 2),
      array( 'db' => 'keterangan',  'dt' => 3 ),
      array( 'db' => 'tahun',   'dt' => 4 ),
      array( 'db' => 'status', 'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==1){
          return 'Digunakan';
        }
        else {
          return '-';
        }
      })
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
