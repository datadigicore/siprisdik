<?php
require_once './config/application.php';
$path = ltrim($_SERVER['REQUEST_URI'], '/');
$temp_path = explode($REQUEST, $path);
$elements = explode('/', $temp_path[1]);
$data = array_filter($elements);
if (count($data) == 0) {
  include "./index.php";
}
else {
  if (!isset($_SESSION['username'])) {
    $utility->location_goto(".");
  }
  else{
    switch ($data[1]) {
      case 'home':
        include "view/content.php";
      break;
      default:
        header('HTTP/1.1 404 Not Found');
      break;
    }
  }
}  
?>
