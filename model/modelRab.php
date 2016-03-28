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
      if (isset($data['output'])) {
        $tahun = $data['tahun'];
        $output = $data['output'];
        $soutput = $data['soutput'];
        $komp = $data['komp'];
        $skomp = $data['skomp'];
        $set = "thang = '$tahun', 
                kdoutput    = '$output',
                kdsoutput   = '$soutput',
                kdkmpnen    = '$komp',
                kdskmpnen   = '$skomp',";
      }else{
        $set = '';
      }
      $uraian = $data['uraian'];
      $t = explode("/", $data['tanggal']);
      $tgl=$t[2].'-'.$t[1].'-'.$t[0];
      $t2         = explode("/", $data['tanggal_akhir']);
      $tgl_akhir  = $t2[2].'-'.$t2[1].'-'.$t2[0];
      $lokasi = $data['lokasi'];
      $tempat = $data['tempat'];

      $query      = "UPDATE rabview SET
        ".$set."        
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

    public function getJumRkakl2($data, $akun=null){
      $rab = $data;
      if ($akun != null) {
        $whereitem = "AND KDAKUN='$akun' GROUP BY KDAKUN";
      }else{
        $whereitem = "";
      }
      $qry_rkakl = "SELECT sum(jumlah) as `jumlah`, sum(realisasi) as `realisasi`, sum(usulan) as `usulan`
                     FROM rkakl_full 
                      WHERE THANG='$rab->thang'
                      AND KDPROGRAM='$rab->kdprogram'
                      AND KDGIAT='$rab->kdgiat'
                      AND KDOUTPUT='$rab->kdoutput'
                      AND KDSOUTPUT='$rab->kdsoutput'
                      AND KDKMPNEN='$rab->kdkmpnen'
                      AND KDSKMPNEN='$rab->kdskmpnen'
                      ".$whereitem."
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_object($res_rkakl)) {
        $jumrkakl = $jumlah;
      }
      return $jumrkakl;
    }

    public function getJumlahRkakl($data, $akun=null, $noitem=null){
      $rab = $data;
      if ($akun != null) {
        $whereitem = "AND KDAKUN='".$akun."'";
      }else{
        $whereitem = "";
      }
      if ($noitem != null) {
        $whereitem .= "AND NOITEM = '".$noitem."' GROUP BY NOITEM";
      }else{
        if ($akun != null) {
          $whereitem .= "GROUP BY KDAKUN";
        }
      }

      $qry_rkakl = "SELECT sum(jumlah) as `jumlah`, sum(realisasi) as `realisasi`, sum(usulan) as `usulan`, GROUP_CONCAT(noitem) as noitem
                     FROM rkakl_full 
                      WHERE THANG='".$rab['thang']."'
                      AND KDPROGRAM='".$rab['kdprogram']."'
                      AND KDGIAT='".$rab['kdgiat']."'
                      AND KDOUTPUT='".$rab['kdoutput']."'
                      AND KDSOUTPUT='".$rab['kdsoutput']."'
                      AND KDKMPNEN='".$rab['kdkmpnen']."'
                      AND KDSKMPNEN='".$rab['kdskmpnen']."'
                      ".$whereitem."
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_array($res_rkakl)) {
        $jumrkakl['jumlah'] = $jumlah['jumlah'];
        $jumrkakl['realisasi'] = $jumlah['realisasi'];
        $jumrkakl['usulan'] = $jumlah['usulan'];
        $jumrkakl['itemgroup'] = $jumlah['noitem'];
      }
      return $jumrkakl;
    }

    public function insertUsulan($rab, $akun, $item, $total){
      $query = "UPDATE rkakl_full SET usulan='$total' WHERE THANG     = '".$rab['thang']."'
                                                      AND KDPROGRAM   = '".$rab['kdprogram']."'
                                                      AND KDGIAT      = '".$rab['kdgiat']."'
                                                      AND KDOUTPUT    = '".$rab['kdoutput']."'
                                                      AND KDSOUTPUT   = '".$rab['kdsoutput']."'
                                                      AND KDKMPNEN    = '".$rab['kdkmpnen']."'
                                                      AND KDSKMPNEN   = '".$rab['kdskmpnen']."'
                                                      AND KDAKUN      = '".$akun."'
                                                      AND NOITEM      = '".$item."'
                                                      ";
      $result = $this->query($query);
      return $result;
    }

    public function insertRealisasi($rab, $akun, $item, $total){
      $query = "UPDATE rkakl_full SET realisasi='$total' WHERE THANG     = '".$rab['thang']."'
                                                      AND KDPROGRAM   = '".$rab['kdprogram']."'
                                                      AND KDGIAT      = '".$rab['kdgiat']."'
                                                      AND KDOUTPUT    = '".$rab['kdoutput']."'
                                                      AND KDSOUTPUT   = '".$rab['kdsoutput']."'
                                                      AND KDKMPNEN    = '".$rab['kdkmpnen']."'
                                                      AND KDSKMPNEN   = '".$rab['kdskmpnen']."'
                                                      AND KDAKUN      = '".$akun."'
                                                      AND NOITEM      = '".$item."'
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
      $thang      = $data['thang'];
      $kdprogram  = $data['kdprogram'];
      $kdgiat     = $data['kdgiat'];
      $kdoutput   = $data['kdoutput'];
      $kdsoutput  = $data['kdsoutput'];
      $kdkmpnen   = $data['kdkmpnen'];
      $kdskmpnen  = $data['kdskmpnen'];
      $penerima   = $data['penerima'];
      $npwp       = $data['npwp'];
      $jenis      = $data['jenis'];

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
      $data  = $this->fetch_array($result);
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
      $tanggal_akhir    = $cekfetch->tanggal_akhir;
      $tempat     = $cekfetch->tempat;
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

          deskripsi   = '$deskripsi',
          tanggal     = '$tanggal',
          tanggal_akhir   = '$tanggal_akhir',
          tempat      = '$tempat',
          lokasi      = '$lokasi',

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
          $biaya_akom  = str_replace(".", "", $data['biaya_akom'][$i]);

          $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari) + $biaya_akom;
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
                        lama_hari   = '$lama_hari',
                        biaya_akom   = '$biaya_akom'
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
          $biaya_akom  = str_replace(".", "", $data['biaya_akom'][$i]);

          $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari) + $biaya_akom;
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
                        lama_hari   = '$lama_hari',
                        biaya_akom   = '$biaya_akom'
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
        $biaya_akom  = str_replace(".", "", $data['biaya_akom'][$i]);


        $value_total  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari) + $biaya_akom;
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
                      lama_hari   = '$lama_hari',
                      biaya_akom  = '$biaya_akom'
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
      $thang      = $data['thang'];
      $kdprogram  = $data['kdprogram'];
      $kdgiat     = $data['kdgiat'];
      $kdoutput   = $data['kdoutput'];
      $kdsoutput  = $data['kdsoutput'];
      $kdkmpnen   = $data['kdkmpnen'];
      $kdskmpnen  = $data['kdskmpnen'];
      if ($data['kdakun'] != "") {
        $kdakun  = $data['kdakun'];
        $noitem  = $data['noitem'];
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

    public function hitung_dipa($data,$kdakun,$noitem){
      $q_out = $q_sout = $q_kmp = $q_skmp = $q_akun  = "";

      $thang      = $data['thang'];
      $kdprogram  = $data['kdprogram'];
      $kdgiat     = $data['kdgiat'];
      $kdout   = $data['kdoutput'];
      $kdsout  = $data['kdsoutput'];
      $kdkmp   = $data['kdkmpnen'];
      $kdskmp  = $data['kdskmpnen'];
     
      $q_out = " and kdoutput='$kdout' "; 
      $q_sout = " and kdsoutput='$kdsout' "; 
      $q_kmp = " and kdkmpnen='$kdkmp' ";  
      $q_skmp = " and kdskmpnen='$kdskmp' "; 

      if($kdakun!=""){ 
        $q_akun = " and kdakun='$kdakun' "; 
      }

      if($kdakun=="521211"){ 
        $q_akun .= " and noitem = '$noitem' "; 
      }  

      $query = " SELECT SUM(JUMLAH) as jumlah, SUM(realisasi) as realisasi , SUM(usulan) as usulan FROM rkakl_full WHERE thang = '$thang' AND kdgiat ='$kdgiat' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun;
      
      $res_pagu = $this->query($query);
      $data_pagu = $this->fetch_array($res_pagu);

      $sisa = $data_pagu['jumlah'] - ($data_pagu['realisasi'] + $data_pagu['usulan']);
   
      $arr_data = array(
              "pagu" => number_format($data_pagu['jumlah'],"2",",","."),
              "kdakun" => $kdakun,
              "realisasi" => number_format($data_pagu['realisasi'],"2",",","."),
              "sisa" => number_format($sisa,"2",",","."),
              "usulan" => number_format($data_pagu['usulan'],"2",",",".")
              );
      echo json_encode($arr_data);
      return $arr_data;
    

    }

    public function deleterab($id_rabview){

      $query = "DELETE FROM rabview WHERE id = '$id_rabview'";
      $query2 = "DELETE FROM rabfull WHERE rabview_id = '$id_rabview'";
      $result = $this->query($query);
      $result2 = $this->query($query2);
      return $result;
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
      $getview = $this->getview($array['id_rab_view']);
      $jenis = $array['jenis'];
      $arrayCount = count($data);
      $x = 0;$error = 'false';
      $honor_output_tot = 0;$honor_profesi_tot = 0;$uang_saku_tot = 0;$trans_lokal_tot=0;$uang_represen_tot=0;
      $uang_harian_tot = 0;$perjalanan_tot = 0;
      $belanja_atk=0;$belanja_bahan=0;$belanja_konsumsi=0;
      $gaji111=0;$gaji119=0;$gaji121=0;$gaji122=0;$gaji123=0;$gaji125=0;$gaji126=0;$gaji129=0;$gaji133=0;$gaji147=0;$gaji151=0;$gaji211=0;$gaji412=0;
      $belanja111=0;$belanja113=0;$belanja114=0;$belanja115=0;$belanja119=0;$belanja811=0;$belanja131=0;$belanja141=0;
      $modal532111=0;$modal533121=0;$modal533121=0;$modal536111=0;
      for ($i=20; $i < $arrayCount; $i++) { 
        if ($data[$i]["B"] == ""){
          break;
        }
        $penerima              = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $asal                  = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $npwp                  = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $nip                   = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $golongan              = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $pns                   = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $pajak                 = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $jabatan               = trim($data[$i]["I"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        #Honor Output 521213
        $honor_output          = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        #Honor Profesi 522151
        $honor_profesi         = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        #Uang Saku 524113 / 524114
        $uang_saku             = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Transport Lokal 524113 / 524114
        $trans_lokal           = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Uang Representatif 524111 / 524113 / 524114 / 524119
        $uang_represen         = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Uang Harian 524111 / 524114 / 524119 / 524211
        $uang_harian           = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # tiket 524111 / 524119 / 524211
        $harga_tiket           = trim($data[$i]["P"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tgl_mulai             = trim($data[$i]["Q"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tgl_akhir             = trim($data[$i]["R"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $lama_hari             = trim($data[$i]["S"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $tingkat_jalan         = trim($data[$i]["T"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $alat_trans            = trim($data[$i]["U"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $kota_asal             = trim($data[$i]["V"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $kota_tujuan           = trim($data[$i]["W"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Taxi Asal dan Tujuan 524111 & 524119
        $taxi_asal111          = trim($data[$i]["X"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $taxi_asal119          = trim($data[$i]["Y"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $taxi_tujuan111        = trim($data[$i]["Z"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $taxi_tujuan119        = trim($data[$i]["AA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Perjalanan Darat 524111 / 524119
        $darat                 = trim($data[$i]["AB"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Airport Tax 524111 / 524119 / 524211
        $airporttax            = trim($data[$i]["AC"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Rute 1, 2, 3, 4  524111 / 524119 / 524211
        $rute1                 = trim($data[$i]["AD"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $harga_tiket1          = trim($data[$i]["AE"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute2                 = trim($data[$i]["AF"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $harga_tiket2          = trim($data[$i]["AG"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute3                 = trim($data[$i]["AH"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $harga_tiket3          = trim($data[$i]["AI"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $rute4                 = trim($data[$i]["AJ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $harga_tiket4          = trim($data[$i]["AK"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Harga Tiket 524111 / 524119
        $harga_tiket5          = trim($data[$i]["AL"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $klmpk_hr              = trim($data[$i]["AM"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $malam                 = trim($data[$i]["AN"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Biaya Akom 524113 / 524114 / 524119
        $biaya_akom            = trim($data[$i]["AO"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Bahan 521211
        $belanja_atk           = trim($data[$i]["AP"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $belanja_bahan         = trim($data[$i]["AQ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $belanja_konsumsi      = trim($data[$i]["AR"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Gaji Pokok PNS 511111
        $gaji111               = trim($data[$i]["AS"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Pembulatan Gaji PNS 511119
        $gaji119               = trim($data[$i]["AT"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja TUnjangan Suami / Istri PNS 511121
        $gaji121               = trim($data[$i]["AU"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Anak PNS 511122
        $gaji122               = trim($data[$i]["AV"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Struktural PNS 511123 
        $gaji123               = trim($data[$i]["AW"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan PPh PNS 511125
        $gaji125               = trim($data[$i]["AX"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Beras PNS 511126
        $gaji126               = trim($data[$i]["AY"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Uang Makan PNS
        $gaji129               = trim($data[$i]["AZ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Khusus Peralihan 511133
        $gaji133               = trim($data[$i]["BA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Lain-lain 511147
        $gaji147               = trim($data[$i]["BB"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Tunjangan Umum PNS 511151
        $gaji151               = trim($data[$i]["BC"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Uang Lembur 512211
        $gaji211               = trim($data[$i]["BD"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Pegawai Transito 512412
        $gaji412               = trim($data[$i]["BE"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Keperluan Perkantoran 521111
        $belanja111            = trim($data[$i]["BF"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Penambah Daya Tahan Tubuh 521113
        $belanja113            = trim($data[$i]["BG"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Pengiriman Surat Pos 521114
        $belanja114            = trim($data[$i]["BH"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Honor Operasional Satker 521115
        $belanja115            = trim($data[$i]["BI"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Barang Operasional 521119
        $belanja119            = trim($data[$i]["BJ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Barang Untuk Persediaan Barang Konsumsi 521811
        $belanja811            = trim($data[$i]["BK"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Jasa Konsultan 522131
        $belanja131            = trim($data[$i]["BL"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Sewa 522141
        $belanja141            = trim($data[$i]["BM"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Modal Peralatan dan Mesin 532111
        $modal532111           = trim($data[$i]["BN"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Biaya Pemeliharaan Peralatan dan Mesin 523121
        $belanja121            = trim($data[$i]["BO"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Penambahan Nilai Gedung dan Bangunan 533121
        $modal533121           = trim($data[$i]["BP"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        # Belanja Modal Lainnya 536111
        $modal536111           = trim($data[$i]["BQ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        
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
                            'thang'       => $getview['thang'],
                            'kdprogram'   => $getview['kdprogram'],
                            'kdgiat'      => $getview['kdgiat'],
                            'kdoutput'    => $getview['kdoutput'],
                            'kdsoutput'   => $getview['kdsoutput'],
                            'kdkmpnen'    => $getview['kdkmpnen'],
                            'kdskmpnen'   => $getview['kdskmpnen'],

                            'deskripsi'   => $getview['deskripsi'],
                            'tanggal'     => $getview['tanggal'],
                            'tanggal_akhir' => $getview['tanggal_akhir'],
                            'lokasi'      => $getview['lokasi'],
                            'tempat'      => $getview['tempat'],

                            'jenis'       => $array['jenis'],
                            'penerima'    => $penerima, 
                            'npwp'        => $npwp,
                            'nip'         => $nip,
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
          $insert[$x]['noitem'] = '1';      ### KODE AKUN BELUM FIX ###
          $insert[$x]['value'] = $honor_output;
          $jumrkakl = $this->getJumlahRkakl($getview, '521213');
          if (!empty($jumrkakl['jumlah'])) {
            $pagu = $jumrkakl['jumlah'] - ($jumrkakl['realisasi'] + $jumrkakl['usulan'] + $honor_output_tot);
            if ($pagu >= $honor_output) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $honor_output_tot += $honor_output;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $this->insertTempRab($insert[$x]);
        }

        if ($honor_profesi != "") {
          $x++;
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = '522151';
          $insert[$x]['noitem'] = '1';      ### KODE AKUN BELUM FIX ###
          $insert[$x]['value'] = $honor_profesi;
          $jumrkakl = $this->getJumlahRkakl($getview, '522151');
          if (!empty($jumrkakl['jumlah'])) {
            $pagu = $jumrkakl['jumlah'] - ($jumrkakl['realisasi'] + $jumrkakl['usulan'] + $honor_profesi_tot);
            if ($pagu >= $honor_profesi) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $honor_profesi_tot += $honor_profesi;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $this->insertTempRab($insert[$x]);
        }

        if ($uang_saku != "") {
          $x++;
          if ($asal == "L") {
            $kdakun = "524113";
          }else{
            $kdakun = "524114";
          }
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = $kdakun;
          $insert[$x]['noitem'] = '1';
          $insert[$x]['value'] = $uang_saku;
          $jumrkakl = $this->getJumlahRkakl($getview, $kdakun);
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl['jumlah'] - ($jumrkakl['realisasi'] + $jumrkakl['usulan'] + $uang_saku_tot);
            if ($pagu >= $uang_saku) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $uang_saku_tot += $uang_saku;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $this->insertTempRab($insert[$x]);
        }

        if ($trans_lokal != "") {
          $x++;
          if ($asal == "L") {
            $kdakun = "524113";
          }else{
            $kdakun = "524114";
          }
          $insert[$x] = $dataorang;
          $insert[$x]['kdakun'] = $kdakun;
          $insert[$x]['noitem'] = '1';
          $insert[$x]['value'] = $trans_lokal;
          $jumrkakl = $this->getJumlahRkakl($getview, $kdakun);
          if (!empty($jumrkakl)) {
            $pagu = $jumrkakl['jumlah'] - ($jumrkakl['realisasi'] + $jumrkakl['usulan'] + $trans_lokal_tot);
            if ($pagu >= $trans_lokal) {
              $insert[$x]['error'] = '0';
            }else{
              $insert[$x]['error'] = '1';
              $error = 'true';
            }
            $trans_lokal_tot += $trans_lokal;
          }else{
            $insert[$x]['error'] = '2';
            $error = 'true';
          }
          $this->insertTempRab($insert[$x]);
        }

        if ($trans_lokal == "") {  #524119
          $x++;
          if ($asal == "L") {
            $kdakun = "524113";
          }else{
            $kdakun = "524114";
          }
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
                      lama_hari   = ''".$insert[$x]['lama_hari']."',
                      ";
          $this->insertTempRab($insert,$subquery);
        }
      }
      return $insert;
    }

    public function insertTempRab($data,$subquery=""){
      $query      = "INSERT INTO temprabfull SET
                    rabview_id  = '".$data['rabview_id']."',
                    thang       = '".$data['thang']."',
                    kdprogram   = '".$data['kdprogram']."',
                    kdgiat      = '".$data['kdgiat']."',
                    kdoutput    = '".$data['kdoutput']."',
                    kdsoutput   = '".$data['kdsoutput']."',
                    kdkmpnen    = '".$data['kdkmpnen']."',
                    kdskmpnen   = '".$data['kdskmpnen']."',
                    kdakun      = '".$data['kdakun']."',
                    noitem      = '".$data['noitem']."',
                    value       = '".$data['value']."',
                    status       = '".$data['status']."',

                    deskripsi   = '".$data['deskripsi']."',
                    tanggal     = '".$data['tanggal']."',
                    lokasi      = '".$data['lokasi']."',

                    jenis       = '".$data['jenis']."',
                    penerima    = '".$data['penerima']."',
                    npwp        = '".$data['npwp']."',
                    golongan    = '".$data['golongan']."',
                    jabatan     = '".$data['jabatan']."',
                    pns         = '".$data['pns']."',
                    ".$subquery."
                    pajak       = '".$data['pajak']."'
                ";
      $result = $this->query($query);
    }

    public function getjumlahgiat($id_rab_view){
      $query = "SELECT sum(value) as jumlah from rabfull where rabview_id='$id_rab_view'";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;
    }

  }

?>
