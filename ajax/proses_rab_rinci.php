<?php
include '../config/application.php';

		$rabview_id = $_GET['id_rab_view'];
	    $table = "rabfull";
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
	      array( 'db' => 'value', 'dt' => 7),
	      array( 'db' => 'status',  'dt' => 8, 'formatter' => function($d,$row){ 
	        if($d==0 && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="content/rab/add-rincian/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i> Add Akun</a>'.
	                  '</div>';
	        }elseif ($d==0 && $_SESSION['level'] == 0) {
	          return  '<div class="text-center ">'.
	                    '<a style="margin:0 2px;" id="btn-trans" href="content/rab/add-rincian/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i> View Akun</a>'.
	                  '</div>';
	        }
	      }),
	    );
		$where = 'rabview_id = "'.$rabview_id.'"';
	    $datatable->get_table($table, $key, $column,$where);
?>
