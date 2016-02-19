<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data RAB
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i> 
        <b>
        <a href="<?php echo $url_rewrite?>content/rab"> Data RAB</a> 
        > 
        <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>"> Orang/Badan </a>
        >
        Tambah Orang / Badan 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tambah Orang / Badan</h3>
          </div>
          <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab_rinci/save_penerima">
            <div class="box-body">
              <input type="hidden" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
              <input type="hidden" id="adendum" name="adendum" value="<?php echo $status;?>" />
              <div class="form-group">
                <label>Jenis</label>
                <select onchange="cekJenis();" class="form-control" required id="jenis-akun" name="jenis-akun" onchange="cnpwp()">
                  <option>-- Pilih Jenis --</option>
                  <option value="0">Badan</option>
                  <option value="1">Orang</option>
                </select>
              </div>
              <div class="form-group form-rab">
                  <label>NPWP</label>
                  <input type="text" class="form-control" value="<?= $npwp ?>" id="npwp" name="npwp" placeholder="NPWP">
              </div>
              <div class="form-group form-rab">
                  <label>Nama Penerima</label>
                  <input type="text" class="form-control" required value="<?= $penerima ?>" id="penerima" name="penerima" placeholder="Nama Penerima">
              </div>
              <div class="form-group form-rab orang">
                  <label>Golongan</label>
                  <select class="form-control" id="golongan" name="golongan">
                    <option value="">-- Pilih --</option>
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                    <option value="4">IV</option>
                  </select>
              </div>
              <div class="form-group form-rab orang">
                  <label>PNS / Non PNS</label>
                  <select class="form-control" id="pns" name="pns">
                    <option>-- Pilih --</option>
                    <option value="1">PNS</option>
                    <option value="0">Non PNS</option>
                  </select>
              </div>
              <div class="form-group form-rab orang">
                   <label>Jabatan Dalam Tugas</label>
                   <input type="text"  class="form-control" value="<?= $jabatan ?>" id="jabatan" name="jabatan" placeholder="Jabatan Dalam Tugas">
              </div>
              <div class="form-group form-rab badan">
                <label>Besar Pajak</label>
                <input type="number" class="form-control" value="<?= $pajak ?>" id="pajak" name="pajak" placeholder="Besar Pajak">
            </div>
            </div>
            <div class="box-footer">
              <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">Cancel</button>
              <button type="submit" class="btn btn-flat btn-success">Simpan</button>
            </div>
            
            <input type="hidden" value="1" name="mode"/>
            <?php
            if ($id != "")
                 echo"<input type=\"hidden\"  name=\"kondisi\" value=\"edit\">";
            else
                 echo"<input type=\"hidden\"  name=\"kondisi\" value=\"tambah\">";

            echo"<input type=\"hidden\"  name=\"kode\" value=\"$id\">";
            ?>
         </form> 
         </div>        
      </div>
    </div>
  </section>
</div>

<script>
  $(function () {
    cekJenis();
    getnpwp();
  });

  function getnpwp(){
    var jenis = $('#jenis-akun').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getnpwp/"+jenis,
      data: { },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        var avai_npwp = obj.npwp;
        $( "#npwp" ).autocomplete({
          source: avai_npwp,
          select: function (event, ui) {
            // cnpwp(jenis);
            cnpwp(ui.item.value);
          },
        });
      },
    });
  }



  function cnpwp(npwp){
    var jenis = $('#jenis-akun').val();
    
      $.ajax({
        type: "POST",
        url: "<?php echo $url_rewrite;?>process/rab_rinci/getorang",
        data: { 'npwp':npwp,
                'jenis':jenis },
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if (obj != null) {
            if(jenis==1){
              var golongan = obj.golongan;
              $('#golongan').val(golongan);
              var pns = obj.pns;
              $('#pns').val(pns);
              var jabatan = obj.jabatan;
              $('#jabatan').val(jabatan);
            }else{
              var pajak = obj.pajak;
              $('#pajak').val(pajak);
            }
            var penerima = obj.penerima;
            $('#penerima').val(penerima);
          };
        }
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

  

  function showOrang(){
    $(".form-rab").show();
    $(".orang").show();
    $(".badan").hide();
  }

  function showBadan(){
    $(".form-rab").show();
    $(".orang").hide();
    $(".badan").show();
  }
  function hideAll(){
    $(".form-rab").hide();
  }
  function cekJenis(){
    var val = $("#jenis-akun").val();
    if(val==0){
      showBadan();
      getnpwp();
    } else if(val==1) {
      showOrang();
      getnpwp();
    } else{
      hideAll();
    }
  }
</script>