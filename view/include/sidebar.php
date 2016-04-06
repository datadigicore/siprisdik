<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo $url_rewrite;?>static/dist/img/risetdikti.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['username'];?></p>
        <!-- <small>Administrator Web</small> -->
      </div>
    </div>
    <ul class="sidebar-menu">
      <li class="header">MENU NAVIGATION</li>
      <?php if ($_SESSION['level'] == 0): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/rkakl"><i class="fa fa-table"></i> <span>Data RKAKL</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/rab-rkakl"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>           
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span><span>Data RAB (51)</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5696"><i class="fa fa-table"></i> <span>Dukungan Manajemen untuk <br>Program Peningkatan Kualitas <br>Kelembagaan Iptek dan Dikti</span></a></li>
          </ul>
        </li>     
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-file-text"></i> <span>Cetak Laporan</span></a></li>
        <!-- <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-file-text"></i> <span>Cetak SPJB</span></a></li> -->
        <li><a href="<?php echo $url_rewrite;?>content/user"><i class="fa fa-group"></i> <span>Data Pengguna</span></a></li>
        
        <!-- <li class="treeview">
              <a href="#"><i class="fa fa-file-text-o"></i> <span>Cetak Dokumen V.2</span> <i class="fa fa-angle-left pull-right"></i></a>            
              <ul class="treeview-menu">
                <li><a href="#"><span>Kuitansi Honor & Uang Saku</span></a></li>
                <li><a href="#"><span>Kuitansi Rincian Perjalanan Dinas</span></a></li>
                <li><a href="#"><span>Kuitansi SPPD Perjalanan Dinas</span></a></li>
                <li><a href="#"><span>Kuitansi Transport Lokal</span></a></li>
              </ul>
            </li> -->
      <?php endif ?>
      <?php if ($_SESSION['level'] != 0 ): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/rab-rkakl"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>   
        <?php if($_SESSION['direktorat'] == 5696){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span><span>Data RAB (51)</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5696"><i class="fa fa-table"></i> <span>Dukungan Manajemen untuk <br>Program Peningkatan Kualitas <br>Kelembagaan Iptek dan Dikti</span></a></li>
          </ul>
        </li>  
        <?php }?> 
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-file-text"></i> <span>Cetak Laporan</span></a></li>
      <?php endif ?>
    </ul>
  </section>
</aside>
