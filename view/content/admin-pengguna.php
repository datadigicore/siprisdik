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
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Table Pengguna</h3>
            <a href="<?php echo $url_rewrite;?>content/adduser" class="btn btn-success btn-sm pull-right">Tambah Pengguna</a>
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
<script>
  $(function () {
    var table = $(".table").DataTable({
      "processing": true,
      "serverSide": true,
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
        {"orderable": false,
         "data": null,
         "defaultContent":  '<div class="text-center">'+
                              '<a style="margin:0 2px;" id="btn-edt" href="#modal-editProject" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>'+
                              '<a style="margin:0 2px;" id="btn-del" href="#modal-deleteProject" class="open-deleteProject btn btn-danger btn-sm" data-toggle="modal"><i class="fa fa-trash-o"></i> Hapus</a>'+
                            '</div>',
         "targets": 6 }
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
  });
</script>