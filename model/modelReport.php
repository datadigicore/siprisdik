<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";
  require_once __DIR__ . "/../library/mPDF/mpdf.php";

  class modelReport extends mysql_db {
    
    public function create_pdf($name, $size, $html){
        ob_end_clean();
        $mpdf=new mPDF('utf-8', $size); 
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($name.".pdf" ,'I');
        exit;
    }

    public function header_dikti(){
      echo '<table style=" text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.8em; font-family:serif; "  align="center">
                <tr>
                    <td rowspan="4" width="7%"><img src="<../../static/dist/img/risetdikti.png" height="8%" /></td>
                    <td style= "vertical-align: bottom;">KEMENTERIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</td>
                    
                </tr>
                <tr>
                    <td style= "vertical-align: bottom;">DIREKTORAT JENDERAL KELEMBAGAAN </td>
                </tr>
                <tr>
                    <td style= "vertical-align: bottom;">ILMU PENGETAHUAN TEKNOLOGI DAN PENDIDIKAN TINGGI</td>
                </tr>                       
                </table>
                <tr>
                    <td style= "vertical-align: top;">________________________________________________________________________________________________________________________________</td>
                </tr> 
                
                '; 

    }

    public function kuitansi($data){
      ob_start();  
      $this->header_dikti();
      echo '  <p align="center">KUINTANSI</p>
                    <table style="width: 100%; font-size:80%;"  border="0">               
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

      $html = ob_get_contents();
      $this->header_dikti();
      $this->create_pdf("SPPD","A4",$html);

    }

    public function kuitansi4($data){
      ob_start();  
      $this->header_dikti();
      echo '  <table style="width: 50%; font-size:80%;"  border="0">               
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
              <table style="text-align: left; width: 100%; font-size:84%; font-family:serif"  >

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

    public function kuitansi3($data){
      ob_start();  
      $this->header_dikti();
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
        </tr> 
        <tr>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>4</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>5</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>6</td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 
      </table>';
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
            <td>Rp. ........................</td>
            <td width="23%"></td>
            <td>Rp .........................</td>
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
                        <td align="left">: Rp ..............................................</td>
                    </tr> 
                    <tr>
                        <td align="left">Yang telah dibayat semula</td>
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

    public function kuitansi2($data) {
        ob_start();  
        $this->header_dikti();
        echo ' <p align="center" style="font-weight:bold; font-size:1.2em">KUINTANSI</p>
                    <table style="width: 50%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left">Sudah Terima Dari </td>
                        <td align="left">: </td>
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
                    <td rowspan="4" width="7%"><img src="<../../static/dist/img/dirjenpajak.png" height="8%" /></td>
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
        echo '  <table style="width: 50%; font-size:80%;"  border="0">               
                    <tr>
                        <td align="left">Nama Wajib Pajak </td>
                        <td align="left">: </td>
                    </tr> 
                    <tr>
                        <td align="left">NPWP</td>
                        <td align="left">:</td>
                    </tr> 
                    <tr>
                        <td align="left">Alamat</td>
                        <td align="left">: </td>
                    </tr>                             

                  </table>';
        echo '<br></br>
              <table style="text-align: center; width: 100%; font-size:84%; font-family:serif"  >
          
              <tr>
                <td style="text-align: center;"> Penghasilan  </td>
                <td style="text-align: center;">Jumlah</td>
                <td style="text-align: center;">Tarif</td>
                <td style="text-align: center;">Pph yang dipotong</td>
              </tr>              
              <tr>
                <td style="text-align: center;">1. Honorarium</td>
                <td style="text-align center;">Rp.................</td>
                <td style="text-align: center;">................... %</td>
                <td style="text-align: center;">Rp................... </td>
              </tr>

              <tr>
                <td style="text-align: center;">2. Imbalan Lainnya</td>
                <td style="text-align center;">Rp.................</td>
                <td style="text-align: center;">................... %</td>
                <td style="text-align: center;">Rp................... </td>
              </tr>
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align center;"></td>
                <td style="text-align: center;">JUMLAH</td>
                <td style="text-align: center;">Rp................... </td>
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
  }

?>
