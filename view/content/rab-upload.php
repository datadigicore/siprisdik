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
            </table>
            <br>
            <table id="example"  class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Asal</th>
                  <th>NPWP</th>
                  <th>NIP</th>
                  <th>Golongan</th>
                  <th>PNS/Non PNS</th>
                  <th>PAJAK</th>
                  <th>Jabatan</th>
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
<script type="text/javascript">
var table_data_json = '[{"name":"Tiger Nixon","position":"System Architect","salary":"$320,800","start_date":"2011/04/25","office":"Edinburgh","extn":"5421"},{"name":"Garrett Winters","position":"Accountant","salary":"$170,750","start_date":"2011/07/25","office":"Tokyo","extn":"8422"},{"name":"Ashton Cox","position":"Junior Technical Author","salary":"$86,000","start_date":"2009/01/12","office":"San Francisco","extn":"1562"}]';

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
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
            {"targets" : 1},
            {"targets" : 2},
            {"targets" : 3},
            {"targets" : 4},
          ],
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/table_upload",
        "type": "POST",
        "data": {'id_rab_view':'<?php echo $id_rab_view;?>' }
      }
    });
     
    // Add event listener for opening and closing details
    $("#example").DataTable().rows().every( function () {
        this.child(format(this.data())).show();
        this.nodes().to$().addClass('shown');
    } );
} );
</script>