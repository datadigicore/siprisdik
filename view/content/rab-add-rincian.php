<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rab" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> Data RAB</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <!-- <a href="<?php echo $url_rewrite;?>content/rab/add" class="btn btn-flat btn-success btn-sm pull-right">Tambah RAB</a> -->
          </div>
          <div class="box-body">
            <form class="form-horizontal" role="form" id="frmMode1" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>proses/student/">
             <input type="hidden" name="kategori" value="0">
                <!-- panel personal info -->
                <div class="panel panel-default">
                     <!-- Default panel contents -->
                     <div class="panel-heading te-panel-heading">
                          <i class="glyphicon glyphicon-th-large"></i> <span>Form Akun RAB</span>
                     </div>

                     <div class="clearfix"></div>

                     <div class="panel-body">
                          <div class="form-group ">
                               <label for="inputFirstName" class="col-md-3 control-label">Jenis</label>
                               <div class="col-md-9">
                                    <select class="form-control" id="jenis-akun" name="jenis-akun">
                                      <option value="0">Badan</option>
                                      <option value="1">Orang</option>
                                    </select>
                               </div>
                          </div>
                          
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Nama Personel</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $penerima ?>" id="penerima" name="penerima" placeholder="Nama Penerima">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">NPWP</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $npwp ?>" id="npwp" name="npwp" placeholder="NPWP">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Golongan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $golongan ?>" id="golongan" name="golongan" placeholder="Golongan Penerima">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Jabatan Dalam Tugas</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $jabatan ?>" id="jabatan" name="jabatan" placeholder="Jabatan Dalam Tugas">
                               </div>
                          </div>                           
                     </div>
                     <!-- end of panel body -->
                </div>


                <div class="form-group">
                     <div class="col-md-offset-3 col-md-9">
                          <button type="submit" name="btnPersonal" class="btn btn-primary">Simpan</button>
                     </div>
                </div>
                <input type="hidden" value="1" name="mode"/>
                <?php
                if ($id != "")
                     echo"<input type=\"hidden\"  name=\"kondisi\" value=\"edit\">";
                else
                     echo"<input type=\"hidden\"  name=\"kondisi\" value=\"tambah\">";

                echo"<input type=\"hidden\"  name=\"kode\" value=\"$id\">";
                ?>
           </form>  
        </div>
      </div>
    </div>
  </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    //kodeAkun("kode-akun");
  });
  function kodeAkun(idSelector){
    var url = "<?=$url_rewrite?>ajax/show_opsi_akun.php";
     ambilData(url, idSelector);
  }
  $(function () {
    $('#table').DataTable({
      "scrollX": true
    });
  });
</script>
