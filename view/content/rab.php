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

            <a href="#addrab" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah RAB</a>

          </div>
          <div class="box-body">
            <table class="display table table-bordered table-striped" style="width:200px">
              <tr>
                <td><label>Tahun</label></td>
                <td>
                  <select id="tahun" name="tahun" class="select2" onchange="search()">
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                  </select>
                </td>
              </tr>
              <?php if ($_SESSION['direktorat'] == "") { ?>
              <tr>
                <td><label>Direktorat</label></td>
                  <td>
                    <select id="direktorat" name="direktorat" class="select2" onchange="search()">
                      <option value="5696">5696</option>
                      <option value="5697">5697</option>
                      <option value="5698">5698</option>
                      <option value="5699">5699</option>
                      <option value="5700">5700</option>
                    </select>
                  </td>
              </tr>
              <?php } else{ ?>
              <input type="hidden" id="direktorat" name="direktorat" value="<?php echo $_SESSION['direktorat']; ?>" />
              <?php } ?>
            </table>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Kode RKAKL</th>
                  <th>Uraian Acara</th>
                  <th>Tanggal</th>
                  <th>Lokasi</th>
                  <!-- <th>Uang Muka Kegiatan</th>
                  <th>Realisasi SPJ</th>
                  <th>Realisasi Pajak</th>
                  <th>Sisa Uang Muka</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    Program   : 06 <br>
                    Output    : 10 <br>
                    Suboutput : 10 <br>
                    Komponen  : 10 <br>
                  </td>
                  <td>Uraian</td>
                  <td>7 Jan 2016</td>
                  <td>-</td>
                  <!-- <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td> -->
                  <td>
                    <div class="text-center">
                      <a style="margin:0 2px;" id="btn-edt" href="<?php echo $url_rewrite;?>content/rabdetail" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Add Transaksi</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="addrab">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab/save" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Add RAB</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Program</label>
            <select class="form-control" name="prog" id="prog" onchange="chprog()" required>
              <option>-- Pilih Program --</option>
              <?php for ($i=0; $i < count($program); $i++) { 
                echo "<option value='".$program[$i]."'>".$program[$i]." - Direktorat Jenderal Kelembagaan Ilmu Pengetahuan Teknolgi dan Pendidikan Tinggi</option>";
              }?>
            </select>
          </div>
          <div class="form-group">
            <label>Output</label>
            <select class="form-control" id="output" name="output" onchange="chout()" required>
              <option>-- Pilih Output --</option>
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
            <label>Uraian Acara</label>
            <textarea rows="5" type="text" class="form-control" id="uraian" name="uraian" placeholder="Uraian Acara" style="resize:none;" required></textarea>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input class="form-control" type="text" name="tanggal"  placeholder="dd/mm/yyyy" />
          </div>
          <div class="form-group">
            <label>Lokasi Kegiatan</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi Kegiatan" required />
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(function () {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy'
    });
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var table = $('#table').DataTable({
      "scrollX": true,
      // "bProcessing": true,
      // "bServerSide": true,
      // "sAjaxSource": "getRab",
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tahun", "value": tahun },
                      { "name": "direktorat", "value": direktorat } );
      }
    });
  });
<<<<<<< HEAD
</script>
=======

  function search(){
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    table.destroy();
    $('#table').DataTable({
      "scrollX": true,
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "getRab",
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tahun", "value": tahun },
                      { "name": "direktorat", "value": direktorat } );
      }
    });
  }

  function chprog(){
    $("#output option").remove();   
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $('#output').append('<option>-- Pilih Output --</option>');
    $('#soutput').append('<option>-- Pilih Sub Output --</option>');
    $('#komp').append('<option>-- Pilih Komponen --</option>');
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
      },
    });
  }
  function chout(){
    $("#soutput option").remove();   
    $("#komp option").remove();   
    $('#soutput').append('<option>-- Pilih Sub Output --</option>');
    $('#komp').append('<option>-- Pilih Komponen --</option>');
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var prog = $('#prog').val();
    var output = $('#output').val();
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
    $('#komp').append('<option>-- Pilih Komponen --</option>');
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
</script>
>>>>>>> fd27e5c190fee33c2f298c31d88ef3641c1984e5
