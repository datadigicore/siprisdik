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
            <?php include "view/include/alert.php" ?>
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
      <form method="POST" action="<?php echo $url_rewrite;?>process/user/edit">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Edit Pengguna</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id"></input>
          <div class="form-group">
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          </div>
          <div class="form-group">
            <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
              <input type="checkbox" id="checkuser">  
            </div>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" disabled>
          </div>
          <div class="form-group">
            <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
              <input type="checkbox" id="checkpass">
            </div>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" disabled>
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
          <button type="submit" class="btn btn-flat btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="hapusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?php echo $url_rewrite;?>process/user/delete">
        <div class="modal-header" style="background-color:#d33724 !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Hapus Pengguna</h4>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin menghapus pengguna ini?</p>
          <input type="hidden" name="id" id="modid"></input>
          <table>
            <tr>
              <td>Nama</td>
              <td>&nbsp;:&nbsp;</td>
              <td id="modnama"></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>&nbsp;:&nbsp;</td>
              <td id="modemail"></td>
            </tr>
            <tr>
              <td>Kewenangan</td>
              <td>&nbsp;:&nbsp;</td>
              <td id="modkewenangan"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#checkuser').on('ifChecked', function(){
      $("#username").removeAttr("disabled");
      $("#username").attr("required",true);
    });
    $('#checkpass').on('ifChecked', function(){
     $("#password").removeAttr("disabled");
     $("#password").attr("required",true);
    });
    $('#checkuser').on('ifUnchecked', function(event){
      $("#username").attr("disabled",true);
    });
    $('#checkpass').on('ifUnchecked', function(){
     $("#password").attr("disabled",true);
    });
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
                              '<a style="margin:0 2px;" id="btn-del" href="#hapusModal" class="open-deleteProject btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-trash-o"></i> Hapus</a>'+
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
      $("#id").val(tabrow.data()[0]);
      $("#nama").val(tabrow.data()[1]);
      $("#username").val(tabrow.data()[3]);
      $("#email").val(tabrow.data()[4]);
      $("#level").val(tabrow.data()[7]);
      $("#status").val(tabrow.data()[8]);
    });
    $(document).on("click", "#btn-del", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      $("#modid").val(tabrow.data()[0]);
      $("#modnama").text(tabrow.data()[1]);
      $("#modemail").text(tabrow.data()[4]);
      $("#modkewenangan").text(tabrow.data()[5]);
    });
  });
</script>