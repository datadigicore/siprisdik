<?php
include 'config/application.php';

switch ($process) {
  case 'table':
    $table = "rabfull";
    $key   = "id";
    $dataArray['url_rewrite'] = $url_rewrite; 
    $dataArray['direktorat'] = $direk; 
    $tahun = $_POST['tahun'];
    $direktorat = $_POST['direktorat'];
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'kdprogram',  'dt' => 1, 'formatter' => function($d,$row, $dataArray){ 
          return '<table><tr><td>Program</td><td>&nbsp;:&nbsp;</td><td>'.$d.'</td></tr>'.
                 '<tr><td>Output</td><td>&nbsp;:&nbsp;</td><td>'.$row[7].'</td></tr>'.
                 '<tr><td>Sub Output</td><td>&nbsp;:&nbsp;</td><td>'.$row[8].'</td></tr>'.
                 '<tr><td>Komponen</td><td>&nbsp;:&nbsp;</td><td>'.$row[9].'</td></tr>'.
                 '<tr><td>Sub Komponen</td><td>&nbsp;:&nbsp;</td><td>'.$row[10].'</td></tr>'.
                 '<tr><td>Akun</td><td>&nbsp;:&nbsp;</td><td>'.$row[11].'</td></tr></table>';
      }),
      array( 'db' => 'deskripsi',  'dt' => 2),
      array( 'db' => 'tanggal',  'dt' => 3, 'formatter' => function( $d, $row ) {
            return date( 'j M Y', strtotime($d));
          }
      ),
      array( 'db' => 'value',  'dt' => 4,'formatter' => function ($d, $row) {
        return number_format($d,2);
      }),
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
          return '<i>Adendum</i>';
        }
        elseif($d==6){
          return '<i>Close Adendum</i>';
        }
        elseif($d==7){
          return '<i>Penutupan Anggaran</i>';
        }
      }),
      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row, $dataArray){ 
            $button = '<center><div class="text-center btn-group-vertical">';
            if ($d == 0 && $_SESSION['level'] != 0 ) {
              $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Ajukan</a>';
              $button .= '<a style="margin:0 2px;" href="#" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i> Edit Transaksi</a>';
            }elseif ($d == 0 && $_SESSION['level'] == 0) {
              $button .= 'N/A';
            }
            if ($d == 1 && $_SESSION['level'] != 0 ) {
              $button .= 'N/A';
            }elseif ($d == 1 && $_SESSION['level'] == 0) {
              $button .= '<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>';
              $button .= '<a style="margin:0 2px;" id="btn-rev" href="#revisi" class="btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Revisi</a>';
            }
            if ($d == 2 && $_SESSION['level'] != 0 ) {
              $button .= 'N/A';
            }elseif ($d == 2 && $_SESSION['level'] == 0) {
              $button .= 'N/A';
            }
            if ($d == 3 && $_SESSION['level'] != 0 ) {
              $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Ajukan</a>';
              $button .= '<a style="margin:0 2px;" href="#" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i> Edit Transaksi</a>';
            }elseif ($d == 3 && $_SESSION['level'] == 0) {
              $button .= 'N/A';
            }
            
            $button .= '</div></center>';
            return $button;
      }),
      array( 'db' => 'kdoutput',  'dt' => 7),
      array( 'db' => 'kdsoutput',  'dt' => 8),
      array( 'db' => 'kdkmpnen',  'dt' => 9),
      array( 'db' => 'kdskmpnen',  'dt' => 10),
      array( 'db' => 'kdakun',  'dt' => 11),
    );
    $where='kdakun like "51%" ';
    if ($tahun != "") {
      if ($where == "") {
        $where = 'thang = "'.$tahun.'"';
      }else{
        $where .= 'AND thang = "'.$tahun.'"';
      }
    }
    if ($direktorat != "") {
      if ($where == "") {
        $where .= 'kdgiat = "'.$direktorat.'"';
      }else{
        $where .= 'AND kdgiat = "'.$direktorat.'"';
      }
    }
    $datatable->get_table($table, $key, $column,$where,$dataArray);
    break;
  case 'getnpwp':
    $npwp = $mdl_rab->getnpwp();
    echo json_encode($npwp);
    break;
  case 'getakun':
    $akun = $mdl_rab->getakunrkakl51($_POST['prog'],$_POST['output'],$_POST['soutput'],$_POST['komp'],$_POST['skomp'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($akun);
    break;
  case 'save':
    $mdl_rab->save51($_POST);
    $utility->load("content/rab51/".$_POST['direktorat'],"success","Data RAB berhasil dimasukkan ke dalam database");
    break;
  case 'ajukan':
    $idrab = $_POST['id_rab_aju'];
    $akun = $mdl_rab->getrabfull($idrab);
    // print_r($akun);die;
    $error = false;
    // echo "<pre>";

    if($akun->kdakun != ""){  
      $rab = $mdl_rab->getRabAkun($akun);
      $jum_rkakl = $mdl_rab->getJumRkakl($akun);
      if ($jum_rkakl->jumlah < ($rab->jumlahrab + $jum_rkakl->realisasi + $jum_rkakl->usulan)) {
        $error = '1';
        $kderror[$i] = $akun->kdakun;
      }
    }else{  //kode akun kosong
      $error = '2';
      $kderror[$i] = $akun->kdakun;
    }


    if (!$error) {
      for ($i=0; $i < count($akun); $i++) { 
        if($akun->kdakun != ""){  // bukan belanja bahan
          $jum_rkakl = $mdl_rab->getJumRkakl($akun);
          $rab = $mdl_rab->getRabAkun($akun);
          $totalusul = $rab[0]->jumlahrab + $jum_rkakl->usulan;
          $item = $jum_rkakl->noitem;
          $pecah_item = explode(",", $item);
          $banyakitem = count($pecah_item);

          $totalperitem = floor($totalusul/$banyakitem);
          $sisaitem = $totalusul % $banyakitem;

          for ($x=0; $x < $banyakitem; $x++) { 
            if ($sisaitem == 0) {
              $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
            }else{
              if ($x == ($banyakitem-1)) {
                $totalperitem = $totalperitem + $sisaitem;
                $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
              }else{
                $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
              }
            }
          }
        }
      }
      $status = '1';
      $mdl_rab->chstatus51($idrab, $status);
      $utility->load("content/rab51/".$_SESSION['direktorat'],"success","Data RAB telah diajukan ke Bendahara Pengeluaran");
    }else{
      $kodeError = implode(", ", $kderror);
      if ($error == 1) {
        $utility->load("content/rab51/".$_SESSION['direktorat'],"warning","Proses tidak dilanjutkan. Kode Akun ".$kodeError." melebihi Pagu");
      }else{
        $utility->load("content/rab51/".$_SESSION['direktorat'],"danger","Proses tidak dilanjutkan. Terdapat kode akun yang kosong");
      }
    }
    break;
  case 'sahkan':
    $idrab = $_POST['id_rab_sah'];
    $akun = $mdl_rab->getrabfull($idrab);

    if($akun->kdakun != ""){  // bukan belanja bahan
      $jum_rkakl = $mdl_rab->getJumRkakl($akun);
      $item = $jum_rkakl->noitem;
      $pecah_item = explode(",", $item);
      $banyakitem = count($pecah_item);

      for ($x=0; $x < $banyakitem; $x++) { 
        $nilai = $mdl_rab->getRealUsul($akun, $pecah_item[$x]);
        $total = $nilai->realisasi + $nilai->usulan;
        $mdl_rab->moveRealisasi($akun, $pecah_item[$x], $total);
      }
    }

    $status = '2';
    $mdl_rab->chstatus51($idrab, $status);
    $utility->load("content/rab51/".$akun->kdgiat,"success","Data RAB telah disahkan");
    break;
  case 'revisi':
    $idrab = $_POST['id_rab_rev'];
    $akun = $mdl_rab->getrabfull($idrab);

    if($akun->kdakun != ""){  // bukan belanja bahan
      $jum_rkakl = $mdl_rab->getJumRkakl($akun);
      $rab = $mdl_rab->getRabAkun($akun);

      $totalusul = $jum_rkakl->usulan - $rab[0]->jumlahrab;
      $item = $jum_rkakl->noitem;
      $pecah_item = explode(",", $item);
      $banyakitem = count($pecah_item);

      $totalperitem = floor($totalusul/$banyakitem);
      $sisaitem = $totalusul % $banyakitem;

      for ($x=0; $x < $banyakitem; $x++) { 
        if ($sisaitem == 0) {
          $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
        }else{
          if ($x == ($banyakitem-1)) {
            $totalperitem = $totalperitem + $sisaitem;
            $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
          }else{
            $mdl_rab->insertUsulan($akun, $pecah_item[$x], $totalperitem);
          }
        }
      }
    }

    $status = '3';
    $mdl_rab->chstatus51($idrab, $status);
    $utility->load("content/rab51/".$akun->kdgiat,"success","Data RAB direvisi");
    break;
  default:
    $utility->location_goto(".");
  break;
}
?>
