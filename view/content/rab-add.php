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
  <?php if($_SESSION['level'] != 0){ ?>
  <form class="form-horizontal" role="form" id="formAkun" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>process/rab_rinci/tambahAkun">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
        </div>
        <div class="box-body" >
          <?php if (isset($_POST['message'])): ?>
            <div class="alert alert-<?php echo $_POST['alert']; ?> alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fa fa-warning"></i><?php echo $_POST['message']; ?>
            </div>
          <?php endif ?>
            <input type="hidden" id="id_rabfull" name="id_rabfull" value="<?php echo $id_rabfull?>" />
            <a style="" id="add-more-akun" href="#" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i> Tambah Akun</a>
            <div class="well" id="div-tambah-akun" style="display:none"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kdakun" onchange="chakun()" required />
              </select>

              <label>No Item</label>
              <select style="margin:5px auto" class="form-control" id="noitem" name="noitem" required />
              </select>

              <div id="bahan" class="hidden">
                <label>PPN</label>
                <input style="margin:5px auto" type="number" class="form-control" name="ppn" id="ppn" value="" placeholder="PPN" required />
              </div>

              <div id="tbl_rute" class="hidden">  
                <br>
                <a class="form-control btn btn-primary btn-sm" onclick="tambahRute()"><i class="fa fa-plus"></i> Tambah Rute</a>
              </div>

              <div id="nilai">
                <label>Value</label>
                <input style="margin:5px auto" type="number" class="form-control" name="value" id="value" value="" placeholder="Value" required />
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php }?>

  <div id="perjalanan" class="row">
  </div>
  
  <div id="tbl_save" class="row hidden">
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-footer">
          <button type="submit" onclick="simpan()" class="btn btn-flat btn-success btn-lg col-xs-12"><i class="fa fa-save"></i> Simpan Akun</a></button>
        </div>
      </div>
    </div>
  </div>

  </form>

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya Yang Sudah Tercatat</h3>
          <!-- <a href="#addrab" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Akun</a> -->
        </div>
        <div class="box-body">
          
          <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
            <thead style="background-color:#11245B;color:white;">
              <tr>
                <th>No</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>No. Item</th>
                <th>Nama Item</th>
                <th>Nilai (Rupiah)</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>        
    </div>
  </div>
  </section>
</div>
<script>

  function getdatepicker(){
    $(".tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });
  }

  $(document).ready(function() {
    $("#add-more-akun").click(function(){
      kodeAkun("kode-akun");
      $("#div-tambah-akun").show();
      $("#tbl_save").removeClass('hidden');
    });
    $("#buat-akun").click(function(){
      var val = $("#kode-akun").val();
      generateForm(val);
    });
    $(document).on("click",".btn-dismiss",function(){
      var val = $(this).attr("value");
      //alert(val);
      $("#"+val).remove();
      $("#kode-akun option[value='"+val+"']").show();
    });
  });


  function generateForm(kdAkun){
    var form_header = '<div class="row" id="'+kdAkun+'">'+
    '<div class="col-xs-12">'+
      '<div class="box">'+
        
        '<div class="box-body">'+
          
          '<div class="panel panel-default" >'+
                     '<div class="panel-heading te-panel-heading">'+
                          '<i class="glyphicon glyphicon-th-large"></i> <span>Belanja Honor Ouput Kegiatan</span>'+
                          '<button class="btn btn-danger btn-dismiss" id="close-'+kdAkun+'" value="'+kdAkun+'" ><i class="fa fa-close"></i></button>'+
                     '</div>'+

                     '<div class="clearfix"></div>'+

                     '<div class="panel-body">'+
                      
                      '<form acion="#" method="POST" class="form-horizontal" name="form-'+kdAkun+'" id="form-'+kdAkun+'">';
        var isi ="";
        var form_footer= '<a class="btn btn-primary" type="submit" id="">Simpan Akun</a>'+
                      '</form>'+
                    '</div>'+
                    '</div>'+
        '</div>'+
      '</div>'+        
    '</div>'+
    '</div>';
    $.ajax({
      method: "GET",
      url: "<?php echo $url_rewrite?>ajax/show_item.php",
      data: { kdAkun: kdAkun, }
    })
    .done(function( r ) {
      r=JSON.parse(r);
      if(r!=null){
        $.each( r, function( key, value ) {
          //alert( key + ": " + value );
          isi = isi+ '<div class="form-group ">'+
                         '<label class="col-md-3 control-label">'+value+'</label>'+
                         '<div class="col-md-9">'+
                              '<input type="text" class="form-control" value="" id="'+kdAkun+'-'+key+'" name="'+kdAkun+'-'+key+'" placeholder="'+value+'">'+
                         '</div>'+
                    '</div>';
        });
        $("#panel-akun").append(form_header+isi+form_footer);
      } else {
        alert("Tidak terdapat item pada kode akun yang anda pilih");
      }
    });    
  }

  function kodeAkun(idSelector){
    var id_rabfull = $('#id_rabfull').val();
    var isi ="<option>-- Pilih Kode Akun --</option>";
    $.ajax({
      method: "GET",
      url: "<?=$url_rewrite?>ajax/show_opsi_akun.php",
      data: { 'id_rabfull': id_rabfull, }
    })
    .done(function(data){
      obj=JSON.parse(data);
      if(obj!=null){
        $.each( obj, function( key, value ) {
          isi = isi+ '<option value="'+key+'">'+key+' - '+value+'</option>';
        });
        $("#kode-akun").append(isi);
      }
    });
  }

  function chakun(){
    var id_rabfull = $('#id_rabfull').val();
    var kdAkun = $('#kode-akun').val();
    $("#noitem option").remove();
    var isi ="<option>-- Pilih No Item --</option>";
    $.ajax({
      method: "GET",
      url: "<?php echo $url_rewrite?>ajax/show_item.php",
      data: { 'id_rabfull': id_rabfull,
              'kdAkun'    : kdAkun, }
    })
    .done(function( r ) {
        r=JSON.parse(r);
        if(r!=null){
          $.each( r, function( key, value ) {
            isi = isi+ '<option value="'+key+'">'+key+' - '+value+'</option>';
          });
          $("#noitem").append(isi);
        } else {
          alert("Tidak terdapat item pada kode akun yang anda pilih");
        }
      });  

    $.ajax({
      method: "POST",
      url: "<?=$url_rewrite?>process/rab_rinci/cekDinas",
      data: { 'id_rabfull': id_rabfull,
              'kdAkun'    : kdAkun, },
      success: function(data){
        data=JSON.parse(data);
        if (data.error) {
         $('#kode-akun').prop('selectedIndex',0);
         $('#noitem option').remove();
         if (data.error == 1) {
          alert('Tidak dapat menambah kode akun baru');
         }else if(data.error == 2){
          alert('Sudah terdapat kode akun 521213. Tidak dapat menambah kode akun selain 524114 / 524119');
         }else if(data.error == 3){
          alert('Sudah terdapat kode akun 522151. Tidak dapat menambah kode akun selain 524114 / 524119');
         }else if(data.error == 4){
          alert('Sudah terdapat kode akun 524114. Tidak dapat menambah kode akun selain 521213 / 522151');
         }else if(data.error == 5){
          alert('Sudah terdapat kode akun 524119. Tidak dapat menambah kode akun selain 521213 / 522151');
         };
        } else {
          if(kdAkun=="524119" || kdAkun=="524114"){
            $('#tbl_rute').removeClass('hidden');
            $('#bahan').addClass('hidden');
            $('#nilai').addClass('hidden');
          } else if(kdAkun == "521211"){
            $('#tbl_rute').addClass('hidden');
            $('#bahan').removeClass('hidden');
            $('#nilai').removeClass('hidden');
            $('#perjalanan').addClass('hidden');
          } else {
            $('#tbl_rute').addClass('hidden');
            $('#bahan').addClass('hidden');
            $('#nilai').removeClass('hidden');
            $('#perjalanan').addClass('hidden');
          }
        }
      },
    });
  }

  function tambahRute(){
    $('#perjalanan').append( ''
          +'<div class="col-xs-4">'
          +'  <div class="box box-warning">'
          +'    <div class="box-header with-border">'
          +'      <h3 class="box-title" style="margin-top:6px;">Tambah Rute</h3>'
          +'      <div class="box-tools pull-right">'
          +'        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>'
          +'        </button>'
          +'      </div>'
          +'    </div>'
          +'    <div class="box-body">'
          +'        <input type="hidden" name="perjalanan" value="true">'
          +'        <label>Rute</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" placeholder="Rute">'
    
          +'        <label>Value</label>'
          +'        <input style="margin:5px auto" required type="text" class="form-control" id="value[]" name="value[]" placeholder="Value">'
                      
          +'        <label> Tanggal Berangkat</label>'
          +'        <div style="margin:5px auto" class="input-group">'
          +'            <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" placeholder="dd/mm/yyyy">'
          +'             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
          +'        </div>'
          +'        <label> Tanggal Kembali</label>'
          +'        <div class="input-group">'
          +'             <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" placeholder="dd/mm/yyyy">'
          +'             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
          +'        </div>'

          +'        <label>Alat Transportasi</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" placeholder="Alat Transportasi">'

          +'        <label>Kota Asal</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal">'

          +'        <label>Kota Tujuan</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan">'

          +'        <label>Taxi Asal</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="taxi_asal[]" name="taxi_asal[]" placeholder="Taxi Asal">'

          +'        <label>Taxi Tujuan</label>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="Taxi Tujuan">'

          +'    </div>'
          +'  </div>'
          +'</div>' );
      getdatepicker();
  }

    
  function simpan(){
    $( "form" ).submit();
    
  }
  // $( "#formAkun" ).submit();
  
  $(function () {
     var table = $("#table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/tableAkun/<?php echo $id_rabfull; ?>",
        "type": "GET"
      },
      "columnDefs" : [
        {"targets" : 0,
         "visible" : false},
        {"targets" : 1},
        {"targets" : 2},
        {"targets" : 3},
        {"targets" : 4},
        {"targets" : 5},
      ],
      "order": [[ 0, "desc" ]]
    });
  });
</script>
