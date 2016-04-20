<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Upload Realisasi
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        Upload Realisasi
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
    	<div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Upload Data Realisasi</h3>
            <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          </div>
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <form action="<?php echo $url_rewrite;?>process/rab/importrkaklreal" method="POST" enctype="multipart/form-data">
		        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		            <span aria-hidden="true" style="color:white">×</span></button>
		          <h4 class="modal-title">Import Data Realisasi</h4>
		        </div>
		        <div class="modal-body">
		          <input type="hidden" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
		          <input type="hidden" id="adendum" name="adendum" value="<?php echo $status;?>" />
		          <input type="hidden" id="jenisimport" name="jenisimport" value="" />
		          <div class="form-group">
		            <label>Download Template <a href="<?php echo $url_rewrite;?>template/TemplateRkaklRealisasi.xls" download>Here</a>.</label>
		          </div>
		          <div class="form-group">
		            <input type="file" id="fileimport" name="fileimport" style="display:none;">
		            <a id="selectbtn" class="btn btn-flat btn-primary" style="position:absolute;right:16px;">Select File</a>
		            <input type="text" id="filename" class="form-control" placeholder="Pilih File .xls / .xlsx" readonly>
		          </div>
		        </div>
		        <div class="modal-footer">
		          <button type="submit" class="btn btn-flat btn-success">Import Data</button>
		        </div>
		      </form>
		    </div>
		  </div>

          <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab/save_import_real">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Upload Data Realisasi</h3>
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <table class="table-striped col-md-12">
              <tr><th colspan="3">Keterangan</th></tr>
                <tr><td valign="top"><span class="label label-warning">Kuning</span></td><td valign="top">&nbsp;</td><td valign="top">Jumlah Usulan Melebihi PAGU</td></tr>
                <tr><td valign="top"><span class="label label-danger">Merah</span></td><td valign="top">&nbsp;</td><td valign="top">Tidak Terdapat Kode Akun dalam RKAKL</td></tr>
            </table>
            <table id="example"  class="table table-striped table-hover table-bordered">
              <thead style="background-color:#04B45F;color:white;">
                <tr>
                  <th>No</th>
                  <th>No. Kode</th>
                  <th>Uraian Kegiatan</th>
                  <th>Alokasi Dana dalam DIPA</th>
                  <th>Jumlah Pengeluaran</th>
                  <th>Sisa Anggaran</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <table class="table-striped col-md-12">
              <tr><th colspan="2">Total</th></tr>
                <tr><td valign="top">Total Alokasi Dana dalam DIPA </td><td valign="top"><?php echo number_format($import[0]->total_dipa,2,',','.');?></td></tr>
                <tr><td valign="top">Total Jumlah Pengeluaran </td><td valign="top"><?php echo number_format($import[0]->total_realisasi,2,',','.');?></td></tr>
                <tr><td valign="top">Total Sisa Anggaran </td><td valign="top"><?php echo number_format($import[0]->total_sisa,2,',','.');?></td></tr>
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
            {"targets" : 1},
            {"targets" : 2},
            {"targets" : 3},
            {"targets" : 4},
            {"targets" : 5},
          ],
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab/table_real_upload",
        "type": "POST",
        "data": { }
      }
    });
    $('#selectbtn').click(function () {
      $("#fileimport").trigger('click');
    });
    $("#fileimport").change(function(){
      $("#filename").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });

$(document).ready(function() {
  <?php if($stat_err == 1) { ?>
  $.ajax({
    url: "<?php echo $url_rewrite;?>process/rab_rinci/deltemprab",
    type: "POST",
    data: {'id_rab_view':'0' }
  }).done(function() {
  });
  $.ajax({
    url: "<?php echo $url_rewrite;?>process/rab/delimportreal",
    type: "POST",
    data: {}
  }).done(function() {
  });
  <?php }?>
  });
</script>
