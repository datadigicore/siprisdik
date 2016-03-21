<script type="text/javascript"></script>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Ubah Password
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-user"></i> Ubah Password</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">

          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <form class="form-horizontal" role="form" id="frmMode1" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>process/user/edt-pass">
              
              <div class="form-group ">
                <label class="col-md-2 control-label">Masukkan Password Lama</label>
                <div class="col-md-9">
                  <input type="password" class="form-control input-profile" id="password" name="password" placeholder="Password Lama" data-toggle="password">
                </div>
              </div>
              <div class="form-group ">
                <label class="col-md-2 control-label">Masukkan Password Baru</label>
                <div class="col-md-9">
                  <input type="password" class="form-control input-profile" id="newpass" name="newpass" placeholder="Password Baru" data-toggle="password">
                </div>
              </div>
              <div class="form-group ">
                <label class="col-md-2 control-label">Masukkan Password Baru (Ulangi)</label>
                <div class="col-md-9">
                  <input type="password" class="form-control input-profile" id="newpass2" name="newpass2" placeholder="Password Baru" data-toggle="password">
                </div>
                <span class="label label-danger" id="warning" style="display:none" data-toggle="tooltip" data-placement="top" title="Password baru tidak sama"><strong><i class="fa fa-exclamation-triangle"></i></strong></span>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-flat btn-primary" id="btn-ubah-pass" disabled><i class="fa fa-edit"></i> Simpan Perubahan</button>
              <div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#newpass2').keyup(function(){
      if($('#newpass').val()==$('#newpass2').val()){
        $('#btn-ubah-pass').attr('disabled',false);
        $('#warning').hide();
      } else {
        $('#warning').show();
        $('#btn-ubah-pass').attr('disabled',true);

      }
    });
  });
</script>