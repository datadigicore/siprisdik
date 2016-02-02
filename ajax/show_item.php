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
$kdAkun=$_GET['kdAkun'];
$id_rabfull=$_GET['id_rabfull'];
$query1 = $db->query("SELECT * FROM rabfull where id ='$id_rabfull'");
$row1 = $db->fetch_object($query1);

 $qry = $db->query("select distinct K.NOITEM, K.NMITEM from rkakl_full K join rabfull B
 					on K.KDPROGRAM = '$row1->kdprogram' 
						and K.KDGIAT = '".trim($row1->kdgiat,"\x0D\x0A")."' 
						and K.KDOUTPUT = '".trim($row1->kdoutput,"\x0D\x0A")."' 
						and K.KDSOUTPUT = '".trim($row1->kdsoutput,"\x0D\x0A")."' 
						and K.KDKMPNEN = '".trim($row1->kdkmpnen,"\x0D\x0A")."' 
						and K.KDSKMPNEN = '$row1->kdskmpnen' 
						and K.KDAKUN = '$kdAkun' 
 					where K.KDAKUN not like '51%' 
 					order by K.NOITEM");

// $qry = $db->query('SELECT K.NOITEM, K.NMITEM FROM rkakl_full K inner join rabfull B 
// 					on K.KDGIAT = B.kdgiat 
//     					and K.KDOUTPUT = B.kdoutput 
//     					and K.KDSOUTPUT = B.kdsoutput 
//     					and K.KDKMPNEN = B.kdkmpnen 
//     					and K.KDSKMPNEN = B.kdskmpnen 
// 					where K.KDAKUN = "'.$kdAkun.'"');
while ($row = $db->fetch_object($qry)) {
     $item[$row->NOITEM] = $row->NMITEM ;
}
echo json_encode($item);
?>
 