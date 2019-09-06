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
    case 'get_notifs':
        getSMS();
    break;
    default:
    echo 'no action';
}

function getSMS(){
    #get List of users and their meta: 

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/apipge/?daction=userwatchlist');
    curl_setopt($curl, CURLOPT_RESOLVE, ['arbitrage.ph:443:34.92.99.210']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $usersmeta = curl_exec($curl);
    curl_close($curl);
    echo $usersmeta;
}


?>    