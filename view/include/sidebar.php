<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Username</p>
        <small>Administrator Web</small>
      </div>
    </div>
    <ul class="sidebar-menu">
      <li class="header">MENU NAVIGATION</li>
      <?php if ($_SESSION['level'] == 0): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-group"></i> <span>Data Pengguna</span></a></li>
      <?php endif ?>
      <?php if ($_SESSION['level'] == 1): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/table"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-dashboard"></i> <span>Laporan</span></a></li>
      <?php endif ?>
      <?php if ($_SESSION['level'] == 2): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/table"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-dashboard"></i> <span>Laporan</span></a></li>
      <?php endif ?>
    </ul>
  </section>
</aside>
