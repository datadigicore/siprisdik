<?php
include 'config/application.php';

switch ($process) {
	case 'save_penerima':
		$id_rab_view = $_POST['id_rab_view'];
		$getview = $mdl_rab->getview($id_rab_view);
		// print_r($getview);die;
		$mdl_rab->save_penerima($id_rab_view, $getview, $_POST);
    	$utility->load("content/rabdetail/".$id_rab_view,"success","Data berhasil dimasukkan ke dalam database");
		break;
	case 'table':
		$rabview_id = $data[3];
		$dataArray['url_rewrite'] = $url_rewrite;
	    $get_table = "rabfull";
	    $key   = "id";
	    $column = array(
	      array( 'db' => 'id',      'dt' => 0 ),
	      array( 'db' => 'penerima',  'dt' => 1, 'formatter' => function($d, $row){
	      	if ($row[2]  == 0) {
	      		$nip = 'N/A';
	      	}else{
	      		$nip = $row[10];
	      	}

	      	if ($row[11] == 1) $gol = 'I';
	      	elseif($row[11] == 2) $gol =  'II';
	      	elseif($row[11] == 3) $gol =  'III';
	      	elseif($row[11] == 4) $gol =  'VI';
	      	else $gol =  'N/A';

	      	if ($row[12] == 0) {
	      		if ($row[2] == 0) {
	      			$pns = 'N/A';
	      		}else{
	      			$pns = 'Non PNS';
	      		}
	      	}else{
	      		$pns = 'PNS';
	      	}

	      	if ($row[2]  == 0) {
	      		$jab = 'N/A';
	      	}else{
	      		$jab = $row[13];
	      	}

	      	return '<table><tr><td>Penerima</td><td> :&nbsp;</td><td>'.$d.'</td></tr>'.
                 '<tr><td>NPWP</td><td> :&nbsp;</td><td>'.$row[9].'</td></tr>'.
                 '<tr><td>NIP</td><td> :&nbsp;</td><td>'.$nip.'</td></tr>'.
                 '<tr><td>Golongan</td><td> :&nbsp;</td><td>'.$gol.'</td></tr>'.
                 '<tr><td>Status PNS</td><td> :&nbsp;</td><td>'.$pns.'</td></tr>'.
                 '<tr><td>Jabatan</td><td> :&nbsp;</td><td>'.$jab.'</td></tr></table>';
	      }),
	      array( 'db' => 'jenis',  'dt' => 2, 'formatter' => function($d, $row){
	      	if ($d == 0) {
	      		return 'Badan';
	      	}else{
	      		return 'Perorangan';
	      	}
	      }),
	      array( 'db' => 'GROUP_CONCAT(DISTINCT(kdakun) SEPARATOR ", ")', 'dt' => 3),
	      array( 'db' => 'SUM(value)', 'dt' => 4, 'formatter' => function($d,$row){ 
	      	return number_format($d,2);
	      }),
	      array( 'db' => 'status',  'dt' => 5, 'formatter' => function($d,$row, $dataArray){ 
	        if($d==0){
	          return '<i>Belum Diajukan</i>';
	        }
	        elseif($d==1){
	          return '<i>Telah Diajukan</i>';
	        }
	        elseif($d==2){
	          return '<i>Telah Disahkan</i>';
	        }
	        elseif($d==3){
	          return '<i>Revisi</i>';
	        }
	        elseif($d==4){
	          return '<i>Telah Disahkan / Close</i>';
	        }
	        elseif($d==5){
	          return '<i>Adendum</i>';
	        }
	        elseif($d==6){
	          return '<i>Adendum Telah Disahkan / Close Adendum</i>';
	        }
	        elseif($d==7){
	          return '<i>Penutupan Anggaran</i>';
	        }
	        elseif($d==8){
	          return '<i>Dibatalkan</i>';
	        }
	      }),
	      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row, $dataArray){ 
	      	$button =  '<div class="text-center btn-group-vertical">';
	      	if ($_SESSION['level'] == 0) {
	      		$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Lihat Akun</a>';
	      		if ($d == 2 || $d == 5 || $d == 4) {
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."pdf".'" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (PDF)</a>';
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."word".'" class="btn btn-flat btn-info btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (Word)</a>';
	      		}
	      	}else{
	      		if ($d == 0 || $d == 3 || $d == 5) {
	      			$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Tambah Akun</a>';
	      		}else{
	      			$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Lihat Akun</a>';
	      		}
	      		if ($d == 2 || $d == 5 || $d == 4) {
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."pdf".'" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (PDF)</a>';
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."word".'" class="btn btn-flat btn-info btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (Word)</a>';
		        }
	      	}
	        $button .='</div>';
	        return $button;
	      }),
		  array( 'db' => 'no_kuitansi', 'dt' => 7, 'formatter' => function($d,$row){
		  	if ($d != "") {
		  		return '<center>'.$d.'</center>';
		  	}else{
		  		return '<center>N/A</center>';
		  	}
		  }),
		  array('db' => 'status', 'dt'=>8, 'formatter' => function($d,$row, $dataArray){
		  	
		  	if ($_SESSION['level'] == 0) {
		  		if ($row[7] != "" && $d == 4 ) {
		  			$button =  '<div class="text-center btn-group-vertical">'.
		  						'<a style="margin:0 2px;" id="btn-batal" href="#batal" class="btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-close"></i> Batal</a>'.
		  						'</div>';
		  		}elseif ($row[7] != "" && $d == 6 ) {
		  			$button =  '<div class="text-center btn-group-vertical">'.
		  						'<a style="margin:0 2px;" id="btn-btl-adn" href="#batal-adn" class="btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-close"></i> Batal</a>'.
		  						'</div>';
		  		}else{
		  			$button = '<center>-</center>';
		  		}
		  	}elseif ($_SESSION['level'] == 2) {
		  		if ($row[7] != "" && ($d == 2 || $d == 5)) {
		  			$button =  '<div class="text-center btn-group-vertical">'.
		  						'<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>'.
		  						'</div>';
		  		}elseif ($row[7] != "" && ($d == 2 || $d == 5)) {
		  			$button =  '<div class="text-center btn-group-vertical">'.
		  						'<a style="margin:0 2px;" id="btn-sah-adn" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>'.
		  						'</div>';
		  		}else{
		  			$button = '<center>-</center>';
		  		}
		  	}else{
		  		if ($row[7] != "" && ($d == 2 || $d == 5)) {
		  			$button = '<i>Belum Disahkan</i>';
		  		}else{
		  			$button = '<center>-</center>';
		  		}
		  	}
		  	
		  	return $button;
		  }),
	      array( 'db' => 'npwp',  'dt' => 9),
	      array( 'db' => 'nip',  'dt' => 10),
	      array( 'db' => 'golongan',  'dt' => 11),
	      array( 'db' => 'pns',  'dt' => 12),
	      array( 'db' => 'jabatan', 'dt' => 13),
	    );
		$where = 'rabview_id = "'.$rabview_id.'"';
		$group = 'npwp';

	    $datatable->get_table_group($get_table, $key, $column,$where, $group, $dataArray);
	    break;
	case 'getorang':
		$getorang = $mdl_rab->getOrang($_POST);
		echo json_encode($getorang);
		break;
	case 'cekAdendum':
		$id_rab_view = $_POST['id_rab_view'];
		$getdata = $mdl_rab->getview($id_rab_view);
		echo json_encode($getdata);
		break;
	case 'sahkanAkun':
		if (isset($_POST)) {
			$status = $_POST['status'];
			$id_rabfull = $_POST['id_rabfull'];
			$id_rab_view = $_POST['id_rab_view'];
			$getrab = $mdl_rab->getrabfull($id_rabfull);
			$mdl_rab->chStatusFullOrang($getrab,$status);
			$mdl_rab->updateView($id_rab_view);
	    	$utility->load("content/rabdetail/".$id_rab_view."/detail","success","Data telah disahkan");
		}else{
			$utility->location_goto(".");
		}
		break;
	case 'tambahAkun':
		// echo "<pre>";
		// print_r($_POST);die;
		if (isset($_POST)) {
			$akun = $_POST['kdakun'];
			if ($akun == '524119') {
				$insert = $mdl_rab->tambahAkunPerjalanan($_POST);
			}else{
				$insert = $mdl_rab->tambahAkun($_POST);
			}
    		$utility->load("content/rabakun/".$_POST['id_rabfull'],"success","Data berhasil dimasukkan ke dalam database");
		}else{
			$utility->location_goto(".");
		}
		break;
	case 'editAkun':
		$akun = $_POST['kdakun'];
		if ($akun == '524119') {
			$insert = $mdl_rab->editAkunPerjalanan($_POST);
		}else{
			$insert = $mdl_rab->editAkun($_POST);
		}
    	$utility->load("content/rabakun/".$_POST['id_rabfull'],"success","Data berhasil diubah");
		break;
	case 'tableAkun':
		$rabfull_id = $data[3];
		$getdata = $mdl_rab->getrabfull($rabfull_id);
		// print_r($getdata);die;
	    $get_table = "rabfull";
	    $get_table2 = "rkakl_full";
	    $on = 'rabfull.`kdprogram` = rkakl_full.`KDPROGRAM`
			    AND rabfull.`kdgiat` = rkakl_full.`KDGIAT`
			    AND rabfull.`kdoutput` = rkakl_full.`KDOUTPUT`
			    AND rabfull.`kdsoutput` = rkakl_full.`KDSOUTPUT`
			    AND rabfull.`kdkmpnen` = rkakl_full.`KDKMPNEN`
			    AND rabfull.`kdskmpnen` = rkakl_full.`KDSKMPNEN`
			    AND rabfull.`kdakun` = rkakl_full.`KDAKUN`
			    AND rabfull.`noitem` = rkakl_full.`NOITEM`';
	    $key   = "rabfull.`id`";
	    $column = array(
	      array( 'db' => 'rabfull.id',      'dt' => 0 ),
	      array( 'db' => 'rabfull.kdakun',  'dt' => 1, 'formatter' => function($d,$row){
	      	return '<table><tr><td>Kode Akun</td><td> :&nbsp;</td><td>'.$d.'</td></tr>'.
                 '<tr><td>No Item</td><td> :&nbsp;</td><td>'.$row[5].'</td></tr></table>';
	      }),
	      array( 'db' => 'rkakl_full.NMAKUN',  'dt' => 2),
	      array( 'db' => 'rabfull.value', 'dt' => 3, 'formatter' => function($d,$row,$dataArray){
	      	return number_format($d,2);
	      }),
	      array( 'db' => 'rabfull.status',  'dt' => 4, 'formatter' => function($d,$row,$dataArray){ 
	        if(($d==0 || $d==3) && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-detail" href="'.$dataArray['url_rewrite'].'content/rabakun/detail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
	                    '<a style="margin:0 2px;" id="btn-edit" href="'.$dataArray['url_rewrite'].'content/rabakun/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>'.
	                    '<a style="margin:0 2px;" id="btn-del" href="#delrab" data-toggle="modal" class="btn btn-flat btn-danger btn-sm" ><i class="fa fa-close"></i>&nbsp; Delete</a>'.
	                  '</div>';
	        }else{
	        	return  '<div class="text-center">'.
		                    '<a style="margin:0 2px;" id="btn-detail" href="'.$dataArray['url_rewrite'].'content/rabakun/detail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
		                '</div>';
	        }
	      }),
	      array( 'db' => 'rabfull.noitem', 'dt' => 5),
	    );
		$where = 'rabfull.thang 		= "'.$getdata->thang.'"
				AND rabfull.kdprogram 	= "'.$getdata->kdprogram.'"
				AND rabfull.kdgiat 		= "'.trim($getdata->kdgiat,"\x0D\x0A").'"
				AND rabfull.kdoutput 	= "'.trim($getdata->kdoutput,"\x0D\x0A").'"
				AND rabfull.kdsoutput	= "'.trim($getdata->kdsoutput,"\x0D\x0A").'"
				AND rabfull.kdkmpnen 	= "'.trim($getdata->kdkmpnen,"\x0D\x0A").'"
				AND rabfull.kdskmpnen 	= "'.$getdata->kdskmpnen.'"
				AND rabfull.penerima 	= "'.$getdata->penerima.'"
				AND rabfull.npwp 		= "'.$getdata->npwp.'"
		';
		// $group = ' ';
		$dataArray['url_rewrite'] = $url_rewrite;

	    $datatable->get_table_join($get_table,$get_table2, $key, $column, $on, $where, $group, $dataArray);
		break;
	case 'cekDinas':
		$id_rabfull = $_POST['id_rabfull'];
		$kdakun = $_POST['kdAkun'];
		$getrab = $mdl_rab->getrabfull($id_rabfull);
		$getakun = $mdl_rab->getakungroup($getrab);
		// print_r($getakun);die;
		$data['error'] = false;
		if (count($getakun) > 2) {
			$data['error'] = '1';
			for ($i=0; $i < count($getakun); $i++) { 
				if ($kdakun == $getakun[$i]->kdakun) {
					$data['error'] = false;
				}
			}
		}else{
			if (!empty($getakun[0]->kdakun)) {
				if ($getakun[0]->kdakun == 521213) {
					if ($kdakun != 524114 && $kdakun != 524119 && $kdakun != 521213) {
						$data['error'] = '2';
					}
				}elseif ($getakun[0]->kdakun == 522151) {
					if ($kdakun != 524114 && $kdakun != 524119 && $kdakun != 522151) {
						$data['error'] = '3';
					}
				}elseif ($getakun[0]->kdakun == 524114) {
					if ($kdakun != 521213  && $kdakun != 522151 && $kdakun != 524114) {
						$data['error'] = '4';
					}
				}elseif ($getakun[0]->kdakun == 524119) {
					if ($kdakun != 521213  && $kdakun != 522151 && $kdakun != 524119) {
						$data['error'] = '5';
					}
				}
			}
		}
		echo json_encode($data);
		break;
	case 'delrab':
		$id_rabfull = $_POST['id_rab_del'];
		$getrabfull = $mdl_rab->getrabfull($id_rabfull);
		$mdl_rab->delrabdetail($id_rabfull);
		$getidrab = $mdl_rab->getminrabid($getrabfull);
    	$utility->load("content/rabakun/".$getidrab->id,"success","Data berhasil dihapus");
		break;
	default:
		$utility->location_goto(".");
		break;
}
?>
