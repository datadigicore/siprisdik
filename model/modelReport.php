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

    public function kuitansi($data) {
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
