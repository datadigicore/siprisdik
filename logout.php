<?php 
include 'utility/utilityCode.php';
$utility = new utilityCode();
#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
$utility->destroy_session();
$flash  = array(
  'category' => "info",
  'messages' => "Anda Telah Mengakhiri Sesi Ini"
);
$utility->load("login",$flash['category'],$flash['messages']);
?>