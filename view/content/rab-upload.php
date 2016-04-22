<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>"> Orang/Badan </a>
        >
        Upload Orang / Badan 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab_rinci/save_dataimport">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          </div>
          <div class="box-body">
            <?php //echo "<pre>";print_r($insert);die; 
            include "view/include/alert.php" ?>
            <table class="display table table-bordered table-striped">
              <tr>
                <th colspan='2'><label>Info</label></th>
                <th><label>Keterangan Tabel</label></th>
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
                <td valign="top" class="col-md-1">
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
                      <tr><td valign="top"><span class="label label-success">Hijau</span></td><td valign="top">&nbsp;</td><td valign="top">Jumlah Usulan Telah Valid</td></tr>
                      <tr><td valign="top"><span class="label label-warning">Kuning</span></td><td valign="top">&nbsp;</td><td valign="top">Jumlah Usulan Melebihi PAGU</td></tr>
                      <tr><td valign="top"><span class="label label-danger">Merah</span></td><td valign="top">&nbsp;</td><td valign="top">Tidak Terdapat Kode Akun dalam Kegiatan Tersebut</td></tr>
                  </table>
                </td>
            </table>
            <br>
            <table id="example" class="display table table-striped table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th></th>
                      <th>Penerima</th>
                      <?php for ($i=0; $i < $banyak_akun; $i++) { 
                        echo "<th>Kode Akun ".(1+$i)."</th>";
                      }?>
                  </tr>
              </thead>
              <tbody>
                <?php $pns = array('Non PNS', 'PNS'); $gol = array('-','I','II','III','IV');
                for ($i=0; $i < count($insert); $i++) { ?>
                <tr>
                  <td><?php echo 1+$i;?></td>
                  <td>
                    <table class="">
                      <tr><td valign="top">Penerima</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->penerima?></td></tr>
                      <tr><td valign="top">Penerima</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->asal?></td></tr>
                      <tr><td valign="top">NPWP</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->npwp?></td></tr>
                      <tr><td valign="top">NIP</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->nip?></td></tr>
                      <tr><td valign="top">PNS</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $pns[$insert[$i]->pns]?></td></tr>
                      <tr><td valign="top">Golongan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $gol[$insert[$i]->golongan]?></td></tr>
                      <tr><td valign="top">Pajak</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->pajak?> %</td></tr>
                      <tr><td valign="top">Jabatan</td><td valign="top">:&nbsp;</td><td valign="top"><?php echo $insert[$i]->jabatan?></td></tr>
                    </table>
                  </td>
                  <?php 
                  $p_akun[$i]           = explode(", ", $insert[$i]->kdakun);
                  $p_item[$i]           = explode(", ", $insert[$i]->noitem);
                  $p_value[$i]          = explode(", ", $insert[$i]->value);
                  $p_alat_trans[$i]     = explode(", ", $insert[$i]->alat_trans);
                  $p_rute[$i]           = explode(", ", $insert[$i]->rute);
                  $p_harga_tiket[$i]    = explode(", ", $insert[$i]->harga_tiket);
                  $p_kota_asal[$i]      = explode(", ", $insert[$i]->kota_asal);
                  $p_kota_tujuan[$i]    = explode(", ", $insert[$i]->kota_tujuan);
                  $p_taxi_asal[$i]      = explode(", ", $insert[$i]->taxi_asal);
                  $p_taxi_tujuan[$i]    = explode(", ", $insert[$i]->taxi_tujuan);
                  $p_tgl_mulai[$i]      = explode(", ", $insert[$i]->tgl_mulai);
                  $p_tgl_akhir[$i]      = explode(", ", $insert[$i]->tgl_akhir);
                  $p_lama_hari[$i]      = explode(", ", $insert[$i]->lama_hari);
                  $p_uang_harian[$i]    = explode(", ", $insert[$i]->uang_harian);
                  $p_biaya_akom[$i]     = explode(", ", $insert[$i]->biaya_akom);
                  $p_tingkat_jalan[$i]  = explode(", ", $insert[$i]->tingkat_jalan);
                  $p_error[$i]          = explode(", ", $insert[$i]->error);
                  $p_keterangan[$i]     = explode(", ", $insert[$i]->keterangan);
                  // print_r($pecahakun);die;
                  for ($j=0; $j < $banyak_akun; $j++) { 
                    if ($p_error[$i][$j] == 0) {
                      $status_err = '<span class="label label-success">Jumlah Usulan Telah Valid</span>';
                    }elseif ($p_error[$i][$j] == 1) {
                      $status_err = '<span class="label label-warning">Jumlah Usulan Melebihi PAGU</span>';
                    }elseif ($p_error[$i][$j] == 2) {
                      $status_err = '<span class="label label-danger">Tidak Terdapat Kode Akun dalam Kegiatan Tersebut</span>';
                    }
                    if (strtoupper(substr($p_keterangan[$i][$j], 0, 10)) == "PERJALANAN") {
                      echo '<td>
                            <table class="">
                              <tr>
                                <td colspan="3">Biaya '.$p_keterangan[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Alat Transportasi</td>
                                <td>:</td>
                                <td>'.$p_alat_trans[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Rute</td>
                                <td>:</td>
                                <td>'.$p_rute[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Harga Tiket</td>
                                <td>:</td>
                                <td>'.number_format($p_harga_tiket[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Kota Asal</td>
                                <td>:</td>
                                <td>'.$p_kota_asal[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Kota Tujuan</td>
                                <td>:</td>
                                <td>'.$p_kota_tujuan[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Taxi Asal</td>
                                <td>:</td>
                                <td>'.number_format($p_taxi_asal[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Taxi Tujuan</td>
                                <td>:</td>
                                <td>'.number_format($p_taxi_tujuan[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Lama Hari</td>
                                <td>:</td>
                                <td>'.$p_lama_hari[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Uang Harian</td>
                                <td>:</td>
                                <td>'.number_format($p_uang_harian[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Tanggal Berangkat</td>
                                <td>:</td>
                                <td>'.date("d/m/Y", strtotime($p_tgl_mulai[$i][$j])).'</td>
                              </tr>
                              <tr>
                                <td>Tanggal Akhir</td>
                                <td>:</td>
                                <td>'.date("d/m/Y", strtotime($p_tgl_akhir[$i][$j])).'</td>
                              </tr>
                              <tr>
                                <td>Tingkat Perjalanan</td>
                                <td>:</td>
                                <td>'.$p_tingkat_jalan[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>'.$status_err.'</td>
                              </tr>
                              <tr>
                                <td>Total Nilai</td>
                                <td>:</td>
                                <td>'.number_format($p_value[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Pajak</td>
                                <td>:</td>
                                <td>'.number_format(($p_value[$i][$j] * $insert[$i]->pajak / 100),2,',','.').'</td>
                              </tr>
                            </table>
                          </td>';
                    }elseif ($p_keterangan[$i][$j] != "") {
                      echo '<td>
                            <table class="">
                              <tr>
                                <td colspan="3"> '.$p_keterangan[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Kode Akun</td>
                                <td>:</td>
                                <td>'.$p_akun[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>No Item</td>
                                <td>:</td>
                                <td>'.$p_item[$i][$j].'</td>
                              </tr>
                              <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>'.$status_err.'</td>
                              </tr>
                              <tr>
                                <td>Nilai</td>
                                <td>:</td>
                                <td>'.number_format($p_value[$i][$j],2,',','.').'</td>
                              </tr>
                              <tr>
                                <td>Pajak</td>
                                <td>:</td>
                                <td>'.number_format(($p_value[$i][$j] * $insert[$i]->pajak / 100),2,',','.').'</td>
                              </tr>
                            </table>
                            </td>';
                    }else{
                      // echo "<td></td>"; 
                    }
                  } ?>
                </tr>
                <?php }?>
              </tbody>
              <tfoot>
                  <tr>
                      <th></th>
                      <th>Penerima</th>
                      <?php for ($i=0; $i < $banyak_akun; $i++) { 
                        echo "<th>Kode Akun ".(1+$i)."</th>";
                      }?>
                  </tr>
              </tfoot>
          </table>
          </div>
          <?php if($stat_err == 0) { ?>
          <div class="box-footer" align="center">
            <button type="submit" class="btn btn-flat btn-lg btn-success"><i class="fa fa-save"></i> Simpan</button>
          </div>
          <?php } ?>
          </form>
        </div>        
      </div>
    </div>
  </section>
</div>
<script type="text/javascript">
  function format ( d ) {
    return '<div class="table-responsive col-md-6" style="padding:1px;">'+
      '<table class="table table-striped table-hover table-bordered tab-pad-0" cellpadding="5" cellspacing="0" border="0">'+
        '<tr>'+
          '<td>Honorarium</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Nilai</td>'+
          '<td>:</td>'+
          '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Pajak</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Status Dana</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>PAGU</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Realisasi</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Usulan Sebelum</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Usulan Sesudah</td>'+
          '<td>:</td>'+
          '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
      '</table>'+
      '</div>'+
      '<div class="table-responsive col-md-6" style="padding:1px;">'+
      '<table class="table table-striped table-hover table-bordered tab-pad-0" cellpadding="5" cellspacing="0" border="0">'+
        '<tr>'+
          '<td>Biaya Perjalanan Dinas</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Kota Asal</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Kota Tujuan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tingkat Perjalanan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Alat Transportasi</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Rute</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Taxi Asal</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Taxi Tujuan</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Dana Harian</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tanggal Berangkat</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Tanggal Akhir</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Total Nilai</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
          '<td>Pajak</td>'+
          '<td>:</td>'+
          '<td>'+d.name+'</td>'+
        '</tr>'+
      '</table>'+
    '</div>';
}
 
$(document).ready(function() {
    var table_data_json = '[{"name":"Tiger Nixon","position":"System Architect","salary":"$320,800","start_date":"2011/04/25","office":"Edinburgh","extn":"5421"},{"name":"Garrett Winters","position":"Accountant","salary":"$170,750","start_date":"2011/07/25","office":"Tokyo","extn":"8422"},{"name":"Ashton Cox","position":"Junior Technical Author","salary":"$86,000","start_date":"2009/01/12","office":"San Francisco","extn":"1562"}]';
      $('#example').DataTable( {
        // "data": JSON.parse(table_data_json),
        "columns": [
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            // { "data": "name" },
            // { "data": "position" },
            // { "data": "office" },
            // { "data": "salary" }
        ],
        "order": [[1, 'asc']]
    } );
    $("#example").DataTable().rows().every( function () {
        this.child(format(this.data())).show();
        this.nodes().to$().addClass('shown');
    });  
} );
</script>