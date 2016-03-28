<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rabakun/<?php echo $getrab['id'];?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Detail 
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> 
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $getrab['rabview_id'];?>"> Orang/Badan </a>
        >
        <a href="<?php echo $url_rewrite?>content/rabakun/<?php echo $getrab['id'];?>"> Transaksi </a>
        >
        Detail </b>
      </li>
    </ol>
  </section>
  <section class="content">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
        </div>
        <div class="box-body" >
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
            <div class="well col-md-6" id="div-tambah-akun"> 
              <label>Kode Akun</label>
              <select style="margin:5px auto" class="form-control" id="kode-akun" name="kdakun" readonly />
              <option><?php echo $datarkakl[0]->KDAKUN.' - '.$datarkakl[0]->NMAKUN;?></option>
              </select>

              <label>No Item</label>
              <select style="margin:5px auto" class="form-control" id="noitem" name="noitem" readonly />
              <option><?php echo $datarkakl[0]->NOITEM.' - '.$datarkakl[0]->NMITEM;?></option>
              </select>

              <?php if($datarkakl[0]->KDAKUN == '521211'){?>
              <div id="bahan">
                <label>PPN (%)</label>
                <input style="margin:5px auto" type="text" class="form-control persen" name="ppn" id="ppn" value="<?php echo $getrab['ppn']?> %" placeholder="PPN" readonly />
              </div>
              <?php } ?>

              <?php if($datarkakl[0]->KDAKUN !== "524119"){?>
              <div id="nilai">
                <label>Jumlah</label>
                <input style="margin:5px auto" type="text" class="form-control" name="value" id="value" value="<?php echo number_format($getrab['value'],2);?>" readonly />
              </div>
              <?php }?>
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
              <?php if ($datarkakl[0]->KDAKUN == "524119") { ?>
              <div class="col-xs-12 well">
                <h3 class="box-title" style="margin-top:6px;">Perincian</h3>
                      <input type="hidden" name="perjalanan" value="true">
                      <table>
                      <tr>
                      <td>
                      <label>Alat Transportasi</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" placeholder="Alat Transportasi" value="<?php echo $getrab['alat_trans']?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Rute</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" placeholder="Rute" value="<?php echo $getrab['rute']?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Tiket</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control uang" id="tiket[]" name="tiket[]" placeholder="0.00"  value="<?php echo $getrab['harga_tiket']?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Kota Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal" value="<?php echo $getrab['kota_asal'];?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Kota Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan" value="<?php echo $getrab['kota_tujuan'];?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Taxi Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control uang" id="taxi_asal[]" name="taxi_asal[]" placeholder="0.00" value="<?php echo $getrab['taxi_asal'];?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Taxi Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control uang" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="0.00" value="<?php echo $getrab['taxi_tujuan'];?>" readonly>
                      </td>
                      </tr>
                      
                      <tr>
                      <td>
                      <label> Tanggal Berangkat</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <div style="margin:5px auto" class="input-group">
                          <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getrab['tgl_mulai']) );?>" readonly>
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label> Tanggal Kembali</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <div class="input-group">
                           <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getrab['tgl_akhir']) );?>"  readonly>
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
                      <input style="margin:5px auto" type="text" class="form-control nomor" id="lama_hari[]" name="lama_hari[]" placeholder="0" value="<?php echo $getrab['lama_hari'];?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Uang Harian</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control uang" id="uang_harian[]" name="uang_harian[]" placeholder="0.00" value="<?php echo $getrab['uang_harian'];?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Biaya Akomodasi</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control uang" id="biaya_akom[]" name="biaya_akom[]" placeholder="0" value="<?php echo $getrab['biaya_akom'];?>" readonly>
                      </td>
                      </tr>
                  </table>
              </div> 
              <?php }?>
            </div>

            <?php if($_SESSION['level'] != 0){?>
              <?php if($getrab['status'] == 0 || $getrab['status'] == 3 || $getrab['status'] == 5){ ?>
              <div id="tbl_edit" class="col-xs-12">
                <a href="<?php echo $url_rewrite.'content/rabakun/edit/'.$id_rabfull;?>" class="btn btn-flat btn-warning btn-lg col-xs-12"><i class="fa fa-pencil"></i> Edit Akun</a>
              </div>
              <?php }?>
            <?php }?>
        </div>
      </div>
    </div>
  </div>

  <!-- <div id="perjalanan" class="row">

  </div> -->
  
  <?php if($_SESSION['level'] != 0){?>
  <!-- <div id="tbl_edit" class="row">
    <div class="col-xs-12">
      <div class="box box-warning">
        <div class="box-footer">
          <a href="<?php echo $url_rewrite.'content/rabakun/edit/'.$id_rabfull;?>" class="btn btn-flat btn-warning btn-lg col-xs-12"><i class="fa fa-pencil"></i> Edit Akun</a>
        </div>
      </div>
    </div>
  </div> -->
  <?php }?>
  </section>
</div>

<script>
  $(function (){
    $('.tanggal').mask('00/00/0000');
    $('.uang').mask('000.000.000.000.000.000.000,00', {reverse: true});
    $('.nomor').mask('0000');
    ceknama();
    $("#div-info").show();
    tambahinfopagu();
  });  

  function tambahinfopagu(){
    var id_rabfull = "<?php echo $id_rabfull;?>";
    var kdAkun = "<?php echo $datarkakl[0]->KDAKUN;?>";
    var noitem = "<?php echo $datarkakl[0]->NOITEM;?>";
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
