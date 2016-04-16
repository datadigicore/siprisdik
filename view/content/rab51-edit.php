<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RAB (51)
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-user"></i> Edit RAB</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Edit RAB</h3>
          </div>
          <form action="<?php echo $url_rewrite;?>process/rab51/edit" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idrab" value="<?php echo $getrab['id'];?>" />
            <div class="box-body">
              <div class="form-group">
                <label>Tahun Anggaran</label>
                <select class="form-control" name="tahun" id="tahun" required>
                  <?php for ($i=0; $i < count($tahun); $i++) { 
                    echo "<option value='".$tahun[$i]."'>".$tahun[$i].'</option>';
                  }?>
                </select>
              </div>
              <input type="hidden" id="prog" name="prog" value="06" />
              <div class="form-group">
                <label>Kode Kegiatan</label><br>
                <!-- <label><?php echo $direk[$direktorat]; ?></label> -->
                <input type="text" class="form-control" readonly id="direktorat2" name="direktorat2" value="<?php echo $direk[$direktorat]; ?>" />
                <input type="hidden" class="form-control" readonly id="direktorat" name="direktorat" value="<?php echo $direktorat; ?>" />
              </div>
              <div class="form-group">
                <label>Output</label>
                <select class="form-control" id="output" name="output" onchange="chout()" required>
                  <option>-- Pilih Output --</option>
                  <option value="tes">Tes aa</option>
                </select>
              </div>
              <div class="form-group">
                <label>Suboutput</label>
                <select class="form-control" id="soutput" name="soutput" onchange="chsout()" required>
                  <option>-- Pilih Sub Output --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Komponen</label>
                <select class="form-control" id="komp" name="komp" onchange="chkomp()" required>
                  <option>-- Pilih Komponen --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Sub Komponen</label>
                <select class="form-control" id="skomp" name="skomp" onchange="chskomp()" required>
                  <option>-- Pilih Sub Komponen --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Akun</label>
                <select class="form-control" id="akun" name="akun" onchange="chakun()" required>
                  <option>-- Pilih Akun --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tanggal</label>
                <input class="form-control" type="text" id="tanggal" name="tanggal" data-date-format="dd/mm/yyyy" value="<?php echo date('d/m/Y',strtotime($getrab['tanggal']));?>" placeholder="dd/mm/yyyy" />
              </div>
              <div class="form-group">
                <label>Jumlah</label>
                <input class="form-control" required type="number" name="jumlah" value="<?php echo $getrab['value'];?>" placeholder="" />
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
    $('#tahun').val('<?php echo $getrab["thang"]; ?>');
    $("#tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy' 
    });
    chprog();
});

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
        $('#output').val('<?php echo $getrab["kdoutput"]; ?>');
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
        $('#soutput').val('<?php echo $getrab["kdsoutput"]; ?>');
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
        $('#komp').val('<?php echo $getrab["kdkmpnen"]; ?>');
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
        $('#skomp').val('<?php echo $getrab["kdskmpnen"]; ?>');
        chskomp();
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
        $('#akun').val('<?php echo $getrab["kdakun"]; ?>');
      },
    });
  }
  </script>