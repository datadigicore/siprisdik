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
    <ul class="nav nav-tabs">
        <li><a href="#honor_saku" data-toggle="tab">Kuitansi Honor & Uang Saku <i class="fa"></i></a></li>
        <li><a href="#rincian_dinas" data-toggle="tab">Kuitansi Rincian Perjalanan Dinas<i class="fa"></i></a></li>
        <li><a href="#sppd" data-toggle="tab">Kuitansi SPPD Perjalanan Dinas<i class="fa"></i></a></li>
        <li><a href="#transport" data-toggle="tab">Kuitansi Transport Lokal<i class="fa"></i></a></li>
    </ul>
    <form action="<?php echo $url_rewrite;?>process/user/kuitansi" method="post" class="form-horizontal" >
              <div class="tab-content">
                  <div class="tab-pane active" id="honor_saku">  
                      <input type="hidden" name="manage" id="manage" value="lap_persediaan">
                  </div>

                  <div class="tab-pane" id="rincian_dinas">
                  </div>

                  <div class="tab-pane" id="sppd">                    
                  </div>


              </div>
                 <!-- <div class="box-body">
                    <label class="col-sm-2 control-label">Kode Satker</label>
                       <div class="col-sm-4">
                          <select name="satker" id="satker" class="form-control">
                          </select>
                        </div>
                  </div> --> 
                                                           
                    <div class="box-body" id="awal" >
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="">
                        </select>
                      </div>
                    </div>                     
                    <div class="box-body" id="akhir" >
                      <label class="col-sm-2 control-label">Tanggal Akhir</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="" >
                        </select>
                      </div>
                    </div>
                     
              <div class="form-group" style="margin-top: 15px;">
                  <div class="col-xs-5 col-xs-offset-3">
                      <button type="submit" class="btn btn-default">Cetak</button>
                  </div>
              </div>
          </form>
  </section>
</div>