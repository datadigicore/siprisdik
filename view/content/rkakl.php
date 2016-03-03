<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RKAKL
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> Data RKAKL</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Kerja dan Anggaran Kementerian/Lembaga</h3>
            <a href="#importModal" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Import RKAKL</a>
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
                  <th>id</th>
                  <th>Tahun RKAKL</th>
                  <th>Tanggal DIPA</th>
                  <th>Nomor DIPA</th>
                  <!-- <th>Nama File Import</th> -->
                  <!-- <th>Keterangan</th> -->
                  <th>Status</th>
                  <th>Aksi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="importModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rkakl/import" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Import Data RKAKL</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <select class="form-control" name="thang" required>
            <?php $earliest_year = date('Y');
            echo '<option  value="" disabled selected>-- Pilih Tahun Anggaran --</option>';
            foreach (range(date('Y')+1, $earliest_year) as $x) {
              echo '<option value="'.$x.'">'.$x.'</option>';
            }?>
            </select>
          </div>
          <div class="form-group">
            <label>Tanggal DIPA</label>
            <input type="text" class="form-control tanggal" id="tanggal" name="tanggal" placeholder="dd/mm/yyyy">
          </div>
          <div class="form-group">
            <label>Nomor DIPA</label>
            <input type="text" class="form-control" id="no_dipa" name="no_dipa" placeholder="Nomor DIPA">
          </div>
          <!-- <div class="form-group">
            <label>Keterangan</label>
            <textarea rows="5" type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" style="resize:none;" required></textarea>
          </div> -->
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
</div>
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rkakl/import" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Revisi Data RKAKL</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="revisi" value="true">
            <input type="hidden" id="thnanggaran" name="thang">
            <input type="text" class="form-control" id="tglimport" name="tglimport" placeholder="Tanggal Import" readonly>
          </div>
          <div class="form-group">
            <label>Tanggal DIPA</label>
            <input type="text" class="form-control tanggal" id="tanggal" name="tanggal" placeholder="dd/mm/yyyy">
          </div>
          <div class="form-group">
            <label>Nomor DIPA</label>
            <input type="text" class="form-control" id="no_dipa" name="no_dipa" placeholder="Nomor DIPA">
          </div>
          <div class="form-group">
            <label>Pesan Revisi</label>
            <textarea rows="5" type="text" class="form-control" id="pesan" name="pesan" placeholder="Pesan Revisi" style="resize:none;" required></textarea>
          </div>
          <div class="form-group">
            <input type="file" id="fileimport-revisi" name="fileimport" style="display:none;">
            <a id="selectbtn-revisi" class="btn btn-flat btn-primary" style="position:absolute;right:16px;">Select File</a>
            <input type="text" id="filename-revisi" class="form-control" placeholder="Pilih File .xls / .xlsx" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-success">Revisi Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="lihatpesan">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Revisi Data RKAKL</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="vtglimport" name="vtglimport" placeholder="Tanggal Import" readonly>
          </div>
          <div class="form-group">
            <label>Tanggal DIPA</label>
            <input type="text" class="form-control tanggal" id="vtanggal" name="vtanggal" placeholder="dd/mm/yyyy" readonly>
          </div>
          <div class="form-group">
            <label>Nomor DIPA</label>
            <input type="text" class="form-control" id="vno_dipa" name="vno_dipa" placeholder="Nomor DIPA" readonly>
          </div>
          <div class="form-group">
            <label>Pesan Revisi</label>
            <textarea rows="5" type="text" class="form-control" id="vpesan" name="vpesan" placeholder="Pesan Revisi" style="resize:none;" readonly></textarea>
          </div>
        </div>
    </div>
  </div>
</div>
<script>

  $(function () {
    $('#selectbtn').click(function () {
      $("#fileimport").trigger('click');
    });
    $("#fileimport").change(function(){
      $("#filename").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    $('#selectbtn-revisi').click(function () {
      $("#fileimport-revisi").trigger('click');
    });
    $("#fileimport-revisi").change(function(){
      $("#filename-revisi").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    var table = $(".table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rkakl/table",
        "type": "POST"
      },
      "columnDefs" : [
        {"targets" : 0,
         "visible" : false},
        {"targets" : 1},
        {"targets" : 2},
        {"targets" : 3},
        {"targets" : 4},
        {"targets" : 5},
        {"targets" : 6,
         "visible" : false},
      ],
      "order": [[ 0, "desc" ]]
    });
    $('.tanggal').mask('00/00/0000');
    $(".tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });

    $(document).on("click", "#btn-edt", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#tglimport").val('Tahun Anggaran : '+tabrow.data()[1]);
      $("#thnanggaran").val(tabrow.data()[1]);
    });
    $(document).on("click", "#btn-pesan", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#vtglimport").val('Tahun Anggaran : '+tabrow.data()[1]);
      // alert('no 2 : '+tabrow.data()[2])
      $("#vtanggal").val(tabrow.data()[2]);
      $("#vno_dipa").val(tabrow.data()[3]);
      $("#vpesan").val(tabrow.data()[8]);
    });
    $(document).on("click", "#btn-viw", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      var f = document.createElement('form');
      f.setAttribute('method','post');
      f.setAttribute('target','_blank');
      f.setAttribute('action','<?php echo $url_rewrite;?>process/rkakl/view');
      var i = document.createElement('input');
      i.setAttribute('type','hidden');
      i.setAttribute('name','filename');
      i.setAttribute('value', tabrow.data()[6]);
      f.appendChild(i);
      document.body.appendChild(f);
      f.submit();
    });
  });
</script>