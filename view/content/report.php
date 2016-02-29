<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Cetak Laporan
      <small>Tahun Anggaran 2016</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-group"></i> Data Pengguna</li>
      <li><i class="fa fa-user"></i>Cetak Laporan Berbasis Dokumen</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs nav-justified">

            <li class="active"><a href="#tab_6" data-toggle="tab" aria-expanded="true">Surat Pertanggung Jawaban Belanja</a></li>
            <li><a href="#tab_5" data-toggle="tab" aria-expanded="true">Rincian Permintaan Pengeluaran</a></li>
            <li ><a href="#tab_7" data-toggle="tab" aria-expanded="true">Surat Perintah Pembayaran</a></li>
            <li ><a href="#tab_8" data-toggle="tab" aria-expanded="true">Realisasi Daya Serap Per kegiatan</a></li>
            
            
          </ul>
          <div class="tab-content" style="padding:5px 0 0 0;">
            <div class="tab-pane" id="tab_5">
              <form method="POST" action="<?php echo $url_rewrite;?>process/report/Rincian_Permintaan_Pengeluaran">
              <div class="box-body" style="padding-bottom:0;">
                <div class="form-group">
                  <div class="form-group">
                  <label>Direktorat</label>
                  <select style="margin:5px auto" class="form-control" id="direktorat" name="direktorat" onchange="" >
                      <?php if($_SESSION['direktorat'] =="5696" or $_SESSION['level'] == 0){ ?>
                          <option value="5696">5696-Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5697" or $_SESSION['level'] == 0){ ?>
                          <option value="5697">5697-Pengembangan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5698" or $_SESSION['level'] == 0){ ?>
                          <option value="5698">5698-Pembinaan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5699" or $_SESSION['level'] == 0){ ?>
                            <option value="5699">5699-Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5700" or $_SESSION['level'] == 0){ ?>
                            <option value="5700">5700-Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya</option>
                      <?php } ?>
                  </select>
                </div>
                  <label>Pilih Kode MAK</label>
                  <select style="margin:5px auto" class="form-control" id="kode-mak" name="kode-mak" onchange="" >
                      <option value="51" >51 Belanja Pegawai</option>
                      <option value="52" >52 Belanja Barang</option>
                      <option value="53" >53 Belanja Modal</option>
                  </select>
                  <div class="form-group">
                  <label>Bulan</label>
                    <select style="margin:5px auto" class="form-control" id="bulan" name="bulan" onchange="" >
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
              </div>        
              </form>
            </div>
            <div class="tab-pane  active" id="tab_6">
              <form method="POST" action="<?php echo $url_rewrite;?>process/report/SPTB">
              <div class="box-body" style="padding-bottom:0;">
                <div class="form-group">
                  <label>Direktorat</label>
                  <select style="margin:5px auto" class="form-control" id="direktorat" name="direktorat" onchange="" >
                      <?php if($_SESSION['direktorat'] =="5696" or $_SESSION['level'] == 0){ ?>
                          <option value="5696">5696-Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5697" or $_SESSION['level'] == 0){ ?>
                          <option value="5697">5697-Pengembangan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5698" or $_SESSION['level'] == 0){ ?>
                          <option value="5698">5698-Pembinaan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5699" or $_SESSION['level'] == 0){ ?>
                            <option value="5699">5699-Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5700" or $_SESSION['level'] == 0){ ?>
                            <option value="5700">5700-Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya</option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Bulan</label>
                    <select style="margin:5px auto" class="form-control" id="bulan" name="bulan" onchange="" >
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group">
                  <label>Kode Akun</label>
                  <select style="margin:5px auto" class="form-control" id="kode-akun" name="kode-akun" onchange="" >
                                          
                  </select>
                </div>
              </div>
              <!-- <div class="box-body">
                      <label class="col-sm-3 control-label">Format laporan</label>
                      <div class="col-sm-4">
                        <select name="format" id="format" class="form-control">
                          <option value="pdf">PDF</option>
                          <option value="word">Word</option>
                        </select>
                      </div>
                    </div> -->
              <div class="box-footer">
                <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
              </div>        
              </form>
            </div>
            <div class="tab-pane" id="tab_7">
              <form method="POST" action="<?php echo $url_rewrite;?>process/report/SPP">
              <div class="box-body" style="padding-bottom:0;">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="text" name="tanggal" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tanggal" placeholder="dd/mm/yyyy">
                </div>
                <div class="form-group">
                  <label>Nomor</label>
                  <input type="text" name="nomor" class="form-control" id="nomor" placeholder="Nomor">
                </div>
                 <div class="form-group">
                  <label>Direktorat</label>
                  <select style="margin:5px auto" class="form-control" id="direktorat" name="direktorat" onchange="" >
                      <?php if($_SESSION['direktorat'] =="5696" or $_SESSION['level'] == 0){ ?>
                          <option value="5696">5696-Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5697" or $_SESSION['level'] == 0){ ?>
                          <option value="5697">5697-Pengembangan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5698" or $_SESSION['level'] == 0){ ?>
                          <option value="5698">5698-Pembinaan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5699" or $_SESSION['level'] == 0){ ?>
                            <option value="5699">5699-Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5700" or $_SESSION['level'] == 0){ ?>
                            <option value="5700">5700-Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya</option>
                      <?php } ?>
                  </select>
                </div>
                <label>Pilih Kode MAK</label>
                  <select style="margin:5px auto" class="form-control" id="kode-mak" name="kode-mak" onchange="" >
                      <option value="51" >51 Belanja Pegawai</option>
                      <option value="52" >52 Belanja Barang</option>
                      <option value="53" >53 Belanja Modal</option>
                  </select>
                <div class="form-group">
                  <label>Bulan</label>
                    <select style="margin:5px auto" class="form-control" id="bulan" name="bulan" onchange="" >
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                </div>               
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
              </div>        
              </form>
            </div>
            <div class="tab-pane" id="tab_8">
              <form method="POST" action="<?php echo $url_rewrite;?>process/report/Daya_Serap">
              <div class="box-body" style="padding-bottom:0;">
                 <div class="form-group">
                  <label>Direktorat</label>
                  <select style="margin:5px auto" class="form-control" id="direktorat" name="direktorat" onchange="" >
                      <?php if($_SESSION['direktorat'] =="5696" or $_SESSION['level'] == 0){ ?>
                          <option value="5696">5696-Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5697" or $_SESSION['level'] == 0){ ?>
                          <option value="5697">5697-Pengembangan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5698" or $_SESSION['level'] == 0){ ?>
                          <option value="5698">5698-Pembinaan Kelembagaan Perguruan Tinggi</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5699" or $_SESSION['level'] == 0){ ?>
                            <option value="5699">5699-Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan</option>
                      <?php } ?>
                      <?php if($_SESSION['direktorat'] =="5700" or $_SESSION['level'] == 0){ ?>
                            <option value="5700">5700-Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya</option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Bulan</label>
                    <select style="margin:5px auto" class="form-control" id="bulan" name="bulan" onchange="" >
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                </div>               
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-flat btn-success pull-right">Cetak</button>
              </div>        
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    kodeAkun("kode-akun");
    $("#add-more-akun").click(function(){
      $("#div-tambah-akun").show();
    });
    $("#buat-akun").click(function(){
      var val = $("#kode-akun").val();
      //$("#"+val).show();
      generateForm(val);
      $("#kode-akun").val('');
      $("#kode-akun option[value='"+val+"']").hide();
    });
    $(document).on("click",".btn-dismiss",function(){
      var val = $(this).attr("value");
      //alert(val);
      $("#"+val).remove();
      $("#kode-akun option[value='"+val+"']").show();
    });
    getdatepicker();
  });

  function getdatepicker(){
    $(".tanggal").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });
  }


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
          url: "<?php echo $url_rewrite?>/ajax/show_item.php",
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
        url: "<?=$url_rewrite?>ajax/select_akun_SPTB.php",
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
  $(function () {
    $('#table').DataTable({
      "scrollX": true
    });
  });
</script>