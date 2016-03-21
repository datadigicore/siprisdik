<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rab" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB 
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > Edit RAB 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Edit RAB</h3>
          </div>
          <form action="<?php echo $url_rewrite;?>process/rab/edit" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idview" value="<?php echo $getview['id'];?>" />
            <div class="box-body">
              <div class="form-group">
                <label>Tahun Anggaran</label>
                <select  <?php echo $readonly;?> class="form-control" name="tahun" id="tahun" required>
                  <?php for ($i=0; $i < count($tahun); $i++) { 
                    echo "<option value='".$tahun[$i]."'>".$tahun[$i].'</option>';
                  }?>
                </select>
              </div>
              
              <input type="hidden" id="prog" name="prog" value="06" />
              <input type="hidden" id="direktorat" name="direktorat" value="<?php echo $_SESSION['direktorat']; ?>" />
              
              <div class="form-group">
                <label>Output</label>
                <select <?php echo $readonly;?> class="form-control" id="output" name="output" onchange="chout()" required>
                  <option>-- Pilih Output --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Suboutput</label>
                <select <?php echo $readonly;?> class="form-control" id="soutput" name="soutput" onchange="chsout()" required>
                  <option>-- Pilih Sub Output --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Komponen</label>
                <select <?php echo $readonly;?> class="form-control" id="komp" name="komp" onchange="chkomp()" required>
                  <option>-- Pilih Komponen --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Sub Komponen</label>
                <select <?php echo $readonly;?> class="form-control" id="skomp" name="skomp" onchange="chskomp()" required>
                  <option>-- Pilih Sub Komponen --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Uraian Acara</label>
                <textarea rows="5" type="text" class="form-control" id="uraian" name="uraian" placeholder="Uraian Acara" style="resize:none;" required><?php echo $getview['deskripsi'];?></textarea>
              </div>
              <div class="form-group">
                <label>Tanggal Awal</label>
                <input class="form-control tanggal" onchange="cektanggal()" type="text" id="tanggal" name="tanggal" value="<?php echo date('d/m/Y',strtotime($getview['tanggal']));?>" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" />
              </div>
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input class="form-control tanggal" onchange="cektanggal()" type="text" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo date('d/m/Y',strtotime($getview['tanggal_akhir']));?>" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" />
              </div>
              <div class="form-group">
                <label>Tempat Kegiatan</label>
                <input type="text" class="form-control" id="tempat" name="tempat" value="<?php echo $getview['tempat'];?>" placeholder="Tempat Kegiatan" required />
              </div>
              <div class="form-group">
                <label>Kota</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $getview['lokasi'];?>" placeholder="Kota" required />
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
    $('#tahun').val('<?php echo $getview["thang"]; ?>');
    $(".tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });
    chprog();
    cektanggal();
});

function cektanggal(){
  var tanggal = $('#tanggal').val();
  var tanggal_akhir = $('#tanggal_akhir').val();
  var pecah_awal = tanggal.split("/"); 
  var pecah_akhir = tanggal_akhir.split("/"); 
  var parsed_awal = new Date(pecah_awal[2],pecah_awal[1],pecah_awal[0]); 
  var parsed_akhir = new Date(pecah_akhir[2],pecah_akhir[1],pecah_akhir[0]); 
  if (parsed_akhir < parsed_awal) {
    $('#tanggal_akhir').val("");
    alert("Tanggal Akhir Kurang Dari Tanggal Awal");
  };
}

function chprog(){
    $("#output option").remove();   
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#output').append('<option>-- Pilih Output --</option>');
    $('#soutput').append('<option>-- Pilih Sub Output --</option>');
    $('#komp').append('<option>-- Pilih Komponen --</option>');
    $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option>-- Pilih Akun --</option>');
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
          $('#output').append('<option value="'+obj.KDOUTPUT[i]+'">'+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+'</option>')
        };
        $('#output').val('<?php echo $getview["kdoutput"]; ?>');
        chout();
      },
    });
  }
  function chout(){
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#soutput').append('<option>-- Pilih Sub Output --</option>');
    $('#komp').append('<option>-- Pilih Komponen --</option>');
    $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option>-- Pilih Akun --</option>');
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
        $('#soutput').val('<?php echo $getview["kdsoutput"]; ?>');
        chsout();
      },
    });
  }
  function chsout(){   
    $("#komp option").remove();   
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#komp').append('<option>-- Pilih Komponen --</option>');
    $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option>-- Pilih Akun --</option>');
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
        $('#komp').val('<?php echo $getview["kdkmpnen"]; ?>');
        chkomp();
      },
    });
  }
  function chkomp(){
    $("#skomp option").remove();   
    $("#akun option").remove();   
    $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
    $('#akun').append('<option>-- Pilih Akun --</option>');
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
        $('#skomp').val('<?php echo $getview["kdskmpnen"]; ?>');
      },
    });
  }
  function chskomp(){ 
    $("#akun option").remove();   
    $('#akun').append('<option>-- Pilih Akun --</option>');
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