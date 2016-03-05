<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";
  require_once __DIR__ . "/../library/mPDF/mpdf.php";
  // include 'config/application.php';
  require_once __DIR__ . '/../utility/PHPExcel.php';
  require_once __DIR__ . '/../utility/PHPExcel/IOFactory.php';

  class modelReport extends mysql_db {

    public function getChartRKAKL(){
      $result = $this->query("SELECT KDGIAT, sum(jumlah), sum(realisasi) from rkakl_full group by KDGIAT");
      while($res=$this->fetch_array($result)){
          $results[] = $res;
      }
      $prev_value = array('value' => null, 'amount' => null);
      sort($results);
      foreach ($results as $data) {
        if ($prev_value['value'] != $data['KDGIAT'] && $data['KDGIAT'] != null) {
            unset($prev_value);
            $prev_value = array('value' => 'Kode Kegiatan '.$data['KDGIAT'], 'amount' => $data['sum(jumlah)']);
            $newResults[] =& $prev_value;
        }
        $prev_value['amount']++;
      }
      for ($i=0; $i < count($newResults) ; $i++) { 
        $newresult[$i][] =& $newResults[$i]['value'];
        $newresult[$i][] =& $newResults[$i]['amount'];
      }
      echo json_encode($newresult);
    }

    public function get_kd_akun($id){
      $result = $this->query("SELECT kdakun from rabfull where id='$id' ");
      $array = $this->fetch_array($result);
      return $array['kdakun'];
    }
    
    public function create_pdf($name, $size, $html){
      ob_end_clean();
      $mpdf=new mPDF('utf-8', $size); 
      $mpdf->WriteHTML(utf8_encode($html));
      $mpdf->Output($name.".pdf" ,'I');
      exit;
    }

    public function create_word($name, $size, $html){
      ob_end_clean();
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=".$name.".doc");
      echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:w="urn:schemas-microsoft-com:office:word"
              xmlns="http://www.w3.org/TR/REC-html40">';
      echo '<head>';
      echo '<style >
              @page Section1
              { 
                 mso-header-margin:.25in;
                margin: 0.20in 0.20in 0.20in 0.20in; 
              } 
               div.Section1
                {page:Section1;}
              body,  p.MsoNormal, li.MsoNormal, div.MsoNormal {
              margin: 0mm 0mm 0mm 0mm;
              margin-bottom:.0001pt;
              font-size:12.0pt;     
              }
              </style>';
      echo '<body>
             <div class="Section1"> ';
      echo $html;
      echo '</div>
      </body>';
      echo '<head>';
      echo '<html>';
    }

    public function log_kwitansi($res, $kode_akun,$id){
      $rabv_id = $res[rabview_id];
      $kdgiat = $res[kdgiat];
      $kdprogram = $res[kdprogram];
      $kdoutput = $res[kdoutput];
      $kdsoutput = $res[kdsoutput];
      $kdkmpnen = $res[kdkmpnen];
      $kdskmpnen = $res[kdskmpnen];
      $npwp= $res[npwp];
      $nip= $res[nip];
      $condition;
      // echo substr($kode, 0,2);
      // echo $npwp;
      if(substr($kode_akun, 0,2)=="51"){
        $condition=" and id='$id' ";
      }
      else{
        $condition="and rabview_id='$rabv_id' and npwp like '$npwp%' and nip like '$nip%' and kdakun='$kode_akun'";
      }

      $sql_org = "SELECT no_kuitansi from kuitansi 
                  where kdgiat = '$kdgiat' 
                    and kdprogram='$kdprogram' 
                    and kdoutput = '$kdoutput'
                    and kdsoutput = '$kdsoutput'
                    and kdkmpnen = '$kdkmpnen'
                    and kdskmpnen = '$kdskmpnen'
                    and npwp like '$npwp%' and nip like '$nip%' and kdakun='$kode_akun' ";
      $sql_org2 = "SELECT no_kuitansi_update from kuitansi
                  where kdgiat = '$kdgiat' 
                    and kdprogram='$kdprogram' 
                    and kdoutput = '$kdoutput'
                    and kdsoutput = '$kdsoutput'
                    and kdkmpnen = '$kdkmpnen'
                    and kdskmpnen = '$kdskmpnen'
                    order by no_kuitansi_update desc limit 1 ";

      $hsl_org = $this->query($sql_org);

      $sql_nomor = "SELECT no_kuitansi, no_kuitansi_update from kuitansi 
                    where kdgiat = '$kdgiat' 
                    and kdprogram='$kdprogram' 
                    and kdoutput = '$kdoutput'
                    and kdsoutput = '$kdsoutput'
                    and kdkmpnen = '$kdkmpnen'
                    and kdskmpnen = '$kdskmpnen' 
                    and npwp like '$npwp%' and nip like '$nip%' and kdakun='$kode_akun' order by no_kuitansi DESC, no_kuitansi_update DESC limit 1 ";
      $hsl_nomor = $this->query($sql_nomor);

      $arr_kw = $this->fetch_array($hsl_nomor);
      $arr_kw_org = $this->fetch_array($hsl_org);
      
      $no_kw = $arr_kw[no_kuitansi];
      
      $no_kw_org = $arr_kw_org[no_kuitansi];

      $no_kw_up = $arr_kw[no_kuitansi_update];


      if ($this->num_rows($hsl_nomor)==0) { 
        // echo "Belum Ada Nomor Kwitansi";
        $no_kw = 501;
        $no_kw_up = 501;
          // Masukkin data baru degan no_kuitansi = 1
          $this->query("UPDATE rabfull set no_kuitansi='$no_kw' where rabview_id='$rabv_id' and npwp='$npwp' and kdakun='$kode_akun' ");
          $this->query("INSERT into kuitansi(no_kuitansi,nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi,nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw' ".$condition." ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw' and no_kuitansi_update is null ".$condition." ");

      }
      else {
        if($this->num_rows($hsl_org)==0){
          // echo "Ada Nomor Kwitansi dan Belum ada orang";
          $no_kw++;
          $no_kw_up+=1;
          // Masukkin data baru degan no_kuitansi = 1++
          $this->query("UPDATE rabfull set no_kuitansi='$no_kw' where rabview_id='$rabv_id' and npwp='$npwp' and kdakun='$kode_akun' ");
          $this->query("INSERT into kuitansi(no_kuitansi, nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi, nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw' ".$condition." ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw' and no_kuitansi_update is null ".$condition." ");

        }
        else{
          $hsl_tbh = $this->query($sql_org2);
          $hsl_arr = $this->fetch_array($hsl_tbh);
          $no_kw_up = $hsl_arr[no_kuitansi_update];
          $no_kw_up+=1;
          // echo "Sudah ada orang dengan kwitansi nomor yg lama";
          $this->query("INSERT into kuitansi(no_kuitansi, nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi, nip, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw_org' ".$condition." ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw_org' and no_kuitansi_update is null  ".$condition." ");

        }
      }

      // echo " No Kwitansi ".$no_kw;
      return $no_kw;
    }

    public function cetak_dok($id,$pil_akun,$format){
      $result = $this->query("SELECT rabview_id, npwp, nip, kdgiat, kdprogram, kdoutput, kdsoutput, kdkmpnen, kdskmpnen from rabfull where id='$id' ");
      $res = $this->fetch_array($result);
      $rabv_id = $res[rabview_id];
      // echo $rabv_id;
      $kdgiat = $res[kdgiat];
      $kdprogram = $res[kdprogram];
      $kdoutput = $res[kdoutput];
      $kdsoutput = $res[kdsoutput];
      $kdkmpnen = $res[kdkmpnen];
      $kdskmpnen = $res[kdskmpnen];
      $kdakun= $res[kdskmpnen];
      $npwp= $res[npwp];
      $nip= $res[nip];

      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$kdgiat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];

      // echo "Npwp : ".$npwp;

      

      // { PENGUJIAN VARIABEL }
      // echo ' No Kwitansi : '.$no_kw." No Kw Update : ".$no_kw_up;
      // $deskripsi = $res[deskripsi];
      // $tanggal = $res[tanggal];
      // $lokasi = $res[lokasi];
      // $uang_muka = $res[uang_muka];
      // echo "Nama : ".$nama."RABV ID ".$rabv_id." KD PROGRAM : ".$kdgiat." ".$kdprogram." ".$kdoutput." ".$kdsoutput." ".$kdkmpnen;
      
      // { PENGUJIAN KONDISI YANG LAMA }
      // $this->log_kwitansi($det_giat);
      $dinas = 0;
      $lokal = 0;
      $dt_akun = array();
      $item_honor = "0";
      $item_transport = "0";
      $item_uangsaku = "0";
      $uang_saku_dalam_113 = 0;
      $uang_saku_dalam_114 = 0;
      $uang_saku_luar = 0;
      $honor_213 = 0;
      $honor_151 = 0;
      $honor_115 = 0;
      $transport_lokal_113 = 0;
      $transport_lokal_114 = 0;
      $item = "";
      $golongan; 
      $pns;
      $pajak;
      $kondisi_akun;
      $sql2 = $this->query("SELECT NMGIAT, NMOUTPUT, NMKMPNEN, NmSkmpnen, NMITEM FROM rkakl_full where KDPROGRAM = '$kdprogram' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN = '$kdkmpnen' and KDSKMPNEN = '$kdskmpnen' ; ");
      $detil_prog = $this->fetch_array($sql2);
      // print_r($detil_prog);
      mysql_free_result($result);
      if($pil_akun=="51"){
        $kondisi_akun = "id='$id' ";
      }
      else{
        $kondisi_akun = " rab.rabview_id='$rabv_id' and rab.npwp like '$npwp%' and rab.nip like '$nip%' order by rab.kdakun asc ";
      }
      // $result = $this->query("SELECT rab.alat_trans, rab.kota_asal, rab.kota_tujuan, rab.lama_hari, rab.tgl_mulai, rab.tgl_akhir, rab.rabview_id, rab.penerima, rab.kdprogram, rab.kdgiat, rab.kdoutput, rab.kdsoutput, rab.kdkmpnen, rab.kdakun, rkkl.NMGIAT, rab.value, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and rab.kdskmpnen = rkkl.KDSKMPNEN  and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rab.rabview_id='$rabv_id' and rab.npwp='$npwp' order by rab.kdakun asc ");
      $sql = "SELECT rab.penerima, rab.nip, rab.jabatan, rab.pns, rab.golongan, rab.kdakun, rkkl.NMGIAT, rab.value, rab.pajak, rab.ppn, rab.pph, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM, rab.tanggal_akhir, rab.lokasi FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdsoutput = rkkl.KDSOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and rab.kdskmpnen = rkkl.KDSKMPNEN  and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where ".$kondisi_akun." ";
      // print($sql);
      $result = $this->query($sql);
      // while($res=$this->fetch_array($result)){
      //   if($res[kdakun]=="524119" || $res[kdakun]=="524114"  || $res[kdakun]=="524113" || $res[kdakun]=="524219")   $dinas=1;
      //   if($res[kdakun]=="524114"  || $res[kdakun]=="524113")   $lokal=1;
      // }
      $counter="";
      $id_akun;
      
      while($res=$this->fetch_array($result)){
        $golongan=$res[golongan];
        $pns = $res[pns];
        // echo "<br>".$res[NMITEM]."<br>";
        if($res[kdakun]=="521213"){
          $item_honor = "1";
          $honor_213 += $res[value];
          // $pot = "";
          // $pph=0;
          $id_akun="521213";
        }
        //521115

        else if($res[kdakun]=="522151"){
          $item_honor = "1";
          $honor_151 += $res[value];
          $id_akun="522151";
          
        }
        else if($res[kdakun]=="521115"){
          $item_honor = "1";
          $honor_115 += $res[value];
          $id_akun="521115";
          
        }
        else if($res[kdakun]=="524113"){
          if(substr($res[NMITEM],1,8)!=="ransport"){
            $item_uangsaku = "1";
            $uang_saku_dalam_113 +=$res[value];
          }
          else
          {
            $item_transport = "1";
            $transport_lokal_113 +=$res[value];
          }
          
        }
        else if($res[kdakun]=="524114"){
          if(substr($res[NMITEM],1,8)!=="ransport"){
            $item_uangsaku = "1";
            $uang_saku_dalam_114 +=$res[value];
          }
          else{
            $item_transport = "1";
            $transport_lokal_114 +=$res[value];
          }
        }
        else if($res[kdakun]=="524119"){
          $item = "Perjalanan Dinas Keluar";
          $dinas=1;
        }
        else{
             // $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$res[kdakun]);
             //  echo '<pagebreak />';
          if($counter!==$res[kdakun]){
            array_push($dt_akun, $res[kdakun]);
            $counter=$res[kdakun];
          }
        }
        
       
      }

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
      // echo "Golongan : ".$golongan;
      // echo "  Pajak : ".$pajak;
      // echo "  PNS : ".$pns;
      $det_giat = array('kdgiat'    => $kdgiat,
                         'kdprogram' => $kdprogram,
                          'kdoutput'  => $kdoutput,
                          'kdsoutput' => $kdsoutput,
                          'kdkmpnen'  => $kdkmpnen,
                          'kdskmpnen' => $kdskmpnen,
                          'no_kw'     => $no_kw,
                          'bpp'       => $bpp,
                          'nip_bpp'   => $nip_bpp,
                          'ppk'       => $ppk,
                          'nip_ppk'   => $nip_ppk,
                          'rabview_id'   => $rabv_id,
                          'pajak'   => $pajak,
                          'nip'   => $nip,
                          'npwp'      => $npwp );
      ob_start();
      // print_r($dt_akun);
      if($honor_115>0){
          $nmr_kuitansi = $this->log_kwitansi($det_giat,"521115");
          $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "Honorarium",$honor_115,$id_akun, $nmr_kuitansi);
          echo '<pagebreak />';
      }
      if($honor_151>0){
          $nmr_kuitansi = $this->log_kwitansi($det_giat,"522151");
          $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "Honorarium",$honor_151,$id_akun, $nmr_kuitansi);
          echo '<pagebreak />';
      }
      if($honor_213>0){
          $nmr_kuitansi = $this->log_kwitansi($det_giat,"521213");
          $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "Honorarium",$honor_213,$id_akun, $nmr_kuitansi);
          echo '<pagebreak />';
      }
      if($uang_saku_dalam_113>0){
          $nmr_kuitansi = $this->log_kwitansi($det_giat,"524113");
          $this->Kuitansi_Honorarium($result, $det_giat, "Uang Saku",$uang_saku_dalam_113,"524113", $nmr_kuitansi);
          echo '<pagebreak />';
      }

      if($transport_lokal_113>0){
        $nmr_kuitansi = $this->log_kwitansi($det_giat,"524113");
        // echo " Return : ".$nmr_kuitansi;
        $this->Kuitansi_Honorarium($result, $det_giat, "Transport Lokal",$transport_lokal_113,"524113", $nmr_kuitansi);
        echo '<pagebreak />';
      }
      if($uang_saku_dalam_114>0){
          $nmr_kuitansi = $this->log_kwitansi($det_giat,"524114");
          $this->Kuitansi_Honorarium($result, $det_giat, "Uang Saku",$uang_saku_dalam_114,"524114", $nmr_kuitansi);
          echo '<pagebreak />';
      }

      if($transport_lokal_114>0){
        $nmr_kuitansi = $this->log_kwitansi($det_giat,"524114");
        // echo " Return : ".$nmr_kuitansi;
        $this->Kuitansi_Honorarium($result, $det_giat, "Transport Lokal",$transport_lokal_114,"524114", $nmr_kuitansi);
        echo '<pagebreak />';
      }

      if(count($dt_akun)==1){
        $nmr_kuitansi = $this->log_kwitansi($det_giat, $dt_akun[0],$id);
        $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$dt_akun[0], $nmr_kuitansi);
        echo '<pagebreak />';
      }
      if(count($dt_akun)>1){
        $nmr_kuitansi = $this->log_kwitansi($det_giat, $dt_akun[0],$id);
        $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$dt_akun[0], $nmr_kuitansi);
        echo '<pagebreak />';
        $nmr_kuitansi = $this->log_kwitansi($det_giat, $dt_akun[1],$id);
        $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$dt_akun[1], $nmr_kuitansi);
        echo '<pagebreak />';
        
      }
      if($dinas==1){
        $query = "SELECT golongan, npwp, lokasi,  jabatan, kota_asal, tgl_mulai,tanggal_akhir as tgl_akhir, kota_tujuan, rute, harga_tiket, alat_trans, taxi_asal, taxi_tujuan, lama_hari, uang_harian, penerima, value FROM rabfull where rabview_id='$rabv_id' and npwp='$npwp' ";
        // print_r($query);
        $nmr_kuitansi = $this->log_kwitansi($det_giat,"524119");
        $result = $this->query($query);
        $array = $this->fetch_array($result, $det_giat);
        // print_r($array);
        $this->SPPD($result, $det_giat);
         echo '<pagebreak />';
        $this->Rincian_Biaya_PD($result, $det_giat);
         echo '<pagebreak />';
        $this->daftar_peng_riil($result, $det_giat);
      }
        // echo "<br>Item Terpilih : ".$item."<br> Honorarium : ".$honor."<br> Uang saku : ".$uang_saku_dalam."Transport Lokal  : ".$transport_lokal;
        
      // ob_start();
      // if($lokal==0) {
      //   $this->Kuitansi_Honor_Uang_Saku($result, $no_kw, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen, $npwp);
      //   echo '<pagebreak />';
      // }
      // else{
      //   $this->Kuitansi_Honorarium($result, $no_kw, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen);
      //   echo '<pagebreak />';
      // }
      // if($dinas==1){ 
      //   $this->Rincian_Biaya_PD($result);
      //   echo '<pagebreak />';
      //   $this->SPPD($result);
      //   echo '<pagebreak />';
      // }
      // $this->daftar_peng_riil($result);
      $html = ob_get_contents();
      if($format=="pdf"){
      $this->create_pdf($npwp."_".$no_kw,"A4",$html);
      }
      else{
        $this->create_word($npwp."_".$no_kw,"A4",$html);
      }
    }

    public function SPTB($data, $direktorat){
      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$direktorat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];
      $sql = "SELECT view.deskripsi as deskripsi, r.NMITEM as nmitem, r.NMGIAT as nmgiat, r.NMAKUN as nmakun, f.kdgiat as kdgiat, f.kdprogram as kdprogram, f.kdoutput as kdoutput, f.kdakun as kdakun, f.penerima as penerima, f.tanggal as tanggal, f.value  as value, f.pajak as pajak, f.ppn as ppn, f.pph as pph FROM rabfull as f LEFT JOIN rkakl_full as r on f.kdgiat = r.KDGIAT and f.kdoutput = r.KDOUTPUT and f.kdsoutput = r.KDSOUTPUT and f.kdkmpnen = r.KDKMPNEN and f.kdskmpnen = r.KDSKMPNEN  and f.kdakun = r.KDAKUN and f.noitem = r.NOITEM  
                LEFT JOIN rabview as view on f.rabview_id = view.id
                where f.kdakun ='$data' and f.kdgiat='$direktorat' ";
      // print_r($sql);
      $res = $this->query($sql);
      $id = $this->fetch_array($res);
      ob_start();
      // echo '<p align="center" style="font-weight:bold; text-decoration: underline;">SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</p>';
      // echo '<p align="center" style="font-weight:bold;">Nomor : ___/SPTB/401196/XII/2016</p>';
      echo '<table style="width: 100%; font-size:0.8em;"  border="0">               
              <tr>
                <td style="font-weight:bold; text-decoration: underline; font-size:1.0em;" align="center" colspan="4">SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</td>
              </tr>
              <tr>
                <td style="font-weight:bold; font-size:1.0em;"  align="center" colspan="4">Nomor : ___/SPTB/401196/XII/2016</td>
              </tr>
              <tr>
                <td align="center" colspan="4"><br></br><br></br></td>
              </tr>

              <tr>
                <td align="left" width="1%">1.</td>
                <td align="left" width="30%">Kode Satuan Kerja</td>
                <td align="left" width="2%">:</td>
                <td align="left" >401196</td>
              </tr>
              <tr>
                <td align="left" width="1%">2.</td>
                <td align="left" width="30%">Nama Satuan Kerja</td>
                <td align="left" width="2%">:</td>
                <td align="left" >Ditjen Kelembagaan Iptek dan Dikti</td>
              </tr>
              <tr>
                <td align="left" width="1%">3.</td>
                <td align="left" width="30%">Tanggal/No.DIPA</td>
                <td align="left" width="2%">:</td>
                <td align="left" > ................................  Nomor : DIPA-042.03.1.401196/2016 dan Revisi ke __, Tgl. _______________________ 2016</td>
              </tr>
              <tr>
                <td align="left" width="1%">4.</td>
                <td align="left" width="30%">Klasifikasi Mata Anggaran</td>
                <td align="left" width="2%">:</td>
                <td align="left" >: 10.03.'.$id[kdprogram].'.'.$id[kdgiat].'.'.$id[kdoutput].'.'.$id[kdakun].'</td>
              </tr>
              <tr>
                <td colspan="4" style="border-top:1px solid;"></td>
              </tr>
            </table>';
      // echo '<p align="center" style="font-weight:bold;">______________________________________________________________________________________________________</p>';
      echo '<p align="left" style="font-size:0.65em;">Yang    bertandatangan  di    bawah  ini    atas  nama    Kuasa    Pengguna    Anggaran    Satuan Kerja Direktorat Jendral Kelembagaan Ilmu Pengetahuan Teknologi Dan Pendidikan Tinggi menyatakan  bahwa  saya  bertanggungjawab  secara  formal  dan  material  atas 
            segala  pengeluaran  yang  telah  dibayar  lunas  oleh  Bendahara  Pengeluaran  kepada  yang  berhak menerima  serta  kebenaran  perhitungan  dan  setoran  pajak  yang  telah  dipungut  atas  pembayaran tersebut dengan perincian sebagai berikut:</p>';
      
      echo '<table border="1" style="width: 100%; font-size:0.6em; border-collapse: collapse;">
            <tr>
              <th width="2%" rowspan="2">No.</td>
              <th rowspan="2">Akun</td>
              <th rowspan="2">Penerima</td>
              <th width="30%" rowspan="2">Uraian</td>
              <th colspan="2">Bukti</td>
              <th rowspan="2">Jumlah</td>
              <th  colspan="2">Pajak yang dipungut Bendahara Pengeluaran</td>
            </tr>
            <tr>
              <th width="10%">Tanggal</th>
              <th width="10%">Nomor</td>
              <th width="10%">PPN</th>
              <th width="10%">PPH</th>
            </tr>';
      $no=1;
      $tot_value = 0;
      $tot_ppn = 0;
      $tot_pph = 0;
      foreach ($res as $value) {
        $item=explode("[", $value[nmitem]);
        echo '<tr>
                <td>'.$no.'</td>
                <td>'.$value[kdakun].'</td>
                <td>'.$value[penerima].'</td>
                <td style="text-align: justify;">'." Biaya ".$item[0]." kegiatan ".$value[deskripsi].", tgl. ".$this->konversi_tanggal($value[tanggal],"").'</td>
                <td>'.$this->konversi_tanggal($value[tanggal],"/").'</td>
                <td>'."-".'</td>
                <td align="right">'.number_format($value[value],0,",",".").'</td>
                <td align="right">'.number_format($value[ppn],0,",",".").'</td>
                <td align="right">'.number_format($value[pph],0,",",".").'</td>
            </tr>';
            $tot_value += $value[value];
            $no++;
            $tot_ppn += $value[ppn];
            $tot_pph += $value[pph];
      }
        
      
      echo '<tr>
              <td colspan="6" align="center">JUMLAH</td>
              <td align="right">'.number_format($tot_value,0,",",".").'</td>
              <td align="right">'.number_format($tot_ppn,0,",",".").'</td>
              <td align="right">'.number_format($tot_pph,0,",",".").'</td>
              </tr>';
          echo '</table>';
          echo '<p align="left" style="font-size:0.65em;">Bukti-bukti  pengeluaran  anggaran  dan asli  setoran  pajak  (SSP/BPN)  tersebut  di  atas disimpan  oleh Pengguna  Anggaran/Kuasa  Pengguna  Anggaran  untuk  kelengkapan  administrasi  dan  pemeriksaan aparat pengawasan fungsional.</p>';
          echo '<p align="left" style="font-size:0.65em;">Demikian surat pernyataan ini dibuat dengan sebenarnya</p>';
          echo '<table style="text-align: justify; width: 98%; font-size:0.6em;" >
                  <tr>

                  <td></td>
                  <td  width="10%"></td>
                  <td>Jakarta, .............................................</td>
                  </tr>

                  <tr>
                    
                    <td>Direktorat Jendral Kelembagaan Iptek dan Dikti</td>
                    <td></td>
                    <td>Bendahara Pengeluaran</td>
                  </tr>
                  <tr>
                    
                    <td>Pejabat Pembuat Komitmen</td>
                    <td></td>
                  </tr>    
                  <tr>
                    <td><br></br><br></br><br></br><br></br></td>
                    
                    <td></td>
                  </tr>
                  <tr>
                    
                    <td style="font-weight:bold">'.$ppk.'</td>
                    <td></td>
                    <td style="font-weight:bold">Sugiharto</td>
                  </tr>
                  <tr>
                    
                    <td>NIP. '.$nip_ppk.'</td>
                    <td></td>
                    <td>NIP. 19750721 200912 1 001</td>
                  </tr>  
                  </table>';
      $html = ob_get_contents();
      $this->create_pdf("SPTB","A4",$html);
    }

    public function SPP($kdgiat, $bulan ,$post, $kdmak, $bulan_kata){
      $sql = $this->query("SELECT kdakun, sum(case when month(tanggal)='$bulan' then value else 0 end) as jumlah, sum(case when month(tanggal)<'$bulan' then value else 0 end) as jml_lalu FROM `rabfull` where  kdgiat='$kdgiat' and kdakun like '$kdmak%' GROUP BY kdakun order by kdakun asc ");
      // $sql2 = $this->query("SELECT substring(kdakun,1,2) as kdakun, sum(case when month(tanggal)='$bulan' then value else 0 end) as jumlah, sum(case when month(tanggal)<'$bulan' then value else 0 end) as jml_lalu FROM `rabfull` where  kdgiat='$kdgiat' GROUP BY kdakun order by kdakun asc ");
      $sql2 = $this->query("SELECT sum(value) as jumlah FROM `rabfull` where  kdgiat='$kdgiat' and kdakun like '$kdmak%' and month(tanggal)='$bulan' ");
      $arr_sql2 = $this->fetch_array($sql2);
      $nilai_spp = $arr_sql2['jumlah'];

      $sql_no_dp = "SELECT no_dipa, date(tanggal) as tanggal from rkakl_view where status=1";
      $res_no_dp = $this->query($sql_no_dp);
      $dt_dp = $this->fetch_array($res_no_dp);
      $nmr_dipa = $dt_dp['no_dipa'];
      $tgl_dipa = $this->konversi_tanggal($dt_dp['tanggal']);

      $pagu_51=$this->get_nama($kdgiat,"","","","","51");
      $pagu_52=$this->get_nama($kdgiat,"","","","","52");
      $pagu_53=$this->get_nama($kdgiat,"","","","","53");
      $pagu_57=$this->get_nama($kdgiat,"","","","","57");

      $nilai_51=$this->get_realisasi($bulan, $kdgiat,0,0,0,0,"51");
      $nilai_52=$this->get_realisasi($bulan, $kdgiat,0,0,0,0,"52");
      $nilai_53=$this->get_realisasi($bulan, $kdgiat,0,0,0,0,"53");
      $nilai_57=$this->get_realisasi($bulan, $kdgiat,0,0,0,0,"57");

      $tot_nilai_51 = $nilai_51['jml_lalu']+$nilai_51['jumlah'];
      $tot_nilai_52 = $nilai_52['jml_lalu']+$nilai_52['jumlah'];
      $tot_nilai_53 = $nilai_53['jml_lalu']+$nilai_53['jumlah'];
      $tot_nilai_57 = $nilai_57['jml_lalu']+$nilai_57['jumlah'];

      $sisa_dana_51 = $pagu_51['jumlah']-$tot_nilai_51;
      $sisa_dana_52 = $pagu_52['jumlah']-$tot_nilai_52;
      $sisa_dana_53 = $pagu_53['jumlah']-$tot_nilai_53;
      $sisa_dana_57 = $pagu_57['jumlah']-$tot_nilai_57;

      $acc_pagu = $pagu_51['jumlah']+$pagu_52['jumlah']+$pagu_53['jumlah']+$pagu_57['jumlah'];
      $acc_lalu = $nilai_51['jml_lalu']+$nilai_52['jml_lalu']+$nilai_53['jml_lalu']+$nilai_57['jml_lalu'];
      $acc_ini = $nilai_51['jumlah']+$nilai_52['jumlah']+$nilai_53['jumlah']+$nilai_57['jumlah'];
      $acc_tot = $tot_nilai_51+$tot_nilai_52+$tot_nilai_53+$tot_nilai_57;
      $acc_sisa_dana = $sisa_dana_57+$sisa_dana_53+$sisa_dana_52+$sisa_dana_51;

      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$kdgiat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];
      ob_start();
      echo '<table cellpadding="1" style="border-collapse:collapse; font-size:0.7em;">

             <tr>
              <td colspan="12" style="font-weight:bold; font-size:1.3em;" align="center">SURAT PERMINTAAN
              PEMBAYARAN</td>
             </tr>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td width="2%"></td>
              <td style="font-weight:bold;" colspan="3" align="right">Tanggal : 31 '.$bulan_kata.' 2016  Nomor :</td>
              <td style="font-weight:bold;"  colspan="5" >'.$post['nomor'].'</td>
             </tr>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan=2>Sifat Pembayaran</td>
              <td style="border:1px solid; text-align:center;" width="1%" >5</td>
              <td></td>
              <td></td>
              <td></td>
              <td width="1%" ></td>
             </tr>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan=2>Jenis Pembayaran</td>
              <td style="border:1px solid;  text-align:center;">1</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td colspan="13" style="border-bottom:1px solid;"></td>
             </tr>
             <tr>
              <td>1. </td>
              <td colspan=2>Kementerian/Lembaga</td>
              <td>:</td>
              <td colspan=2>Kemenristek Dikti</td>
              
              <td>[ 042 ]</td>
              <td>7. </td>
              <td>Kegiatan</td>
              <td></td>
              <td></td>
              <td>[ PKKID ]</td>
             </tr>
             <tr>
              <td>2. </td>
              <td colspan=2>Unit Organisasi</td>
              <td>:</td>
              <td colspan=2>Ditjen Kelembagaan Iptek
              dan Dikti</td>
              <td>[ 03 ]</td>
              <td>8. </td>
              <td>Kode Kegiatan</td>
              <td></td>
              <td></td>
              <td >[ '.$kdgiat.' ]</td>
             </tr>
             <tr>
              <td>3. </td>
              <td colspan=2>Kantor/Satker</td>
              <td>:</td>
              <td colspan=2>Ditjen Kelembagaan Iptek
              dan Dikti</td>
              <td>[401196]</td>
              <td>9. </td>
              <td colspan=3>Kode Fungsi, Sub Fungsi,
              Program</td>
              <td>[ 10.03.06 ]</td>
             </tr>
             <tr>
              <td>4. </td>
              <td colspan=2>Lokasi</td>
              <td>:</td>
              <td>DKI Jakarta</td>
              <td></td>
              <td>[ 01 ]</td>
              <td>10. </td>
              <td colspan=3>Kewenangan Pelaksanaan</td>
              <td>[ KP ]</td>
             </tr>
             <tr>
              <td>5. </td>
              <td colspan=2>Tempat</td>
              <td>:</td>
              <td>Kota Jakarta Pusat</td>
              <td></td>
              <td>[ 51 ]</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>6. </td>
              <td colspan=2>Alamat</td>
              <td>:</td>
              <td colspan=2>Gedung Kemenristek Dikti
              Lt. 6</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan=4>Jln. Jend. Sudirman Pintu
              I Senayan, Jakarta Pusat</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td colspan=12 style="border-top:1px solid;"><br></br></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10 style="font-weight:bold; text-align:center;">KEPADA</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10 style="font-weight:bold; text-align:center;">Yth. Pejabat Penanda Tangan Surat Perintah Membayar</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10 style="font-weight:bold; text-align:center;">Direktorat Jenderal Kelembagaan Ilmu Pengetahuan
              Teknologi dan Pendidikan Tinggi</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10 style="font-weight:bold; text-align:center;">di- Kota Jakarta Pusat</td>
              <td></td>
             </tr>
             <tr>
              <td colspan=12><br></br></td>
             </tr>
             <tr>
              <td colspan=12 >Berdasarkan DIPA Nomor : '.$nmr_dipa.', Tgl. '.$tgl_dipa.' dan, bersama ini kami
              ajukan pembayaran sebagai berikut :</td>
             </tr>
             <tr>
              <td >1. </td>
              <td colspan=2>Jumlah pembayaran</td>
              <td>:</td>
              <td>1) dengan angka:</td>
              <td colspan="7" style="font-weight:bold; font-size:1.2em">Rp. '.number_format($nilai_spp,0,".",",").',-</td>
             </tr>
             <tr>
              <td></td>
              <td colspan=2>yang dimintakan</td>
              <td>:</td>
              <td>2) dengan huruf :</td>
              <td colspan=7 align=left style="font-weight:bold; font-size:1.2em">'.$this->terbilang($nilai_spp).'</td>
             </tr>
             <tr>
              <td>2. </td>
              <td colspan=2>Untuk keperluan</td>
              <td>:</td>
              <td>GU NIHIL</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>3. </td>
              <td colspan=2>Jenis Belanja</td>
              <td>:</td>
              <td>'.$kdmak.'</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>4. </td>
              <td colspan=2>Atas nama</td>
              <td>:</td>
              <td colspan=4>Bendahara Pengeluaran
              Dit. Kelembagaan &amp; Kerjasama Dikti</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>5. </td>
              <td colspan=2>Alamat</td>
              <td>:</td>
              <td colspan=3>Gedung D Lt. VI Jl. Jend.
              Sudirman Pintu I Senayan</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>6. </td>
              <td colspan=2>Mempunyai rekening</td>
              <td>:</td>
              <td colspan=5>Pada Bank Mandiri KK
              Jakarta Kementerian Pendidikan Nasional</td>
              <td colspan=3>Rek. No. 102-00-0558946-7</td>
             </tr>
             <tr>
              <td>7. </td>
              <td colspan=2>No.&amp; Tgl.SPK/Kontr.</td>
              <td>:</td>
              <td>-</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>8. </td>
              <td colspan=2>Nilai SPK/Kontrak</td>
              <td>:</td>
              <td>-</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             </tr>
             <tr>
              <td>9. </td>
              <td colspan=2>Dengan penjelasan</td>
              <td>:</td>
              <td colspan=2>NPWP No.
              00.493.675.3-077.000</td>
              <td ></td>
              <td ></td>
              <td ></td>
              <td ></td>
              <td ></td>
              <td></td>
             </tr>
             <tr >
              <td style="border:1px solid"  align="center" rowspan=4>No</td>
              <td style="border-top:1px solid" align="center" >I</td>
              <td style="border-top:1px solid"  align="center" >Kegiatan &amp; MAK</td>
              <td style="border:1px solid"  align="center" colspan=2 rowspan=4>Pagu Dalam DIPA (Rp)</td>
              <td style="border:1px solid"  align="center" colspan=2 rowspan=4>SPP/SPM s/d yang lalu (Rp)</td>
              <td style="border:1px solid"  align="center" colspan=2 rowspan=4>Jumlah SPP ini (Rp)</td>
              <td style="border:1px solid"  align="center" colspan=2 rowspan=4>Jumlah s/d SPP ini (Rp)</td>
              <td style="border:1px solid"  align="center" rowspan=4>Sisa Dana(Rp)</td>
             </tr>
              <tr >
              <td  ></td>
              <td >Bersangkutan</td>
             </tr>
             <tr >
              <td  >II</td>
              <td >Semua Kode Keg.</td>
             </tr>
             <tr >
              <td></td>
              <td >Dalam MAK</td>
             </tr>
             <tr>
              <td style="border:1px solid" align="center">1</td>
              <td style="border:1px solid"  align="center" colspan=2>2</td>
              <td style="border:1px solid"  align="center" colspan=2>3</td>
              <td style="border:1px solid"  align="center" colspan=2>4</td>
              <td style="border:1px solid"  align="center" colspan=2>5</td>
              <td style="border:1px solid"  align="center" colspan=2>6 = ( 4+5)</td>
              <td style="border:1px solid"  align="center"  >7 = (3-6)</td>
             </tr>
             <tr>
              <td style="border:1px solid" align="center">I</td>
              <td style="border:1px solid"  align="center" colspan=2>Sub. Kegiatan & MAK</td>
              <td style="border:1px solid"  align="center" colspan=2></td>
              <td style="border:1px solid"  align="center" colspan=2></td>
              <td style="border:1px solid"  align="center" colspan=2></td>
              <td style="border:1px solid"  align="center" colspan=2></td>
              <td style="border:1px solid"  align="center"  ></td>
             </tr>';
      $tot_pagu=0; $tot_spp_ini=0; $tot_spp_lalu=0; $acc_tot_spp=0;$tot_sisa_dana=0;
      while($data=$this->fetch_array($sql)){
        $pagu=$this->hitung_pagu($kdgiat, $data['kdakun']);
        $tot_pagu+=$pagu;
        $spp_ini = $data['jumlah'];
        $tot_spp_ini+=$spp_ini;
        $spp_lalu = $data['jml_lalu'];
        $tot_spp_lalu += $spp_lalu;
        $tot_spp = $spp_lalu+$spp_ini;
        $acc_tot_spp+=$tot_spp;
        $sisa_dana = $pagu-$tot_spp;
        $tot_sisa_dana+=$sisa_dana;
        echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="left">'."2016.003 - ".$data['kdakun'].'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_lalu,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_ini,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_spp,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana,2,",",".").'</td>
              </tr>';

      }

      echo '<tr>
                <td style="border-left:1px solid; border:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="center">JUMLAH I</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($tot_pagu,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($tot_spp_lalu,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($tot_spp_ini,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($acc_tot_spp,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" align="right">'.number_format($tot_sisa_dana,2,",",".").'</td>
              </tr>';
      $spp_ini_fix=$tot_spp_ini;
      $tot_pagu=0; $tot_spp_ini=0; $tot_spp_lalu=0; $acc_tot_spp=0;$tot_sisa_dana=0;
      $init = $this->fetch_array($sql2);

      $pagu       =$this->hitung_pagu($kdgiat, $init['kdakun']); 
      $spp_ini    =$init['jumlah']; 
      $spp_lalu   =$init['jml_lalu'];
      $tot_spp    =$spp_ini+$spp_lalu;
      $sisa_dana  =$pagu-$tot_spp; 
      

      $tot_pagu     =$pagu; 
      $tot_spp_ini  =$spp_ini; 
      $tot_spp_lalu =$spp_lalu; 
      $acc_tot_spp  =$tot_spp;
      $tot_sisa_dana=$sisa_dana;
      $kd_akun      =$init['kdakun'];
      $init         =0;
      while($dt2=$this->fetch_array($sql2)){
        
        if($kd_akun!=$dt2['kdakun'] and $init==0){
          echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="left">'.$kd_akun.'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_lalu,2,",",".").'</td>';
          if($kd_akun==$kdmak) {
            echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_ini,2,",",".").'</td>';
          }
          else{
            $sisa_dana = $pagu-$spp_lalu;
            $tot_spp = $spp_lalu;
            $tot_sisa_dana=$sisa_dana;
            echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.'-'.'</td>';
          }
          echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_spp,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana,2,",",".").'</td>
              </tr>';
            $init=1;
            $spp_ini = 0;
            $spp_lalu = 0;
            $sisa_dana = 0;
            $tot_spp = 0;
            $pagu=0;
        }

          $pagu=$this->hitung_pagu($kdgiat, $dt2['kdakun']);
          $spp_ini += $dt2['jumlah'];
          $spp_lalu += $dt2['jml_lalu'];
          $sisa_dana += $pagu-$tot_spp;
          $tot_spp += $spp_lalu+$spp_ini;

          // $tot_pagu+=$pagu;
          $tot_spp_lalu += $spp_lalu;
          
          $tot_spp_ini+=$spp_ini_fix;
          $tot_sisa_dana+=$sisa_dana;
        
        
       if($kd_akun!=$dt2['kdakun'] and $init==1){
        
        echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="left">'.$dt2['kdakun'].'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_lalu,2,",",".").'</td>';
          if($dt2['kdakun']==$kdmak) {
            echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($spp_ini_fix,2,",",".").'</td>';
            $tot_spp = $spp_lalu+$spp_ini_fix;
            $sisa_dana = $pagu - $tot_spp;
          }
          else{
            echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.'-'.'</td>';
          $sisa_dana = $pagu-$spp_lalu;

          }
        echo '<td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_spp,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana,2,",",".").'</td>
              </tr>';

        $spp_ini = 0;
        $spp_lalu = 0;
        $sisa_dana = 0;
        $tot_spp = 0;
        $kd_akun=$dt2['kdakun'];
        $tot_pagu+=$pagu;
        $acc_tot_spp+=$tot_spp;
        }

      }
      
      echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">II</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="center">Kegiatan & MAK</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
              </tr>';
      echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="center">2016.51</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu_51['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_51['jml_lalu'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_51['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_nilai_51,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana_51,2,",",".").'</td>
              </tr>';
      echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="center">2016.52</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu_52['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_52['jml_lalu'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_52['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_nilai_52,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana_52,2,",",".").'</td>
              </tr>';
      echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="center">2016.53</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu_53['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_53['jml_lalu'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_53['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_nilai_53,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana_53,2,",",".").'</td>
              </tr>';
      echo '<tr>
                <td style="border-left:1px solid; border-right:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="center">2016.57</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($pagu_57['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_57['jml_lalu'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($nilai_57['jumlah'],2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" colspan=2 align="right">'.number_format($tot_nilai_57,2,",",".").'</td>
                <td style="border-left:1px solid; border-right:1px solid;" align="right">'.number_format($sisa_dana_57,2,",",".").'</td>
              </tr>';

      echo '<tr>
                <td style="border-left:1px solid; border:1px solid;" align="right"></td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="center">JUMLAH II</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($acc_pagu,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($acc_lalu,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($acc_ini,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" colspan=2 align="right">'.number_format($acc_tot,2,",",".").'</td>
                <td style="border-left:1px solid; border:1px solid;" align="right">'.number_format($acc_sisa_dana,2,",",".").'</td>
              </tr>';
      echo  '<tr>
              <td style="border:1px solid; text-align:center;"  colspan="3">Uang Persediaan</td>
              
              <td style="border-right:1px solid; border-bottom:1px solid; text-align:right;" colspan="2">-</td>
              
              <td style="border-right:1px solid; border-bottom:1px solid; text-align:right;" colspan="2">-</td>
              <td style="border-right:1px solid; border-bottom:1px solid; text-align:right;" colspan="2">-</td>
                            <td style="border-right:1px solid; border-bottom:1px solid; text-align:right;" colspan="2">-</td>>
              <td style="border:1px solid; text-align:right;">-</td>
             </tr>
             <tr >
              <td colspan="8" style="border-left:1px solid;">
              <td  >Surat bukti untuk</td>
              <td colspan="3" style="border-right:1px solid;">
             </tr>
             <tr>
              <td style="border-left:1px solid;" colspan="2">
              <td>LAMPIRAN</td>
              <td style="border:1px solid; width:10px"></td>
              <td>LEMBAR : B</td>
              <td colspan="2">
              <td style="border:1px solid; width:10px"></td>
              <td >pengeluaran</td>
              <td style="border:1px solid; width:10px"></td>
              <td >STS ___ lembar</td>
              <td style="border-right:1px solid;"></td>
             </tr>
             <tr>
              <td style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid;" colspan="12"><br></br></td>
             </tr>
             <tr>
              <td colspan="12"><br></br></td>
             </tr>
             <tr>
             <td colspan=5 >Diterima
              oleh penguji SPP/Penerbit SPM</td>
              <td colspan="4">
              <td colspan=3>Jakarta : 31 Desember 2016 </td>
             </tr>
             <tr >
              <td colspan=5 >Dirjen
              Kelembagaan Iptek dan Dikti (401196)</td>
              <td colspan="4">
              <td colspan=3>Pejabat Pembuat Komitmen</td>
             </tr>
             <tr >
              <td colspan=3 >Pada
              tanggal</td>
              <td colspan="6">
              <td colspan=3>Dirjen Kelembagaan Iptek
              dan Dikti (401196)</td>
             </tr>
             <tr>
              <td colspan="12" ><br></br> <br></br> <br></br></td>
             </tr>
             <tr >
              <td  colspan=3 >Akhmad
              Mahmudin, S.IP, M.Si</td>
              <td colspan="6">
              <td  colspan=2>'.$ppk.'</td>
              <td></td>
             </tr>
             <tr >
              <td  colspan=3 >NIP.
              19611214 198403 1 001</td>
              <td colspan="6">
              <td colspan=3>NIP. '.$nip_ppk.'</td>
             </tr>
             </table>';
            $html = ob_get_contents();
            $this->create_pdf("SPTB","A4",$html);
    }
    // DAFTAR RINCIAN PERMINTAAN PENGELUARAN
    public function Rincian_Permintaan_Pengeluaran($data, $direktorat, $bulan, $bulan_kata){
      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$direktorat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];
      $sql = $this->query("SELECT kdakun, penerima, tanggal, sum(value) as jumlah FROM `rabfull` where kdakun like '$data%' and kdgiat='$direktorat' and month(tanggal)='$bulan' GROUP BY kdakun order by kdakun asc ");
      $sql_pagu = $this->query("SELECT SUM(JUMLAH) as jumlah from rkakl_full where KDAKUN like '$data%' and KDGIAT='$direktorat' ");
      $data_pagu = $this->fetch_array($sql_pagu);
      $jumlah_pagu = $data_pagu['jumlah'];
      
      $sql_lalu = $this->query("SELECT sum(value) as jml_lalu from rabfull where kdakun like '$data%' and kdgiat='$direktorat' and month(tanggal)<'$bulan' GROUP BY kdakun ");
      $data_jml_lalu = $this->fetch_array($sql_lalu);
      $jml_lalu = $data_jml_lalu['jml_lalu'];
      ob_start();
      echo '<table cellpadding="3" style="width: 100%; font-size:0.7em; border-collapse: collapse;">
              <tr>
                <th colspan="7" style="border-top: 1px solid; border-left: 1px solid; border-right: 1px solid; font-size:1.0em; ">DAFTAR RINCIAN<br></td>
              </tr>
              <tr>
                <th colspan="7" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid; font-size:1.0em;">PERMINTAAN PENGELUARAN<br></td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">1. Kementrian / Lembaga<br></td>
                <td  colspan="2">: Kemenristek Dikti</td>
                <td style="border-left: 1px solid; border-right: 1px solid;" colspan="2">Jenis SPP<br></td>
                <td>6. Nomor<br></td>
                <td style="border-right: 1px solid;">:</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">2. Unit Organisasi<br></td>
                <td colspan="2">: Ditjen Kelembagaan Iptek dan Dikti</td>
                <td style="border-left: 1px solid; border-right: 1px solid;" colspan="2">1. GU NIHIL</td>
                <td>7. KODE KEGIATAN<br></td>
                <td style="border-right: 1px solid;">: '.$direktorat.'</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">3. Lokasi<br></td>
                <td colspan="2">: DKI Jakarta<br></td>
                <td style="border-left: 1px solid; border-right: 1px solid; border-top: 1px solid;" colspan="2"><br>PAGU SUB KEGIATAN</br></td>
                <td>8. KODE MAK<br></td>
                <td style="border-right: 1px solid;">:'." ".$data.'</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">4. Kantor / Satuan Kerja<br></td>
                <td colspan="2">: Ditjen Kelembagaan Iptek dan Dikti</td>
                <td style="border-left: 1px solid; border-right: 1px solid;" colspan="2" rowspan="2">Rp. '.number_format($jumlah_pagu,2,",",".").'</td>
                <td>9. TAHUN ANGGARAN<br></td>
                <td style="border-right: 1px solid;">: 2016</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">5. Alamat<br></td>
                <td  colspan="2">: Komplek Kemdikbud Gedung D Lt. 6</td>
                <td>10. Bulan</td>
                <td style="border-right: 1px solid;">: '.$bulan_kata.'</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid; border-bottom: 1px solid"></td>
                <td  style="border-bottom: 1px solid; border-right: 1px solid" colspan="2">Jln. Jend. Sudirman Pintu I Senayan, Jakarta Pusat</td>
                <td style="border-right: 1px solid; border-bottom: 1px solid; border-top: 1px solid; " colspan="4"></td>
              </tr>
              <tr>
                <td  rowspan="2" style="border: 1px solid; text-align:center;">No. Urut</td>
                <td  colspan="2" style="border: 1px solid;  text-align:center;">BUKTI PENGELUARAN</td>
                <td  rowspan="2" style="border: 1px solid;  text-align:center;">NPWP</td>
                <td  rowspan="2" style="border: 1px solid;  text-align:center;">MAK</td>
                <td  rowspan="2" style="border: 1px solid;  text-align:center;">NO BUKTI</td>
                <td  rowspan="2" style="border: 1px solid;  text-align:center;">JUMLAH KOTOR YANG DIBAYARKAN (Rp)</td>
              </tr>
              <tr>
                <td style="border: 1px solid;  text-align:center;" >TANGGAL PEMB</td>
                <td style="border: 1px solid;  text-align:center;">PENERIMA</td>
              </tr>';
      $no=1;
      $jml_ini=0;
      while($data=$this->fetch_array($sql)){
        echo '<tr>
                <td style="border: 1px solid;  text-align:center;">'.$no.'</td>
                <td style="border: 1px solid;  text-align:center;"></td>
                <td style="border: 1px solid;  text-align:center;">SPTB</td>
                <td style="border: 1px solid;  text-align:center;">-</td>
                <td style="border: 1px solid;  text-align:center;">'.$data[kdakun].'</td>
                <td style="border: 1px solid;  text-align:center;">Terlampir Pada SPTB</td>
                <td style="border: 1px solid;  text-align:right;">'.number_format($data[jumlah],2,",",".").'</td>
              </tr>';
              $jml_ini+=$data[jumlah];
              $no++;
      }
      $no--;
      if($jml_lalu=='') $jml_lalu=0;
      $total_spp = $jml_ini+$jml_lalu;
      echo'   <tr>
                <td style="border-right: 1px solid; border-left: 1px solid; border-top: 1px solid;  text-align:center;"> Jumlah Lampiran :</td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">Jumlah SPP ini (Rp)</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid; text-align:right;" colspan="5">'.number_format($jml_ini,2,",",".").'</td>

              </tr>
              <tr>
                <td style="border-right: 1px solid; border-left: 1px solid;  text-align:center;">'.$no.'</td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">SPM/SPP Sebelum SPP ini atas beban sub kegiatan ini</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid; text-align:right;" colspan="5">'.number_format($jml_lalu,2,",",".").'</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid; border-bottom: 1px solid;"></td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">Jumlah s.d. SPP ini atas beban sub kegiatan ini</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid; text-align:right;" colspan="5">'.number_format($total_spp,2,",",".").'</td>
              </tr>
            </table>';
      echo '<table style="text-align: justify; width: 100%; font-size:84%;"  >
            <tr>

            <td></td>
            <td width="30%"></td>
            <td>Jakarta, .............................................</td>
            </tr>

            <tr>
              <td></td>
              <td width="60%"></td>
              <td>Direktorat Kelembagaan dan Kerjasama</td>
            </tr>
            <tr>
              <td></td>
              <td width="60%"></td>
              <td>Pejabat Pembuat Komitmen</td>
            </tr>    
            <tr>
              <td><br></br><br></br><br></br><br></br></td>
              <td width="60%"></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td width="60%"></td>
              <td style="font-weight:bold">'.$ppk.'</td>
            </tr>
            <tr>
              <td></td>
              <td width="60%"></td>
              <td>NIP. '.$nip_ppk.'</td>
            </tr>  
            </table>';
            $html = ob_get_contents();
            $this->create_pdf("Rincian_Permintaan_Pengeluaran","A4",$html);

    }
    //Kuitansi Honorarium
    public function Kuitansi_Honorarium($data,$det,$item,$val,$kd_akun, $nmr_kw){
      $penerima;
      $jabatan;
      $total=0;
      // echo " NOmor KW : ".$nmr_kw;
      if($item==""){
        foreach ($data as $value) {
          if($value[kdakun]==$kd_akun and $value[kdakun]!== "521213" and $value[kdakun]!== "522151"and $value[kdakun]!== "524114"and $value[kdakun]!== "524113"and $value[kdakun]!== "524119" ){
             $total += $value[value];
             $penerima = $value[penerima];
             $npwp = $value[npwp];
          }
        }
      }
      else{
        foreach ($data as $value) {
           $penerima = $value[penerima];
           $jabatan = $value[jabatan];
           break;
        }
        $total=$val;
      }
      echo '  <p align="right">No '.$nmr_kw."/".$det['kdgiat'].".".$det['kdoutput'].".".$det['kdsoutput'].".".$det['kdkmpnen']."/2016".'</p>'; 
      require __DIR__ . "/../utility/report/header_dikti.php";
      echo '  <p align="center" style="text-decoration:underline;">KUITANSI</p>
                    <table style="width: 100%; font-size:80%; border-collapse: collapse;"  border="0">               
                    <tr>
                        <td align="left">Sudah Terima Dari </td>
                        <td align="left">: </td>
                        <td align="left" style="font-weight:bold"> Kuasa Pengguna Anggaran Direktorat Jenderal Kelembagaan IPTEK dan DIKTI</td>
                        
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left">: </td>
                        <td align="left" style="font-size:1.3em;"><b>Rp. '.number_format($total,0,",",".").'</b></td>
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: </td>
                        <td align="left"> <b>'.$this->terbilang($total,1).'<b></td>
                        
                    </tr>                
                    <tr>
                        <td align="left">Untuk Pembayaran</td>
                        <td align="left">: </td>
                        <td></td>
                        
                    </tr>                

                    </table>';
        $pph = (15 / 100) * $total;
        $diterima = $total-$pph;      
        echo  '<table style="width: 100%; font-size:80%;"  border="0">';
        if($item==""){                   
        foreach ($data as $value) {
          echo '<tr>
                  <td width="18%"></td>
                  <td width="40%">'.$value[NMITEM].'</td>
                  <td>'." : Rp. ".number_format($value[value],0,",",".").'</td>
                </tr>';
          }
        }
        else{
          echo '<tr>
                  <td width="18%"></td>
                  <td width="40%">'.$item.'</td>
                  <td>'." : Rp. ".number_format($val,0,",",".").'</td>
                </tr>';

        }
          echo '<tr>
                  <td ></td>
                  <td >'."Jumlah ".'</td>
                  <td>'." : Rp. ".number_format($total,0,",",".").'</td>
                </tr>';
        echo  '</table>';
        
        echo '<br></br>
              <table style="text-align: left; width: 100%; font-size:84%; font-family:serif"  >
          
              <tr>
                <td> Mengetahui/Setuju dibayar  </td>
                <td>Lunas Dibayar</td>
                <td>........................ 2016</td>
              </tr>              
              <tr>
                <td>Pejabat Pembuat Komitmen,</td>
                <td>Tgl...........................</td>
                <td>Penerima</td>
              </tr>
              <tr>
                <td></td>
                <td>Bendahara Pengeluaran Pembantu,</td>
                <td></td>
              </tr>
              <tr>
                <td><br></br> <br></br> <br></br></td>
                <td><br></br> <br></br> <br></br></td>
              </tr>
              <tr>
                <td>'.$det['ppk'].'</td>
                <td>'.$det['bpp'].'</td>
                <td>'.$penerima.'</td>
              </tr>              

              <tr>
                <td>NIP '.$det['nip_ppk'].'</td>
                <td>NIP '.$det['nip_bpp'].'</td>
                <td></td>
              </tr>
              <tr>
                <td style="border-bottom:2px dashed;" colspan="3"><br></br></td>
              </table>';

      if($item=="Transport Lokal"){
      require __DIR__ . "/../utility/report/header_dikti.php";  
        echo '<table border=0 style="width: 100%; text-align:left; border-collapse:collapse; font-size:85%;">
              <tr>
                <td style=" font-weight:bold;" align="center" colspan="3"> DAFTAR PENGELUARAN RIIL </td>
              </tr>
              <tr>
                <td style="" colspan="3"><br>Yang bertanda tangan dibawah ini :</br></td>
              </tr>
              <tr>
                <td width="20%">Nama</td>
                <td width="2%">:</td>
                <td>'.$penerima.'</td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>'.$jabatan.'</td>
              </tr>
            </table>';
        
        echo '<table border=0 style="width: 100%; text-align:left; border-collapse:collapse; font-size:0.9em;">
                <tr>
                  <td>Berdasarkan Surat Perjalanan Dinas (SPD) Tanggal ........................... Nomor: ...................................., dengan ini saya menyatakan dengan sesungguhnya bahwa:</td>
                </tr>
              </table>';
        
        echo '<table style="width: 100%; text-align:left; border-collapse:collapse; font-size:0.9em;">
                <tr>
                  <td width="3%">1.</td>
                  <td colspan="2">Biaya Transport dan pengeluaran yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi : </td>
                </tr>
              </table>';

        echo '<table cellpadding="2" style="width: 100%; text-align:left; border-collapse:collapse; font-size:0.9em;">
                <tr>
                      <td width="2%"></td>
                      <td width="4%" style="border:1px solid; font-weight:bold; text-align:center; ">No</td>
                      <td style="border:1px solid; font-weight:bold; text-align:center;">Uraian</td>
                      <td colspan="2" width="22%" style="border:1px solid; font-weight:bold; text-align:center;">Jumlah</td>
                </tr>
                <tr>
                      <td width="2%"></td>
                      <td width="4%" style="border-left:1px solid;">1</td>
                      <td style="border-left:1px solid;">Transport Lokal</td>
                      <td  width="5%" style="border-left:1px solid;  solid;">Rp.</td>
                      <td  width="17%" style="border-right:1px solid; text-align:right;">'.number_format($total,0,",",".").'</td>
                </tr>';

        echo    '<tr>
                    <td style=""> <br></br><br></br> </td>
                    <td style="border-top:1px solid;" colspan="4"> <br></br><br></br> </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td colspan="4">Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan Perjalanan Dinas dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran, saya bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara.</td>
                </tr>     ';
        echo  '</table>

      <h5>Demikian pernyataan ini dibuat untuk dipergunakan sebagaimana mestinya</h5>';

      echo '<table  style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
        <tr>
          <td width="60%">Mengetahui</td>
          <td>Jakarta, ..................................................</td>
        </tr>
        <tr>
          <td>Pejabat Pembuat Komitmen</td>
          <td>Yang Melaksanakan</td>
        </tr>
        <tr>
          <td colspan="2"><br></br><br></br><br></br> <br></br></td>
        </tr>
        <tr>
          <td style="font-weight:bold">'.$det['ppk'].'</td>
          <td>( '.$penerima.' )</td>
        </tr>
        
        <tr>
          <td>NIP. '.$det['nip_ppk'].'</td>
          <td></td>
        </tr>
      </table>';
      }

    }

    //SPPD SURAT PERINTAH PERJALANAN DINAS
    public function SPPD($data,$pejabat){
      // $query = "SELECT kota_asal, golongan, tingkat_jalan,  jabatan, kota_tujuan, alat_trans, lama_hari, tgl_mulai, tgl_akhir, uang_harian, penerima FROM rabfull where rabview_id='$rabv_id' and npwp='$npwp' ";
      // $data = $this->query($query);
      $golongan=null;
      $jabatan=null;
      $tingkat_jalan=null;
      $transportasi=null;
      $kota_asal=null;
      $kota_tujuan=null;
      $lama_hari=null;
      $tgl_mulai = null;
      $tgl_akhir = null;
      $penerima=null;
      $npwp=null;
      $lokasi=null;

      foreach ($data as $value) {
        if($value[golongan]!=""){ $golongan = $value[golongan]; }
        if($value[jabatan]!=""){ $jabatan = $value[jabatan]; }
        if($value[tingkat_jalan]!=""){ $tingkat_jalan = $value[tingkat_jalan]; }
        if($value[alat_trans]!=""){ $transportasi = $value[alat_trans]; }
        if($value[kota_asal]!="") $kota_asal= $value[kota_asal];
        if($value[kota_tujuan]!="") $kota_tujuan = $value[kota_tujuan];
        if($value[lama_hari]!="") $lama_hari = $value[lama_hari];
        if($value[tgl_mulai]!="") $tgl_mulai = $this->konversi_tanggal($value[tgl_mulai],"");
        if($value[tgl_akhir]!="") $tgl_akhir = $this->konversi_tanggal($value[tgl_akhir],"");
        if($value[npwp]!="") $npwp = $value[npwp];
        if($value[lokasi]!="") $lokasi = $value[lokasi];
        $penerima=$value[penerima];
      }

      // ob_start();  
      require __DIR__ . "/../utility/report/header_dikti.php";
      echo '  <table style="width: 50%; font-size:80%;"   border="0">               
                    <tr>
                        <td align="left">Lembar Ke</td>
                        <td align="left">: </td>
                    </tr> 
                    <tr>
                        <td align="left">Kode Nomor</td>
                        <td align="left">:</td>
                    </tr> 
                    <tr>
                        <td align="left">Nomor</td>
                        <td align="left">: </td>
                    </tr>                
                    </table>';
          echo '<p align="center">SURAT PERINTAH PERJALANAN DINAS</p>';
          echo '  <table style="width: 100%; border-collapse:collapse; font-size:80%;"  border="1">
                              
                    <tr>
                        <td>1</td>
                        <td>Pejabat berwenang yang memberi perintah</td>
                        <td colspan="2">Kuasa Pengguna Anggaran Direktorat Jenderal Kelembagaan Ilmu Pengetahuan, Teknologi dan Pendidikan Tinggi Kementerian Riset, Teknologi dan Pendidikan Tinggi </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Nama/NIP Pegawai Yang Diperintahkan</td>
                      <td colspan="2">'.$penerima." / ".$npwp.'</td>
                    </tr> 
                    <tr>
                        <td>3</td>
                        <td>
                          <p> a.  Pangkat dan Golongan ruang gaji menurut PP No. 6 Tahun 1997</p>
                          <p> b.  Jabatan/Instansi</p>
                          <p> c.  Tingkat menurut peraturan perjalanan dinas</p>
                        </td>
                        <td colspan="2"><p>'.$golongan.'</p>
                                        <p>'.$jabatan.'</p>
                                        <p>'.$tingkat_jalan.'</p></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Maksud Perjalanan Dinas</td>
                      <td colspan="2"></td>
                    </tr> 
                    <tr>
                      <td>5</td>
                      <td>Alat Angkutan yang dipergunakan</td>
                      <td colspan="2">'.$transportasi.'</td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>
                          <p> a.  Tempat Berangkat</p>
                          <p> b.  Tempat Tujuan</p>
                      </td>
                      <td colspan="2">
                          <p>'.$kota_asal.'</p>
                          <p>'.$kota_tujuan.'</p>
                      </td>
                    </tr> 
                    <tr>
                      <td>7</td>
                      <td>
                          <p>a.  Lamanya perjalanan dinas</p>
                          <p>b.  Tanggal berangkat</p>
                          <p>c.  Tanggal kembali/tiba di Tempat baru *)</p>

                      </td>
                      <td colspan="2">
                          <p>'.$lama_hari." Hari".'</p>
                          <p>'.$tgl_mulai.'</p>
                          <p>'.$tgl_akhir.'</p></td>
                    </tr>
                    
                    <tr>
                      <td>8</td>
                      <td>Pengikut</td>
                      
                      <td >Tanggal Lahir</td>
                      <td>Keterangan</td>
                    </tr> 
                    <tr>
                      <td>-</td>
                      <td></td>
                      
                      <td></td>
                      <td></td>
                      
                    </tr>
                    <tr>
                      <td>9</td>
                      <td>
                          <p>Pembebanan Anggaran</p>
                          <p>a. Instansi</p>
                          <p>b. Mata Anggaran</p>

                      </td>
                          
                      <td colspan="2">
                          <p>Pembebanan Anggaran</p>
                          <p>a. Direktorat Jenderal Kelembagaan Ilmu Pengetahuan Teknologi, dan Pendidikan Tinggi</p>
                          <p>b. Belanja</p>
                      </td>
                    </tr>
                    <tr>
                      <td>10</td>
                      <td>Keterangan Lain - lain : </td>
                      
                      <td colspan="2"> </td>
                      
                    </tr>

                </table>
                <p style="font-size:0.8em">*) Coret yang tidak perlu</p>';
        $date = getdate();
        echo '
              <table style="text-align: left; width: 100%; font-size:84%; border-collapse: collapse; font-family:serif"  >

              <tr>
                <td width="60%"></td>
                <td>Dikeluarkan Di </td>
                <td> : '.$lokasi.'</td>
              </tr>
              <tr>
                <td width="60%"></td>
                <td>Pada Tanggal</td>
                <td> : '.$tgl_akhir.'</td>
              </tr>

              </table>';



    }

    //Rincian Biaya Perjalanan Dinas
    public function Rincian_Biaya_PD($result,$pejabat){
      $direktorat=$pejabat['kdgiat'];
      $penerima;
      // $jml=0; 
      // $query = "SELECT kota_asal, kota_tujuan, tiket, airport_tax, alat_trans, taxi_asal, taxi_tujuan, lama_hari, uang_harian, penerima, npwp FROM rabfull where rabview_id='$rabv_id' and npwp='$npwp' ";
      // print_r($query);
      // $result = $this->query($query);
      // $array = $this->fetch_array($result);
      $asal=""; $tujuan=""; $alat_trans; $tiket=0; $airport_tax=0;
      $taxi_asal=0; $taxi_tujuan=0; $jml_hari=1; $uang_harian=0; $lokasi;
      $jml_uang_harian;
      $tgl_mulai = null;
      $tgl_akhir = null;
      
      // print_r($result);
      foreach ($result as $val) {
        if($val[alat_trans]!="") $alat_trans = $val[alat_trans];
        if($val[kota_asal]!="") $asal = $val[kota_asal];
        if($val[kota_tujuan]!="") $tujuan = $val[kota_tujuan];
        if($val[harga_tiket]>0) $tiket = $val[harga_tiket];
        if($val[airport_tax]>0) $airport_tax = $val[airport_tax];
        if($val[taxi_asal]>0)   $taxi_asal = $val[taxi_asal];
        if($val[taxi_tujuan]>0) $taxi_tujuan = $val[taxi_tujuan];
        if($val[lama_hari]>0)   $jml_hari = $val[lama_hari];
        if($val[tgl_mulai]!="") $tgl_mulai = $this->konversi_tanggal($val[tgl_mulai],"");
        if($val[tgl_akhir]!="") $tgl_akhir = $this->konversi_tanggal($val[tgl_akhir],"");
        if($val[uang_harian]>0) $uang_harian = $val[uang_harian];   
        if($val[lokasi]!="") $lokasi = $val[lokasi];   
        $penerima=$val[penerima];
      }
      $jml_uang_harian = $jml_hari * $uang_harian;
      $total = $tiket + $airport_tax + $taxi_asal + $taxi_tujuan +$jml_uang_harian;
      require __DIR__ . "/../utility/report/header_dikti.php";
      echo '<p align="center" style="font-weight:bold; font-size:1.0em">RINCIAN BIAYA PERJALANAN DINAS</p>';
      echo '  <table style="width: 40%; font-size:80%; font-weight:bold;"  border="0">     
        <tr>
            <td align="left">Lampiran SPPD Nomor</td>
            <td align="left">: </td>
        </tr> 
        <tr>
            <td align="left">Tanggal</td>
            <td align="left">:</td>
            <td align="left"></td>
        </tr> 
               

        </table>';    

      echo '  <table cellpadding="8" style="width: 100%; border-collapse:collapse; font-size:80%;">     
        <tr>
            <td width="9%" style="border:1px solid; text-align:center;">NO</td>
            <td width="40%"  style="border:1px solid; text-align:center;">PERINCIAN BIAYA</td>
            <td style="border:1px solid; text-align:center;">JUMLAH Rp.</td>
            <td style="border:1px solid; text-align:center;">KETERANGAN</td>
        </tr>'; 
       // $no=1; 
       //  foreach ($data as $value) {
          
          // echo '<tr>
          //        <td style="border-left:1px solid; border-right:1px solid">'.$no++.'</td>
          //        <td style="border-left:1px solid; border-right:1px solid" align="left">'.$value[NMITEM].'</td>
          //        <td style="border-left:1px solid; border-right:1px solid">'.number_format($value[value],0,",",".").'</td>
          //        <td style="border-left:1px solid; border-right:1px solid"></td>
          //       </tr>';
          //       $jml+=$value[value];
          // }
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">Transport : </td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';

          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$asal." - ".$tujuan.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp.'.number_format($tiket,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          if($airport_tax>0){
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'."Airport tax".'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp.'.number_format($airport_tax).'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          }
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'."Biaya Taxi dari / ke Bandara :  ".'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$asal." - Rp.".number_format($taxi_asal,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp.'.number_format($taxi_asal,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$tujuan." - Rp.".number_format($taxi_tujuan,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp.'.number_format($taxi_tujuan,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'."Uang Harian :".'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';

          //Uang Harian
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$jml_hari." Hari X Rp. ".number_format($uang_harian,0,",",".")." = Rp.".$jml_uang_harian.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp.'.number_format($jml_uang_harian,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'."Jumlah".'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Rp. '.number_format($total,0,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;"></td>
                </tr>';  
                echo '<tr>
                  <td style="border:1px solid; border-right:1px solid;"></td>
                  <td colspan="2" style="border:1px solid; border-right:1px solid;">'.$this->terbilang($total,1).'</td>
                  <td style="border:1px solid;"></td>
                </tr>';                

      echo '</table>';
      
      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$direktorat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];
      $date = getdate();
      echo '<table style="text-align: justify; width: 100%; font-size:84%; font-family:serif"  >
            <tr>

            <td></td>
            <td width="23%"></td>
            <td>'.$lokasi.','.$this->konversi_tanggal($tgl_akhir).'</td>
          </tr>

          <tr>
            <td>Telah dibayar sejumlah</td>
            <td width="23%"></td>
            <td>Telah menerima sejumlah uang sebesar</td>
          </tr>
          <tr>
            <td>Rp. '.number_format($total,0,",",".").'</td>
            <td width="23%"></td>
            <td>Rp. '.number_format($total,0,",",".").'</td>
          </tr>    
          <tr>
            <td>Bendahara Pengeluaran Pembantu</td>
            <td width="23%"></td>
            <td>Yang Menerima</td>
          </tr>
          <tr>
            <td><br></br><br></br><br></br><br></br></td>
            <td width="23%"></td>
            <td></td>
          </tr>
          <tr>
            <td>'.$bpp.'</td>
            <td width="23%"></td>
            <td>'.$penerima.'</td>
          </tr>
          <tr>
            <td>NIP '.$nip_bpp.'</td>
            <td width="23%"></td>
            <td></td>
          </tr>  
          </table>';
      echo '<p>______________________________________________________________________________________________________</p>';
      echo '<p align="center" style="font-weight:bold; font-size:1.0em">PERHITUNGAN SPPD RAMPUNG</p>';
      echo '  <table style="width: 60%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left">Ditetapkan Sejumlah</td>
                        <td align="left">: Rp. '."..............................................".'</td>
                    </tr> 
                    <tr>
                        <td align="left">Yang telah dibayar semula</td>
                        <td align="left">: Rp ..............................................</td>
                    </tr> 
                    <tr>
                        <td align="left">Sisa kurang/lebih</td>
                        <td align="left">: Rp ..............................................</td>
                    </tr> 
                    </table>';
                echo '<table style="text-align: right; width: 100%; font-size:80%;" >
                  <tr>                
                    <td colspan="2">Mengetahui Setuju Dibayar</td>
                  </tr>
                  <tr>
                    <td colspan="2">Pejabat Pembuat Komitmen</td>
                  </tr>    
                  <tr>
                    <td colspan="2"><br></br><br></br><br></br><br></br></td>
                  </tr>
                  <tr>
                    <td  colspan="2" style="font-weight:bold">'.$pejabat['ppk'].'</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-weight:bold">NIP. '.$pejabat['nip_ppk'].'</td>
                  </tr>  
                  </table>';  
      // $html = ob_get_contents();
      // $this->create_pdf("RB_Perjalanan_Dinas","A4",$html);
    }

    //Kuitansi Honor Dan Uang Saku
    public function Kuitansi_Honor_Uang_Saku($data,$det,$item,$val,$kd_akun, $nmr_kw) {
      $penerima;
      $total=0;
      $pph;
      // echo "Pajak Pot: ".$det['pajak'];
      if($item==""){
        foreach ($data as $value) {
          if($value[kdakun]==$kd_akun and $value[kdakun]!== "521213" and $value[kdakun]!== "522151"and $value[kdakun]!== "524114"and $value[kdakun]!== "524113"and $value[kdakun]!== "524119" ){
             $total += $value[value];
             $penerima = $value[penerima];
             $npwp = $value[npwp];
          }
          $tanggal_akhir = $value[tanggal_akhir];
          $lokasi = $value[lokasi];
        }
      }
      else{
        foreach ($data as $value) {
          $penerima = $value[penerima];
          $tanggal_akhir = $value[tanggal_akhir];
          $lokasi = $value[lokasi];
          break;
        }
        $total=$val;
      }

      if($det['pajak']>0){
        $pph = ($det['pajak'] / 100) * $total;
      }
      else {
        $pph=0;
      }

      $diterima = $total-$pph;  
        echo '  <p align="right">No '.$nmr_kw."/".$det['kdgiat'].".".$det['kdoutput'].".".$det['kdsoutput'].".".$det['kdkmpnen']."/2016".'</p>'; 
        require __DIR__ . "/../utility/report/header_dikti.php";
        echo ' <p align="center" style="font-weight:bold; font-size:1.2em">KUITANSI</p>
                    <table cellpadding="3" style="width: 100%; font-size:0.7em;"  border="0">               
                    <tr>
                        <td align="left" width="20%">Sudah Terima Dari </td>
                        <td width="1%" align="left">:</td>
                        <td colspan="2"> '.$penerima.'</td>
                       
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left" >: </td>
                        <td style="background-color:gray" colspan="2">Rp. '.number_format($total,0,",",".").'</td>
                        
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: </td>
                        <td colspan="2">'.$this->terbilang($total,1).'</td>
                        
                    </tr>                
                    <tr>
                        <td align="left">Untuk Pembayaran</td>
                        <td align="left">: '."".'</td>
                        <td></td>
                        <td></td>
                    </tr>'; 
         echo  '</table>';
            
         echo  '<table style="width: 100%; font-size:0.7em;"  border="0">';
         if($item==""){                   
            foreach ($data as $value) {
              if($value[kdakun]==$kd_akun and $value[kdakun]!== "521213" and $value[kdakun]!== "522151"and $value[kdakun]!== "524114"and $value[kdakun]!== "524113"and $value[kdakun]!== "524119" ){
                echo '<tr>
                        <td width="21%"></td>
                        <td width="40%">'.substr($value[NMITEM],0,strpos($value[NMITEM],"[")-1).'</td>
                        <td> : Rp. </td>
                        <td align="right">'."".number_format($value[value],0,",",".").'</td>
                      </tr>';
                }
            }
          }
          else{
            echo '<tr>
                      <td width="21%"></td>
                      <td width="40%">'.$item.'</td>
                      <td> : Rp. </td>
                      <td align="right">'."".number_format($total,0,",",".").'</td>
                    </tr>';

          }
          echo '<tr>
                  <td ></td>
                  <td >'."PPh. ".$det['pajak']."  %".'</td>
                  <td> : Rp. </td>
                  <td align="right">'." ".number_format($pph,0,",",".").'</td>
                </tr>';
          echo '<tr>
                  <td ></td>
                  <td >'."Diterima ".'</td>
                  <td> : Rp. </td>
                  <td align="right">'."".number_format($diterima,0,",",".").'</td>
                </tr>';
           echo  '</table>';
        
        
        echo '<br></br>
              <table style="text-align: center; width: 100%; font-size:0.7em;"  >
          
              <tr>
                <td style="text-align: center;"> Mengetahui/Setuju dibayar  </td>
                <td style="text-align: center;">Lunas Dibayar</td>
                <td style="text-align: center;">'.$lokasi.', '.$this->konversi_tanggal($tanggal_akhir,"").'</td>
              </tr>              
              <tr>
                <td style="text-align: center;">Pejabat Pembuat Komitmen,</td>
                <td style="text-align center;">Tgl '.'...........................'.'</td>
                <td style="text-align: center;">Penerima</td>
              </tr>
              <tr>
                <td></td>
                <td>Bendahara Pengeluaran Pembantu,</td>
                <td></td>
              </tr>
               <tr>
                <td colspan="3"><br></br> <br></br> <br></br></td>
              </tr>
              <tr>
                <td style="text-align: center;">'.$det['ppk'].'</td>
                <td style="text-align: center;">'.$det['bpp'].'</td>
                <td style="text-align: center;">'.'('.$penerima.')'.'</td>
              </tr>              
              <tr>
                <td style="text-align: center;">NIP'.$det['nip_ppk'].'</td>
                <td style="text-align: center;">NIP'.$det['nip_bpp'].'</td>
                <td style="text-align: center;"></td>
              </tr>
              </table>';
              echo '<p>__ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __</p>';

                echo '<table style=" text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;  font-size:0.7em; font-family:serif; "  align="center">
                <tr>
                    <td rowspan="4" width="13%"><img src="<../../static/dist/img/dirjenpajak.png" height="8%" /></td>
                    <td style= "vertical-align: bottom;">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</td>
                    
                </tr>
                <tr>
                    <td style= "vertical-align: bottom;">DIREKTORAT JENDERAL PAJAK </td>
                </tr>
                <tr>
                    <td style= "vertical-align: bottom;" style=" font-weight:bold; text-align: center;">BUKTI PEMOTONGAN PPh pasal 21</td>
                </tr>  
                <tr>
                    <td style= "vertical-align: bottom;" style="  font-weight:bold; text-align: center;" >Nomor : '.$nmr_kw."/".$det['kdgiat'].".".$det['kdoutput'].".".$det['kdsoutput'].".".$det['kdkmpnen']."/2016".'</td>
                </tr>                
                
                </table>';
        echo '  <table style="width: 100%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left" width="17%">Nama Wajib Pajak </td>
                        <td align="left">:'.$penerima.' </td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">NPWP</td>
                        <td align="left">:'.$det[npwp].'</td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">Alamat</td>
                        <td align="left">: </td>
                    </tr>                             
                  </table>
                  <br></br>';
        echo '<table style="text-align: left; width: 100%; font-size:0.7em;"  >
              <tr>
                <td > Penghasilan </td>
                <td width="20%">Jumlah</td>
                <td width="20%">Tarif</td>
                <td width="20%">Pph yang dipotong</td>
              </tr>';
        $no=1;
        $tot_pot=(15/100)*$val;
        foreach ($data as $value) {
          if($value[kdakun]==$kd_akun and $value[kdakun]!== "521213" and $value[kdakun]!== "522151"and $value[kdakun]!== "524114"and $value[kdakun]!== "524113"and $value[kdakun]!== "524119" ){
            $pot = (15/100)*$value[value];
            $tot_pot +=$pot;
            $det_item=explode("[",$value[NMITEM] );
            echo '<tr>
                    <td>'.$no.". ".$det_item[0].'</td>
                    <td>Rp. '.number_format($value[value],0,",",".").'</td>
                    <td>'.$det['pajak'].' %</td>
                    <td>'."Rp. ".number_format($det['pajak']/100*$value[value],0,",",".").'</td>
                  </tr>';
            $no++;
          }
          }
          if($item!==""){  
            echo '<tr>
                    <td>1.'.$item.'</td>
                    <td>Rp. '.number_format($val,0,",",".").'</td>
                    <td>'.$det['pajak'].' %</td>
                    <td>'."Rp. ".number_format($det['pajak']/100*$val,0,",",".").'</td>
                  </tr>
                ';
          }
          echo '</table>';
         echo '<table style="text-align: left; width: 100%; font-size:0.7em;"  >
              <tr>

                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: left;">'.$lokasi.', '.$this->konversi_tanggal($tanggal_akhir,"").'</td>
              </tr>

              <tr>

                <td style="text-align center;">Perhatian : </td>
                <td style="text-align: center;"></td>
                <td style="text-align: center; font-size:0.7em;">Pemotong Pajak :</td>
              </tr>
              <tr>

                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td width="27%" style="text-align: center; font-size:0.7em;">Nama  : Bendahara Pengeluaran Direktorat Jenderal Kelembagaann IPTEK dan DIKTI</td>
              </tr>

              <tr>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td width="27%" style="text-align: center; font-size:0.7em;">NPWP : 00.493.675.3-077.000</td>
              </tr>
              <tr>
                <td>
                  <br></br>
                  <br></br>
                  <br></br>
                  <br></br>
                </td>
              </tr>
              <tr >

                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Josephine Margaretta</td>
              </tr>
              <tr>

                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">NIP. 19870613 201012 2 009</td>
              </tr>



              </table>';
        
        // $html = ob_get_contents(); 
        // $this->create_pdf("Kw_Honor_Uang_Saku","A4",$html);
        
    }
 

public function daftar_peng_riil($result,$det){
  $direktorat = $det['kdgiat'];
  $asal=""; $tujuan=""; $alat_trans=""; $tiket=0; $airport_tax=0;
  $taxi_asal=0; $taxi_tujuan=0; $jml_hari=1; $uang_harian=0; $penerima; $jabatan; $tgl_mulai; $tgl_akhir;
  $jenis_transport="";

  foreach ($result as $val) {
    if($val[alat_trans]!="") $alat_trans = $val[alat_trans];
    if($val[kota_asal]!="") $asal = $val[kota_asal];
    if($val[kota_tujuan]!="") $tujuan = $val[kota_tujuan];
    if($val[harga_tiket]>0) $tiket = $val[harga_tiket];
    if($val[airport_tax]>0) $airport_tax = $val[airport_tax];
    if($val[taxi_asal]>0)   $taxi_asal = $val[taxi_asal];
    if($val[taxi_tujuan]>0) $taxi_tujuan = $val[taxi_tujuan];
    if($val[lama_hari]>0)   $jml_hari = $val[lama_hari];
    if($val[uang_harian]>0) $uang_harian = $val[uang_harian];
    if($val[tgl_mulai]!="") $tgl_mulai = $this->konversi_tanggal($val[tgl_mulai],"");
    if($val[tgl_akhir]!="") $tgl_akhir = $this->konversi_tanggal($val[tgl_akhir],"");  
    $penerima = $val['penerima'];
    $jabatan = $val['jabatan'];
               
  }
  if($val[harga_tiket]>0){
    $jenis_transport="Transportasi Udara";
  }
  else {
    $jenis_transport="Kendaraan Darat";
  }
  echo '<table style="text-align:center; width: 100%; ">
          <tr>
            <td width="24%" rowspan="5"><img src="'.$url_rewrite.'static/dist/img/risetdikti.png" height="15%" /></td>
            <td>KEMENTERIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</td>
          </tr>
          <tr>
            <td style="font-weight:bold">DIREKTORAT JENDERAL KELEMBAGAAN ILMU </td>
          </tr>
          <tr>
            <td style="font-weight:bold">PENGETAHUAN, TEKNOLOGI, DAN PENDIDIKAN TINGGI</td>
          </tr>
          <tr>
            <td style="font-size:0.8em">Jalan Jend. Sudirman Pintu I Senayan - Jakarta Pusat 10270 </td>
          </tr>
          <tr>
            <td style="font-size:0.8em">Telepon : (021) 57946063, Fax : (021) 57946062</td>
          </tr>
          <tr>
            <td style="border-bottom:3px solid; font-size:0.8em;"></td>
            <td style="border-bottom:3px solid; font-size:0.8em;">Laman : www.dikti.go.id</td>
          </tr>
          <tr>
            <td colspan ="2" style="text-decoration: underline; font-weight:bold;">DAFTAR PENGELUARAN RIIL</td>
          </tr>
        </table>';
      
  echo '<table style="width: 100%; text-align:left; border-collapse:collapse; font-size:0.9em;">
        <tr>
          <td style="" colspan="4"><br>Yang bertanda tangan dibawah ini :</br></td>
        </tr>
        <tr>
          <td width="2%"></td>
          <td width="20%">Nama</td>
          <td width="2%">:</td>
          <td>'.$penerima.'</td>
        </tr>
        <tr>
          <td></td>
          <td>Jabatan</td>
          <td>:</td>
          <td>'.$jabatan.'</td>
        </tr>
        <tr>
          <td colspan="4"> <br></br><br></br> </td>
        </tr>
        <tr>
          <td colspan="4">Berdasarkan Surat Perjalanan Dinas (SPD) Tanggal '.$tgl_mulai.' Nomor: ___________________________, dengan ini saya menyatakan dengan sesungguhnya bahwa:</td>
        </tr>
        <tr>
          <td colspan="4"><br></br><br></br></td>
        </tr>
        <tr>
          <td>1.</td>
          <td colspan="3">Biaya Transport dan pengeluaran yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi : </td>
        </tr>
        <tr>
          <td colspan="4"><br></br><br></br></td>
        </tr>
      </table>';

      echo '<table cellpadding="2" style="width: 100%; text-align:left; border-collapse:collapse; font-size:0.9em;">
              <tr>
                <td width="2%"></td>
                <td width="4%" style="border:1px solid; font-weight:bold; text-align:center;">No</td>
                <td style="border:1px solid; font-weight:bold; text-align:center;">Uraian</td>
                <td  style="border:1px solid; font-weight:bold; text-align:center;" colspan="2">Jumlah</td>
              </tr>

              ';
        $no=0;
        $total_rincian=0;
        if($tiket>0){    
          $no+=1;
          if($airport_tax>0){  
          echo '<tr>
                  <td></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$no.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Biaya '.$jenis_transport.'</td>
                  <td width="4">Rp. </td>
                  <td style="border-left:1px solid; border-right:1px solid; text-align:right;">'.number_format($tiket,0,",",".").'</td>
                </tr>';
          $total_rincian +=$tiket;
          } 
        }
        if($airport_tax>0){    
          $no+=1; 
          echo '<tr>
                  <td></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$no.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Airport Tax</td>
                  <td width="4">Rp. </td>
                  <td style="border-left:1px solid; border-right:1px solid; text-align:right;">Rp. '.number_format($airport_tax,0,",",".").'</td>
                </tr>';
          $total_rincian +=$airport_tax; 
          
        }
        if($taxi_asal>0){
          $no+=1;
          echo '<tr>
                  <td></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$no.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Biaya Taksi '.$asal.'</td>
                  <td width="4">Rp. </td>
                  <td style=" border-right:1px solid; text-align:right;">'.number_format($taxi_asal,0,",",".").'</td>
                </tr>';
          $total_rincian +=$taxi_asal; 

        }
        if($taxi_tujuan>0){
          $no+=1;
          echo '<tr>
                  <td></td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.$no.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">Biaya Taxi '.$tujuan.'</td>
                  <td width="4">Rp. </td>
                  <td style="border-bottom:1px solid; border-right:1px solid; text-align:right;">'.number_format($taxi_tujuan,0,",",".").'</td>
                </tr>';
          $total_rincian +=$taxi_tujuan; 
        }
        echo '<tr>
                  <td></td>
                  <td style="border:1px solid;" colspan="2">Jumlah</td>
                  <td width="4" style="border-bottom:1px solid; border-top:1px solid;">Rp. </td>
                  <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right;">'.number_format($total_rincian,0,",",".").'</td>
                </tr>';
          
      echo '<tr>
              <td> <br></br><br></br> </td>
              <td style="border-top:1px solid;" colspan="3"> <br></br><br></br> </td>
            </tr>
            <tr>
              <td>2.</td>
              <td colspan="3">Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan Perjalanan Dinas dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran, saya bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara.</td>
            </tr>
            ';


  echo  '</table>';
// $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$direktorat' ");
//       $arr_pb = $this->fetch_array($result_pb);
      $bpp = $det['bpp'];
      $nip_bpp = $det['nip_bpp'];
      $ppk = $det['ppk'];
      $nip_ppk = $det['nip_ppk'];
      $date = getdate();
      echo '<table  style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
        <tr>
          <td colspan="2"><br></br></td>
        </tr>
        <tr>
          <td width="60%">Mengetahui</td>
          <td>Jakarta, '.$this->konversi_tanggal($tgl_akhir).'</td>
        </tr>
        <tr>
          <td>Pejabat Pembuat Komitmen</td>
          <td>Yang Melaksanakan</td>
        </tr>
        <tr>
          <td><br></br><br></br><br></br></td>
          <td><br></br><br></br><br></br></td>
        </tr>
        <tr>
          <td style="font-weight:bold">'.$ppk.'</td>
          <td>'.$penerima.'</td>
        </tr>
        
        <tr>
          <td>NIP. '.$nip_ppk.'</td>
          <td></td>
        </tr>
      </table>';

}
    public function pengajuan_UMK($data) {
      $uang_harian_saku=0;
      $honorarium=0;
      $Akomodasi=0;
      $taxi_lokal=0;
      $tiket=0;
      $lain2=0;
      $tot=0;
      $sql = "SELECT rab.tanggal, rab.lama_hari, rab.deskripsi, rab.lokasi, rab.rabview_id, rab.penerima, rab.kdprogram, rab.kdgiat, rab.kdoutput, rab.kdsoutput, rab.kdkmpnen, rab.kdakun, rab.taxi_asal, rab.taxi_tujuan, rab.harga_tiket, rkkl.NMGIAT, rab.value, rab.uang_muka, rab.uang_harian, rab.uang_saku, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdsoutput = rkkl.KDSOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and  rab.kdskmpnen = rkkl.KDSKMPNEN and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rabview_id='$data' ";
      // print_r($sql);
      $result = $this->query($sql);
      $res2 = $this->fetch_array($result);
      // print_r($res);
      $direktorat=$res2['kdgiat'];
      foreach($result as $rs) {

              if(substr($rs[NMITEM],1,8)=="ransport" or $rs[taxi_tujuan]>0 or $rs[taxi_asal]>0){
                $taxi_lokal += $rs[taxi_asal]+$rs[taxi_tujuan];
              }

              if(substr($rs[NMITEM],1,3)=="ang" or $rs[uang_harian]>0 or $rs[uang_saku]>0){
                $uang_harian_saku += ($rs[uang_harian]*$rs[lama_hari])+$rs[uang_saku];
              }

              if(substr($rs[NMITEM],1,3)=="ang" and ($rs[uang_harian]==0.0 or $rs[uang_saku]==0.0)){
                $uang_harian_saku += $rs[value];
              }
              if(substr($rs[NMITEM],1,4)=="onor" or $rs[NMAKUN]=="Belanja Jasa Profesi")
              {
                $honorarium += $rs[value];
              }
              if(substr($rs[NMITEM],1,4)=="iket" or $rs[harga_tiket]>0 ){
                $tiket += $rs[harga_tiket];
              }
              
              if((substr($rs[NMITEM],1,8)!="ransport" and $rs[taxi_tujuan]==0 and $rs[taxi_asal]==0) and (substr($rs[NMITEM],1,3)!="ang" and $rs[uang_harian]==0.00 and $rs[uang_saku]==0.00) and (substr($rs[NMITEM],1,4)!="onor") and (substr($rs[NMITEM],1,4)!="iket" and $rs[harga_tiket]==0.00 ) and $rs[NMAKUN]!="Belanja Jasa Profesi"){
                // $taxi_lokal += $rs[taxi_asal]+$rs[taxi_tujuan];
                $lain2+= $rs[value];
              }
             
             
               

        }
         $tot   += $taxi_lokal+$uang_harian_saku+$honorarium+$tiket+$lain2;

      $result_pb = $this->query("SELECT bpp, nip_bpp, ppk, nip_ppk from direktorat where kode='$direktorat' ");
      $arr_pb = $this->fetch_array($result_pb);
      $bpp = $arr_pb[bpp];
      $nip_bpp = $arr_pb[nip_bpp];
      $ppk = $arr_pb[ppk];
      $nip_ppk = $arr_pb[nip_ppk];
      ob_start();
      echo  '<table  cellpadding="3" style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.85em;">
            <tr>
              <td style="text-align:center;" colspan="6"><h4>PENGAJUAN UANG MUKA KERJA (UMK)</h4> </td>
            </tr>
            <tr>
              <td style="text-align:center;" colspan="6"><h4>RINCIAN KEBUTUHAN DANA</h4></td>
            </tr>
            <tr>
              <td colspan="4"><br></br><br></br></td>
            </tr>
              <tr>
                <td>1</td>
                <td>Satker</td>
                <td>:</td>
                <td colspan="3">Direktorat Jenderal Kelembagaan Ilmu Pengetahuan Teknologi dan Pendidikan Tinggi</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Kegiatan</td>
                 <td>:</td>
                <td colspan="3">'.$res2[NMGIAT].'</td>               
              </tr>
              <tr>
                <td>3</td>
                <td>Output</td>
                 <td>:</td>
                <td colspan="3">'.$res2[NMOUTPUT].'</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Komponen Input</td>
                 <td>:</td>
                <td colspan="3">'.$res2[NMKMPNEN].'</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Sub Komponen</td>
                <td>:</td>
                <td colspan="3">'.$res2[NMSKMPNEN].'</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Tujuan Pekerjaan</td>
                <td>:</td>
                <td colspan="3">'.$res2[deskripsi].'</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Waktu Pelaksanaan</td>
                <td>:</td>
                <td colspan="3">'.$this->konversi_tanggal($res2[tanggal]).'</td>
                
              </tr>
              <tr>
                <td>8</td>
                <td>Tempat pelaksanaan</td>
                <td>:</td>
                <td colspan="3">'.$res2[lokasi].'</td>
              </tr>
              <tr>
                <td>9</td>
                <td>Kebutuhan Biaya</td>
                <td>:</td>
                <td>1. Uang Harian / Uang Saku</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($uang_harian_saku,2,",",".").'</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>2. Honorarium</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($honorarium,2,",",".").'</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>3. Akomodasi</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($Akomodasi,2,",",".").'</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>4. Taxi / transport lokal</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($taxi_lokal,2,",",".").'</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>5. Tiket</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($tiket,2,",",".").'</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>6. Lain-lain</td>
                <td>: Rp.</td>
                <td align="right">'.number_format($lain2,2,",",".").'</td>
              </tr>
              ';
              // $no=1;
              // $tot=0;
        // foreach($result as $rs) {

        //  echo '<tr>
        //         <td></td>
        //         <td></td>
        //         <td></td>
        //         <td>'.$no.". ".$rs[NMITEM].'</td>
        //         <td>: Rp. </td>
        //         <td>'.number_format($rs[value],0,",",".").'</td>
        //       </tr>';
        //       $no++;
        //       $tot+=$rs[value];
        // }
        echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight:bold;">JUMLAH</td>
                <td style="font-weight:bold;">: Rp. </td>
                <td align="right" style="font-weight:bold;">'.number_format($tot,2,",",".").'</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Penanggung Jawab kegiatan</td>
                <td>:</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>11</td>
                <td>Waktu Penyelesaian SPJ</td>
                <td>:</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Jakarta, '.$this->konversi_tanggal($res2[tanggal]).'</td>
              </tr>
              </table>
              <table cellpadding="3" style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.85em;">
              <tr>
                <td></td>
                <td style="border: 1px solid black; " >Kuasa Pengguna Anggaran</td>
                <td></td>
                <td style="border: 1px solid black;">Bendahara Pengeluaran</td>
                <td></td>
                <td style="border: 1px solid black;">Pejabat Pembuat Komitmen</td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td  style="border-left: 1px solid black; border-right: 1px solid black;"></td>
                <td></td>
                <td style="border-left: 1px solid black; border-right: 1px solid black;"></td>
                <td></td>
                <td style="border-left: 1px solid black; border-right: 1px solid black;"></td>
              </tr> 
              <tr>
                <td></td>
                <td style="border-left: 1px solid black; border-right: 1px solid black;">Agus Indrajo</td>
                <td></td>
                <td style="border-left: 1px solid black;  border-right: 1px solid black;">Josephine Margaretta</td>
                <td ></td>
                <td style="border-left: 1px solid black; border-right: 1px solid black;">'.$ppk.'</td>
              </tr> 
              <tr>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;">NIP. 19600505 198703 1 001</td>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">NIP. 19870613 201012 2 009</td>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;">NIP. '.$nip_ppk.'</td>
              </tr>
            </table>';
            $html = ob_get_contents();
            $this->create_pdf("Pengajuan UMK","A4",$html);
      
    }

    public function realisasi_daya_serap($dir, $tanggal ) {
      // $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, value  FROM rabfull group by kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun order by kdgiat asc, kdoutput asc, kdsoutput asc, kdkmpnen asc, kdskmpnen asc, kdakun asc ";
      $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, NMAKUN,  sum(jumlah) as jumlah  FROM rkakl_full where kdgiat like '%$dir%' group by kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun order by kdgiat asc, kdoutput asc, kdsoutput asc, kdkmpnen asc, kdskmpnen asc, kdakun asc ";
      $res = $this->query($sql);
      ob_start();
      echo '<table style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.95em;">
                <tr>
                  <td colspan="15" style="text-align:center; font-weight:bold">LAPORAN REALISASI DAYA SERAP PER KEGIATAN</td>
                </tr>
                <tr>
                  <td colspan="2">Nama Satker</td>
                  <td align="left" width="2%">:</td>
                  <td align="left" > Direktorat Jenderal Kelembagaan Iptek dan Dikti</td>
                  
                </tr>
                <tr>
                  <td colspan="2">Kode Kegiatan</td>
                  <td>:</td>
                  <td align="left">401196</td>
                </tr>
                <tr>
                  <td colspan="2">Nomor Tanggal DIPA</td>
                  <td>:</td>
                  <td  align="left">DIPA-042-03.1.401196/2016, tgl. 7 Desember 2016</td>
                </tr>
                <tr>
                  <td colspan="2">Propinsi DKI</td>
                  <td>:</td>
                  <td align="left">DKI</td> 
                <tr>
                  <td colspan="2">Departemen</td>
                  <td>:</td>
                  <td align="left">Kementerian Ristek dan Dikti</td>
                </tr>
                </tr>
                <tr>
                  <td colspan="2">Program</td>
                  <td>:</td>
                  <td align="left">Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</td>
                </tr>
                <tr>
                  <td colspan="2">Jumlah Anggaran</td>
                  <td>:</td>
                  <td  align="left">-</td>
                </tr>
                <tr>
                  <td colspan="2">Kemajuan Fisik (%)</td>
                  <td>:</td>
                  <td align="left">-</td>
                </tr>
                <tr>
                  <td colspan="2">Kemajuan Keu. (%)</td>
                  <td>:</td>
                  <td align="left">-</td>
                </tr>
                
                </table>';

      echo '<table  style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.75em;">
              <tr>
                <td rowspan="2" style="text-align:center; border:1px solid;">No. Kode</td>
                <td rowspan="2" colspan="2" style="text-align:center; border:1px solid;">Uraian Kegiatan/Jenis Pengeluaran</td>
                <td rowspan="2" style="text-align:center; border:1px solid; ">Volume Kegiatan</td>
                <td rowspan="2" style="text-align:center; border:1px solid; ">Alokasi Dana Dalam DIPA</td>
                <td colspan="3" style="text-align:center; border:1px solid;">Jumlah Pengeluaran s/d Bulan Lalu</td>
                <td colspan="3" style="text-align:center; border:1px solid;">Jumlah Pengeluaran Bulan Ini </td>
                <td rowspan="2" style="text-align:center; border:1px solid;">Jumlah Pengeluaran</td>
                <td rowspan="2" style="text-align:center; border:1px solid;">Sisa Anggaran</td>
                <td colspan="2" style="text-align:center; border:1px solid;">Presentasi Daya Serap</td>
              </tr>
              <tr>
                <td style="text-align:center; border:1px solid;">SP2D LS</td>
                <td style="text-align:center; border:1px solid;">SP2D GU</td>
                <td style="text-align:center; border:1px solid;">Jumlah</td>
                <td style="text-align:center; border:1px solid;">SPM LS</td>
                <td style="text-align:center; border:1px solid;">SPM GU</td>
                <td style="text-align:center; border:1px solid;">Jumlah</td>
                <td style="text-align:center; border:1px solid;">%Fisik</td>
                <td style="text-align:center; border:1px solid;">%keu</td>
              </tr>';
      $kd_dir=""; $kdout=""; $kdsout=""; $kdkmp=""; $kdskmp="";
      $acc_alokasi = 0;
      $acc_sp2d_ls_lalu = 0;
      $acc_sp2d_gu_lalu = 0;
      $acc_sp2d_lalu = 0;
      $acc_sp2d_ls_ini = 0;
      $acc_sp2d_gu_ini = 0;
      $acc_sp2d_ini = 0;
      $acc_sisa_ang = 0;
      foreach ($res as $value) {
        if($kd_dir!=$value['kdgiat']){
          $nmdir = $this->get_nama($value['kdgiat']);
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          $acc_alokasi += $nmdir['jumlah'];
          $acc_sp2d_ls_lalu += 0;
          $acc_sp2d_gu_lalu += $nilai['jml_lalu'];
          $acc_sp2d_lalu += $nilai['jml_lalu'];
          $acc_sp2d_ls_ini = 0;
          $acc_sp2d_gu_ini += $nilai['jumlah'];
          $acc_sp2d_ini += $nilai['jumlah'];
          $acc_sisa_ang += $sisa;
          echo '<tr>
                  <td colspan="15" style="border-bottom:1px solid"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="left" >'.$value['kdgiat'].'</td>
                  <td style="border-left:1px solid; font-weight:bold; " colspan="2">'.$nmdir['kdgiat'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout!=$value['kdoutput'])){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'] );
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="center">'.$value['kdoutput'].'</td>
                  <td style="border-left:1px solid; font-weight:bold;" colspan="2">'.$nmdir['kdout'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput'] and $kdsout!=$value['kdsoutput']) or ($kd_dir==$value['kdgiat'] and $kdout!=$value['kdoutput'])  or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout!=$value['kdsoutput'] ) ){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'], $value['kdsoutput'] );
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput'], $value['kdsoutput'] );
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="center">'.''.'</td>
                  <td style="border-left:1px solid; font-weight:bold;" colspan="2">'.$value['kdsoutput']."  ".$nmdir['kdsout'].'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if((($kd_dir!=$value['kdgiat'] or $kd_dir==$value['kdgiat']) and $kdout!=$value['kdoutput'] and ($kdsout!=$value['kdsoutput'] or $kdsout==$value['kdsoutput']) and $kdkmp!=$value['kdkmpnen']) or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout!=$value['kdsoutput']) or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout==$value['kdsoutput'] and $kdkmp!=$value['kdkmpnen'] ) ){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'], $value['kdsoutput'], $value['kdkmpnen'] );
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput'], $value['kdsoutput'], $value['kdkmpnen'] );
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid;"  align="center">'.''.'</td>
                  <td style="border-left:1px solid; font-weight:bold;" colspan="2">'.$value['kdkmpnen']." ".$nmdir['kdkmp'].'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if((($kd_dir!=$value['kdgiat'] or $kd_dir==$value['kdgiat']) and ($kdout!=$value['kdoutput'] or $kdout==$value['kdoutput']) and ($kdsout!=$value['kdsoutput'] or $kdsout==$value['kdsoutput']) and ($kdkmp!=$value['kdkmpnen'] ) and ($kdskmp!=$value['kdskmpnen'] or $kdskmp==$value['kdskmpnen'])) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout==$value['kdsoutput'] and $kdkmp==$value['kdkmpnen'] and $kdskmp!=$value['kdskmpnen'] ) ){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'], $value['kdsoutput'], $value['kdkmpnen'], $value['kdskmpnen'] );
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput'], $value['kdsoutput'], $value['kdkmpnen'], $value['kdskmpnen'], $value['kdakun'] );
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
           echo '<tr>
                  <td style="border-left:1px solid" align="center">'.''.'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style=" font-weight:bold;" colspan="1">'.$value['kdskmpnen']."  ".$nmdir['kdskmp'].'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }
          $kd_dir = $value['kdgiat'];
          $kdout = $value['kdoutput'];
          $kdsout = $value['kdsoutput'];
          $kdkmp = $value['kdkmpnen'];
          $kdskmp = $value['kdskmpnen'];
          
         // if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput'] and $kdsout!=$value['kdsoutput'] and $kdkmp!=$value['kdkmpnen'] and $kdskmp!=$value['kdskmpnen']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout==$value['kdsoutput'] and $kdkmp==$value['kdkmpnen'] and $kdskmp==$value['kdskmpnen'] ) ){
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput'], $value['kdsoutput'], $value['kdkmpnen'], $value['kdskmpnen'], $value['kdakun']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $value['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid" align="center">'.''.'</td>
                  <td style="border-left:1px solid"  colspan="2">'.$value['kdakun']." ".$value['NMAKUN'].'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid; text-align:right;">'.number_format($value['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
          
      // }
      }
      echo '<tr>
              
              <td style="border:1px solid; text-align:center;" colspan="4">'.'TOTAL'.'</td>
              <td style="border:1px solid; text-align:right;">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_alokasi,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; ">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_sp2d_lalu,2,",",".").'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold; ">'.number_format($acc_sp2d_ini,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_tot_spp,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold; ">'.number_format($acc_sisa_ang,2,",",".").'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid; border-right:1px solid;">'.'-'.'</td>
            </tr>';
      echo '<tr>
              <td colspan="15" style="border-top:1px solid"></td>
            </tr>';
      echo '</table>';
      $html = ob_get_contents();
      ob_clean();
      $this->create_pdf("Realisasi Per Kegiatan","A4-L",$html);
    }

    public function rekap_realisasi_daya_serap($dir, $tanggal ) {
      // $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, value  FROM rabfull group by kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun order by kdgiat asc, kdoutput asc, kdsoutput asc, kdkmpnen asc, kdskmpnen asc, kdakun asc ";
      $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, NMAKUN,  jumlah  FROM rkakl_full where kdgiat like '%$dir%' group by kdgiat, kdoutput, kdakun order by kdgiat asc, kdoutput asc, kdakun asc ";
      $res = $this->query($sql);
      ob_start();
      echo '<table style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.95em;">
                <tr>
                  <td colspan="15" style="text-align:center; font-weight:bold">LAPORAN REALISASI DAYA SERAP PER KEGIATAN</td>
                </tr>
                <tr>
                  <td colspan="2">Nama Satker</td>
                  <td align="left" width="2%">:</td>
                  <td align="left" > Direktorat Jenderal Kelembagaan Iptek dan Dikti</td>
                  
                </tr>
                <tr>
                  <td colspan="2">Kode Kegiatan</td>
                  <td>:</td>
                  <td align="left">401196</td>
                </tr>
                <tr>
                  <td colspan="2">Nomor Tanggal DIPA</td>
                  <td>:</td>
                  <td  align="left">DIPA-042-03.1.401196/2016, tgl. 7 Desember 2016</td>
                </tr>
                <tr>
                  <td colspan="2">Propinsi DKI</td>
                  <td>:</td>
                  <td align="left">DKI</td> 
                <tr>
                  <td colspan="2">Departemen</td>
                  <td>:</td>
                  <td align="left">Kementerian Ristek dan Dikti</td>
                </tr>
                </tr>
                <tr>
                  <td colspan="2">Program</td>
                  <td>:</td>
                  <td align="left">Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</td>
                </tr>
                <tr>
                  <td colspan="2">Jumlah Anggaran</td>
                  <td>:</td>
                  <td  align="left">-</td>
                </tr>
                <tr>
                  <td colspan="2">Kemajuan Fisik (%)</td>
                  <td>:</td>
                  <td align="left">-</td>
                </tr>
                <tr>
                  <td colspan="2">Kemajuan Keu. (%)</td>
                  <td>:</td>
                  <td align="left">-</td>
                </tr>
                
                </table>';

      echo '<table  style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.75em;">
              <tr>
                <td rowspan="2" style="text-align:center; border:1px solid;">No. Kode</td>
                <td rowspan="2" colspan="2" style="text-align:center; border:1px solid;">Uraian Kegiatan/Jenis Pengeluaran</td>
                <td rowspan="2" style="text-align:center; border:1px solid; ">Volume Kegiatan</td>
                <td rowspan="2" style="text-align:center; border:1px solid; ">Alokasi Dana Dalam DIPA</td>
                <td colspan="3" style="text-align:center; border:1px solid;">Jumlah Pengeluaran s/d Bulan Lalu</td>
                <td colspan="3" style="text-align:center; border:1px solid;">Jumlah Pengeluaran Bulan Ini </td>
                <td rowspan="2" style="text-align:center; border:1px solid;">Jumlah Pengeluaran</td>
                <td rowspan="2" style="text-align:center; border:1px solid;">Sisa Anggaran</td>
                <td colspan="2" style="text-align:center; border:1px solid;">Presentasi Daya Serap</td>
              </tr>
              <tr>
                <td style="text-align:center; border:1px solid;">SP2D LS</td>
                <td style="text-align:center; border:1px solid;">SP2D GU</td>
                <td style="text-align:center; border:1px solid;">Jumlah</td>
                <td style="text-align:center; border:1px solid;">SPM LS</td>
                <td style="text-align:center; border:1px solid;">SPM GU</td>
                <td style="text-align:center; border:1px solid;">Jumlah</td>
                <td style="text-align:center; border:1px solid;">%Fisik</td>
                <td style="text-align:center; border:1px solid;">%keu</td>
              </tr>';
      $kd_dir=""; $kdout=""; $kdsout=""; $kdkmp=""; $kdskmp="";
      $acc_alokasi = 0;
      $acc_sp2d_ls_lalu = 0;
      $acc_sp2d_gu_lalu = 0;
      $acc_sp2d_lalu = 0;
      $acc_sp2d_ls_ini = 0;
      $acc_sp2d_gu_ini = 0;
      $acc_sp2d_ini = 0;
      $acc_sisa_ang = 0;
      foreach ($res as $value) {
        if($kd_dir!=$value['kdgiat']){
          $nmdir = $this->get_nama($value['kdgiat']);
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          $acc_alokasi += $nmdir['jumlah'];
          $acc_sp2d_ls_lalu += 0;
          $acc_sp2d_gu_lalu += $nilai['jml_lalu'];
          $acc_sp2d_lalu += $nilai['jml_lalu'];
          $acc_sp2d_ls_ini = 0;
          $acc_sp2d_gu_ini += $nilai['jumlah'];
          $acc_sp2d_ini += $nilai['jumlah'];
          $acc_sisa_ang += $sisa;
          echo '<tr>
                  <td colspan="15" style="border-bottom:1px solid"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="left" >'.$value['kdgiat'].'</td>
                  <td style="border-left:1px solid; font-weight:bold; " colspan="2">'.$nmdir['kdgiat'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout!=$value['kdoutput'])){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'] );
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="center">'.$value['kdoutput'].'</td>
                  <td style="border-left:1px solid; font-weight:bold;" colspan="2">'.$nmdir['kdout'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nmdir['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        
          $kd_dir = $value['kdgiat'];
          $kdout = $value['kdoutput'];
          $kdsout = $value['kdsoutput'];
          $kdkmp = $value['kdkmpnen'];
          $kdskmp = $value['kdskmpnen'];
          
         // if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput'] and $kdsout!=$value['kdsoutput'] and $kdkmp!=$value['kdkmpnen'] and $kdskmp!=$value['kdskmpnen']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout==$value['kdoutput'] and $kdsout==$value['kdsoutput'] and $kdkmp==$value['kdkmpnen'] and $kdskmp==$value['kdskmpnen'] ) ){
          
          $nilai = $this->get_realisasi($tanggal, $value['kdgiat'], $value['kdoutput'], 0, 0, 0, $value['kdakun']);
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $value['jumlah']-$jml;
          echo '<tr>
                  <td style="border-left:1px solid" align="center">'.''.'</td>
                  <td style="border-left:1px solid"  colspan="2">'.$value['kdakun']." ".$value['NMAKUN'].'</td>
                  <td style="border-left:1px solid;">'.''.'</td>
                  <td style="border-left:1px solid; text-align:right;">'.number_format($value['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($nilai['jml_lalu'],2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($nilai['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($jml,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
          
      // }
    }
      echo '<tr>
              
              <td style="border:1px solid; text-align:center;" colspan="4">'.'TOTAL'.'</td>
              <td style="border:1px solid; text-align:right;">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_alokasi,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; ">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_sp2d_lalu,2,",",".").'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold; ">'.number_format($acc_sp2d_ini,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold;">'.number_format($acc_tot_spp,2,",",".").'</td>
              <td style="border:1px solid; text-align:right; font-weight:bold; ">'.number_format($acc_sisa_ang,2,",",".").'</td>
              <td style="border:1px solid;">'.'-'.'</td>
              <td style="border:1px solid; border-right:1px solid;">'.'-'.'</td>
            </tr>';
      echo '<tr>
              <td colspan="15" style="border-top:1px solid"></td>
            </tr>';
      echo '</table>';
      $html = ob_get_contents();
      ob_clean();
      $this->create_pdf("Pengajuan UMK","A4-L",$html);
    }

    public function rekap_total($dir, $tanggal ) {
      // $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, value  FROM rabfull group by kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun order by kdgiat asc, kdoutput asc, kdsoutput asc, kdkmpnen asc, kdskmpnen asc, kdakun asc ";
      $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, NMAKUN,  jumlah  FROM rkakl_full where kdgiat like '%$dir%' group by kdgiat, kdoutput order by kdgiat asc, kdoutput asc";
      $res = $this->query($sql);
      ob_start();
       
  

      echo '<table style="width: 100%;  text-align:left; border-collapse:collapse; font-size:0.7em;">
              <tr>
                <td colspan="20" style="font-size:1em; font-weight:bold; text-align:center;">Laporan Realisasi Daya Serap Pelaksanaan DIPA TA 2016</td>
              </tr>
              <tr>
                <td colspan="20" style="font-size:1em; font-weight:bold; text-align:center;">Bulan :  '.''.' 2016</td>
              </tr>
              <tr>
                <td colspan="20" style="font-size:1em; font-weight:bold; text-align:center;"> Direktorat Jenderal Kelembagaan Ilmu Pengetahuan Teknologi dan Pendidikan Tinggi</td>
              </tr>
              <tr>
                <td colspan="20" style="font-size:1em; font-weight:bold; text-align:center;">Satker Ditjen Kelembagaan Iptek dan Dikti</td>
              </tr>
              <tr>
                <td colspan="20"><br></br></td>
              </tr>
              <tr>
              <td rowspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Kode Satker'."\n".'/keg/'."\n".'sub keg</td>
              <td rowspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Uraian Satker/'."\n".'Kegiatan/'."\n".'Sub Kegiatan</td>
              <td colspan="3" style="font-weight:bold; text-align:center; border:1px solid; ">Sasaran</td>
              <td rowspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Sumber Dana</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Belanja Pegawai</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Belanja Barang</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Belanja Modal</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Belanja Bantuan Sosial</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Jumlah</td>
              <td colspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Presentase Daya Serap</td>
              <td rowspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Sisa Anggaram</td>
              <td rowspan="2" style="font-weight:bold; text-align:center; border:1px solid; ">Ket</td>
            </tr>
            <tr>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Satuan</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Sasaran</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Alokasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Alokasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid;">Alokasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Alokasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Alokasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">Realisasi</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">% Fisik</td>
              <td style="font-weight:bold; text-align:center; border:1px solid; ">% Keu</td>
             </tr>';
      $kd_dir=""; $kdout=""; $kdsout=""; $kdkmp=""; $kdskmp="";
      $tot_dipa_51 = 0;
      $tot_dipa_52 = 0;
      $tot_dipa_53 = 0;
      $tot_dipa_57 = 0;
      $tot_nilai_51 = 0;
      $tot_nilai_52 = 0;
      $tot_nilai_53 = 0;
      $tot_nilai_57 = 0;
      $tot_sisa=0;
      $acc_alokasi = 0;

      foreach ($res as $value) {
        if($kd_dir!=$value['kdgiat']){
          $nmdir = $this->get_nama($value['kdgiat']);
          $dipa_51 = $this->get_nama($value['kdgiat'],"","","","","51");
          $dipa_52 = $this->get_nama($value['kdgiat'],"","","","","52");
          $dipa_53 = $this->get_nama($value['kdgiat'],"","","","","53");
          $dipa_57 = $this->get_nama($value['kdgiat'],"","","","","57");
          $nilai_51 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"51");
          $nilai_52 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"52");
          $nilai_53 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"53");
          $nilai_57 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"57");
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          $jml_dipa = $dipa_51['jumlah']+$dipa_52['jumlah']+$dipa_53['jumlah']+$dipa_57['jumlah'];
          $jml_nilai = $nilai_51['jumlah']+$nilai_52['jumlah']+$nilai_53['jumlah']+$nilai_57['jumlah'];
          $tot_dipa_51 += $dipa_51['jumlah'];
          $tot_dipa_52 += $dipa_52['jumlah'];
          $tot_dipa_53 += $dipa_53['jumlah'];
          $tot_dipa_57 += $dipa_57['jumlah'];
          $tot_nilai_51 += $nilai_51['jumlah'];
          $tot_nilai_52 += $nilai_52['jumlah'];
          $tot_nilai_53 += $nilai_53['jumlah'];
          $tot_nilai_57 += $nilai_57['jumlah'];
          $tot_sisa+=$jml_dipa-$jml_nilai;
          $acc_alokasi += $jml_dipa;

          $acc_sisa_ang += $sisa;
          echo '<tr>
                  <td colspan="20" style="border-bottom:1px solid"></td>
                </tr>';
          echo '<tr>
                  <td style="border-left:1px solid; font-weight:bold;" align="center" >'.$value['kdgiat'].'</td>
                  <td style="border-left:1px solid; font-weight:bold; " >'.$nmdir['kdgiat'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'RM'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($dipa_51['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($nilai_51['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($dipa_52['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai_52['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($dipa_53['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai_53['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($dipa_57['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($nilai_57['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml_dipa,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold;">'.number_format($jml_nilai,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right; font-weight:bold; ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout!=$value['kdoutput'])){
          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'],"","","","" );
          $dipa_51 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","51");
          $dipa_52 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","52");
          $dipa_53 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","53");
          $dipa_57 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","57");
          $nilai_51 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"51");
          $nilai_52 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"52");
          $nilai_53 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"53");
          $nilai_57 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"57");
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          
          $jml_dipa = $dipa_51['jumlah']+$dipa_52['jumlah']+$dipa_53['jumlah']+$dipa_57['jumlah'];
          $jml_nilai = $nilai_51['jumlah']+$nilai_52['jumlah']+$nilai_53['jumlah']+$nilai_57['jumlah'];
          $sisa=$jml_dipa-$jml_nilai;
         echo '<tr>
                  <td style="border-left:1px solid;" align="center" >'.$value['kdoutput'].'</td>
                  <td style="border-left:1px solid; " >'.$nmdir['kdout'].'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'-'.'</td>
                  <td style="border-left:1px solid;">'.'RM'.'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($dipa_51['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($nilai_51['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($dipa_52['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($nilai_52['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($dipa_53['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($nilai_53['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($dipa_57['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($nilai_57['jumlah'],2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($jml_dipa,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right; ">'.number_format($jml_nilai,2,",",".").'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.'-'.'</td>
                  <td style="border-left:1px solid; text-align:right;  ">'.number_format($sisa,2,",",".").'</td>
                  <td style="border-left:1px solid; border-right:1px solid;">'.'-'.'</td>
                </tr>';
        }

        
          $kd_dir = $value['kdgiat'];
          $kdout = $value['kdoutput']; 
      }
      echo '<tr>
        <td style="border:1px solid;" align="center" colspan="6">'.'TOTAL'.'</td>
        <td style="border:1px solid; text-align:right; ">'.number_format($tot_dipa_51,2,",",".").'</td>
        <td style="border:1px solid; text-align:right; ">'.number_format($tot_nilai_51,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_dipa_52,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_nilai_52['jumlah'],2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_dipa_53,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_nilai_53,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_dipa_57,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_nilai_57,2,",",".").'</td>
        <td style="border:1px solid; text-align:right; ">'.number_format($jml_dipa,2,",",".").'</td>
        <td style="border:1px solid; text-align:right; ">'.number_format($jml_nilai,2,",",".").'</td>
        <td style="border:1px solid; text-align:right;  ">'.'-'.'</td>
        <td style="border:1px solid; text-align:right;  ">'.'-'.'</td>
        <td style="border:1px solid; text-align:right;  ">'.number_format($tot_sisa,2,",",".").'</td>
        <td style="border:1px solid; border-right:1px solid;">'.'-'.'</td>
      </tr>';

      echo '<tr>
              <td colspan="15" style="border-top:1px solid"></td>
            </tr>';
      echo '</table>';
      $html = ob_get_contents();
      // ob_clean();
      $this->create_pdf("Pengajuan UMK","A4-L",$html);
    }

    function kekata($x) {
      $x = abs($x);
      $angka = array("", "satu", "dua", "tiga", "empat", "lima",
      "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
      $temp = "";
      if ($x <12) {
      $temp = " ". $angka[$x];
      } else if ($x <20) {
      $temp = $this->kekata($x - 10). " belas";
      } else if ($x <100) {
      $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
      } else if ($x <200) {
      $temp = " seratus" . $this->kekata($x - 100);
      } else if ($x <1000) {
      $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
      } else if ($x <2000) {
      $temp = " seribu" . $this->kekata($x - 1000);
      } else if ($x <1000000) {
      $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
      } else if ($x <1000000000) {
      $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
      } else if ($x <1000000000000) {
      $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
      } else if ($x <1000000000000000) {
      $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
      }
      return $temp;

    }

    function get_nama($kdgiat, $kdout, $kdsout, $kdkmp, $kdskmp, $kdakun){
      $q_out = $q_sout = $q_kmp = $q_skmp = $kd_akun = " ";
      if($kdout!=""){ 
        $q_out = " and KDOUTPUT='$kdout' "; 
        $k_out = " ,NMOUTPUT "; 
      }
      if($kdsout!=""){ 
        $q_sout = " and KDSOUTPUT='$kdsout' "; 
        $k_sout = " ,NMSOUTPUT "; 
      }
      if($kdkmp!=""){ 
        $q_kmp = " and KDKMPNEN='$kdkmp' ";  
        $k_kmp = " ,NMKMPNEN "; 
      }
      if($kdskmp!=""){ 
        $q_skmp = " and KDSKMPNEN='$kdskmp' "; 
        $k_skmp = " ,NMSKMPNEN "; 
      }
      if($kdakun!=""){ 
        $q_akun = " and KDAKUN='$kdakun' "; 
        $k_skmp = " ,NMAKUN ";
        if(strlen($kdakun)==2){
          $q_akun = " and kdakun like '$kdakun%' "; 
        }  
      }
      $query = " SELECT SUM(JUMLAH) as jumlah, NMGIAT ".$k_out." ".$k_sout." ".$k_kmp." ".$k_skmp." FROM rkakl_full WHERE kdgiat LIKE '%$kdgiat%' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun;
      
      
      $res = $this->query($query);
      $data = $this->fetch_array($res);

      $hasil = array(
                    "kdgiat" => $data['NMGIAT'],
                    "kdout" => $data['NMOUTPUT'],
                    "kdsout" => $data['NMSOUTPUT'],
                    "kdkmp" => $data['NMKMPNEN'],
                    "kdskmp" => $data['NMSKMPNEN'],
                    "kdakun" => $data['NMAKUN'],
                    "jumlah" => $data['jumlah']
                    );
      return $hasil;
    }

    function get_realisasi($tanggal, $kdgiat, $kdout, $kdsout, $kdkmp, $kdskmp, $kdakun)
     {
      $q_out = $q_sout = $q_kmp = $q_skmp = $kd_akun = "";
      if($kdout!=0){ 
        $q_out = " and kdoutput='$kdout' "; 
        $k_out = " ,NMOUTPUT "; 
      }
      if($kdsout!=0){ 
        $q_sout = " and kdsoutput='$kdsout' "; 
        $k_sout = " ,NMSOUTPUT "; 
      }
      if($kdkmp!=0){ 
        $q_kmp = " and kdkmpnen='$kdkmp' ";  
        $k_kmp = " ,NMKMPNEN "; 
      }
      if($kdskmp!=0){ 
        $q_skmp = " and kdskmpnen='$kdskmp' "; 
        $k_skmp = " ,NMSKMPNEN "; 
      }
      if($kdakun!=0){ 
        $q_akun = " and kdakun='$kdakun' "; 
        $k_skmp = " ,NMAKUN ";
        if(strlen($kdakun)==2){
          $q_akun = " and kdakun like '$kdakun%' "; 
        } 
        
      }
      // echo "akuns : ".$kdakun;
      $query = " SELECT SUM(case when month(tanggal)<'$tanggal' then value else 0 end) as jml_lalu, SUM(case when month(tanggal)='$tanggal' then value else 0 end) as jumlah FROM rabfull WHERE kdgiat LIKE '%$kdgiat%' ".$q_out.$q_sout.$q_kmp.$q_skmp.$q_akun;
      // print_r($query);
      
      $res = $this->query($query);
      $data = $this->fetch_array($res);

     $data = array(
              "jml_lalu" => $data['jml_lalu'],
              "jumlah" => $data['jumlah']
              );
      return $data;
    }

    function hitung_pagu($kdgiat, $kdakun){
      $sql = $this->query("SELECT sum(JUMLAH) as jml from rkakl_full where KDGIAT='$kdgiat' and KDAKUN like '$kdakun%' ");
      $data = $this->fetch_array($sql);
      return $data['jml'];
    }

    function konversi_tanggal($tgl,$type)
    {
      $data_tgl = explode("-",$tgl);
      $bulan ="";
      if($data_tgl[1]=="01")
            {
                $bulan="Januari";
            }        

            if($data_tgl[1]=="02")
            {
                $bulan="Februari";
            }

            if($data_tgl[1]=="03")
            {
                $bulan="Maret";
            }
            if($data_tgl[1]=="04")
            {
                $bulan="April";
            }
            if($data_tgl[1]=="05")
            {
                $bulan="Mei";
            }
            if($data_tgl[1]=="06")
            {
                $bulan="Juni";
            }
            if($data_tgl[1]=="07")
            {
                $bulan="Juli";
            }
            if($data_tgl[1]=="08")
            {
                $bulan="Agustus";
            }
            if($data_tgl[1]=="09")
            {
                $bulan="September";
            }
            if($data_tgl[1]=="10")
            {
                $bulan="Oktober";
            }
            if($data_tgl[1]=="11")
            {
                $bulan="November";
            }
            if($data_tgl[1]=="12")
            {
                $bulan="Desember";
            }
      if($type==""){
        $array = array($data_tgl[2],$bulan,$data_tgl[0]);
        $tanggal = implode(" ", $array );
      }
      else {
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode(" / ", $array );
      }
      
      return $tanggal;
    }    

    function terbilang($x, $style=1) {
      if($x<0) {
      $hasil = "minus ". trim($this->kekata($x));
      } else {
      $hasil = trim($this->kekata($x));
      }
      switch ($style) {
      case 1:
      $hasil = strtoupper($hasil);
      break;
      case 2:
      $hasil = strtolower($hasil);
      break;
      case 3:
      $hasil = ucwords($hasil);
      break;
      default:
      $hasil = ucfirst($hasil);
      break;
      }
      $hasil .= " RUPIAH";
      return $hasil;
    }

    function serapan($dir, $bulan, $tahun){
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
      $huruf = array('1' => 'A',
                     '2' => 'B',
                     '3' => 'C',
                     '4' => 'D',
                     '5' => 'E',
                     '6' => 'F',
                     '7' => 'G',
                     '8' => 'H',
                     '9' => 'I',
                     '10' => 'J',
                     '11' => 'K',
                     '12' => 'L',
                     '13' => 'M',
                     '14' => 'N',
                     '15' => 'O',
                     '16' => 'P',
                     '17' => 'Q',
                     '18' => 'R',
                     '19' => 'S',
                     '20' => 'T',
                     '21' => 'U',
                     '22' => 'V',
                     '23' => 'W',
                     '24' => 'X',
                     '25' => 'Y',
                     '26' => 'Z',
                     );

      $bulan = $bulan;
      $tahun = '2016';
      $objPHPExcel = new PHPExcel();
      // Set properties
      $objPHPExcel->getProperties()->setCreator("Sistem Keuangan Dikti")
              ->setLastModifiedBy("Sistem Keuangan Dikti")
              ->setTitle("Office 2007 XLSX Document")
              ->setSubject("Office 2007 XLSX Document")
              ->setDescription("Office 2007 XLSX, generated by PHPExcel.")
              ->setKeywords("office 2007 openxml php")
              ->setCategory("Laporan Keuangan");
      $border = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );
      $horizontal = array(
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
      );
      $vertical = array(
          'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          )
      );
      $objPHPExcel->getDefaultStyle()
    ->getBorders()
    ->getLeft()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getDefaultStyle()
    ->getBorders()
    ->getRight()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

      $sheet = $objPHPExcel->getActiveSheet()->setTitle('Rekap');
      $sheet->mergeCells('A1:T1');
      $sheet->mergeCells('A2:T2');
      $sheet->mergeCells('A3:T3');
      $sheet->mergeCells('A4:T4');
      $sheet->getStyle('A1:A4')->getFont()->setBold(true);
      $sheet->getStyle("A1:A4")->applyFromArray($horizontal);
      $sheet->getStyle('A6:T8')->getFont()->setBold(true);
      $sheet->getStyle("A6:T8")->applyFromArray($horizontal);
      $sheet->getStyle("A6:T8")->applyFromArray($vertical);
      $sheet->getStyle("A6:T8")->applyFromArray($border);

      $nmdir = $this->get_nama($dir);
      if (isset($nmdir['kdgiat'])) {
        $namadirek = $nmdir['kdgiat'];
      }else{
        $namadirek = "";
      }

      $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A1', 'Laporan Resapan Realisasi Daya Serap')
              ->setCellValue('A2', 'Bulan : '.$arrbulan[$bulan].' '.$tahun)
              ->setCellValue('A3', $namadirek)
              ->setCellValue('A4', 'Satker Ditjen Kelembagaan Iptek dan Dikti');
          
      $sheet->mergeCells('A6:A7');
      $sheet->mergeCells('B6:B7');
      $sheet->mergeCells('C6:E6');
      $sheet->mergeCells('F6:F7');
      $sheet->mergeCells('G6:H6');
      $sheet->mergeCells('I6:J6');
      $sheet->mergeCells('K6:L6');
      $sheet->mergeCells('M6:N6');
      $sheet->mergeCells('O6:P6');
      $sheet->mergeCells('Q6:R6');
      $sheet->mergeCells('S6:S7');
      $sheet->mergeCells('T6:T7');

      $cell = $objPHPExcel->setActiveSheetIndex(0);
      $cell->setCellValue('A6','Kode Satker/ keg/ sub keg');
      $cell->setCellValue('B6','Uraian Satker/Kegiatan/Sub Kegiatan');
      $cell->setCellValue('C6','Sasaran');
      $cell->setCellValue('C7','Satuan');
      $cell->setCellValue('D7','Sasaran');
      $cell->setCellValue('E7','Realisasi');
      $cell->setCellValue('F6','Sumber Dana');
      $cell->setCellValue('G6','Belanja Pegawai');
      $cell->setCellValue('G7','Alokasi');
      $cell->setCellValue('H7','Realisasi');
      $cell->setCellValue('I6','Belanja Barang');
      $cell->setCellValue('I7','Alokasi');
      $cell->setCellValue('J7','Realisasi');
      $cell->setCellValue('K6','Belanja Modal');
      $cell->setCellValue('K7','Alokasi');
      $cell->setCellValue('L7','Realisasi');
      $cell->setCellValue('M6','Belanja Bantuan Sosial');
      $cell->setCellValue('M7','Alokasi');
      $cell->setCellValue('N7','Realisasi');
      $cell->setCellValue('O6','Jumlah');
      $cell->setCellValue('O7','Alokasi');
      $cell->setCellValue('P7','Realisasi');
      $cell->setCellValue('Q6','Persentase Daya Serap');
      $cell->setCellValue('Q7','% Fisik');
      $cell->setCellValue('R7','% Keu');
      $cell->setCellValue('S6','Sisa Anggaran');
      $cell->setCellValue('T6','Ket');
      
      for ($i=1; $i <= 20; $i++) {
        $cell->setCellValue($huruf[$i].'8',$i);
      }
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);


      $cell->setCellValue('A10','401196');
      $cell->setCellValue('B10','Ditjen Kelembagaan Iptek dan Dikti');
      $sheet->getStyle('A10:B10')->getFont()->setBold(true);

      $sql = " SELECT kdgiat, kdoutput, kdsoutput,kdkmpnen, kdskmpnen, kdakun, NMAKUN,  jumlah  FROM rkakl_full where kdgiat like '%$dir%' group by kdgiat, kdoutput order by kdgiat asc, kdoutput asc";
      $res = $this->query($sql);
      
      $kd_dir=""; $kdout=""; $kdsout=""; $kdkmp=""; $kdskmp="";
      $tot_dipa_51  = 0;
      $tot_dipa_52  = 0;
      $tot_dipa_53  = 0;
      $tot_dipa_57  = 0;
      $tot_nilai_51 = 0;
      $tot_nilai_52 = 0;
      $tot_nilai_53 = 0;
      $tot_nilai_57 = 0;
      $tot_sisa     =0;
      $acc_alokasi  = 0;
      $grandtotaldipa  = 0;
      $grandtotalnilai  = 0;

      for ($b=1; $b <= 20; $b++) { 
          $sheet->getStyle($huruf[$b].'9')
                      ->getBorders()
                      ->getLeft()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle($huruf[$b].'9')
                      ->getBorders()
                      ->getRight()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle($huruf[$b].'10')
                      ->getBorders()
                      ->getLeft()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle($huruf[$b].'10')
                      ->getBorders()
                      ->getRight()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }
      $row = '11';

      foreach ($res as $value) {
        for ($b=1; $b <= 20; $b++) { 
          $sheet->getStyle($huruf[$b].$row)
                      ->getBorders()
                      ->getLeft()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle($huruf[$b].$row)
                      ->getBorders()
                      ->getRight()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

        if($kd_dir!=$value['kdgiat']){
          $row++;
          for ($b=1; $b <= 20; $b++) { 
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getLeft()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getRight()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          }
          $nmdir = $this->get_nama($value['kdgiat']);
          $dipa_51 = $this->get_nama($value['kdgiat'],"","","","","51");
          $dipa_52 = $this->get_nama($value['kdgiat'],"","","","","52");
          $dipa_53 = $this->get_nama($value['kdgiat'],"","","","","53");
          $dipa_57 = $this->get_nama($value['kdgiat'],"","","","","57");
          $nilai_51 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"51");
          $nilai_52 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"52");
          $nilai_53 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"53");
          $nilai_57 = $this->get_realisasi($tanggal, $value['kdgiat'],0,0,0,0,"57");
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          $sisa = $nmdir['jumlah']-$jml;
          $jml_dipa = $dipa_51['jumlah']+$dipa_52['jumlah']+$dipa_53['jumlah']+$dipa_57['jumlah'];
          $jml_nilai = $nilai_51['jumlah']+$nilai_52['jumlah']+$nilai_53['jumlah']+$nilai_57['jumlah'];
          $tot_dipa_51 += $dipa_51['jumlah'];
          $tot_dipa_52 += $dipa_52['jumlah'];
          $tot_dipa_53 += $dipa_53['jumlah'];
          $tot_dipa_57 += $dipa_57['jumlah'];
          $tot_nilai_51 += $nilai_51['jumlah'];
          $tot_nilai_52 += $nilai_52['jumlah'];
          $tot_nilai_53 += $nilai_53['jumlah'];
          $tot_nilai_57 += $nilai_57['jumlah'];
          $tot_sisa+=$jml_dipa-$jml_nilai;
          $acc_alokasi += $jml_dipa;

          $acc_sisa_ang += $sisa;

          $persen_keu = ($jml_nilai / $jml_dipa) *100;

          $grandtotaldipa += $jml_dipa;
          $grandtotalnilai += $jml_nilai;


          $cell->setCellValue('A'.$row,$value['kdgiat'],PHPExcel_Cell_DataType::TYPE_STRING);
          $cell->setCellValue('B'.$row,$nmdir['kdgiat']);
          $cell->setCellValue('C'.$row,'-');
          $cell->setCellValue('D'.$row,'-');
          $cell->setCellValue('E'.$row,'-');
          $cell->setCellValue('F'.$row,'RM');
          $cell->setCellValue('G'.$row,number_format($dipa_51['jumlah'],2,",","."));
          $cell->setCellValue('H'.$row,number_format($nilai_51['jumlah'],2,",","."));
          $cell->setCellValue('I'.$row,number_format($dipa_52['jumlah'],2,",","."));
          $cell->setCellValue('J'.$row,number_format($nilai_52['jumlah'],2,",","."));
          $cell->setCellValue('K'.$row,number_format($dipa_53['jumlah'],2,",","."));
          $cell->setCellValue('L'.$row,number_format($nilai_53['jumlah'],2,",","."));
          $cell->setCellValue('M'.$row,number_format($dipa_57['jumlah'],2,",","."));
          $cell->setCellValue('N'.$row,number_format($nilai_57['jumlah'],2,",","."));
          $cell->setCellValue('O'.$row,number_format($jml_dipa,2,",","."));
          $cell->setCellValue('P'.$row,number_format($jml_nilai,2,",","."));
          $cell->setCellValue('Q'.$row,'-');
          $cell->setCellValue('R'.$row,number_format($persen_keu,2));
          $cell->setCellValue('S'.$row,number_format($sisa,2,",","."));
          $cell->setCellValue('T'.$row,'-');

          $cell->getStyle('A'.$row.':T'.$row)->getFont()->setBold(true);

          $row++;
          for ($b=1; $b <= 20; $b++) { 
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getLeft()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getRight()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          }
        }

        if(($kd_dir!=$value['kdgiat'] and $kdout!=$value['kdoutput']) or ($kd_dir!=$value['kdgiat']) or ($kd_dir==$value['kdgiat'] and $kdout!=$value['kdoutput'])){
          $row++;
          for ($b=1; $b <= 20; $b++) { 
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getLeft()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle($huruf[$b].$row)
                        ->getBorders()
                        ->getRight()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          }

          $nmdir = $this->get_nama($value['kdgiat'], $value['kdoutput'],"","","","" );
          $dipa_51 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","51");
          $dipa_52 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","52");
          $dipa_53 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","53");
          $dipa_57 = $this->get_nama($value['kdgiat'],$value['kdoutput'],"","","","57");
          $nilai_51 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"51");
          $nilai_52 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"52");
          $nilai_53 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"53");
          $nilai_57 = $this->get_realisasi($tanggal, $value['kdgiat'],$value['kdoutput'],0,0,0,"57");
          $jml = $nilai['jml_lalu']+$nilai['jumlah'];
          // print_r($nilai_52);
          
          $jml_dipa = $dipa_51['jumlah']+$dipa_52['jumlah']+$dipa_53['jumlah']+$dipa_57['jumlah'];
          $jml_nilai = $nilai_51['jumlah']+$nilai_52['jumlah']+$nilai_53['jumlah']+$nilai_57['jumlah'];
          $sisa=$jml_dipa-$jml_nilai;
          $persen_keu = ($jml_nilai / $jml_dipa) *100;

          $cell->setCellValue('A'.$row,$value['kdoutput'],PHPExcel_Cell_DataType::TYPE_STRING);
          $cell->getStyle('A'.$row)->getNumberFormat()->setFormatCode('000');
          $cell->setCellValue('B'.$row,$nmdir['kdout']);
          $cell->setCellValue('C'.$row,'-');
          $cell->setCellValue('D'.$row,'-');
          $cell->setCellValue('E'.$row,'-');
          $cell->setCellValue('F'.$row,'RM');
          $cell->setCellValue('G'.$row,number_format($dipa_51['jumlah'],2,",","."));
          $cell->setCellValue('H'.$row,number_format($nilai_51['jumlah'],2,",","."));
          $cell->setCellValue('I'.$row,number_format($dipa_52['jumlah'],2,",","."));
          $cell->setCellValue('J'.$row,number_format($nilai_52['jumlah'],2,",","."));
          $cell->setCellValue('K'.$row,number_format($dipa_53['jumlah'],2,",","."));
          $cell->setCellValue('L'.$row,number_format($nilai_53['jumlah'],2,",","."));
          $cell->setCellValue('M'.$row,number_format($dipa_57['jumlah'],2,",","."));
          $cell->setCellValue('N'.$row,number_format($nilai_57['jumlah'],2,",","."));
          $cell->setCellValue('O'.$row,number_format($jml_dipa,2,",","."));
          $cell->setCellValue('P'.$row,number_format($jml_nilai,2,",","."));
          $cell->setCellValue('Q'.$row,'-');
          $cell->setCellValue('R'.$row,number_format($persen_keu,2));
          $cell->setCellValue('S'.$row,number_format($sisa,2,",","."));
          $cell->setCellValue('T'.$row,'-');
        }
          $kd_dir = $value['kdgiat'];
          $kdout = $value['kdoutput']; 
      }
      $row = $row+2;
      for ($b=1; $b <= 20; $b++) { 
        $sheet->getStyle($huruf[$b].($row-1))
                    ->getBorders()
                    ->getLeft()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sheet->getStyle($huruf[$b].($row-1))
                    ->getBorders()
                    ->getRight()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      }
      for ($b=1; $b <= 20; $b++) { 
        $sheet->getStyle($huruf[$b].($row-1))
                    ->getBorders()
                    ->getLeft()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sheet->getStyle($huruf[$b].($row-1))
                    ->getBorders()
                    ->getRight()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      }

      $persen_keu = ($grandtotalnilai / $grandtotaldipa) *100;
      $total_sisa = $grandtotaldipa - $grandtotalnilai;

      $cell->setCellValue('A'.$row,'Jumlah');
      $cell->mergeCells('A'.$row.':F'.$row);
      $sheet->getStyle("A".$row)->applyFromArray($horizontal);
      $cell->setCellValue('G'.$row,number_format($tot_dipa_51,2,",","."));
      $cell->setCellValue('H'.$row,number_format($tot_nilai_51,2,",","."));
      $cell->setCellValue('I'.$row,number_format($tot_dipa_52,2,",","."));
      $cell->setCellValue('J'.$row,number_format($tot_nilai_52,2,",","."));
      $cell->setCellValue('K'.$row,number_format($tot_dipa_53,2,",","."));
      $cell->setCellValue('L'.$row,number_format($tot_nilai_53,2,",","."));
      $cell->setCellValue('M'.$row,number_format($tot_dipa_57,2,",","."));
      $cell->setCellValue('N'.$row,number_format($tot_nilai_57,2,",","."));
      $cell->setCellValue('O'.$row,number_format($grandtotaldipa,2,",","."));
      $cell->setCellValue('P'.$row,number_format($grandtotalnilai,2,",","."));
      $cell->setCellValue('Q'.$row,'-');
      $cell->setCellValue('R'.$row,number_format($persen_keu,2));
      $cell->setCellValue('S'.$row,number_format($total_sisa,2,",","."));
      $cell->setCellValue('T'.$row,'-');

      $sheet->getStyle('A'.$row.':T'.$row)->getFont()->setBold(true);
      $sheet->getStyle('A'.$row.':T'.$row)->applyFromArray($border);

      $row = $row+2;
      $cell->setCellValue('B'.$row,'Mengetahui/Menyetujui');
      $cell->setCellValue('I'.$row,'Kepala Bagian Perencanaan dan Penganggaran');
      $cell->setCellValue('Q'.$row,'Jakarta, '.$this->konversi_tanggal(date("Y-m-d"),""));
      $row++;
      $cell->setCellValue('B'.$row,'Kuasa Pengguna Anggaran');
      $cell->setCellValue('I'.$row,'Ditjen Kelembagaan Iptek dan Dikti');
      $cell->setCellValue('Q'.$row,'Bendahara Pengeluaran');
      $row = $row+5;
      $cell->setCellValue('B'.$row,'Agus Indarjo');
      $cell->setCellValue('I'.$row,'Sawitri Isnandari');
      $cell->setCellValue('Q'.$row,'Josephine Margaretta');
      $sheet->getStyle('A'.$row.':T'.$row)->getFont()->setBold(true);
      $row++;
      $cell->setCellValue('B'.$row,'NIP. 19600505 198703 1 001');
      $cell->setCellValue('I'.$row,'NIP. 19670206 199303 2 001');
      $cell->setCellValue('Q'.$row,'NIP. 19870613 201012 2 009');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Laporan Resapan Realisasi ('.$bulan.' '.$tahun.').xlsx"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      // If you want to output e.g. a PDF file, simply do:
      //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
      $objWriter->save('php://output');
    }
}

?>
