<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelRab extends mysql_db {

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
      $query  = "SELECT KDOUTPUT, NMOUTPUT FROM rkakl_full as r where kdprogram='$prog' and thang='$th' and kdgiat='$dr' 
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

    public function save($data){
      $direktorat = $data['direktorat2'];
      $tahun = $data['tahun2'];
      $prog = $data['prog'];
      $output = $data['output'];
      $soutput = $data['soutput'];
      $komp = $data['komp'];
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
        deskripsi   = '$uraian',
        tanggal     = '$tgl',
        lokasi      = '$lokasi',
        status      = '0'
      ";
      $result = $this->query($query);
      return $result;
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
      // while($fetch  = $this->fetch_object($result)) {
      //   $data[$i]['kdprogram'] = $fetch->kdprogram;
      //   $data[$i]['kdoutput'] = $fetch->kdoutput;
      //   $data[$i]['kdsoutput'] = $fetch->kdsoutput;
      //   $data[$i]['kdkmpnen'] = $fetch->kdkmpnen;
      //   $i++;
      // }
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
        kdoutput    = '$kdprogram',
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
        jabatan     = '$jabatan',
        status      = '0'
      ";
      $result = $this->query($query);
      return $result;
    }

  }

?>
