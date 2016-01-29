<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> Data RAB</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <a href="#addrab" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Orang / Badan</a>
          </div>
          <div class="box-body">
            <?php if (isset($_POST['message'])): ?>
              <div class="alert alert-<?php echo $_POST['alert']; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning"></i><?php echo $_POST['message']; ?>
              </div>
            <?php endif ?>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Keterangan</th>
                  <th>NPWP</th>
                  <th>Golongan </th>
                  <th>Jabatan</th>
                  <th>Kode Akun</th>
                  <th>Total Dana RAB</th>
                  <th>Status</th>
                  <th></th>
                  <th>Pelaporan</th>
                  <?php if($_SESSION['level'] == 0){?>
                  <th></th>
                  <?php }?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="addrab" style="z-index:-100px">
  <div class="modal-dialog">
    <div class="modal-content">
      <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab_rinci/save_penerima">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Form</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          <div class="form-group">
            <label>Jenis</label>
            <select class="form-control" id="jenis-akun" name="jenis-akun">
              <option value="0">Badan</option>
              <option value="1">Orang</option>
            </select>
          </div>
          <div class="form-group ">
              <label>NPWP</label>
              <input type="text" class="form-control" value="<?= $npwp ?>" id="npwp" name="npwp" onkeyup="cnpwp()" placeholder="NPWP">
          </div>
          <div class="form-group">
              <label>Nama Personel</label>
              <input type="text" class="form-control" value="<?= $penerima ?>" id="penerima" name="penerima" placeholder="Nama Penerima">
          </div>
          <div class="form-group ">
              <label>Golongan</label>
              <input type="text" class="form-control" value="<?= $golongan ?>" id="golongan" name="golongan" placeholder="Golongan Penerima">
          </div>
          <div class="form-group ">
              <label>PNS / Non PNS</label>
              <select class="form-control" id="pns" required name="pns">
              <option>-- Pilih --</option>
              <option value="1">PNS</option>
              <option value="0">Non PNS</option>
            </select>
          </div>
          <div class="form-group ">
               <label>Jabatan Dalam Tugas</label>
               <input type="text" class="form-control" value="<?= $jabatan ?>" id="jabatan" name="jabatan" placeholder="Jabatan Dalam Tugas">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Cancel</button>
          <button type="submit" class="btn btn-flat btn-success">Simpan</button>
        </div>
        <input type="hidden" value="1" name="mode"/>
        <?php
        if ($id != "")
             echo"<input type=\"hidden\"  name=\"kondisi\" value=\"edit\">";
        else
             echo"<input type=\"hidden\"  name=\"kondisi\" value=\"tambah\">";

        echo"<input type=\"hidden\"  name=\"kode\" value=\"$id\">";
        ?>
     </form> 
    </div>
  </div>
</div>
<script>
  $(function () {
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var table = $("#table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/table/<?php echo $id_rab_view; ?>",
        "type": "GET"
      },
      "columnDefs" : [
        {"targets" : 0,
         "visible" : false},
        {"targets" : 1},
        {"targets" : 2},
        {"targets" : 3},
        {"targets" : 4},
        {"targets" : 5},
      ],
      "order": [[ 0, "desc" ]]
    });

    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getnpwp",
      data: { },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        var avai_npwp = obj.npwp;
        $( "#npwp" ).autocomplete({
          source: avai_npwp
        });
      },
    });
  });

  function cnpwp(){
    var npwp = $('#npwp').val();
    alert(npwp);
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab_rinci/getorang",
      data: { 'npwp':npwp },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        var penerima = obj.penerima;
        $('#penerima').val(penerima);
        var golongan = obj.golongan;
        $('#golongan').val(golongan);
        var pns = obj.pns;
        $('#pns').val(pns);
        var jabatan = obj.jabatan;
        $('#jabatan').val(jabatan);
      },
    });
  }

  function search(){
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    table.destroy();
    $('#table').DataTable({
      "scrollX": true,
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "getRab",
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tahun", "value": tahun },
                      { "name": "direktorat", "value": direktorat } );
      }
    });
  }
</script>