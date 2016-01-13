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
        $qry = $db->query('SELECT K.NOITEM, K.NMITEM FROM rkakl_full K inner join rabview B on K.KDGIAT = B.kdgiat and K.KDOUTPUT = B.kdoutput and K.KDSOUTPUT = B.kdsoutput and K.KDKMPNEN = B.kdkmpnen and K.KDSKMPNEN = B.kdskmpnen where K.KDAKUN = "'.$kdAkun.'"');
                while ($row = $db->fetch_object($qry)) {
                     $item[$row->NOITEM] = $row->NMITEM ;
                }
        echo json_encode($item);
?>
 