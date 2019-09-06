<?php
	/*
	* Template Name: WatchList API Page
	* Template page for Watchlist Page Platform
    */
    
	header('Content-Type: application/json');
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require(getcwd().'/wp-load.php');

    date_default_timezone_set("Asia/Manila");
    

$action = $_GET['action'];

switch($action){
    case 'getSMS':
    break;
    default:
    echo 'no action';
}

function getSMS(){
echo 'get SMS';
}



?>    