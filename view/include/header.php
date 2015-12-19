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
            <?php include ('header-notif.php'); ?>
            <?php include ('header-message.php'); ?>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="user-image" alt="User Image">
                <span class="hidden-xs">Username RISTEKDIKTI</span>
              </a>
              <ul class="dropdown-menu" style="border-right:none;">
                <li class="user-header">
                  <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="img-circle" alt="User Image">
                  <p>
                    Username - RISTEKDIKTI
                    <small>Login terakhir pukul 12.30</small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
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