<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Cetak Laporan
      <small>Tahun Anggaran 2016</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-group"></i> Data Pengguna</li>
      <li><i class="fa fa-user"></i>Cetak Laporan Berbasis Dokumen</li>
    </ol>
  </section>
  <section class="content">
    <div class="col-md-9 col-xs-12">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs nav-justified">
          <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Kuitansi Honor & Uang Saku</a></li>
          <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Kuitansi Rincian Perjalanan Dinas</a></li>
          <li><a href="#tab_3" data-toggle="tab" aria-expanded="true">Kuitansi SPPD Perjalanan Dinas</a></li>
          <li><a href="#tab_4" data-toggle="tab" aria-expanded="true">Kuitansi Transport Lokal</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
              Dokumen Lain <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" style="background:white;">
              <li><a href="#tab_5" data-toggle="tab" aria-expanded="true">Rincian Permintaan Pengeluaran</a></li>
              <li><a href="#tab_6" data-toggle="tab" aria-expanded="true">Surat Pertanggung Jawaban Belanja</a></li>
            </ul>
          </li>
        </ul>
        <div class="tab-content" style="padding:5px 0 0 0;">
          <div class="tab-pane active" id="tab_1">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/Kuitansi_Honor_Uang_Saku">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>        
            </form>
          </div>
          <div class="tab-pane" id="tab_2">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/Rincian_Biaya_PD">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>
            </form>
          </div>
          <div class="tab-pane" id="tab_3">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/SPPD">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>        
            </form>
          </div>
          <div class="tab-pane" id="tab_4">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/Kuitansi_Honorarium">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>        
            </form>
          </div>
          <div class="tab-pane" id="tab_5">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/Rincian_Permintaan_Pengeluaran">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>        
            </form>
          </div>
          <div class="tab-pane" id="tab_6">
            <form method="POST" action="<?php echo $url_rewrite;?>process/report/SPTB">
            <div class="box-body" style="padding-bottom:0;">
              <div class="form-group">
                <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="Tanggal Awal">
              </div>
              <div class="form-group">
                <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="Tanggal Akhir" >
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
            </div>        
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>