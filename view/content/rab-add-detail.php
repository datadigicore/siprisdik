<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Detail 
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

            <div class="well" id="div-tambah-akun"> 
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
                <label>PPN</label>
                <input style="margin:5px auto" type="number" class="form-control" name="ppn" id="ppn" value="<?php echo $getrab->ppn?>" placeholder="PPN" readonly />
              </div>
              <?php } ?>

              <?php if($datarkakl[0]->KDAKUN !== "524119"){?>
              <div id="nilai">
                <label>Jumlah</label>
                <input style="margin:5px auto" type="text" class="form-control" name="value" id="value" value="<?php echo number_format($getrab->value,2);?>" readonly />
              </div>
              <?php }?>
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
                      <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" placeholder="Alat Transportasi" value="<?php echo $getjalan[$i]->alat_trans?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Rute</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" placeholder="Rute" value="<?php echo $getjalan[$i]->rute?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Tiket</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="tiket[]" name="tiket[]" placeholder="0.00"  value="<?php echo $getjalan[$i]->harga_tiket?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Kota Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" placeholder="Kota Asal" value="<?php echo $getjalan[$i]->kota_asal;?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Kota Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" placeholder="Kota Tujuan" value="<?php echo $getjalan[$i]->kota_tujuan;?>" readonly>
                      </td>
                      </tr>

                      <tr>
                      <td>
                      <label>Taxi Asal</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="taxi_asal[]" name="taxi_asal[]" placeholder="0.00" value="<?php echo $getjalan[$i]->taxi_asal;?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Taxi Tujuan</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="taxi_tujuan[]" name="taxi_tujuan[]" placeholder="0.00" value="<?php echo $getjalan[$i]->taxi_tujuan;?>" readonly>
                      </td>
                      </tr>
                      
                      <tr>
                      <td>
                      <label> Tanggal Berangkat</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <div style="margin:5px auto" class="input-group">
                          <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_mulai) );?>" readonly>
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
                           <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_akhir) );?>"  readonly>
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
                      <input style="margin:5px auto" type="text" class="form-control" id="lama_hari[]" name="lama_hari[]" placeholder="0" value="<?php echo $getjalan[$i]->lama_hari;?>" readonly>
                      </td>
                      <td>&nbsp;</td>
                      <td>
                      <label>Uang Harian</label>
                      </td>
                      <td>&nbsp;:&nbsp;</td>
                      <td>
                      <input style="margin:5px auto" type="text" class="form-control" id="uang_harian[]" name="uang_harian[]" placeholder="0.00" value="<?php echo $getjalan[$i]->uang_harian;?>" readonly>
                      </td>
                      </tr>
                  </table>
              </div> 
              <?php }?>
            </div>

            <?php if($_SESSION['level'] != 0){?>
              <?php if($getrab->status == 0 || $getrab->status == 3 || $getrab->status == 5){ ?>
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
