<?php 
require_once __DIR__ . '/../config/config.php';

class datatable extends config {
    function get_rkakl_view($table, $primaryKey, $columns){
        $config = new config();
        $sql_details = $config->sql_details();
        require( 'ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns)
        );        
    }
    function get_table($table, $primaryKey, $columns, $where, $dataArray){
        $config = new config();
        $sql_details = $config->sql_details();
        require( 'ssp.class.php' );
        echo json_encode(
            SSP::simplewhere( $_POST, $sql_details, $table, $primaryKey, $columns, $where, $dataArray)
        );        
    }
    function get_table_group($table, $primaryKey, $columns, $where, $group, $dataArray){
        $config = new config();
        $sql_details = $config->sql_details();
        require( 'ssp.class.php' );
        echo json_encode(
            SSP::simplewheregroup( $_POST, $sql_details, $table, $primaryKey, $columns, $where,$group, $dataArray)
        );        
    }
    function get_table_join($table,$table2, $primaryKey, $columns, $on, $where, $group, $dataArray){
        $config = new config();
        $sql_details = $config->sql_details();
        require( 'ssp.class.php' );
        echo json_encode(
            SSP::complexjoin( $_POST, $sql_details, $table, $table2, $primaryKey, $columns, $on, $where, $group, $dataArray)
        );        
    }
}
