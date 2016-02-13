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
        <li><a href="<?php echo $url_rewrite;?>content/rab"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>           
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span><span>Data RAB (51)</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5696"><i class="fa fa-table"></i> <span>Dukungan Manajemen untuk <br>Program Peningkatan Kualitas <br>Kelembagaan Iptek dan Dikti</span></a></li>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5697"><i class="fa fa-table"></i> <span>Pengembangan <br>Kelembagaan Perguruan Tinggi</span></a></li>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5698"><i class="fa fa-table"></i> <span>Pembinaan Kelembagaan <br>Perguruan Tinggi</span></a></li>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5699"><i class="fa fa-table"></i> <span>Penguatan dan <br>Pengembangan Lembaga <br>Penelitian dan Pengembangan</span></a></li>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5700"><i class="fa fa-table"></i> <span>Pengembangan Taman Sains <br>dan Teknologi (TST) dan <br>Lembaga Penunjang Lainnya</span></a></li>
          </ul>
        </li>     
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-file-text"></i> <span>Cetak Surat</span></a></li>
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
      <?php if ($_SESSION['level'] != 0): ?>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/rab"><i class="fa fa-table"></i> <span>Data RAB</span></a></li>   
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span><span>Data RAB (51)</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if($_SESSION['direktorat'] == 5696){ ?>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5696"><i class="fa fa-table"></i> <span>Dukungan Manajemen untuk <br>Program Peningkatan Kualitas <br>Kelembagaan Iptek dan Dikti</span></a></li>
            <?php }elseif($_SESSION['direktorat'] == 5697){ ?>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5697"><i class="fa fa-table"></i> <span>Pengembangan <br>Kelembagaan Perguruan Tinggi</span></a></li>
            <?php }elseif($_SESSION['direktorat'] == 5698){ ?>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5698"><i class="fa fa-table"></i> <span>Pembinaan Kelembagaan <br>Perguruan Tinggi</span></a></li>
            <?php }elseif($_SESSION['direktorat'] == 5699){ ?>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5699"><i class="fa fa-table"></i> <span>Penguatan dan <br>Pengembangan Lembaga <br>Penelitian dan Pengembangan</span></a></li>
            <?php }elseif($_SESSION['direktorat'] == 5700){ ?>
            <li><a href="<?php echo $url_rewrite;?>content/rab51/5700"><i class="fa fa-table"></i> <span>Pengembangan Taman Sains <br>dan Teknologi (TST) dan <br>Lembaga Penunjang Lainnya</span></a></li>
            <?php }?>
          </ul>
        </li>   
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-dashboard"></i> <span>Laporan</span></a></li>
      <?php endif ?>
    </ul>
  </section>
</aside>
