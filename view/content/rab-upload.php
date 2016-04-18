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
          <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab_rinci/save_dataimport">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <table class="display table table-bordered table-striped">
              <tr>
                <th colspan='2'><label>Info</label></th>
                <th><label>Keterangan Tabel</label></th>
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
                <td valign="top" class="col-md-1">
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
                <td valign="top" class="col-md-1">
                  <table class="table-striped col-md-12">
                      <tr><td valign="top"><span class="label label-success">Hijau</span></td><td valign="top">&nbsp;</td><td valign="top">Jumlah Usulan Telah Valid</td></tr>
                      <tr><td valign="top"><span class="label label-warning">Kuning</span></td><td valign="top">&nbsp;</td><td valign="top">Jumlah Usulan Melebihi PAGU</td></tr>
                      <tr><td valign="top"><span class="label label-danger">Merah</span></td><td valign="top">&nbsp;</td><td valign="top">Tidak Terdapat Kode Akun dalam Kegiatan Tersebut</td></tr>
                  </table>
                </td>
            </table>
            <br>
            <table id="example"  class="table table-striped table-hover table-bordered">
              <thead style="background-color:#11245B;color:white;">
                <tr style="background-color:#0000BB;color:white;">
                  <th style="background-color:#FFFFFF;" colspan="41">-</th>
                  <th colspan="11"><center>RUTE 1</center></th>
                  <th colspan="11"><center>RUTE 2</center></th>
                  <th colspan="11"><center>RUTE 3</center></th>
                  <th colspan="11"><center>RUTE 4</center></th>
                </tr>
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Jenis</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
                  <th rowspan="2">val</th>
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
                  <th>Biaya Akom (Hotel)</th>
                  <th colspan="3">Belanja Bahan 521211</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                  <th rowspan="2">Tingkat dlm Perjalanan Dinas</th>
                  <th rowspan="2">Kota Asal</th>
                  <th rowspan="2">Kota Tujuan</th>
                  <th rowspan="2">Alat Transportasi</th>
                  <th colspan="2">Rute 1</th>
                  <th colspan="2">Taxi Asal</th>
                  <th colspan="2">Taxi Tujuan</th>
                  <th>Uang Harian</th>
                  <th rowspan="2">Lama Hari</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                  <th rowspan="2">Alat Transportasi</th>
                  <th colspan="2">Rute 1</th>
                  <th colspan="2">Taxi Asal</th>
                  <th colspan="2">Taxi Tujuan</th>
                  <th>Uang Harian</th>
                  <th rowspan="2">Lama Hari</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                  <th rowspan="2">Alat Transportasi</th>
                  <th colspan="2">Rute 1</th>
                  <th colspan="2">Taxi Asal</th>
                  <th colspan="2">Taxi Tujuan</th>
                  <th>Uang Harian</th>
                  <th rowspan="2">Lama Hari</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                  <th rowspan="2">Alat Transportasi</th>
                  <th colspan="2">Rute 1</th>
                  <th colspan="2">Taxi Asal</th>
                  <th colspan="2">Taxi Tujuan</th>
                  <th>Uang Harian</th>
                  <th rowspan="2">Lama Hari</th>
                  <th rowspan="2">Tanggal Berangkat</th>
                  <th rowspan="2">Tanggal Kembali</th>
                </tr>
                <tr>
                  <th>521213</th>
                  <th>522151</th>
                  <th>524113 / 524114</th>
                  <th>524113 / 524114</th>
                  <th>524111 / 524113 / 524114 / 524119</th>
                  <th>524113 / 524114 / 524119</th>
                  <th>ATK</th>
                  <th>Bahan Habis Pakai</th>
                  <th>Konsumsi</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111 / 524114 / 524119 / 524211</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111 / 524114 / 524119 / 524211</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111 / 524114 / 524119 / 524211</th>
                  <th>524111/524119/524211</th>
                  <th>Harga Tiket</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111</th>
                  <th>524119</th>
                  <th>524111 / 524114 / 524119 / 524211</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <?php if($stat_err == 0) { ?>
          <div class="box-footer" align="center">
            <button type="submit" class="btn btn-flat btn-lg btn-success"><i class="fa fa-save"></i> Simpan</button>
          </div>
          <?php } ?>
          </form>
        </div>        
      </div>
    </div>
  </section>
</div>

<script>
var oTable;
  $(function () {
    $('#example').DataTable( {
      "info":false,
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "columnDefs" : [
            {"targets" : 0,
             "visible" : false},
            {"targets" : 1,
             "visible" : false},
            {"targets" : 2,
             "visible" : false},
            {"targets" : 3,
             "visible" : false},
            {"targets" : 4,
             "visible" : false},
            {"targets" : 5,
             "visible" : false},
            {"targets" : 6,
             "visible" : false},
            {"targets" : 7,
             "visible" : false},
            {"targets" : 8,
             "visible" : false},
            {"targets" : 9,
             "visible" : false},
            {"targets" : 10,
             "visible" : false},
            {"targets" : 11,
             "visible" : false},
            {"targets" : 12,
             "visible" : false},
            {"targets" : 13,
             "visible" : false},
            {"targets" : 14,
             "visible" : false},
            {"targets" : 15,
             "visible" : false},
            {"targets" : 16,
             "visible" : false},
            {"targets" : 17,
             "visible" : false},
            {"targets" : 18,
             "visible" : false},
            {"targets" : 19},
            {"targets" : 20},
            {"targets" : 21},
            {"targets" : 22},
            {"targets" : 23},
            {"targets" : 24},
            {"targets" : 25},
            {"targets" : 26},
            {"targets" : 27},
            {"targets" : 28},
            {"targets" : 29},
            {"targets" : 30},
            {"targets" : 31},
            {"targets" : 32},
            {"targets" : 33},
            {"targets" : 34},
            {"targets" : 35},
            {"targets" : 36},
            {"targets" : 37},
            {"targets" : 38},
            {"targets" : 39},
            {"targets" : 40},
            {"targets" : 41},
            {"targets" : 42},
            {"targets" : 43},
            {"targets" : 44},
            {"targets" : 45},
            {"targets" : 46},
            {"targets" : 47},
            {"targets" : 48},
            {"targets" : 49},
            {"targets" : 50},
            {"targets" : 51},
            {"targets" : 52},
            {"targets" : 53},
            {"targets" : 54},
            {"targets" : 55},
            {"targets" : 56},
            {"targets" : 57},
            {"targets" : 58},
            {"targets" : 59},
            {"targets" : 60},
            {"targets" : 61},
            {"targets" : 62},
            {"targets" : 63},
            {"targets" : 64},
            {"targets" : 65},
            {"targets" : 66},
            {"targets" : 67},
            {"targets" : 68},
            {"targets" : 69},
            {"targets" : 70},
            {"targets" : 71},
            {"targets" : 72},
            {"targets" : 73},
            {"targets" : 74},
            {"targets" : 75},
            {"targets" : 76},
            {"targets" : 77},
            {"targets" : 78},
            {"targets" : 79},
            {"targets" : 80},
            {"targets" : 81},
            {"targets" : 82},
            {"targets" : 83},
            {"targets" : 84},
          ],
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/table_upload",
        "type": "POST",
        "data": {'id_rab_view':'<?php echo $id_rab_view;?>' }
      }
    });
} );

$(document).ready(function() {
  <?php if($stat_err == 1) { ?>
  $.ajax({
    url: "<?php echo $url_rewrite;?>process/rab_rinci/deltemprab",
    type: "POST",
    data: {'id_rab_view':'<?php echo $id_rab_view;?>' }
  }).done(function() {
    alert('berhasil dihapus');
  });
  <?php }?>
  });
</script>
