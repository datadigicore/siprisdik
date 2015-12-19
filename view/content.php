<?php 
include ('include/meta.php');
include ('include/header.php');
include ('include/sidebar.php');
switch (isset($_POST['content'])) {
  case 'table':
    include ('content/table.php');
  break;
  default:
    include ('content/home.php');
  break;
}
include ('include/footer.php');
include ('include/javascript.php');
?>