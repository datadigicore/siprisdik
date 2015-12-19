<?php
  include 'config/application.php';
  if (isset($_SESSION['username'])) {
  	$utility->location_goto("content/home");
  }
  else {
  	include "view/login.php";
  }
?>
