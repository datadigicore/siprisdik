<?php
include 'config/application.php';

switch ($process) {
  case 'table':
    $table = "rabview";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'kdprogram',  'dt' => 1, 'formatter' => function($d,$row){ 
          return 'Program : '.$d.'<br>'.'Output : ';
      }),
      array( 'db' => 'desk',  'dt' => 2),
      array( 'db' => 'tanggal',  'dt' => 3, 'formatter' => function( $d, $row ) {
            return date( 'j M Y', strtotime($d));
          }
      ),
      array( 'db' => 'lokasi',  'dt' => 4 ),
      array( 'db' => 'status', 'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==0){
          return '<i>Belum Diajukan</i>';
        }
        elseif($d==1){
          return '<i>Telah Diajukan</i>';
        }
        elseif($d==2){
          return '<i>Telah Disahkan</i>';
        }
        elseif($d==3){
          return '<i>Revisi</i>';
        }
        elseif($d==4){
          return '<i>Close</i>';
        }
        elseif($d==5){
          return '<i>Kwitansi Telah Disahkan</i>';
        }
      }),
      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row){ 
        if($d==0 && $_SESSION['level'] != 0){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-trans" href="#" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-list"></i> Add Transaksi</a>'.
                    '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Ajukan</a>'.
                  '</div>';
        }elseif ($d==0 && $_SESSION['level'] == 0) {
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-trans" href="#" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-list"></i> Add Transaksi</a>'.
                  '</div>';
        }
        if($d==1  && $_SESSION['level'] != 0){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                  '</div>';
        }elseif ($d==1  && $_SESSION['level'] == 0) {
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                    '<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>'.
                    '<a style="margin:0 2px;" id="btn-rev" href="#revisi" class="btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>'.
                  '</div>';
        }
        else{
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                  '</div>';
        }
      }),
    );
    $datatable->get_table($table, $key, $column,$where="");
  break;
  case 'getout':
    $output = $mdl_rab->getout($_POST['prog'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($output);
    break;
  case 'getsout':
    $soutput = $mdl_rab->getsout($_POST['prog'],$_POST['output'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($soutput);
    break;
  case 'getkomp':
    $komp = $mdl_rab->getkomp($_POST['prog'],$_POST['output'],$_POST['soutput'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($komp);
    break;
  case 'save':
    $mdl_rab->save($_POST);
    $utility->load("content/rab","success","Data RAB berhasil dimasukkan ke dalam database");
    break;
  case 'ajukan':
    $mdl_rab->ajukan($_POST);
    $utility->load("content/rab","success","Data RAB telah diajukan ke Bendahara Pengeluaran");
    break;
  case 'sahkan':
    $mdl_rab->sahkan($_POST);
    $utility->load("content/rab","success","Data RAB telah disahkan");
    break;
  default:
    $utility->location_goto(".");
  break;
}
?>
