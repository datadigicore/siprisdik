<div class="content-wrapper">
  <section class="content-header">
    <a  href="<?php echo $url_rewrite?>content/rab/<?php echo $idrkakl ?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB 
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> <b>
        <a  href="<?php echo $url_rewrite?>content/rab/<?php echo $idrkakl ?>"> Data RAB</a> 
        > Tambah RAB 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tambah RAB</h3>
          </div>
          <form action="<?php echo $url_rewrite;?>process/rab/save" method="POST" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label>Tahun Anggaran</label>
                <!-- <select class="form-control" name="tahun" id="tahun" required>
                  <?php 
                  // // for ($i=0; $i < count($tahun); $i++) { 
                  //   // echo "<option value='".$tahun[$i]."'>".$tahun[$i].'</option>';
                  // }
                  ?>
                </select> -->
                <input class="form-control " type="text" id="tahun" name="tahun" value="<?php echo $datarkakl[0]->THANG ?>" readonly/>
              </div>
              <input type="hidden" id="prog" name="prog" value="06" />
              <?php if ($_SESSION['direktorat'] == "") { ?>
              <div class="form-group">
                <label>Kode Kegiatan</label>
                <select class="form-control" id="direktorat" name="direktorat" onchange="chout()">
                    <option value="5696">5696</option>
                    <option value="5697">5697</option>
                    <option value="5698">5698</option>
                    <option value="5699">5699</option>
                    <option value="5700">5700</option>
                </select>
              </div>
              <?php } else{ ?>
              <input  type="hidden" id="direktorat" name="direktorat" value="<?php echo $_SESSION['direktorat']; ?>" />
              <?php } ?>
              <div class="form-group">
                <label>Output</label>
                <?php if($datarkakl[0]->KDOUTPUT!=""){?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon2"><?php echo $datarkakl[0]->NMOUTPUT ?></span>
                  <input class="form-control " type="text" id="output" name="output" value="<?php echo $datarkakl[0]->KDOUTPUT ?>" readonly/>

                  </div>
                  <?php } else {?>
                <select class="form-control" id="output" name="output" onchange="chout()" required>
                  <option value="">-- Pilih Output --</option>
                </select>
                <?php }?>
              </div>
              <div class="form-group">
                <label>Suboutput</label>
                <?php if($datarkakl[0]->KDSOUTPUT!=""){?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon2"><?php echo $datarkakl[0]->NMSOUTPUT ?></span>
                  <input class="form-control" type="text" id="soutput" name="soutput" value="<?php echo $datarkakl[0]->KDSOUTPUT ?>" readonly/>
                  </div>
                  <?php } else {?>
                <select class="form-control" id="soutput" name="soutput" onchange="chsout()" required>
                  <option value="">-- Pilih Sub Output --</option>
                </select>
                <?php }?>
              </div>
              <div class="form-group">
                <label>Komponen</label>
                <?php if($datarkakl[0]->KDKMPNEN!=""){?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon2"><?php echo $datarkakl[0]->NMKMPNEN ?></span>
                  <input class="form-control" type="text" id="komp" name="komp" value="<?php echo $datarkakl[0]->KDKMPNEN ?>" readonly/>
                  </div>
                  <?php } else {?>
                <select class="form-control" id="komp" name="komp" onchange="chkomp()" required>
                  <option value="">-- Pilih Komponen --</option>
                </select>
                <?php }?>
              </div>
              <div class="form-group">
                <label>Sub Komponen</label>
                <?php if($datarkakl[0]->KDSKMPNEN!=""){?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon2"><?php echo $datarkakl[0]->NMSKMPNEN ?></span>
                  <input class="form-control" type="text" id="skomp" name="skomp" value="<?php echo $datarkakl[0]->KDSKMPNEN ?>" readonly/>
                  </div>
                  <?php } else {?>
                <select class="form-control" id="skomp" name="skomp" onchange="chskomp()" required>
                  <option value="">-- Pilih Sub Komponen --</option>
                </select>
                <?php }?>
              </div>
              <div class="form-group">
                <label>Uraian Acara</label>
                <textarea rows="5" type="text" class="form-control" id="uraian" name="uraian" placeholder="Uraian Acara" style="resize:none;" required></textarea>
              </div>
              <div class="form-group">
                <label>Tanggal Awal</label>
                <input class="form-control tanggal" onchange="cektanggal()" type="text" id="tanggal" name="tanggal" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" required />
              </div>
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input class="form-control tanggal" onchange="cektanggal()" type="text" id="tanggal_akhir" name="tanggal_akhir" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" required />
              </div>
              <div class="form-group">
                <label>Tempat Kegiatan</label>
                <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Tempat Kegiatan" required />
              </div>
              <div class="form-group">
                <label>Kota</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Kota" required />
              </div>
              
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-success">Save</button>
            </div>
          </form>
         </div>        
      </div>
    </div>
  </section>
</div>

<script>
$(function() {
// chprog();
  $("#tanggal").datepicker({
    autoclose: true,
    monthNames: [ "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],

    // yearRange: '-70:+30',
           changeMonth: true,

           // numberOfMonths: 3,
           dateFormat: 'dd/mm/yy',
           onClose: function(selectedDate) {
            // alert("tes");
           $("#tanggal_akhir").datepicker("option", "minDate", selectedDate);
                   // var lama=(bulan_studi($('#lamaijin').val())+1)*31;
                   // var nyd = new Date(selectedDate);
                   // nyd.setDate(nyd.getDate() + lama);
                    //alert(nyd);
                // $("#tanggal_akhir").datepicker("option", "maxDate", nyd);
             //$("#periode_belajar_end").datepicker("option", "maxDate", " '+ "+lama+"M'");
           }
    });

    $("#tanggal_akhir").datepicker({ 
      autoclose: true,
    monthNames: [ "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy'
    });
    $("#tanggal_akhir").datepicker({ 
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy'
    });
    
    <?php if($datarkakl[0]->KDOUTPUT != ""){?>
      $("#output").prop('readonly', true);
      <?php
    }
    ?>
    // $(".tanggal").datepicker({ 
    //   monthNames: [ "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
    //   changeMonth: true,
    //   changeYear: true,
    //   format: 'dd/mm/yyyy' 
    // });
    // chprog();
});

function cektanggal(){
  var tanggal = $('#tanggal').val();
  var tanggal_akhir = $('#tanggal_akhir').val();
  var pecah_awal = tanggal.split("/"); 
  var pecah_akhir = tanggal_akhir.split("/"); 
  var parsed_awal = new Date(pecah_awal[2],pecah_awal[1],pecah_awal[0]); 
  var parsed_akhir = new Date(pecah_akhir[2],pecah_akhir[1],pecah_akhir[0]); 
  if (parsed_akhir < parsed_awal) {
    $('#tanggal_akhir').val('');
    alert("Tanggal Akhir Kurang Dari Tanggal Awal");
  };
}

function chprog(){
    $("#output option").remove();   
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#output').append('<option value="">-- Pilih Output --</option>');
    $('#soutput').append('<option value="">-- Pilih Sub Output --</option>');
    $('#komp').append('<option value="">-- Pilih Komponen --</option>');
    $('#skomp').append('<option value="">-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option value="">-- Pilih Akun --</option>');
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var prog = $('#prog').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getout",
      data: { 'prog' : prog,
              'tahun' : tahun,
              'direktorat' : direktorat
            },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.KDOUTPUT.length; i++) {
          if(<?php echo $datarkakl[0]->KDOUTPUT?> == obj.KDOUTPUT[i]){
            $('#output').append('<option value="'+obj.KDOUTPUT[i]+'" selected>'+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+'</option>');
          } else {
            $('#output').append('<option value="'+obj.KDOUTPUT[i]+'">'+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+'</option>');
          }
        };
      },
    });
  }
  function chout(){
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#soutput').append('<option value="">-- Pilih Sub Output --</option>');
    $('#komp').append('<option value="">-- Pilih Komponen --</option>');
    $('#skomp').append('<option value="">-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option value="">-- Pilih Akun --</option>');
    var prog = $('#prog').val();
    var output = $('#output').val();
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getsout",
      data: { 'prog' : prog,
              'output' : output,
              'tahun' : tahun,
              'direktorat' : direktorat
            },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.KDSOUTPUT.length; i++) {

          $('#soutput').append('<option value="'+obj.KDSOUTPUT[i]+'">'+obj.KDSOUTPUT[i]+' - '+obj.NMSOUTPUT[i]+'</option>')
        };
      },
    });

  }
  function chsout(){   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#komp').append('<option value="">-- Pilih Komponen --</option>');
    $('#skomp').append('<option value="">-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option value="">-- Pilih Akun --</option>');
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var prog = $('#prog').val();
    var output = $('#output').val();
    var soutput = $('#soutput').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getkomp",
      data: { 'prog' : prog,
              'output' : output,
              'soutput' : soutput,
              'tahun' : tahun,
              'direktorat' : direktorat
            },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.KDKMPNEN.length; i++) {
          $('#komp').append('<option value="'+obj.KDKMPNEN[i]+'">'+obj.KDKMPNEN[i]+' - '+obj.NMKMPNEN[i]+'</option>')
        };
      },
    });
  }
  function chkomp(){
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#skomp').append('<option value="">-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option value="">-- Pilih Akun --</option>');
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var prog = $('#prog').val();
    var output = $('#output').val();
    var soutput = $('#soutput').val();
    var komp = $('#komp').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getskomp",
      data: { 'prog' : prog,
              'output' : output,
              'soutput' : soutput,
              'komp' : komp,
              'tahun' : tahun,
              'direktorat' : direktorat
            },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.KDSKMPNEN.length; i++) {
          $('#skomp').append('<option value="'+obj.KDSKMPNEN[i]+'">'+obj.KDSKMPNEN[i]+' - '+obj.NMSKMPNEN[i]+'</option>')
        };
      },
    });
  }
  function chskomp(){ 
    $("#akun option").remove();   
    $('#akun').append('<option value="">-- Pilih Akun --</option>');
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var prog = $('#prog').val();
    var output = $('#output').val();
    var soutput = $('#soutput').val();
    var komp = $('#komp').val();
    var skomp = $('#skomp').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab51/getakun",
      data: { 'prog' : prog,
              'output' : output,
              'soutput' : soutput,
              'komp' : komp,
              'skomp' : skomp,
              'tahun' : tahun,
              'direktorat' : direktorat
            },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.KDAKUN.length; i++) {
          $('#akun').append('<option value="'+obj.KDAKUN[i]+'">'+obj.KDAKUN[i]+' - '+obj.NMAKUN[i]+'</option>')
        };
      },
    });
  }
  </script>