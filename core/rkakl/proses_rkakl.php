<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';

switch ($process) {
  case 'import':
    if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
      $path = $_FILES['fileimport']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if($ext != 'xls' && $ext != 'xlsx') {
        $utility->load("content/rkakl","danger","Jenis file yang di upload tidak sesuai");
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
          $rkakl->clearRkakl();
          $rkakl->insertRkakl($data_insert);
          $rkakl->importRkakl($allDataInSheet);
          $utility->load("content/rkakl","success","Data berhasil di import ke dalam database");
        }
      }
    }
    else {
      $utility->load("content/rkakl","warning","Belum ada file excel rkakl yang di lampirkan");
    }
  break;
  case 'table':
    $table = "rkakl_view";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'tanggal',  'dt' => 1, 'formatter' => function( $d, $row ) {
            return date( 'j-M-Y \&\n\b\s\p\&\n\b\s\p\&\n\b\s\p H:i', strtotime($d));
          }
      ),
      array( 'db' => 'filename',  'dt' => 2),
      array( 'db' => 'keterangan',  'dt' => 3 ),
      array( 'db' => 'tahun',   'dt' => 4 ),
      array( 'db' => 'status', 'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==1){
          return '<i>Digunakan</i>';
        }
        else {
          return '<i>Direvisi</i>';
        }
      }),
      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row){ 
        if($d==1){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" href="#viewFile" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View</a>'.
                    '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>'.
                  '</div>';
        }
        else{
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" href="#viewFile" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View</a>'.
                  '</div>';
        }
      }),
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
