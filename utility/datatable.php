<?php 
require_once __DIR__ . '/../config/config.php';

class datatable extends config {
    function get_table($tabel, $kunci, $kolom, $dimana){
        $table = $tabel;
        $primaryKey = $kunci;
        $columns = $kolom;
        $where = $dimana;
        $config = new config();
        $sql_details = $config->sql_details();
        require( 'ssp.class.php' );
        echo json_encode(
            SSP::simplewhere( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
        );        
    }
}
