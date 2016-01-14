<div class="content-wrapper">
  <section class="content-header">
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
          <div class="box-body" >

            <a style="" id="add-more-akun" href="#" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i> Tambah Akun</a>
            <div class="well" id="div-tambah-akun" style="display:none"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kode-akun" onchange="" >
                                      
              </select>
              <label>No Item</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kode-akun" >
                                      
              </select>
              <a style="" id="add-more-akun" href="#" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Akun</a>
            </div>
            <hr>
            <form class="form-horizontal" role="form" id="frmMode1" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>proses/student/" style="display:none">
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
                               <label class="col-md-3 control-label">Belanja Bahan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $belanja ?>" id="belanja" name="belanja" placeholder="Belanja bahan / ATK">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Honor Output</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $honor_output ?>" id="honor_output" name="honor_output" placeholder="Jumlah Honor Output">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Honor Profesi</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $honor_profesi ?>" id="honor_profesi" name="honor_profesi" placeholder="Jumlah Honor Profesi">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Uang Saku</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $uang_saku ?>" id="uang_saku" name="uang_saku" placeholder="Jumlah Uang Saku">
                               </div>
                          </div>
                          <div class="form-group ">
                               <label class="col-md-3 control-label">Transport Lokal</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $transport_lokal ?>" id="transport_lokal" name="transport_lokal" placeholder="Jumlah Transport Lokal">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Uang Harian</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $uang_harian ?>" id="uang_harian" name="uang_harian" placeholder="Jumlah Uang Harian">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Tiket</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $tiket ?>" id="tiket" name="tiket" placeholder="Tiket">
                               </div>
                          </div>
                          
                          <script>
                             $(function() {
                                  $("#tgl_mulai").datepicker();
                                  $("#tgl_akhir").datepicker();
                             });
                          </script>
                          <div class="form-group">
                               <label for="inputFrom" class="col-md-3 control-label"> Tanggal Berangkat</label>
                               <div class="col-md-9">
                                    <div class="input-group">
                                         <input type="text" readonly="1"  class="form-control" id="tgl_mulai" value="<?= $tgl_mulai ?>" name="tgl_mulai" placeholder="Tanggal Berangkat">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputFrom" class="col-md-3 control-label"> Tanggal Kembali</label>
                               <div class="col-md-9">
                                    <div class="input-group">
                                         <input type="text" readonly="1"  class="form-control" id="tgl_akhir" value="<?= $tgl_akhir ?>" name="tgl_akhir" placeholder="Tanggal Berangkat">
                                         <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Tingkat Dalam Perjalanan Dinas</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $tingkat_jalan ?>" id="tingkat_jalan" name="tingkat_jalan" placeholder="Tingkat Dalam Perjalanan Dinas">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Alat Transportasi</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $alat_trans ?>" id="alat_trans" name="alat_trans" placeholder="Alat Transportasi">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Kota Asal</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $kota_asal ?>" id="kota_asal" name="kota_asal" placeholder="Kota Asal">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Kota Tujuan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $kota_tujuan ?>" id="kota_tujuan" name="kota_tujuan" placeholder="Kota Tujuan">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Kota Tujuan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $kota_tujuan ?>" id="kota_tujuan" name="kota_tujuan" placeholder="Kota Tujuan">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Taxi Asal</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $taxi_asal ?>" id="taxi_asal" name="taxi_asal" placeholder="Taxi Asal">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Taxi Tujuan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $taxi_tujuan ?>" id="taxi_tujuan" name="taxi_tujuan" placeholder="Taxi Tujuan">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Pajak Airport</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $airport_tax ?>" id="airport_tax" name="airport_tax" placeholder="Pajak Airport">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Rute 1</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $rute1 ?>" id="rute1" name="rute1" placeholder="Rute 1">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Rute 2</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $rute2 ?>" id="rute2" name="rute2" placeholder="Rute 2">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Rute 3</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $rute3 ?>" id="rute3" name="rute3" placeholder="Rute 3">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Rute 4</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $rute4 ?>" id="rute4" name="rute4" placeholder="Rute 4">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Harga Tiket</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $harga_tiket ?>" id="harga_tiket" name="harga_tiket" placeholder="Harga Tiket">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Lama Hari</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $lama_hari ?>" id="lama_hari" name="lama_hari" placeholder="Lama Hari">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Kelompok HR</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $klmpk_hr ?>" id="klmpk_hr" name="klmpk_hr" placeholder="Kelompok HR">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">PNS / Non-PNS</label>
                               <div class="col-md-9">
                                    <select class="form-control" id="pns" name="pns">
                                      <option value="0">PNS</option>
                                      <option value="1">Non-PNS</option>
                                    </select>
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Malam</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $malam ?>" id="malam" name="malam" placeholder="Jumlah Malam">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Biaya Akomodasi</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $biaya_akom ?>" id="biaya_akom" name="biaya_akom" placeholder="Biaya Akomodasi">
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
  <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <!-- <a href="#addrab" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Akun</a> -->
          </div>
          <div class="box-body">
            
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Kode Akun</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <td>1</td>
                <td>523213</td>
                <td>
                  <div class="text-center">
                    <a style="margin:0 2px;" id="btn-edt" href="#detailrab" class="btn btn-flat btn-primary btn-sm" data-toggle="modal"><i class="fa fa-list"></i> Detail</a>
                  </div>
                </td>
              </tbody>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    kodeAkun("kode-akun");
    $("#add-more-akun").click(function(){
      $("#div-tambah-akun").show();
    });
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
