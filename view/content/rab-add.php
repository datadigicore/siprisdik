<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $getrab->rabview_id;?>"> Orang/Badan </a>
        >
         Transaksi </a>
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
  <form class="form-horizontal" role="form" id="formAkun" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>process/rab_rinci/tambahAkun">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="margin-top:6px;">Transaksi</h3>
        </div>
        <div class="box-body" >
          <?php if (isset($_POST['message'])): ?>
            <div class="alert alert-<?php echo $_POST['alert']; ?> alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fa fa-warning"></i><?php echo $_POST['message']; ?>
            </div>
          <?php endif ?>
            <table class="display table table-bordered table-striped" >
              <tr>
                <th class="col-md-1"><label>RKAKL</label></th>
                <th class="col-md-1"><label>Penerima</label></th>
              </tr>
              <tr>
                <td>
                <table>
                <tr><td valign="top">Tahun</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->THANG?></td></tr>
                <tr><td valign="top">Kegiatan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMGIAT?></td></tr>
                <tr><td valign="top">Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMOUTPUT?></td></tr>
                <tr><td valign="top">Sub Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMSOUTPUT?></td></tr>
                <tr><td valign="top">Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMKMPNEN?></td></tr>
                <tr><td valign="top">Sub Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NmSkmpnen?></td></tr>
<!--                 <tr><td valign="top">Alokasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo "Rp. ".$eval_nilai['pagu']; ?></td></tr>
                <tr><td valign="top">Realisasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo "Rp. ".$eval_nilai['realisasi']; ?></td></tr>
                <tr><td valign="top">Sisa</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo "Rp. ".$eval_nilai['sisa']; ?></td></tr>
                <tr><td valign="top">Usulan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo "Rp. ".$eval_nilai['usulan']; ?></td></tr>
       -->      </table>
                </td>
                <td>
                <table>
                <tr><td valign="top">NPWP</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $getrab->npwp;?></td></tr>
                <tr><td valign="top">Nama</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $getrab->penerima;?></td></tr>
                <tr><td valign="top" id="title_dipa"></td><td valign="top">:&nbsp;</td><td valign="top" id="nilai_dipa"></td></tr>
                <tr><td valign="top" id="title_realisasi"></td><td valign="top">:&nbsp;</td><td valign="top" id="nilai_realisasi" ></td></tr>
                <tr><td valign="top" id="title_sisa"></td><td valign="top">:&nbsp;</td><td valign="top" id="nilai_sisa"></td></tr>
                </table>
                </td>
            </table>
            <br>
            <input type="hidden" id="id_rabfull" name="id_rabfull" value="<?php echo $id_rabfull?>" />
            <?php if($_SESSION['level'] != 0){ ?>
            <?php if($getrab->status == 0 || $getrab->status == 3 || $getrab->status == 5){ ?>
            <a style="" id="add-more-akun" href="#" class="btn btn-flat btn-success btn-lg"><i class="fa fa-plus"></i> Tambah Transaksi</a>
            <?php }?>
            <?php }?>
            <div class="well" id="div-tambah-akun" style="display:none"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kdakun" onchange="chakun()" required />
              </select>

              <label>No Item</label>
              <select style="margin:5px auto" class="form-control" id="noitem" name="noitem" required />
              </select>

              <div id="bahan">
              </div>

              <div id="tbl_rute">  
              </div>

              <div id="nilai">
              </div>
            </div>
            <div id="perjalanan">
            </div>

            <div id="tbl_save" class="col-xs-12 hidden">
              <button type="submit" class="btn btn-flat btn-success btn-lg"><i class="fa fa-save"></i> Simpan Akun</a></button>
            </div>
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
                <th>Nilai (Rupiah)</th>
                <th>Aksi</th>
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
<div class="modal fade" id="delrab">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab_rinci/delrab" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rab_del" name="id_rab_del" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Ingin Menghapus Data ?</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Tidak</button>
          <button type="submit" class="btn btn-flat btn-success">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  var table;
  $(function () {
    table = $("#table").DataTable({
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
      ],
      "order": [[ 0, "desc" ]]
    });

    $(document).on("click", "#btn-del", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rab_del").val(tabrow.data()[0]);
    });

    
  });

  function getdatepicker(){
    $(".tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });
  }

  function mask(){
    $('.tanggal').mask('00/00/0000');
    $('.uang').mask('000.000.000.000.000.000.000', {reverse: true});
    $('.nomor').mask('0000');
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
    var isi ="<option value=''>-- Pilih Kode Akun --</option>";
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
        $("#kode-akun").html(isi);
      }
    });
  }

  function chakun(){
    var id_rabfull = $('#id_rabfull').val();
    var kdAkun = $('#kode-akun').val();
    $("#noitem option").remove();
    var isi ="<option value=''>-- Pilih No Item --</option>";
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
      url: "<?=$url_rewrite?>process/rab_rinci/hitung_pagu",
      data: { 'id_rabfull': id_rabfull,
              'kdAkun'    : kdAkun, },
      dataType: "json"
    })
    .done(function( r ) {
        // alert(r.sisa);
        document.getElementById('title_dipa').innerHTML = "Alokasi Kode "+r.kdakun;
        document.getElementById('title_realisasi').innerHTML = "Realisasi Kode "+r.kdakun;
        document.getElementById('title_sisa').innerHTML = "Sisa Alokasi Kode "+r.kdakun;
        document.getElementById('nilai_dipa').innerHTML = "Rp. "+r.pagu;
        document.getElementById('nilai_realisasi').innerHTML = "Rp. "+r.realisasi;
        document.getElementById('nilai_sisa').innerHTML = "Rp. "+r.sisa;
        document.getElementById("value").setAttribute("max",r.sisa);
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
         }else if(data.error == 6){
          alert('Sudah terdapat kode akun 524119 sebanyak 4 akun');
         };
        } else {
          if(kdAkun=="524119"){
            // $('#tbl_rute').append('<br>'
            //       +'  <a class="form-control btn btn-primary btn-sm" onclick="tambahRute()"><i class="fa fa-plus"></i> Tambah Perincian</a>'
            //       );
            tambahRute();
            $('#bahan').empty();
            $('#nilai').empty();
          } else if(kdAkun == "521211"){
            $('#bahan').append('  <label>PPN (%)</label>'
              +'  <input style="margin:5px auto" type="text" class="form-control nomor" name="ppn" id="ppn" value="" placeholder="PPN" required />'
              );
            $('#nilai').empty();
            $('#nilai').append('<label>Jumlah</label>'
              +'  <input style="margin:5px auto" type="text" class="form-control uang" name="value" id="value" value="" placeholder="Jumlah" required />'
              );
            $('#perjalanan').empty();
            $('#tbl_rute').empty();
          } else {
            $('#bahan').empty();
            $('#nilai').empty();
            $('#nilai').append('<label>Jumlah</label>'
              +'  <input style="margin:5px auto" type="text" class="form-control uang" name="value" id="value" value="" placeholder="Jumlah" required />'
              );
            $('#perjalanan').empty();
            $('#tbl_rute').empty();
          }
          mask();
        }
      },
    });
  }

  function tambahRute(){
    $('#perjalanan').append( ''
          +'<div class="col-xs-12 well">'
          +'      <h3 class="box-title" style="margin-top:6px;">Perincian</h3>'
          +'        <input type="hidden" name="perjalanan" value="true">'
          +'        <table>'
          +'        <tr>'
          +'        <td>'
          +'        <label>Alat Transportasi</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <select style="margin:5px auto" class="form-control" id="alat_trans[]" name="alat_trans[]">'
          +'        <option value="darat">Darat</option>'
          +'        <option value="udara">Udara</option>'
          +'        <option value="laut">Laut</option>'
          +'        </select>'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Rute</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" placeholder="Rute">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Tiket</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control uang" id="harga_tiket[]" name="harga_tiket[]" placeholder="Harga Tiket">'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Kota Asal</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Kota Tujuan</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan">'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Taxi Asal</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control uang" id="taxi_asal[]" name="taxi_asal[]" placeholder="Jumlah Taxi Asal">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Taxi Tujuan</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control uang" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="Jumlah Taksi Tujuan">'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label> Tanggal Berangkat</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <div style="margin:5px auto" class="input-group">'
          +'            <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" placeholder="dd/mm/yyyy">'
          +'             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
          +'        </div>'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label> Tanggal Kembali</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <div class="input-group">'
          +'             <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" placeholder="dd/mm/yyyy">'
          +'             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
          +'        </div>'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Jumlah Hari</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control nomor" id="lama_hari[]" name="lama_hari[]" placeholder="0">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Uang Harian</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control uang" id="uang_harian[]" name="uang_harian[]" placeholder="Jumlah Uang per Hari">'
          +'        </td>'
          +'        </tr>'

          +'</div>' 
          );
    getdatepicker();
  }

    
  function simpan(){
    $( "#formAkun" ).submit();
  }

</script>
