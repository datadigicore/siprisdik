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
            <?php echo "<pre>";print_r($insert);die; include "view/include/alert.php" ?>
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
            <table id="example" class="display table table-striped table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Position</th>
                      <th></th>
                      <th></th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Position</th>
                      <th></th>
                      <th></th>
                  </tr>
              </tfoot>
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
<script type="text/javascript">
  function format ( d ) {
    return '<div class="table-responsive col-md-6" style="padding:1px;">'+
      '<table class="table table-striped table-hover table-bordered tab-pad-0" cellpadding="5" cellspacing="0" border="0">'+
        '<tr>'+
          '<td>Honorarium</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Nilai</td>'+
          '<td>:</td>'+
          '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Pajak</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Status Dana</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>PAGU</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Realisasi</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Usulan Sebelum</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Usulan Sesudah</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
      '</table>'+
      '</div>'+
      '<div class="table-responsive col-md-6" style="padding:1px;">'+
      '<table class="table table-striped table-hover table-bordered tab-pad-0" cellpadding="5" cellspacing="0" border="0">'+
        '<tr>'+
          '<td>Biaya Perjalanan Dinas</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Kota Asal</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Kota Tujuan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tingkat Perjalanan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Alat Transportasi</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Rute</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Taxi Asal</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Taxi Tujuan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Dana Harian</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tanggal Berangkat</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tanggal Akhir</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Total Nilai</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Pajak</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
      '</table>'+
    '</div>';
}
 
$(document).ready(function() {
    var table_data_json = '[{"name":"Tiger Nixon","position":"System Architect","salary":"$320,800","start_date":"2011/04/25","office":"Edinburgh","extn":"5421"},{"name":"Garrett Winters","position":"Accountant","salary":"$170,750","start_date":"2011/07/25","office":"Tokyo","extn":"8422"},{"name":"Ashton Cox","position":"Junior Technical Author","salary":"$86,000","start_date":"2009/01/12","office":"San Francisco","extn":"1562"}]';
      $('#example').DataTable( {
        "data": JSON.parse(table_data_json),
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "salary" }
        ],
        "order": [[1, 'asc']]
    } );
    $("#example").DataTable().rows().every( function () {
        this.child(format(this.data())).show();
        this.nodes().to$().addClass('shown');
    });  
} );
</script>