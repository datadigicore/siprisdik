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
        case 'edit_profile':
          include ('view/content/edit_profile.php');
        break;
        case 'edit_pass':
          include ('view/content/edit_pass.php');
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
            // if(isset($_GET['kdoutput']) && isset($_GET['kdsoutput']) && isset($_GET['kdkmpnen']) && isset($_GET['kdskmpnen']))
            $idrkakl=$data[3];
            $cek = $mdl_rab->cekRkaklEksis($idrkakl);
            if($cek)
            {

                  // $cek = $mdl_rab->cekRkaklDirektorat($idrkakl,$direktorat);
                  // if($cek==true){
                    $datarkakl = $mdl_rab->getrkaklfull3($idrkakl);
                  include ('view/content/rab-tambah.php');  
                  // }
                  // else {
                  //   $utility->load("./content/rab-rkakl",'warning','Anda tidak punya kewenangan untuk mengubah RAB direktorat lain !');
                  // }
                  
                } else {
                  $utility->load("./content/rab-rkakl",'warning','ID RKAKL tidak dapat ditemukan !');
                }
            
          } else if($data[2]=='add-rincian'){
            $id = $data[3];
            include ('view/content/rab-add-rincian.php');
          } else {
            $direktorat = $_SESSION['direktorat'];
            // if(isset($_GET['kdoutput']) && isset($_GET['kdsoutput']) && isset($_GET['kdkmpnen']) && isset($_GET['kdskmpnen']))
            $idrkakl = $data[2];
            $cek = $mdl_rab->cekRkaklEksis($idrkakl);
            
            if($cek)
                {
                  
                  // if($cek==true){
                    $datarkakl = $mdl_rab->getrkaklfull3($idrkakl);
                    include ('view/content/rab.php');
                  // }
                  // else {
                  //   $utility->load("./content/rab-rkakl",'warning','Anda tidak punya kewenangan untuk mengubah RAB direktorat lain !');
                  // }

                  
                } else {
                  $utility->load("./content/rab-rkakl",'warning','ID RKAKL tidak dapat ditemukan !');
                }
          }
        break;
        case 'rab-rkakl':
          $direktorat = $_SESSION['direktorat'];
          $tahun = $mdl_rab->getYear();
          include ('view/content/rab-rkakl.php');
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
            $jumlah = $mdl_rab->getJumlahRkakl($view);
            include ('view/content/rabdetail.php');
          }
          break;
        case 'rabakun':
          if ($data[2] == 'detail') {
            $id_rabfull = $data[3];
            $getrab = $mdl_rab->getrabfull($id_rabfull);
            $datarkakl = $mdl_rab->getrkaklfull($getrab);
            include ('view/content/rab-add-detail.php');
          } else{
            $id_rabfull = $data[2];
            $getrab = $mdl_rab->getrabfull($id_rabfull);
            $datarkakl = $mdl_rab->getrkaklfull($getrab);
            include ('view/content/rab-add.php');
          }
          break;
        case 'insertrab':
          include ('view/content/rab-insert.php');
        break;
        case 'report':
          include ('view/content/report.php');
        break;
        case 'rab51':
          if($data[2]=='addnew'){
            $tahun = $mdl_rab->getYear();
            $direktorat = '5696';
            include ('view/content/rab51-add.php');
          }elseif($data[2]=='edit'){
            $tahun = $mdl_rab->getYear();
            $direktorat = '5696';
            $id = $data[3];
            $getrab = $mdl_rab->getrabfull($id);
            include ('view/content/rab51-edit.php');
          } else {
            $tahun = $mdl_rab->getYear();
            $direktorat = '5696';
            $tahun = $mdl_rab->getYear();
            include ('view/content/rab51.php');
          }
          break;
        case 'real-upload':
            $id_rab_view = "";
            $insert = $mdl_rab->gettemprab($id_rab_view);
            $import = $mdl_rab->getimportreal();
            $stat_err = $data[2];
          include ('view/content/real-upload.php');
          break;
        default:
          include ('view/content/home.php');
        break;
      }
    }
    else {
      switch ($data[1]) {
        case 'edit_profile':
          include ('view/content/edit_profile.php');
        break;
        case 'edit_pass':
          include ('view/content/edit_pass.php');
        break;
        case 'report':
          include ('view/content/report.php');
        break;
        case 'table':
          include ('view/content/table.php');
        break;
        case 'rab':
          if($data[2]=='tambah'){
            $direktorat = $_SESSION['direktorat'];
            // $tahun = $mdl_rab->getYear();
            // if(isset($_GET['kdoutput']) && isset($_GET['kdsoutput']) && isset($_GET['kdkmpnen']) && isset($_GET['kdskmpnen']))
            $idrkakl=$data[3];
            $cek = $mdl_rab->cekRkaklEksis($idrkakl);
            if($cek)
            {

                  $cek = $mdl_rab->cekRkaklDirektorat($idrkakl,$direktorat);
                  if($cek==true){
                    $datarkakl = $mdl_rab->getrkaklfull3($idrkakl);
                    include ('view/content/rab-tambah.php');
                  }
                  else {
                    $utility->load("./content/rab-rkakl",'warning','Anda tidak punya kewenangan untuk mengubah RAB direktorat lain !');
                  }

                  
                } else {
                  $utility->load("./content/rab-rkakl",'warning','ID RKAKL tidak dapat ditemukan !');
                }
          } else if($data[2]=='edit'){
            $direktorat = $_SESSION['direktorat'];
            $tahun = $mdl_rab->getYear();
            $idview = $data[3];
            $getview = $mdl_rab->getview($idview);
            $rabfull = $mdl_rab->getjumlahgiat($idview);
            if ($rabfull->jumlah == "") {
              $readonly = "";
            }else{
              $readonly = "disabled";
            }
            include ('view/content/rab-edit.php');
          } else {
            $direktorat = $_SESSION['direktorat'];
            // $tahun = $mdl_rab->getYear();
            // if(isset($_GET['kdoutput']) && isset($_GET['kdsoutput']) && isset($_GET['kdkmpnen']) && isset($_GET['kdskmpnen']))
            // print_r($data[2]);exit;
            $idrkakl = $data[2];
            $cek = $mdl_rab->cekRkaklEksis($idrkakl);
            if($cek)
                {
                  $cek = $mdl_rab->cekRkaklDirektorat($idrkakl,$direktorat);
                  if($cek==true){
                    $datarkakl = $mdl_rab->getrkaklfull3($idrkakl);
                  
                    include ('view/content/rab.php');
                  }
                  else {
                    $utility->load("./content/rab-rkakl",'warning','Anda tidak punya kewenangan untuk mengubah RAB direktorat lain !');
                  }
                } else {
                  $utility->load("./content/rab-rkakl",'warning','ID RKAKL tidak dapat ditemukan !');
                }
            
          }
        break;
         case 'rab-rkakl':
          $direktorat = $_SESSION['direktorat'];
          $tahun = $mdl_rab->getYear();
          include ('view/content/rab-rkakl.php');
          break;
        case 'rabdetail':
          if($data[3]=='add'){
            $id_rab_view = $data[2];
            $status = $data[4];
            include ('view/content/rab-orang-add.php');
          }elseif ($data[3]=='edit') {
            $id_rab_full = $data[2];
            $getrab = $mdl_rab->getrabfull($id_rab_full);
            $id_rab_view = $getrab['rabview_id'];
            include ('view/content/rab-orang-edit.php');
          }elseif ($data[3] == 'upload') {
            $id_rab_view = $data[2];
            $view = $mdl_rab->getview($id_rab_view);
            $datarkakl = $mdl_rab->getrkaklfull($view);
            $jumlah = $mdl_rab->getJumlahRkakl($view);
            $insert = $mdl_rab->gettemprab($id_rab_view);
            $stat_err = $data[4];
            include ('view/content/rab-upload.php');
          } else{
            $id_rab_view = $data[2];
            $view = $mdl_rab->getview($id_rab_view);
            $datarkakl = $mdl_rab->getrkaklfull($view);
            $jumlah = $mdl_rab->getJumlahRkakl($view);
            include ('view/content/rabdetail.php');
          }
          break;
        case 'rabakun':
          if ($data[2] == 'detail') {
            $id_rabfull = $data[3];
            $getrab = $mdl_rab->getrabfull($id_rabfull);
            $datarkakl = $mdl_rab->getrkaklfull2($getrab);
            $jumlah = $mdl_rab->getJumlahRkakl($getrab);
            $view=$getrab;
            include ('view/content/rab-add-detail.php');
          } else if ($data[2] == 'edit') {
            $id_rabfull = $data[3];
            $getrab = $mdl_rab->getrabfull($id_rabfull);
            $datarkakl = $mdl_rab->getrkaklfull2($getrab);
            $jumlah = $mdl_rab->getJumlahRkakl($getrab);
            $view=$getrab;
            include ('view/content/rab-add-edit.php');
          } else{
            $id_rabfull = $data[2];
            $getrab = $mdl_rab->getrabfull($id_rabfull);
            $datarkakl = $mdl_rab->getrkaklfull2($getrab);
            $jumlah = $mdl_rab->getJumlahRkakl($getrab);
            $view=$getrab;
            include ('view/content/rab-add.php');
          }
          break;
        case 'rab51':
          $tahun = $mdl_rab->getYear();
          $direktorat = $_SESSION['direktorat'];
          $tahun = $mdl_rab->getYear();
          include ('view/content/rab51.php');
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
