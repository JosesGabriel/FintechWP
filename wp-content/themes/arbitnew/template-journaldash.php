<?php
    /*
    * Template Name: Journal Design
    */

// get_header();
// Ralph Was Here 
// Trading Journal
global $current_user, $wpdb;
$user = wp_get_current_user();
date_default_timezone_set('Asia/Manila');

function getjurfees($funmarketval, $funtype)
{
	// Commissions
	$dpartcommission = $funmarketval * 0.0025;
	$dcommission = ($dpartcommission > 20 ? $dpartcommission : 20);
	// TAX
	$dtax = $dcommission * 0.12;
	// Transfer Fee
	$dtransferfee = $funmarketval * 0.00005;
	// SCCP
	$dsccp = $funmarketval * 0.0001;
	$dsell = $funmarketval * 0.006;

	if ($funtype == 'buy') {
		$dall = $dcommission + $dtax + $dtransferfee + $dsccp;
	} else {
		$dall = $dcommission + $dtax + $dtransferfee + $dsccp + $dsell;
	}

	return $dall;
}

// number formater
function number_format_short($n, $precision = 1)
{
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} elseif ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} elseif ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} elseif ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}

	if ($precision > 0) {
		$dotzero = '.'.str_repeat('0', $precision);
		$n_format = str_replace($dotzero, '', $n_format);
	}

	return $n_format.$suffix;
}
?>

<!-- BOF BUY trades -->
<?php
    if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Live') {

		$dledger = $wpdb->get_results('SELECT * FROM arby_ledger where userid = '.$user->ID);
	
		$buypower = 0;
		foreach ($dledger as $getbuykey => $getbuyvalue) {
			if ($getbuyvalue->trantype == 'deposit' || $getbuyvalue->trantype == 'selling') {
				$buypower = $buypower + $getbuyvalue->tranamount;
			} else {
				$buypower = $buypower - $getbuyvalue->tranamount;
			}
		}

		$stockquantity = str_replace(",", "", $_POST['inpt_data_qty']);
		$butstockprice = str_replace(",", "", $_POST['inpt_data_price']);

		$total_stocks_price = bcadd($stockquantity, $butstockprice);

		if ($total_stocks_price > $buypower) {
			wp_redirect('/journal');
			exit;
		}

        $tradeinfo = [];
        // $tradeinfo['buymonth'] = $_POST['inpt_data_buymonth'];
        // $tradeinfo['buyday'] = $_POST['inpt_data_buyday'];
		// $tradeinfo['buyyear'] = $_POST['inpt_data_buyyear'];

		$tradeinfo['buymonth'] = date('F', strtotime($_POST['newdate']));
        $tradeinfo['buyday'] = date('d', strtotime($_POST['newdate']));
		$tradeinfo['buyyear'] = date('Y', strtotime($_POST['newdate']));
		
		// $stocksinfo = json_decode(json_encode($_POST['inpt_data_stock']));
        $tradeinfo['stock'] = $_POST['inpt_data_stock'];
        
        // $_POST['inpt_data_price'] = $butstockprice;
		$tradeinfo['price'] = $butstockprice;
        // $_POST['inpt_data_qty'] = number_format($_POST['inpt_data_qty'],0);
        $tradeinfo['qty'] = $stockquantity;

        $tradeinfo['currprice'] = $_POST['dloglistinpt_data_currprice'];
        $tradeinfo['change'] = $_POST['inpt_data_change'];
        $tradeinfo['open'] = $_POST['inpt_data_open'];
        $tradeinfo['low'] = $_POST['inpt_data_low'];
        $tradeinfo['high'] = $_POST['inpt_data_high'];
        $tradeinfo['volume'] = $_POST['inpt_data_volume'];
        $tradeinfo['value'] = $_POST['inpt_data_value'];
        $tradeinfo['boardlot'] = $_POST['inpt_data_boardlot'];
        $tradeinfo['strategy'] = $_POST['inpt_data_strategy'];
        $tradeinfo['tradeplan'] = $_POST['inpt_data_tradeplan'];
        $tradeinfo['emotion'] = $_POST['inpt_data_emotion'];
        $tradeinfo['tradingnotes'] = $_POST['inpt_data_tradingnotes'];
		$tradeinfo['status'] = $_POST['inpt_data_status'];
		 
        $dlistofstocks = get_user_meta($user->ID, '_trade_list', true);
        if ($dlistofstocks && is_array($dlistofstocks) && in_array($_POST['inpt_data_stock'], $dlistofstocks)) {
            $dstocktraded = get_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock'], true);
            if ($dstocktraded && $dstocktraded != '') {
                array_push($dstocktraded['data'], $tradeinfo);
                $dstocktraded['totalstock'] = $dstocktraded['totalstock'] + $stockquantity;

                $totalprice = 0;
                $totalquanta = 0;
                foreach ($dstocktraded['data'] as $ddatakey => $ddatavalue) {
                    $dmarkvval = $ddatavalue['price'] * $ddatavalue['qty'];
                    $dfees = getjurfees($dmarkvval, 'buy');
                    $totalprice += $dmarkvval + $dfees;
                    $totalquanta += $ddatavalue['qty'];
                }
                $dstocktraded['aveprice'] = ($totalprice / $totalquanta);

                update_user_meta($user->ID, '_trade_'.$tradeinfo['stock'], $dstocktraded);
            }
        } else {
            $finaldata = [];
            $finaldata['data'] = [];
            array_push($finaldata['data'], $tradeinfo);
            $finaldata['totalstock'] = $stockquantity;
            $dmarkvval = $tradeinfo['price'] * $tradeinfo['qty'];
            $dfees = getjurfees($dmarkvval, 'buy');
            $finaldata['aveprice'] = ($dmarkvval + $dfees) / $tradeinfo['qty'];
            update_user_meta($user->ID, '_trade_'.$tradeinfo['stock'], $finaldata);

            if (!$dlistofstocks) {
                $djournstocks = array($tradeinfo['stock']);
            } else {
                $djournstocks = $dlistofstocks;
                array_push($djournstocks, $tradeinfo['stock']);
            }
            update_user_meta($user->ID, '_trade_list', $djournstocks);
        }
        $dtotalpurchse = $butstockprice * $stockquantity;
        echo $dtotalpurchse;

        $stockcost = ($butstockprice * $stockquantity);
        $purchasefee = getjurfees($stockcost, 'buy');

        $wpdb->insert('arby_ledger', array(
                'userid' => $user->ID,
                'date' => date('Y-m-d'),
                'trantype' => 'purchase',
                'tranamount' => $stockcost + $purchasefee, // ... and so on
            ));

        // wp_redirect( '/chart/'.$tradeinfo['stock'] );
        wp_redirect('/journal');
        exit;
    }
?>
<!-- EOF BUY trades -->

<!-- BOF Deposit -->
<?php
    if (isset($_POST['todelete'])) {

        //========================================
           $deletelogs = 'delete from arby_tradelog where tlid = '. $_POST['todelete'] .' and isuser ='.$user->ID;
           $wpdb->query($deletelogs);
           //wp_redirect('/journal');
           //exit; 
        //=========================================

        echo 'delete: '.$_POST['todelete'];
        $post = array('ID' => $_POST['todelete'], 'post_status' => 'draft');
        wp_update_post($post);
        wp_redirect("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
        exit;
    }
    if (isset($_POST['istype'])) {
		$dxammount = preg_replace("/[^0-9.]/", "", $_POST['damount']);
        if ($dxammount > 0) {
            $wpdb->insert('arby_ledger', array(
                'userid' => $user->ID,
                'date' => $_POST['ddate'],
                'trantype' => $_POST['istype'],
                'tranamount' =>  $dxammount// ... and so on
            ));
        }

        wp_redirect('/journal');
        exit;
    }




    //if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Edit') {

    if(isset($_POST['to_edit'])){
        //echo $_POST['inpt_data_status'];

        $log_id = $_POST['to_edit'];
        $strategy = $_POST['strategy_'. $log_id];
        $tradepan = $_POST['trade_plan_'. $log_id];
        $emotion = $_POST['emotion_'. $log_id];
        $notes = $_POST['tlnotes_'. $log_id];

         $updatelogs = "UPDATE arby_tradelog set tlstrats = '$strategy', tltradeplans = '$tradepan', tlemotions = '$emotion', tlnotes = '$notes'  where tlid = '$log_id' and isuser ='$user->ID'";
         $wpdb->query($updatelogs);


        $data_trade_info = array_search('data_trade_info', array_column($postmetas, 'meta_key'));

        update_post_meta($log_id,  'data_trade_info', $strategy);
       // update_post_meta($log_id,  'data_trade_info', $data_trade_info[0]->strategy, 'test');
               
        wp_redirect('/journal');
        exit;
    }



?>
<!-- EOF Deposit -->


<!-- BOF SELL trades -->
<?php
    if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Log') {
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

        $dstocktraded = get_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock'], true);
        $user_idd = $curuserid;
        $user_namee = $current_user->user_login;
		$data_postid = $_POST['inpt_data_postid'];
		
		$sellmonth = date('F', strtotime($_POST['selldate']));
		$sellday = date('d', strtotime($_POST['selldate']));
		$sellyear = date('Y', strtotime($_POST['selldate']));
		$selldayname = date('l', strtotime($_POST['selldate']));

		$toparsesell = parse_str($_POST['inpt_data_sellprice']);
		$sellprice = rtrim($toparsesell, ',');
		$sellqty = rtrim($_POST['inpt_data_qty'], ',');

		$pzemos = "";
		$pzplans = "";
		$pzstrats = "";
		$pznotes = "";

		if(isset($_POST['formsource']) && $_POST['formsource'] == "fromchart"){
			$buyyinginfo = unserialize(stripslashes($_POST['dtradelogs']));
			// $buyyinginfo['data'][0]['strategy'];

			$pzemos = $buyyinginfo['data'][0]['emotion'];;
			$pzplans = $buyyinginfo['data'][0]['tradeplan'];;
			$pzstrats = $buyyinginfo['data'][0]['strategy'];;
			$pznotes = $buyyinginfo['data'][0]['tradingnotes'];;
		} else {
			$buyyinginfo = json_decode(stripslashes($_POST['dtradelogs']));

			$pzemos = $buyyinginfo[0]->emotion;
			$pzplans = $buyyinginfo[0]->tradeplan;
			$pzstrats = $buyyinginfo[0]->strategy;
			$pznotes = $buyyinginfo[0]->tradingnotes;
		}


        $dstocktraded['totalstock'] = $dstocktraded['totalstock'] - $sellqty;
		
        if ($dstocktraded['totalstock'] <= 0) {
            $dlisroflive = get_user_meta($user->ID, '_trade_list', true);
            foreach ($dlisroflive as $rmkey => $rmvalue) {
                if ($rmvalue == $_POST['inpt_data_stock']) {
                    unset($dlisroflive[$rmkey]);
                    delete_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock']);
                }
            }
            update_user_meta($user->ID, '_trade_list', $dlisroflive);
        } else {
            // Update existing data.

            update_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock'], $dstocktraded);
        }

        $stockcost = ($sellprice * $sellqty);
        $purchasefee = getjurfees($stockcost, 'sell');

        $wpdb->insert('arby_ledger', array(
                'userid' => $user->ID,
                'date' => date('Y-m-d', strtotime($_POST['selldate'])),
                'trantype' => 'selling',
                'tranamount' => $stockcost - $purchasefee, // ... and so on
			));
		
		
		$inserttrade = "insert into arby_tradelog (tldate, tlvolume, tlaverageprice, tlsellprice, tlstrats, tltradeplans, tlemotions, tlnotes, isuser, isstock) values ('".$_POST['selldate']."','".$_POST['inpt_data_qty']."','".$_POST['inpt_avr_price']."','".$_POST['inpt_data_sellprice']."','".$pzstrats."','".$pzplans."','".$pzemos."','".$pznotes."', '".$user->ID."', '".$_POST['inpt_data_stock']."')";
		$wpdb->query($inserttrade);

        wp_redirect('/journal');
        exit;
	}
	
	if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'record') {

		$inserttrade = "insert into arby_tradelog (tldate, tlvolume, tlaverageprice, tlsellprice, tlstrats, tltradeplans, tlemotions, tlnotes, isuser, isstock) values ('".$_POST['solddate']."','".$_POST['inpt_data_qty_sold']."','".$_POST['inpt_data_price_bought']."','".$_POST['inpt_data_price_sold']."','".$_POST['inpt_data_strategy']."','".$_POST['inpt_data_tradeplan']."','".$_POST['inpt_data_emotion']."','".$_POST['inpt_data_tradingnotes']."', '".$user->ID."', '".$_POST['inpt_data_stock_sold']."')";
		$wpdb->query($inserttrade);
		
		wp_redirect('/journal');
        exit;

	}
?>
<!-- EOF SELL trades -->

<!-- BOF DELETE LIVE PORTFOLIO -->
<?php if(isset($_GET['todo']) && @$_GET['todo'] == 'deletelivetrade'){
	$getdstocks = get_user_meta($user->ID, '_trade_list', true);
	$isstock = @$_GET['stock'];
	$isprice = @$_GET['totalbase'];
	if (($key = array_search($isstock, $getdstocks)) !== false) {
		unset($getdstocks[$key]);
		$deletesql = 'delete from arby_usermeta where user_id = "'.$user->ID.'" and meta_key = "_trade_'.$isstock.'"';
		$wpdb->query($deletesql);

		$wpdb->insert('arby_ledger', array(
			'userid' => $user->ID,
			'date' => date('Y-m-d'),
			'trantype' => 'deleted_live',
			'tranamount' => $isprice, // ... and so on
		));
		update_user_meta($user->ID, '_trade_list', $getdstocks);

	}

	wp_redirect('/journal');
    exit;
	// print_r($getdstocks);

} ?>
<!-- EOF DELETE LIVE PORTFOLIO -->

<?php

require("journal/header-files.php");
require("parts/global-header.php");


?>


<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/journal_style.css?<?php echo time(); ?>">

<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

<?php
    $getdstocks = get_user_meta($user->ID, '_trade_list', true);

    $curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://dev-v1.arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
	
	curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$gerdqouteone = curl_exec($curl);
	
    curl_close($curl);

    $gerdqoute = json_decode($gerdqouteone);
	// $gerdqoute = [];
	
	// print_r($gerdqouteone);
?>
<!-- BOF get the tradelogs -->
<?php
    $author_query = array(
        'posts_per_page' => '-1',
        'post_status' => 'publish',
        'meta_key' => 'data_userid',
        'meta_value' => $user->ID,
    );
    $author_posts = new WP_Query($author_query);
?>
<!-- EOF get the tradelogs -->



<!-- BOF SORT DATA FOR JOURNAL -->
<?php
	
	$alltradelogs = [];
	
    if ($author_posts->have_posts()) {
        while ($author_posts->have_posts()) {
			$author_posts->the_post();

			$buysscounter++;
			$tradeid = get_the_ID();
			$postmetas = $wpdb->get_results( "select * from arby_postmeta where post_id = ".$tradeid);

			$tradeitems = [];
            $tradeitems['id'] = $tradeid;

			$data_sellmonth = array_search('data_sellmonth', array_column($postmetas, 'meta_key'));
			$tradeitems['data_sellmonth'] = $postmetas[$data_sellmonth]->meta_value;
			
			$data_sellday = array_search('data_sellday', array_column($postmetas, 'meta_key'));
			$tradeitems['data_sellday'] = $postmetas[$data_sellday]->meta_value;
			
			$data_sellyear = array_search('data_sellyear', array_column($postmetas, 'meta_key'));
            $tradeitems['data_sellyear'] = $postmetas[$data_sellyear]->meta_value;

			$data_stock = array_search('data_stock', array_column($postmetas, 'meta_key'));
			$tradeitems['data_stock'] = $postmetas[$data_stock]->meta_value;
			
			$data_dprice = array_search('data_dprice', array_column($postmetas, 'meta_key'));
            $tradeitems['data_dprice'] = $postmetas[$data_dprice]->meta_value;

			$data_sell_price = array_search('data_sell_price', array_column($postmetas, 'meta_key'));
			$tradeitems['data_sell_price'] = $postmetas[$data_sell_price]->meta_value;
			
			$data_quantity = array_search('data_quantity', array_column($postmetas, 'meta_key'));
            $tradeitems['data_quantity'] = $postmetas[$data_quantity]->meta_value;
            // $tradeitems['data_quantity'] = get_post_meta($tradeid, 'data_quantity', true);
			$data_avr_price = array_search('data_avr_price', array_column($postmetas, 'meta_key'));
			$data_avr_price = $postmetas[$data_avr_price]->meta_value;
			
			$data_trade_info = array_search('data_trade_info', array_column($postmetas, 'meta_key'));
            $dlistofinfo = json_decode($postmetas[$data_trade_info]->meta_value);

            $trade_plans = [];
            $strategy_plans = [];
            $emotions = [];
            foreach ($dlistofinfo as $key => $value) {
                array_push($trade_plans, $value->tradeplan);
                array_push($strategy_plans, $value->strategy);
                array_push($emotions, $value->emotion);
            }
            $tradeitems['trade_plans'] = $trade_plans;
            $tradeitems['strategy_plans'] = $strategy_plans;
            $tradeitems['emotions'] = $emotions;

            $tradeitems['data_trade_info'] = $dlistofinfo;
            $tradeitems['data_avr_price'] = $data_avr_price;

			array_push($alltradelogs, $tradeitems);
			
        }
        wp_reset_postdata();
    } else {
	}
	
	

    // Months
    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
?>
<!-- EOF SORT DATA FOR JOURNAL -->

<!-- BOF Sort LIVE Portfolio -->
<?php
$dtradeingfo = [];
$isjounalempty = false;



if ($getdstocks && $getdstocks != '') {
    
    foreach ($getdstocks as $dstockskey => $dstocksvalue) {
		$dstocktraded = get_user_meta($user->ID, '_trade_'.$dstocksvalue, true);
		$key = array_search($value, array_column($gerdqoute->data, 'symbol'));
		$stockdetails = $gerdqoute->data[$key];
        if ($dstocktraded && $dstocktraded != '') {
            // $dstockinfo = $gerdqoute->data->$dstocksvalue;
            $dstockinfo = $stockdetails;
            $marketval = $dstockinfo->last * $dstocktraded['totalstock'];
            $dsellfees = getjurfees($marketval, 'sell');
            $dtotal = $marketval - $dsellfees;

            $dstocktraded['totalcost'] = $dtotal;
            $dstocktraded['stockname'] = $dstocksvalue;
            array_push($dtradeingfo, $dstocktraded);
        }
    }
} else {
	$isjounalempty = true;
	
	

}

$issampledata = get_user_meta($user->ID, 'issampleactivated', true);
if($issampledata){
	$isjounalempty = false;
	// echo "no smaple";
} else {
	$isjounalempty = true;
	$getdstocks = ['Stock_1', 'Stock_2'];
	$dtradeingfo = [
		[
			'data' => [
				[
					'buymonth' => 'August',
					'buyday' => 22,
					'buyyear' => 2019,
					'stock' => 'MBT',
					'price' => 100,
					'qty' => 5,
					'currprice' => 75.40,
					'change' => '0.40%',
					'open' => 75.50,
					'low' => 75.20,
					'high' => 75.80,
					'volume' => '957.73K',
					'value' => '72.29m',
					'boardlot' => 10,
					'strategy' => 'Trend Following',
					'tradeplan' => 'Day Trade',
					'emotion' => 'this is a test',
					'tradingnotes' => 'Trading Notes',
					'status' => 'Live',
				],
			],
			'totalstock' => 1213228,
			'aveprice' => 2228.5209688868,
			'totalcost' => 84225991.13847,
			'stockname' => 'Stock_1',
		],
		[
			'data' => [
				[
					'buymonth' => 'August',
					'buyday' => 22,
					'buyyear' => 2019,
					'stock' => 'MBT',
					'price' => 100,
					'qty' => 5,
					'currprice' => 75.40,
					'change' => '0.40%',
					'open' => 75.50,
					'low' => 75.20,
					'high' => 75.80,
					'volume' => '957.73K',
					'value' => '72.29m',
					'boardlot' => 10,
					'strategy' => 'Trend Following',
					'tradeplan' => 'Day Trade',
					'emotion' => 'this is a test',
					'tradingnotes' => 'Trading Notes',
					'status' => 'Live',
				],
			],
			'totalstock' => 1213228,
			'aveprice' => 2228.5209688868,
			'totalcost' => 84225991.13847,
			'stockname' => 'Stock_2',
		]
	];
	// echo "with sample";
}

?>
<!-- EOF Sort LIVE Portfolio -->

<!-- BOF Trade Logs Data from DB -->
<?php
	$ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$user->ID.' order by tldate');

	$dailyvolumes = '';
	$dailyvalues = '';
	$dpercschart = '';
	$gplchart = '';
	$feeschart = '';
	$demotsonchart = '';
	$stratstrg = '';
	$wincharts = '';
	$formonthperc = '';
	$iswin = 0;
	$isloss = 0;
	$buysscounter = 0;

	$profits = [
		'mon' => 0,
		'tue' => 0,
		'wed' => 0,
		'thu' => 0,
		'fri' => 0,
	];

	$months = array(
		'jan' => 0,
		'feb' => 0,
		'mar' => 0,
		'apr' => 0,
		'may' => 0,
		'jun' => 0,
		'jul ' => 0,
		'aug' => 0,
		'sep' => 0,
		'oct' => 0,
		'nov' => 0,
		'dec' => 0
	);

	$profitsmonths = array(
		'jan' => 0,
		'feb' => 0,
		'mar' => 0,
		'apr' => 0,
		'may' => 0,
		'jun' => 0,
		'jul ' => 0,
		'aug' => 0,
		'sep' => 0,
		'oct' => 0,
		'nov' => 0,
		'dec' => 0
	);

	$tremo = [
		'Neutral' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0
		],
		'Greedy' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0
		],
		'Fearful' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0
		]
	];

	$allstocks = [];

	$strats = [
		'Bottom Picking' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0,
		],
		'Breakout Play' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0,
		],
		'Trend Following' => [
			'total_trades' => 0,
			'trwin' => 0,
			'trloss' => 0,
		],
	];

	$fees = [
		'commissions' => 0,
		'vat' => 0,
		'transfer' => 0,
		'sccp' => 0,
		'sell' => 0,
	];

	if(!empty($ismytrades)){
		foreach ($ismytrades as $key => $value) {
			$dailyvolumes .= '{';
			$dailyvolumes .= '"category": "'.$buysscounter.'",';
			$dailyvolumes .= '"column-1": '.($value->tlvolume != "" ? $value->tlvolume : 0).'';
			$dailyvolumes .= '},';
			
			$dailyvalues .= '{';
			$dailyvalues .= '"category": "'.$buysscounter.'",';
			$dailyvalues .= '"column-1": '.($value->tlsellprice != "" ? $value->tlsellprice : 0).'';
			$dailyvalues .= '},';

			$marketvals = $value->tlvolume * $value->tlaverageprice;
			$selltotal = $value->tlvolume * $value->tlsellprice;
			$sellvalue = $selltotal - getjurfees($selltotal, 'sell');
			$profit = $sellvalue - $marketvals;

			$istrdate = date('D', strtotime($value->tldate));
			$ismonthtrade = date('M', strtotime($value->tldate));

			$profits[strtolower($istrdate)] += $profit;
			$months[strtolower($ismonthtrade)] += getjurfees($selltotal, 'sell');

			$profitsmonths[strtolower($ismonthtrade)] += $profit;

			$gplchart .= '{';
			$gplchart .= '"category": "'.$buysscounter.'",';
			$gplchart .= '"column-1": "'.number_format($profit, 2, '.', '').'",';
			$gplchart .= '"column-2": "#673ab7"';
			$gplchart .= '},';
				
			
			if($profit > 0){
				$tremo[$value->tlemotions]['trwin']++;
				$strats[$value->tlstrats]['trwin']++;
				$iswin++;
			} else {
				$tremo[$value->tlemotions]['trloss'] ++;
				$strats[$value->tlstrats]['trloss'] ++;
				$isloss++;
			}
			$tremo[$value->tlemotions]['total_trades']++;
			$strats[$value->tlstrats]['total_trades']++;
			
			// top stocks
			$allstocks[$value->isstock]['stockname'] = $value->isstock;
			$allstocks[$value->isstock]['profit'] += $profit;
			$allstocks[$value->isstock]['profmarketval'] += $marketvals;

			$commissions = $marketvals * 0.0025;
			$finalcommis = ($commissions <= 20 ? 20 : $commissions);
			$fees['commissions'] += $finalcommis;
			$fees['vat'] += ($finalcommis * 0.12);
			$fees['transfer'] += ($marketvals * 0.00005);
			$fees['sccp'] += ($marketvals * 0.0001);
			$fees['sell'] += ($marketvals * 0.006);
			
		}
	}

	// winning stocks
	$winstocks = $allstocks;
	usort($winstocks, function($a, $b) {
		return $b['profit'] - $a['profit'];
	});

	// lossing stocks
	$lossing = $allstocks;
	usort($lossing, function($a, $b) {
		return $a['profit'] - $b['profit'];
	});


	$intowinchartbands = '';
	$intowinchartlabels = '';
	$winxcount = 0;
	$winningstocks = [];
	foreach ($winstocks as $key => $value) {
		if($value['profit'] > 0 && $winxcount < 3){

			$dwins = [];
			$dwins['stocks'] = $value['stockname'];
			$dwins['profit'] = $value['profit'];

			array_push($winningstocks, $dwins);

			$profperc = (abs($value['profit']) / $value['profmarketval']) * 100;

			$intowinchartbands .= '{';
			$intowinchartbands .= '"color": "'.($winxcount == 2 ? '#2C3E51' : ($winxcount == 1 ? '#223448' : ($winxcount == 0 ? '#172A3F' : ''))).'",';
			$intowinchartbands .= '"startValue": 0,';
			$intowinchartbands .= '"endValue": "100",';
			$intowinchartbands .= '"radius": "'.($winxcount == 2 ? '100' : ($winxcount == 1 ? '85' : ($winxcount == 0 ? '70' : ''))).'%",';
			$intowinchartbands .= '"innerRadius": "'.($winxcount == 2 ? '85' : ($winxcount == 1 ? '70' : ($winxcount == 0 ? '55' : ''))).'%",';
			$intowinchartbands .= '"alpha": 0.3';
			$intowinchartbands .= '}, {';
			$intowinchartbands .= ' "color": "'.($winxcount == 2 ? '#00e676' : ($winxcount == 1 ? '#06af68' : ($winxcount == 0 ? '#0d785a' : ''))).'",';
			$intowinchartbands .= ' "startValue": 0,';
			$intowinchartbands .= ' "endValue": '. (($profperc >= 0) ? number_format(abs($profperc), 2, '.', ',') : 0.00 ).',';
			$intowinchartbands .= ' "radius": "'.($winxcount == 2 ? '100' : ($winxcount == 1 ? '85' : ($winxcount == 0 ? '70' : ''))).'%",';
			$intowinchartbands .= ' "innerRadius": "'.($winxcount == 2 ? '85' : ($winxcount == 1 ? '70' : ($winxcount == 0 ? '55' : ''))).'%",';
			$intowinchartbands .= ' "balloonText": "'. ($profperc > 0 ? number_format($profperc, 2, '.', ',') : 0.00).'%"';
			$intowinchartbands .= '},';
		
			$intowinchartlabels .= '{';
			$intowinchartlabels .= '"text": "'. $value['stockname'] .'",';
			$intowinchartlabels .= '"x": "49%",';
			$intowinchartlabels .= '"y": "'.($winxcount == 2 ? '6.5' : ($winxcount == 1 ? '13.4' : ($flosskey == 0 ? '20' : '33'))).'%",';
			$intowinchartlabels .= '"size": 11,';
			$intowinchartlabels .= '"bold": false,';
			$intowinchartlabels .= '"color": "#d8d8d8",';
			$intowinchartlabels .= '"align": "right",';
			$intowinchartlabels .= '},';
			
			$winxcoun++;
			if($winxcount == 3){
				break;
			}
		}
	}
	usort($winningstocks, function($a, $b) {
		return $b['profit'] - $a['profit'];
	});

	$intolosschartbands = '';
	$intolosschartlabels = '';
	$lossxcount = 0;
	$loosingstocks = [];
	foreach ($lossing as $key => $value) {
		if($value['profit'] < 0 && $lossxcount < 3){

			$dloss = [];
			$dloss['stocks'] = $value['stockname'];
			$dloss['profit'] = $value['profit'];

			array_push($loosingstocks, $dloss);

			$lossprofperc = (abs($value['profit']) / $value['profmarketval']) * 100;

			$intolosschartbands .= '{';
			$intolosschartbands .= '"color": "'.($lossxcount == 0 ? '#2C3E51' : ($lossxcount == 1 ? '#223448' : ($lossxcount == 2 ? '#172A3F' : ''))).'",';
			$intolosschartbands .= '"startValue": 0,';
			$intolosschartbands .= '"endValue": "100",';
			$intolosschartbands .= ' "radius": "'.($lossxcount == 0 ? '100' : ($lossxcount == 1 ? '85' : ($lossxcount == 2 ? '70' : ''))).'%",';
			$intolosschartbands .= ' "innerRadius": "'.($lossxcount == 0 ? '85' : ($lossxcount == 1 ? '70' : ($lossxcount == 2 ? '55' : ''))).'%",';
			$intolosschartbands .= '"alpha": 0.5';
			$intolosschartbands .= '},{';
			$intolosschartbands .= ' "color": "'.($lossxcount == 0 ? '#b91e45' : ($lossxcount == 1 ? '#732546' : ($lossxcount == 2 ? '#442946' : ''))).'",';
			$intolosschartbands .= ' "startValue": 0,';
			$intolosschartbands .= ' "endValue": '. ($lossprofperc > 0 ? number_format($lossprofperc, 2, '.', ',') : 0.00 ).',';
			$intolosschartbands .= ' "radius": "'.($lossxcount == 0 ? '100' : ($lossxcount == 1 ? '85' : ($lossxcount == 2 ? '70' : ''))).'%",';
			$intolosschartbands .= ' "innerRadius": "'.($lossxcount == 0 ? '85' : ($lossxcount == 1 ? '70' : ($lossxcount == 2 ? '55' : ''))).'%",';
			$intolosschartbands .= ' "balloonText": "'. ($lossprofperc > 0 ? number_format($lossprofperc, 2, '.', ',') : 0.00).'%"';
			$intolosschartbands .= '},';
			
			$intolosschartlabels .= '{';
			$intolosschartlabels .= '"text": "'. $value['stockname'] .'",';
			$intolosschartlabels .= '"x": "49%",';
			$intolosschartlabels .= '"y": "'.($lossxcount == 0 ? '6.5' : ($lossxcount == 1 ? '13.4' : ($lossxcount == 2 ? '20' : '33'))).'%",';
			$intolosschartlabels .= '"size": 11,';
			$intolosschartlabels .= '"bold": false,';
			$intolosschartlabels .= '"color": "#d8d8d8",';
			$intolosschartlabels .= '"align": "right",';
			$intolosschartlabels .= '},';
			
			$lossxcount++;
			if($lossxcount == 3){
				break;
			}
		}
	}

	usort($loosingstocks, function($a, $b) {
		return $a['profit'] - $b['profit'];
	});
	
	// print_r($loosingstocks);

	foreach ($profits as $key => $value) {
		$dpercschart .= '{';
		$dpercschart .= '"category": "'.$key.'",';
		$dpercschart .= '"column-1": "'.$value.'",';
		$dpercschart .= '"column-2": "#673ab7"';
		$dpercschart .= '},';
	}

	foreach ($months as $key => $value) {
		$feeschart .= '{';
		$feeschart .= '"category": "'.ucfirst($key).'",';
		$feeschart .= '"column-1": "'.$value.'"';
		$feeschart .= '},';
	}

	foreach ($tremo as $key => $value) {
		if($value['total_trades'] > 0){
			$demotsonchart .= '{';
			$demotsonchart .= '"category": "'.$key.'",';
			$demotsonchart .= '"column-2": "'.$value['trloss'].'",';
			$demotsonchart .= '"Trades": "'.$value['trwin'].'"';
			$demotsonchart .= '},';
		}	
	}
	$winningstarts = "";
	$lossingstrats = "";
	$lastwin = 0;
	$lastlose = 0;
	foreach ($strats as $key => $value) {
		$winningstarts = ($lastwin > $value['trwin'] ? $winningstarts: $key );
		$lossingstrats = ($lastlose > $value['trloss'] ? $lossingstrats : $key);

		$stratstrg .= '{';
		$stratstrg .= '"category": "'.$key.'",';
		$stratstrg .= '"column-2": "'.$value['trloss'].'",';
		$stratstrg .= '"Trades": "'.$value['trwin'].'",';
		$stratstrg .= '"colors": "#06af68",';
		$stratstrg .= '"colorsred": "#b7193f"';
		$stratstrg .= '},';

		$wincharts .= '{';
		$wincharts .= '"strategy": "'.$key.'",';
		$wincharts .= '"winvals": '.$value['trwin'].'';
		$wincharts .= '},';

		$lastwin = ($lastwin > $value['trwin'] ? $lastwin : $value['trwin']);
		$lastlose = ($lastlose > $value['trloss'] ? $lastlose : $value['trloss']);
	}

	foreach ($profitsmonths as $key => $value) {
		$formonthperc .= '{';
		$formonthperc .= '"category": "'.$key.'",';
		$formonthperc .= '"column-1": "'.$value.'"';
		$formonthperc .= '},';
	}

	for ($i=$buysscounter; $i <= 20; $i++) { 
		$dailyvolumes .= '{';
		$dailyvolumes .= '"category": "'.$i.'",';
		$dailyvolumes .= '"column-1": 0';
		$dailyvolumes .= '},';

		
		$dailyvalues .= '{';
		$dailyvalues .= '"category": "'.$i.'",';
		$dailyvalues .= '"column-1": 0';
		$dailyvalues .= '},';

		$gplchart .= '{';
		$gplchart .= '"category": "'.$i.'",';
		$gplchart .= '"column-1": "0",';
		$gplchart .= '"column-2": "#673ab7"';
		$gplchart .= '},';
	}

	

?>
<!-- EOF Trade Logs Data from DB -->

<!-- BOF Ledger Data -->
<?php
    $duseridmo = $user->ID;
	$dledger = $wpdb->get_results('SELECT * FROM arby_ledger where userid = '.$duseridmo.' order by ledid');
	
	$buypower = 0;
    foreach ($dledger as $getbuykey => $getbuyvalue) {
        if ($getbuyvalue->trantype == 'deposit' || $getbuyvalue->trantype == 'selling' || $getbuyvalue->trantype == 'dividend' || $getbuyvalue->trantype == 'deleted_live') {
            $buypower = $buypower + $getbuyvalue->tranamount;
        } else {
            $buypower = $buypower - $getbuyvalue->tranamount;
        }
	}
	// $issampledata = get_user_meta($user->ID, 'issampleactivated', true);
	if(empty($dledger)){
		// wp_redirect('/journal');
        // exit;
	}
	if(empty($issampledata)){
		$dledger = [];
		$dledger[0] = new \stdClass();
		$dledger[0]->ledid = 250;
		$dledger[0]->userid = 111;
		$dledger[0]->date = '2019-08-21';
		$dledger[0]->trantype = 'deposit';
		$dledger[0]->tranamount = 100000;

		$dledger[1] = new \stdClass();
		$dledger[1]->ledid = 250;
		$dledger[1]->userid = 111;
		$dledger[1]->date = '2019-08-21';
		$dledger[1]->trantype = 'deposit';
		$dledger[1]->tranamount = 100000;

		$dledger[2] = new \stdClass();
		$dledger[2]->ledid = 250;
		$dledger[2]->userid = 111;
		$dledger[2]->date = '2019-08-21';
		$dledger[2]->trantype = 'deposit';
		$dledger[2]->tranamount = 100000;

		$dledger[3] = new \stdClass();
		$dledger[3]->ledid = 250;
		$dledger[3]->userid = 111;
		$dledger[3]->date = '2019-08-21';
		$dledger[3]->trantype = 'deposit';
		$dledger[3]->tranamount = 100000;

		$dledger[3] = new \stdClass();
		$dledger[3]->ledid = 250;
		$dledger[3]->userid = 111;
		$dledger[3]->date = '2019-08-21';
		$dledger[3]->trantype = 'deposit';
		$dledger[3]->tranamount = 100000;
	}
?>
<!-- BOF Current Allocation Data -->
<?php
	$currentalocinfo = "";
	if(!empty($issampledata)){
		$dequityp = $buypower;
		$aloccolors = array('#FF5500', '#00B4C4', '#FF008F', '#FFB700', '#CEF500', '#FB3640', '#00AAFF', '#CC0066', '#33FF99', '#FF8000', '#33FFCC', '#FB3640', '#FF2B66', '#99FF00', '#9900FF', '#FB3640', '#00B4C4', '#FF008F', '#FFB700');
		$currentalocinfo = '{"category" : "Cash", "column-1" : "'.number_format($buypower, 2, '.', '').'"},';
		$currentaloccolor = '"#FF5500",';
		if ($dtradeingfo) {
			foreach ($dtradeingfo as $trinfokey => $trinfovalue) {
				// print_r($trinfovalue);
				$key = array_search(strtoupper($trinfovalue['stockname']), array_column($gerdqoute->data, 'symbol'));
				$stockdetails = $gerdqoute->data[$key];
				$dstockinfo = $stockdetails;
				$marketval = $dstockinfo->last * $trinfovalue['totalstock'];
				$dsellfees = getjurfees($marketval, 'sell');
				$dtotal = $marketval - $dsellfees;
	
				$dequityp += $dtotal;
				$currentalocinfo .= '{"category" : "'.$trinfovalue['stockname'].'", "column-1" : "'.number_format($dtotal, 2, '.', '').'"},';
				$currentaloccolor .= '"'.$aloccolors[$trinfokey + 1].'",';
			}
		}
	} else {
		$dequityp = 245318.22;
		$currentalocinfo = '{"category" : "Cash", "column-1" : "245318.22"},{"category" : "Sample Stock 1", "column-1" : "61752.33"},{"category" : "Sample Stock 2", "column-1" : "59760.32"},{"category" : "Sample Stock 3", "column-1" : "59760.32"}';
		$currentaloccolor = '"#FF5500","#00B4C4","#FF2B66","#FFB700","#CEF500","#FF5500","#00AAFF","#CC0066","#33FF99"';
	}
    
?>
<!-- EOF Current Allocation Data -->


<!-- Delete Data -->
<?php

    if (isset($_POST) && strtolower(@$_POST['deletedata']) == 'reset') {

		
        $dlistofstocks = get_user_meta($user->ID, '_trade_list', true);

        // Delete Live Trade
        foreach ($dlistofstocks as $delkey => $delvalue) {
            update_user_meta($user->ID, '_trade_'.$delvalue, '');
            delete_user_meta($user->ID, '_trade_n  '.$delvalue);

            // $dsotcksss = get_user_meta($user->ID, '_trade_'.$delvalue, true);
        }
		delete_user_meta($user->ID, '_trade_list');
		

		update_user_meta($user->ID, 'issampleactivated', 'no');
        // delete ledger
		$wpdb->get_results('delete from arby_ledger where userid = '.$user->ID);
		$deletelogs = 'delete from arby_tradelog where isuser ='.$user->ID;
		$wpdb->query($deletelogs);
        wp_redirect('/journal');
        exit;
    }
?>
<!-- Delete Data -->
<?php
																				
	usort($gerdqoute->data, function($a, $b) {
		return $a->symbol <=> $b->symbol;
	});
	$listosstocks = $gerdqoute->data;

?>
<!-- BOF Record a Trade -->
	<?php require "journal/record-trade.php";?>
<!-- EOF Record a Trade -->


<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

						<?php require("parts/global-sidebar.php"); ?>

					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 800px !important;">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    <span id="journal" class="journaltabs">
						                        <!-- Tabs -->
						                        <ul class="nav panel-tabs">
						                            <li class="<?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active'; ?>"><a href="#tab1" data-toggle="tab" class="<?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active show'; ?>">Dashboard</a></li>
						                            <li class="<?php echo isset($_GET['pt']) ? 'active' : ''; ?>"><a href="#tab2" data-toggle="tab" class="<?php echo isset($_GET['pt']) ? 'active show' : ''; ?> opentradelogtab">Tradelogs</a></li>
						                            <li class="<?php echo isset($_GET['ld']) ? 'active' : ''; ?>"><a href="#tab3" data-toggle="tab" class="<?php echo isset($_GET['ld']) ? 'active show' : ''; ?> openledger">Ledger</a></li>
						                            <!-- <li class=""><a href="#tab4" data-toggle="tab" class="">Calendar</a></li> -->
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane <?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active show'; ?>" id="tab1">
                                                    <div class="liveportfoliobox">
                                                        <div class="box-portlet">
                                                            <div class="box-portlet-header">
                                                                Live Portfolio
                                                                <div class="dltbutton">
																	<div class="dbuttondelete">
																		<form action="/journal" method="post" class="resetform">
																			<input type="hidden" name="deletedata" value="reset">
																			<input type="submit" name="resetdd" value="Reset" class="delete-data-btn resetdata">
																		</form>
																	</div>
																	
																	<!-- BOF Enter Trade -->
																	<?php require "journal/enter-trade.php";?>
																	<!-- EOF Enter Trade -->
																	
																	<!-- BOF Add Funds Button -->
																		<?php require "journal/add-funds.php";?>
																	<!-- EOF Add Funds Button -->
                                                        		</div>
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <?php require "journal/live_portfolio.php";?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                	<?php require "journal/dashboard.php";?>
						                        </div>
						                        <div class="tab-pane <?php echo isset($_GET['pt']) ? 'active show' : ''; ?> testss" id="tab2">
													<?php require "journal/tradelogs.php";?>
						                        </div>
						                        <div class="tab-pane <?php echo isset($_GET['ld']) ? 'active show' : ''; ?>" id="tab3">
													<?php require "journal/ledger.php";?>
                                                	<br class="clear">
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->
<?php
require "journal/footer-files.php";
