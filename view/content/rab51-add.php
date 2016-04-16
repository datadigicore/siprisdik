<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RAB (51)
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-user"></i> Tambah RAB</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tambah RAB</h3>
          </div>
          <form action="<?php echo $url_rewrite;?>process/rab51/save" method="POST" enctype="multipart/form-data">
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
                <!-- <select class="form-control" id="output" name="output" onchange="chout()" required>
                  <option>-- Pilih Output --</option>
                </select> -->
                <input type="text" class="form-control" value="994 - Layanan Perkantoran" readonly>
                <input type="hidden" id="output" name="output" value="994">
              </div>
              <div class="form-group">
                <label>Suboutput</label>
                <!-- <select class="form-control" id="soutput" name="soutput" onchange="chsout()" required>
                  <option>-- Pilih Sub Output --</option>
                </select> -->
                <input type="text" class="form-control" value="001 - Layanan Perkantoran" readonly>
                <input type="hidden" id="soutput" name="soutput" value="001">
              </div>
              <div class="form-group">
                <label>Komponen</label>
                <!-- <select class="form-control" id="komp" name="komp" onchange="chkomp()" required>
                  <option>-- Pilih Komponen --</option>
                </select> -->
                <input type="text" class="form-control" value="001 - Gaji dan Tunjangan" readonly>
                <input type="hidden" id="komp" name="komp" value="001">
              </div>
              <div class="form-group">
                <label>Sub Komponen</label>
                <!-- <select class="form-control" id="skomp" name="skomp" onchange="chskomp()" required>
                  <option>-- Pilih Sub Komponen --</option>
                </select> -->
                <input type="text" class="form-control" value="A - Pembayaran Gaji dan Tunjangan" readonly>
                <input type="hidden" id="skomp" name="skomp" value="A">
              </div>
              <div class="form-group">
                <label>Akun</label>
                <select class="form-control" id="akun" name="akun" onchange="chakun()" required>
                  <option>-- Pilih Akun --</option>
                </select>
              </div>
              <!-- <div class="form-group">
                <label>Deskripsi</label>
                <textarea rows="5" type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" style="resize:none;" required></textarea>
              </div> -->
              <div class="form-group">
                <label>Tanggal</label>
                <input class="form-control" type="text" id="tanggal" name="tanggal" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" />
              </div>
              <div class="form-group">
                <label>Jumlah</label>
                <input class="form-control uang" required type="text" name="jumlah" />
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
    $("#tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy' 
    });
    $('.uang').mask('000.000.000.000.000.000.000', {reverse: true});
    chskomp();
});

// function chprog(){
//     $("#output option").remove();   
//     $("#soutput option").remove();   
//     $("#komp option").remove();   
//     $("#skomp option").remove();   
//     $("#akun option").remove();   
//     $('#output').append('<option>-- Pilih Output --</option>');
//     $('#soutput').append('<option>-- Pilih Sub Output --</option>');
//     $('#komp').append('<option>-- Pilih Komponen --</option>');
//     $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
//     $('#akun').append('<option>-- Pilih Akun --</option>');
//     var tahun = $('#tahun').val();
//     var direktorat = $('#direktorat').val();
//     var prog = $('#prog').val();
//     $.ajax({
//       type: "POST",
//       url: "<?php echo $url_rewrite;?>process/rab/getout",
//       data: { 'prog' : prog,
//               'tahun' : tahun,
//               'direktorat' : direktorat
//             },
//       success: function(data){
//         var obj = jQuery.parseJSON(data);
//         for (var i = 0; i < obj.KDOUTPUT.length; i++) {
//           $('#output').append('<option value="'+obj.KDOUTPUT[i]+'">'+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+'</option>')
//         };
//       },
//     });
//   }
//   function chout(){
//     $("#soutput option").remove();   
//     $("#komp option").remove();   
//     $("#skomp option").remove();   
//     $("#akun option").remove();   
//     $('#soutput').append('<option>-- Pilih Sub Output --</option>');
//     $('#komp').append('<option>-- Pilih Komponen --</option>');
//     $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
//     $('#akun').append('<option>-- Pilih Akun --</option>');
//     var prog = $('#prog').val();
//     var output = $('#output').val();
//     var tahun = $('#tahun').val();
//     var direktorat = $('#direktorat').val();
//     $.ajax({
//       type: "POST",
//       url: "<?php echo $url_rewrite;?>process/rab/getsout",
//       data: { 'prog' : prog,
//               'output' : output,
//               'tahun' : tahun,
//               'direktorat' : direktorat
//             },
//       success: function(data){
//         var obj = jQuery.parseJSON(data);
//         for (var i = 0; i < obj.KDSOUTPUT.length; i++) {
//           $('#soutput').append('<option value="'+obj.KDSOUTPUT[i]+'">'+obj.KDSOUTPUT[i]+' - '+obj.NMSOUTPUT[i]+'</option>')
//         };
//       },
//     });
//   }
//   function chsout(){   
//     $("#komp option").remove();   
//     $("#skomp option").remove();   
//     $("#akun option").remove();   
//     $('#komp').append('<option>-- Pilih Komponen --</option>');
//     $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
//     $('#akun').append('<option>-- Pilih Akun --</option>');
//     var tahun = $('#tahun').val();
//     var direktorat = $('#direktorat').val();
//     var prog = $('#prog').val();
//     var output = $('#output').val();
//     var soutput = $('#soutput').val();
//     $.ajax({
//       type: "POST",
//       url: "<?php echo $url_rewrite;?>process/rab/getkomp",
//       data: { 'prog' : prog,
//               'output' : output,
//               'soutput' : soutput,
//               'tahun' : tahun,
//               'direktorat' : direktorat
//             },
//       success: function(data){
//         var obj = jQuery.parseJSON(data);
//         for (var i = 0; i < obj.KDKMPNEN.length; i++) {
//           $('#komp').append('<option value="'+obj.KDKMPNEN[i]+'">'+obj.KDKMPNEN[i]+' - '+obj.NMKMPNEN[i]+'</option>')
//         };
//       },
//     });
//   }
//   function chkomp(){
//     $("#skomp option").remove();   
//     $("#akun option").remove();   
//     $('#skomp').append('<option>-- Pilih Sub Komponen --</option>');
//     $('#akun').append('<option>-- Pilih Akun --</option>');
//     var tahun = $('#tahun').val();
//     var direktorat = $('#direktorat').val();
//     var prog = $('#prog').val();
//     var output = $('#output').val();
//     var soutput = $('#soutput').val();
//     var komp = $('#komp').val();
//     $.ajax({
//       type: "POST",
//       url: "<?php echo $url_rewrite;?>process/rab/getskomp",
//       data: { 'prog' : prog,
//               'output' : output,
//               'soutput' : soutput,
//               'komp' : komp,
//               'tahun' : tahun,
//               'direktorat' : direktorat
//             },
//       success: function(data){
//         var obj = jQuery.parseJSON(data);
//         for (var i = 0; i < obj.KDSKMPNEN.length; i++) {
//           $('#skomp').append('<option value="'+obj.KDSKMPNEN[i]+'">'+obj.KDSKMPNEN[i]+' - '+obj.NMSKMPNEN[i]+'</option>')
//         };
//       },
//     });
//   }
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