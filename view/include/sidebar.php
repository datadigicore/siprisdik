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
      <li class="active"><a href="<?php echo $url_rewrite;?>content/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <form method="POST" action="<?php echo $url_rewrite;?>content/table">
      <li class="hand" onclick="$(this).closest('form').submit()"  style="padding: 12px 5px 12px 15px;">
          <input type="hidden" name="content" value="table">
          <a><i class="fa fa-table" style="width:20px"></i> <span>Data RAB</span></a>
      </li>
      </form>
    </ul>
  </section>
</aside>
