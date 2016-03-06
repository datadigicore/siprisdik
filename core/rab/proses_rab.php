<?php
include 'config/application.php';

switch ($process) {
  case 'table':
    $table = "rabview";
    $key   = "id";
    $dataArray['url_rewrite'] = $url_rewrite; 
    $dataArray['direktorat'] = $direk; 
    $tahun = $_POST['tahun'];
    $direktorat = $_POST['direktorat'];
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'kdprogram',  'dt' => 1, 'formatter' => function($d,$row, $dataArray){ 
          return '<table><tr><td>Program</td><td> :&nbsp;</td><td>'.$d.'</td></tr>'.
                 '<tr><td>Output</td><td> :&nbsp;</td><td>'.$row[9].'</td></tr>'.
                 '<tr><td>Sub Output</td><td> :&nbsp;</td><td>'.$row[10].'</td></tr>'.
                 '<tr><td>Komponen</td><td> :&nbsp;</td><td>'.$row[11].'</td></tr>'.
                 '<tr><td>Sub Komponen</td><td> :&nbsp;</td><td>'.$row[12].'</td></tr></table>';
      }),
      array( 'db' => 'kdgiat',  'dt' => 2, 'formatter' => function($d, $row, $dataArray){
        return $dataArray['direktorat'][$d];
      }),
      array( 'db' => 'deskripsi',  'dt' => 3),
      array( 'db' => 'tanggal',  'dt' => 4, 'formatter' => function( $d, $row ) {
        $arrbulan = array(
                '01'=>"Januari",
                '02'=>"Februari",
                '03'=>"Maret",
                '04'=>"April",
                '05'=>"Mei",
                '06'=>"Juni",
                '07'=>"Juli",
                '08'=>"Agustus",
                '09'=>"September",
                '10'=>"Oktober",
                '11'=>"November",
                '12'=>"Desember",
        );
        $pecahtgl1 = explode("-", $d);
        $tglawal = $pecahtgl1[2].' '.$arrbulan[$pecahtgl1[1]].' '.$pecahtgl1[0];
        $pecahtgl2 = explode("-", $row[15]);
        $tglakhir = $pecahtgl2[2].' '.$arrbulan[$pecahtgl2[1]].' '.$pecahtgl2[0];
        return $tglawal.' - '.$tglakhir;
      }),
      array( 'db' => 'lokasi',  'dt' => 5, 'formatter' => function($d,$row){
        return $row[14].', '.$d;
      }),
      array( 'db' => '(SELECT SUM(rabfull.value) from rabfull where rabfull.rabview_id = rabview.id group by rabfull.rabview_id)','dt' => 6, 'formatter' => function($d,$row){
        return 'Rp '.number_format($d,2,',','.');
      }),
      array( 'db' => 'status', 'dt' => 7, 'formatter' => function($d,$row){ 
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
      array( 'db' => 'status',  'dt' => 8, 'formatter' => function($d,$row, $dataArray){ 
        $button = '<div class="text-center btn-group-vertical">';
        if($d==0 && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list pull-left"></i> Rincian</a>';
          if ($_SESSION['level'] == 2) {
            $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check pull-left"></i> Ajukan</a>';
          }
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rab/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil pull-left"></i> Edit</a>';
        }
        elseif ($d==0 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list pull-left"></i> Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Rincian Keb. Dana</a>';
        }
        elseif($d==1  && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" class="btn btn-flat btn-primary btn-sm" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" ><i class="fa fa-list pull-left"></i> Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Rincian Keb. Dana</a>';        
        }

        elseif ($d==1  && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check pull-left"></i> Sahkan</a>';
          $button .= '<a style="margin:0 2px;" id="btn-rev" href="#revisi" class="btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-edit pull-left"></i> Revisi</a>';
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list pull-left"></i> Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak pengajuan_UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Rincian Keb. Dana</a>';
        }
        elseif($d==3 && $_SESSION['level'] != 0){
          if ($_SESSION['level'] == 2) {
            $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check pull-left"></i> Ajukan Revisi</a>';
          }
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rab/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil pull-left"></i> Edit</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list pull-left"></i> Rincian</a>';
        }
        elseif ($d==3 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list pull-left"></i> Rincian</a>';
        }
        elseif($d==6 && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list pull-left"></i> Rincian</a>';
        }
        elseif ($d==6 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-aju" href="#tutup" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check pull-left"></i> Penutupan Anggaran</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list pull-left"></i> Rincian</a>';
        }
        else{
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list pull-left"></i> Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file-text-o pull-left"></i> Cetak Rincian Keb. Dana</a>';
        }
        if ($row[13] != "") {
          $button .= '<a style="margin:0 2px;" id="btn-pesan" href="#pesanrevisi" class="btn btn-flat btn-info btn-sm" data-toggle="modal"><i class="fa fa-envelope pull-left"></i> Pesan</a>';
        }
        $button .= '</div>';
        return $button;
      }),
      array( 'db' => 'kdoutput',  'dt' => 9),
      array( 'db' => 'kdsoutput',  'dt' => 10),
      array( 'db' => 'kdkmpnen',  'dt' => 11),
      array( 'db' => 'kdskmpnen',  'dt' => 12),
      array( 'db' => 'pesan',  'dt' => 13),
      array( 'db' => 'tempat',  'dt' => 14),
      array( 'db' => 'tanggal_akhir',  'dt' => 15),
    );
    $where="";
    if ($tahun != "") {
      $where = 'thang = "'.$tahun.'"';
    }
    if ($direktorat != "") {
      if ($where == "") {
        $where .= 'kdgiat = "'.$direktorat.'"';
      }else{
        $where .= 'AND kdgiat = "'.$direktorat.'"';
      }
    }
    $group='';
    $datatable->get_table_group($table, $key, $column,$where,$group,$dataArray);
    break;
  case 'getnpwp':
    $jenis = $data[3];
    $npwp = $mdl_rab->getnpwp($jenis);
    echo json_encode($npwp);
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
  case 'edit':
    $mdl_rab->edit($_POST);
    $utility->load("content/rab","success","Data RAB berhasil diubah");
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
    $pesan = $_POST['pesan'];
    $mdl_rab->chstatus($id_rabview, $status);
    $mdl_rab->pesanrevisi($id_rabview, $pesan);
    $utility->load("content/rab","success","Data RAB direvisi");
    break;
  default:
    $utility->location_goto(".");
  break;
}
?>
