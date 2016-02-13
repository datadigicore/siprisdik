<?php
require_once './config/application.php';
$path = ltrim($_SERVER['REQUEST_URI'], '/');
$temp_path = explode($REQUEST, $path);
$elements = explode('/', $temp_path[1]);
$data = array_filter($elements);

$direk = array( '5696' => 'Dukungan Manajemen untuk Program Peningkatan Kualitas Kelembagaan Iptek dan Dikti',
              '5697' => 'Pengembangan Kelembagaan Perguruan Tinggi',
              '5698' => 'Pembinaan Kelembagaan Perguruan Tinggi',
              '5699' => 'Penguatan dan Pengembangan Lembaga Penelitian dan Pengembangan',
              '5700' => 'Pengembangan Taman Sains dan Teknologi (TST) dan Lembaga Penunjang Lainnya',
            );
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
          if($data[2]=='tambah'){
            include ('view/content/rab-tambah.php');
          } else if($data[2]=='add-rincian'){
            $id = $data[3];
            include ('view/content/rab-add-rincian.php');
          } else {
            $direktorat = $_SESSION['direktorat'];
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab.php');
          }
        break;
        case 'rabdetail':
          if($data[3]=='add'){
            $id_rab_view = $data[2];
            $status = $data[4];
            include ('view/content/rab-orang-add.php');
          }else{
            $id_rab_view = $data[2];
            $view = $mdl_rab->getview($id_rab_view);
            $datarkakl = $mdl_rab->getrkaklfull($view);
            include ('view/content/rabdetail.php');
          }
          break;
        case 'rabakun':
            $id_rabfull = $data[2];
          include ('view/content/rab-add.php');
          break;
        case 'insertrab':
          include ('view/content/rab-insert.php');
        break;
        case 'report':
          include ('view/content/report.php');
        break;
        case 'rab51':
          if($data[3]=='addnew'){
            $tahun = $mdl_rab->getYear();
            $direktorat = $data[2];
            include ('view/content/rab51-add.php');
          } else {
            $tahun = $mdl_rab->getYear();
            $direktorat = $data[2];
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab51.php');
          }
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
        case 'rab':
          if($data[2]=='tambah'){
            $direktorat = $_SESSION['direktorat'];
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab-tambah.php');
          } else if($data[2]=='add-rincian'){
            include ('view/content/rab-add-rincian.php');
          } else {
            $direktorat = $_SESSION['direktorat'];
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab.php');
          }
        break;
        case 'rabdetail':
          if($data[3]=='add'){
            $id_rab_view = $data[2];
            $status = $data[4];
            include ('view/content/rab-orang-add.php');
          }else{
            $id_rab_view = $data[2];
            $view = $mdl_rab->getview($id_rab_view);
            $datarkakl = $mdl_rab->getrkaklfull($view);
            include ('view/content/rabdetail.php');
          }
          break;
        case 'rabakun':
            $id_rabfull = $data[2];
          include ('view/content/rab-add.php');
          break;
        case 'rab51':
          if($data[3]=='addnew'){
            $tahun = $mdl_rab->getYear();
            $direktorat = $data[2];
            include ('view/content/rab51-add.php');
          }elseif($data[3]=='edit'){
            $tahun = $mdl_rab->getYear();
            $direktorat = $data[2];
            $id = $data[4];
            $getrab = $mdl_rab->getrabfull($id);
            include ('view/content/rab51-edit.php');
          } else {
            $tahun = $mdl_rab->getYear();
            $direktorat = $data[2];
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab51.php');
          }
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
