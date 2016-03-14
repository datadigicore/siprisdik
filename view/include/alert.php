<?php 
// print_r('<pre>');
// print_r($utility);
  if ($utility->readflash('success') != '') { ?>
    <div class="alert alert-success" style="text-align: center;">
      <strong>Perhatian!</strong> <?php echo $utility->readflash('success'); ?>
    </div><?php
    $flash = array('success','info','warning','error');
    $utility->unflash($flash);
  }
  else if ($utility->readflash('info') != '') { ?>
    <div class="alert alert-info" style="text-align: center;">
      <strong>Perhatian!</strong> <?php echo $utility->readflash('info'); ?>
    </div><?php
    $flash = array('success','info','warning','error');
    $utility->unflash($flash);
  }
  else if ($utility->readflash('warning') != '') { ?>
    <div class="alert alert-warning" style="text-align: center;">
      <strong>Perhatian!</strong> <?php echo $utility->readflash('warning'); ?>
    </div><?php
    $flash = array('success','info','warning','error');
    $utility->unflash($flash);
  }
  else if ($utility->readflash('error') != '') { ?>
    <div class="alert alert-danger" style="text-align: center;">
      <strong>Perhatian!</strong> <?php echo $utility->readflash('error'); ?>
    </div><?php
    $flash = array('success','info','warning','error');
    $utility->unflash($flash);
  }
?>
