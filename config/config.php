<?php
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  header('Cache-control: private');
  header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header('Pragma: no-cache');

  $cookie_name    = 'siteAuth';
  $cookie_time    = (3600 * 24 * 30);
  $algoritma      = "rijndael-256";
  $mode           = "cfb";
  $secretkey      = "sipdikti";
  $TITLE          = "Sistem Informasi Pelaporan";
  $domain         = "localhost";
  $url_rewrite    = "http://localhost/siprisdik/";
  $REQUEST        = "siprisdik/content";
  $PROSES_REQUEST = "siprisdik/process";
  // $path           = "C:/xampp/htdocs/siprisdik/";
  $path           = "/opt/lampp/htdocs/siprisdik/";
  // $path           = "/Applications/XAMPP/htdocs/siprisdik/";
  // $path_upload    = "C:/xampp/htdocs/siprisdik/static/uploads/";
  $path_upload    = "/opt/lampp/htdocs/siprisdik/static/uploads/";
  // $path_upload    = "/Applications/XAMPP/htdocs/siprisdik/static/uploads/";

  class config {
    public $db_host              = "localhost";
    public $db_user              = "root";
    public $db_pass              = "";
    public $database             = "rkakl";
    public $url_rewrite_class    = "http://localhost/siprisdik";
    public $session_expired_time = "7200";
    public $hashing_number       = "d1kt1w4rr10r5";
    public $debug                = 1;
    public function open_connection() {
      $this->link_db = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->database)
      or die("Koneksi Database gagal");
      return $this->link_db;
    }
    public function sql_details() {
      $this->sql_details = array(
        'user' => $this->db_user,
        'pass' => $this->db_pass,
        'db'   => $this->database,
        'host' => $this->db_host
      );
      return $this->sql_details;
    }
  }
?>
