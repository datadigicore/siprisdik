<style type="text/css">
  div.dataTables_wrapper {
    max-width: 100%;
    margin: 0 auto;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Pengguna
      <small>Management Control</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> Data Pengguna</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Pengguna</h3>
            <a href="<?php echo $url_rewrite;?>content/adduser" class="btn btn-success btn-sm pull-right">Tambah Pengguna</a>
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
<script>
  $(function () {
    $('#table').DataTable({
      "scrollX": true
    });
  });
</script>