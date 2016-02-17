<?php
include 'config/application.php';

$sess_id    = $_SESSION['user_id'];
$id         = $_SESSION['id'];
$name       = $purifier->purify($_POST[name]);
$username   = $purifier->purify($_POST[username]);
$password   = $utility->sha512($_POST[password]);
$newpassword   = $utility->sha512($_POST[newpass]);
$newpassword2  = $utility->sha512($_POST[newpass2]);
// $hash_pass  = $utility->sha512($_POST[hash_pass]);
$email      = $purifier->purify($_POST[email]);
$level      = $purifier->purify($_POST[level]);
$direktorat     = $purifier->purify($_POST[direktorat]);
$status     = $purifier->purify($_POST[status]);

$data_pengguna = array(
  "id"         => $id,
  "name"       => $name,
  "username"   => $username,
  "password"   => $password,
  "newpassword"   => $newpassword,
  "newpassword2"   => $newpassword2,
  "email"      => $email,
  "level"      => $level,
  "direktorat" => $direktorat,
  "status"     => $status
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
      array( 'db' => 'direktorat',   'dt' => 6 ),
      array( 'db' => 'level',   'dt' => 7 ),
      array( 'db' => 'status',  'dt' => 8 )
    );
    $where = "level != 0";
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
    $pengguna->insertPengguna($data_pengguna);
    $utility->load("content/adduser","success","Data berhasil ditambahkan");
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
  case 'del':
    $pengguna->deletePengguna($hapuspengguna);
    $utility->location_goto("content/setting");
  break;
  case 'kuitansi':
    $report->kuitansi($data_pengguna);
  break;
  default:
    $utility->location_goto(".");
  break;
}
?>
