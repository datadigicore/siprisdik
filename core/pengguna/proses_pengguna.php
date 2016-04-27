<?php
include 'config/application.php';

$sess_id      = $_SESSION['user_id'];
$id           = $_SESSION['id'];
$id_data      = $purifier->purify($_POST[id]);
$kode         = $purifier->purify($_POST[kode]);
$name         = $purifier->purify($_POST[name]);
$username     = $purifier->purify($_POST[username]);
$password     = $utility->sha512($_POST[password]);
$newpassword  = $utility->sha512($_POST[newpass]);
$newpassword2 = $utility->sha512($_POST[newpass2]);
$email        = $purifier->purify($_POST[email]);
$level        = $purifier->purify($_POST[level]);
$kdprogram    = $purifier->purifyArray($_POST[kdprogram]);
$direktorat   = $purifier->purifyArray($_POST[direktorat]);
$kdoutput     = $purifier->purifyArray($_POST[kdoutput]);
$status       = $purifier->purify($_POST[status]);

$strKdoutput = "";
$strKdprogram = "";
$strDirektorat = "";

foreach ($kdoutput as $value) {
  if($strKdoutput==""){
    $strKdoutput = $value;
  } else {
    $strKdoutput = $strKdoutput.",".$value;
  }
}
foreach ($kdprogram as $value) {
  if($strKdprogram==""){
    $strKdprogram = $value;
  } else {
    $strKdprogram = $strKdprogram.",".$value;
  }
}
foreach ($direktorat as $value) {
  if($strDirektorat==""){
    $strDirektorat = $value;
  } else {
    $strDirektorat = $strDirektorat.",".$value;
  }
}

$data_pengguna = array(
  "id"           => $id,
  "id_data"      => $id_data,
  "kode"         => $kode,
  "name"         => $name,
  "username"     => $username,
  "password"     => $password,
  "newpassword"  => $newpassword,
  "newpassword2" => $newpassword2,
  "email"        => $email,
  "level"        => $level,
  "kdprogram"    => $strKdprogram,
  "direktorat"   => $strDirektorat,
  "kdoutput"     => $strKdoutput,
  "status"       => $status
);

switch ($process) {
  case 'table':
    $table = "pengguna";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'nama',  'dt' => 1 ),
      array( 'db' => 'status',  'dt' => 2, 'formatter' => function($d,$row){ 
        if($d==1){
          return '<button id="aktif" class="btn btn-flat btn-success btn-xs"><i class="fa fa-check-circle"></i> Aktif</button>';
        }
        else{
          return '<button id="nonaktif" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-warning"></i> Belum Aktif</button>';
        }
      }),
      array( 'db' => 'username',  'dt' => 3 ),
      array( 'db' => 'email',   'dt' => 4 ),
      array( 'db' => 'level', 'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==1){
          return 'Operator Bendahara Pengeluaran';
        }
        else if ($d==2){
          return 'Bendahara Pengeluaran Pembantu';
        }
        else if ($d==3){
          return 'Operator BPP';
        }
      }),
      array( 'db' => 'kdgrup',   'dt' => 6 ),
      array( 'db' => 'level',   'dt' => 7 ),
      array( 'db' => 'status',  'dt' => 8 )
    );
    $where = "level != 0";
    $datatable->get_table($table, $key, $column, $where);
  break;
  case 'table-group':
    $table = "grup";
    $key   = "id";
    $column = array(
      array( 'db' => 'id',      'dt' => 0 ),
      array( 'db' => 'kode',  'dt' => 1 ),
      array( 'db' => 'nama',  'dt' => 2),
      array( 'db' => 'kdoutput',  'dt' => 3 )
    );
    $where = "";
    $datatable->get_table($table, $key, $column, $where);
  break;
  case 'activate':
    $id = $_POST['key'];
    $pengguna->activatePengguna($id);
  break;
  case 'deactivate':
    $id = $_POST['key'];
    $pengguna->deactivatePengguna($id);
  break;
  case 'add':
    
    // $strKdoutput = "";
    // foreach ($kdoutput as $value) {
    //   if($strKdoutput==""){
    //     $strKdoutput = $value;
    //   } else {
    //     $strKdoutput = $strKdoutput.",".$value;
    //   }
    // }
    // echo $strKdoutput;
    $pengguna->insertPengguna($data_pengguna);
    $utility->load("content/adduser","success","Data berhasil ditambahkan");
  break;
  case 'add-group':
    
    // $strKdoutput = "";
    // foreach ($kdoutput as $value) {
    //   if($strKdoutput==""){
    //     $strKdoutput = $value;
    //   } else {
    //     $strKdoutput = $strKdoutput.",".$value;
    //   }
    // }
    // echo $strKdoutput;
    $pengguna->insertGroup($data_pengguna);
    $utility->load("content/addgroup","success","Data berhasil ditambahkan");
  break;
  case 'edt':
    $pengguna->updatePengguna($data_pengguna);
    $utility->location_goto("content/setting");
  break;
  case 'edt-pass':
    if($newpassword2==$newpassword){
      $current_pass = $pengguna->getPass($data_pengguna);
      
      if($current_pass==$password){
        $pengguna->updatePass($data_pengguna);
        $utility->load("content/edit_pass","success","Password berhasil diubah");
      } else {
        $utility->load("content/edit_pass","warning","Password Gagal Diubah, Password lama tidak sesuai");
      }
      
    } else {
      $utility->load("content/edit_pass","warning","Password Gagal Diubah, Password baru tidak sama");
    }
  break;
  case 'edt2':
    $pengguna->updatePengguna2($data_pengguna);
    $utility->load("content/edit_profile","success","Data berhasil diubah");
  break;
  case 'edit':
    if (!empty($_POST['password'])) {
      $_POST['password'] = $utility->sha512($_POST['password']);
    }
    $pengguna->editPengguna($purifier->purifyArray($_POST));
    $utility->load("content/user","success","Data Pengguna berhasil diperbaharui");
  break;
  case 'edit-group':
    $pengguna->editGrup($data_pengguna);
    $utility->load("content/user","success","Data Pengguna berhasil diperbaharui");
  break;
  case 'delete':
    $id = $_POST['id'];
    $pengguna->deletePengguna($id);
    $utility->load("content/user","success","Data Pengguna berhasil dihapus");
  break;
  case 'kuitansi':
    $report->kuitansi($data_pengguna);
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
