<?php
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  
  header('Cache-Control: no-store, must-revalidate');
  header('Pragma       : no-cache');
  header('Expires      : 0');

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
  $path           = "/var/www/html/siprisdik/";
  $path_upload    = "/var/www/html/siprisdik/static/uploads/";
  
  class config {
    public $db_host              = "localhost";
    public $db_user              = "root";
    public $db_pass              = "root";
    public $database             = "rkakl";
    public $url_rewrite_class    = "http://localhost/siprisdik/";
    public $hashing_number       = "d1kt1w4rr10r5";
    public $debug                = 1;
    public static $session_time  = 7200 /*2 hours*/;
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
