<?php
include 'config/application.php';

switch ($process) {
  case 'table':
    $table = "rabview";
    $key   = "id";
    $dataArray['url_rewrite'] = $url_rewrite; 
    $dataArray['direktorat'] = $direk; 
    $dataArray['idrkakl'] = $_POST['idrkakl'];
    $tahun = $_POST['tahun'];
    $kdprogram = $_POST['kdprogram'];
    $kdgiat = $_POST['direktorat'];
    $kdoutput = $_POST['kdoutput'];
    $kdsoutput = $_POST['kdsoutput'];
    $kdkmpnen = $_POST['kdkmpnen'];
    $kdskmpnen = $_POST['kdskmpnen'];

    #realisasi
    $query="SELECT `id`,`rabview_id`, `value`, `status`
            FROM `rabfull` WHERE kdprogram = '$kdprogram' AND kdgiat = '$kdgiat' and kdoutput = '$kdoutput' and kdsoutput = '$kdsoutput' and kdkmpnen = '$kdkmpnen' and kdskmpnen = '$kdskmpnen' " ;
    $result=$db->_fetch_array($query,1);

    $rabview =array();
    $key_stack=array();
    $jumlah = 0;
    if (!is_null($result)) {
      foreach ($result as $a => $b) {
        $id=$b['id'];
        $rabview_id=$b['rabview_id'];
        $jumlah=$b['value'];
        $status=$b['status'];
        if ($status == 2 || $status == 4 || $status == 5 || $status == 6 || $status == 0 || $status == 1 || $status == 3) {
          $dataArray['jumlah']["$rabview_id"] += $jumlah;
        }else{
          $dataArray['jumlah']["$rabview_id"] += 0;
        }
      }
    }

    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'deskripsi',  'dt' => 1),
      array( 'db' => 'tanggal',  'dt' => 2, 'formatter' => function( $d, $row ) {
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
        $pecahtgl2 = explode("-", $row[9]);
        $tglakhir = $pecahtgl2[2].' '.$arrbulan[$pecahtgl2[1]].' '.$pecahtgl2[0];
        return $tglawal.' - '.$tglakhir;
      }),
      array( 'db' => 'lokasi',  'dt' => 3, 'formatter' => function($d,$row){
        return $row[8].', '.$d;
      }),
      array( 'db' => 'id', 'dt' => 4, 'formatter' => function($d,$row,$data){
        return 'Rp '.number_format($data['jumlah'][$row[4]],2,',','.');
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
        $button = '<div class="btn-group col-sm-12"> <b>';
        if($d==0 && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          if ($_SESSION['level'] == 2) {
            $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="col-sm-12 btn btn-flat btn-success btn-sm col-sm" data-toggle="modal"><i class="fa fa-check"></i>&nbsp; Ajukan</a>';
          }
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rab/edit/'.$row[0].'/'.$dataArray['idrkakl'].'" class="col-sm-12 btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>';
          $button .= '<a style="margin:0 2px;" id="btn-del" href="#delete" class="col-sm-12 btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-close"></i>&nbsp; Delete</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Rincian Keb. Dana</a>';
        }
        elseif ($d==0 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Rincian Keb. Dana</a>';
        }
        elseif($d==1  && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" class="col-sm-12 btn btn-flat btn-primary btn-sm" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" ><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Rincian Keb. Dana</a>';        
        }

        elseif ($d==1  && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="col-sm-12 btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i>&nbsp; Sahkan</a>';
          $button .= '<a style="margin:0 2px;" id="btn-rev" href="#revisi" class="col-sm-12 btn btn-flat btn-warning btn-sm" data-toggle="modal"><i class="fa fa-edit"></i>&nbsp; Revisi</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Rincian Keb. Dana</a>';
        }
        elseif($d==3 && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          if ($_SESSION['level'] == 2) {
            $button .= '<a style="margin:0 2px;" id="btn-aju" href="#ajuan" class="col-sm-12 btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i>&nbsp; Ajukan Revisi</a>';
          }
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rab/edit/'.$row[0].'/'.$dataArray['idrkakl'].'" class="col-sm-12 btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>';
          if ($row[7] != "") {
            $button .= '<a style="margin:0 2px;" id="btn-pesan" href="#pesanrevisi" class="col-sm-12 btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-envelope"></i>&nbsp; Pesan </a>';
          }
        }
        elseif ($d==3 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 col-sm-12 btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          if ($row[7] != "") {
            $button .= '<a style="margin:0 2px;" id="btn-pesan" href="#pesanrevisi" class="col-sm-12 btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-envelope"></i>&nbsp; Pesan </a>';
          }
        }
        elseif($d==6 && $_SESSION['level'] != 0){
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Rincian</a>';
        }
        elseif ($d==6 && $_SESSION['level'] == 0) {
          $button .= '<a style="margin:0 2px;" id="btn-aju" href="#tutup" class="col-sm-12 btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i>&nbsp; Penutupan Anggaran</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Rincian</a>';
        }
        else{
          $button .= '<a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'" class="col-sm-12 btn btn-flat btn-primary btn-sm " ><i class="fa fa-list"></i>&nbsp; Rincian</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/pengajuan_UMK/'.$row[0].'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Pengajuan UMK</a>';
          $button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/rincian_kebutuhan_dana/'.$row[0].'/1'.'" class="col-sm-12 btn btn-flat btn-default btn-sm" ><i class="fa fa-file-text-o"></i>&nbsp; Cetak Daftar PJ UMK</a>';
        }
        $button .= '</b></div>';
        return $button;
      }),
      array( 'db' => 'pesan',  'dt' => 7),
      array( 'db' => 'tempat',  'dt' => 8),
      array( 'db' => 'tanggal_akhir',  'dt' => 9),
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
    if ($kdoutput != "") {
      if ($where == "") {
        $where .= 'kdoutput = "'.$kdoutput.'"';
      }else{
        $where .= 'AND kdoutput = "'.$kdoutput.'"';
      }
    }
    if ($kdsoutput != "") {
      if ($where == "") {
        $where .= 'kdsoutput = "'.$kdsoutput.'"';
      }else{
        $where .= 'AND kdsoutput = "'.$kdsoutput.'"';
      }
    }
    if ($kdkmpnen != "") {
      if ($where == "") {
        $where .= 'kdkmpnen = "'.$kdkmpnen.'"';
      }else{
        $where .= 'AND kdkmpnen = "'.$kdkmpnen.'"';
      }
    }
    if ($kdskmpnen != "") {
      if ($where == "") {
        $where .= 'kdskmpnen = "'.$kdskmpnen.'"';
      }else{
        $where .= 'AND kdskmpnen = "'.$kdskmpnen.'"';
      }
    }
    $group='';
    $datatable->get_table_group($table, $key, $column,$where,$group,$dataArray);
    break;
  case 'table-rkakl':
    $table = "rkakl_full";
    $key   = "KDGIAT";
    $dataArray['url_rewrite'] = $url_rewrite; 
    // $dataArray['direktorat'] = $direk; 
    $tahun = $_POST['tahun'];
    $kdgrup = $_POST['kdgrup'];
    $kewenangan = $mdl_rab->getKewenangan($kdgrup);
    $arrKdprogram = $kewenangan['kdprogram'];
    $arrDirektorat = $kewenangan['kdgiat'];
    $arrKdoutput = $kewenangan['kdoutput'];
    
    #realisasi
    $kdprog = implode("','", $arrKdprogram);
    $kddir = implode("','", $arrDirektorat);
    $kdout = implode("','", $arrKdoutput);
    if($_SESSION['level']!=0){
      $whererab = "WHERE kdprogram in ('$kdprog') and kdgiat in ('$kddir') and kdoutput in ('$kdout') ";
    }
    $query="SELECT `id`, `thang`, `kdprogram`, `kdgiat`, `kdoutput`, `kdsoutput`, `kdkmpnen`, `kdskmpnen`, `deskripsi`, `tanggal`, `tanggal_akhir`, `tempat`, `lokasi`, `value`, `status` 
            FROM `rabfull` $whererab " ;
    $result=$db->_fetch_array($query,1);

    $rabview =array();
    $key_stack=array();
    if (!is_null($result)) {
      foreach ($result as $key => $value) {
        $id=$value['id'];
        $thang=$value['thang'];
        $kdprogram=$value['kdprogram'];
        $kdgiat=$value['kdgiat'];
        $kdoutput=$value['kdoutput'];
        $kdsoutput=$value['kdsoutput'];
        $kdkmpnen=$value['kdkmpnen'];
        $kdskmpnen=$value['kdskmpnen'];
        $idtriwulan=$value['idtriwulan'];
        $jumlah=$value['value'];
        $status=$value['status'];
        $key="$kdprogram-$kdgiat-$kdoutput-$kdsoutput-$kdkmpnen-$kdskmpnen";
        $dataArray["$kdprogram-$kdgiat-$kdoutput-$kdsoutput-$kdkmpnen-$kdskmpnen"]['key']=$key;
        if ($status == 2 || $status == 4 || $status == 5 || $status == 6) {
          $dataArray["$kdprogram-$kdgiat-$kdoutput-$kdsoutput-$kdkmpnen-$kdskmpnen"]['realisasi'] += $jumlah;
        }elseif($status == 0 || $status == 1 || $status == 3){
          $dataArray["$kdprogram-$kdgiat-$kdoutput-$kdsoutput-$kdkmpnen-$kdskmpnen"]['usulan'] += $jumlah;
        }
      }
    }

    $column = array(
      array( 'db' => 'IDRKAKL',      'dt' => 0, 'formatter' => function($d,$row){
        return $row[0];
      }),
      array( 'db' => 'CONCAT(KDGIAT," - ",NMGIAT) AS KDGIAT',   'field' => 'KDGIAT', 'as' => 'KDGIAT',   'dt' => 1, 'formatter' => function($d,$row){
        return $row[1];
      }),
      array( 'db' => 'CONCAT(KDOUTPUT," - ",NMOUTPUT) AS KDOUTPUT',   'field' => 'KDOUTPUT', 'as' => 'KDOUTPUT',   'dt' => 2, 'formatter' => function($d,$row){
        return $row[2];
      }),
      array( 'db' => 'CONCAT(KDSOUTPUT," - ",NMSOUTPUT) AS KDSOUTPUT',   'field' => 'KDSOUTPUT', 'as' => 'KDSOUTPUT',   'dt' => 3, 'formatter' => function($d,$row){
        return $row[3];
      }),
      array( 'db' => 'CONCAT(KDKMPNEN," - ",NMKMPNEN) AS KDKMPNEN',   'field' => 'KDKMPNEN', 'as' => 'KDKMPNEN',   'dt' => 4, 'formatter' => function($d,$row){
        return $row[4];
      }),
      array( 'db' => 'CONCAT(KDSKMPNEN," - ",NMSKMPNEN) AS KDSKMPNEN',   'field' => 'KDKMPNEN', 'as' => 'KDSKMPNEN',   'dt' => 5, 'formatter' => function($d,$row){
        return $row[5];
      }),
      array( 'db' => 'SUM(JUMLAH) as JUMLAH', 'field' => 'JUMLAH', 'as' => 'JUMLAH',    'dt' => 6, 'formatter' => function($d,$row){
        return number_format($row[6],2,".",".");
      }),
      array( 'db' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN) ',  'field' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN)', 'as' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN)',   'dt' => 7, 'formatter' => function($d,$row,$data){
        if(!isset($data["$row[7]"]['realisasi']) || $data["$row[7]"]['realisasi'] == 0 || $data["$row[7]"]['realisasi'] == ''){
          return 0;
        } else {
          return number_format($data["$row[7]"]['realisasi'],2,".",".");
        }
      }),
      array( 'db' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN) ',  'field' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN)', 'as' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN)',   'dt' => 8, 'formatter' => function($d,$row,$data){
        if(!isset($data["$row[8]"]['usulan']) || $data["$row[8]"]['usulan'] == 0 || $data["$row[8]"]['usulan'] == ''){
          return 0;
        } else {
          return number_format($data["$row[8]"]['usulan'],2,".",".");
        }
      }),
      array( 'db' => 'CONCAT(KDPROGRAM,"-",KDGIAT,"-",KDOUTPUT,"-",KDSOUTPUT,"-",KDKMPNEN,"-",KDSKMPNEN) as i',   'field' => 'SISA', 'as' => 'SISA',   'dt' => 9, 'formatter' => function($d,$row){
        return number_format(($row[6]-($row[7]+$row[8])),2,",",".");
      }),
      array( 'db' => 'NMOUTPUT',      'dt' => 10, 'formatter' => function($d,$row, $dataArray){
        $button = '<div class="btn-group"><a style="margin:0 2px;" href="'.$dataArray['url_rewrite'].'content/rab/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Rincian</a><div>';
        return $button;
      }),
    );
    $where=[];
    if($_SESSION['level']!=0){
      $i=0;
      foreach ($arrKdprogram as $key => $value) {
        # code...
        if ($where[$i] == "") {
          $where[$i] .= 'KDPROGRAM = "'.$value.'"';
        }else{
          $where[$i] .= ' AND KDPROGRAM = "'.$value.'"';
        }
        $where[$i] .= ' AND status = 1';
        $i++;
      }
      $i=0;
      foreach ($arrDirektorat as $key => $value) {
        # code...
        if ($where[$i] == "") {
          $where[$i] .= 'KDGIAT = "'.$value.'"';
        }else{
          $where[$i] .= ' AND KDGIAT = "'.$value.'"';
        }
        $where[$i] .= ' AND status = 1';
        $i++;
      }
      $i=0;
      foreach ($arrKdoutput as $key => $value) {
        # code...
        if ($where[$i] == "") {
          $where[$i] .= 'KDOUTPUT= "'.$value.'"';
        }else{
          $where[$i] .= ' AND KDOUTPUT = "'.$value.'"';
        }
        $where[$i] .= ' AND status = 1';
        $i++;
      }
    }

    // if ($tahun != "") {
    //   $where = 'thang = "'.$tahun.'"';
    // }
    // print_r($where);exit;
    // if ($kewenangan['kdprogram'].) {
    //   if ($where == "") {
    //     $where .= 'KDGIAT = "'.$direktorat.'"';
    //   }else{
    //     $where .= 'AND KDGIAT = "'.$direktorat.'"';
    //   }
    // }

    $group='KDGIAT, KDOUTPUT, KDSOUTPUT, KDKMPNEN, KDSKMPNEN';
    $datatable->get_table_union($table, $key, $column,$where,$group,$dataArray);
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
  case 'getout2':
    $output = $mdl_rab->getout2($_POST['prog'],$_POST['direktorat']);
    echo json_encode($output);
    break;
  case 'getsout':
    $soutput = $mdl_rab->getsout($_POST['prog'],$_POST['output'],$_POST['tahun'],$_POST['direktorat']);
    echo json_encode($soutput);
    break;
  case 'getDirektorat':
    $kdprog = $_POST['prog'];
    $rs = $mdl_rab->getDirektorat($kdprog);
    echo json_encode($rs);
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
    $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB berhasil dimasukkan ke dalam database");
    break;
  case 'edit':
    $id_rabview = $_POST['idview'];
    $akun = $mdl_rab->getview($id_rabview);
    $mdl_rab->edit($_POST);
    $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB telah diubah");
    break;
  case 'ajukan':
    $id_rabview = $_POST['id_rab_aju'];
    $akun = $mdl_rab->getakun($id_rabview);
    $view = $mdl_rab->getview($id_rabview);
    $error = false;
    for ($i=0; $i < count($akun); $i++) { 
      if ($akun[$i]->kdakun == "") {  //kode akun kosong
        $error = '2';
        $kderror[$i] = $akun[$i]->kdakun;
      }
    }
    if (!$error) {
      $status = '1';
      $mdl_rab->chstatus($id_rabview, $status);
      $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB telah diajukan ke Bendahara Pengeluaran");
    }else{
      $kodeError = implode(", ", $kderror);
      if ($error == 1) {
        $utility->load("content/rab/".$_POST['idrkakl'],"warning","Proses tidak dilanjutkan. Kode Akun ".$kodeError." melebihi Pagu");
      }else{
        $utility->load("content/rab/".$_POST['idrkakl'],"error","Proses tidak dilanjutkan. Terdapat data yang kosong");
      }
    }
    break;
  case 'sahkan':
    $id_rabview = $_POST['id_rab_sah'];
    $akun = $mdl_rab->getakun($id_rabview);
    $view = $mdl_rab->getview($id_rabview);
    for ($i=0; $i < count($akun); $i++) { 
      $valuelama = $akun[$i]->value;
      if ($akun[$i]->kdakun == 521211) {  //belanja bahan
        $rab = $mdl_rab->getRabItem($akun[$i]);
        for ($j=0; $j < count($rab); $j++) { 
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
          // print_r($jum_rkakl);die;
          $realisasi = $jum_rkakl->realisasi;
          $usulan = $jum_rkakl->usulan - $valuelama;
          $total = $realisasi + $valuelama;
          $item = $rab[$j]->noitem;
          $mdl_rab->moveRealisasi($akun[$i], $item, $total, $usulan);
        }
      }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
        $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
        $usulan = $jum_rkakl->usulan;
        $totalusul = $usulan - $valuelama;

        $realisasi = $jum_rkakl->realisasi;
        $totalreal = $realisasi + $valuelama;

        $item = $jum_rkakl->noitem;
        $pecah_item = explode(",", $item);
        $banyakitem = count($pecah_item);

        $totalperitem = floor($totalreal/$banyakitem);
        $sisaitem = $totalreal % $banyakitem;

        $totalitemlama = floor($totalusul/$banyakitem);
        $sisalama = $totalusul % $banyakitem;

        for ($x=0; $x < $banyakitem; $x++) { 
          if ($x == ($banyakitem-1)) {
            $totalperitem = $totalperitem + $sisaitem;
            $totalitemlama = $totalitemlama + $sisalama;
            $mdl_rab->moveRealisasi($akun[$i], $pecah_item[$x], $totalperitem, $totalitemlama);
          }else{
            $mdl_rab->moveRealisasi($akun[$i], $pecah_item[$x], $totalperitem, $totalitemlama);
          }
        }
      }
    }
    $status = '2';
    $mdl_rab->chstatus($id_rabview, $status);
    $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB telah disahkan");
    break;
  case 'revisi':
    $id_rabview = $_POST['id_rab_rev'];
    $view = $mdl_rab->getview($id_rabview);
    $status = '3';
    $pesan = $_POST['pesan'];
    $mdl_rab->chstatus($id_rabview, $status);
    $mdl_rab->pesanrevisi($id_rabview, $pesan);
    $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB direvisi");
    break;
  case 'delete':
    $id_rabview = $_POST['id_rab_del'];
    $akun = $mdl_rab->getakun($id_rabview);
    for ($i=0; $i < count($akun); $i++) { 
      $valrab = $akun[$i]->value;
      $kodeakun = $akun[$i]->kdakun;
      if ($akun[$i]->kdakun == 521211) {  //belanja bahan
        $rab = $mdl_rab->getRabItem($akun[$i]);
        for ($j=0; $j < count($rab); $j++) { 
          $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i], $rab[$j]);
          $usulan = $jum_rkakl->usulan;
          $total =  $usulan - $valrab;
          $item = $rab[$j]->noitem;
          $mdl_rab->insertUsulan2($akun[$i],$kodeakun, $item, $total);
        }
      }elseif($akun[$i]->kdakun != ""){  // bukan belanja bahan
        $jum_rkakl = $mdl_rab->getJumRkakl($akun[$i]);
        // $item = $jum_rkakl->noitem;
        // $pecah_item = explode(",", $item);
        // $banyakitem = count($pecah_item);

        // for ($x=0; $x < $banyakitem; $x++) { 
        //   $nilai = $mdl_rab->getRealUsul($akun[$i], $pecah_item[$x]);
        //   $total = $nilai->usulan;
        //   $mdl_rab->moveRealisasi($akun[$i], $pecah_item[$x], $total);
        // }
        $totalusul = $jum_rkakl->usulan - $valrab;
        $itemgroup = $jum_rkakl->noitem;
        $pecah_item = explode(",", $itemgroup);
        $banyakitem = count($pecah_item);

        $totalperitem = floor($totalusul/$banyakitem);
        $sisaitem = $totalusul % $banyakitem;
        for ($x=0; $x < $banyakitem; $x++) { 
          if ($sisaitem == 0) {
            $mdl_rab->insertUsulan2($akun[$i], $kodeakun, $pecah_item[$x], $totalperitem);
          }else{
            if ($x == ($banyakitem-1)) {
              $totalperitem = $totalperitem + $sisaitem;
              $mdl_rab->insertUsulan2($akun[$i], $kodeakun, $pecah_item[$x], $totalperitem);
            }else{
              $mdl_rab->insertUsulan2($akun[$i], $kodeakun, $pecah_item[$x], $totalperitem);
            }
          }
        }
      }
    }
    $mdl_rab->deleterab($id_rabview);
    $utility->load("content/rab/".$_POST['idrkakl'],"success","Data RAB telah dihapus");
    break;
  case 'importrkaklreal':
    if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          $utility->load("content/rabdetail/".$id_rab_view."/add/".$status,"error","Jenis file yang di upload tidak sesuai");
        }
        else {
          $time = time();
          $target_dir = $path_upload;
          $target_name = basename(date("Ymd-His-\R\A\B.",$time).$ext);
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
            // echo "<pre>";
            // print_r($allDataInSheet);die;
            $data = $mdl_rab->importrealisasi($allDataInSheet);
            // echo "<pre>"; print_r($data);die;
            if ($data['error'] == 'true') {
              $utility->load("content/real-upload/1",'error','Proses Tidak Dapat Dilanjutkan. Silahkan Validasi dan Unggah Kembali.');
            }else{
              $utility->load("content/real-upload/0",'success','Telah Berhasil Diupload. Silahkan Melanjutkan Proses.');
            }
          }
        }
      }
      else {
        $utility->load("content/real-upload/1","warning","Belum ada file Excel yang di lampirkan");
      }
    die();
    break;
  case 'table_real_upload':
    $rabview_id = $_POST['id_rab_view'];
    $dataArray['url_rewrite'] = $url_rewrite;
    $get_table = "import_real";
    $key   = "id";
    $column = array(
        array( 'db' => 'id',      'dt' => 0 ),
        array( 'db' => 'kode',  'dt' => 1),
        array( 'db' => 'uraian',  'dt' => 2),
        array( 'db' => 'dipa', 'dt' => 3, 'formatter' => function($d,$row){
          $error = $row[6];
          if ($error == "1") {
            $val = '<span class="label label-warning">'.number_format($d,2,',','.').'</span>';
          }elseif ($error == "2") {
            $val = '<span class="label label-danger">'.number_format($d,2,',','.').'</span>';
          }else{
            $val = number_format($d,2,',','.');
          }
          return $val;
        }),
        array( 'db' => 'realisasi', 'dt' => 4, 'formatter' => function($d,$row){
          $error = $row[6];
          if ($error == "1") {
            $val = '<span class="label label-warning">'.number_format($d,2,',','.').'</span>';
          }elseif ($error == "2") {
            $val = '<span class="label label-danger">'.number_format($d,2,',','.').'</span>';
          }else{
            $val = number_format($d,2,',','.');
          }
          return $val;
        }),
        array( 'db' => 'sisa', 'dt' => 5, 'formatter' => function($d,$row){$error = $row[6];
          if ($error == "1") {
            $val = '<span class="label label-warning">'.number_format($d,2,',','.').'</span>';
          }elseif ($error == "2") {
            $val = '<span class="label label-danger">'.number_format($d,2,',','.').'</span>';
          }else{
            $val = number_format($d,2,',','.');
          }
          return $val;
        }),
        array( 'db' => 'error',  'dt' => 6),
    );

    $where = 'created_by = "'.$_SESSION['id'].'"';
    $group = '';

    $datatable->get_table($get_table, $key, $column,$wherex, $dataArray);
    break;
  case 'save_import_real':
    $id_rab_view = "0";
    $getsave = $mdl_rab->save_temprabfull_real($id_rab_view);
    $utility->load("content/real-upload/","success","Data berhasil dimasukkan ke dalam database");
    break;
  case 'delimportreal':
    $mdl_rab->hapusimportreal();
    break;
  default:
    $utility->location_goto(".");
  break;
}
?>
