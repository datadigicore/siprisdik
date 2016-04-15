<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $getrab['rabview_id'];?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $getrab['rabview_id'];?>"> Orang/Badan </a>
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
          <?php include "view/include/alert.php"; ?>
            <table class="display table table-bordered table-striped" >
              <tr>
                <th colspan='3'><label>Info Kegiatan</label></th>
              </tr>
              <tr>
                <td valign="top" class="col-md-1">
                  <table class="table-striped col-md-12">
                      <tr><td valign="top">Tahun</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->THANG?></td></tr>
                      <tr><td valign="top">Kegiatan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMGIAT?></td></tr>
                      <tr><td valign="top">Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMOUTPUT?></td></tr>
                      <tr><td valign="top">Sub Output</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMSOUTPUT?></td></tr>
                      <tr><td valign="top">Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NMKMPNEN?></td></tr>
                      <tr><td valign="top">Sub Komponen</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $datarkakl[0]->NmSkmpnen?></td></tr>
                  </table>
                </td>
                <td class="col-md-1">
                  <table class="table-striped col-md-12">
                      <tr><td valign="top">Uraian Acara</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $view['deskripsi']; ?></td></tr>
                      <tr><td valign="top">Tanggal</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo date("d M Y",strtotime($view['tanggal'])).' - '.date("d M Y",strtotime($view['tanggal_akhir'])); ?></td></tr>
                      <tr><td valign="top">Lokasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $view['tempat'].', '.$view['lokasi']; ?></td></tr>
                      <tr><td valign="top">Alokasi Anggaran</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['jumlah'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Jumlah Realisasi</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['realisasi'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Jumlah Usulan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format($jumlah['usulan'],2,',','.'); ?></td></tr>
                      <tr><td valign="top">Sisa</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo 'Rp '.number_format(($jumlah['jumlah'] - ($jumlah['realisasi'] + $jumlah['usulan'])),2,',','.'); ?></td></tr>
                  </table>
                </td>
                <td valign="top" class="col-md-1">
                  <table class="table-striped col-md-12">
                    <tr><td valign="top">NPWP</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-npwp"></div></td></tr>
                    <tr><td valign="top">Nama</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $getrab['penerima'];?></td></tr>
                    <tr><td valign="top">NIP</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-nip"></div></td></tr>
                    <tr><td valign="top">Status PNS</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-pns"></div></td></tr>
                    <tr><td valign="top">Golongan</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-gol"></div></td></tr>
                    <tr><td valign="top">Jabatan</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-jbt"></div></td></tr>
                    <tr><td valign="top">Besar Pajak (PPh)</td><td valign="top">:&nbsp;</td><td valign="top"><div id="info-pajak"></div></td></tr>
                  </table>
                </td>
            </table>
            <br>
            <input type="hidden" id="id_rabfull" name="id_rabfull" value="<?php echo $id_rabfull?>" />
            <?php if($_SESSION['level'] != 0){ ?>
            <?php if($getrab['status'] == 0 || $getrab['status'] == 3 || $getrab['status'] == 5){ ?>
            <div class="col-md-12">
              <a style="" id="add-more-akun" href="#" class="btn btn-flat btn-success btn-lg"><i class="fa fa-plus"></i> Tambah Transaksi</a>
            </div>
            <?php }?>
            <?php }?>
            <div class="well col-md-6" id="div-tambah-akun" style="display:none"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kdakun" onchange="chakun()" required />
              </select>

              <div id="div-item" style="display:none">
                <label>No Item</label>
                <select style="margin:5px auto" class="form-control" id="noitem" name="noitem" onchange="tambahinfopagu()" />
                </select>
              </div>

              <div id="bahan">
              </div>

              <div id="tbl_rute">  
              </div>

              <div id="nilai">
              </div>
            </div>
            <div class="col-md-6" id="div-info" style="display:none">
              <table class="display table table-bordered table-striped" >
                <tr>
                  <th class="col-md-1"><label>Info Akun</label></th>
                </tr>
                <tr>
                  <td id="info-pagu">
                  </td>
              </table>
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
                <th>Keterangan</th>
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

    ceknama();
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
      $("#div-info").show();
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
    $("#kode-akun").empty();
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
    
    if (kdAkun == "521211") {
      $('#item-hide').remove();
      $('#div-item').show();
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
    }else{
      $('#item-hide').remove();
      $('#div-tambah-akun').append('<input type="hidden" id="item-hide" name="noitem" value="1" />');
      $('#div-item').hide();
    };


    var noitem = $('#noitem').val();
    if (kdAkun == '521211' && noitem == null) {
      $('#info-pagu').empty();
      $('#info-pagu').append('<h4>Pilih No Item Terlebih Dahulu</h4>');
    }else{
      tambahinfopagu();
    };  

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

  function tambahinfopagu(){
    var id_rabfull = $('#id_rabfull').val();
    var kdAkun = $('#kode-akun').val();
    var noitem = $('#noitem').val();
    $.ajax({
        method: "POST",
        url: "<?=$url_rewrite?>process/rab_rinci/hitung_pagu",
        data: { 'id_rabfull': id_rabfull,
                'kdAkun'    : kdAkun,
                'noitem'    : noitem },
        dataType: "json"
      })
      .done(function( r ) {
          $('#info-pagu').empty();
          $('#info-pagu').append(''
                      +'<table>'
                      +'  <tr>'
                      +'      <td valign="top"><h4>Alokasi</h4></td>'
                      +'      <td valign="top"><h4>&nbsp;:&nbsp;</h4></td>'
                      +'      <td valign="top"><h4>Rp. '+r.pagu+'</h4></td>'
                      +'    </tr>'
                      +'  <tr>'
                      +'      <td valign="top"><h4>Realisasi</h4></td>'
                      +'      <td valign="top"><h4>&nbsp;:&nbsp;</h4></td>'
                      +'      <td valign="top"><h4>Rp. '+r.realisasi+'</h4></td>'
                      +'    </tr>'
                      +'  <tr>'
                      +'  <tr>'
                      +'      <td valign="top"><h4>Usulan</h4></td>'
                      +'      <td valign="top"><h4>&nbsp;:&nbsp;</h4></td>'
                      +'      <td valign="top"><h4>Rp. '+r.usulan+'</h4></td>'
                      +'    </tr>'
                      +'  <tr>'
                      +'      <td valign="top"><h4>Sisa Alokasi</h4></td>'
                      +'      <td valign="top"><h4>&nbsp;:&nbsp;</h4></td>'
                      +'      <td valign="top"><h4>Rp. '+r.sisa+'<h4></td>'
                      +'    </tr>'
                      +'</table>'
                      );
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
          +'        <option value="">-- Pilih Alat Transportasi--</option>'
          +'        <option value="Udara">Udara</option>'
          +'        <option value="Laut">Laut</option>'
          +'        <option value="Darat">Darat</option>'
          +'        </select>'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Kota Asal</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" onchange="inputrute(this.id,this.value)" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Kota Tujuan</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" onchange="inputrute(this.id,this.value)" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan">'
          +'        </td>'
          +'        </tr>'

          +'        <tr>'
          +'        <td>'
          +'        <label>Rute</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input readonly style="margin:5px auto" type="text" class="form-control" id="rute" name="rute[]" placeholder="Rute">'
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
          +'            <input type="text" class="form-control tanggal" onchange="cektanggal()" data-date-format="dd/mm/yyyy" id="tgl_mulai" name="tgl_mulai[]" placeholder="dd/mm/yyyy">'
          +'             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>'
          +'        </div>'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label> Tanggal Kembali</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <div class="input-group">'
          +'             <input type="text" class="form-control tanggal" onchange="cektanggal()" data-date-format="dd/mm/yyyy" id="tgl_akhir" name="tgl_akhir[]" placeholder="dd/mm/yyyy">'
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

          +'        <tr>'
          +'        <td>'
          +'        <label>Biaya Akomodasi</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control uang" id="biaya_akom[]" name="biaya_akom[]" placeholder="0">'
          +'        </td>'
          +'        </tr>'

          +'</div>' 
          );
    getdatepicker();
  }

  function inputrute(id,val){
    if (id == "kota_asal[]") {
      $('#rute').val(val);
    }else{
      var asal = $('#rute').val();
      $('#rute').val(asal+' - '+val);
    };
  }


  function cektanggal(){
    var tanggal = $('#tgl_mulai').val();
    var tanggal_akhir = $('#tgl_akhir').val();
    var pecah_awal = tanggal.split("/"); 
    var pecah_akhir = tanggal_akhir.split("/"); 
    var parsed_awal = new Date(pecah_awal[2],pecah_awal[1],pecah_awal[0]); 
    var parsed_akhir = new Date(pecah_akhir[2],pecah_akhir[1],pecah_akhir[0]); 
    if (parsed_akhir < parsed_awal) {
      $('#tgl_akhir').val('');
      alert("Tanggal Kembali Kurang Dari Tanggal Berangkat");
    };
  }

    
  function simpan(){
    $( "#formAkun" ).submit();
  }

  function ceknama(){
    $('#info-npwp').empty();
    $('#info-nip').empty();
    $('#info-pns').empty();
    $('#info-gol').empty();
    $('#info-jbt').empty();
    $('#info-pajak').empty();

    var npwp = "<?php echo $getrab['npwp'];?>";
    var nip = "<?php echo $getrab['nip'];?>";
    var pns = "<?php echo $getrab['pns'];?>";
    var gol = "<?php echo $getrab['golongan'];?>";
    var jbt = "<?php echo $getrab['jabatan'];?>";
    var pajak = "<?php echo $getrab['pajak'];?>";
    var jenis = "<?php echo $getrab['jenis'];?>";

    if(npwp!=""){
      $('#info-npwp').append(npwp);
    }else {
      $('#info-npwp').append('N/A');
    };
    $('#info-nip').append(nip);
    if (pns==1) {
      $('#info-pns').append('PNS');
    }else{
      $('#info-pns').append('Non PNS');
    };
    if (gol==1) {
      $('#info-gol').append('I');
    }else if (gol==2) {
      $('#info-gol').append('II');
    }else if (gol==3) {
      $('#info-gol').append('III');
    }else if (gol==4) {
      $('#info-gol').append('IV');
    }else {
      $('#info-gol').append('N/A');
    };
    $('#info-jbt').append(jbt);
    $('#info-pajak').append(pajak+' %');
    
  }

</script>
