<?php
include 'config/application.php';

switch ($process) {
	case 'save_penerima':
		$id_rab_view = $_POST['id_rab_view'];
		$getview = $mdl_rab->getview($id_rab_view);
		// print_r($getview);die;
		$mdl_rab->save_penerima($id_rab_view, $getview, $_POST);
    	$utility->load("content/rabdetail/".$id_rab_view."/detail","success","Data berhasil dimasukkan ke dalam database");
		break;
	case 'table':
		$rabview_id = $data[3];
		$dataArray['url_rewrite'] = $url_rewrite;
	    $get_table = "rabfull";
	    $key   = "id";
	    $column = array(
	      array( 'db' => 'id',      'dt' => 0 ),
	      array( 'db' => 'penerima',  'dt' => 1),
	      array( 'db' => 'jenis',  'dt' => 2, 'formatter' => function($d, $row){
	      	if ($d == 0) {
	      		return 'Badan';
	      	}else{
	      		return 'Perorangan';
	      	}
	      }),
	      array( 'db' => 'npwp',  'dt' => 3),
	      array( 'db' => 'golongan',  'dt' => 4 ),
	      array( 'db' => 'jabatan', 'dt' => 5),
	      array( 'db' => 'GROUP_CONCAT(DISTINCT(kdakun) SEPARATOR ", ")', 'dt' => 6),
	      array( 'db' => 'SUM(value)', 'dt' => 7, 'formatter' => function($d,$row){ 
	      	return number_format($d,2);
	      }),
	      array( 'db' => 'status',  'dt' => 8, 'formatter' => function($d,$row, $dataArray){ 
	        if($d==0 && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Add Akun</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file"></i>&nbsp; Cetak Kuitansi</a>'.
	                  '</div>';
	        }elseif ($d==0 && $_SESSION['level'] == 0) {
	          return  '<div class="text-center btn-group-vertical">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; View Akun</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-file"></i>&nbsp; Cetak Kuitansi</a>'.
	                  '</div>';
	        }
	      }),
		  array( 'db' => 'no_kuitansi', 'dt' => 9, 'formatter' => function($d,$row){
		  	if ($d != "") {
		  		return '<center>'.$d.'</center>';
		  	}else{
		  		return '<center>-</center>';
		  	}
		  }),
		  array('db' => 'status', 'dt'=>10, 'formatter' => function($d,$row, $dataArray){
		  	if ($_SESSION['level'] == 0) {
		  		return  '<div class="text-center btn-group-vertical">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/sahkanAkun/'.$row[0].'" class="btn btn-flat btn-success btn-sm"><i class="fa fa-check"></i>&nbsp; Sahkan</a>'.
	                  '</div>';
		  	}else{
		  		return '';
		  	}
		  	  
		  })
	    );
		$where = 'rabview_id = "'.$rabview_id.'"';
		$group = 'npwp';

	    $datatable->get_table_group($get_table, $key, $column,$where, $group, $dataArray);
	    break;
	case 'getorang':
		$npwp = $_POST['npwp'];
		$getorang = $mdl_rab->getOrang($npwp);
		echo json_encode($getorang);
		break;
	case 'tambahAkun':
		$insert = $mdl_rab->tambahAkun($_POST);
    	$utility->load("content/rabakun/".$_POST['id_rabfull'],"success","Data berhasil dimasukkan ke dalam database");
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
	      array( 'db' => 'rabfull.kdakun',  'dt' => 1),
	      array( 'db' => 'rkakl_full.NMAKUN',  'dt' => 2),
	      array( 'db' => 'rabfull.noitem',  	'dt' => 3),
	      array( 'db' => 'rkakl_full.NMITEM',  'dt' => 4 ),
	      array( 'db' => 'rabfull.value', 'dt' => 5, 'formatter' => function($d,$row,$dataArray){
	      	return number_format($d,2);
	      }),
	      array( 'db' => 'rabfull.status',  'dt' => 6, 'formatter' => function($d,$row,$dataArray){ 
	        if($d==0 && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-danger btn-sm" ><i class="fa fa-close"></i>&nbsp; Delete</a>'.
	                  '</div>';
	        }elseif ($d==0 && $_SESSION['level'] == 0) {
	          return  '<div class="text-center btn-group-vertical">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-danger btn-sm" ><i class="fa fa-close"></i>&nbsp; Delete</a>'.
	                  '</div>';
	        }else{
	        	return  '<div class="text-center">'.
		                    '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
		                  '</div>';
	        }
	      })
	    );
		$where = 'rabfull.thang 		= "'.$getdata->thang.'"
				AND rabfull.kdprogram 	= "'.$getdata->kdprogram.'"
				AND rabfull.kdgiat 		= "'.$getdata->kdgiat.'"
				AND rabfull.kdoutput 	= "'.$getdata->kdoutput.'"
				AND rabfull.kdsoutput	= "'.$getdata->kdsoutput.'"
				AND rabfull.kdkmpnen 	= "'.$getdata->kdkmpnen.'"
				AND rabfull.kdskmpnen 	= "'.$getdata->kdskmpnen.'"
				AND rabfull.penerima 	= "'.$getdata->penerima.'"
				AND rabfull.npwp 		= "'.$getdata->npwp.'"
		';
		// $group = ' ';
		$dataArray['url_rewrite'] = $url_rewrite;

	    $datatable->get_table_join($get_table,$get_table2, $key, $column, $on, $where, $group, $dataArray);
		break;
}
?>
