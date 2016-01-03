<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';

switch ($process) {
  case 'import':
    $thang = $purifier->purify($_POST['thang']);
    $revisi = $purifier->purify($_POST['revisi']);
    $result = $rkakl->checkThang($thang);
    if ($result->num_rows == 0 || $revisi == 'true') {
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          $utility->load("content/rkakl","danger","Jenis file RKAKL yang di upload tidak sesuai");
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
              "tahun"      => $purifier->purify($_POST['thang'])
            );
            if ($thang == date("Y")+1 && $revisi == 'true') {
              $data_insert["status"] = 0;
            }
            if ($thang == date("Y")+1) {
              $data_insert["status"] = 2;
            }
            else {
              $data_insert["status"] = 1;
            }
            $rkakl->clearRkakl($thang);
            $rkakl->insertRkakl($data_insert);
            $rkakl->importRkakl($allDataInSheet);
            $utility->load("content/rkakl","success","Data RKAKL berhasil di import ke dalam database");
          }
        }
      }
      else {
        $utility->load("content/rkakl","warning","Belum ada file RKAKL yang di lampirkan");
      }
    }
    else {
      $utility->load("content/rkakl","warning","Maaf data tahun anggaran ".$thang." sudah ada, jika ingin melakukan perubahan harap revisi");
    }
    die();
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
        if($d==2){
          return '<i>Disusun</i>';
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
        if($d==2){
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
