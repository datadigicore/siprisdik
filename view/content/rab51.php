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
            <?php if ($_SESSION['level'] != '0') {
              echo '<a href="'.$url_rewrite.'content/rab51/'.$direktorat.'/addnew" class="btn btn-flat btn-success btn-sm pull-right">Tambah RAB</a>';
            }?>
          </div>
          <div class="box-body">
            <?php if (isset($_POST['message'])): ?>
              <div class="alert alert-<?php echo $_POST['alert']; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning"></i><?php echo $_POST['message']; ?>
              </div>
            <?php endif ?>
            <table class="display table table-bordered table-striped" style="width:750px">
              <tr>
                <td><label>Tahun</label></td>
                <td>
                  <select class="form-control select2" name="tahun2" id="tahun2" required>
                    <?php for ($i=0; $i < count($tahun); $i++) { 
                      echo "<option value='".$tahun[$i]."'>".$tahun[$i].'</option>';
                    }?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label>Direktorat</label></td>
                <td><label><?php echo $direk[$direktorat]; ?></label></td>
                <input type="hidden" id="direktorat2" name="direktorat2" value="<?php echo $direktorat; ?>" />
              </tr>
            </table>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Kode RKAKL</th>
                  <th>Deskripsi</th>
                  <th>Tanggal</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  <th>Action</th>
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
<div class="modal fade" id="ajuan">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab51/ajukan" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rab_aju" name="id_rab_aju" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Ingin Melakukan Pengajuan ?</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Tidak</button>
          <button type="submit" class="btn btn-flat btn-success">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="sahkan">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab51/sahkan" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rab_sah" name="id_rab_sah" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Ingin Melakukan Pengesahan ?</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Tidak</button>
          <button type="submit" class="btn btn-flat btn-success">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="revisi">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab51/revisi" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rab_rev" name="id_rab_rev" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Melakukan Revisi pada RAB ini ?</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Tidak</button>
          <button type="submit" class="btn btn-flat btn-success">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
var table;
  $(function () {
     $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'
      });

    var tahun = $('#tahun2').val();
    var direktorat = $('#direktorat2').val();
    table = $("#table").DataTable({
        "oLanguage": {
          "sInfoFiltered": ""
        },
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
          "url": "<?php echo $url_rewrite;?>process/rab51/table",
          "type": "POST",
          "data": {'tahun':tahun,
                    'direktorat': direktorat }
        },
          "columnDefs" : [
            {"targets" : 0,
             "visible" : false},
            {"targets" : 1},
            {"targets" : 2},
            {"targets" : 3},
            {"targets" : 4},
            {"targets" : 5},
            {"targets" : 6},
          ],
        "order": [[ 0, "desc" ]]
    });
    
    $(document).on("click", "#btn-aju", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rab_aju").val(tabrow.data()[0]);
    });
    $(document).on("click", "#btn-sah", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rab_sah").val(tabrow.data()[0]);
    });
    $(document).on("click", "#btn-rev", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rab_rev").val(tabrow.data()[0]);
    });

  });

  function search(){
    var tahun = $('#tahun2').val();
    var direktorat = $('#direktorat2').val();
    table.destroy();
    table = $("#table").DataTable({
        "oLanguage": {
          "sInfoFiltered": ""
        },
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
          "url": "<?php echo $url_rewrite;?>process/rab/table",
          "type": "POST",
          "data": {'tahun':tahun,
                    'direktorat': direktorat }
        },
          "columnDefs" : [
            {"targets" : 0,
             "visible" : false},
            {"targets" : 1},
            {"targets" : 2},
            {"targets" : 3},
            {"targets" : 4},
            {"targets" : 5},
            {"targets" : 6},
          ],
        "order": [[ 0, "desc" ]]
    });
  }

  
</script>
