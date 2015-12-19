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
    include ('view/include/meta.php');
    include ('view/include/header.php');
    include ('view/include/sidebar.php');
    switch ($data[1]) {
      case 'table':
        include ('view/content/table.php');
      break;
      default:
        include ('view/content/home.php');
      break;
    }
    include ('view/include/footer.php');
    include ('view/include/javascript.php');
  }
}  
?>
