<link rel="stylesheet" href="<?php echo $url_rewrite;?>static/plugins/iCheck/square/blue.css">
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="index2.html" class="logo">
        <span class="logo-mini"><img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png"></span>
        <span class="logo-lg"><img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png"> <b>RISTEK</b>DIKTI</span>
      </a>
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <?php //include ('header-notif.php'); ?>
            <?php //include ('header-message.php'); ?>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['username'];?></span>
              </a>
              <ul class="dropdown-menu" style="border-right:none;">
                <li class="user-header">
                  <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['username'];?>
                    <!-- <small>Login terakhir pukul 12.30</small> -->
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo $url_rewrite?>content/edit_profile" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo $url_rewrite;?>signout" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="modal fade" id="editProfil">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#111F3F !important; color:white;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="color:white">×</span></button>
            <h4 class="modal-title">Edit Profil</h4>
          </div>
          <div class="modal-body" style="background:white !improtant">
            <div class="form-group">
              <input type="text" class="form-control" name="name" placeholder="Nama Lengkap"  value="<?php echo $_SESSION['nama'];?>" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $_SESSION['email'];?>" required>
            </div>
            <div class="form-group">
              <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
                <input type="checkbox">  
              </div>
              <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $_SESSION['username'];?>" readonly>
            </div>
            <div class="form-group">
              <div class="checkbox icheck" style="position:absolute;margin:6px;right:16px;background:white;">
                <input type="checkbox">
              </div>
              <input type="password" class="form-control" name="password" placeholder="Password" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-flat btn-success">Simpan Perubahan</button>
          </div>
        </div>
      </div>
    </div>
    <script src="<?php echo $url_rewrite;?>static/plugins/iCheck/icheck.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
    </script>