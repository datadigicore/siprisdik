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

 $qry = $db->query("select distinct K.KDAKUN, K.NMAKUN from rkakl_full K join rabfull B
 					on K.KDPROGRAM = '$row1->kdprogram' 
						and K.KDGIAT = '$row1->kdgiat' 
						and K.KDOUTPUT = '$row1->kdoutput' 
						and K.KDSOUTPUT = '$row1->kdsoutput' 
						and K.KDKMPNEN = '$row1->kdkmpnen' 
						and K.KDSKMPNEN = '$row1->kdskmpnen' 
 					where K.KDAKUN not like '51%' 
 					and B.id = '$id_rabfull'
 					order by K.KDAKUN");

 $qry = $db->query("select distinct KDAKUN, NMAKUN from rkakl_full order by KDAKUN");
 // echo "<option value=\"\" >--Pilih Kode Akun--</option>";

 while ($row = $db->fetch_object($qry)) {
    $akun[$row->KDAKUN] = $row->NMAKUN ;
 }
 echo json_encode($akun);

?>
