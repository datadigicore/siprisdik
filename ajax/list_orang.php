<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University
include '../config/application.php';
// $kodeUniversitas=$_GET['kodeUniversitas'];
 // $id_rabfull=$_GET['id_rabfull'];
 // $query1 = $db->query("SELECT * FROM rabfull where id ='$id_rabfull'");
 // $row1 = $db->fetch_object($query1);
 // print_r($row1);die;


$direktorat = $_SESSION['direktorat'];
 // $qry = $db->query("select distinct f.kdakun as KDAKUN, r.NMAKUN from rabfull f inner join rkakl_full r on f.kdakun = r.KDAKUN  where f.kdgiat='$direktorat' order by KDAKUN");
  $qry="select concat(nip,'-',npwp) as nip, penerima from rabfull group by concat( IFNULL(nip,''), IFNULL(npwp,''))";
 $qrye = $db->query($qry);
 // echo "<option value=\"\" >--Pilih Kode Akun--</option>";
 while ($row = $db->fetch_object($qrye)) {
     $akun[$row->nip] = $row->penerima;
 }
 echo json_encode($akun);

?>
