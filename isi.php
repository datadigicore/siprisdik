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
  else {
    include ('view/include/meta.php');
    include ('view/include/javascript.php');
    include ('view/include/header.php');
    include ('view/include/sidebar.php');
    if ($_SESSION['level'] == 0) {
      switch ($data[1]) {
        case 'user':
          include ('view/content/pengguna.php');
        break;
        case 'adduser':
          include ('view/content/pengguna-add.php');
        break;
        case 'rkakl':
          include ('view/content/rkakl.php');
        break;
        case 'insertrkakl':
          include ('view/content/rkakl-insert.php');
        break;
        case 'rab':
          if($data[2]=='add'){
            include ('view/content/rab-add.php');
          } else {
            include ('view/content/rab.php');
          }
        break;
        case 'insertrab':
          include ('view/content/rab-insert.php');
        break;
        case 'report':
          include ('view/content/report.php');
        break;
        default:
          include ('view/content/home.php');
        break;
      }
    }
    else {
      switch ($data[1]) {
        case 'table':
          include ('view/content/table.php');
        break;
        default:
          include ('view/content/home.php');
        break;
      }
    }
    include ('view/include/footer.php');
  }
}
?>
