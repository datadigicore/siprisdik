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
                 '<tr><td>Output</td><td>&nbsp;:&nbsp;</td><td>'.$row[6].'</td></tr>'.
                 '<tr><td>Sub Output</td><td>&nbsp;:&nbsp;</td><td>'.$row[7].'</td></tr>'.
                 '<tr><td>Komponen</td><td>&nbsp;:&nbsp;</td><td>'.$row[8].'</td></tr>'.
                 '<tr><td>Sub Komponen</td><td>&nbsp;:&nbsp;</td><td>'.$row[9].'</td></tr>'.
                 '<tr><td>Akun</td><td>&nbsp;:&nbsp;</td><td>'.$row[10].'</td></tr></table>';
      }),
      array( 'db' => 'deskripsi',  'dt' => 2),
      array( 'db' => 'tanggal',  'dt' => 3, 'formatter' => function( $d, $row ) {
            return date( 'j M Y', strtotime($d));
          }
      ),
      array( 'db' => 'value',  'dt' => 4,'formatter' => function ($d, $row) {
        return number_format($d,2);
      }),
      array( 'db' => 'status',  'dt' => 5, 'formatter' => function($d,$row, $dataArray){ 
          return  '<div class="text-center btn-group-vertical">'.
                    '<a style="margin:0 2px;" href="#" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> View Transaksi</a>'.
                    '<a style="margin:0 2px;" href="#" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i> Edit Transaksi</a>'.
                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."pdf".'" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-file"></i>&nbsp; Cetak Kuitansi (PDF)</a>'.
                     '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."word".'" class="btn btn-flat btn-info btn-sm"><i class="fa fa-file"></i>&nbsp; Cetak Kuitansi (Word)</a>';
                  '</div>';
      }),
      array( 'db' => 'kdoutput',  'dt' => 6),
      array( 'db' => 'kdsoutput',  'dt' => 7),
      array( 'db' => 'kdkmpnen',  'dt' => 8),
      array( 'db' => 'kdskmpnen',  'dt' => 9),
      array( 'db' => 'kdakun',  'dt' => 10),
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
    $id_rabview = $_POST['id_rab_aju'];
    $akun = $mdl_rab->getakun($id_rabview);
    $error = false;
    // echo "<pre>";
    for ($i=0; $i < count($akun); $i++) { 
      if ($akun[$i]->kdakun == 521211) {  //belanja bahan
        $rab = $mdl_rab->getRabItem($akun[$i]);
        for ($j=0; $j < count($rab); $j++) { 
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
          if ($jum_rkakl->jumlah < ($rab[$j]->jumlahrab + $jum_rkakl->realisasi + $jum_rkakl->usulan)) {
            $error = '1';
            $kderror[$i] = $akun[$i]->kdakun;
          }
        }
      }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
        $rab = $mdl_rab->getRabAkun($akun[$i]);
        $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
        if ($jum_rkakl->jumlah < ($rab->jumlahrab + $jum_rkakl->realisasi + $jum_rkakl->usulan)) {
          $error = '1';
          $kderror[$i] = $akun[$i]->kdakun;
        }
      }else{  //kode akun kosong
        $error = '2';
        $kderror[$i] = $akun[$i]->kdakun;
      }
    }

    if (!$error) {
      for ($i=0; $i < count($akun); $i++) { 
        if ($akun[$i]->kdakun == 521211) {  //belanja bahan
          $rab = $mdl_rab->getRabItem($akun[$i]);
          for ($j=0; $j < count($rab); $j++) { 
            $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
            $total = $jum_rkakl->usulan + $rab[$j]->jumlahrab;
            $item = $rab[$j]->noitem;
            $mdl_rab->insertUsulan($akun[$i], $item, $total);
          }
        }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
          $rab = $mdl_rab->getRabAkun($akun[$i]);
          $totalusul = $rab[0]->jumlahrab + $jum_rkakl->usulan;
          $item = $jum_rkakl->noitem;
          $pecah_item = explode(",", $item);
          $banyakitem = count($pecah_item);

          $totalperitem = floor($totalusul/$banyakitem);
          $sisaitem = $totalusul % $banyakitem;

          for ($x=0; $x < $banyakitem; $x++) { 
            if ($sisaitem == 0) {
              $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
            }else{
              if ($x == ($banyakitem-1)) {
                $totalperitem = $totalperitem + $sisaitem;
                $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
              }else{
                $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
              }
            }
          }
        }
      }
      $status = '1';
      $mdl_rab->chstatus($id_rabview, $status);
      $utility->load("content/rab","success","Data RAB telah diajukan ke Bendahara Pengeluaran");
    }else{
      $kodeError = implode(", ", $kderror);
      if ($error == 1) {
        $utility->load("content/rab","warning","Proses tidak dilanjutkan. Kode Akun ".$kodeError." melebihi Pagu");
      }else{
        $utility->load("content/rab","danger","Proses tidak dilanjutkan. Terdapat kode akun yang kosong");
      }
    }
    break;
  case 'sahkan':
    $id_rabview = $_POST['id_rab_sah'];
    $akun = $mdl_rab->getakun($id_rabview);
    for ($i=0; $i < count($akun); $i++) { 
      if ($akun[$i]->kdakun == 521211) {  //belanja bahan
        $rab = $mdl_rab->getRabItem($akun[$i]);
        for ($j=0; $j < count($rab); $j++) { 
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
          $realisasi = $jum_rkakl->realisasi;
          $usulan = $jum_rkakl->usulan;
          $total = $realisasi + $usulan;
          $item = $rab[$j]->noitem;
          $mdl_rab->moveRealisasi($akun[$i], $item, $total);
        }
      }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
        $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
        $item = $jum_rkakl->noitem;
        $pecah_item = explode(",", $item);
        $banyakitem = count($pecah_item);

        for ($x=0; $x < $banyakitem; $x++) { 
          $nilai = $mdl_rab->getRealUsul($akun[$i], $pecah_item[$x]);
          $total = $nilai->realisasi + $nilai->usulan;
          $mdl_rab->moveRealisasi($akun[$i], $pecah_item[$x], $total);
        }
      }
    }
    $status = '2';
    $mdl_rab->chstatus($id_rabview, $status);
    $utility->load("content/rab","success","Data RAB telah disahkan");
    break;
  case 'revisi':
    $id_rabview = $_POST['id_rab_rev'];
    $akun = $mdl_rab->getakun($id_rabview);
    for ($i=0; $i < count($akun); $i++) { 
      if ($akun[$i]->kdakun == 521211) {  //belanja bahan
        $rab = $mdl_rab->getRabItem($akun[$i]);
        for ($j=0; $j < count($rab); $j++) { 
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
          $total = $jum_rkakl->usulan - $rab[$j]->jumlahrab;
          $item = $rab[$j]->noitem;
          $mdl_rab->insertUsulan($akun[$i], $item, $total);
        }
      }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
        $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
        $rab = $mdl_rab->getRabAkun($akun[$i]);

        $totalusul = $jum_rkakl->usulan - $rab[0]->jumlahrab;
        $item = $jum_rkakl->noitem;
        $pecah_item = explode(",", $item);
        $banyakitem = count($pecah_item);

        $totalperitem = floor($totalusul/$banyakitem);
        $sisaitem = $totalusul % $banyakitem;

        for ($x=0; $x < $banyakitem; $x++) { 
          if ($sisaitem == 0) {
            $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
          }else{
            if ($x == ($banyakitem-1)) {
              $totalperitem = $totalperitem + $sisaitem;
              $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
            }else{
              $mdl_rab->insertUsulan($akun[$i], $pecah_item[$x], $totalperitem);
            }
          }
        }
      }
    }
    $status = '3';
    $mdl_rab->chstatus($id_rabview, $status);
    $utility->load("content/rab","success","Data RAB direvisi");
    break;
  default:
    $utility->location_goto(".");
  break;
}
?>
