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
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Rencana Anggaran Biaya</h3>
            <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          </div>
          <div class="box-body">
            <?php if (isset($_POST['message'])): ?>
              <div class="alert alert-<?php echo $_POST['alert']; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning"></i><?php echo $_POST['message']; ?>
              </div>
            <?php endif ?>
            <table class="display table table-bordered table-striped" style="width:750px">
              <tr>
                <td class="col-md-1"><label>Tahun</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->THANG?></label></td>
              </tr>
              <tr>
                <td><label>Kegiatan</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->NMGIAT?></label></td>
              </tr>
              <tr>
                <td><label>Output</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->NMOUTPUT?></label></td>
              </tr>
              <tr>
                <td><label>Sub Output</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->NMSOUTPUT?></label></td>
              </tr>
              <tr>
                <td><label>Komponen</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->NMKMPNEN?></label></td>
              </tr>
              <tr>
                <td><label>Sub Komponen</label></td>
                <td class="col-md-2"><label><?php echo $datarkakl[0]->NmSkmpnen?></label></td>
              </tr>
            </table>
            <table class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Penerima</th>
                  <th>Kode Akun</th>
                  <th>Total Dana RAB</th>
                  <th>error</th>
                </tr>
              </thead>
              <tbody>
              <?php for ($i=0; $i < count($insert); $i++) { ?>
                  <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $insert[$i]->penerima ?></td>
                    <td><?php echo $insert[$i]->kdakun ?></td>
                    <td><?php echo 'Rp '.number_format($insert[$i]->value, 2) ?></td>
                    <td><?php echo $insert[$i]->error ?></td>
                  </tr>
              <?php }?>
              </tbody>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
