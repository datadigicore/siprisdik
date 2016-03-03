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
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tabel Pengguna</h3>
            <a href="<?php echo $url_rewrite;?>content/adduser" class="btn btn-flat btn-success btn-sm pull-right">Tambah Pengguna</a>
          </div>
          <div class="box-body">
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>Id</th>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Kewenangan</th>
                  <th>Direktorat</th>
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
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#111F3F !important; color:white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white">×</span></button>
        <h4 class="modal-title">Edit Pengguna</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" required>
        </div>
        <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
            <input type="checkbox" id="checkuser">  
          </div>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly>
        </div>
        <div class="form-group">
          <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
            <input type="checkbox" id="checkpass">
          </div>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" readonly>
        </div>
        <div class="form-group">
          <select class="form-control" id="level" name="level" required>
            <option value="" disabled selected>-- Pilih Kewenangan --</option>
            <option value="1">Operator Bendahara Pengeluaran</option>
            <option value="2">Bendahara Pengeluaran Pembantu</option>
            <option value="3">Operator Bendahara Pengeluaran Pembantu</option>
          </select>
        </div>
        <div class="form-group">
          <select class="form-control" id="status" name="status" required>
            <option value="" disabled selected>-- Pilih Status Akun --</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-success">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    var table = $(".table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/user/table",
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
        {"targets" : 6},
        {"orderable": false,
         "data": null,
         "defaultContent":  '<div class="text-center">'+
                              '<a style="margin:0 2px;" id="btn-edt" href="#editModal" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>'+
                              '<a style="margin:0 2px;" id="btn-del" href="#modal-deleteProject" class="open-deleteProject btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-trash-o"></i> Hapus</a>'+
                            '</div>',
         "targets": 7 },
         {"targets" : 8,
         "visible" : false},
      ],
      "order": [[ 0, "desc" ]]
    });
    $(document).on("click", "#nonaktif", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      row_id = tabrow.data()[0];
      $.ajax({
        type: "post",
        url : "<?php echo $url_rewrite;?>process/user/activate",
        data: {key:row_id},
        success: function(data)
        {
          table.draw();
        }
      });
      return false;
    });
    $(document).on("click", "#aktif", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      row_id = tabrow.data()[0];
      $.ajax({
        type: "post",
        url : "<?php echo $url_rewrite;?>process/user/deactivate",
        data: {key:row_id},
        success: function(data)
        {
          table.draw();
        }
      });
      return false;
    });
    $(document).on("click", "#btn-edt", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      $("#name").val(tabrow.data()[1]);
      $("#username").val(tabrow.data()[3]);
      $("#email").val(tabrow.data()[4]);
      $("#level").val(tabrow.data()[7]);
      $("#status").val(tabrow.data()[8]);
    });
  });
</script>