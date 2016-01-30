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
// $kodeUniversitas=$_GET['kodeUniversitas'];
 $id_rabfull=$_GET['id_rabfull'];
 $query1 = $db->query("SELECT * FROM rabfull where id ='$id_rabfull'");
 $row1 = $db->fetch_object($query1);
 // print_r($row1);die;



 $qry = $db->query("select distinct KDAKUN, NMAKUN from rkakl_full order by KDAKUN");
 // echo "<option value=\"\" >--Pilih Kode Akun--</option>";
 while ($row = $db->fetch_object($qry)) {
     $akun[$row->KDAKUN] = $row->NMAKUN ;
 }
 echo json_encode($akun);

?>
