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
            <a href="#addrab" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah RAB</a>
          </div>
          <div class="box-body">
            <table class="display table table-bordered table-striped" style="width:200px">
              <tr>
                <td><label>Tahun</label></td>
                <td>
                  <select id="tahun" class="select2" onchange="search()">
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label>Direktorat</label></td>
                <td>
                  <select id="direktorat" class="select2" onchange="search()">
                    <option value="5696">5696</option>
                    <option value="5697">5697</option>
                    <option value="5698">5698</option>
                    <option value="5699">5699</option>
                    <option value="5700">5700</option>
                  </select>
                </td>
              </tr>
            </table>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Program</th>
                  <th>Output</th>
                  <th>Suboutput</th>
                  <th>Komponen Input</th>
                  <th>Uraian Acara</th>
                  <th>Hari / Tanggal</th>
                  <th>Lokasi</th>
                  <th>Uang Muka Kegiatan</th>
                  <th>Realisasi SPJ</th>
                  <th>Realisasi Pajak</th>
                  <th>Sisa Uang Muka</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <td>1</td>
                <td>06</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Uraian</td>
                <td>7 Jan 2016</td>
                <td>-</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>
                  <div class="text-center">
                    <a style="margin:0 2px;" id="btn-edt" href="<?php echo $url_rewrite;?>content/rabdetail" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Add Transaksi</a>
                  </div>
                </td>
              </tbody>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="addrab">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rkakl/import" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Add RAB</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Program</label>
            <select class="form-control" name="thang" required>
              <option>-- Pilih Program --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Output</label>
            <select class="form-control" name="thang" required>
              <option>-- Pilih Output --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Suboutput</label>
            <select class="form-control" name="thang" required>
              <option>-- Pilih Suboutput --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Komponen</label>
            <select class="form-control" name="thang" required>
              <option>-- Pilih Komponen --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Uraian Acara</label>
            <textarea rows="5" type="text" class="form-control" id="uraian" name="uraian" placeholder="Uraian Acara" style="resize:none;" required></textarea>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="dd/mm/yyyy" required />
          </div>
          <div class="form-group">
            <label>Lokasi Kegiatan</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi Kegiatan" required />
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(function () {
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var table = $('#table').DataTable({
      "scrollX": true,
      // "bProcessing": true,
      // "bServerSide": true,
      // "sAjaxSource": "getRab",
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tahun", "value": tahun },
                      { "name": "direktorat", "value": direktorat } );
      }
    });
  });

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