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
      $result = $this->query("SELECT rabview_id from rabfull where id='$id' ");
      $res = $this->fetch_array($result);
      $rabv_id = $res[rabview_id];
      // echo $rabv_id;
      $kdgiat= $res[kdgiat];
      $kdprogram = $res[kdprogram];
      $kdoutput = $res[kdoutput];
      $kdsoutput = $res[kdsoutput];
      $kdkmpnen = $res[kdkmpnen];
      $kdskmpnen = $res[kdskmpnen];
      $kdakun= $res[kdskmpnen];
      // $deskripsi = $res[deskripsi];
      // $tanggal = $res[tanggal];
      // $lokasi = $res[lokasi];
      // $uang_muka = $res[uang_muka];
      // echo "Nama : ".$nama."RABV ID ".$rabv_id." KD PROGRAM".$kdgiat." ".$kdprogram." ".$kdoutput." ".$kdsoutput." ".$kdkmpnen;
      $dinas = 0;
      $lokal = 0;
      $sql2 = $this->query("SELECT NMGIAT, NMOUTPUT, NMKMPNEN, NmSkmpnen, NMITEM FROM rkakl_full where KDPROGRAM = '$kdprogram' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN = '$kdkmpnen'; ");
      $detil_prog = $this->fetch_array($sql2);
      // print_r($detil_prog);
      mysql_free_result($result);
      $result = $this->query("SELECT rab.alat_trans, rab.kota_asal, rab.kota_tujuan, rab.lama_hari, rab.tgl_mulai, rab.tgl_akhir, rab.rabview_id, rab.penerima, rab.kdprogram, rab.kdgiat, rab.kdoutput, rab.kdsoutput, rab.kdkmpnen, rab.kdakun, rkkl.NMGIAT, rab.value, rkkl.NMOUTPUT, rkkl.NMKMPNEN, rkkl.NMSKMPNEN, rkkl.NMAKUN, rkkl.NMITEM FROM rabfull as rab LEFT JOIN rkakl_full as rkkl on rab.kdgiat = rkkl.KDGIAT and rab.kdoutput = rkkl.KDOUTPUT and rab.kdkmpnen = rkkl.KDKMPNEN and rab.kdakun = rkkl.KDAKUN and rab.noitem = rkkl.NOITEM  where rabview_id='$rabv_id' and penerima='$nama' ");
      while($res=$this->fetch_array($result)){
        if($res[kdakun]=="524119" || $res[kdakun]=="524114"  || $res[kdakun]=="524113" || $res[kdakun]=="524219")   $dinas=1;
        if($res[kdakun]=="524114"  || $res[kdakun]=="524113")   $lokal=1;
      }
      ob_start();
      if($lokal==0) {
        $this->Kuitansi_Honor_Uang_Saku($result);
        echo '<pagebreak />';
      }
      if($dinas==1){ 
        $this->Rincian_Biaya_PD($result);
        echo '<pagebreak />';
        $this->SPPD($result);
        echo '<pagebreak />';
      }
      if($lokal==1) {
        $this->Kuitansi_Honorarium($result);
        echo '<pagebreak />';
      }
      $this->daftar_peng_riil($result);
      $html = ob_get_contents();
      $this->create_pdf("SPTB","A4",$html);

    }
    public function SPTB($data){
      $sql = $this->query("SELECT f.kdakun as kdakun, f.penerima as penerima, f.tanggal as tanggal, f.value as value, v.deskripsi as deskripsi FROM rabview as v LEFT JOIN rabfull as f on v.id = f.rabview_id where f.kdakun like '%5%' ");
      ob_start();
      echo '<p align="center" style="font-weight:bold; text-decoration: underline;">SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</p>';
      echo '<p align="center" style="font-weight:bold;">Nomor : </p>';
      echo '<table style="width: 100%; font-size:0.65em;"  border="0">               
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
                <td align="left" >: 10.03.06.5696.003.522151</td>
              </tr>
            </table>';
      echo '<p align="center" style="font-weight:bold;">______________________________________________________________________________________________________</p>';
      echo '<p align="left" style="font-size:0.65em;">Yang    bertandatangan  di    bawah  ini    atas  nama    Kuasa    Pengguna    Anggaran    Satuan Kerja Direktorat Jendral Kelembagaan Ilmu Pengetahuan Teknologi Dan Pendidikan Tinggi menyatakan  bahwa  saya  bertanggungjawab  secara  formal  dan  material  atas 
            segala  pengeluaran  yang  telah  dibayar  lunas  oleh  Bendahara  Pengeluaran  kepada  yang  berhak menerima  serta  kebenaran  perhitungan  dan  setoran  pajak  yang  telah  dipungut  atas  pembayaran tersebut dengan perincian sebagai berikut:</p>';
      
      echo '<table border="1" style="width: 100%; font-size:0.6em; border-collapse: collapse;">
            <tr>
              <th rowspan="2">No.</td>
              <th rowspan="2">Akun</td>
              <th rowspan="2">Penerima</td>
              <th rowspan="2">Uraian</td>
              <th colspan="2">Bukti</td>
              <th rowspan="2">Jumlah</td>
              <th  colspan="2">Pajak yang dipungut Bendahara Pengeluaran</td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>Nomor</td>
              <th width="10%">PPN</td>
              <th width="10%">PPH</td>
            </tr>';
      $no=1;
      $tot_value = 0;
      $tot_ppn = 0;
      $tot_pph = 0;
      while($data = $this->fetch_array($sql)){
        echo '<tr>
                <td>'.$no.'</td>
                <td>'.$data[kdakun].'</td>
                <td>'.$data[penerima].'</td>
                <td>'.$data[deskripsi].'</td>
                <td>'.$data[tanggal].'</td>
                <td>'."-".'</td>
                <td>'.$data[value].'</td>
                <td>'." ".'</td>
                <td>'." ".'</td>
            </tr>';
            $tot_value += $data[value];
            $no++;
      }
      echo '<tr>
              <td colspan="6">JUMLAH</td>
              <td>'.$tot_value.'</td>
              <td>'.$tot_pph.'</td>
              <td>'.$tot_pph.'</td>
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

    // DAFTAR RINCIAN PERMINTAAN PENGELUARAN
    public function Rincian_Permintaan_Pengeluaran($data){
      $sql = $this->query("SELECT kdakun, penerima, tanggal, sum(value) as jumlah FROM `rabfull` GROUP BY kdakun order by kdakun asc ");
      ob_start();
      echo '<table border="1" style="width: 100%; font-size:0.9em; border-collapse: collapse;">
              <tr>
                <th colspan="7">DAFTAR RINCIAN<br></td>
              </tr>
              <tr>
                <th colspan="7">PERMINTAAN PENGELUARAN<br></td>
              </tr>
              <tr>
                <td >1. Kementrian / Lembaga<br></td>
                <td colspan="2">: Kemenristek Dikti</td>
                <td colspan="2">Jenis SPP<br></td>
                <td>6. Nomor<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>2. Unit Organisasi<br></td>
                <td colspan="2">: Ditjen Kelembagaan Iptek dan Dikti</td>
                <td colspan="2">1. GU NIHIL</td>
                <td>7. KODE KEGIATAN<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>3. Lokasi<br></td>
                <td colspan="2">: : DKI Jakarta<br></td>
                <td colspan="2">PAGU SUB KEGIATAN<br></td>
                <td>8. KODE MAK<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>4. Kantor / Satuan Kerja<br></td>
                <td colspan="2">: Ditjen Kelembagaan Iptek dan Dikti</td>
                <td colspan="2" rowspan="2"></td>
                <td>9. TAHUN ANGGARAN<br></td>
                <td>: 2016</td>
              </tr>
              <tr>
                <td>5. Alamat<br></td>
                <td colspan="2">: : Komplek Kemdikbud Gedung D Lt. 6</td>
                <td>10. Bulan</td>
                <td>:</td>
              </tr>
              <tr>
              <td></td>
                <td colspan="4">Jln. Jend. Sudirman Pintu I Senayan, Jakarta Pusat</td>
                
                
              </tr>
              <tr>
                <td  rowspan="2">No. Urut</td>
                <td  colspan="2">BUKTI PENGELUARAN</td>
                <td  rowspan="2">NPWP</td>
                <td  rowspan="2">MAK</td>
                <td  rowspan="2">NO BUKTI</td>
                <td  rowspan="2">JUMLAH KOTOR YANG DIBAYARKAN (Rp)</td>
              </tr>
              <tr>
                <td >TANGGAL PEMB</td>
                <td >PENERIMA</td>
              </tr>';
      $no=1;
      while($data=$this->fetch_array($sql)){
        echo '<tr>
                <td>'.$no.'</td>
                <td></td>
                <td>SPTB</td>
                <td>-</td>
                <td>'.$data[kdakun].'</td>
                <td>Terlampir Pada SPTB</td>
                <td>'.$data[jumlah].'</td>
              </tr>';
              $no++;
      }
      echo'   <tr>
                <td>Jumlah Lampiran :</td>
                <td colspan="5">Jumlah SPP ini (Rp)</td>
                <td colspan="5"></td>

              </tr>
              <tr>
                <td>7</td>
                <td colspan="5">SPM/SPP Sebelum SPP ini atas beban sub kegiatan ini</td>
                <td colspan="5"></td>
              </tr>
              <tr>
                <td></td>
                <td colspan="5">Jumlah s.d. SPP ini atas beban sub kegiatan ini</td>
                <td colspan="5"></td>
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
    public function Kuitansi_Honorarium($data){
      $penerima="";
      $total=0;
      foreach ($data as $value) {
         $total += $value[value];
         $penerima = $value[penerima];
      }
      echo '  <p align="right">No...............................................</p>'; 
      require __DIR__ . "/../utility/report/header_dikti.php";
      echo '  <p align="center">KUITANSI</p>
                    <table style="width: 100%; font-size:80%; border-collapse: collapse;"  border="0">               
                    <tr>
                        <td align="left">Sudah Terima Dari </td>
                        <td align="left" style="font-weight:bold">: Kuasa Pengguna Anggaran Direktorat Jenderal Kelembagaan IPTEK dan DIKTI</td>
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left">: Rp. '.$total.'</td>
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: </td>
                    </tr>                
                    <tr>
                        <td align="left">Untuk Pembayaran</td>
                        <td align="left">: </td>
                    </tr>                

                    </table>';
        $pph = (15 / 100) * $total;
        $diterima = $total-$pph;      
        echo  '<table style="width: 100%; font-size:80%;"  border="0">';                   
        foreach ($data as $value) {
          echo '<tr>
                  <td width="18%"></td>
                  <td width="40%">'.$value[NMITEM].'</td>
                  <td>'." : Rp. ".$value[value].'</td>
                </tr>';
          }
          echo '<tr>
                  <td ></td>
                  <td >'."Jumlah ".'</td>
                  <td>'." : Rp. ".$total.'</td>
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

      // $html = ob_get_contents();
      // $this->create_pdf("SPPD","A4",$html);

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

      echo '  <table cellpadding="8" style="width: 100%; text-align:center; border-collapse:collapse; font-size:80%;">     
        <tr>
            <td width="9%" style="border:1px solid">NO</td>
            <td style="border:1px solid">PERINCIAN BIAYA</td>
            <td style="border:1px solid">JUMLAH Rp.</td>
            <td style="border:1px solid">KETERANGAN</td>
        </tr>'; 
        $no=1;
        foreach ($data as $value) {
          
          echo '<tr>
                 <td style="border-left:1px solid; border-right:1px solid">'.$no++.'</td>
                 <td style="border-left:1px solid; border-right:1px solid" align="left">'.$value[NMITEM].'</td>
                 <td style="border-left:1px solid; border-right:1px solid">'.$value[value].'</td>
                 <td style="border-left:1px solid; border-right:1px solid"></td>
                </tr>';
                $jml+=$value[value];
          }
          echo '<tr>
                  <td style="border-top:1px solid"></td>
                  <td style="border-top:1px solid"></td>
                  <td style="border-top:1px solid"></td>
                  <td style="border-top:1px solid"></td>
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
            <td>Rp. '.$jml.'</td>
            <td width="23%"></td>
            <td>Rp. '.$jml.'</td>
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
                        <td align="left">: Rp. '.$jml.'</td>
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
    public function Kuitansi_Honor_Uang_Saku($data) {
      $penerima;
      $total=0;
      foreach ($data as $value) {
         $total += $value[value];
         $penerima = $value[penerima];
      }
        echo '  <p align="right">No...............................................</p>';  
        require_once __DIR__ . "/../utility/report/header_dikti.php";
        echo ' <p align="center" style="font-weight:bold; font-size:1.2em">KUITANSI</p>
                    <table style="width: 100%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left" width="20%">Sudah Terima Dari </td>
                        <td align="left">: '.$penerima.'</td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left" style="background-color:gray">: Rp. '.$total.'</td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: '.$this->terbilang($total,1).'</td>
                        <td></td>
                        <td></td>
                    </tr>                
                    <tr>
                        <td align="left">Untuk Pembayaran</td>
                        <td align="left">: '."".'</td>
                        <td></td>
                        <td></td>
                    </tr>'; 
         echo  '</table>';
         $pph = (15 / 100) * $total;
         $diterima = $total-$pph;      
         echo  '<table style="width: 100%; font-size:80%;"  border="0">';                   
        foreach ($data as $value) {
          echo '<tr>
                  <td width="21%"></td>
                  <td width="40%">'.$value[NMITEM].'</td>
                  <td>'." : Rp. ".$value[value].'</td>
                </tr>';
          }
          echo '<tr>
                  <td ></td>
                  <td >'."Jumlah ".'</td>
                  <td>'." : Rp. ".$total.'</td>
                </tr>';
          echo '<tr>
                  <td ></td>
                  <td >'."PPh. 15% ".'</td>
                  <td>'." : Rp. ".$pph.'</td>
                </tr>';
          echo '<tr>
                  <td ></td>
                  <td >'."Diterima ".'</td>
                  <td>'." : Rp. ".$diterima.'</td>
                </tr>';
           echo  '</table>';
        
        
       
        echo '<br></br>
              <table style="text-align: center; width: 100%; font-size:84%; font-family:serif"  >
          
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
                <td><br></br></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td style="text-align: center;">'.'Ridwan'.'</td>
                <td style="text-align: center;">'.'Evi Nursanti'.'</td>
                <td style="text-align: center;">'.'('.$data_rab[penerima].')'.'</td>
              </tr>              

              <tr>
                <td style="text-align: center;">NIP'.'196212101992031001'.'</td>
                <td style="text-align: center;">NIP'." ".'196203051986022001'.'</td>
                <td style="text-align: center;"></td>
              </tr>
              </table>';
              echo '<p>__ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __</p>';

                echo '<table style=" text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;  font-size:0.8em; font-family:serif; "  align="center">
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
                        <td align="left">:'.$data_rab[penerima].' </td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">NPWP</td>
                        <td align="left">:'.$data_rab[npwp].'</td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">Alamat</td>
                        <td align="left">: </td>
                    </tr>                             
                  </table>';
        echo '<table style="text-align: left; width: 100%; font-size:84%; font-family:serif"  >
              <tr>
                <td width="25%"> Penghasilan </td>
                <td width="25%">Jumlah</td>
                <td width="25%">Tarif</td>
                <td width="25%">Pph yang dipotong</td>
              </tr>';
        $no=1;
        $tot_pot=0;
        foreach ($data as $value) {
          $pot = (15/100)*$value[value];
          $tot_pot +=$pot;
          echo '<tr>
                  <td>'.$no.". ".$value[NMITEM].'</td>
                  <td>'.$value[value].'</td>
                  <td>15%</td>
                  <td>'."Rp. ".$pot.'</td>
                </tr>';
          $no++;
          }  
          echo '<tr>
                  <td></td>
                  <td></td>
                  <td>JUMLAH</td>
                  <td>'."Rp. ".$tot_pot.'</td>
                </tr>
              </table>';

         echo '<table style="text-align: left; width: 100%; font-size:84%; font-family:serif"  >
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

    public function rekap_keg($data) {
      ob_start();
      echo '<table>
              <tr>
                <th rowspan="2"></td>
                <th rowspan="2"></td>
                <th rowspan="2"></td>
                <th rowspan="2"></td>
                <th colspan="3"></td>
                <th colspan="3"></td>
                <th rowspan="2"></td>
                <th rowspan="2"></td>
                <th colspan="2"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
          </table>';
      $html = ob_get_contents(); 
      $this->create_pdf("Rinc_perjalanan_dinas","A4",$html);
      
    }

public function daftar_peng_riil($data){
  $penerima="";
  foreach ($data as $value) {
    $penerima = $value[penerima];
  }
  // ob_start();
      echo '<h2 align="center">DAFTAR PENGELUARAN RIIL<h2>
          <h5>Yang bertanda tangan dibawah ini :<h5>';
      echo '<table border=1 style="width: 100%; text-align:left; border-collapse:collapse; font-size:80%;">
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
                  <td>'." : Rp. ".$value[value].'</td>
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
      echo  '<table cellpadding="3" style="width: 100%;  text-align:left; border-collapse:collapse; font-size:80%;">
            <tr>
              <td style="text-align:center;" colspan="6"><h4>PENGAJUAN UANG MUKA KERJA (UMK)</h4> </td>
            </tr>
            <tr>
              <td style="text-align:center;" colspan="6"><h4>RINCIAN KEBUTUHAN DANA</h4></td>
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
                <td colspan="3">'.$res2[tanggal].'</td>
                
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
                <td>:</td>
                <td>'.$rs[value].'</td>
              </tr>';
              $no++;
              $tot+=$rs[value];
        }
        echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td>JUMLAH</td>
                <td>: </td>
                <td>'.$tot.'</td>
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
                <td>Jakarta, ................................. 2016</td>
              </tr>
              <tr>
                <td></td>
                <td style="border: 1px solid black; " >Kuasa Pengguna Anggaran</td>
                <td></td>
                <td style="border: 1px solid black;">Bendahara Pengeluaran</td>
                <td></td>
                <td style="border: 1px solid black;">Pejabat Pembuat Komitmen</td>
              </tr>
              <tr>
                <td><br></br><p></p></td>
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
