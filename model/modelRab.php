<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelRab extends mysql_db {

    public function getOrang($data){
      $npwp = $data['npwp'];
      $jenis = $data['jenis'];
      $query  = "SELECT penerima, npwp, pajak, golongan, jabatan, pns FROM rabfull as r 
                  where npwp = '$npwp' and jenis='$jenis' group by r.npwp";
      $result = $this->query($query);
      while ($fetch = $this->fetch_array($result)) {
        $data['penerima'] = $fetch['penerima'];
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

    public function getnpwp(){
      $query = "SELECT npwp FROM rabfull group by npwp";
      $result = $this->query($query);
      $i=0;
      while ($fetch  = $this->fetch_object($result)) {
        $data['npwp'][$i] = $fetch->npwp;
        $i++;
      }
      return $data;
    }

    public function save($data){
      $direktorat = $data['direktorat'];
      $tahun = $data['tahun'];
      $prog = $data['prog'];
      $output = $data['output'];
      $soutput = $data['soutput'];
      $komp = $data['komp'];
      $skomp = $data['skomp'];
      $uraian = $data['uraian'];
      $t = explode("/", $data['tanggal']);
      $tgl=$t[2].'-'.$t[1].'-'.$t[0];
      $lokasi = $data['lokasi'];

      $query      = "INSERT INTO rabview SET
        thang       = '$tahun',
        kdprogram   = '$prog',
        kdgiat      = '$direktorat',
        kdoutput    = '$output',
        kdsoutput   = '$soutput',
        kdkmpnen    = '$komp',
        kdskmpnen    = '$skomp',
        deskripsi   = '$uraian',
        tanggal     = '$tgl',
        lokasi      = '$lokasi',
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
        value     = '$value',
        status      = '0'
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
      $query  = "SELECT thang,kdprogram,kdgiat,kdoutput,kdsoutput,kdkmpnen,kdskmpnen, deskripsi,tanggal,lokasi,
                        status
                 FROM rabview as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_array($result);
      return $data;
    }

    public function getrabfull($id){
      $query  = "SELECT *
                 FROM rabfull as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;
    }

    public function save_penerima($id_rab_view,$getview, $post){
      // print_r($getview);die;
      $thang      = $getview['thang'];
      $kdprogram  = $getview['kdprogram'];
      $kdgiat     = trim($getview['kdgiat'],"\x0D\x0A");
      $kdoutput   = trim($getview['kdoutput'],"\x0D\x0A");
      $kdsoutput  = trim($getview['kdsoutput'],"\x0D\x0A");
      $kdkmpnen   = trim($getview['kdkmpnen'],"\x0D\x0A");
      $kdskmpnen  = $getview['kdskmpnen'];
      $deskripsi  = $getview['deskripsi'];
      $tanggal    = $getview['tanggal'];
      $lokasi     = $getview['lokasi'];

      $jenis = $post['jenis-akun'];
      $penerima = $post['penerima'];
      $npwp = $post['npwp'];
      $jabatan = $post['jabatan'];
      $golongan = $post['golongan'];
      $pns = $post['pns'];

      $status = $post['adendum'];

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
        lokasi      = '$lokasi',

        jenis       = '$jenis',
        penerima    = '$penerima',
        npwp        = '$npwp',
        jabatan     = '$jabatan',
        golongan    = '$golongan',
        pns         = '$pns',
        pajak       = '$pajak',

        status       = '$status'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function getKwitansi($id_rab_view){
      $query  = "SELECT * FROM kwitansi as k
                  where k.rabview_id='$id_rab_view'
                  group by k.no_kwitansi";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data['KDKMPNEN'][$i] = $fetch->KDKMPNEN;
        $data['NMKMPNEN'][$i] = $fetch->NMKMPNEN;
        $i++;
      }
      return $data;
    }

    public function tambahAkun($data){
      $id_rabfull = $data['id_rabfull'];
      $cek  = "SELECT * FROM rabfull where id='$id_rabfull'";
      $cekresult = $this->query($cek);
      $cekfetch  = $this->fetch_object($cekresult);
      // print_r($cekfetch);die;
      // echo $cekfetch->kdakun; exit;
      if ($cekfetch->kdakun !="") {
        $rabview_id= $cekfetch->rabview_id;
        $thang      = $cekfetch->thang;
        $kdprogram  = $cekfetch->kdprogram;
        $kdgiat     = trim($cekfetch->kdgiat,"\x0D\x0A");
        $kdoutput   = trim($cekfetch->kdoutput,"\x0D\x0A");
        $kdsoutput  = trim($cekfetch->kdsoutput,"\x0D\x0A");
        $kdkmpnen   = trim($cekfetch->kdkmpnen,"\x0D\x0A");
        $kdskmpnen  = $cekfetch->kdskmpnen;
        $kdakun     = $data['kdakun'];
        $noitem     = $data['noitem'];
        $value      = $data['value'];

        $deskripsi  = $cekfetch->deskripsi;
        $tanggal    = $cekfetch->tanggal;
        $lokasi     = $cekfetch->lokasi;

        $jenis      = $cekfetch->jenis;
        $penerima   = $cekfetch->penerima;
        $npwp       = $cekfetch->npwp;
        $pajak      = $cekfetch->pajak;
        $golongan   = $cekfetch->golongan;
        $jabatan    = $cekfetch->jabatan;
        $pns        = $cekfetch->pns;

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

          deskripsi   = '$deskripsi',
          tanggal     = '$tanggal',
          lokasi      = '$lokasi',

          jenis       = '$jenis',
          penerima    = '$penerima',
          npwp        = '$npwp',
          golongan    = '$golongan',
          jabatan     = '$jabatan',
          pns         = '$pns'
        ";
        $result = $this->query($query);
        return $result;
      }else{
        $kdakun     = $data['kdakun'];
        $noitem     = $data['noitem'];
        $value      = $data['value'];

        $sub_query = "";

        if( $data['perjalanan'] == 'true'){
          $tgl_mulai     = date('Y-m-d', strtotime(str_replace('-', '/', $data['tgl_mulai'])));
          $tgl_akhir     = date('Y-m-d', strtotime(str_replace('-', '/', $data['tgl_akhir'])));
          $alat_trans     = $data['alat_trans'];
          $kota_asal     = $data['kota_asal'];
          $kota_tujuan     = $data['kota_tujuan'];
          $taxi_asal     = $data['taxi_asal'];
          $taxi_tujuan     = $data['taxi_tujuan'];
          $rute1     = $data['rute1'];
          $rute2     = $data['rute2'];
          $rute3     = $data['rute3'];
          $rute4     = $data['rute4'];

          $sub_query = "tgl_mulai = '$tgl_mulai',
            tgl_akhir = '$tgl_akhir',
            alat_trans= '$alat_trans',
            kota_asal='$kota_asal',
            kota_tujuan='$kota_tujuan',
            taxi_asal='$taxi_asal',
            taxi_tujuan='$taxi_tujuan',
            rute1='$rute1',
            rute2='$rute2',
            rute3='$rute3',
            rute4='$rute4'
            ";

        }

        $query = "UPDATE rabfull SET kdakun='$kdakun', noitem='$noitem', value='$value', $sub_query
                  where id='$id_rabfull'";
        $result = $this->query($query);
        return $result;
        

        
      }
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

  }

?>
