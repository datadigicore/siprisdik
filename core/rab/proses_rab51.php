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
      array( 'db' => '(select concat(r.kdakun," - ",r.nmakun) from rkakl_full as r where r.KDAKUN = rabfull.kdakun limit 1)', 'dt' => 1),
      array( 'db' => 'tanggal',  'dt' => 2, 'formatter' => function( $d, $row ) {
            return date( 'j M Y', strtotime($d));
          }
      ),
      array( 'db' => 'value',  'dt' => 3,'formatter' => function ($d, $row) {
        return number_format($d,2);
      }),
      array( 'db' => 'status',  'dt' => 4, 'formatter' => function($d,$row, $dataArray){ 
          if ($_SESSION['level']==0) {
            $button = '<center><div class="text-center btn-group-vertical">';
            $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rab51/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i> Edit Transaksi</a>';
            $button .= '</div></center>';
          }
          else{
            $button = '<center> - </center>';
          }
            return $button;
      }),
      // array( 'db' => 'kdoutput',  'dt' => 5),
      // array( 'db' => 'kdsoutput',  'dt' => 6),
      // array( 'db' => 'kdkmpnen',  'dt' => 7),
      // array( 'db' => 'kdskmpnen',  'dt' => 8),
      // array( 'db' => 'kdakun',  'dt' => 9),
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
    // $datatable->get_table_join($table,$table2, $key, $column, $on, $where, $group, $dataArray);
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
    $utility->load("content/rab51","success","Data RAB berhasil dimasukkan ke dalam database");
    break;
  case 'edit':
    $mdl_rab->edit51($_POST);
    $utility->load("content/rab51/".$_POST['direktorat'],"success","Data RAB berhasil diubah");
    break;
  case 'ajukan':
    $idrab = $_POST['id_rab_aju'];
    $akun = $mdl_rab->getrabfull($idrab);
    $error = false;
    // echo "<pre>";

    if($akun->kdakun != ""){  
      $jum_rkakl = $mdl_rab->getJumRkakl($akun);
      $jumlah1 = $jum_rkakl->jumlah;
      $jumlah2 = $akun->value + $jum_rkakl->realisasi + $jum_rkakl->usulan;
      if ($jumlah1 < $jumlah2) {
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

          $totalusul = $akun->value + $jum_rkakl->usulan;
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
        $utility->load("content/rab51/".$_SESSION['direktorat'],"error","Proses tidak dilanjutkan. Terdapat kode akun yang kosong");
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
