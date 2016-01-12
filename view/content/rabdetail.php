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
            <a href="<?php echo $url_rewrite;?>content/rab/add-rincian" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Akun</a>
          </div>
          <div class="box-body">
            
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Keterangan</th>
                  <th>Total Dana RAB</th>
                  <th>Kode Akun</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <td>1</td>
                <td>Harris Anggara</td>
                <td>Perorangan</td>
                <td>Belum Ada</td>
                <td>Belum Ada</td>
                <td>
                  <div class="text-center">
                    <a style="margin:0 2px;" id="btn-edt" href="<?php echo $url_rewrite;?>content/rab/add" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-list"></i> Detail</a>
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
      <form action="" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" id="detailrab">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST" enctype="multipart/form-data">
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