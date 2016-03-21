<div class="content-wrapper">
  <section class="content-header">
    <a href="<?php echo $url_rewrite?>content/rabdetail/<?php echo $id_rab_view;?>" class="btn btn-app bg-navy"><i class="fa fa-arrow-left"></i>Kembali</a>
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
        Edit Orang / Badan 
        </b>
      </li>
    </ol>
  </section>
  <section class="content">
    <div class="row" id="formorang">
      <div class="col-md-6 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Edit Orang / Badan</h3>
          </div>
          <form enctype="multipart/form-data" method="post" action="<?php echo $url_rewrite;?>process/rab_rinci/save_edit_penerima">
            <div class="box-body">
              <input type="hidden" name="id_rab_view" value="<?php echo $id_rab_view ?>" />
              <input type="hidden" name="id_rab_full" value="<?php echo $id_rab_full ?>" />
              <div class="form-group">
                <label>Jenis</label>
                <select onchange="cekJenis();" class="form-control" required id="jenis-akun" name="jenis-akun" onchange="cnpwp()">
                  <option>-- Pilih Jenis --</option>
                  <option value="0">Badan</option>
                  <option value="1">Orang</option>
                </select>
              </div>
              <div class="form-group form-rab">
                  <label>Nama Penerima</label>
                  <input type="text" class="form-control" required value="<?= $penerima ?>" id="penerima" name="penerima" placeholder="Nama Penerima">
              </div>
              <div class="form-group form-rab">
                  <label>NPWP</label>
                  <input type="text" class="form-control" value="<?= $npwp ?>" id="npwp" name="npwp" placeholder="NPWP">
              </div>
              <div class="form-group form-rab orang">
                  <label>NIP</label>
                  <input type="text" class="form-control" value="<?= $nip ?>" id="nip" name="nip" placeholder="NIP">
              </div>
              <div class="form-group form-rab orang">
                  <label>PNS / Non PNS</label>
                  <select class="form-control" id="pns" name="pns" onchange="pilihpns()">
                    <option value="">-- Pilih --</option>
                    <option value="1">PNS</option>
                    <option value="0">Non PNS</option>
                  </select>
              </div>
              <div class="form-group form-rab orang">
                  <label>Golongan</label>
                  <select class="form-control" id="golongan" name="golongan" onchange="hitungpajak()">
                    <option value="">-- Pilih --</option>
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                    <option value="4">IV</option>
                  </select>
              </div>
              <div class="form-group form-rab orang">
                  <label>Jabatan Dalam Tugas</label>
                  <div id="div-jabatan">
                  </div>
              </div>
              <div class="form-group form-rab orang">
                <label>Besar Pajak</label>
                <input type="text" class="form-control" id="pajak-orang" readonly>
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
    $('#jenis-akun').val('<?= $getrab["jenis"] ?>');
    cekJenis();
    $('#penerima').val('<?= $getrab["penerima"] ?>');
    $('#npwp').val('<?= $getrab["npwp"] ?>');
    $('#nip').val('<?= $getrab["nip"] ?>');
    $('#pns').val('<?= $getrab["pns"] ?>');
    $('#golongan').val('<?= $getrab["golongan"] ?>');
    $('#jabatan').val('<?= $getrab["jabatan"] ?>');
    $('#pajak').val('<?= $getrab["pajak"] ?>');

    var jenis = $('#jenis-akun').val();
    var pns = $('#pns').val();
    var jabatan = '<?= $getrab["jabatan"] ?>';
    if (jenis == 1) {
      pilihpns();
      if (pns==0) {
        if (jabatan != "Tim" && jabatan != "Narasumber") {
          $('#jabatan').val("Lain");
          pilihJabatan();
          $('#jabatan-lain').val(jabatan);
        }else{
          $('#jabatan').val(jabatan);
        };
      }else{
        $('#jabatan').val(jabatan);
      };
      hitungpajak();
    };
    getnpwp();
    $(document).on("click", "#tambahorang", function (){
      tambahorang();
    });
  });

  function getnpwp(){
    var jenis = $('#jenis-akun').val();
    $.ajax({
      type: "POST",
      url: "<?php echo $url_rewrite;?>process/rab/getnpwp/"+jenis,
      data: { },
      success: function(data){
        var obj = jQuery.parseJSON(data);
        var avai_npwp = obj.penerima;
        $( "#penerima" ).autocomplete({
          source: avai_npwp,
          select: function (event, ui) {
            // cnpwp(jenis);
            cnpwp(ui.item.value);
          },
        });
      },
    });
  }

  function cnpwp(penerima){
    var jenis = $('#jenis-akun').val();

      $.ajax({
        type: "POST",
        url: "<?php echo $url_rewrite;?>process/rab_rinci/getorang",
        data: { 'penerima':penerima,
                'jenis':jenis },
        success: function(data){
          var obj = jQuery.parseJSON(data);
          if (obj != null) {
            var npwp = obj.npwp;
            $('#npwp').val(npwp);
            if(jenis==1){
              var nip = obj.nip;
              $('#nip').val(nip);
              var golongan = obj.golongan;
              $('#golongan').val(golongan);
              var pns = obj.pns;
              $('#pns').val(pns);
              pilihpns();
              var jabatan = obj.jabatan;
              if (pns==0) {
                if (jabatan != "Tim" && jabatan != "Narasumber") {
                  $('#jabatan').val("Lain");
                  pilihJabatan();
                  $('#jabatan-lain').val(jabatan);
                }else{
                  $('#jabatan').val(jabatan);
                };
              }else{
                $('#jabatan').val(jabatan);
              };
              hitungpajak();
            }else{
              var pajak = obj.pajak;
              $('#pajak').val(pajak);
            }
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
    $(".btn-pilih").hide();
    $('.lain').hide();
    $('.pns').hide();
    $('.nonpns').hide();
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

  function pilih(){
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

  function pilihpns(){
    var val = $("#pns").val();
    if (val==1) {
      $('#div-jabatan').empty();
      $('#div-jabatan').append(''
        +'<input type="text" class="form-control pns" id="jabatan" name="jabatan" placeholder="Jabatan Dalam Tugas">'
        );
    }else if(val==0){
      $('#div-jabatan').empty();
      $('#div-jabatan').append(''
        +'  <select class="form-control nonpns" id="jabatan" name="jabatan" onchange="pilihJabatan()">'
        +'      <option value="">-- Pilih --</option>'
        +'      <option value="Tim">Tim</option>'
        +'      <option value="Narasumber">Narasumber</option>'
        +'      <option value="Lain">Lainnya</option>'
        +'    </select>'
        +'    <input type="text" class="form-control nonpns lain" id="jabatan-lain" name="jabatan_lain" placeholder="Jabatan Dalam Tugas">'
      );
      $('.lain').hide();
      $('#golongan').val('');
    }else{
      $('#div-jabatan').empty();
    };
    hitungpajak();
  }

  function pilihJabatan(){
    var val = $("#jabatan").val();
    if (val=="Lain") {
      $('.lain').show();
    }else{
      $('.lain').hide();
    };
  }

  function hitungpajak(){
    var pns = $("#pns").val();
    var golongan = $("#golongan").val();
    if (pns == 1) {
      if (golongan == 4) {
        $('#pajak-orang').val('15 %');
      }else if (golongan == 3) {
        $('#pajak-orang').val('5 %');
      }else if (golongan == 2) {
        if (pns == 1) {
          $('#pajak-orang').val('0 %');
        }else{
          if ($npwp != "") {
            $('#pajak-orang').val('5 %');
          }else{
            $('#pajak-orang').val('6 %');
          }
        }
      }else{
        $('#pajak-orang').val('0 %');
      }
    }else if (pns == 0){
      $('#pajak-orang').val('6 %');
    }
  }

</script>