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
	case 'save_edit_penerima':
		$id_rab_view = $_POST['id_rab_view'];
		$getview = $mdl_rab->getview($id_rab_view);
		$id_rab_full = $_POST['id_rab_full'];
        $getrab = $mdl_rab->getrabfull($id_rab_full);
		// print_r($getview);die;
		$mdl_rab->save_edit_penerima($id_rab_view, $getview, $_POST, $getrab);
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
                 '<tr><td>Status PNS</td><td> :&nbsp;</td><td>'.$pns.'</td></tr>'.
                 '<tr><td>Golongan</td><td> :&nbsp;</td><td>'.$gol.'</td></tr>'.
                 '<tr><td>Jabatan</td><td> :&nbsp;</td><td>'.$jab.'</td></tr>'.
                 '<tr><td>Besar Pajak</td><td> :&nbsp;</td><td>'.$row[14].' %</td></tr></table>';
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
	      	return 'Rp '.number_format($d,2,',','.');
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
	        elseif($d==9){
	          return '<i>Dibatalkan (Adendum)</i>';
	        }
	      }),
	      array( 'db' => 'status',  'dt' => 6, 'formatter' => function($d,$row, $dataArray){ 
	      	$button =  '<div class="text-center btn-group-vertical">';
	      	if ($_SESSION['level'] == 0) {
	      		$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-list"></i>&nbsp; Lihat Akun</a>';
	      		// if ($d == 2 || $d == 5 || $d == 4) {
	      		// 	$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."pdf".'" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (PDF)</a>';
	      		// 	$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."word".'" class="btn btn-flat btn-info btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (Word)</a>';
	      		// }
	      	}else{
	      		if ($d == 0 || $d == 3 || $d == 5) {
	      			$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Tambah Akun</a>';
	      		}else{
	      			$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabakun/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Lihat Akun</a>';
	      		}
	      		if ($d == 2 || ($d == 5 && $row[3] != "") || $d == 4 || $d == 6 || $d == 8 || $d == 9) {
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."pdf".'" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (PDF)</a>';
	      			$button .=  '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'process/report/cetak_dok/'.$row[0]."-".$row[1]."-"."word".'" class="btn btn-flat btn-info btn-sm"><i class="fa fa-file"></i>&nbsp; Kuitansi (Word)</a>';
		        }
		        if ($d == 0 || $d == 2 || $d == 3 || $d == 5) {
	      			$button .= '<a style="margin:0 2px;" id="btn-trans" href="'.$dataArray['url_rewrite'].'content/rabdetail/'.$row[0].'/edit" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit Orang/Badan</a>';
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
		  						'<a style="margin:0 2px;" id="btn-batal-adn" href="#batal" class="btn btn-flat btn-danger btn-sm" data-toggle="modal"><i class="fa fa-close"></i> Batal</a>'.
		  						'</div>';
		  		}else{
		  			$button = '<center>-</center>';
		  		}
		  	}elseif ($_SESSION['level'] == 2) {
		  		if ($row[7] != "" && ($d == 2 || $d == 8)) {
		  			$button =  '<div class="text-center btn-group-vertical">'.
		  						'<a style="margin:0 2px;" id="btn-sah" href="#sahkan" class="btn btn-flat btn-success btn-sm" data-toggle="modal"><i class="fa fa-check"></i> Sahkan</a>'.
		  						'</div>';
		  		}elseif ($row[7] != "" && ($d == 5 || $d == 9)) {
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
	      array( 'db' => 'pajak', 'dt' => 14),
	    );
		$where = 'rabview_id = "'.$rabview_id.'"';
		$group = 'npwp, penerima, pns, golongan';

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
	case 'batalAkun':
		if (isset($_POST)) {
			$status = $_POST['status'];
			$id_rabfull = $_POST['id_rabfull'];
			$id_rab_view = $_POST['id_rab_view'];
			$getrab = $mdl_rab->getrabfull($id_rabfull);

			$mdl_rab->chStatusFullOrang($getrab,$status);

	    	$utility->load("content/rabdetail/".$id_rab_view."/detail","success","Data telah dibatalkan");
		}else{
			$utility->location_goto(".");
		}
		break;
	case 'tambahAkun':
		$id_rabfull = $_POST['id_rabfull'];
		$akun = $_POST['kdakun'];	    
		$noitem = $_POST['noitem'];	    
		if ($akun == '524119') {
			$taxi_asal    = str_replace(".", "", $_POST['taxi_asal'][0]);
	        $taxi_tujuan  = str_replace(".", "", $_POST['taxi_tujuan'][0]);
	        $harga_tiket  = str_replace(".", "", $_POST['harga_tiket'][0]);
	        $uang_harian  = str_replace(".", "", $_POST['uang_harian'][0]);
	        $lama_hari    = $_POST['lama_hari'][0];
          	$biaya_akom   = str_replace(".", "", $data['biaya_akom'][$i]);
	        $value  	  = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari) + $biaya_akom;
		}else{
			$value = $_POST['value'];
			$value = str_replace(".", "", $value);
		}

		$getrab = $mdl_rab->getrabfull($id_rabfull);
		$error = false;
		$status = $getrab['status'];

	    if ($akun == 521211) {  //belanja bahan
	        $jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun, $noitem);
	        $sisa = $jum_rkakl['jumlah'] - ($jum_rkakl['realisasi'] + $jum_rkakl['usulan']);
	        if ($sisa < $value) {
	            $error = '1';
	            $kderror = $akun;
	        }
	    }elseif($akun != ""){  // bukan belanja bahan
	        $jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun);
	        $sisa = $jum_rkakl['jumlah'] - ($jum_rkakl['realisasi'] + $jum_rkakl['usulan']);
	        if ($sisa < $value) {
	            $error = '1';
	            $kderror = $akun;
	        }
	    }else{  //kode akun kosong
	        $error = '2';
	        $kderror = $akun;
	    }

	    if (!$error) {
	        if ($akun == '521211') {  //belanja bahan
	        	$jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun, $noitem);
	            if ($status == 0) {
		        	$total = $jum_rkakl['usulan'] + $value;
		            $mdl_rab->insertUsulan($getrab, $akun, $noitem, $total);
	        	}else{
		        	$total = $jum_rkakl['realisasi'] + $value;
		            $mdl_rab->insertRealisasi($getrab, $akun, $noitem, $total);
	        	}
	        }elseif($akun != ""){  // bukan belanja bahan
	          	$jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun);
	          	if ($status == 0) {
		        	$totalusul = $jum_rkakl['usulan'] + $value;
	          	}else{
		        	$totalusul = $jum_rkakl['realisasi'] + $value;
	          	}
		        $itemgroup = $jum_rkakl['itemgroup'];
		        $pecah_item = explode(",", $itemgroup);
		        $banyakitem = count($pecah_item);

		        $totalperitem = floor($totalusul/$banyakitem);
		        $sisaitem = $totalusul % $banyakitem;

	          for ($x=0; $x < $banyakitem; $x++) { 
	            if ($sisaitem == 0) {
	            	if ($status == 0) {
	            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
	            	}else{
	            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
	            	}
	            }else{
	            	if ($x == ($banyakitem-1)) {
		                $totalperitem = $totalperitem + $sisaitem;
		                if ($status == 0) {
		            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}else{
		            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}
		            }else{
		                if ($status == 0) {
		            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}else{
		            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}
		            }
	            }
	          }
	        }

			if ($akun == '524119') {
				$insert = $mdl_rab->tambahAkunPerjalanan($_POST);
			}else{
				$insert = $mdl_rab->tambahAkun($_POST);
			}
    		$utility->load("content/rabakun/".$id_rabfull,"success","Data berhasil dimasukkan ke dalam database");
	    }else{
	      if ($error == 1) {
	        $utility->load("content/rabakun/".$id_rabfull,"warning","Proses tidak dilanjutkan. Kode Akun ".$kderror." melebihi Pagu");
	      }else{
	        $utility->load("content/rabakun/".$id_rabfull,"error","Proses tidak dilanjutkan. Terdapat kode akun yang kosong");
	      }
	    }
		break;
	case 'editAkun':
		$id_rabfull = $_POST['id_rabfull'];
		$akun = $_POST['kdakun'];	    
		$noitem = $_POST['noitem'];	
		if ($akun == '524119') {
			$taxi_asal    = str_replace(".", "", $_POST['taxi_asal'][0]);
	        $taxi_tujuan  = str_replace(".", "", $_POST['taxi_tujuan'][0]);
	        $harga_tiket  = str_replace(".", "", $_POST['harga_tiket'][0]);
	        $uang_harian  = str_replace(".", "", $_POST['uang_harian'][0]);
	        $lama_hari    = $_POST['lama_hari'][0];
          	$biaya_akom   = str_replace(".", "", $data['biaya_akom'][$i]);
	        $value_baru   = $taxi_asal + $taxi_tujuan + $harga_tiket + ($uang_harian * $lama_hari) + $biaya_akom;
		}else{
			$value_baru = $_POST['value'];
			$value_baru = str_replace(".", "", $value_baru);
		}

		$getrab = $mdl_rab->getrabfull($id_rabfull);
		$value_lama = $getrab['value'];
		$status = $getrab['status'];

		$error = false;

	    if ($akun == 521211) {  //belanja bahan
	        $jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun, $noitem);
	        $sisa = $jum_rkakl['jumlah'] - (($jum_rkakl['realisasi'] + $jum_rkakl['usulan']) - $value_lama);
	        if ($sisa < $value_baru) {
	            $error = '1';
	            $kderror = $akun;
	        }
	    }elseif($akun != ""){  // bukan belanja bahan
	        $jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun);
	        $sisa = $jum_rkakl['jumlah'] - (($jum_rkakl['realisasi'] + $jum_rkakl['usulan']) - $value_lama);
	        if ($sisa < $value_baru) {
	            $error = '1';
	            $kderror = $akun;
	        }
	    }else{  //kode akun kosong
	        $error = '2';
	        $kderror = $akun;
	    }

	    if (!$error) {
	        if ($akun == '521211') {  //belanja bahan
	        	$jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun, $noitem);
	        	if ($status == 0) {
		        	$usulan_baru = $jum_rkakl['usulan'] - $value_lama;
		        	$total = $usulan_baru + $value_baru;
		            $mdl_rab->insertUsulan($getrab, $akun, $noitem, $total);
	        	}else{
		        	$realisasi_baru = $jum_rkakl['realisasi'] - $value_lama;
		        	$total = $realisasi_baru + $value_baru;
		            $mdl_rab->insertRealisasi($getrab, $akun, $noitem, $total);
	        	}
	        }elseif($akun != ""){  // bukan belanja bahan
	          	$jum_rkakl = $mdl_rab->getJumlahRkakl($getrab, $akun);
	          	if ($status == 0) {
		        	$usulan_baru = $jum_rkakl['usulan'] - $value_lama;
			        $totalusul = $usulan_baru + $value_baru;
	          	}else{
		        	$realisasi_baru = $jum_rkakl['realisasi'] - $value_lama;
			        $totalusul = $realisasi_baru + $value_baru;
	          	}
		        $itemgroup = $jum_rkakl['itemgroup'];
		        $pecah_item = explode(",", $itemgroup);
		        $banyakitem = count($pecah_item);

		        $totalperitem = floor($totalusul/$banyakitem);
		        $sisaitem = $totalusul % $banyakitem;

	          for ($x=0; $x < $banyakitem; $x++) { 
	            if ($sisaitem == 0) {
	            	if ($status == 0) {
	            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
	            	}else{
	            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
	            	}
	            }else{
	                if ($x == ($banyakitem-1)) {
		                $totalperitem = $totalperitem + $sisaitem;
		                if ($status == 0) {
		            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}else{
		            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}
	                }else{
		                if ($status == 0) {
		            		$mdl_rab->insertUsulan($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}else{
		            		$mdl_rab->insertRealisasi($getrab, $akun, $pecah_item[$x], $totalperitem);
		            	}
	                }
	            }
	          }
	        }

			if ($akun == '524119') {
				$insert = $mdl_rab->editAkunPerjalanan($_POST);
			}else{
				$insert = $mdl_rab->editAkun($_POST);
			}
    		$utility->load("content/rabakun/".$id_rabfull,"success","Data berhasil dimasukkan ke dalam database");
	    }else{
	      if ($error == 1) {
	        $utility->load("content/rabakun/edit/".$id_rabfull,"warning","Proses tidak dilanjutkan. Kode Akun ".$kderror." melebihi Pagu");
	      }else{
	        $utility->load("content/rabakun/edit/".$id_rabfull,"error","Proses tidak dilanjutkan. Terdapat kode akun yang kosong");
	      }
	    }
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
                 '<tr><td>No Item</td><td> :&nbsp;</td><td>'.$row[6].'</td></tr></table>';
	      }),
	      array( 'db' => 'rkakl_full.NMAKUN',  'dt' => 2),
	      array( 'db' => 'rabfull.value', 'dt' => 3, 'formatter' => function($d,$row,$dataArray){
	      	return 'Rp '.number_format($d,2);
	      }),
	      array( 'db' => 'rabfull.kdakun', 'dt' => 4, 'formatter' => function($d,$row,$dataArray){
	      	if ($d == '524119') {
	      		return '<table><tr><td>Rute</td><td> :&nbsp;</td><td>'.$row[7].'</td></tr>'.
                 		'<tr><td>Tiket</td><td> :&nbsp;</td><td>Rp '.number_format($row[8],2,",",".").'</td></tr>'.
                 		'<tr><td>Taxi Asal</td><td> :&nbsp;</td><td>Rp '.number_format($row[9],2,",",".").'</td></tr>'.
                 		'<tr><td>Taxi Tujuan</td><td> :&nbsp;</td><td>Rp '.number_format($row[10],2,",",".").'</td></tr>'.
                 		'<tr><td>Lama Hari</td><td> :&nbsp;</td><td>'.$row[11].'</td></tr>'.
                 		'<tr><td>Uang Harian</td><td> :&nbsp;</td><td>Rp '.number_format($row[12],2,",",".").'</td></tr>'.
                 		'<tr><td>Akomodasi</td><td> :&nbsp;</td><td>Rp '.number_format($row[13],2,",",".").'</td></tr></table>';
	      	}elseif($d == '521211'){
	      		return '<table><tr><td>PPN</td><td> :&nbsp;</td><td>'.$row[14].' %</td></tr></table>';
	      	}else{
	      		return '-';
	      	}
	      }),
	      array( 'db' => 'rabfull.status',  'dt' => 5, 'formatter' => function($d,$row,$dataArray){ 
	        if(($d==0 || $d==3 || $d==5) && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-detail" href="'.$dataArray['url_rewrite'].'content/rabakun/detail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
	                    '<a style="margin:0 2px;" id="btn-edit" href="'.$dataArray['url_rewrite'].'content/rabakun/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>'.
	                    '<a style="margin:0 2px;" id="btn-del" href="#delrab" data-toggle="modal" class="btn btn-flat btn-danger btn-sm" ><i class="fa fa-close"></i>&nbsp; Delete</a>'.
	                  '</div>';
	        }elseif($d==2 && $_SESSION['level'] != 0){
	          return  '<div class="text-center">'.
	                    '<a style="margin:0 2px;" id="btn-detail" href="'.$dataArray['url_rewrite'].'content/rabakun/detail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
	                    '<a style="margin:0 2px;" id="btn-edit" href="'.$dataArray['url_rewrite'].'content/rabakun/edit/'.$row[0].'" class="btn btn-flat btn-warning btn-sm" ><i class="fa fa-pencil"></i>&nbsp; Edit</a>'.
	                  '</div>';
	        }else{
	        	return  '<div class="text-center">'.
		                    '<a style="margin:0 2px;" id="btn-detail" href="'.$dataArray['url_rewrite'].'content/rabakun/detail/'.$row[0].'" class="btn btn-flat btn-primary btn-sm" ><i class="fa fa-list"></i>&nbsp; Detail</a>'.
		                '</div>';
	        }
	      }),
	      array( 'db' => 'rabfull.noitem', 'dt' => 6),
	      array( 'db' => 'rabfull.rute', 'dt' => 7),
	      array( 'db' => 'rabfull.harga_tiket', 'dt' => 8),
	      array( 'db' => 'rabfull.taxi_asal', 'dt' => 9),
	      array( 'db' => 'rabfull.taxi_tujuan', 'dt' => 10),
	      array( 'db' => 'rabfull.lama_hari', 'dt' => 11),
	      array( 'db' => 'rabfull.uang_harian', 'dt' => 12),
	      array( 'db' => 'rabfull.biaya_akom', 'dt' => 13),
	      array( 'db' => 'rabfull.ppn', 'dt' => 14),
	    );
		$where = 'rabfull.rabview_id 	= "'.$getdata['rabview_id'].'"
				AND rabfull.thang 		= "'.$getdata['thang'].'"
				AND rabfull.kdprogram 	= "'.$getdata['kdprogram'].'"
				AND rabfull.kdgiat 		= "'.trim($getdata['kdgiat'],"\x0D\x0A").'"
				AND rabfull.kdoutput 	= "'.trim($getdata['kdoutput'],"\x0D\x0A").'"
				AND rabfull.kdsoutput	= "'.trim($getdata['kdsoutput'],"\x0D\x0A").'"
				AND rabfull.kdkmpnen 	= "'.trim($getdata['kdkmpnen'],"\x0D\x0A").'"
				AND rabfull.kdskmpnen 	= "'.$getdata['kdskmpnen'].'"
				AND rabfull.penerima 	= "'.$getdata['penerima'].'"
				AND rabfull.npwp 		= "'.$getdata['npwp'].'" ';
		// $group = ' ';
		$dataArray['url_rewrite'] = $url_rewrite;

	    $datatable->get_table_join($get_table,$get_table2, $key, $column, $on, $where, $group, $dataArray);
		break;
	case 'hitung_pagu':
		$getrab = $mdl_rab->getrabfull($_POST['id_rabfull']);
		$mdl_rab->hitung_dipa($getrab,$_POST['kdAkun'],$_POST['noitem']);
		break;
	case 'cekDinas':
		$id_rabfull = $_POST['id_rabfull'];
		$kdakun = $_POST['kdAkun'];
		$getrab = $mdl_rab->getrabfull($id_rabfull);
		$getakun = $mdl_rab->getakungroup($getrab);
		// print_r($getakun);die;
		$data['kodeakun'] = count($getakun);
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
					} else if ($getakun[0]->banyak >= 4){
						$data['error'] = '6';
					}
				}
			}
		}
		echo json_encode($data);
		break;
	case 'delrab':
		$id_rabfull = $_POST['id_rab_del'];
		$getrabfull = $mdl_rab->getrabfull($id_rabfull);
		$getidrab = $mdl_rab->getminrabid($getrabfull);
		if ($getidrab->banyak > 1) {
			$mdl_rab->delrabdetail($id_rabfull);
		}else{
			$mdl_rab->delrabakun($id_rabfull);
		}
    	$utility->load("content/rabakun/".$getidrab->id,"success","Data berhasil dihapus");
		break;
	case 'importrab':
		$id_rab_view = $purifier->purify($_POST['id_rab_view']);
	    $status = $purifier->purify($_POST['adendum']);
	    $jenisimport = $purifier->purify($_POST['jenisimport']);
	    if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
	        $path = $_FILES['fileimport']['name'];
	        $ext = pathinfo($path, PATHINFO_EXTENSION);
	        if($ext != 'xls' && $ext != 'xlsx') {
	          $utility->load("content/rabdetail/".$id_rab_view."/add/".$status,"error","Jenis file yang di upload tidak sesuai");
	        }
	        else {
	          $time = time();
	          $target_dir = $path_upload;
	          $target_name = basename(date("Ymd-His-\R\A\B.",$time).$ext);
	          $target_file = $target_dir . $target_name;
	          $response = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
	          if($response) {
	            try {
	              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
	            }
	            catch(Exception $e) {
	              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
	            }
	            $array = array('id_rab_view' => $id_rab_view,
	            				'status' 	 => $status,
	            				'jenis'		 => $jenisimport
	            				);
	            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
	            // echo "<pre>";
	            // print_r($allDataInSheet);die;
	            $data = $mdl_rab->importRab($array,$allDataInSheet);
	            echo "<pre>"; print_r($data);die;
	            $utility->load("content/rabdetail/".$id_rab_view."/upload",'success','Telah Berhasil Diupload');
	          }
	        }
	      }
	      else {
	        $utility->load("content/rkakl","warning","Belum ada file Excel yang di lampirkan");
	      }
	    die();
    	break;
    case 'downloadRab':
		$excel2 = PHPExcel_IOFactory::createReader('Excel5');
		$excel2 = $excel2->load($path_download.'importRAB.xls'); // Empty Sheet
		// $excel2->setActiveSheetIndex();
		// $excel2->getActiveSheet()->setCellValue('C6', '4');
		// ->setCellValue('C6', '4')
		//     ->setCellValue('C7', '5')
		//     ->setCellValue('C8', '6')       
		//     ->setCellValue('C9', '7');
		// print_r($excel2);die;

		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel5');
		header("Content-type: text/xls");
		header("Cache-Control: no-store, no-cache");
		header('Content-Disposition: attachment; filename="importRAB.xls"');
		$objWriter->save('php://output','w');
    	break;
	default:
		$utility->location_goto(".");
		break;
}
?>
