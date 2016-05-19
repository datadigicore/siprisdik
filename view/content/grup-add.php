<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Grup
      <small>Management Control</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-group"></i> Data Pengguna</li>
      <li><i class="fa fa-user"></i> Tambah Grup</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" style="margin-top:6px;">Tambah Grup</h3>
          </div>
          <form method="POST" action="<?php echo $url_rewrite;?>process/user/add-group" id="group-form">
            <div class="box-body">
              <?php include "view/include/alert.php" ?>
              <div class="form-group">
                <input type="text" class="form-control" name="kode" placeholder="Kode Grup" data-toggle="tooltip" data-placement="top" title="Kode Grup" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Nama Grup" data-toggle="tooltip" data-placement="top" title="Nama Grup" required>
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
              <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Direktorat">

                <div class="row text-center" data-toggle="popover" data-placement="left" data-content="Isi Kode Program" id="row-kdprogram">
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
              </div> 
              <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Direktorat">

                <div class="row text-center" data-toggle="popover" data-placement="left" data-content="Isi Kode Direktorat" id="row-direktorat">
                  <label>Direktorat</label>
                </div>
                <div class="row text-center" id="kdgiat-div">
                  
                   
                    
                </div>
              </div>
              <div class="well" data-toggle="tooltip" data-placement="top" title="Kode Output">

                <div class="row text-center" data-toggle="popover" data-placement="left" data-content="Isi Kode Output" id="row-kdoutput">
                  <label>Kode Output</label>
                </div>
                <div class="row text-center" id="kdoutput-div">
                  
                   
                    
                </div>
              </div>
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
    $( "#group-form" ).validate({
      rules: {
        "kdoutput[]": { 
                      required: true, 
                      minlength: 1 
              },
        "direktorat[]": { 
                      required: true, 
                      minlength: 1 
              },
        "kdprogram[]": { 
                      required: true, 
                      minlength: 1 
              } 
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") == "direktorat[]" ) {
          $('#row-direktorat').popover('show');
          //error.insertAfter("#lastname");
        }else if (element.attr("name") == "kdprogram[]" ) {
          $('#row-kdprogram').popover('show');
          //error.insertAfter("#lastname");
        }else if (element.attr("name") == "kdoutput[]" ) {
          $('#row-kdoutput').popover('show');
          //error.insertAfter("#lastname");
        } else {
      error.insertAfter(element);
    }
      }
    });

    $(document).on('ifChanged','.kdprog', function(){
      chDirektorat();
    });

    $(document).on('ifChanged','.kdgiat', function(){
      chOutput();
    });

    // $(document).on('change','#kdprogram',chDirektorat);
    // $(document).on('change','#kdgiat',chOutput);
  });

  function chDirektorat(){
    var values=[];
    $.each($('input:checkbox.kdprog:checked'), function() {
      values.push($(this).val());
      // or you can do something to the actual checked checkboxes by working directly with  'this'
      // something like $(this).hide() (only something useful, probably) :P
    });
    //alert(values);
    if(values.length!=0){
      $.ajax({
        type: "POST",
        url: "<?php echo $url_rewrite;?>process/rab/getDirektorat",
        data: { 'prog' : values
              },
        success: function(data){
          // alert(JSON.stringify(jQuery.parseJSON(data)));
          var obj = jQuery.parseJSON(data);
          // $ckbx = '<option value="" disabled selected id="kdgiat-div">-- Pilih Direktorat --</option>';
          var ckbx = '';
          for (var i = 0; i < obj.KDGIAT.length; i++) {
            // $ckbx = $ckbx + '<option value="'+obj.KDGIAT[i]+'" id="kdgiat-div">'+obj.KDGIAT[i]+' - '+obj.NMGIAT[i]+'</option>';
            ckbx+=' <div class=" col-md-4 ">'+
                      '<div class="checkbox">'+
                        '<label><input type="checkbox" class="kdgiat" name="direktorat[]" value="'+obj.KDPROGRAM[i]+'-'+obj.KDGIAT[i]+'"> '+obj.KDGIAT[i]+' - '+obj.NMGIAT[i]+' ('+obj.KDPROGRAM[i]+')</label>'+
                      '</div>'+
                    '</div>';
          };
          $('#kdgiat-div').html(ckbx);
          $('.kdgiat').iCheck({
             checkboxClass: 'icheckbox_square-blue'
          });
        }
      });
      
    } else {
      $('#kdgiat-div').html('');
      $('#kdoutput-div').html("");
    }
    
  }

  function chOutput(){
    var values=[];
    var values2=[];
    $.each($('input:checkbox.kdprog:checked'), function() {
      values.push($(this).val());
      // or you can do something to the actual checked checkboxes by working directly with  'this'
      // something like $(this).hide() (only something useful, probably) :P
    });
    $.each($('input:checkbox.kdgiat:checked'), function() {
      var str = $(this).val();
      values2.push(str);
      // or you can do something to the actual checked checkboxes by working directly with  'this'
      // something like $(this).hide() (only something useful, probably) :P
    });
    // alert(values2);
    if(values.length!=0 && values2.length!=0){
      $.ajax({
        type: "POST",
        url: "<?php echo $url_rewrite;?>process/rab/getout2",
        data: { 'prog' : values,
                'direktorat' :values2
              },
        success: function(data){
          // alert(JSON.stringify(jQuery.parseJSON(data)));
          var obj = jQuery.parseJSON(data);
          var ckbx = "";
          for (var i = 0; i < obj.KDOUTPUT.length; i++) {
            ckbx= ckbx+' <div class=" col-md-4 ">'+
                      '<div class="checkbox">'+
                        '<label><input type="checkbox" id="kdoutput" class="kdoutput" name="kdoutput[]" value="'+obj.KDPROGRAM[i]+'-'+obj.KDGIAT[i]+'-'+obj.KDOUTPUT[i]+'"> '+obj.KDOUTPUT[i]+' - '+obj.NMOUTPUT[i]+' ('+obj.KDPROGRAM[i]+'-'+obj.KDGIAT[i]+')</label>'+
                      '</div>'+
                    '</div>';
          };
          $('#kdoutput-div').html(ckbx);
          $('.kdoutput').iCheck({
             checkboxClass: 'icheckbox_square-blue'
          });
        }
      });
      
    } else {
      $('#kdoutput-div').html("");
    }
    
  }
</script>