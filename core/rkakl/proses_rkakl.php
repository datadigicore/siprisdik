<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';

switch ($process) {
  case 'import':
    $thang = $purifier->purify($_POST['thang']);
    $revisi = $purifier->purify($_POST['revisi']);
    
    $tanggal = $purifier->purify($_POST['tanggal']);
    $pecahtgl = explode("/", $tanggal);
    $tanggal = $pecahtgl[2].'-'.$pecahtgl[1].'-'.$pecahtgl[0];

    $no_dipa = $purifier->purify($_POST['no_dipa']);
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
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            $data_insert = array(
              "tanggal"    => $tanggal,
              "no_dipa"   => $no_dipa,
              "filename"   => $path,
              "filesave"   => $target_name,
              "keterangan" => $purifier->purify($_POST['keterangan']),
              "tahun"      => $purifier->purify($_POST['thang'])
            );

            if ($thang == date("Y")+1) {
              $data_insert["status"] = 2;
            }
            else {
              $data_insert["status"] = 1;
            }

            //pesan revisi
            if (isset($_POST['pesan'])) {
              $data_insert['pesan'] = $_POST['pesan'];
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
      array( 'db' => 'tahun',   'dt' => 1 ),
      array( 'db' => 'tanggal',  'dt' => 2, 'formatter' => function( $d, $row ) {
            return date( 'j-M-Y', strtotime($d));
          }
      ),
      array( 'db' => 'no_dipa',  'dt' => 3),
      // array( 'db' => 'filename',  'dt' => 4),
      // array( 'db' => 'keterangan',  'dt' => 4 ),
      array( 'db' => 'status', 'dt' => 4, 'formatter' => function($d,$row){ 
        if($d==1){
          return '<i>Digunakan</i> - Revisi '.$row[7];
        }
        if($d==2){
          return '<i>Disusun</i> - Revisi '.$row[7];
        }
        else {
          return '<i>Direvisi</i> - Revisi '.$row[7];
        }
      }),
      array( 'db' => 'status',  'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==1){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View</a>'.
                    '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>'.
                  '</div>';
        }
        if($d==2){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View</a>'.
                    '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>'.
                  '</div>';
        }
        else{
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View</a>'.
                    '<a style="margin:0 2px;" id="btn-pesan" href="#lihatpesan" class="btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-envelope"></i> Pesan</a>'.
                  '</div>';
        }
      }),
      array( 'db' => 'filesave',  'dt' => 6),
      array( 'db' => 'versi',  'dt' => 7),
      array( 'db' => 'pesan',  'dt' => 8),
    );
    $datatable->get_rkakl_view($table, $key, $column);
  break;
  case 'view':
    ini_set('memory_limit', '-1');
    $filesave = $purifier->purify($_POST['filename']);
    $data = new Spreadsheet_Excel_Reader($path_upload.$filesave);
    echo '<html>
    <head>
    <title>Sistem Informasi Pelaporan | Ristek Dikti</title>
    <link rel="shortcut icon" type="image/png" href="'.$url_rewrite."static/dist/img/risetdikti.png".'"/>
    <style>
    table.excel {border-style:ridge;border-width:1;border-collapse:collapse;font-family:sans-serif;font-size:12px;}
    table.excel thead th, table.excel tbody th {background:#CCCCCC;border-style:ridge;border-width:1;text-align: center;vertical-align:bottom;}
    table.excel tbody th {text-align:center;width:20px;}
    table.excel tbody td {vertical-align:bottom;}
    table.excel tbody td {padding: 0 3px;border: 1px solid #EEEEEE;}
    </style>
    </head>
    <body>'.$data->dump(true,true).'</body>
    </html>';
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
