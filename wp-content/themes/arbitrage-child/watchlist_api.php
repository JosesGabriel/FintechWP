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
    curl_setopt($curl, CURLOPT_URL, '/apipge/?daction=userwatchlist');
    curl_setopt($curl, CURLOPT_RESOLVE, ['arbitrage.ph:443:34.92.99.210']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $usersmeta = curl_exec($curl);
    curl_close($curl);
    echo $usersmeta; */

    global $wpdb;
    $users = get_users( array( 'fields' => array( 'ID', 'user_email' ) ) );
    $result = [];
    
    foreach($users as $user_id){
        #get user meta per ID
        $usermetas = get_user_meta($user_id->ID, '_watchlist_instrumental', true);
        $userphone = get_user_meta($user_id->ID, 'cpnum', true);
        $useremail = $user_id->user_email;
        #do not include users whow do not have watchlist items
        if(!empty($usermetas)){
            #do not even do anything if the user does not have cpnum:
            if(!empty($userphone)){    
                $userdata = [];
                $userdata["ID"] = $user_id->ID;
                $userdata["Phone"] = $userphone;
                $userdata["Email"] = $useremail;
                $userdata["Stocks"] = [];
                foreach($usermetas as $usermeta){
                    if($usermeta['stockname'] != null){
                    $stockdata = [];
                    #get stock name and stock values for comparison
                    $stockname = $usermeta['stockname'];
                    $stockdata["Stock"] = $stockname;
                    #get PSE data
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=".$stockname);
                    
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $dstock = json_decode($response);
                    $dstock = $dstock->data;
                    $last_price = floatval($dstock->last);
                    #start comparing :

                    #entry price 
                    
                    if(!empty($usermeta['dconnumber_entry_price'])){
                        $entryprice = floatval($usermeta['dconnumber_entry_price']);
                        if($last_price == $entryprice){
                            #add data and message to array
                            #$stockdata["EntryMessage"] = 'From Arbitrage: Buy Now! ' . $stockname . ' Current price is now Php ' . $last_price;
                            $stockdata["EntryMessage"] = 'Alerts from Arbitrage: Your entry price for ' . $stockname . ' has been hit. ' . $stockname . ' price is now Php ' . $last_price . '. Buy now!';
                        }else{
                            $stockdata["EntryMessage"] = "";
                        }
                    }
                    #stop loss point
                    //$stockdata["StopLoss Message"] = '';
                    if(!empty($usermeta['dconnumber_take_profit_point'])){
                        $stoplosspoint = floatval($usermeta['dconnumber_stop_loss_point']);
                        if($last_price < $stoplosspoint){
                            #add data and message to array
                            #$stockdata["StopLossMessage"] = 'From Arbitrage: Sell Now and Stop your Loss! ' . $stockname . ' Current price is now Php ' . $last_price;
                            $stockdata["StopLossMessage"] = 'Alerts from Arbitrage: Your stop loss point for ' . $stockname . ' has been hit. ' . $stockname . ' price is now Php ' . $last_price . '. Cut your losses now!';
                        }else{
                            $stockdata["StopLossMessage"] = "";
                        }
                    }
                    #take profit point
                   // $stockdata["TakeProfit Message"] = '';
                    if(!empty($usermeta['dconnumber_stop_loss_point'])){
                        $takeprofitpoint = floatval($usermeta['dconnumber_take_profit_point']);
                        if($last_price > $takeprofitpoint){
                            #add data and message to array
                            #$stockdata["TakeProfitMessage"] = 'From Arbitrage: Sell Now and Secure your Profit! ' . $stockname . ' Current price is now Php ' . $last_price;
                            $stockdata["TakeProfitMessage"] = 'Alerts from Arbitrage: Your take profit point for ' . $stockname . ' has been hit. ' . $stockname . ' price is now Php ' . $last_price . '. Secure your profits now!';
                        }else{
                            $stockdata["TakeProfitMessage"] = "";
                        }
                    }
                    #push stockdata to userdata
                    array_push($userdata["Stocks"],$stockdata);
                    }
                }
                #push userdata to array
                array_push($result,$userdata);
                #gwapo ko ambot lng
            }
        }
    }

    $output = json_encode($result);
    echo $output; 

}


?>    