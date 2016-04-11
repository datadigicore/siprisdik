<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>"> Orang/Badan </a>
        >
        Upload Orang / Badan 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <table class="display table table-bordered table-striped">
              <tr>
                <th colspan='2'><label>Info</label></th>
              </tr>
              <tr>
                <td valign="top" class="col-md-1">
                  <table class="table-striped col-md-12">
                      <tr><td valign="top">Tahun</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->THANG?></td></tr>
                      <tr><td valign="top">Kegiatan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMGIAT?></td></tr>
                      <tr><td valign="top">Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMOUTPUT?></td></tr>
                      <tr><td valign="top">Sub Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMSOUTPUT?></td></tr>
                      <tr><td valign="top">Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMKMPNEN?></td></tr>
                      <tr><td valign="top">Sub Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NmSkmpnen?></td></tr>
                  </table>
                </td>
                <td class="col-md-1">
                  <table class="table-striped col-md-12">
                      <tr><td valign="top">Uraian Acara</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $view['deskripsi']; ?></td></tr>
                      <tr><td valign="top">Tanggal</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo date("d M Y",strtotime($view['tanggal'])).' - '.date("d M Y",strtotime($view['tanggal_akhir'])); ?></td></tr>
                      <tr><td valign="top">Lokasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $view['tempat'].', '.$view['lokasi']; ?></td></tr>
                      <tr><td valign="top">Alokasi Anggaran</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['jumlah'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Jumlah Realisasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['realisasi'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Jumlah Usulan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['usulan'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Sisa</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format(($jumlah['jumlah'] - ($jumlah['realisasi'] + $jumlah['usulan'])),2,',','.'); ?></td></tr>
                  </table>
                </td>
            </table>
            <br>
            <table id="example"  class="table table-striped table-hover table-bordered">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Nama</th>
                  <th rowspan="2">Asal</th>
                  <th rowspan="2">NPWP</th>
                  <th rowspan="2">NIP</th>
                  <th rowspan="2">Golongan</th>
                  <th rowspan="2">PNS/Non PNS</th>
                  <th rowspan="2">PAJAK</th>
                  <th rowspan="2">Jabatan</th>
                  <th>Honor Output</th>
                  <th>Honor Profesi</th>
                  <th>Uang Saku</th>
                  <th>Transport Lokal</th>
                  <th>Uang Representatif</th>
                  <th>Uang Harian</th>
                  <th>Tiket</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                  <th rowspan="2">Lama Hari</th>
                  <th rowspan="2">Tingkat dalam Perjalanan Dinas</th>
                  <th rowspan="2">Alat Transportasi</th>
                  <th rowspan="2">Kota Asal</th>
                  <th rowspan="2">Kota Tujuan</th>
                  <th colspan="2">Taxi Asal</th>
                  <th colspan="2">Taxi Tujuan</th>
                  <th>Perjalanan Darat</th>
                  <th>Airportax</th>
                  <th colspan="2">Rute 1</th>
                  <th colspan="2">Rute 2</th>
                  <th colspan="2">Rute 3</th>
                  <th colspan="2">Rute 4</th>
                  <th>Harga Tiket</th>
                  <th rowspan="2">Kelompok HR</th>
                  <th rowspan="2">Malam</th>
                  <th>Biaya Akom</th>
                  <th colspan="3">Belanja Bahan 521211</th>
                  <th>Belanja Gaji Pokok PNS</th>
                  <th>Belanja Pembulatan Gaji PNS</th>
                  <th>Belanja Tunj. Suami/Istri PNS</th>
                  <th>Belanja Tunj. Anak PNS</th>
                  <th>Belanja Tunj. Struktural PNS</th>
                  <th>Belanja Tunj. PPh PNS</th>
                  <th>Belanja Tunj. Beras PNS</th>
                  <th>Belanja Uang Makan PNS</th>
                  <th>Belanja Tunj. Khusus Peralihan PNS</th>
                  <th>Belanja Tunj. Lain-lain</th>
                  <th>Belanja Tunj. Umum PNS</th>
                  <th>Belanja Uang Lembur</th>
                  <th>Belanja Pegawai Transito</th>
                  <th>Belanja Keperluan Perkantoran</th>
                  <th>Belanja Penambah Daya Tahan Tubuh</th>
                  <th>Belanja pengiriman  surat pos </th>
                  <th>Honor Operasional Satker</th>
                  <th>Belanja Barang Operasional Lainnya</th>
                  <th>Belanja Barang untuk persediaan Barang Konsumsi</th>
                  <th>Belanja Jasa Konsultan</th>
                  <th>Belanja Sewa</th>
                  <th>Belanja Modal Peralatan dan Mesin</th>
                  <th>Belanja Biaya Pemeliharaan Peralatan dan Mesin</th>
                  <th>Belanja Penambahan Nilai Gedung dan Bangunan</th>
                  <th>Belanja Modal Lainnya</th>
                  <th rowspan="2">Status</th>
                </tr>
                <tr>
                  <th>521213</th>
                  <th>522151</th>
                  <th>524113 / 524114</th>
                  <th>524113 / 524114</th>
                  <th>524111/524113/524114 / 524119</th>
                  <th>524111/524114 / 524119/524211</th>
                  <th>524111/524119/524211</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111/524119</th>
                  <th>524111/524119/524211</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111/524119</th>
                  <th>524113/524114/524119</th>
                  <th>ATK</th>
                  <th>Bahan Habis Pakai</th>
                  <th>Konsumsi</th>
                  <th>511111</th>
                  <th>511119</th>
                  <th>511121</th>
                  <th>511122</th>
                  <th>511123</th>
                  <th>511125</th>
                  <th>511126</th>
                  <th>511129</th>
                  <th>511133</th>
                  <th>511147</th>
                  <th>511151</th>
                  <th>512211</th>
                  <th>512412</th>
                  <th>521111</th>
                  <th>521113</th>
                  <th>521114</th>
                  <th>521115</th>
                  <th>521119</th>
                  <th>521811</th>
                  <th>522131</th>
                  <th>522141</th>
                  <th>532111</th>
                  <th>523121</th>
                  <th>533121</th>
                  <th>536111</th>
                </tr>
              </thead>
              <tbody>
                <?php for ($i=0; $i < count($insert); $i++) { ?>
                      <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo $insert[$i]->penerima ?></td>
                        <td><?php echo $insert[$i]->kdakun ?></td>
                        <td><?php echo 'Rp '.number_format($insert[$i]->value, 2) ?></td>
                        <td><?php echo $insert[$i]->error ?></td>
                      </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>

<script>
var oTable;
$(document).ready(function() {
    $('#example').DataTable( {
      "info":false,
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/table_upload",
        "type": "POST",
        "data": {'id_rab_view':'<?php echo $id_rab_view;?>' }
      }
    });
} );
</script>
