<?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  
  require_once __DIR__ .'/../config/application.php';
  
  $username = $purifier->purify($_POST['username']);
  $password = $purifier->purify($_POST['password']);

  if (!isset($_SESSION['username'])) {
    $data  = array('username' => $username,
      'password' => $password
    );
    $result = $login->readUser($data);
    if ($result == true) {
      $_SESSION['id']       = $result->id;
      $_SESSION['nama']     = $result->nama;
      $_SESSION['username'] = $result->username;
      $_SESSION['email']    = $result->email;
      $_SESSION['level']    = $result->level;
      $utility->location_goto("content/home");
    }
    else {
      $utility->location_goto(".");
    }
  }
  else {
    $utility->location_goto("content/home");
  }
?>