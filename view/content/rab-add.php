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
            <a href="<?php echo $url_rewrite;?>content/rab/add" class="btn btn-flat btn-success btn-sm pull-right">Tambah RAB</a>
          </div>
          <div class="box-body">
            <form class="form-horizontal" role="form" id="frmMode1" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>proses/student/">
             <input type="hidden" name="kategori" value="0">
                <!-- panel personal info -->
                <div class="panel panel-default">
                     <!-- Default panel contents -->
                     <div class="panel-heading te-panel-heading">
                          <i class="glyphicon glyphicon-th-large"></i> <span>Indentitas</span>
                     </div>

                     <div class="clearfix"></div>

                     <div class="panel-body">
                          <div class="form-group ">
                               <label for="inputFirstName" class="col-md-3 control-label">Nama Depan</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $namamahasiswa ?>" id="namamahasiswa" name="namamahasiswa" placeholder="Nama Depan">
                               </div>
                          </div>
                          <div class="form-group">
                               <label for="inputLastName" class="col-md-3 control-label">Nama Belakang</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $namamahasiswa2 ?>" id="namamahasiswa2" name="namamahasiswa2" placeholder="Nama Belakang">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputPlaceDateBirth" class="col-md-3 control-label">Tempat/Tanggal Lahir</label>
                               <div class="col-md-9">
                                    <div class="col-md-5 te-no-padding">
                                         <input type="text" class="form-control" id="tempatlahir" value="<?= $tempatlahir ?>" name="tempatlahir" placeholder="Tempat">
                                    </div>
                                    <div class="col-md-1">
                                         <label for="inputPlaceDateBirth" class="col-md-3 control-label te-no-padding">/</label>
                                    </div>
                                    <div class="col-md-6 te-no-padding">
                                         <script>
                                                      $(function() {
                                                      $("#tanggallahir").datepicker({
                                                      yearRange: '-70:+30',
                                                              changeMonth: true,
                                                              changeYear: true,
                                                              numberOfMonths: 1,
                                                              dateFormat: 'd M yy ',
                                                      });
                                                      });</script>
                                         <div class="input-group">
                                              <input type="text" readonly="1"class="form-control" id="tanggallahir" value="<?= $tanggallahir ?>"name="tanggallahir" placeholder="Tanggal Lahir" style="cursor:pointer">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                         </div>
                                    </div>
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputGender" class="col-md-3 control-label">Jenis Kelamin</label>
                               <div class="col-md-9">
                                    <select class="form-control" id="sex" name="sex">
                                         <option value="">Jenis Kelamin</option>
                                         <?php
                                         $qry = $DB->query("select idsex,namasex from sex");
                                         while ($row = $DB->fetch_object($qry)) {
                                              $id_sex = $row->idsex;
                                              $nama_sex = $row->namasex;
                                              if ($id_sex == $sex)
                                                   echo "<option value=\"$id_sex\" selected>$nama_sex</option>";
                                              else
                                                   echo "<option value=\"$id_sex\" >$nama_sex</option>";
                                         }
                                         ?>
                                    </select>
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputNationality" class="col-md-3 control-label">Kebangsaan</label>
                               <div class="col-md-9">
                                    <select class="form-control" name="nationality_idnationality" id="nationality_idnationality">
                                         <option value="">Pilih Kebangsaan</option>
                                         <?php
                                         $qry = $DB->query("select idnationality,namanegara from nationality");
                                         while ($row = $DB->fetch_object($qry)) {
                                              $id_nationality = $row->idnationality;
                                              $nama_negara = $row->namanegara;
                                              if ($id_nationality == $nationality_idnationality)
                                                   echo "<option value=\"$id_nationality\" selected>$nama_negara</option>";
                                              else
                                                   echo "<option value=\"$id_nationality\" >$nama_negara</option>";
                                         }
                                         ?>
                                    </select>
                               </div>
                          </div>

                     </div>
                     <!-- end of panel body -->
                </div>
                <!-- end of panel personal info -->

                <!-- panel residence info -->
                <div class="panel panel-default">
                     <!-- Default panel contents -->
                     <div class="panel-heading te-panel-heading">
                          <i class="glyphicon glyphicon-th-large"></i> <span>Tempat Tinggal Asal</span>
                     </div>

                     <div class="clearfix"></div>

                     <div class="panel-body">
                          <div class="form-group ">
                               <label for="inputHomeAddress" class="col-md-3 control-label">Alamat rumah</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="alamat" value="<?= $alamat ?>"name="alamat" placeholder="Alamat rumah">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputCity" class="col-md-3 control-label">Kota</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="city" name="city" value="<?= $city ?>" placeholder="Kota">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputProvince" class="col-md-3 control-label">Provinisi/Negara Bagian</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="province" name="province" value="<?= $province ?>"placeholder="Provinsi/ Negara Bagian">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputCountry" class="col-md-3 control-label">Negara</label>
                               <div class="col-md-9">
                                    <select class="form-control" name="country" id="country">
                                         <option value="">Pilih Negara </option>
                                         <?php
                                         $qry = $DB->query("select country_name from countries order by country_name  asc ");
                                         while ($row = $DB->fetch_object($qry)) {
                                              $country_name = $row->country_name;
                                              if ($country_name == $country)
                                                   echo "<option value=\"$country_name\" selected>$country_name </option>";
                                              else
                                                   echo "<option value=\"$country_name\" >$country_name </option>";
                                         }
                                         ?>
                                    </select>
                                 <!--   <input type="text" class="form-control" id="country" name="country" value="<?= $country ?>" placeholder="Country">
                               -->
                                 </div>
                          </div>

                          <div class="form-group">
                               <label for="inputPostalCode" class="col-md-3 control-label">Kode Pos</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="postal" value="<?= $postal ?>" name="postal" placeholder="Kode Pos">
                               </div>
                          </div>

                     </div>
                     <!-- end of panel body -->
                </div>
                <!-- end of panel residence info -->

                <!-- panel current address info -->
                <div class="panel panel-default">
                     <!-- Default panel contents -->
                     <div class="panel-heading te-panel-heading">
                          <i class="glyphicon glyphicon-th-large"></i> <span>Tempat Tinggal di Indonesia</span>
                     </div>

                     <div class="clearfix"></div>

                     <div class="panel-body">
                          <div class="form-group ">
                               <label for="inputCurrentAddress" class="col-md-3 control-label">Alamat Terkini</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="alamatind" value="<?= $alamatind ?>"name="alamatind" placeholder="Alamat saat ini">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputCity" class="col-md-3 control-label">Kota</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="cityind" value="<?= $cityind ?>" name="cityind" placeholder="Kota ">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputProvince" class="col-md-3 control-label">Provinsi/Negara Bagian</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="provinceid" value="<?= $provinceid ?>" name="provinceid" placeholder="Provinsi/ Negara Bagian">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputPostalCode" class="col-md-3 control-label">Kode Pos</label>
                               <div class="col-md-9">
                                    <input type="text" class="form-control" id="postalind" value="<?= $postalind ?>" name="postalind" placeholder="Kode Pos">
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputPhone" class="col-md-3 control-label">Telp/Handphone</label>
                               <div class="col-md-9">
                                    <div class="col-md-5 te-no-padding">
                                         <input type="text" class="form-control" id="telp" name="telp" value="<?= $telp ?>" placeholder="Telp.">
                                    </div>
                                    <div class="col-md-1">
                                         <label for="inputPhone" class="col-md-3 control-label te-no-padding">/</label>
                                    </div>
                                    <div class="col-md-6 te-no-padding">
                                         <input type="text" class="form-control" id="telp2" name="telp2" value="<?= $telp2 ?>" placeholder="Handphone">
                                    </div>
                               </div>
                          </div>

                          <div class="form-group">
                               <label for="inputPhoto" class="col-md-3 control-label">Foto  (jpg/png)</label>
                               <div class="col-md-9">
                                    <?php
                                    if ($foto != "") {
                                         echo "<img src='$url_rewrite/data/$id/$foto' style='width:50%'>&nbsp;&nbsp;&nbsp;";
                                         echo "<button type=\"button\" class=\"btn btn-warning btn-sm\"
                                         onclick=\"javascript:location.href='$url_rewrite" . "proses/student/rfoto/$id/$foto '\"
                                         >Remove File</button>";
                                         echo "<input type='hidden' value='$foto' name='text_foto'/>";
                                    } else {
                                         ?>
                                         <input type="file" class="form-control" id="foto" name="foto">
                                         <?php
                                    }
                                    ?>
                               </div>
                          </div>

                     </div>
                     <!-- end of panel body -->
                </div>
                <!-- end of panel current address info -->


                <div class="form-group">
                     <div class="col-md-offset-3 col-md-9">
                          <button type="submit" name="btnPersonal" class="btn btn-primary">Save and Next</button>
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
  </section>
</div>
<script>
  $(function () {
    $('#table').DataTable({
      "scrollX": true
    });
  });
</script>
