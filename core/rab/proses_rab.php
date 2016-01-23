<?php
include 'config/application.php';

switch ($process) {
  case 'table':
    $table = "rabview";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'kdprogram',  'dt' => 1, 'formatter' => function($d,$row){ 
          return 'Program : '.$row[1].
                '<br>'.'Output : '.$row[7].
                '<br>'.'Suboutput : '.$row[8].
                '<br>'.'Komponen : '.$row[9];
      }),
      array( 'db' => 'deskripsi',  'dt' => 2),
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
          return '<i>Penutupan Anggaran</i>';
        }
      }),
      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row){ 
        if($d==0 && $_SESSION['level'] != 0){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-trans" href="'.$url_rewrite.'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Add Transaksi</a>'.
                    '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Ajukan</a>'.
                  '</div>';
        }elseif ($d==0 && $_SESSION['level'] == 0) {
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-trans" href="'.$url_rewrite.'rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i> Add Transaksi</a>'.
                     '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Cetak Rincian</a>'.
                  '</div>';
        }
        if($d==1  && $_SESSION['level'] != 0){
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                     '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Cetak Rincian</a>'.
                  '</div>';
        }elseif ($d==1  && $_SESSION['level'] == 0) {
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                     '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Cetak Rincian</a>'.
                    '<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>'.
                    '<a style="margin:0 2px;" id="btn-rev" href="#revisi" class="btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>'.
                  '</div>';
        }
        else{
          return  '<div class="text-center">'.
                    '<a style="margin:0 2px;" id="btn-viw" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-file-text-o"></i> View Transaksi</a>'.
                     '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Cetak Rincian</a>'.
                  '</div>';
        }
      }),
      array( 'db' => 'kdoutput',  'dt' => 7),
      array( 'db' => 'kdsoutput',  'dt' => 8),
      array( 'db' => 'kdkmpnen',  'dt' => 9),
    );
    $datatable->get_table($table, $key, $column,$where="");
    break;
  case 'getout':
    // print_r($_POST);die;
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
  case 'getskomp':
    $skomp = $mdl_rab->getskomp($_POST['prog'],$_POST['output'],$_POST['soutput'],$_POST['komp'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($skomp);
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
