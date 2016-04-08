<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rab" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
    <h1>
      Data RAB
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        Orang/Badan </a>
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
            <?php if ($_SESSION['level'] != 0) {
              echo '<a id="tblAdd" data-toggle="modal" class="btn btn-flat btn-primary btn-md pull-right"><i class="fa fa-user"></i>&nbsp;Tambah Orang / Badan</a>';
            }?>
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php"; ?>
            <table class="display table table-bordered table-striped">
              <tr>
                <th colspan='2'><label>Info</label></th>
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
            </table>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>No</th>
                  <th>Penerima</th>
                  <th>Keterangan</th>
                  <th>Kode Akun</th>
                  <th>Total Dana RAB</th>
                  <th>Status</th>
                  <th></th>
                  <th>Pelaporan</th>
                  <?php if($_SESSION['level'] == 0 || $_SESSION['level'] == 2){?>
                  <th>Aksi</th>
                  <?php }?>
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

<div class="modal fade" id="sahkan">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab_rinci/sahkanAkun" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rabfull" name="id_rabfull" value="" />
          <input type="hidden" id="id_rab_view" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          <input type="hidden" id="status" name="status" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Ingin Melakukan Pengesahan ?</label>
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
<div class="modal fade" id="batal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/rab_rinci/batalAkun" method="POST">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Dialog Box</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_rabfull_batal" name="id_rabfull" value="" />
          <input type="hidden" id="id_rab_view_batal" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
          <input type="hidden" id="status_batal" name="status" value="" />
          <div class="form-group">
            <label>Apakah Anda Yakin Ingin Membatalkan Rincian ini ?</label>
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
  $(function () {
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    var table = $("#table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/rab_rinci/table/<?php echo $id_rab_view; ?>",
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

    

    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getnpwp",
      data: { },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        var avai_npwp = obj.npwp;
        $( "#npwp" ).autocomplete({
          source: avai_npwp
        });
      },
    });

    var id_rab_view = $('#id_rab_view').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab_rinci/cekAdendum",
      data: { 'id_rab_view': id_rab_view},
      success: function(data){
        var obj = jQuery.parseJSON(data);
        if (obj.status != 0 && obj.status != 3 && obj.status != 4) {
          $('#tblAdd').addClass('hidden');
        }else if(obj.status == 4){
          $('#tblAdd').html('Tambah Orang/Badan (Adendum)');
          $('#adendum').val('5');
          $('#tblAdd').attr('href','<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view?>/add/5');
        }else{
          $('#tblAdd').attr('href','<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view?>/add/0');
        };
      },
    });

    $(document).on("click", "#btn-sah", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rabfull").val(tabrow.data()[0]);
      $("#status").val('4');
    });
    $(document).on("click", "#btn-sah-adn", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rabfull").val(tabrow.data()[0]);
      $("#status").val('6');
    });
    $(document).on("click", "#btn-batal", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rabfull_batal").val(tabrow.data()[0]);
      $("#status_batal").val('8');
    });
    $(document).on("click", "#btn-batal-adn", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#id_rabfull_batal").val(tabrow.data()[0]);
      $("#status_batal").val('9');
    });
  });

  function cnpwp(){
    var npwp = $('#npwp').val();
    var jenis = $('#jenis-akun').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab_rinci/getorang",
      data: { 'npwp':npwp,
              'jenis':jenis },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        if (obj != null) {
          var penerima = obj.penerima;
          $('#penerima').val(penerima);
          var golongan = obj.golongan;
          $('#golongan').val(golongan);
          var pns = obj.pns;
          $('#pns').val(pns);
          var jabatan = obj.jabatan;
          $('#jabatan').val(jabatan);
        };
      },
    });
  }

  function search(){
    var tahun = $('#tahun').val();
    var direktorat = $('#direktorat').val();
    table.destroy();
    $('#table').DataTable({
      "scrollX": true,
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "getRab",
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tahun", "value": tahun },
                      { "name": "direktorat", "value": direktorat } );
      }
    });
  }
</script>