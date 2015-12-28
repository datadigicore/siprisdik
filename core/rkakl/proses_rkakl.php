<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';

switch ($process) {
  case 'import':
    $arr = get_defined_functions();
    echo "Tes Case";
    print('<pre>');
    print_r($_FILES['fileimport']);
    if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
      $namearr = explode(".",$_FILES['fileimport']['name']);
      if(end($namearr) != 'xls' && end($namearr) != 'xlsx') {
        echo '<p> Invalid File </p>';
        $invalid = 1;
      }
      else {
        $target_dir = $path_upload;
        $target_file = $target_dir . basename($_FILES["fileimport"]["name"]);
        $response = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
        if($response) {
          try {
            $objPHPExcel = PHPExcel_IOFactory::load($target_file);
          }
          catch(Exception $e) {
            die('Error : Unable to load the file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
          }
          $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
          print_r($allDataInSheet);
          $arrayCount = count($allDataInSheet);
          echo $arrayCount;
        }
      }
    }
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
