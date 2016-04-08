<?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  // session_start();
  require_once __DIR__ .'/../config/application.php';
  
  $username = $purifier->purify($_POST['username']);
  $password = $purifier->purify($_POST['password']);
  $password = $utility->sha512($password);

  if (!isset($_SESSION['username'])) {
    $data  = array('username' => $username,
      'password' => $password
    );
    $result = $login->readUser($data);
    if ($result == true) {
      if ($result->status == 1) {
        $_SESSION['id']         = $result->id;
        $_SESSION['nama']       = $result->nama;
        $_SESSION['username']   = $result->username;
        $_SESSION['email']      = $result->email;
        $_SESSION['level']      = $result->level;
        $_SESSION['direktorat'] = $result->direktorat;
        $_SESSION['expire']     = time() + config::$session_time;
        $utility->location_goto("content/home");
      }
      else {
        $alert   = "warning";
        $message = "Maaf Akun Anda Belum Aktif";
        $utility->load(".",$alert,$message);
      }
    }
    else {
      $alert   = "error";
      $message = "Maaf Akun Anda Belum Terdaftar";
      $utility->load(".",$alert,$message);
    }
  }
  else {
    $utility->location_goto("content/home");
  }
?>