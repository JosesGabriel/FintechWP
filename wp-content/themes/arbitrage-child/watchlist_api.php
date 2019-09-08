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

   /* $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/apipge/?daction=userwatchlist');
    curl_setopt($curl, CURLOPT_RESOLVE, ['arbitrage.ph:443:34.92.99.210']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $usersmeta = curl_exec($curl);
    curl_close($curl);
    echo $usersmeta; */

    global $wpdb;
    $users = get_users( array( 'fields' => array( 'ID' ) ) );
    $result = array();
    array_push($result,$users);
    foreach($users as $user_id){
        #get user meta per ID
        $usermetas = get_user_meta($user_id->ID, '_watchlist_instrumental', true);
        $userphone = get_user_meta($user_id->ID, 'cpnum', true);
        #do not even do anything if the user does not have cpnum:
        if(!is_null($userphone)){    
            
            //array_push($result,$userphone);
            foreach($usermetas as $usermeta){
                #get stock name and stock values for comparison
                $stockname = $usermeta['stockname'];
                $entryprice = $usermeta['dconnumber_entry_price'];
                $takeprofitpoint = $usermeta['dconnumber_take_profit_point'];
                $stoplosspoint = $usermeta['dconnumber_stop_loss_point'];

                #get PSE data
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=".$stockname);
                curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($curl);
                curl_close($curl);

                $dstock = json_decode($response);
                $dstock = $dstock->data;
                
                $last_price = $dstock->last;
                //echo 'Stockname: ' . $stockname . " Last: " . $last_price . " <br>";
                #start comparing :

                #sample JSON data:
                $userlist = array("1","2","3");
                $jsonoutput = [];
              
            }
            $output = json_encode($result);
            echo $output;
        }

    }

    

}


?>    