<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Detail 
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> Detail</li>
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

              <?php if($datarkakl[0]->KDAKUN !== "524119" && $datarkakl[0]->KDAKUN !== "524114"){?>
              <div id="nilai">
                <label>Value</label>
                <input style="margin:5px auto" type="number" class="form-control" name="value" id="value" value="<?php echo number_format($getrab->value);?>" readonly />
              </div>
              <?php }?>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div id="perjalanan" class="row">
    <?php for ($i=0; $i < count($getjalan); $i++) {  ?>
    <div class="col-xs-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title" style="margin-top:6px;">Rute</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
            <input type="hidden" name="perjalanan" value="true">
            <label>Rute</label>
            <input style="margin:5px auto" type="text" class="form-control" id="rute[]" name="rute[]" value="<?php echo $getjalan[$i]->rute;?>" readonly>

            <label>Value</label>
            <input style="margin:5px auto" type="text" class="form-control" id="value[]" name="value[]" value="<?php echo $getjalan[$i]->value;?>" readonly>
                
            <label> Tanggal Berangkat</label>
            <div style="margin:5px auto" class="input-group">
                <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_mulai[]" name="tgl_mulai[]" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_mulai) );?>" readonly>
                 <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
            <label> Tanggal Kembali</label>
            <div class="input-group">
                 <input type="text" class="form-control tanggal" data-date-format="dd/mm/yyyy" id="tgl_akhir[]" name="tgl_akhir[]" value="<?php echo date('d/m/Y', strtotime($getjalan[$i]->tgl_akhir) );?>" readonly>
                 <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>

            <label>Alat Transportasi</label>
            <input style="margin:5px auto" type="text" class="form-control" id="alat_trans[]" name="alat_trans[]" value="<?php echo $getjalan[$i]->alat_trans;?>" readonly>

            <label>Kota Asal</label>
            <input style="margin:5px auto" type="text" class="form-control" id="kota_asal[]" name="kota_asal[]" value="<?php echo $getjalan[$i]->kota_asal;?>" readonly>

            <label>Kota Tujuan</label>
            <input style="margin:5px auto" type="text" class="form-control" id="kota_tujuan[]" name="kota_tujuan[]" value="<?php echo $getjalan[$i]->kota_tujuan;?>" readonly>

            <label>Taxi Asal</label>
            <input style="margin:5px auto" type="text" class="form-control" id="taxi_asal[]" name="taxi_asal[]" value="<?php echo $getjalan[$i]->taxi_asal;?>" readonly>

            <label>Taxi Tujuan</label>
            <input style="margin:5px auto" type="text" class="form-control" id="taxi_tujuan[]" name="taxi_tujuan[]" value="<?php echo $getjalan[$i]->taxi_tujuan;?>" readonly>

        </div>
      </div>
    </div> 
    <?php }?>
  </div>
  
  <div id="tbl_edit" class="row">
    <div class="col-xs-12">
      <div class="box box-warning">
        <div class="box-footer">
          <a href="<?php echo $url_rewrite.'content/rabakun/edit/'.$id_rabfull;?>" class="btn btn-flat btn-warning btn-lg col-xs-12"><i class="fa fa-pencil"></i> Edit Akun</a>
        </div>
      </div>
    </div>
  </div>
  </section>
</div>
