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
  $url_rewrite    = "http://202.125.94.116/dikti/";
  $REQUEST        = "dikti/content";
  $PROSES_REQUEST = "dikti/process";
  // $path           = "C:/xampp/htdocs/siprisdik/";
  $path           = "/srv/www/htdocs/dikti/";
  // $path           = "/Applications/XAMPP/htdocs/siprisdik/";
  // $path_upload    = "C:/xampp/htdocs/siprisdik/static/uploads/";
  $path_upload    = "/srv/www/htdocs/dikti/static/uploads/";
  // $path_upload    = "/Applications/XAMPP/htdocs/siprisdik/static/uploads/";
  $path_download = "srv/www/htdocs/dikti/template/";

  class config {
    public $db_host              = "localhost";
    public $db_user              = "dikti";
    public $db_pass              = "dikti123";
    public $database             = "dikti_keuangan";
    public $url_rewrite_class    = "http://202.125.94.116/dikti";
    public $session_expired_time = "7200";
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
