<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Informasi Pelaporan | Ristek Dikti</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png"/>
    <link rel="stylesheet" href="<?php echo $url_rewrite;?>static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url_rewrite;?>static/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $url_rewrite;?>static/dist/css/style.min.css">
    <link rel="stylesheet" href="<?php echo $url_rewrite;?>static/dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo $url_rewrite;?>static/plugins/iCheck/square/blue.css">
  </head>
  <body class="hold-transition login-page">
    <div class="dikti-header">
      <div class="top-header">
        <div class="container">
          <a href="#">
            <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png">
            <h3 class="logo nomargin">Sistem Informasi Pelaporan</h3>
          </a>
        </div>
      </div>
    </div>
    <div class="login-box">
      <div class="login-logo">
        Halaman Login
      </div>
      <div class="login-box-body">
        <p class="login-box-msg">Masukkan Username dan Password</p>
        <form action="<?php echo $url_rewrite;?>login" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Login
                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div>
          </div>
        </form>
        <p class="nomargin" style="margin-top:8px">Lupa Password? Klik<a href="#"> Disini</a></p>
      </div>
    </div>
    <script src="<?php echo $url_rewrite;?>static/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $url_rewrite;?>static/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $url_rewrite;?>static/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
    </script>
  </body>
</html>