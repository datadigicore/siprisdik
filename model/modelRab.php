<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelRab extends mysql_db {

    public function getOrang($data){
      $penerima = $data['penerima'];
      $jenis = $data['jenis'];
      $query  = "SELECT * FROM rabfull as r 
                  where penerima = '$penerima' and jenis='$jenis' group by r.npwp order by id desc";
      $result = $this->query($query);
      while ($fetch = $this->fetch_array($result)) {
        $data['nip'] = $fetch['nip'];
        $data['npwp'] = $fetch['npwp'];
        $data['pajak'] = $fetch['pajak'];
        $data['golongan'] = $fetch['golongan'];
        $data['jabatan'] = $fetch['jabatan'];
        $data['pns'] = $fetch['pns'];
      }
      return $data;
    }

    public function getYear(){
      $query  = "SELECT thang FROM rkakl_full as r where thang != '' group by r.thang";
      $result = $this->query($query);
      $i=0;
      while ($fetch = $this->fetch_object($result)) {
        $data[$i] = $fetch->thang;
        $i++;
      }
      return $data;
    }

    public function getProg() {
      $query  = "SELECT KDPROGRAM FROM rkakl_full as r group by r.kdprogram";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data[$i] = $fetch->KDPROGRAM;
        $i++;
      }
      return $data;
    }

    public function getout($prog, $th, $dr) {
      $query  = "SELECT KDOUTPUT, NMOUTPUT FROM rkakl_full as r 
                where kdprogram='$prog' and thang='$th' and kdgiat='$dr' 
                  group by r.KDOUTPUT";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDOUTPUT'][$i] = $fetch->KDOUTPUT;
        $data['NMOUTPUT'][$i] = $fetch->NMOUTPUT;
        $i++;
      }
      return $data;
    }

    public function getsout($prog, $output, $th, $dr) {
      $query  = "SELECT KDSOUTPUT, NMSOUTPUT FROM rkakl_full as r 
                  where kdprogram='$prog' and kdoutput='$output' and thang='$th' and kdgiat='$dr' 
                  group by r.KDSOUTPUT";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDSOUTPUT'][$i] = $fetch->KDSOUTPUT;
        $data['NMSOUTPUT'][$i] = $fetch->NMSOUTPUT;
        $i++;
      }
      return $data;
    }

    public function getkomp($prog, $output, $soutput, $th, $dr) {
      $query  = "SELECT KDKMPNEN, NMKMPNEN FROM rkakl_full as r 
                  where kdprogram='$prog' and kdoutput='$output' and kdsoutput='$soutput' and thang='$th' and kdgiat='$dr' 
                  group by r.KDKMPNEN";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDKMPNEN'][$i] = $fetch->KDKMPNEN;
        $data['NMKMPNEN'][$i] = $fetch->NMKMPNEN;
        $i++;
      }
      return $data;
    }

    public function getskomp($prog, $output, $soutput, $komp, $th, $dr) {
      $query  = "SELECT KDSKMPNEN, NMSKMPNEN FROM rkakl_full as r 
                  where kdprogram='$prog' and kdoutput='$output' and kdsoutput='$soutput' and kdkmpnen='$komp' and thang='$th' and kdgiat='$dr' 
                  group by r.KDSKMPNEN";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDSKMPNEN'][$i] = $fetch->KDSKMPNEN;
        $data['NMSKMPNEN'][$i] = $fetch->NMSKMPNEN;
        $i++;
      }
      return $data;
    }

    public function getakunrkakl51($prog, $output, $soutput, $komp, $skomp, $th, $dr) {
      $query  = "SELECT KDAKUN, NMAKUN FROM rkakl_full as r 
                  where kdprogram='$prog' and kdoutput='$output' and kdsoutput='$soutput' and kdkmpnen='$komp' and kdskmpnen='$skomp' and thang='$th' and kdgiat='$dr' 
                  AND kdakun like '51%'
                  group by r.KDSKMPNEN";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDAKUN'][$i] = $fetch->KDAKUN;
        $data['NMAKUN'][$i] = $fetch->NMAKUN;
        $i++;
      }
      return $data;
    }

    public function getnpwp($jenis){
      $query = "SELECT npwp, penerima FROM rabfull where jenis = '$jenis' and (npwp != '' or npwp is not null) group by npwp";
      $result = $this->query($query);
      $i=0;
      while ($fetch  = $this->fetch_object($result)) {
        $data['npwp'][$i] = $fetch->npwp;
        $data['penerima'][$i] = $fetch->penerima;
        $i++;
      }
      return $data;
    }

    public function save($data){
      $direktorat = $data['direktorat'];
      $tahun      = $data['tahun'];
      $prog       = $data['prog'];
      $output     = $data['output'];
      $soutput    = $data['soutput'];
      $komp       = $data['komp'];
      $skomp      = $data['skomp'];
      $uraian     = $data['uraian'];
      $t          = explode("/", $data['tanggal']);
      $tgl        = $t[2].'-'.$t[1].'-'.$t[0];
      $t2         = explode("/", $data['tanggal_akhir']);
      $tgl_akhir  = $t2[2].'-'.$t2[1].'-'.$t2[0];
      $lokasi     = $data['lokasi'];
      $tempat     = $data['tempat'];

      $query      = "INSERT INTO rabview SET
        thang       = '$tahun',
        kdprogram   = '$prog',
        kdgiat      = '$direktorat',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen   = '$skomp',
        deskripsi   = '$uraian',
        tanggal     = '$tgl',
        tanggal_akhir = '$tgl_akhir',
        lokasi      = '$lokasi',
        tempat      = '$tempat',
        status      = '0'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function save51($data){
      $direktorat = $data['direktorat'];
      $tahun = $data['tahun'];
      $prog = $data['prog'];
      $output = $data['output'];
      $soutput = $data['soutput'];
      $komp = $data['komp'];
      $skomp = $data['skomp'];
      $akun = $data['akun'];
      $deskripsi = $data['deskripsi'];
      $value = $data['jumlah'];
      $t = explode("/", $data['tanggal']);
      $tgl=$t[2].'-'.$t[1].'-'.$t[0];
      $t2         = explode("/", $data['tanggal_akhir']);
      $tgl_akhir  = $t2[2].'-'.$t2[1].'-'.$t2[0];

      $query      = "INSERT INTO rabfull SET
        thang       = '$tahun',
        kdprogram   = '$prog',
        kdgiat      = '$direktorat',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen    = '$skomp',
        kdakun    = '$akun',
        deskripsi   = '$deskripsi',
        tanggal     = '$tgl',
        tanggal_akhir     = '$tgl_akhir',
        value     = '$value',
        status      = '0'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function edit($data){
      $idview = $data['idview'];
      $tahun = $data['tahun'];
      $output = $data['output'];
      $soutput = $data['soutput'];
      $komp = $data['komp'];
      $skomp = $data['skomp'];
      $uraian = $data['uraian'];
      $t = explode("/", $data['tanggal']);
      $tgl=$t[2].'-'.$t[1].'-'.$t[0];
      $t2         = explode("/", $data['tanggal_akhir']);
      $tgl_akhir  = $t2[2].'-'.$t2[1].'-'.$t2[0];
      $lokasi = $data['lokasi'];
      $tempat = $data['tempat'];

      $query      = "UPDATE rabview SET
        thang       = '$tahun',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen   = '$skomp',
        deskripsi   = '$uraian',
        tanggal     = '$tgl',
        tanggal_akhir = '$tgl_akhir',
        lokasi      = '$lokasi',
        tempat      = '$tempat'
        WHERE id = '$idview'
      ";

      $query2      = "UPDATE rabfull SET
        thang       = '$tahun',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen   = '$skomp',
        deskripsi   = '$uraian',
        tanggal     = '$tgl',
        tanggal_akhir = '$tgl_akhir',
        lokasi      = '$lokasi',
        tempat      = '$tempat'
        WHERE rabview_id = '$idview'
      ";
      $result = $this->query($query);
      $result2 = $this->query($query2);
      return $result;
    }

    public function edit51($data){
      $idrab = $data['idrab'];
      $tahun = $data['tahun'];
      $output = $data['output'];
      $soutput = $data['soutput'];
      $komp = $data['komp'];
      $skomp = $data['skomp'];
      $akun = $data['akun'];
      $deskripsi = $data['deskripsi'];
      $value = $data['jumlah'];
      $t = explode("/", $data['tanggal']);
      $tgl=$t[2].'-'.$t[1].'-'.$t[0];
      $t2         = explode("/", $data['tanggal_akhir']);
      $tgl_akhir  = $t2[2].'-'.$t2[1].'-'.$t2[0];

      $query      = "UPDATE rabfull SET
        thang       = '$tahun',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen   = '$skomp',
        kdakun      = '$akun',
        deskripsi   = '$deskripsi',
        tanggal     = '$tgl',
        tanggal_akhir = '$tgl_akhir',
        value       = '$value'
        WHERE id = '".$idrab."'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function getakun($id_rabview){
      $query_rab = "SELECT * FROM rabfull where rabview_id = '$id_rabview' group by kdakun";
      $res_rab = $this->query($query_rab);
      while ($rab = $this->fetch_object($res_rab)) {
        $akun[] = $rab;
      }
      return $akun;
    }

    public function getakungroup($data){
      $thang      = $data->thang;
      $kdprogram  = $data->kdprogram;
      $kdgiat     = $data->kdgiat;
      $kdoutput   = $data->kdoutput;
      $kdsoutput  = $data->kdsoutput;
      $kdkmpnen   = $data->kdkmpnen;
      $kdskmpnen  = $data->kdskmpnen;
      $penerima   = $data->penerima;
      $npwp       = $data->npwp;
      $jenis      = $data->jenis;
      // print_r($data);die;
      $query_rab  = "SELECT kdakun, count(0) as banyak FROM rabfull 
                            WHERE thang='$thang'
                            AND kdprogram='$kdprogram'
                            AND kdgiat='$kdgiat'
                            AND kdoutput='$kdoutput'
                            AND kdsoutput='$kdsoutput'
                            AND kdkmpnen='$kdkmpnen'
                            AND kdskmpnen='$kdskmpnen'
                            AND penerima='$penerima'
                            AND npwp='$npwp'
                            AND jenis='$jenis'
                          GROUP BY kdakun";
      $res_rab    = $this->query($query_rab);
      while ($rab = $this->fetch_object($res_rab)) {
        $akun[] = $rab;
      }
      return $akun;
    }

    public function getRabItem($data){
      $rab = $data;
      $qry_jumrab = "SELECT noitem, sum(value) as jumlahrab FROM rabfull
                          WHERE thang='$rab->thang'
                            AND kdprogram='$rab->kdprogram'
                            AND kdgiat='$rab->kdgiat'
                            AND kdoutput='$rab->kdoutput'
                            AND kdsoutput='$rab->kdsoutput'
                            AND kdkmpnen='$rab->kdkmpnen'
                            AND kdskmpnen='$rab->kdskmpnen'
                            AND kdakun='$rab->kdakun'
                          GROUP BY noitem
                          ";
      $res_rab = $this->query($qry_jumrab);
      while ($rab = $this->fetch_object($res_rab)) {
        $item[] = $rab;
      }
      return $item;
    }

    public function getRabAkun($data){
      $rab = $data;
      $qry_jumrab = "SELECT kdakun, sum(value) as `jumlahrab` FROM rabfull
                          WHERE thang='$rab->thang'
                            AND kdprogram='$rab->kdprogram'
                            AND kdgiat='$rab->kdgiat'
                            AND kdoutput='$rab->kdoutput'
                            AND kdsoutput='$rab->kdsoutput'
                            AND kdkmpnen='$rab->kdkmpnen'
                            AND kdskmpnen='$rab->kdskmpnen'
                            AND kdakun='$rab->kdakun'
                          GROUP BY kdakun
                          ";
      $res_rab = $this->query($qry_jumrab);
      while ($rab = $this->fetch_object($res_rab)) {
        $item[] = $rab;
      }
      return $item;
    }

    public function getJumRkakl($dataAkun, $dataItem=null){
      $rab = $dataAkun;
      if ($dataItem != null) {
        $whereitem = "AND NOITEM='".$dataItem->noitem."' GROUP BY NOITEM";
      }else{
        $whereitem = "GROUP BY KDAKUN";
      }
      $qry_rkakl = "SELECT sum(jumlah) as `jumlah`, sum(realisasi) as `realisasi`, sum(usulan) as `usulan`, GROUP_CONCAT(noitem) as noitem
                     FROM rkakl_full 
                      WHERE THANG='$rab->thang'
                      AND KDPROGRAM='$rab->kdprogram'
                      AND KDGIAT='$rab->kdgiat'
                      AND KDOUTPUT='$rab->kdoutput'
                      AND KDSOUTPUT='$rab->kdsoutput'
                      AND KDKMPNEN='$rab->kdkmpnen'
                      AND KDSKMPNEN='$rab->kdskmpnen'
                      AND KDAKUN='$rab->kdakun'
                      ".$whereitem."
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_object($res_rkakl)) {
        $jumrkakl = $jumlah;
      }
      return $jumrkakl;
    }

    public function getJumRkakl2($data, $akun){
      $rab = $data;
      // print_r($rab);
      $whereitem = "GROUP BY KDAKUN";
      $qry_rkakl = "SELECT sum(jumlah) as `jumlah`, sum(realisasi) as `realisasi`, sum(usulan) as `usulan`
                     FROM rkakl_full 
                      WHERE THANG='$rab->thang'
                      AND KDPROGRAM='$rab->kdprogram'
                      AND KDGIAT='$rab->kdgiat'
                      AND KDOUTPUT='$rab->kdoutput'
                      AND KDSOUTPUT='$rab->kdsoutput'
                      AND KDKMPNEN='$rab->kdkmpnen'
                      AND KDSKMPNEN='$rab->kdskmpnen'
                      AND KDAKUN='$akun'
                      ".$whereitem."
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_object($res_rkakl)) {
        $jumrkakl = $jumlah;
      }
      return $jumrkakl;
    }

    public function insertUsulan($dataAkun, $item, $total){
      $rab = $dataAkun;
      if ($total == 0) {
        $total = 'null';
      }
      $query = "UPDATE rkakl_full SET usulan='$total' WHERE THANG='$rab->thang'
                                                      AND KDPROGRAM='$rab->kdprogram'
                                                      AND KDGIAT='$rab->kdgiat'
                                                      AND KDOUTPUT='$rab->kdoutput'
                                                      AND KDSOUTPUT='$rab->kdsoutput'
                                                      AND KDKMPNEN='$rab->kdkmpnen'
                                                      AND KDSKMPNEN='$rab->kdskmpnen'
                                                      AND KDAKUN='$rab->kdakun'
                                                      AND NOITEM = '$item'
                                                      ";

      $result = $this->query($query);

      return $result;
    }

    public function getRealUsul($dataAkun, $item){
      $rab = $dataAkun;
      $qry_rkakl = "SELECT realisasi, usulan
                     FROM rkakl_full 
                      WHERE THANG='$rab->thang'
                      AND KDPROGRAM='$rab->kdprogram'
                      AND KDGIAT='$rab->kdgiat'
                      AND KDOUTPUT='$rab->kdoutput'
                      AND KDSOUTPUT='$rab->kdsoutput'
                      AND KDKMPNEN='$rab->kdkmpnen'
                      AND KDSKMPNEN='$rab->kdskmpnen'
                      AND KDAKUN='$rab->kdakun'
                      AND NOITEM='".$item."'
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_object($res_rkakl)) {
        $jumrkakl = $jumlah;
      }
      return $jumrkakl;
    }

    public function moveRealisasi($dataAkun, $item, $total){
      $rab = $dataAkun;
      $query = "UPDATE rkakl_full SET realisasi='$total', usulan=null 
                      WHERE THANG='$rab->thang'
                        AND KDPROGRAM='$rab->kdprogram'
                        AND KDGIAT='$rab->kdgiat'
                        AND KDOUTPUT='$rab->kdoutput'
                        AND KDSOUTPUT='$rab->kdsoutput'
                        AND KDKMPNEN='$rab->kdkmpnen'
                        AND KDSKMPNEN='$rab->kdskmpnen'
                        AND KDAKUN='$rab->kdakun'
                        AND NOITEM = '$item'
                       ";

      $result = $this->query($query);

      return $result;
    }

    public function revisi($dataAkun, $item, $total){
      $rab = $dataAkun;
      $query = "UPDATE rkakl_full SET usulan=null 
                      WHERE THANG='$rab->thang'
                        AND KDPROGRAM='$rab->kdprogram'
                        AND KDGIAT='$rab->kdgiat'
                        AND KDOUTPUT='$rab->kdoutput'
                        AND KDSOUTPUT='$rab->kdsoutput'
                        AND KDKMPNEN='$rab->kdkmpnen'
                        AND KDSKMPNEN='$rab->kdskmpnen'
                        AND KDAKUN='$rab->kdakun'
                        AND NOITEM = '$item'
                       ";

      $result = $this->query($query);

      return $result;
    }

    public function chstatus($id_rabview, $status){
      $query = "UPDATE rabview SET status='$status' WHERE id = '$id_rabview'";
      $query2 = "UPDATE rabfull SET status='$status' WHERE rabview_id = '$id_rabview'";

      $result = $this->query($query);
      $result2 = $this->query($query2);

      if ($status == 1) {
        $query3 = "UPDATE rabview SET submit_at='".date("Y-m-d H:i:s")."', submit_by = '".$_SESSION['id']."' WHERE id = '$id_rabview'";
        $result3 = $this->query($query3);
      }elseif ($status == 2) {
        $query3 = "UPDATE rabview SET approve_at='".date("Y-m-d H:i:s")."', approve_by = '".$_SESSION['id']."' WHERE id = '$id_rabview'";
        $result3 = $this->query($query3);
      }

      return array('result' => $result,
                    'result2' => $result2
                  );
    }

    public function chstatus51($idrab, $status){
      $query = "UPDATE rabfull SET status='$status' WHERE id = '$idrab'";

      $result = $this->query($query);

      return array('result' => $result,
                  );
    }

    public function chStatusFull($id_rabfull, $status){
      $query = "UPDATE rabfull SET status='$status' WHERE id = '$id_rabfull'";

      $result = $this->query($query);

      return $result;
    }

    public function chStatusFullOrang($data, $status){
      $thang      = $data->thang;
      $kdprogram  = $data->kdprogram;
      $kdgiat     = $data->kdgiat;
      $kdoutput   = $data->kdoutput;
      $kdsoutput  = $data->kdsoutput;
      $kdkmpnen   = $data->kdkmpnen;
      $kdskmpnen  = $data->kdskmpnen;
      $penerima   = $data->penerima;
      $npwp       = $data->npwp;
      $jenis      = $data->jenis;

      $query = "UPDATE rabfull SET status='$status' 
                          WHERE thang='$thang'
                            AND kdprogram='$kdprogram'
                            AND kdgiat='$kdgiat'
                            AND kdoutput='$kdoutput'
                            AND kdsoutput='$kdsoutput'
                            AND kdkmpnen='$kdkmpnen'
                            AND kdskmpnen='$kdskmpnen'
                            AND penerima='$penerima'
                            AND npwp='$npwp'
                            AND jenis='$jenis'";

      $result = $this->query($query);

      return $result;
    }

    public function getview($id){
      $query  = "SELECT *
                 FROM rabview as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_array($result);
      return $data;
    }

    public function getview2($id){
      $query  = "SELECT *
                 FROM rabview as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;
    }

    public function getrabfull($id){
      $query  = "SELECT *
                 FROM rabfull as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;
    }

    public function gettemprab($id){
      $query  = "SELECT *
                 FROM temprabfull as r where rabview_id = '$id'";
      $result = $this->query($query);
      $x=0;
      while ($fetch = $this->fetch_object($result)) {
        $data[$x] = $fetch;
        $x++;
      }
      return $data;
    }

    public function save_penerima($id_rab_view,$getview, $post){
      // print_r($post);die;
      $thang      = $getview['thang'];
      $kdprogram  = $getview['kdprogram'];
      $kdgiat     = trim($getview['kdgiat'],"\x0D\x0A");
      $kdoutput   = trim($getview['kdoutput'],"\x0D\x0A");
      $kdsoutput  = trim($getview['kdsoutput'],"\x0D\x0A");
      $kdkmpnen   = trim($getview['kdkmpnen'],"\x0D\x0A");
      $kdskmpnen  = $getview['kdskmpnen'];
      $deskripsi  = $getview['deskripsi'];
      $tanggal    = $getview['tanggal'];
      $tanggal_akhir = $getview['tanggal_akhir'];
      $lokasi     = $getview['lokasi'];
      $tempat     = $getview['tempat'];

      $jenis = $post['jenis-akun'];
      $penerima = $post['penerima'];
      $npwp = $post['npwp'];
      $nip = $post['nip'];
      $jabatan = $post['jabatan'];
      if ($jabatan == "Lain") {
        $jabatan = $post['jabatan_lain'];
      }
      $golongan = $post['golongan'];
      $pns = $post['pns'];
      $pajak_input = $post['pajak'];

      $status = $post['adendum'];

      if($jenis==1){
        if ($pns == 1) {
          if ($golongan == 4) {
            $pajak = '15';
          }elseif ($golongan == 3) {
            $pajak = '5';
          }elseif ($golongan == 2) {
            if ($pns == 1) {
              $pajak = '0';
            }else{
              if ($npwp != "") {
                $pajak = '5';
              }else{
                $pajak = '6';
              }
            }
          }else{
            $pajak = '0';
          }
        }else{
         $pajak = '6';
        }
      } else if($jenis == 0){
        $pajak = $pajak_input;

      }
      $query      = "INSERT INTO rabfull SET
        rabview_id  = '$id_rab_view',
        thang       = '$thang',
        kdprogram   = '$kdprogram',
        kdgiat      = '$kdgiat',
        kdoutput    = '$kdoutput',
        kdsoutput   = '$kdsoutput',
        kdkmpnen    = '$kdkmpnen',
        kdskmpnen   = '$kdskmpnen',
        deskripsi   = '$deskripsi',
        tanggal     = '$tanggal',
        tanggal_akhir = '$tanggal_akhir',
        lokasi      = '$lokasi',
        tempat      = '$tempat',

        jenis       = '$jenis',
        penerima    = '$penerima',
        npwp        = '$npwp',
        nip        = '$nip',
        jabatan     = '$jabatan',
        golongan    = '$golongan',
        pns         = '$pns',
        pajak       = '$pajak',

        status       = '$status'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function save_edit_penerima($id_rab_view,$getview, $post, $getrab){
      // print_r($post);die;
      $thang      = $getview['thang'];
      $kdprogram  = $getview['kdprogram'];
      $kdgiat     = trim($getview['kdgiat'],"\x0D\x0A");
      $kdoutput   = trim($getview['kdoutput'],"\x0D\x0A");
      $kdsoutput  = trim($getview['kdsoutput'],"\x0D\x0A");
      $kdkmpnen   = trim($getview['kdkmpnen'],"\x0D\x0A");
      $kdskmpnen  = $getview['kdskmpnen'];

      $jenis = $post['jenis-akun'];
      $penerima = $post['penerima'];
      $npwp = $post['npwp'];
      $nip = $post['nip'];
      $jabatan = $post['jabatan'];
      if ($jabatan == "Lain") {
        $jabatan = $post['jabatan_lain'];
      }
      $golongan = $post['golongan'];
      $pns = $post['pns'];
      $pajak_input = $post['pajak'];

      if($jenis==1){
        if ($pns == 1) {
          if ($golongan == 4) {
            $pajak = '15';
          }elseif ($golongan == 3) {
            $pajak = '5';
          }elseif ($golongan == 2) {
            if ($pns == 1) {
              $pajak = '0';
            }else{
              if ($npwp != "") {
                $pajak = '5';
              }else{
                $pajak = '6';
              }
            }
          }else{
            $pajak = '0';
          }
        }else{
         $pajak = '6';
        }
      } else if($jenis == 0){
        $pajak = $pajak_input;
      }

      $query      = "UPDATE rabfull SET
        jenis       = '$jenis',
        penerima    = '$penerima',
        npwp        = '$npwp',
        nip         = '$nip',
        jabatan     = '$jabatan',
        golongan    = '$golongan',
        pns         = '$pns',
        pajak       = '$pajak'

        WHERE
        rabview_id  = '$id_rab_view' AND
        thang       = '$thang' AND
        kdprogram   = '$kdprogram' AND
        kdgiat      = '$kdgiat' AND
        kdoutput    = '$kdoutput' AND
        kdsoutput   = '$kdsoutput' AND
        kdkmpnen    = '$kdkmpnen' AND
        kdskmpnen   = '$kdskmpnen' AND

        penerima    = '$getrab->penerima' AND
        npwp        = '$getrab->npwp' AND
        jenis       = '$getrab->jenis' AND
        golongan    = '$getrab->golongan'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function tambahAkun($data){
      $id_rabfull = $data['id_rabfull'];
      $cek  = "SELECT * FROM rabfull where id='$id_rabfull'";
      $cekresult = $this->query($cek);
      $cekfetch  = $this->fetch_object($cekresult);
      // print_r($cekfetch);die;
      // echo $cekfetch->kdakun; exit;
      if ($cekfetch->kdakun !="") {
        $rabview_id = $cekfetch->rabview_id;
        $thang      = $cekfetch->thang;
        $kdprogram  = $cekfetch->kdprogram;
        $kdgiat     = trim($cekfetch->kdgiat,"\x0D\x0A");
        $kdoutput   = trim($cekfetch->kdoutput,"\x0D\x0A");
        $kdsoutput  = trim($cekfetch->kdsoutput,"\x0D\x0A");
        $kdkmpnen   = trim($cekfetch->kdkmpnen,"\x0D\x0A");
        $kdskmpnen  = $cekfetch->kdskmpnen;

        $kdakun     = $data['kdakun'];
        $noitem     = $data['noitem'];
        $value      = str_replace(".", "", $data['value']);

        $deskripsi  = $cekfetch->deskripsi;
        $tanggal    = $cekfetch->tanggal;
        $lokasi     = $cekfetch->lokasi;

        $jenis      = $cekfetch->jenis;
        $penerima   = $cekfetch->penerima;
        $npwp       = $cekfetch->npwp;
        $nip       = $cekfetch->nip;
        $pajak      = $cekfetch->pajak;
        $golongan   = $cekfetch->golongan;
        $jabatan    = $cekfetch->jabatan;
        $pns        = $cekfetch->pns;
        $pajak      = $cekfetch->pajak;
        $status      = $cekfetch->status;

        $pph        = ($pajak/100) * $value; 

        if (!empty($data['ppn'])) {
          $ppn = $data['ppn'];
        }else{
          $ppn = null;
        }

        $query      = "INSERT INTO rabfull SET
          rabview_id  = '$rabview_id',
          thang       = '$thang',
          kdprogram   = '$kdprogram',
          kdgiat      = '$kdgiat',
          kdoutput    = '$kdoutput',
          kdsoutput   = '$kdsoutput',
          kdkmpnen    = '$kdkmpnen',
          kdskmpnen   = '$kdskmpnen',
          kdakun      = '$kdakun',
          noitem      = '$noitem',
          value       = '$value',
          status       = '$status',

          deskripsi   = '$deskripsi',
          tanggal     = '$tanggal',
          lokasi      = '$lokasi',

          jenis       = '$jenis',
          penerima    = '$penerima',
          npwp        = '$npwp',
          nip        = '$nip',
          golongan    = '$golongan',
          jabatan     = '$jabatan',
          pns         = '$pns',

          pajak       = '$pajak',
          ppn         = '$ppn',
          pph         = '$pph'
        ";
        $result = $this->query($query);
        return $result;
      }else{
        $kdakun     = $data['kdakun'];
        $noitem     = $data['noitem'];
        $value      = str_replace(".", "", $data['value']);

        $pajak      = $cekfetch->pajak;
        $pph        = ($pajak/100) * $value; 
        if (!empty($data['ppn'])) {
          $ppn = $data['ppn'];
        }else{
          $ppn = null;
        }

        $query = "UPDATE rabfull SET 
                    kdakun  ='$kdakun', 
                    noitem  ='$noitem', 
                    value   ='$value',

                    pph     = '$pph',
                    ppn     = '$ppn'
                  where id='$id_rabfull'";
        $result = $this->query($query);
        return $result;
      }
    }

    public function editAkun($data){
      $id_rabfull = $data['id_rabfull'];
      $cek  = "SELECT * FROM rabfull where id='$id_rabfull'";
      $cekresult = $this->query($cek);
      $cekfetch  = $this->fetch_object($cekresult);

      $kdakun     = $data['kdakun'];
      $noitem     = $data['noitem'];
      $value      = str_replace(".", "", $data['value']);

      $pajak      = $cekfetch->pajak;
      $pph        = ($pajak/100) * $value; 
      
      if (!empty($data['ppn'])) {
        $ppn = $data['ppn'];
      }else{
        $ppn = null;
      }

      $query = "UPDATE rabfull SET 
                  kdakun  ='$kdakun', 
                  noitem  ='$noitem', 
                  value   ='$value',

                  pph     = '$pph',
                  ppn     = '$ppn'
                where id='$id_rabfull'";
      $result = $this->query($query);
      return $result;
    }

    public function tambahAkunPerjalanan($data){
      $id_rabfull = $data['id_rabfull'];
      $cek  = "SELECT * FROM rabfull where id='$id_rabfull'";
      $cekresult = $this->query($cek);
      $cekfetch  = $this->fetch_object($cekresult);

      $thang      = $cekfetch->thang;
      $kdprogram  = $cekfetch->kdprogram;
      $kdgiat     = trim($cekfetch->kdgiat,"\x0D\x0A");
      $kdoutput   = trim($cekfetch->kdoutput,"\x0D\x0A");
      $kdsoutput  = trim($cekfetch->kdsoutput,"\x0D\x0A");
      $kdkmpnen   = trim($cekfetch->kdkmpnen,"\x0D\x0A");
      $kdskmpnen  = $cekfetch->kdskmpnen;

      $kdakun     = $data['kdakun'];
      $noitem     = $data['noitem'];

      $deskripsi  = $cekfetch->deskripsi;
      $tanggal    = $cekfetch->tanggal;
      $lokasi     = $cekfetch->lokasi;

      $jenis      = $cekfetch->jenis;
      $penerima   = $cekfetch->penerima;
      $npwp       = $cekfetch->npwp;
      $golongan   = $cekfetch->golongan;
      $jabatan    = $cekfetch->jabatan;
      $pns        = $cekfetch->pns;
      $pajak      = $cekfetch->pajak;

      if ($cekfetch->kdakun !="") {
        $rabview_id = $cekfetch->rabview_id;
        $pph        = ($pajak/100) * $value; 

        $query      = "INSERT INTO rabfull SET
          rabview_id  = '$rabview_id',
          thang       = '$thang',
          kdprogram   = '$kdprogram',
          kdgiat      = '$kdgiat',
          kdoutput    = '$kdoutput',
          kdsoutput   = '$kdsoutput',
          kdkmpnen    = '$kdkmpnen',
          kdskmpnen   = '$kdskmpnen',
          kdakun      = '$kdakun',
          noitem      = '$noitem',

          jenis       = '$jenis',
          penerima    = '$penerima',
          npwp        = '$npwp',
          golongan    = '$golongan',
          jabatan     = '$jabatan',
          pns         = '$pns',
          pajak       = '$pajak'
        ";
        $result = $this->query($query);

        $id_rabfull = $this->insert_id($result); 
        $sub_query = "";
        $value_total = 0;
        $countperjalanan = 1;
        for ($i=0; $i < $countperjalanan; $i++) { 
          // $tgl_mulai    = date('Y-m-d', strtotime(str_replace('-', '/', )));
          // $tgl_akhir    = date('Y-m-d', strtotime(str_replace('-', '/', $data['tgl_akhir'][$i])));
          $pecah1 = explode("/", $data['tgl_mulai'][$i]);
          $tgl_mulai = $pecah1[2].'-'.$pecah1[1].'-'.$pecah1[0];
          $pecah2 = explode("/", $data['tgl_akhir'][$i]);
          $tgl_akhir = $pecah2[2].'-'.$pecah2[1].'-'.$pecah2[0];

          $alat_trans   = $data['alat_trans'][$i];
          $kota_asal    = $data['kota_asal'][$i];
          $kota_tujuan  = $data['kota_tujuan'][$i];
          $taxi_asal    = str_replace(".", "", $data['taxi_asal'][$i]);
          $taxi_tujuan  = str_replace(".", "", $data['taxi_tujuan'][$i]);
          $rute         = $data['rute'][$i];
          $harga_tiket  = str_replace(".", "", $data['harga_tiket'][$i]);
          $uang_harian  = str_replace(".", "", $data['uang_harian'][$i]);
          $lama_hari    = $data['lama_hari'][$i];

          $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari);
          $pph        = ($pajak/100) * $value_total; 

          $sub_query = "tgl_mulai   = '$tgl_mulai',
                        tgl_akhir   = '$tgl_akhir',
                        alat_trans  = '$alat_trans',
                        kota_asal   = '$kota_asal',
                        kota_tujuan = '$kota_tujuan',
                        taxi_asal   = '$taxi_asal',
                        taxi_tujuan = '$taxi_tujuan',
                        rute        = '$rute',
                        harga_tiket = '$harga_tiket',
                        uang_harian = '$uang_harian',
                        lama_hari   = '$lama_hari'
                        ";

          $queryjalan   = "UPDATE rabfull SET 

            pajak       = '$pajak',
            pph         = '$pph',
            value         = '$value_total',
            ".$sub_query."
            where id = '$id_rabfull'";
          $resultjalan = $this->query($queryjalan);
        }
        return $resultjalan;
      }else{
        $sub_query = "";
        $value_total = 0;
        $countperjalanan = 1;
        for ($i=0; $i < $countperjalanan; $i++) { 
          $pecah1 = explode("/", $data['tgl_mulai'][$i]);
          $tgl_mulai = $pecah1[2].'-'.$pecah1[1].'-'.$pecah1[0];
          $pecah2 = explode("/", $data['tgl_akhir'][$i]);
          $tgl_akhir = $pecah2[2].'-'.$pecah2[1].'-'.$pecah2[0];

          $alat_trans   = $data['alat_trans'][$i];
          $kota_asal    = $data['kota_asal'][$i];
          $kota_tujuan  = $data['kota_tujuan'][$i];
          $taxi_asal    = str_replace(".", "", $data['taxi_asal'][$i]);
          $taxi_tujuan  = str_replace(".", "", $data['taxi_tujuan'][$i]);
          $rute         = $data['rute'][$i];
          $harga_tiket  = str_replace(".", "", $data['harga_tiket'][$i]);
          $uang_harian  = str_replace(".", "", $data['uang_harian'][$i]);
          $lama_hari    = $data['lama_hari'][$i];

          $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari);
          $pph        = ($pajak/100) * $value_total; 

          $sub_query = "tgl_mulai   = '$tgl_mulai',
                        tgl_akhir   = '$tgl_akhir',
                        alat_trans  = '$alat_trans',
                        kota_asal   = '$kota_asal',
                        kota_tujuan = '$kota_tujuan',
                        taxi_asal   = '$taxi_asal',
                        taxi_tujuan = '$taxi_tujuan',
                        rute        = '$rute',
                        harga_tiket = '$harga_tiket',
                        uang_harian = '$uang_harian',
                        lama_hari   = '$lama_hari'
                        ";

          $queryjalan   = "UPDATE rabfull SET 
            kdakun       = '$kdakun',
            noitem       = '$noitem',
            pajak       = '$pajak',
            pph         = '$pph',
            value         = '$value_total',
            ".$sub_query."
            where id = '$id_rabfull'";
          $resultjalan = $this->query($queryjalan);
        }
        return $resultjalan;
      }
    }

    public function editAkunPerjalanan($data){
      $id_rabfull = $data['id_rabfull'];
      $cek  = "SELECT * FROM rabfull where id='$id_rabfull'";
      $cekresult = $this->query($cek);
      $cekfetch  = $this->fetch_object($cekresult);

      $thang      = $cekfetch->thang;
      $kdprogram  = $cekfetch->kdprogram;
      $kdgiat     = trim($cekfetch->kdgiat,"\x0D\x0A");
      $kdoutput   = trim($cekfetch->kdoutput,"\x0D\x0A");
      $kdsoutput  = trim($cekfetch->kdsoutput,"\x0D\x0A");
      $kdkmpnen   = trim($cekfetch->kdkmpnen,"\x0D\x0A");
      $kdskmpnen  = $cekfetch->kdskmpnen;

      $kdakun     = $data['kdakun'];
      $noitem     = $data['noitem'];

      $jenis      = $cekfetch->jenis;
      $penerima   = $cekfetch->penerima;
      $npwp       = $cekfetch->npwp;
      $golongan   = $cekfetch->golongan;
      $jabatan    = $cekfetch->jabatan;
      $pns        = $cekfetch->pns;
      $pajak      = $cekfetch->pajak;
        
      $sub_query = "";
      $value_total = 0;
      $countperjalanan = 1;
      for ($i=0; $i < $countperjalanan; $i++) { 
        // $tgl_mulai    = date('Y-m-d', strtotime(str_replace('-', '/', $data['tgl_mulai'][$i])));
        // $tgl_akhir    = date('Y-m-d', strtotime(str_replace('-', '/', $data['tgl_akhir'][$i])));
        $pecah1 = explode("/", $data['tgl_mulai'][$i]);
        $tgl_mulai = $pecah1[2].'-'.$pecah1[1].'-'.$pecah1[0];
        $pecah2 = explode("/", $data['tgl_akhir'][$i]);
        $tgl_akhir = $pecah2[2].'-'.$pecah2[1].'-'.$pecah2[0];
        $alat_trans   = $data['alat_trans'][$i];
        $kota_asal    = $data['kota_asal'][$i];
        $kota_tujuan  = $data['kota_tujuan'][$i];
        $taxi_asal    = str_replace(".", "", $data['taxi_asal'][$i]);
        $taxi_tujuan  = str_replace(".", "", $data['taxi_tujuan'][$i]);
        $rute         = $data['rute'][$i];
        $harga_tiket  = str_replace(".", "", $data['harga_tiket'][$i]);
        $uang_harian  = str_replace(".", "", $data['uang_harian'][$i]);
        $lama_hari    = $data['lama_hari'][$i];


        $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari);
        $pph          = ($pajak/100) * $value_total; 

        $sub_query = "tgl_mulai   = '$tgl_mulai',
                      tgl_akhir   = '$tgl_akhir',
                      alat_trans  = '$alat_trans',
                      kota_asal   = '$kota_asal',
                      kota_tujuan = '$kota_tujuan',
                      taxi_asal   = '$taxi_asal',
                      taxi_tujuan = '$taxi_tujuan',
                      rute        = '$rute',
                      harga_tiket = '$harga_tiket',
                      uang_harian = '$uang_harian',
                      lama_hari   = '$lama_hari'
                      ";

      }

      $pajak      = $cekfetch->pajak;
      $pph        = ($pajak/100) * $value_total; 

      if (!empty($data['ppn'])) {
        $ppn = $data['ppn'];
      }else{
        $ppn = null;
      }

      $query = "UPDATE rabfull SET 
                  kdakun  ='$kdakun', 
                  noitem  ='$noitem', 
                  value   ='$value_total',
                  pph     = '$pph',
                  ppn     = '$ppn',
                  ".$sub_query."
                where id='$id_rabfull'";
      $result = $this->query($query);
      return $result;
      
    }

    public function updateView($id){
      $query  = "SELECT status FROM rabfull as r where rabview_id = '$id' and status != '4'";
      $result = $this->query($query);
      $data  = $this->fetch_array($result);

      if (empty($data)) {
        $query2 = "UPDATE rabview SET status='4' WHERE id = '$id'";
        $result2 = $this->query($query2);
      }
      return $data;
    }

    public function getrkaklfull($data){
      $thang      = $data['thang'];
      $kdprogram  = $data['kdprogram'];
      $kdgiat     = $data['kdgiat'];
      $kdoutput   = $data['kdoutput'];
      $kdsoutput  = $data['kdsoutput'];
      $kdkmpnen   = $data['kdkmpnen'];
      $kdskmpnen  = $data['kdskmpnen'];

      $query  = "SELECT * FROM rkakl_full
                            WHERE THANG='$thang'
                            AND KDPROGRAM='$kdprogram'
                            AND KDGIAT='$kdgiat'
                            AND KDOUTPUT='$kdoutput'
                            AND KDSOUTPUT='$kdsoutput'
                            AND KDKMPNEN='$kdkmpnen'
                            AND KDSKMPNEN='$kdskmpnen'
                            LIMIT 1";
      $result    = $this->query($query);
      while ($rkakl = $this->fetch_object($result)) {
        $all[] = $rkakl;
      }
      return $all;
    }

    public function getrkaklfull2($data){
      $thang      = $data->thang;
      $kdprogram  = $data->kdprogram;
      $kdgiat     = $data->kdgiat;
      $kdoutput   = $data->kdoutput;
      $kdsoutput  = $data->kdsoutput;
      $kdkmpnen   = $data->kdkmpnen;
      $kdskmpnen  = $data->kdskmpnen;
      if ($data->kdakun != "") {
        $kdakun  = $data->kdakun;
        $noitem  = $data->noitem;
        $query  = "SELECT * FROM rkakl_full
                            WHERE THANG   ='$thang'
                            AND KDPROGRAM ='$kdprogram'
                            AND KDGIAT    ='$kdgiat'
                            AND KDOUTPUT  ='$kdoutput'
                            AND KDSOUTPUT ='$kdsoutput'
                            AND KDKMPNEN  ='$kdkmpnen'
                            AND KDSKMPNEN ='$kdskmpnen'
                            AND KDAKUN    ='$kdakun'
                            AND NOITEM    ='$noitem'
                            LIMIT 1";
      }else{
        $query  = "SELECT * FROM rkakl_full
                            WHERE THANG   ='$thang'
                            AND KDPROGRAM ='$kdprogram'
                            AND KDGIAT    ='$kdgiat'
                            AND KDOUTPUT  ='$kdoutput'
                            AND KDSOUTPUT ='$kdsoutput'
                            AND KDKMPNEN  ='$kdkmpnen'
                            AND KDSKMPNEN ='$kdskmpnen'
                            LIMIT 1";
      }
      $result    = $this->query($query);
      while ($rkakl = $this->fetch_object($result)) {
        $all[] = $rkakl;
      }
      return $all;
    }

    public function hitung_dipa($data,$kdakun){
      $q_out = $q_sout = $q_kmp = $q_skmp = $q_akun  = "";

      $thang      = $data->thang;
      $kdprogram  = $data->kdprogram;
      $kdgiat     = $data->kdgiat;
      $kdout   = $data->kdoutput;
      $kdsout  = $data->kdsoutput;
      $kdkmp   = $data->kdkmpnen;
      $kdskmp  = $data->kdskmpnen;
     

      // if($kdout!=""){ 
        $q_out = " and kdoutput='$kdout' "; 
        $k_out = " ,kdoutput "; 
      // }
      // if($kdsout!=""){ 
        $q_sout = " and kdsoutput='$kdsout' "; 
        $k_sout = " ,kdsoutput"; 
      // }
      // if($kdkmp!=""){ 
        $q_kmp = " and kdkmpnen='$kdkmp' ";  
        $k_kmp = " ,kdkmpnen "; 
      // }
      // if($kdskmp!=""){ 
        $q_skmp = " and kdskmpnen='$kdskmp' "; 
        $k_skmp = " ,kdskmpnen "; 
      // }
      if($kdakun!=""){ 
        $q_akun = " and kdakun='$kdakun' "; 
        $k_skmp = " ,kdakun ";
        }  
      // }
      $query = " SELECT SUM(JUMLAH) as jumlah FROM rkakl_full WHERE kdgiat ='$kdgiat' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun;
      // print($query);
      
      $res_pagu = $this->query($query);
      $data_pagu = $this->fetch_array($res_pagu);

      // $query = " SELECT SUM(case when month(tanggal)<'$tanggal' then value else 0 end) as jml_lalu, SUM(case when month(tanggal)='$tanggal' then value else 0 end) as jumlah FROM rabfull WHERE kdgiat = '$kdgiat' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun.' and status in (2,4,6,7)';
      $query = " SELECT SUM(value) as realisasi, SUM(case when status in(0,1,3,5) then value else 0 end) as usulan FROM rabfull WHERE kdgiat = '$kdgiat' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun;
      // print($query);
      $res = $this->query($query);
      $data_rab = $this->fetch_array($res);

      $sisa = $data_pagu['jumlah'] - $data_rab['realisasi'];
   
   
      
     $arr_data = array(
              "pagu" => number_format($data_pagu['jumlah'],"2",",","."),
              "kdakun" => $kdakun,
              "realisasi" => number_format($data_rab['realisasi'],"2",",","."),
              "sisa" => number_format($sisa,"2",",","."),
              "usulan" => number_format($data_rab['usulan'],"2",",",".")
              );
      echo json_encode($arr_data);
      return $arr_data;
    

    }

    public function delrabdetail($id_rabfull){

      $query = "DELETE FROM rabfull WHERE id = '$id_rabfull'";
      $result = $this->query($query);
      return $result;
    }

    public function delrabakun($id_rabfull){

      $query = "UPDATE rabfull SET kdakun = null, 
                                    noitem = null, 
                                    ppn= null,  
                                    value= null,  
                                    no_kuitansi= null,  
                                    tgl_mulai   = null,
                                    tgl_akhir   = null,
                                    alat_trans  = null,
                                    kota_asal   = null,
                                    kota_tujuan = null,
                                    taxi_asal   = null,
                                    taxi_tujuan = null,
                                    rute        = null,
                                    harga_tiket = null,
                                    uang_harian = null,
                                    lama_hari   = null
                              WHERE id = '$id_rabfull'";
      $result = $this->query($query);
      return $result;
    }

    public function getminrabid($data){
      $query = "SELECT MIN(id) as id, count(id) as banyak FROM rabfull where rabview_id    = '$data->rabview_id'
                                                    AND penerima      = '$data->penerima'
                                                    AND npwp          = '$data->npwp'
                                                    AND jenis         = '$data->jenis'
                                                  ";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;    
    }

    public function pesanrevisi($id, $pesan){
      $query = "UPDATE rabview set pesan = '$pesan' where id ='$id' ";
      $result = $this->query($query);
      return $result;
    }

    public function importRab($array, $data){
      $timestamp = date("Y-m-d H:i:s");
      $getview = $this->getview2($array['id_rab_view']);
      $arrayCount = count($data);
      $x = 0;$error = 'false';
      $jumhonor = 0;$jumprofesi = 0;$jumsaku = 0;$jumperjalanan=0;$jumharian=0;
      for ($i=20; $i < $arrayCount; $i++) { 
        if ($data[$i]["B"] == "") {
          break;
        }
        $penerima       = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $npwp           = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $pajak          = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $golongan       = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $jabatan        = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $belanja        = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $honor_output   = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $honor_profesi  = trim($data[$i]["I"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $uang_saku      = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $trans_lokal    = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $uang_harian    = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tiket          = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tgl_mulai      = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tgl_akhir      = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tingkat        = trim($data[$i]["P"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $alat_trans     = trim($data[$i]["Q"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $kota_asal      = trim($data[$i]["R"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $kota_tujuan    = trim($data[$i]["S"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $taxi_asal      = trim($data[$i]["T"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $taxi_tujuan    = trim($data[$i]["U"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $airport_tax    = trim($data[$i]["V"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute1          = trim($data[$i]["W"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute2          = trim($data[$i]["X"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute3          = trim($data[$i]["Y"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute4          = trim($data[$i]["Z"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $harga_tiket    = trim($data[$i]["AA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $lama_hari      = trim($data[$i]["AB"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $klmpk_hr       = trim($data[$i]["AC"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $pns            = trim($data[$i]["AD"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $malam          = trim($data[$i]["AE"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $akom           = trim($data[$i]["AF"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        
        if ($pns == 'PNS') {
          $pns = '1';
        }else{
          $pns = '0';
        }
        if ($golongan == 'I') {
          $golongan = '1';
        }elseif ($golongan == 'II') {
          $golongan = '2';
        }elseif ($golongan == 'III') {
          $golongan = '3';
        }elseif ($golongan == 'IV') {
          $golongan = '4';
        }

        if($jenis==1){
          if ($pns == 1) {
            if ($golongan == "4") {
              $pajak = '15';
            }elseif ($golongan == "3") {
              $pajak = '5';
            }elseif ($golongan == "2") {
              if ($pns == 1) {
                $pajak = '0';
              }else{
                if ($npwp != "") {
                  $pajak = '5';
                }else{
                  $pajak = '6';
                }
              }
            }else{
              $pajak = '0';
            }
          }else{
           $pajak = '6';
          }
        } 

        if($array['status'] == ""){
          $stat = 0;
        }else{
          $stat = $array['status'];
        }

        $dataorang = array('rabview_id'   => $array['id_rab_view'],
                            'thang'       => $getview->thang,
                            'kdprogram'   => $getview->kdprogram,
                            'kdgiat'      => $getview->kdgiat,
                            'kdoutput'    => $getview->kdoutput,
                            'kdsoutput'   => $getview->kdsoutput,
                            'kdkmpnen'    => $getview->kdkmpnen,
                            'kdskmpnen'   => $getview->kdskmpnen,
                            'noitem'      => '1',
                            'deskripsi'   => $getview->deskripsi,
                            'tanggal'     => $getview->tanggal,
                            'lokasi'      => $getview->lokasi,

                            'jenis'       => $array['jenis'],
                            'penerima'    => $penerima, 
                            'npwp'        => $npwp,
                            'pajak'       => $pajak,
                            'golongan'    => $golongan,
                            'jabatan'     => $jabatan,
                            'pns'         => $pns,
                            'status'      => $stat,
                            'created_by'  => $_SESSION['id'],
                            'created_at'  => $timestamp
                            );
        
        if ($honor_output  != "") {
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = '521213';
          $insert[$x]['value'] = $honor_output;
          $jumrkakl = $this->getJumRkakl2($getview, '521213');
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl->jumlah + $jumrkakl->realisasi + $jumrkakl->usulan + $jumhonor;
            if ($pagu >= $honor_output) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $jumhonor += $honor_output;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          echo "1";
          $query      = "INSERT INTO temprabfull SET
              rabview_id  = '".$insert[$x]['rabview_id']."',
              thang       = '".$insert[$x]['thang']."',
              kdprogram   = '".$insert[$x]['kdprogram']."',
              kdgiat      = '".$insert[$x]['kdgiat']."',
              kdoutput    = '".$insert[$x]['kdoutput']."',
              kdsoutput   = '".$insert[$x]['kdsoutput']."',
              kdkmpnen    = '".$insert[$x]['kdkmpnen']."',
              kdskmpnen   = '".$insert[$x]['kdskmpnen']."',
              kdakun      = '".$insert[$x]['kdakun']."',
              noitem      = '".$insert[$x]['noitem']."',
              value       = '".$insert[$x]['value']."',
              status       = '".$insert[$x]['status']."',

              deskripsi   = '".$insert[$x]['deskripsi']."',
              tanggal     = '".$insert[$x]['tanggal']."',
              lokasi      = '".$insert[$x]['lokasi']."',

              jenis       = '".$insert[$x]['jenis']."',
              penerima    = '".$insert[$x]['penerima']."',
              npwp        = '".$insert[$x]['npwp']."',
              golongan    = '".$insert[$x]['golongan']."',
              jabatan     = '".$insert[$x]['jabatan']."',
              pns         = '".$insert[$x]['pns']."',

              pajak       = '".$insert[$x]['pajak']."'
          ";
          $result = $this->query($query);
        }

        if ($honor_profesi != "") {
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = '522151';
          $insert[$x]['value'] = $honor_profesi;
          $jumrkakl = $this->getJumRkakl2($getview, '522151');
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl->jumlah + $jumrkakl->realisasi + $jumrkakl->usulan + $jumprofesi;
            if ($pagu >= $honor_profesi) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $jumprofesi += $honor_profesi;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $query      = "INSERT INTO temprabfull SET
              rabview_id  = '".$insert[$x]['rabview_id']."',
              thang       = '".$insert[$x]['thang']."',
              kdprogram   = '".$insert[$x]['kdprogram']."',
              kdgiat      = '".$insert[$x]['kdgiat']."',
              kdoutput    = '".$insert[$x]['kdoutput']."',
              kdsoutput   = '".$insert[$x]['kdsoutput']."',
              kdkmpnen    = '".$insert[$x]['kdkmpnen']."',
              kdskmpnen   = '".$insert[$x]['kdskmpnen']."',
              kdakun      = '".$insert[$x]['kdakun']."',
              noitem      = '".$insert[$x]['noitem']."',
              value       = '".$insert[$x]['value']."',
              status       = '".$insert[$x]['status']."',

              deskripsi   = '".$insert[$x]['deskripsi']."',
              tanggal     = '".$insert[$x]['tanggal']."',
              lokasi      = '".$insert[$x]['lokasi']."',

              jenis       = '".$insert[$x]['jenis']."',
              penerima    = '".$insert[$x]['penerima']."',
              npwp        = '".$insert[$x]['npwp']."',
              golongan    = '".$insert[$x]['golongan']."',
              jabatan     = '".$insert[$x]['jabatan']."',
              pns         = '".$insert[$x]['pns']."',

              pajak       = '".$insert[$x]['pajak']."'
          ";
          $result = $this->query($query);
        }

        if ($uang_saku != "") {
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = '524114';
          $insert[$x]['value'] = $uang_saku;
          $jumrkakl = $this->getJumRkakl2($getview, '524114');
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl->jumlah + $jumrkakl->realisasi + $jumrkakl->usulan + $jumsaku;
            if ($pagu >= $uang_saku) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $jumsaku += $uang_saku;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $query      = "INSERT INTO temprabfull SET
              rabview_id  = '".$insert[$x]['rabview_id']."',
              thang       = '".$insert[$x]['thang']."',
              kdprogram   = '".$insert[$x]['kdprogram']."',
              kdgiat      = '".$insert[$x]['kdgiat']."',
              kdoutput    = '".$insert[$x]['kdoutput']."',
              kdsoutput   = '".$insert[$x]['kdsoutput']."',
              kdkmpnen    = '".$insert[$x]['kdkmpnen']."',
              kdskmpnen   = '".$insert[$x]['kdskmpnen']."',
              kdakun      = '".$insert[$x]['kdakun']."',
              noitem      = '".$insert[$x]['noitem']."',
              value       = '".$insert[$x]['value']."',
              status       = '".$insert[$x]['status']."',

              deskripsi   = '".$insert[$x]['deskripsi']."',
              tanggal     = '".$insert[$x]['tanggal']."',
              lokasi      = '".$insert[$x]['lokasi']."',

              jenis       = '".$insert[$x]['jenis']."',
              penerima    = '".$insert[$x]['penerima']."',
              npwp        = '".$insert[$x]['npwp']."',
              golongan    = '".$insert[$x]['golongan']."',
              jabatan     = '".$insert[$x]['jabatan']."',
              pns         = '".$insert[$x]['pns']."',

              pajak       = '".$insert[$x]['pajak']."'
          ";
          $result = $this->query($query);
        }

        if ($rute1 == "") {  #524119
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = $kdakun;

          $insert[$x]['uang_harian'] = $uang_harian;
          $insert[$x]['lama_hari'] = $lama_hari;
          $insert[$x]['tiket'] = $tiket;
          $insert[$x]['taxi_asal'] = $taxi_asal;
          $insert[$x]['taxi_tujuan'] = $taxi_tujuan;
          $insert[$x]['kota_asal'] = $kota_asal;
          $insert[$x]['kota_tujuan'] = $kota_tujuan;
          $insert[$x]['tgl_mulai'] = $tgl_mulai;
          $insert[$x]['tgl_akhir'] = $tgl_akhir;
          $jumrab = $tiket + $taxi_asal + $taxi_tujuan + ($uang_harian * $lama_hari);
          $insert[$x]['value'] = $jumrab;

          $jumrkakl = $this->getJumRkakl2($getview, $kdakun);
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl->jumlah + $jumrkakl->realisasi + $jumrkakl->usulan + $jumperjalanan;
            if ($pagu >= $jumrab) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $jumperjalanan += $jumrab;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $sub_query = "tgl_mulai   = ''".$insert[$x]['tgl_mulai']."',
                      tgl_akhir   = ''".$insert[$x]['tgl_akhir']."',
                      alat_trans  = ''".$insert[$x]['alat_trans']."',
                      kota_asal   = ''".$insert[$x]['kota_asal']."',
                      kota_tujuan = ''".$insert[$x]['kota_tujuan']."'
                      taxi_asal   = ''".$insert[$x]['taxi_asal']."',
                      taxi_tujuan = ''".$insert[$x]['taxi_tujuan']."',
                      rute        = ''".$insert[$x]['rute']."',
                      harga_tiket = ''".$insert[$x]['harga_tiket']."',
                      uang_harian = ''".$insert[$x]['uang_harian']."',
                      lama_hari   = ''".$insert[$x]['lama_hari']."'
                      ";
          $query      = "INSERT INTO temprabfull SET
              rabview_id  = '".$insert[$x]['rabview_id']."',
              thang       = '".$insert[$x]['thang']."',
              kdprogram   = '".$insert[$x]['kdprogram']."',
              kdgiat      = '".$insert[$x]['kdgiat']."',
              kdoutput    = '".$insert[$x]['kdoutput']."',
              kdsoutput   = '".$insert[$x]['kdsoutput']."',
              kdkmpnen    = '".$insert[$x]['kdkmpnen']."',
              kdskmpnen   = '".$insert[$x]['kdskmpnen']."',
              kdakun      = '".$insert[$x]['kdakun']."',
              noitem      = '".$insert[$x]['noitem']."',
              value       = '".$insert[$x]['value']."',
              status       = '".$insert[$x]['status']."',

              deskripsi   = '".$insert[$x]['deskripsi']."',
              tanggal     = '".$insert[$x]['tanggal']."',
              lokasi      = '".$insert[$x]['lokasi']."',

              jenis       = '".$insert[$x]['jenis']."',
              penerima    = '".$insert[$x]['penerima']."',
              npwp        = '".$insert[$x]['npwp']."',
              golongan    = '".$insert[$x]['golongan']."',
              jabatan     = '".$insert[$x]['jabatan']."',
              pns         = '".$insert[$x]['pns']."',

              pajak       = '".$insert[$x]['pajak']."',
              ".$sub_query."
          ";
          $result = $this->query($query);
        }else{
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = '524114';
          $insert[$x]['value'] = $uang_saku;
          $jumrkakl = $this->getJumRkakl2($getview, '524114');
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl->jumlah + $jumrkakl->realisasi + $jumrkakl->usulan + $jumsaku;
            if ($pagu >= $uang_saku) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $jumsaku += $uang_saku;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $query      = "INSERT INTO temprabfull SET
              rabview_id  = '".$insert[$x]['rabview_id']."',
              thang       = '".$insert[$x]['thang']."',
              kdprogram   = '".$insert[$x]['kdprogram']."',
              kdgiat      = '".$insert[$x]['kdgiat']."',
              kdoutput    = '".$insert[$x]['kdoutput']."',
              kdsoutput   = '".$insert[$x]['kdsoutput']."',
              kdkmpnen    = '".$insert[$x]['kdkmpnen']."',
              kdskmpnen   = '".$insert[$x]['kdskmpnen']."',
              kdakun      = '".$insert[$x]['kdakun']."',
              noitem      = '".$insert[$x]['noitem']."',
              value       = '".$insert[$x]['value']."',
              status       = '".$insert[$x]['status']."',

              deskripsi   = '".$insert[$x]['deskripsi']."',
              tanggal     = '".$insert[$x]['tanggal']."',
              lokasi      = '".$insert[$x]['lokasi']."',

              jenis       = '".$insert[$x]['jenis']."',
              penerima    = '".$insert[$x]['penerima']."',
              npwp        = '".$insert[$x]['npwp']."',
              golongan    = '".$insert[$x]['golongan']."',
              jabatan     = '".$insert[$x]['jabatan']."',
              pns         = '".$insert[$x]['pns']."',

              pajak       = '".$insert[$x]['pajak']."'
          ";
          $result = $this->query($query);
        }
      }
      return $insert;
    }

  }

?>
