<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Profil
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-user"></i> Profil</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            Profil
          </div>

          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <form class="form-horizontal" role="form" id="frmMode1" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>process/user/edt2">
              
              <div class="form-group ">
                <label class="col-md-2 control-label">Nama</label>
                <div class="col-md-9">
                  <input type="text" class="form-control input-profile" value="<?= $_SESSION['nama'] ?>" id="name" name="name" placeholder="Nama" readonly="true">
                </div>
              </div>
              <div class="form-group ">
                <label class="col-md-2 control-label">Username</label>
                <div class="col-md-9">
                  <input type="text" class="form-control input-profile" value="<?= $_SESSION['username'] ?>" id="username" name="username" placeholder="Username" readonly="true">
                </div>
              </div>
              <div class="form-group ">
                <label class="col-md-2 control-label">Email</label>
                <div class="col-md-9">
                  <input type="text" class="form-control input-profile" value="<?= $_SESSION['email'] ?>" id="email" name="email" placeholder="Email" readonly="true">
                </div>
              </div>
              <div class="form-group ">
                <label class="col-md-2 control-label">Direktorat</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" value="<?= $_SESSION['direktorat'] ?>" id="direktorat" name="direktorat" placeholder="Direktorat" readonly="true">
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-flat btn-primary" id="btn-ubah-profil" style="display:none"><i class="fa fa-edit"></i> Simpan Perubahan</button>
              <div>
            </form>
            <hr>
            <div class="text-center">
              <button class="btn btn-flat btn-primary" id="ubah-profil"><i class="fa fa-user"></i> Ubah Profil</button>
              <a class="btn btn-flat btn-primary" href="<?php echo $url_rewrite?>content/edit_pass" id="ubah-password"><i class="fa fa-key"></i> Ubah Password</a>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  $(document).ready(function(){
    $(document).on('click','#ubah-profil',function(e){
      e.preventDefault();
      $('.input-profile').attr('readonly',false);
      $('#btn-ubah-profil').show();
      $('#ubah-profil').hide();
    });
  });
</script>