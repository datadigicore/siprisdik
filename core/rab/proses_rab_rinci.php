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

		// $kwitansi = $mdl_rab->getKwitansi($rabview_id);
		$a='a';
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
	      array( 'db' => 'kdakun', 'dt' => 6),
	      array( 'db' => 'value', 'dt' => 7, 'formatter' => function($d,$row){ 
	      	return number_format($d,2);

	      }),
	      array( 'db' => 'status',  'dt' => 8, 'formatter' => function($d,$row){ 
	        if($d==0 && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Add Akun</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-file"></i>&nbsp; Cetak Kwitansi</a>'.
	                  '</div>';
	        }elseif ($d==0 && $_SESSION['level'] == 0) {
	          return  '<div class="text-center btn-group-vertical">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; View Akun</a>'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/report/Kuitansi_Honorarium/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-file"></i>&nbsp; Cetak Kwitansi</a>'.
	                  '</div>';
	        }
	      }),
		  array( 'db' => 'status', 'dt' => 9, 'formatter' => function($d,$row){
		  	return '<select class="form-control" id="kwit">'.
		  			'<option>1</option>'.
		  			'<select>';
		  }),
		  array('db' => 'status', 'dt'=>10, 'formatter' => function($d,$row){
		  	  return  '<div class="text-center btn-group-vertical">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="http://localhost/siprisdik/process/sahkanAkun/'.$row[0].'" class="btn btn-flat btn-success btn-sm"><i class="fa fa-check"></i>&nbsp; Sahkan</a>'.
	                  '</div>';
		  })
	    );
		$where = 'rabview_id = "'.$rabview_id.'"';
		$group = 'npwp';

	    $datatable->get_table_group($get_table, $key, $column,$where, $group);
	    break;
}
?>
