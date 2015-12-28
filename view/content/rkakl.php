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
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Pajak</th>
                  <th>Golongan</th>
                  <th>Jabatan dlm Tugas</th>
                  <th>Honor Output</th>
                  <th>Honor Profesi</th>
                  <th>Uang Saku</th>
                  <th>Trans. Lokal</th>
                  <th>Uang Harian</th>
                  <th>Harga Tiket</th>
                  <th>Biaya Akomodasi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Agus Indarjo</td>
                  <td>15</td>
                  <td>II</td>
                  <td>Narasumber</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Purwanto Subroto</td>
                  <td>15</td>
                  <td>II</td>
                  <td>Pakar</td>
                  <td></td>
                  <td>6.108.480</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>25.760.000</td>
                  <td></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Vivi Indra Amelia</td>
                  <td>15</td>
                  <td>II</td>
                  <td>Pelaksana</td>
                  <td></td>
                  <td>6.094.340</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>26.630.000</td>
                  <td></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Maryke Alelo</td>
                  <td>15</td>
                  <td>IV</td>
                  <td>Tim</td>
                  <td></td>
                  <td>6.094.340</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>25.760.000</td>
                  <td></td>
                </tr>
              </tbody>
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
            <input type="text" class="form-control" id="tglimport" name="tglimport" placeholder="Tanggal Import" readonly>
          </div>
          <div class="form-group">
            <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
              <input type="checkbox" id="checkrev">  
            </div>
            <input type="text" class="form-control" id="revisi" name="revisi" placeholder="Revisi RKAKL" readonly>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" required>
          </div>
          <div class="form-group">
            <input type="file" id="fileimport" name="fileimport" style="display:none;">
            <a id="selectbtn" class="btn btn-flat btn-primary" style="position:absolute;right:16px;">Select File</a>
            <input type="text" id="filename" class="form-control" placeholder="Pilih File .xls / .xlsx">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-success">Import Data</button>
        </div>
      </form>
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
    $('#table').DataTable({
      "scrollX": true
    });
  });
</script>