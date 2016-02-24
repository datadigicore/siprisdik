<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Edit 
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> 
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $getrab->rabview_id;?>"> Orang/Badan </a>
        >
        <a href="<?php echo $url_rewrite?>content/rabakun/<?php echo $getrab->id;?>"> Transaksi </a>
        >
        Edit </b>
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
  <?php if($_SESSION['level'] != 0){ ?>
  <form class="form-horizontal" role="form" id="formAkun" enctype="multipart/form-data" method="post" action="<?= $url_rewrite ?>process/rab_rinci/editAkun">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
        </div>
        <div class="box-body" >
            <input type="hidden" id="id_rabfull" name="id_rabfull" value="<?php echo $id_rabfull?>" />
            <div class="well" id="div-tambah-akun"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kdakun" onchange="chakun()" required />
              </select>

              <label>No Item</label>
              <select style="margin:5px auto" class="form-control" id="noitem" name="noitem" required />
              </select>

              <div id="bahan">
              <?php if($datarkakl[0]->KDAKUN == '521211') {?>
                <label>PPN</label>
                <input style="margin:5px auto" type="number" class="form-control" name="ppn" id="ppn" value="<?php echo $getrab->ppn?>" placeholder="PPN" />
              <?php }?>
              </div>

              <div id="tbl_rute">
              </div>

              <div id="nilai">
              <?php if($datarkakl[0]->KDAKUN !== "524119" ) {?>
                <label>Jumlah</label>
                <input style="margin:5px auto" type="number" class="form-control" name="value" id="value" value="<?php echo $getrab->value;?>" />
              <?php }?>
              </div>
            </div>
            <div id="perjalanan">
              <?php for ($i=0; $i < count($getjalan); $i++) {  ?>
              <div class="col-xs-12 well">
                <h3 class="box-title" style="margin-top:6px;">Perincian</h3>
                      <input type="hidden" name="perjalanan" value="true">
                      <table class="col-xs-12">
                      <tr>
                      <td>
                      <label>Alat Transportasi</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" placeholder="Alat Transportasi" value="<?php echo $getjalan[$i]->alat_trans?>">
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Rute</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" placeholder="Rute" value="<?php echo $getjalan[$i]->rute?>">
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Tiket</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="tiket[]" name="tiket[]" placeholder="0.00"  value="<?php echo $getjalan[$i]->harga_tiket?>">
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Kota Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal" value="<?php echo $getjalan[$i]->kota_asal;?>">
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Kota Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan" value="<?php echo $getjalan[$i]->kota_tujuan;?>">
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Taxi Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="taxi_asal[]" name="taxi_asal[]" placeholder="0.00" value="<?php echo $getjalan[$i]->taxi_asal;?>">
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Taxi Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="0.00" value="<?php echo $getjalan[$i]->taxi_tujuan;?>">
                      </td>
                      </tr>
                      
                      <tr>
                      <td>
                      <label> Tanggal Berangkat</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <div style="margin:5px auto" class="input-group">
                          <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_mulai) );?>">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label> Tanggal Kembali</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <div class="input-group">
                           <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_akhir) );?>" >
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Jumlah Hari</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="lama_hari[]" name="lama_hari[]" placeholder="0" value="<?php echo $getjalan[$i]->lama_hari;?>">
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Uang Harian</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="uang_harian[]" name="uang_harian[]" placeholder="0.00" value="<?php echo $getjalan[$i]->uang_harian;?>">
                      </td>
                      </tr>
                  </table>
              </div> 
              <?php }?>
            </div>

            <div id="tbl_save" class="col-xs-12">
              <button type="submit" onclick="simpan()" class="btn btn-flat btn-success btn-lg"><i class="fa fa-save"></i> Simpan Akun</a></button>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php }?>

  </form>

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
    kodeAkun("kode-akun");
    getdatepicker();
  });

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
      $("#kode-akun").val("<?php echo $getrab->kdakun;?>");
      chakun();
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
        $("#noitem").val("<?php echo $getrab->noitem;?>");
      });  

      if(kdAkun=="524119" ){
        // $('#tbl_rute').append('<br>'
        //       +'  <a class="form-control btn btn-primary btn-sm" onclick="tambahRute()"><i class="fa fa-plus"></i> Tambah Rute</a>'
        //       );
        if (isEmpty($('#perjalanan'))) {
          tambahRute();
        }
        $('#bahan').empty();
        $('#nilai').empty();
      } else if(kdAkun == "521211"){
        if (isEmpty($('#bahan'))) {
            $('#bahan').append('  <label>PPN</label>'
          +'  <input style="margin:5px auto" type="number" class="form-control" name="ppn" id="ppn" value="" placeholder="PPN" required />'
          );
        }
        if (isEmpty($('#nilai'))) {
          $('#nilai').append('<label>Jumlah</label>'
            +'  <input style="margin:5px auto" type="number" class="form-control" name="value" id="value" value="" placeholder="Jumlah" required />'
            );
        }
        $('#perjalanan').empty();
        $('#tbl_rute').empty();
      } else {
        $('#bahan').empty();
        if (isEmpty($('#nilai'))) {
          $('#nilai').append('<label>Jumlah</label>'
            +'  <input style="margin:5px auto" type="number" class="form-control" name="value" id="value" value="" placeholder="Jumlah" required />'
            );
        }
        $('#perjalanan').empty();
        $('#tbl_rute').empty();
      }
  }

  function isEmpty( el ){
      return !$.trim(el.html())
  }
  

  function tambahRute(){
    $('#perjalanan').append( ''
          +'<div class="col-xs-12 well">'
          +'      <h3 class="box-title" style="margin-top:6px;">Perincian</h3>'
          +'        <input type="hidden" name="perjalanan" value="true">'
          +'        <table class="col-xs-12">'
          +'        <tr>'
          +'        <td>'
          +'        <label>Alat Transportasi</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" placeholder="Alat Transportasi">'
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
          +'        <input style="margin:5px auto" type="text" class="form-control" id="tiket[]" name="tiket[]" placeholder="0.00">'
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
          +'        <input style="margin:5px auto" type="text" class="form-control" id="taxi_asal[]" name="taxi_asal[]" placeholder="0.00">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Taxi Tujuan</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="0.00">'
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
          +'        <input style="margin:5px auto" type="text" class="form-control" id="lama_hari[]" name="lama_hari[]" placeholder="0">'
          +'        </td>'
          +'        <td>&nbsp;</td>'
          +'        <td>'
          +'        <label>Uang Harian</label>'
          +'        </td>'
          +'        <td>&nbsp;:&nbsp;</td>'
          +'        <td>'
          +'        <input style="margin:5px auto" type="text" class="form-control" id="uang_harian[]" name="uang_harian[]" placeholder="0.00">'
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
