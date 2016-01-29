<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelRab extends mysql_db {

    public function getOrang($npwp){
      $query  = "SELECT penerima, npwp, pajak, golongan, jabatan, pns FROM rabfull as r 
                  where npwp = '$npwp' group by r.npwp";
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

    public function getakun($data){
      $id_rabview = $data['id_rab_aju'];
      $query_rab = "SELECT * FROM rabfull where rabview_id = '$id_rabview' group by kdakun";
      $res_rab = $this->query($query_rab);
      while ($rab = $this->fetch_object($res_rab)) {
        $akun[] = $rab;
      }
      return $akun;
    }
    public function getitembahan($data){
      $rab = $data;
      $qry_jumrab = "SELECT noitem, value FROM rabfull
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

    public function getrkakl($dataAkun, $dataItem){
      $rab = $dataAkun;
      $qry_rkakl = "SELECT jumlah FROM rkakl_full 
                      WHERE THANG='$rab->thang'
                      AND KDPROGRAM='$rab->kdprogram'
                      AND KDGIAT='$rab->kdgiat'
                      AND KDOUTPUT='$rab->kdoutput'
                      AND KDSOUTPUT='$rab->kdsoutput'
                      AND KDKMPNEN='$rab->kdkmpnen'
                      AND KDSKMPNEN='$rab->kdskmpnen'
                      AND KDAKUN='$rab->kdakun'
                      AND NOITEM='".$dataItem->noitem."'
                      ";
      $res_rkakl = $this->query($qry_rkakl);
      while ($jumlah = $this->fetch_object($res_rkakl)) {
        $jumrkakl = $jumlah->jumlah;
      }
      return $jumrkakl;
    }

    public function ajukan($data){
      $id_rab = $data['id_rab_aju'];
      $query = "UPDATE rabview SET status='1' WHERE id = '$id_rab'";
      $query2 = "UPDATE rabfull SET status='1' WHERE rabview_id = '$id_rab'";

      $result = $this->query($query);
      $result2 = $this->query($query2);

      return array('result' => $result,
                    'result2' => $result2
                  );
    }

    public function sahkan($data){
      $id_rab = $data['id_rab_sah'];
      $query = "UPDATE rabview SET status='2' WHERE id = '$id_rab'";
      $query2 = "UPDATE rabfull SET status='2' WHERE rabview_id = '$id_rab'";

      $result = $this->query($query);
      $result2 = $this->query($query2);

      return array('result' => $result,
                    'result2' => $result2
                  );
    }

    public function getview($id){
      $query  = "SELECT thang,kdprogram,kdgiat,kdoutput,kdsoutput,kdkmpnen,kdskmpnen, deskripsi,tanggal,lokasi
                 FROM rabview as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_array($result);
      return $data;
    }

    public function getrabfull($id){
      $query  = "SELECT thang,kdprogram,kdgiat,kdoutput,kdsoutput,kdkmpnen,kdskmpnen, penerima,npwp
                 FROM rabfull as r where id = '$id'";
      $result = $this->query($query);
      $data  = $this->fetch_object($result);
      return $data;
    }

    public function save_penerima($id_rab_view,$getview, $post){
      // print_r($getview);die;
      $thang      = $getview['thang'];
      $kdprogram  = $getview['kdprogram'];
      $kdgiat     = $getview['kdgiat'];
      $kdoutput   = $getview['kdoutput'];
      $kdsoutput  = $getview['kdsoutput'];
      $kdkmpnen   = $getview['kdkmpnen'];
      $kdskmpnen  = $getview['kdskmpnen'];
      $deskripsi  = $getview['deskripsi'];
      $tanggal    = $getview['tanggal'];
      $lokasi     = $getview['lokasi'];

      $jenis = $post['jenis-akun'];
      $penerima = $post['penerima'];
      $npwp = $post['npwp'];
      $golongan = $post['golongan'];
      $jabatan = $post['jabatan'];

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
        golongan    = '$golongan',
        jabatan     = '$jabatan'
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
      if ($cekfetch->kdakun !="") {
        $rabview_id= $cekfetch->rabview_id;
        $thang      = $cekfetch->thang;
        $kdprogram  = $cekfetch->kdprogram;
        $kdgiat     = $cekfetch->kdgiat;
        $kdoutput   = $cekfetch->kdoutput;
        $kdsoutput  = $cekfetch->kdsoutput;
        $kdkmpnen   = $cekfetch->kdkmpnen;
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

        $query = "UPDATE rabfull SET kdakun='$kdakun', noitem='$noitem', value='$value' 
                    where id='$id_rabfull'";
        $result = $this->query($query);
        return $result;
      }
    }

  }

?>
