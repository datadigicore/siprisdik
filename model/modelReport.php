<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";
  require_once __DIR__ . "/../library/mPDF/mpdf.php";

  class modelReport extends mysql_db {

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

    public function cetak_dok($id,$nama){
      $result = $this->query("SELECT rabview_id, npwp, kdgiat, kdprogram, kdoutput, kdsoutput, kdkmpnen, kdskmpnen from rabfull where id='$id' ");
      $res = $this->fetch_array($result);
      $rabv_id = $res[rabview_id];
      // echo $rabv_id;
      $kdprogram = $res[kdprogram];
      $kdoutput = $res[kdoutput];
      $kdsoutput = $res[kdsoutput];
      $kdkmpnen = $res[kdkmpnen];
      $kdskmpnen = $res[kdskmpnen];
      $kdakun= $res[kdskmpnen];
      $npwp= $res[npwp];
      // echo "Npwp : ".$npwp;
      $sql_org = "SELECT no_kuitansi from kuitansi 
                  where kdgiat = '$kdgiat' 
                    and kdprogram='$kdprogram' 
                    and kdoutput = '$kdoutput'
                    and kdsoutput = '$kdsoutput'
                    and kdkmpnen = '$kdkmpnen'
                    and kdskmpnen = '$kdskmpnen'
                    and npwp = '$npwp'  ";
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
                    and kdskmpnen = '$kdskmpnen' order by no_kuitansi DESC, no_kuitansi_update DESC limit 1 ";
      $hsl_nomor = $this->query($sql_nomor);

      $arr_kw = $this->fetch_array($hsl_nomor);
      $arr_kw_org = $this->fetch_array($hsl_org);
      
      $no_kw = $arr_kw[no_kuitansi];
      
      $no_kw_org = $arr_kw_org[no_kuitansi];

      $no_kw_up = $arr_kw[no_kuitansi_update];


      if ($this->num_rows($hsl_nomor)==0) { 
        // echo "Belum Ada Nomor Kwitansi";
        $no_kw = 1;
        $no_kw_up = 1;
          // Masukkin data baru degan no_kuitansi = 1
          $this->query("UPDATE rabfull set no_kuitansi='$no_kw' where rabview_id='$rabv_id' and npwp='$npwp' ");
          $this->query("INSERT into kuitansi(no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw' and rabview_id='$rabv_id' and npwp='$npwp' ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw' and rabview_id='$rabv_id' and no_kuitansi_update is null and npwp='$npwp' ");

      }
      else {
        if($this->num_rows($hsl_org)==0){
          // echo "Ada Nomor Kwitansi dan Belum ada orang";
          $no_kw++;
          $no_kw_up+=1;
          // Masukkin data baru degan no_kuitansi = 1++
          $this->query("UPDATE rabfull set no_kuitansi='$no_kw' where rabview_id='$rabv_id' and npwp='$npwp' ");
          $this->query("INSERT into kuitansi(no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw' and rabview_id='$rabv_id' and npwp='$npwp' ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw' and rabview_id='$rabv_id' and no_kuitansi_update is null and npwp='$npwp' ");

        }
        else{
          $hsl_tbh = $this->query($sql_org2);
          $hsl_arr = $this->fetch_array($hsl_tbh);
          $no_kw_up = $hsl_arr[no_kuitansi_update];
          $no_kw_up+=1;
          // echo "Sudah ada orang dengan kwitansi nomor yg lama";
          $this->query("INSERT into kuitansi(no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom)
                        select
                          no_kuitansi, rabview_id, thang, kdprogram, kdgiat, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, kdakun, noitem, deskripsi, tanggal, lokasi, uang_muka, realisasi_spj, realisasi_pajak, sisa, status, jenis, penerima, npwp, ppn, pph, golongan, jabatan, value, belanja, honor_output, honor_profesi, uang_saku, trans_lokal, uang_harian, tiket, tgl_mulai, tgl_akhir, tingkat_jalan, alat_trans, kota_asal, kota_tujuan, taxi_asal, taxi_tujuan, airport_tax, rute1, rute2, rute3, rute4, harga_tiket, lama_hari, klmpk_hr, pns, malam, biaya_akom
                        from rabfull where no_kuitansi='$no_kw_org' and rabview_id='$rabv_id' and npwp='$npwp' ");
          $this->query("UPDATE kuitansi set no_kuitansi_update='$no_kw_up' where no_kuitansi='$no_kw_org' and rabview_id='$rabv_id' and no_kuitansi_update is null and npwp='$npwp' ");

        }
      }
      $det_giat = array('kdgiat'    => $res[kdgiat],
                         'kdprogram' => $res[kdprogram],
                          'kdoutput'  => $res[kdoutput],
                          'kdsoutput' => $res[kdsoutput],
                          'kdkmpnen'  => $res[kdkmpnen],
                          'kdskmpnen' => $res[kdskmpnen],
                          'no_kw'     => $no_kw,
                          'npwp'      => $res[npwp] );

      // { PENGUJIAN VARIABEL }
      // echo ' No Kwitansi : '.$no_kw." No Kw Update : ".$no_kw_up;
      // $deskripsi = $res[deskripsi];
      // $tanggal = $res[tanggal];
      // $lokasi = $res[lokasi];
      // $uang_muka = $res[uang_muka];
      // echo "Nama : ".$nama."RABV ID ".$rabv_id." KD PROGRAM : ".$kdgiat." ".$kdprogram." ".$kdoutput." ".$kdsoutput." ".$kdkmpnen;
      
      // { PENGUJIAN KONDISI YANG LAMA }

      $dinas = 0;
      $lokal = 0;
      $dt_akun = array();
      $item_honor = "0";
      $item_transport = "0";
      $item_uangsaku = "0";
      $uang_saku_dalam = 0;
      $uang_saku_luar = 0;
      $honor = 0;
      $transport_lokal = 0;
      $item = "";
      $sql2 = $this->query("SELECT NMGIAT, NMOUTPUT, NMKMPNEN, NmSkmpnen, NMITEM FROM rkakl_full where KDPROGRAM = '$kdprogram' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN = '$kdkmpnen' and KDSKMPNEN = '$kdskmpnen' ; ");
      $detil_prog = $this->fetch_array($sql2);
      // print_r($detil_prog);
      mysql_free_result($result);
      // $result = $this->query("SELECT rab.alat_trans, rab.kota_asal, rab.kota_tujuan, rab.lama_hari, rab.tgl_mulai, rab.tgl_akhir, rab.rabview_id, rab.penerima, rab.kdprogram, rab.kdgiat, rab.kdoutput, rab.kdsoutput, rab.kdkmpnen, rab.kdakun, rkkl.NMGIAT, rab.value, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and rab.kdskmpnen = rkkl.KDSKMPNEN  and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rab.rabview_id='$rabv_id' and rab.npwp='$npwp' order by rab.kdakun asc ");
      $result = $this->query("SELECT rab.tgl_mulai, rab.tgl_akhir, rab.rabview_id, rab.penerima, rab.kdakun, rkkl.NMGIAT, rab.value, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and rab.kdskmpnen = rkkl.KDSKMPNEN  and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rab.rabview_id='$rabv_id' and rab.npwp='$npwp' order by rab.kdakun asc ");
      // while($res=$this->fetch_array($result)){
      //   if($res[kdakun]=="524119" || $res[kdakun]=="524114"  || $res[kdakun]=="524113" || $res[kdakun]=="524219")   $dinas=1;
      //   if($res[kdakun]=="524114"  || $res[kdakun]=="524113")   $lokal=1;
      // }
      $counter="";
      ob_start();
      while($res=$this->fetch_array($result)){
        // echo "<br>".$res[NMITEM]."<br>";
        if($res[kdakun]=="521213"){
          $item_honor = "1";
          $honor += $res[value];
          // $pot = "";
          // $pph=0;
        }
        else if($res[kdakun]=="522151"){
          $item_honor = "1";
          $honor += $res[value];
          
        }
        else if($res[kdakun]=="524113"){
          if(substr($res[NMITEM],1,8)!=="ransport"){
            $item_uangsaku = "1";
            $uang_saku_dalam +=$res[value];
          }
          else
          {
            $item_transport = "1";
            $transport_lokal +=$res[value];
          }
          
        }
        else if($res[kdakun]=="524114"){
          if(substr($res[NMITEM],1,8)!=="ransport"){
            $item_uangsaku = "1";
            $uang_saku_dalam +=$res[value];
          }
          else{
            $item_transport = "1";
            $transport_lokal +=$res[value];
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
      // print_r($dt_akun);
      if($honor>0){
          $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "Honorarium",$honor);
          echo '<pagebreak />';
      }
      if($uang_saku_dalam>0){
          $this->Kuitansi_Honorarium($result, $det_giat, "Uang Saku",$uang_saku_dalam);
          echo '<pagebreak />';
        }
      if($transport_lokal>0){
        $this->Kuitansi_Honorarium($result, $det_giat, "Transport Lokal",$transport_lokal);
        echo '<pagebreak />';
        }
      if($dt_akun[0]!==""){
        $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$dt_akun[0]);
        echo '<pagebreak />';
      }
      if($dt_akun[1]!==""){
        $this->Kuitansi_Honor_Uang_Saku($result, $det_giat, "",0,$dt_akun[1]);
        echo '<pagebreak />';
      }
      if($dinas==1){
        $this->SPPD($data);
         echo '<pagebreak />';
        $this->Rincian_Biaya_PD($data);
         echo '<pagebreak />';
        $this->daftar_peng_riil($data);
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
      $this->create_pdf($npwp."_".$no_kw,"A4",$html);

    }
    public function SPTB($data){
      $sql = $this->query("SELECT r.NMITEM as nmitem, r.NMGIAT as nmgiat, r.NMAKUN as nmakun, f.kdgiat as kdgiat, f.kdprogram as kdprogram, f.kdoutput as kdoutput, f.kdakun as kdakun, f.penerima as penerima, f.tanggal as tanggal, f.value as value FROM rabfull as f LEFT JOIN rkakl_full as r on f.kdgiat = r.KDGIAT and f.kdoutput = r.KDOUTPUT and f.kdkmpnen = r.KDKMPNEN and f.kdskmpnen = r.KDSKMPNEN  and f.kdakun = r.KDAKUN and f.noitem = r.NOITEM  where f.kdakun ='$data' ");
      $id = $this->fetch_array($sql);
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
            </table>';
      echo '<p align="center" style="font-weight:bold;">______________________________________________________________________________________________________</p>';
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
      foreach ($sql as $value) {
        $item=explode("[", $value[nmitem]);
        echo '<tr>
                <td>'.$no.'</td>
                <td>'.$value[kdakun].'</td>
                <td>'.$value[penerima].'</td>
                <td style="text-align: justify;">'." Biaya ".$item[0]." kegiatan ".$value[nmgiat].", tgl. ".$this->konversi_tanggal($value[tanggal],"").'</td>
                <td>'.$this->konversi_tanggal($value[tanggal],"/").'</td>
                <td>'."-".'</td>
                <td align="right">'.number_format($value[value],0,",",".").'</td>
                <td>'." ".'</td>
                <td>'." ".'</td>
            </tr>';
            $tot_value += $value[value];
            $no++;
      }
        
      
      echo '<tr>
              <td colspan="6">JUMLAH</td>
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
                    
                    <td style="font-weight:bold">Sudarsono</td>
                    <td></td>
                    <td style="font-weight:bold">Sugiharto</td>
                  </tr>
                  <tr>
                    
                    <td>NIP. 19640920 198403 1 001</td>
                    <td></td>
                    <td>NIP. 19750721 200912 1 001</td>
                  </tr>  
                  </table>';
      $html = ob_get_contents();
      $this->create_pdf("SPTB","A4",$html);


    }

    public function SPP($data){
      ob_start();
      echo '<table cellpadding="1" style="border-collapse:collapse; font-size:0.85em;">

             <tr>
              <td colspan="12" style="font-weight:bold; font-size:1.3em;" align="center">SURAT PERMINTAAN
              PEMBAYARAN</td>
             </tr>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td width="2%"></td>
              <td style="font-weight:bold;" colspan="3" align="right">Tanggal : 31 Desember 2016 Nomor :</td>
              <td style="font-weight:bold;"  colspan="5" >00675/LEMKERMA/673474/2016</td>
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
              <td >[ 5696 ]</td>
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
              <td colspan=12><br></br></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10>KEPADA</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10>Yth. Pejabat Penanda Tangan Surat Perintah Membayar</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10>Direktorat Jenderal Kelembagaan Ilmu Pengetahuan
              Teknologi dan Pendidikan Tinggi</td>
              <td></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=10>di- Kota Jakarta Pusat</td>
              <td></td>
             </tr>
             <tr>
              <td colspan=12><br></br></td>
             </tr>
             <tr>
              <td colspan=12 >Berdasarkan DIPA Nomor : DIPA-042.03.1.401196/2016, Tgl. 1
              Desember2015 dan, bersama ini kami
              ajukan pembayaran sebagai berikut :</td>
             </tr>
             <tr>
              <td >1. </td>
              <td colspan=2>Jumlah pembayaran</td>
              <td>:</td>
              <td>1) dengan angka:</td>
              <td colspan=3>#REF!</td>
              <td ></td>
              <td ></td>
              <td ></td>
              <td ></td>
             </tr>
             <tr>
              <td></td>
              <td colspan=2>yang dimintakan</td>
              <td>:</td>
              <td>2) dengan huruf :</td>
              <td colspan=7 align=center style="width:442pt">#NAME?</td>
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
              <td>52 (Belanja Barang)</td>
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
             </tr>';
      echo   '<tr>
              <td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; "    ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;  "  >JUMLAH II</td>
              <td style="border-top:1px solid; border-bottom:1px solid; solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; solid;  "  ></td>
              <td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;  "  ></td>
              <td style="border:1px solid;" ></td>
             </tr>
             <tr>
              <td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; "  colspan=3>Uang Persediaan</td>
              <td style="border-left:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-right:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-left:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-right:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-left:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-right:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-left:1px solid; border-bottom:1px solid;" ></td>
              <td style="border-right:1px solid; border-bottom:1px solid;" ></td>>
              <td style="border:1px solid;"></td>
             </tr>
             <tr >
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  ></td>
              <td  >Surat bukti untuk</td>
              <td  ></td>
              <td ></td>
              <td  ></td>
             </tr>
             <tr >
              <td ></td>
              <td></td>
              <td>LAMPIRAN</td>
              <td ></td>
              <td>LEMBAR : B</td>
              <td></td>
              <td></td>
              <td ></td>
              <td>pengeluaran</td>
              <td ></td>
              <td>STS ___ lembar</td>
              <td ></td>
             </tr>
             <tr>
             <td colspan=5 >Diterima
              oleh penguji SPP/Penerbit SPM</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan=3>Jakarta : 31 Desember 2016 </td>
             </tr>
             <tr >
              <td colspan=5 >Dirjen
              Kelembagaan Iptek dan Dikti (401196)</td>
              <td></td>
              <td ></td>
              <td ></td>
              <td></td>
              <td colspan=3>Pejabat Pembuat Komitmen</td>
             </tr>
             <tr >
              <td colspan=3 >Pada
              tanggal</td>
              <td></td>
              <td></td>
              <td></td>
              <td ></td>
              <td ></td>
              <td></td>
              <td colspan=3>Dirjen Kelembagaan Iptek
              dan Dikti (401196)</td>
             </tr>
             <tr >
              <td  colspan=3 >Akhmad
              Mahmudin, S.IP, M.Si</td>
              <td></td>
              <td ></td>
              <td></td>
              <td ></td>
              <td ></td>
              <td></td>
              <td  colspan=2>Sudarsono</td>
              <td></td>
             </tr>
             <tr >
              <td  colspan=3 >NIP.
              19611214 198403 1 001</td>
              <td></td>
              <td ></td>
              <td></td>
              <td></td>
              <td ></td>
              <td></td>
              <td  colspan=3>NIP. 19640920 198403 1 001</td>
             </tr>
             </table>';
            $html = ob_get_contents();
            $this->create_pdf("SPTB","A4",$html);

    }
    // DAFTAR RINCIAN PERMINTAAN PENGELUARAN
    public function Rincian_Permintaan_Pengeluaran($data){
      $sql = $this->query("SELECT kdakun, penerima, tanggal, sum(value) as jumlah FROM `rabfull` where kdakun like '$data%' GROUP BY kdakun order by kdakun asc ");
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
                <td style="border-right: 1px solid;">:</td>
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
                <td style="border-left: 1px solid; border-right: 1px solid;" colspan="2" rowspan="2">Rp. </td>
                <td>9. TAHUN ANGGARAN<br></td>
                <td style="border-right: 1px solid;">: 2016</td>
              </tr>
              <tr>
                <td style="border-left: 1px solid;">5. Alamat<br></td>
                <td  colspan="2">: Komplek Kemdikbud Gedung D Lt. 6</td>
                <td>10. Bulan</td>
                <td style="border-right: 1px solid;">:</td>
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
      while($data=$this->fetch_array($sql)){
        echo '<tr>
                <td style="border: 1px solid;  text-align:center;">'.$no.'</td>
                <td style="border: 1px solid;  text-align:center;"></td>
                <td style="border: 1px solid;  text-align:center;">SPTB</td>
                <td style="border: 1px solid;  text-align:center;">-</td>
                <td style="border: 1px solid;  text-align:center;">'.$data[kdakun].'</td>
                <td style="border: 1px solid;  text-align:center;">Terlampir Pada SPTB</td>
                <td style="border: 1px solid;  text-align:center;">'.number_format($data[jumlah],0,",",".").'</td>
              </tr>';
              $no++;
      }
      $no--;
      echo'   <tr>
                <td style="border-right: 1px solid; border-left: 1px solid; border-top: 1px solid;  text-align:center;"> Jumlah Lampiran :</td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">Jumlah SPP ini (Rp)</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid;" colspan="5"></td>

              </tr>
              <tr>
                <td style="border-right: 1px solid; border-left: 1px solid;  text-align:center;">'.$no.'</td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">SPM/SPP Sebelum SPP ini atas beban sub kegiatan ini</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid;" colspan="5"></td>
              </tr>
              <tr>
                <td style="border-left: 1px solid; border-bottom: 1px solid;"></td>
                <td style="border: 1px solid;  text-align:center;" colspan="5">Jumlah s.d. SPP ini atas beban sub kegiatan ini</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid;" colspan="5"></td>
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
              <td style="font-weight:bold">Sudarsono</td>
            </tr>
            <tr>
              <td></td>
              <td width="60%"></td>
              <td>NIP. 19640920 198403 1 001</td>
            </tr>  
            </table>';
            $html = ob_get_contents();
            $this->create_pdf("Rincian_Permintaan_Pengeluaran","A4",$html);

    }
    //Kuitansi Honorarium
    public function Kuitansi_Honorarium($data, $det, $item, $val){
      $total=$val;
      if($item==""){
        foreach ($data as $value) {
           $total += $value[value];
           $penerima = $value[penerima];
        }
      }
      echo '  <p align="right">No '.$det['no_kw']."/".$det['kdgiat'].".".$det['kdoutput'].".".$det['kdsoutput'].".".$det['kdkmpnen']."/2016".'</p>'; 
      require __DIR__ . "/../utility/report/header_dikti.php";
      echo '  <p align="center">KUITANSI</p>
                    <table style="width: 100%; font-size:80%; border-collapse: collapse;"  border="0">               
                    <tr>
                        <td align="left">Sudah Terima Dari </td>
                        <td align="left">: </td>
                        <td align="left" style="font-weight:bold"> Kuasa Pengguna Anggaran Direktorat Jenderal Kelembagaan IPTEK dan DIKTI</td>
                        
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left">: </td>
                        <td align="left" style="background-color:gray; font-size:1.2em;"><b>Rp. '.number_format($total,0,",",".").'</b></td>
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
                <td>'.'..................................'.'</td>
                <td>'.'..................................'.'</td>
                <td>'.$penerima.'</td>
              </tr>              

              <tr>
                <td>NIP'.'..........................'.'</td>
                <td>NIP'." ".'..........................'.'</td>
                <td></td>
              </tr>
              </table>';

      if($item=="Transport Lokal"){
        echo "---------------------------------------------------------------------------------------------------------------------------------------";
        echo '<table border=0 style="width: 100%; text-align:left; border-collapse:collapse; font-size:85%;">
        <tr>
          <td style="border-top:0px solid; border-left:0px solid; border-right:0px solid; font-weight:bold;" align="center" colspan="3"> DAFTAR PENGELUARAN RIIL </td>
        </tr>
        <tr>
          <td style="border-top:0px solid; border-left:0px solid; border-right:0px solid;" colspan="3"><br>Yang bertanda tangan dibawah ini :</br></td>
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

      echo '<table border=0 style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
        <tr>
          <td>Berdasarkan Surat Perjalanan Dinas (SPD) Tanggal ........................... Nomor: ...................................., dengan ini saya menyatakan dengan sesungguhnya bahwa:</td>
        </tr>
      </table>';
      echo '<table style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
              <tr>
                <td width="3%">1.</td>
                <td colspan="2">Biaya Transport dan pengeluaran yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi : </td>
              </tr>';
        // foreach ($data as $value) {
          
        //   echo '<tr>
        //           <td></td>
        //           <td width="35%">- '.$value[NMITEM].'</td>
        //           <td>'." : Rp. ".number_format($value[value],0,",",".").'</td>
        //         </tr>';
        //   }
      echo '<tr>
              <td>2</td>
              <td colspan="2">Jumlah Uang tersebut pada lembar Uraian diatas benar-benar dikeluarkan untuk pelaksanaan Perjalanan dinas dimaksud dan apabilah dikemudian hari terdapat kelebihan atas pembayaran, kami bersedia menyetorkan kelebihan tersebut ke kas Negara</td>
            </tr>';


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
          <td><br></br><br></br></td>
          <td><br></br><br></br></td>
        </tr>
        <tr>
          <td style="font-weight:bold">Ridwan</td>
          <td>'.$penerima.'</td>
        </tr>
        
        <tr>
          <td>NIP. 1962121019920310011</td>
          <td></td>
        </tr>
      </table>';
      }

    }

    //SPPD SURAT PERINTAH PERJALANAN DINAS
    public function SPPD($data){
      $transportasi=null;
      $kota_asal=null;
      $kota_tujuan=null;
      $lama_hari=null;
      $tgl_mulai = null;
      $tgl_akhir = null;
      $penerima=nul;

      foreach ($data as $value) {
        if($value[alat_trans]!=''){ $transportasi = $value[alat_trans]; }
        if($value[kota_asal]!="") $kota_asal= $value[kota_asal];
        if($value[kota_tujuan]!="") $kota_tujuan = $value[kota_tujuan];
        if($value[lama_hari]!="") $lama_hari = $value[lama_hari];
        if($value[tgl_mulai]!="") $tgl_mulai = $value[tgl_mulai];
        if($value[tgl_akhir]!="") $tgl_akhir = $value[tgl_akhir];
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
                      <td colspan="2">'.$penerima.'</td>
                    </tr> 
                    <tr>
                        <td>3</td>
                        <td>
                          <p> a.  Pangkat dan Golongan ruang gaji menurut PP No. 6 Tahun 1997</p>
                          <p> b.  Jabatan/Instansi</p>
                          <p> c.  Tingkat menurut peraturan perjalanan dinas</p>
                        </td>
                        <td colspan="2">Ada di RAB</td>
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
        echo '
              <table style="text-align: left; width: 100%; font-size:84%; border-collapse: collapse; font-family:serif"  >

              <tr>
                <td width="60%"></td>
                <td>Dikeluarkan Di </td>
                <td> :................................................</td>
              </tr>
              <tr>
                <td width="60%"></td>
                <td>Pada Tanggal</td>
                <td> :................................................ </td>
              </tr>

              </table>';
      // $html = ob_get_contents();
      // $this->create_pdf("SPPD","A4",$html);

    }

    //Rincian Biaya Perjalanan Dinas
    public function Rincian_Biaya_PD($data){
      $jml=0; 
      $query = "SELECT kota_asal, kota_tujuan, tiket, airport_tax, alat_trans, taxi_asal, taxi_tujuan, lama_hari, uang_harian, penerima, npwp FROM rabfull where rabview_id='$data'";
      // print_r($query);
      $result = $this->query($query);
      $array = $this->fetch_array($result);
      $asal=""; $tujuan=""; $alat_trans; $tiket=0; $airport_tax=0;
      $taxi_asal=0; $taxi_tujuan=0; $jml_hari=1; $uang_harian=0;
      $jml_uang_harian;
      // print_r($result);
      foreach ($result as $val) {
        $alat_trans = $val[alat_trans];
        $asal = $val[kota_asal];
        $tujuan = $val[kota_tujuan];
        if($val[tiket]>0) $tiket = $val[tiket];
        if($val[airport_tax]>0) $airport_tax = $val[airport_tax];
        if($val[taxi_asal]>0)   $taxi_asal = $val[taxi_asal];
        if($val[taxi_tujuan]>0) $taxi_tujuan = $val[taxi_tujuan];
        if($val[lama_hari]>0)   $jml_hari = $val[lama_hari];
        if($val[uang_harian]>0) $uang_harian = $val[uang_harian];   
               
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
      echo '<table style="text-align: justify; width: 100%; font-size:84%; font-family:serif"  >
            <tr>

            <td></td>
            <td width="23%"></td>
            <td>Jakarta, .............................................</td>
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
            <td>......................................</td>
            <td width="23%"></td>
            <td>......................................</td>
          </tr>
          <tr>
            <td></td>
            <td width="23%"></td>
            <td>NIP ...............................</td>
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
      // $html = ob_get_contents();
      // $this->create_pdf("RB_Perjalanan_Dinas","A4",$html);

    }

    //Kuitansi Honor Dan Uang Saku
    public function Kuitansi_Honor_Uang_Saku($data,$det,$item,$val,$kd_akun) {
      $penerima;
      $total=$val;

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
           break;
        }
      }
      $pph = (15 / 100) * $total;
      $diterima = $total-$pph;  
        echo '  <p align="right">No '.$det['no_kw']."/".$det['kdgiat'].".".$det['kdoutput'].".".$det['kdsoutput'].".".$det['kdkmpnen']."/2016".'</p>'; 
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
                        <td style="background-color:gray" colspan="2">Rp. '.number_format($diterima,0,",",".").'</td>
                        
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: </td>
                        <td colspan="2">'.$this->terbilang($diterima,1).'</td>
                        
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
                        <td width="40%">'.$value[NMITEM].'</td>
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
                      <td align="right">'."".number_format($val,0,",",".").'</td>
                    </tr>';

          }
          echo '<tr>
                  <td ></td>
                  <td >'."Jumlah ".'</td>
                  <td> : Rp. </td>
                  <td align="right">'."".number_format($total,0,",",".").'</td>
                  <td></td>
                </tr>';
          echo '<tr>
                  <td ></td>
                  <td >'."PPh. 15% ".'</td>
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
                <td style="text-align: center;">........................ 2016</td>
              </tr>              
              <tr>
                <td style="text-align: center;">Pejabat Pembuat Komitmen,</td>
                <td style="text-align center;">Tgl...........................</td>
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
                <td style="text-align: center;">'.'Ridwan'.'</td>
                <td style="text-align: center;">'.'Evi Nursanti'.'</td>
                <td style="text-align: center;">'.'('.$penerima.')'.'</td>
              </tr>              
              <tr>
                <td style="text-align: center;">NIP'.'196212101992031001'.'</td>
                <td style="text-align: center;">NIP'." ".'196203051986022001'.'</td>
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
                    <td style= "vertical-align: bottom;" style="  font-weight:bold; text-align: center;" >Nomor : ........................</td>
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
                <td width="25%"> Penghasilan </td>
                <td width="25%">Jumlah</td>
                <td width="25%">Tarif</td>
                <td width="25%">Pph yang dipotong</td>
              </tr>';
        $no=1;
        $tot_pot=(15/100)*$val;
        foreach ($data as $value) {
          if($value[kdakun]==$kd_akun and $value[kdakun]!== "521213" and $value[kdakun]!== "522151"and $value[kdakun]!== "524114"and $value[kdakun]!== "524113"and $value[kdakun]!== "524119" ){
            $pot = (15/100)*$value[value];
            $tot_pot +=$pot;
            echo '<tr>
                    <td>'.$no.". ".$value[NMITEM].'</td>
                    <td>Rp. '.number_format($value[value],0,",",".").'</td>
                    <td>15%</td>
                    <td>'."Rp. ".number_format($pot,0,",",".").'</td>
                  </tr>';
            $no++;
          }
          }  
          echo '<tr>
                  <td>1.'.$item.'</td>
                  <td>'.$val.'</td>
                  <td>15 %</td>
                  <td>'."Rp. ".number_format($tot_pot,0,",",".").'</td>
                </tr>
              </table>';

         echo '<table style="text-align: left; width: 100%; font-size:0.7em;"  >
              <tr>

                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: left;">Jakarta, ..............................</td>
              </tr>

              <tr>

                <td style="text-align center;"></td>
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
              <br></br>
              <br></br>
              <br></br>
              <br></br>
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

 

public function daftar_peng_riil($data){
  $penerima="";
  foreach ($data as $value) {
    $penerima = $value[penerima];
  }
  // ob_start();
      // echo '<h2 align="center">DAFTAR PENGELUARAN RIIL<h2>
      //     <h6><h6>';
      echo '<table border=1 style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
        <tr>
          <td style="border-top:0px solid; border-left:0px solid; border-right:0px solid; font-weight:bold;" align="center" colspan="3"> DAFTAR PENGELUARAN RIIL </td>
        </tr>
        <tr>
          <td style="border-top:0px solid; border-left:0px solid; border-right:0px solid; font-weight:bold;" colspan="3"><br>Yang bertanda tangan dibawah ini :</br></td>
        </tr>
        <tr>
          <td width="20%">Nama</td>
          <td width="2%">:</td>
          <td>'.$penerima.'</td>
        </tr>
        <tr>
          <td>Asal Daerah</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td>No Handphone</td>
          <td></td>
          <td></td>
        </tr>
      </table>';

      echo '<h5>Berdasarkan Surat Tugas :</h5>';

      echo '<table border=1 style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
        <tr>
          <td width="20%">Nomor</td>
          <td width="2%">:</td>
          <td></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>:</td>
          <td></td>
        </tr>
      </table>';

      echo '<h5>Dengan ini saya menyatakan dengan sesugguhnya bahwa :</h5>';
      echo '<table style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
              <tr>
                <td width="3%">1.</td>
                <td colspan="2">Biaya Transport dan pengeluaran yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi : </td>
              </tr>';
        foreach ($data as $value) {
          
          echo '<tr>
                  <td></td>
                  <td width="35%">- '.$value[NMITEM].'</td>
                  <td>'." : Rp. ".number_format($value[value],0,",",".").'</td>
                </tr>';
          }
      echo '<tr>
              <td>2</td>
              <td colspan="2">Jumlah Uang tersebut pada lembar Uraian diatas benar-benar dikeluarkan untuk pelaksanaan Perjalanan dinas dimaksud dan apabilah dikemudian hari terdapat kelebihan atas pembayaran, kami bersedia menyetorkan kelebihan tersebut ke kas Negara</td>
            </tr>';


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
          <td><br></br><br></br></td>
          <td><br></br><br></br></td>
        </tr>
        <tr>
          <td style="font-weight:bold">Ridwan</td>
          <td>'.$penerima.'</td>
        </tr>
        
        <tr>
          <td>NIP. 1962121019920310011</td>
          <td></td>
        </tr>
      </table>';

}
    public function pengajuan_UMK($data) {
      // $sql = $this->query("SELECT kdgiat, kdprogram, kdoutput, kdsoutput, kdkmpnen, kdskmpnen, deskripsi, tanggal, lokasi, sum(uang_muka) as uang_muka, sum(uang_harian) as uang_harian, sum(uang_saku) as uang_saku, sum(honor_output) as honor_output, sum(honor_profesi) as honor_profesi, sum(tiket) as tiket, sum(biaya_akom) as akom, sum(trans_lokal) as trans_lokal FROM rabfull where rabview_id='$data' ");
      
      // $res = $this->fetch_array($sql);
      // $kdgiat= $res[kdgiat];
      // $kdprogram = $res[kdprogram];
      // $kdoutput = $res[kdoutput];
      // $kdsoutput = $res[kdsoutput];
      // $kdkmpnen = $res[kdkmpnen];
      // $kdskmpnen = $res[kdskmpnen];
      // $deskripsi = $res[deskripsi];
      // $tanggal = $res[tanggal];
      // $lokasi = $res[lokasi];
      // $uang_muka = $res[uang_muka];    

      // $sql2 = $this->query("SELECT NMGIAT, NMOUTPUT, NMKMPNEN, NmSkmpnen FROM rkakl_full where KDPROGRAM = '$kdprogram' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN = '$kdkmpnen'; ");
      // $res2 = $this->fetch_array($sql2);
      // print_r("SELECT NMGIAT, NMOUTPUT, NMKMPNEN, NmSkmpnen FROM rkakl_full where KDPROGRAM = '$kdprogram' and KDOUTPUT='$kdoutput' ");
      $result = $this->query("SELECT rab.tanggal, rab.deskripsi, rab.lokasi, rab.rabview_id, rab.penerima, rab.kdprogram, rab.kdgiat, rab.kdoutput, rab.kdsoutput, rab.kdkmpnen, rab.kdakun, rkkl.NMGIAT, rab.value, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and  rab.kdskmpnen = rkkl.KDSKMPNEN and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rabview_id='$data' ");
      $res2 = $this->fetch_array($result);
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
                <td></td>
                <td></td>
                <td></td>
              </tr>';
              $no=1;
              $tot=0;
        foreach($result as $rs) {

         echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td>'.$no.". ".$rs[NMITEM].'</td>
                <td>: Rp. </td>
                <td>'.number_format($rs[value],0,",",".").'</td>
              </tr>';
              $no++;
              $tot+=$rs[value];
        }
        echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight:bold;">JUMLAH</td>
                <td style="font-weight:bold;">: Rp. </td>
                <td style="font-weight:bold;">'.number_format($tot,0,",",".").'</td>
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
                <td style="border-left: 1px solid black; border-right: 1px solid black;">....................................</td>
              </tr> 
              <tr>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;">NIP. 19600505 198703 1 001</td>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">NIP. 19870613 201012 2 009</td>
                <td></td>
                <td style="border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;">NIP. ....................................</td>
              </tr>
            </table>';
            $html = ob_get_contents();
            $this->create_pdf("Pengajuan UMK","A4",$html);
      
    }

    public function readPengguna($data) {
      
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
            $bulan="Agusts";
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

function terbilang($x, $style=4) {
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
  }

?>
