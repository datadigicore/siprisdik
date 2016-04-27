<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Pengguna
      <small>Management Control</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-group"></i> Data Pengguna</li>
      <li><i class="fa fa-user"></i> Tambah Pengguna</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tambah Pengguna</h3>
          </div>
          <form method="POST" action="<?php echo $url_rewrite;?>process/user/add">
            <div class="box-body">
              <?php include "view/include/alert.php" ?>
              <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" data-toggle="tooltip" data-placement="top" title="Nama Lengkap" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" data-toggle="tooltip" data-placement="top" title="Email" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" data-toggle="tooltip" data-placement="top" title="Username" autocomplete="off" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" data-toggle="tooltip" data-placement="top" title="Password" autocomplete="off" required>
              </div>
              <div class="form-group">
                <select class="form-control" name="level" data-toggle="tooltip" data-placement="top" title="Kewenangan" required>
                  <option value="" disabled selected>-- Pilih Kewenangan --</option>
                  <!-- <option value="1">Operator Bendahara Pengeluaran</option> -->
                  <option value="2">Bendahara Pengeluaran Pembantu</option>
                  <option value="3">Operator Bendahara Pengeluaran Pembantu</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="kode" data-toggle="tooltip" data-placement="top" title="Group" id="group-select" required>
                  <option value="" disabled selected>-- Pilih Grup --</option>
                  <?php foreach ($group as $key => $value){ ?>
                  <option value="<?php echo $key ?>"><?php echo $key." - ".$value ?></option>
                     

                   <?php } ?>
                </select>
              </div>
              <!-- <div class="form-group">
                <select class="form-control" name="kdprogram" id="kdprogram" class="kdprogram" data-toggle="tooltip" data-placement="top" title="Kode Program" required>
                  <option value="" disabled selected>-- Pilih Kode Program --</option>
                  <?php foreach ($kdprog as $value){ ?>
                  <option value="<?php echo $value ?>"><?php echo $value ?></option>
                     

                   <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="direktorat" id="kdgiat" class="kdgiat" data-toggle="tooltip" data-placement="top" title="Direktorat" required>
                  <option value="" disabled selected >-- Pilih Direktorat --</option>
                </select>
              </div> -->
              <!-- <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Direktorat">

                <div class="row text-center">
                  <label>Kode Program</label>
                </div>
                <div class="row text-center">
                  <?php foreach ($kdprog as $value){ ?>
                     <div class=" col-md-4 ">
                      <div class="checkbox">
                        <label><input type="checkbox" value="<?php echo $value ?>" name="kdprogram[]" class="kdprog" data-toggle="toggle"> <?php echo $value ?></label>
                      </div>
                    </div>

                   <?php } ?>
                   
                    
                </div>
              </div>  -->
              <!-- <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Direktorat">

                <div class="row text-center">
                  <label>Direktorat</label>
                </div>
                <div class="row text-center" id="kdgiat-div">
                  
                   
                    
                </div>
              </div>
              <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Output">

                <div class="row text-center">
                  <label>Kode Output</label>
                </div>
                <div class="row text-center" id="kdoutput-div">
                  
                   
                    
                </div>
              </div> -->
             <!--  <div class="form-group">
                <select class="form-control" name="direktorat" required>
                  <option value="" disabled selected>-- Pilih Direktorat --</option>
                  <option value="5696">5696</option>
                  <option value="5697">5697</option>
                  <option value="5698">5698</option>
                  <option value="5699">5699</option>
                  <option value="5700">5700</option>
                </select>
              </div> -->
              <div class="form-group">
                <select class="form-control" name="status" data-toggle="tooltip" data-placement="top" title="Status Akun" required>
                  <option value="" disabled selected>-- Pilih Status Akun --</option>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right">Submit</button>
            </div>
          </form>
        </div>        
      </div>
    </div>
  </section>
</div>
<script>
  $(function () {
    $(document).on('ifChanged','.kdprog', function(){
      chDirektorat();
    });

    $(document).on('ifChanged','.kdgiat', function(){
      chOutput();
    });

    // $(document).on('change','#kdprogram',chDirektorat);
    // $(document).on('change','#kdgiat',chOutput);
  });

  // function chDirektorat(){
  //   var values=[];
  //   $.each($('input:checkbox.kdprog:checked'), function() {
  //     values.push($(this).val());
  //     // or you can do something to the actual checked checkboxes by working directly with  'this'
  //     // something like $(this).hide() (only something useful, probably) :P
  //   });
  //   //alert(values);
  //   if(values.length!=0){
  //     $.ajax({
  //       type: "POST",
  //       url: "<?php echo $url_rewrite;?>process/rab/getDirektorat",
  //       data: { 'prog' : values
  //             },
  //       success: function(data){
  //         // alert(JSON.stringify(jQuery.parseJSON(data)));
  //         var obj = jQuery.parseJSON(data);
  //         // $ckbx = '<option value="" disabled selected id="kdgiat-div">-- Pilih Direktorat --</option>';
  //         var ckbx = '';
  //         for (var i = 0; i < obj.KDGIAT.length; i++) {
  //           // $ckbx = $ckbx + '<option value="'+obj.KDGIAT[i]+'" id="kdgiat-div">'+obj.KDGIAT[i]+' - '+obj.NMGIAT[i]+'</option>';
  //           ckbx= ckbx+' <div class=" col-md-4 ">'+
  //                     '<div class="checkbox">'+
  //                       '<label><input type="checkbox" class="kdgiat" name="direktorat[]" value="'+obj.KDGIAT[i]+'"> '+obj.KDGIAT[i]+' - '+obj.NMGIAT[i]+'</label>'+
  //                     '</div>'+
  //                   '</div>';
  //         };
  //         $('#kdgiat-div').html(ckbx);
  //         $('.kdgiat').iCheck({
  //            checkboxClass: 'icheckbox_square-blue'
  //         });
  //       }
  //     });
      
  //   } else {
  //     $('#kdgiat').html('<option value="" disabled selected id="kdgiat-div">-- Pilih Direktorat --</option>');
  //   }
    
  // }

  // function chOutput(){
  //   var values=[];
  //   var values2=[];
  //   $.each($('input:checkbox.kdprog:checked'), function() {
  //     values.push($(this).val());
  //     // or you can do something to the actual checked checkboxes by working directly with  'this'
  //     // something like $(this).hide() (only something useful, probably) :P
  //   });
  //   $.each($('input:checkbox.kdgiat:checked'), function() {
  //     values2.push($(this).val());
  //     // or you can do something to the actual checked checkboxes by working directly with  'this'
  //     // something like $(this).hide() (only something useful, probably) :P
  //   });
  //   // alert(values2);
  //   if(values.length!=0 && values2.length!=0){
  //     $.ajax({
  //       type: "POST",
  //       url: "<?php echo $url_rewrite;?>process/rab/getout2",
  //       data: { 'prog' : values,
  //               'direktorat' :values2
  //             },
  //       success: function(data){
  //         // alert(JSON.stringify(jQuery.parseJSON(data)));
  //         var obj = jQuery.parseJSON(data);
  //         var ckbx = "";
  //         for (var i = 0; i < obj.KDOUTPUT.length; i++) {
  //           ckbx= ckbx+' <div class=" col-md-4 ">'+
  //                     '<div class="checkbox">'+
  //                       '<label><input type="checkbox" id="kdoutput" class="kdoutput" name="kdoutput[]" value="'+obj.KDPROGRAM[i]+','+obj.KDGIAT[i]+','+obj.KDOUTPUT[i]+'"> '+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+' ('+obj.KDGIAT[i]+')</label>'+
  //                     '</div>'+
  //                   '</div>';
  //         };
  //         $('#kdoutput-div').html(ckbx);
  //         $('.kdoutput').iCheck({
  //            checkboxClass: 'icheckbox_square-blue'
  //         });
  //       }
  //     });
      
  //   } else {
  //     $('#kdoutput-div').html("");
  //   }
    
  // }
</script>