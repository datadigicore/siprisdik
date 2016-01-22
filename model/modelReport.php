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
    public function SPTB($data){
      ob_start();
      echo '<p align="center" style="font-weight:bold; text-decoration: underline;">SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</p>';
      echo '<p align="center" style="font-weight:bold;">Nomor : </p>';
      echo '<table style="width: 100%; font-size:0.65em;"  border="0">               
              <tr>
                <td align="left" width="1%">1.</td>
                <td align="left" width="1%"></td>
                <td align="left" width="30%">Kode Satuan Kerja</td>
                <td align="left" width="2%">:</td>
                <td align="left" >a</td>
              </tr>
              <tr>
                <td align="left" width="1%">2.</td>
                <td align="left" width="1%"></td>
                <td align="left" width="30%">Nama Satuan Kerja</td>
                <td align="left" width="2%">:</td>
                <td align="left" >a</td>
              </tr>
              <tr>
                <td align="left" width="1%">3.</td>
                <td align="left" width="1%"></td>
                <td align="left" width="30%">Tanggal/No.DIPA</td>
                <td align="left" width="2%">:</td>
                <td align="left" >a</td>
              </tr>
              <tr>
                <td align="left" width="1%">4.</td>
                <td align="left" width="1%"></td>
                <td align="left" width="30%">Klasifikasi Mata Anggaran</td>
                <td align="left" width="2%">:</td>
                <td align="left" >a</td>
              </tr>
            </table>';
      echo '<p align="center" style="font-weight:bold;">______________________________________________________________________________________________________</p>';
      echo '<p align="left" style="font-size:0.65em;">Yang    bertandatangan  di    bawah  ini    atas  nama    Kuasa    Pengguna    Anggaran    Satuan Kerja Direktorat Jendral Kelembagaan Ilmu Pengetahuan Teknologi Dan Pendidikan Tinggi menyatakan  bahwa  saya  bertanggungjawab  secara  formal  dan  material  atas 
            segala  pengeluaran  yang  telah  dibayar  lunas  oleh  Bendahara  Pengeluaran  kepada  yang  berhak menerima  serta  kebenaran  perhitungan  dan  setoran  pajak  yang  telah  dipungut  atas  pembayaran tersebut dengan perincian sebagai berikut:</p>';
      
      echo '<table border="1" style="width: 100%; font-size:0.6em; border-collapse: collapse;">
            <tr>
              <th rowspan="2">No.</th>
              <th rowspan="2">Akun</th>
              <th rowspan="2">Penerima</th>
              <th rowspan="2">Uraian</th>
              <th colspan="2">Bukti</th>
              <th rowspan="2">Jumlah</th>
              <th  colspan="2">Pajak yang dipungut Bendahara Pengeluaran</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Nomor</th>
              <th width="10%">PPN</th>
              <th width="10%">PPH</th>
            </tr>
          </table>';
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
      ob_start();
      echo '<table border="1" style="width: 100%; font-size:0.9em; border-collapse: collapse;">
              <tr>
                <th colspan="7">DAFTAR RINCIAN<br></th>
              </tr>
              <tr>
                <th colspan="7">PERMINTAAN PENGELUARAN<br></td>
              </tr>
              <tr>
                <td >1. Kementrian / Lembaga<br></td>
                <td colspan="2">:</td>
                <td colspan="2">Jenis SPP<br></td>
                <td>6. Nomor<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>2. Unit Organisasi<br></td>
                <td colspan="2">:<br></td>
                <td colspan="2"></td>
                <td>7. KODE KEGIATAN<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>3. Lokasi<br></td>
                <td colspan="2">:<br></td>
                <td colspan="2">PAGU SUB KEGIATAN<br></td>
                <td>8. KODE MAK<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>4. Kantor / Satuan Kerja<br></td>
                <td colspan="2">:<br></td>
                <td colspan="2" rowspan="2"></td>
                <td>9. TAHUN ANGGARAN<br></td>
                <td>:</td>
              </tr>
              <tr>
                <td>5. Alamat<br></td>
                <td colspan="2">:</td>
                <td>10. Bulan<br></td>
                <td>:</td>
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
              </tr>
              <tr>
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
      ob_start(); 
      echo '  <p align="right">No...............................................</p>'; 
      require_once __DIR__ . "/../utility/report/header_dikti.php";
      echo '  <p align="center">KUINTANSI</p>
                    <table style="width: 100%; font-size:80%; border-collapse: collapse;"  border="0">               
                    <tr>
                        <td align="left">Sudah Terima Dari </td>
                        <td align="left" style="font-weight:bold">: Kuasa Pengguna Anggaran Direktorat Jenderal Kelembagaan IPTEK dan DIKTI</td>
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left">: Rp. </td>
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
                <td>'.'(..................................)'.'</td>
              </tr>              

              <tr>
                <td>NIP'.'..........................'.'</td>
                <td>NIP'." ".'..........................'.'</td>
                <td></td>
              </tr>
              </table>';

      $html = ob_get_contents();
      $this->create_pdf("SPPD","A4",$html);

    }

    //SPPD SURAT PERINTAH PERJALANAN DINAS
    public function SPPD($data){
      ob_start();  
      require_once __DIR__ . "/../utility/report/header_dikti.php";
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
                      <td colspan="2"></td>
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
                      <td>Maksud Perjakanan Dinas</td>
                      <td colspan="2"></td>
                    </tr> 
                    <tr>
                      <td>5</td>
                      <td>Alat Angkutan yang dipergunakan</td>
                      <td colspan="2"></td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>
                          <p> a.  Tempat Berangkat</p>
                          <p> b.  Tempat Tujuan</p>
                      </td>
                      <td colspan="2"></td>
                    </tr> 
                    <tr>
                      <td>7</td>
                      <td>
                          <p>a.  Lamanya perjalanan dinas</p>
                          <p>b.  Tanggal berangkat</p>
                          <p>c.  Tanggal kembali/tiba di Tempat baru *)</p>

                      </td>
                      <td colspan="2"></td>
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
      $html = ob_get_contents();
      $this->create_pdf("SPPD","A4",$html);

    }

    //Rincian Biaya Perjalanan Dinas
    public function Rincian_Biaya_PD($data){
      
      $no=1;
      $jml=0;
      $id = $data;
      $result = $this->query("SELECT penerima, value, npwp, deskripsi, honor_output, honor_profesi, pajak FROM rabfull where rabview_id='$id' ");
      // $data = $this->fetch_array($result);

      ob_start();  
      require_once __DIR__ . "/../utility/report/header_dikti.php";
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

      echo '  <table style="width: 100%; text-align:center; border-collapse:collapse; font-size:80%;"  border="1">     
        <tr>
            <td width="9%">NO</td>
            <td>PERINCIAN BIAYA</td>
            <td>JUMLAH Rp.</td>
            <td>KETERANGAN</td>
        </tr>'; 

      while($data=$this->fetch_array($result)){
        echo '<tr>
                <td>'.$no++.'</td>
                <td>'.$data[deskripsi].'</td>
                <td>'.$data[value].'</td>
                <td></td>
              </tr>';
        $jml +=$data[value];

      }

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
      $html = ob_get_contents();
      $this->create_pdf("RB_Perjalanan_Dinas","A4",$html);

    }

    //Kuitansi Honor Dan Uang Saku
    public function Kuitansi_Honor_Uang_Saku($data) {
      $id = $data;
      $result = $this->query("SELECT penerima, value, npwp, deskripsi, honor_output, honor_profesi, pajak FROM rabfull where id='$id' ");
      $data = $this->fetch_array($result);
        ob_start();
        echo '  <p align="right">No...............................................</p>';  
        require_once __DIR__ . "/../utility/report/header_dikti.php";
        echo ' <p align="center" style="font-weight:bold; font-size:1.2em">KUINTANSI</p>
                    <table style="width: 100%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left" width="20%">Sudah Terima Dari </td>
                        <td align="left">: '.$data[penerima].'</td>
                    </tr> 
                    <tr>
                        <td align="left">Jumlah Uang</td>
                        <td align="left" style="background-color:gray">: Rp. '.$data[value].'</td>
                    </tr> 
                    <tr>
                        <td align="left">Uang Sebesar</td>
                        <td align="left">: '.$this->terbilang($data[value],1).'</td>
                    </tr>                
                    <tr>
                        <td align="left">Untuk Pembayaran</td>
                        <td align="left">: '.$data[deskripsi].'</td>
                    </tr>                

                    </table>';
    
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
                <td><br></br> <br></br> <br></br></td>
                <td><br></br> <br></br> <br></br></td>
              </tr>
              <tr>
                <td style="text-align: center;">'.'..................................'.'</td>
                <td style="text-align: center;">'.'..................................'.'</td>
                <td style="text-align: center;">'.'(..................................)'.'</td>
              </tr>              

              <tr>
                <td style="text-align: center;">NIP'.'..........................'.'</td>
                <td style="text-align: center;">NIP'." ".'..........................'.'</td>
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
                        <td align="left">:'.$data[penerima].' </td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">NPWP</td>
                        <td align="left">:'.$data[npwp].'</td>
                    </tr> 
                    <tr>
                        <td align="left" width="17%">Alamat</td>
                        <td align="left">: </td>
                    </tr>                             

                  </table>';
        echo '<br></br>
              <table style="text-align: left; width: 100%; font-size:84%; font-family:serif"  >
          
              <tr>
                <td > Penghasilan </td>
                <td >Jumlah</td>
                <td >Tarif</td>
                <td >Pph yang dipotong</td>
              </tr>              
              <tr>
                <td >1. Honorarium</td>
                <td style="text-align center;">Rp.................</td>
                <td >................... %</td>
                <td >Rp................... </td>
              </tr>

              <tr>
                <td >2. Imbalan Lainnya</td>
                <td style="text-align center;">Rp.................</td>
                <td >................... %</td>
                <td >Rp................... </td>
              </tr>
              <tr>
                <td ></td>
                <td style="text-align center;"></td>
                <td >JUMLAH</td>
                <td >Rp................... </td>
              </tr>
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Jakarta, .............................................</td>
              </tr>

              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center; font-size:0.7em;">Pemotong Pajak :</td>
              </tr>
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td width="27%" style="text-align: center; font-size:0.7em;">Nama  : Bendahara Pengeluaran Direktorat Jenderal Kelembagaann IPTEK dan DIKTI</td>
              </tr>
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td width="27%" style="text-align: center; font-size:0.7em;">NPWP : 00.493.675.3-077.000</td>
              </tr>
              <br></br>
              <br></br>
              <br></br>
              <br></br>
              <tr >
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Josephine Margaretta</td>
              </tr>
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">NIP. 19870613 201012 2 009</td>
              </tr>



              </table>';
        
        $html = ob_get_contents(); 
        $this->create_pdf("Kw_Honor_Uang_Saku","A4",$html);
        
    }

    public function rekap_keg($data) {
      ob_start();
      echo '<table>
              <tr>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th colspan="3"></th>
                <th colspan="3"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th colspan="2"></th>
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

    public function deletePengguna($id) {
      
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
    return $hasil;
}
  }

?>
