<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University
include '../config/application.php';
$kodeUniversitas=$_GET['kodeUniversitas'];
$idprodi=$_GET['idprodi'];

 $qry = $db->query("select distinct KDAKUN, NMAKUN from rkakl_full order by KDAKUN");
 while ($row = $db->fetch_object($qry)) {
      $kode_akun = $row->KDAKUN;
      $nama_akun = $row->NMAKUN;
      if ($kd_akun == $kode_akun)
           echo "<option value=\"$kode_akun\" selected>$kode_akun : $nama_akun</option>";
      else
           echo "<option value=\"$kode_akun\" >$kode_akun : $nama_akun</option>";
 }
?>
