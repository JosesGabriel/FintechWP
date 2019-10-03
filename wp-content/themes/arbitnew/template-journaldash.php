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
	curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
	
	curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $gerdqouteone = curl_exec($curl);
    curl_close($curl);

    $gerdqoute = json_decode($gerdqouteone);
    // $gerdqoute = [];
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
	$dtotalpl = 0;

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
			if(date('Y', strtotime($value->tldate)) == date('Y')){
				$dtotalpl += $profit;
			}

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
	$initcapital = $dledger[0]->tranamount;
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

                                                        	<?php
                                                                function date_lvp_sort($a, $b)
                                                                {
                                                                    return strtotime($a->date) - strtotime($b->date);
                                                                }
                                                                usort($dledger, 'date_lvp_sort');
                                                                $dbaseaccount = 0;
                                                                $porttotaldep = 0;
                                                                $porttotalwid = 0;

                                                                foreach ($dledger as $dbaseledgekey => $dbaseledgevalue) {
                                                                    if ($dbaseledgevalue->trantype == 'deposit') {
                                                                        $dbaseaccount = $dbaseaccount + $dbaseledgevalue->tranamount;
                                                                        $porttotaldep += $dbaseledgevalue->tranamount;
                                                                    } elseif ($dbaseledgevalue->trantype == 'withraw') {
                                                                        $dbaseaccount = $dbaseaccount - $dbaseledgevalue->tranamount;
                                                                        $porttotalwid += $dbaseledgevalue->tranamount;
                                                                    }
                                                                }

                                                                // echo $dbaseaccount;
                                                            ?>
															<?php if($isjounalempty): ?>
															<?php endif; ?>
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

<div class="script">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script type="text/javascript">
		var today = new Date();
		var currentDate = today.getFullYear()+'-'+ ('0' + (today.getMonth()+1)).slice(-2) +'-'+ ("0" + today.getDate()).slice(-2);	
		jQuery(".buySell__date-picker").attr('max',currentDate);
		// jQuery(".buySell__date-picker").attr('value',currentDate);



        function editEvent(event) {
			jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
			jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
			jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
			jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
			jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
			jQuery('#event-modal').modal();
			

		}

		function getObject(event){
			jQuery(".dtopentertrade").find("#newdate").val(event.value);
		}
		function buydate(event){
			jQuery(".buyaddtrade").find("#addstockisdate").val(event.value);
		}
		function selldate(event){
			jQuery("#selldate").val(event.value);
		}

	jQuery(document).ready(function(){

        jQuery("#buy-order--submit").click(function(){

            console.log('...sell');
            if($('#sell_price--input').val().length > 0 && $('#qty_price--input').val().length > 0) {
                
                 $('.chart-loader').css("display","block");
                 $(this).hide();
            }

        });


		jQuery(".changeselldate").change(function() {
			var date = $(this).val();
		});
        
        jQuery(".editmenow").click(function(){

        //$(document).on("click", ".editmenow", function() {
            var ulogid = jQuery(this).attr('data-istl');

            var strat = jQuery('.strat_'+ ulogid).val();
            var tplan = jQuery('.tplan_'+ ulogid).val();
            var emot = jQuery('.emot_'+ ulogid).val();
            var tnotes = jQuery('.tnotes_'+ ulogid).val();
            jQuery(".edittlogs_" + ulogid).find("#strategy").val(strat);
            jQuery(".edittlogs_" + ulogid).find("#trade_plan").val(tplan);
            jQuery(".edittlogs_" + ulogid).find("#emotion").val(emot);
            jQuery(".edittlogs_" + ulogid).find("#tlnotes").val(tnotes);

            $('.chart-loader').css("display","block");
            $(this).hide();

            jQuery('.edittlogs_' + ulogid).submit();

        });

		$(".deletelive").on('click', function(e){
			e.preventDefault();

			/// journal/?todo=deletelivetrade&stock=

			let dstock = $(this).attr('data-stock');
			let dtotalprice = $(this).attr('data-totalprice');
			

			swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this entry!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					console.log('delete this');
					console.log(dstock);
					window.location.href = "/journal/?todo=deletelivetrade&stock="+dstock+"&totalbase="+dtotalprice;

					// jQuery(this).parents(".dloglist").addClass("housed");
					// jQuery(".deleteformitem").find("#todelete").val(dlogid);
					// jQuery(".deleteformitem").submit();
				} else {
					// swal("Your imaginary file is safe!");
				}
			});
		});

        $('.deletelog').on('click', function () {
	//$(document).on("click", ".deletelog", function() {

		//jQuery(".deletelog").click(function(e){

			var dlogid = jQuery(this).attr('data-istl');

			swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this entry!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
                    console.log('delete this');
					jQuery(this).parents(".dloglist").addClass("housed");
					jQuery(".deleteformitem").find("#todelete").val(dlogid);
					jQuery(".deleteformitem").submit();
				} else {
					// swal("Your imaginary file is safe!");
				}
			});
	});

		jQuery("#inpt_data_select_stock").on('change', function() {
			var datts = this.value;
			var dstocks = $.parseJSON(datts);

			jQuery("input[name='inpt_data_currprice']").val((dstocks.last).toFixed(2));
			jQuery("input[name='inpt_data_change']").val((dstocks.change).toFixed(2));
			jQuery("input[name='inpt_data_open']").val((dstocks.open).toFixed(2));
			jQuery("input[name='inpt_data_low']").val((dstocks.low).toFixed(2));
			jQuery("input[name='inpt_data_high']").val((dstocks.high).toFixed(2));
			var numseprvm = dstocks.volume.toFixed(2);
			var numseprve = dstocks.value.toFixed(2);
			jQuery("input[name='inpt_data_volume']").val(replaceCommas(numseprvm));
			jQuery("input[name='inpt_data_value']").val(replaceCommas(numseprve));
			
			// board lot
			var dboard = 0;
			if (dstocks.last >= 0.0001 && dstocks.last <= 0.0099) {
				dboard = '1,000,000';
			} else if (dstocks.last >= 0.01 && dstocks.last <= 0.049) {
				dboard = '100,000';
			} else if (dstocks.last >= 0.05 && dstocks.last <= 0.495) {
				dboard = '10,000';
			} else if (dstocks.last >= 0.5 && dstocks.last <= 4.99) {
				dboard = '1,000';
			} else if (dstocks.last >= 5 && dstocks.last <= 49.95) {
				dboard = 100;
			} else if (dstocks.last >= 50 && dstocks.last <= 999.5) {
				dboard = 10;
			} else if (dstocks.last >= 1000) {
				dboard = 5;
			} 

			jQuery("input[name='inpt_data_boardlot']").val(dboard);
			jQuery("input[name='inpt_data_stock']").val(dstocks.symbol);

			function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1) 
					components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
					components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
			}
		});

		jQuery(".dloadform").click(function(e){
			e.preventDefault();
			var dstock = $(".dentertrade #inpt_data_select_stock").val().replace(/,/g, '');
			var dbuypower = parseFloat($(".dentertrade #input_buy_product").val().replace(/,/g, ''));
			var total_price = parseFloat(jQuery('input[name="inpt_data_total_price"]').val().replace(/,/g, ''));
			var buySell__date = jQuery('#journal__trade-btn--date-picker').val();

			if(dstock != "" && dbuypower > 0 && total_price < dbuypower && buySell__date != ""){
				jQuery(".dentertrade").submit();
			} else if (buySell__date == "") {
				swal('Date is required.');
				jQuery('.chart-loader').hide();
				jQuery('.confirmtrd').show();
			} else if (total_price < dbuypower) {
				swal('Not enough funds.');
				jQuery('.chart-loader').hide();
				jQuery('.confirmtrd').show();
			}
		});

		function thetradefees(totalfees, istype){
			// Commissions
			let dpartcommission = totalfees * 0.0025;
			let dcommission = (dpartcommission > 20 ? dpartcommission : 20);
			// TAX
			let dtax = dcommission * 0.12;
			// Transfer Fee
			let dtransferfee = totalfees * 0.00005;
			// SCCP
			let dsccp = totalfees * 0.0001;
			let dsell = totalfees * 0.006;
			let dall;
			if (istype == 'buy') {
				dall = dcommission + dtax + dtransferfee + dsccp;
			} else {
				dall = dcommission + dtax + dtransferfee + dsccp + dsell;
			}

			return dall;
		}


		jQuery(document).on('keyup', 'input[name="inpt_data_price_bought"], input[name="inpt_data_qty_bought"]', function (e) {
			let price = jQuery('input[name="inpt_data_price_bought"]').val().replace(/,/g, '');
			let quantity = jQuery('input[name="inpt_data_qty_bought"]').val().replace(/,/g, '');

			let totalmarket = parseFloat(price) * parseFloat(quantity);
			let finalcost = totalmarket + parseFloat(thetradefees(totalmarket, 'buy'));
			let wdecimal = finalcost.toFixed(2);
			if(!isNaN(finalcost)){
				jQuery('input[name="inpt_data_total_bought_price"]').val(replaceCommas(wdecimal));
			}
			function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1) 
					components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
					components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
			}
			
		});

		jQuery(document).on('keyup', 'input[name="inpt_data_price_sold"], input[name="inpt_data_qty_sold"]', function (e) {
			let boughtfinal = jQuery('input[name="inpt_data_total_bought_price"]').val().replace(/,/g, '');

			let price = jQuery('input[name="inpt_data_price_sold"]').val().replace(/,/g, '');
			let quantity = jQuery('input[name="inpt_data_qty_sold"]').val().replace(/,/g, '');

			let totalmarket = parseFloat(price) * parseFloat(quantity);
			let finalcost = totalmarket - parseFloat(thetradefees(totalmarket, 'sell'));
			let finalbought = finalcost.toFixed(2);
			let totalfinalsold = finalcost - boughtfinal;
			let finalsold = totalfinalsold.toFixed(2);
			if(!isNaN(finalcost)){
				jQuery('input[name="inpt_data_total_sold_price"]').val(replaceCommas(finalbought));
				jQuery('input[name="inpt_data_total_sold_profitloss"]').val(replaceCommas(finalsold));
			}
			function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1) 
					components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
					components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
			}
			
		});

		jQuery(document).on('change', '#inpt_data_stock_bought', function() {
			let dstock = this.value;
			jQuery("#inpt_data_stock_sold").val(dstock);

		});

		jQuery(document).on('change', '#inpt_data_stock_sold', function() {
			let dstock = this.value;
			jQuery("#inpt_data_stock_bought").val(dstock);

		});


		// calculate total price
		jQuery(document).on('keyup', '#entertopdataprice, #entertopdataquantity', function (e) {
			let price = jQuery('#entertopdataprice').val().replace(/,/g, '');
			let quantity = jQuery('#entertopdataquantity').val().replace(/,/g, '');
			// let quantity = jQuery('#entertopdataquantity').val();
			
			let total_price = parseFloat(price) * Math.trunc(quantity);
			total_price = isNaN(total_price) || total_price < 0 ? 0 : parseFloat(total_price).toFixed(2);

			let finaltotal = parseFloat(total_price) + parseFloat(thetradefees(total_price, 'buy'));
			let decnumbs = finaltotal.toFixed(2);
			jQuery('input[name="inpt_data_total_price"]').val(replaceCommas(decnumbs));

			function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1) 
					components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
					components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
			}
		});
		
		jQuery('#selectdepotype').on('change', function() {
			// alert( this.value );
			jQuery("#tabdeposit").find('input[name="istype"]').val(this.value);

		});


		jQuery(".depotbutton").click(function(e){
			
			var dinputinfo = jQuery(this).parents(".depotincome").find(".depo-input-field").val();

			if(dinputinfo != ""){
				jQuery(".depotincome").submit();
			} else {
				swal("field should not be empty");
			}
		});

		jQuery(".divibutton").click(function(e){
			
			var dinputinfo = jQuery(this).parents(".dividincome").find(".depo-input-field").val();

			if(dinputinfo != ""){
				jQuery(".dividincome").submit();
			} else {
				swal("field should not be empty");
			}
		});

		jQuery("li.dspecitem").click(function(e){
			if (jQuery(this).hasClass("ledgeopened")) {
				jQuery(this).removeClass("ledgeopened");
				jQuery(this).find(".ddetailshere").hide('slow');
			} else {
				jQuery(this).addClass("ledgeopened");
				jQuery(this).find(".ddetailshere").show('slow');
			}

		});

		jQuery('.resetdata').click(function(e){
			e.preventDefault();
			swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover your Journal Data!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
			if (willDelete) {
				jQuery('.resetform').submit();
			} 
			});
		});
		jQuery('.dbuttonrecord').click(function(e){
			e.preventDefault();
			jQuery('.record_modal').show();
		});
		jQuery('.to_closethis_rec').click(function(e){
			e.preventDefault();
			jQuery('.record_modal').hide();
		});


		jQuery(".dwidfunds").click(function(e){
			if ($dwidraw > 0) {
				$dbuypower = jQuery(this).parents(".modal-content").find(".dwithdrawnum").attr('data-dpower');
				$dwidraw = jQuery(this).parents(".modal-content").find(".dwithdrawnum").val();
				if (parseFloat($dbuypower) <= parseFloat($dwidraw) ) {
					e.preventDefault();
					if (!jQuery(this).parents(".modal-content").find(".errormessage").length) {
						jQuery(this).parents(".modal-content").find(".dinitem").append('<div class="errormessage">You cant exceed by ₱'+$dbuypower+'</div>');
					}
				}
			} else {
				e.preventDefault();
			}
		});

		jQuery(".dmoveto").click(function(e){
			e.preventDefault();
			// ptchangenum
			// jQuery("#ptchangenum").submit();
			var dnumsec = jQuery("#ptchangenum").find("#ptnum").val();
			if(parseInt(dnumsec) <= 0 || dnumsec.length === 0 ){

			} else {
				jQuery("#ptchangenum").submit();
			}
		});

		jQuery(".lddmoveto").click(function(e){
			e.preventDefault();
			// ptchangenum
			// jQuery("#ptchangenum").submit();
			var dnumsec = jQuery("#ldchangenum").find("#ldnum").val();
			if(parseInt(dnumsec) <= 0 || dnumsec.length === 0 ){

			} else {
				jQuery("#ldchangenum").submit();
			}
		});


		jQuery('.search-logs').on('keyup', function () {

			var totalrow = $('input[name="hsearchlogs"]').val();

			if($(this).val().length < 1) {
        		jQuery('.dloglist').css("display","block");
        		for(var x = 0; x < totalrow; x++){
        			jQuery('.s-logs'+ x).remove();
        		}
        		$('.s-logs').remove();
        		 
    		}else {
    			jQuery('.dloglist').css("display","none");
    			jQuery('.s-logs').css("display","block");
    			var keyword = $(this).val();
    				
    			var tdate = $('.tdate').text();
    			//var tdata = new Array($('.tdata').text());
    			//var tdata = [];
    			var td =  $(".tdata").text().length
    			var tcolor;
    			for(var i = 0; i < totalrow; i++){
    				var tdata = $('#tdata' + i).text();
    				var tdate = $('#tdate' + i).text();
    				var tquantity = $('#tquantity' + i).text();
    				var tavprice = $('#tavprice' + i).text();
    				var tbvalue = $('#tbvalue' + i).text();
    				var tsellprice = $('#tsellprice' + i).text();
    				var tsellvalue = $('#tsellvalue' + i).text();
    				var tploss = $('#tploss' + i).text();
    				var tpercent = $('#tpercent' + i).text();
    				var dprofit = $('#dprofit' + i).val();
    				var deletelog = $('#deletelog' + i).val();

    				//if(keyword == tdata){
    				var rgxp = new RegExp(keyword, "gi");

    				if (tdata.match(rgxp)) {

		    				if(dprofit > 0 ){
		    					tcolor = 'txtgreen';
		    				}else{
		    					tcolor = 'txtred';
		    				}
		    			
		    			if($('#logrows-'+ i).hasClass('s-logs'+ i)){
		    				$('.s-logs').remove();
		    				return;

		    			}else{

		    				$('.dstatstrade1 ul').append(
		    				$("<li class='s-logs"+ i +"' id='logrows-" + i+ "'><div style='width:99%;' class='tdatalogs"+ i +"'><div style='width:65px'>" + tdate + "</div><div style='width:45px; margin-left: 13px;'><a href='/chart/"+ tdata +"' class='stock-label'>"+ tdata +"</a></div><div style='width:55px; margin-left: -10px;margin-right: 10px;' class='table-cell-live'>" + tquantity + "</div><div style='width:65px' class='table-cell-live'>" + tavprice + "</div><div style='width:95px' class='table-cell-live'> "+ tbvalue +"</div><div style='width:65px' class='table-cell-live'>"+ tsellprice +"</div><div style='width:95px' class='table-cell-live'>"+ tsellvalue +"</div><div style='width:80px; margin-left: 10px;' class='"+tcolor+" table-cell-live' >" + tploss + "</div><div style='width:65px' class='"+tcolor+" table-cell-live'>" +tpercent + "</div><div style='width:35px; text-align:center;margin-left: 5px;'><a href='#tradelognotes_" + tdata + "' class='smlbtn blue fancybox-inline'><i class='fas fa-clipboard'></i></a></div><div style='width:25px'><a class='deletelog smlbtn-delete' data-istl='"+ deletelog +"' style='cursor:pointer;text-align:center'><i class='fas fa-eraser'></i></a></div></div><div class='hidethis'><div class='tradelogbox' id='tradelognotes_" + tdata + "'><div class='entr_ttle_bar'><strong>"+ tdata +"</strong> <span class='datestamp_header'></span><hr class='style14 style15' style='width: 93% !important;width: 93% !important;margin: 5px auto !important;'><div class='trdlgsbox'><div class='trdleft'><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Strategy:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Trade Plan:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Emotion:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Performance:</strong></span> <span class='modal-notes-result'>%</span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Outcome:</strong></span> <span class='modal-notes-result'></span></div></div><div class='trdright darkbgpadd'><div><strong>Notes:</strong></div><div></div></div><div class='trdclr'></div></div> </div></li>"));
		    					$('.s-logs').remove();
		    			}
		    					
    				}else{
    					$('.s-logs' + i).remove();
    					if(!$('#norecords').hasClass('s-logs')){
    						$('.dstatstrade1 ul').append("<li class='s-logs' id='norecords'><div>No records found.</div></li>");
    					}
    				}

    			}
    			

    		}	
			
        });


	});
    </script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/journalscripts.js?<?php echo time(); ?>"></script>

<script language="javascript">
	


	// Chart 1 - Current Allocation
	AmCharts.makeChart("chartdiv1",
		{
			"type": "pie",
			"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
			"innerRadius": "40%",
			"pieX": "45%",
			"pieY": "50%",
			"radius": 50,
			"pullOutRadius": "0%",
			"startRadius": "0%",
			"pullOutDuration": 0,
			"sequencedAnimation": false,
			"startDuration": 0,
			"colors": [
				<?php echo $currentaloccolor; ?>
			],
			"labelColorField": "#FFFFFF",
			"labelsEnabled": false,
			"labelTickAlpha": 1,
			"labelTickColor": "#FFFFFF",
			"titleField": "category",
			"valueField": "column-1",
			"backgroundColor": "#000000",
			"borderColor": "#FFFFFF",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"allLabels": [],
			"balloon": {},
			"legend": {
				"enabled": true,
				"align": "center",
				"autoMargins": false,
				"color": "#78909C",
				"left": 0,
				"markerSize": 14,
				"markerType": "circle",
				"position": "left",
				"valueWidth": 80
			},
			"titles": [],
			"dataProvider": [<?php echo $currentalocinfo; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$formonthperc = '{"category": "Jan","column-1": "80"},{"category": "Feb","column-1": "60"},{"category": "Mar","column-1": "30"},{"category": "Apr","column-1": "20"},{"category": "May","column-1": "10"},{"category": "Jun","column-1": "-5"},{"category": "Jul","column-1": "-15"},{"category": "Aug","column-1": "-20"},{"category": "Sep","column-1": "-10"},{"category": "Oct","column-1": "5"},{"category": "Nov","column-1": "10"},{"category": "Dec","column-1": "15"}';
		}
	?>
	// Chart 2 - Monthly Performance (Bar)
	AmCharts.makeChart("chartdiv2",
		{
			"type": "serial",
			"categoryField": "category",
			"sequencedAnimation": false,
			"startDuration": 0,
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"addClassNames": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"plotAreaBorderColor": "#FFFFFF",
			"zoomOutText": "Reset",
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"handDrawThickness": 4,
			"usePrefixes": true,
			"categoryAxis": {
				"axisAlpha": 0.09,
				"axisColor": "#FFFFFF",
				"boldPeriodBeginning": false,
				"color": "#78909C",
				"firstDayOfWeek": 6,
				"gridAlpha": 0.09,
				"gridThickness": 0,
				"markPeriodChange": false,
				"minorGridAlpha": 0,
				"minorGridEnabled": true,
				"titleFontSize": 0
			},
			"trendLines": [],
			"graphs": [
				{
					"columnWidth": 1,
					"cornerRadiusTop": 3,
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 12,
					"gapPeriod": 0,
					"id": "AmGraph-2",
					"lineColor": "undefined",
					"lineColorField": "color",
					"lineThickness": 0,
					"negativeFillAlphas": 1,
					"negativeFillColors": "#ff1744",
					"title": "",
					"topRadius": 0,
					"type": "column",
					"valueField": "column-1"
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-2",
					"autoRotateAngle": 90,
					"axisAlpha": 0.09,
					"axisColor": "#FFFFFF",
					"color": "#78909C",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"labelRotation": 48.6,
					"title": "",
					"titleBold": false,
					"titleColor": "#FFFFFF",
					"titleFontSize": 0
				}
			],
			"allLabels": [],
			"balloon": {
				"fixedPosition": false,
				"fontSize": 10,
				"showBullet": true
			},
			"titles": [],
			"dataProvider": [
				<?php echo $formonthperc; ?>
			]
		}
	);

	// Chart 3 - Monthly Performance (Pie) - Removed requested by Ai
	<?php
		if($isjounalempty){
			$iswin = 100;
			$isloss = 60;
		}
	?>
	// Chart 4a - Trade Statistics (chartdiv4a)
	// var chart = 
	<?php
		if($isjounalempty){
			$wincharts = '{"strategy": "Bottom Picking","winvals": 15},{"strategy": "Breakout Play","winvals": 9},{"strategy": "Trend Following","winvals": 2}';
		}
	?>
	// Chart 4b - Win Allocations (chartdiv4b)
	var chart = AmCharts.makeChart("chartdiv4b", {
	  "type": "pie",
	  "startDuration": 0,
	  "sequencedAnimation": false,
	  "theme": "none",
	  "marginBottom": 0,
	  "marginTop": 0,
	  "marginLeft": 0,
	  "marginRight": 0,
	  "labelsEnabled": false,
	  "addClassNames": true,
	  "fontFamily": "Roboto",
	  "fontSize": 11,
	  "legend":{
		"enabled": false,
		"position":"bottom",
		"autoMargins":false,
		"color": "#d8d8d8",
		"align": "center",
		"valueWidth": 35
	  },
	  "color": "#d8d8d8",
	  "innerRadius": "50%",
	  "radius": 75,
	  "autoMargins": false,
	  "colors": [
		"#f44336",
		"#FFC107",
		"#06af68"
		// "#4CAF50",
		// "#00BCD4",
		// "#2196F3",
		// "#673AB7",
		// "#E91E63",
		// "#FF9800",
		// "#FFEB3B",
		// "#8BC34A"
	  ],
	  "defs": {
		"filter": [{
		  "id": "shadow",
		  "width": "200%",
		  "height": "200%",
		  "feOffset": {
			"result": "offOut",
			"in": "SourceAlpha",
			"dx": 0,
			"dy": 0
		  },
		  "feGaussianBlur": {
			"result": "blurOut",
			"in": "offOut",
			"stdDeviation": 5
		  },
		  "feBlend": {
			"in": "SourceGraphic",
			"in2": "blurOut",
			"mode": "normal"
		  }
		}]
	  },
	  "dataProvider": [<?php echo $wincharts; ?>],
	  "valueField": "winvals",
	  "titleField": "strategy",
	  "export": {
		"enabled": false
	  }
	});

	chart.addListener("init", handleInit);

	chart.addListener("rollOverSlice", function(e) {
	  handleRollOver(e);
	});

	function handleInit(){
	  chart.legend.addListener("rollOverItem", handleRollOver);
	  /*jQuery("#chartdiv2 svg").prepend('<defs><linearGradient id="myGradient" gradientTransform="rotate(90)">
	  <stop offset="5%" stop-color="#00e676" /><stop offset="95%" stop-color="#000000" /></linearGradient></defs>');*/
	}

	function handleRollOver(e){
	  var wedge = e.dataItem.wedge.node;
	  wedge.parentNode.appendChild(wedge);
	}

	<?php
		if($isjounalempty){
			$stratstrg = '{"category": "Bottom Picking","column-2": "4","Trades": "15","colors": "#06af68","colorsred": "#b7193f"},{"category": "Breakout Play","column-2": "1","Trades": "9","colors": "#06af68","colorsred": "#b7193f"},{"category": "Trend Following","column-2": "8","Trades": "2","colors": "#06af68","colorsred": "#b7193f"}';
		}
	?>
	// Chart 5 - Strategy Statistics
	AmCharts.makeChart("chartdiv5",
{
	"type": "serial",
	"categoryField": "category",
	"rotate": true,
	"marginLeft": 10,
	"marginRight": 10,
	"autoMarginOffset": 0,
	"marginBottom": 20,
	"marginTop": 85,
	"startDuration": 0,
	"sequencedAnimation": false,
	"backgroundColor": "#0D1F33",
	"color": "#78909C",
	"fontFamily": "Roboto",
	"usePrefixes": true,
	"categoryAxis": {
		"axisAlpha": 0,
		"axisColor": "#FFFFFF",
		"gridColor": "#FFFFFF",
		"gridThickness": 0,
		"title": "WINS & LOSSES",
		"titleBold": false,
		"titleColor": "#d8d8d8",
		"titleFontSize": 14
	},
	"trendLines": [],
	"graphs": [
		{
			"alphaField": "color",
			"balloonText": "[[title]]: [[value]]",
			"bulletField": "color",
			"bulletSizeField": "color",
			"closeField": "color",
			"colorField": "colors",
			"columnIndexField": "color",
			"customBulletField": "color",
			"dashLengthField": "color",
			"descriptionField": "color",
			"errorField": "color",
			"fillAlphas": 1,
			"fillColors": "#00E676",
			"fillColorsField": "color",
			"fixedColumnWidth": 15,
			"gapField": "color",
			"highField": "color",
			"id": "AmGraph-1",
			"labelColorField": "color",
			"lineAlpha": 0,
			"lineColorField": "color",
			"lowField": "color",
			"openField": "color",
			"patternField": "color",
			"title": "Wins",
			"type": "column",
			"valueField": "Trades",
			"xField": "color",
			"yField": "color",
			"cornerRadiusTop": 3,
		},
		{
			"alphaField": "color",
			"balloonText": "[[title]]: [[value]]",
			"bulletField": "color",
			"bulletSizeField": "color",
			"closeField": "color",
			"colorField": "colorsred",
			"columnIndexField": "color",
			"customBulletField": "color",
			"dashLengthField": "color",
			"descriptionField": "color",
			"errorField": "color",
			"fillAlphas": 1,
			"fillColors": "#ff1744",
			"fillColorsField": "color",
			"fixedColumnWidth": 15,
			"gapField": "color",
			"highField": "color",
			"id": "AmGraph-2",
			"labelColorField": "color",
			"lineColorField": "color",
			"lineThickness": 0,
			"lowField": "color",
			"openField": "color",
			"patternField": "color",
			"title": "Losses",
			"type": "column",
			"valueField": "column-2",
			"xField": "color",
			"yField": "color",
			"cornerRadiusTop": 3,
		}
	],
	"guides": [],
	"valueAxes": [
		{
			"id": "ValueAxis-1",
			"stackType": "regular",
			"axisAlpha": 0.19,
			"axisColor": "#FFFFFF",
			"dashLength": 3,
			"gridAlpha": 0.22,
			"gridColor": "#FFFFFF",
			"title": ""
		}
	],
	"allLabels": [],
	"balloon": {},
	"titles": [],
	"dataProvider": [
		<?php echo $stratstrg; ?>
	]
}
	);
	<?php 
		if($isjounalempty){
			$feeschart = '
			{"category": "Jan","column-1": "123"},
			{"category": "Feb","column-1": "345"},
			{"category": "Mar","column-1": "456"},
			{"category": "Apr","column-1": "345"},
			{"category": "May","column-1": "123"},
			{"category": "Jun","column-1": "23"},
			{"category": "Jul","column-1": "6"},
			{"category": "Aug","column-1": "36"},
			{"category": "Sep","column-1": "403"},
			{"category": "Oct","column-1": "50"},
			{"category": "Nov","column-1": "30"},
			{"category": "Dec","column-1": "60"}';
		}
	?>
	// Chart 6 - Expense Report
	AmCharts.makeChart("chartdiv6",
		{
			"type": "serial",
			"categoryField": "category",
			"autoMarginOffset": 0,
			"marginBottom": 0,
			"marginLeft": 0,
			"marginRight": 0,
			"backgroundColor": "#142C46",
			"borderColor": "#FFFFFF",
			"color": "#78909C",
			"usePrefixes": true,
			"categoryAxis": {
				"gridPosition": "start",
				"axisAlpha": 0.19,
				"axisColor": "#FFFFFF",
				"gridAlpha": 0,
				"gridColor": "#FFFFFF"
			},
			"trendLines": [],
			"graphs": [
				{
					"balloonColor": "undefined",
					"balloonText": "[[category]]: [[value]]",
					"bullet": "round",
					"bulletAlpha": 0,
					"bulletBorderColor": "undefined",
					"bulletBorderThickness": 6,
					"bulletColor": "#ff1744",
					"bulletSize": 0,
					"columnWidth": 0,
					"fillAlphas": 0.05,
					"fillColors": "#ff1744",
					"gapPeriod": 3,
					"id": "AmGraph-1",
					"legendAlpha": 0,
					"legendColor": "undefined",
					"lineColor": "#ff1744",
					"lineThickness": 3,
					"minBulletSize": 18,
					"minDistance": 0,
					"negativeBase": 2,
					"negativeFillAlphas": 0,
					"negativeLineAlpha": 0,
					"title": "Expense Report",
					"topRadius": 0,
					"type": "smoothedLine",
					"valueField": "column-1",
					"visibleInLegend": false
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-1",
					"axisAlpha": 0.18,
					"axisColor": "#FFFFFF",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"minorTickLength": -2,
					"title": ""
				}
			],
			"allLabels": [],
			"balloon": {},
			"legend": {
				"enabled": true,
				"useGraphSettings": true
			},
			"titles": [],
			"dataProvider": [<?php echo $feeschart; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$dailyvolumes = '
			{"category": "0","column-1": 53},
			{"category": "1","column-1": 22},
			{"category": "2","column-1": 40},
			{"category": "3","column-1": 22},
			{"category": "4","column-1": 53},
			{"category": "5","column-1": 54},
			{"category": "6","column-1": 200},
			{"category": "7","column-1": 200},
			{"category": "8","column-1": 123},
			{"category": "9","column-1": 234},
			{"category": "10","column-1": 232},
			{"category": "11","column-1": 200},
			{"category": "12","column-1": 180},
			{"category": "13","column-1": 190},
			{"category": "14","column-1": 170},
			{"category": "15","column-1": 150},
			{"category": "16","column-1": 120},
			{"category": "17","column-1": 110},
			{"category": "18","column-1": 100},
			{"category": "19","column-1": 90},
			{"category": "20","column-1": 80}';
		}
	?>
	// Chart 7 - Daily Buy Volume
	AmCharts.makeChart("chartdiv7",
		{
			"type": "serial",
			"categoryField": "category",
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"plotAreaBorderColor": "#FFFFFF",
			"zoomOutText": "Reset",
			"sequencedAnimation": false,
			"startDuration": 0,
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"handDrawThickness": 4,
			"usePrefixes": true,
			"categoryAxis": {
				"axisAlpha": 0.09,
				"axisColor": "#FFFFFF",
				"boldPeriodBeginning": false,
				"color": "#78909C",
				"firstDayOfWeek": 6,
				"gridAlpha": 0.09,
				"gridThickness": 0,
				"markPeriodChange": false,
				"minorGridAlpha": 0,
				"minorGridEnabled": true
			},
			"trendLines": [],
			"graphs": [
				{
					"columnWidth": 1,
					"cornerRadiusTop": 3,
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 8,
					"gapPeriod": 0,
					"id": "AmGraph-2",
					"lineColor": "undefined",
					"lineColorField": "color",
					"lineThickness": 0,
					"negativeFillAlphas": 1,
					"negativeFillColors": "#E91E63",
					"negativeLineAlpha": 0,
					"negativeLineColor": "undefined",
					"tabIndex": -3,
					"title": "graph 1",
					"topRadius": 0,
					"type": "column",
					"valueField": "column-1"
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-2",
					"autoRotateAngle": 90,
					"axisAlpha": 0.09,
					"axisColor": "#FFFFFF",
					"color": "#78909C",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"labelRotation": 48.6,
					"title": "",
					"titleBold": false,
					"titleColor": "#FFFFFF",
					"titleFontSize": 0
				}
			],
			"allLabels": [],
			"titles": [],
			"dataProvider": [<?php echo $dailyvolumes; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$dailyvalues = '
			{"category": "0","column-1": 53},
			{"category": "1","column-1": 22},
			{"category": "2","column-1": 40},
			{"category": "3","column-1": 22},
			{"category": "4","column-1": 53},
			{"category": "5","column-1": 54},
			{"category": "6","column-1": 200},
			{"category": "7","column-1": 200},
			{"category": "8","column-1": 123},
			{"category": "9","column-1": 234},
			{"category": "10","column-1": 232},
			{"category": "11","column-1": 200},
			{"category": "12","column-1": 180},
			{"category": "13","column-1": 190},
			{"category": "14","column-1": 170},
			{"category": "15","column-1": 150},
			{"category": "16","column-1": 120},
			{"category": "17","column-1": 110},
			{"category": "18","column-1": 100},
			{"category": "19","column-1": 90},
			{"category": "20","column-1": 80}';
		}
	?>
	// Chart 8 - Daily Buy Value
	AmCharts.makeChart("chartdiv8",
		{
			"type": "serial",
			"categoryField": "category",
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"zoomOutText": "Reset",
			"sequencedAnimation": false,
			"startDuration": 0,
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"handDrawThickness": 4,
			"usePrefixes": true,
			"categoryAxis": {
				"axisAlpha": 0.09,
				"axisColor": "#FFFFFF",
				"boldPeriodBeginning": false,
				"color": "#78909C",
				"firstDayOfWeek": 6,
				"gridAlpha": 0.09,
				"gridThickness": 0,
				"markPeriodChange": false,
				"minorGridAlpha": 0,
				"minorGridEnabled": true
			},
			"trendLines": [],
			"graphs": [
				{
					"columnWidth": 1,
					"cornerRadiusTop": 3,
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 8,
					"gapPeriod": 0,
					"id": "AmGraph-2",
					"lineColor": "undefined",
					"lineColorField": "color",
					"lineThickness": 0,
					"negativeFillAlphas": 1,
					"negativeFillColors": "#E91E63",
					"negativeLineAlpha": 0,
					"negativeLineColor": "undefined",
					"tabIndex": -3,
					"title": "graph 1",
					"topRadius": 0,
					"type": "column",
					"valueField": "column-1"
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-2",
					"autoRotateAngle": 90,
					"axisAlpha": 0.09,
					"axisColor": "#FFFFFF",
					"color": "#78909C",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"labelRotation": 48.6,
					"title": "",
					"titleBold": false,
					"titleColor": "#FFFFFF",
					"titleFontSize": 0
				}
			],
			"allLabels": [],
			"balloon": {
				"fixedPosition": false,
				"fontSize": 10,
				"showBullet": true
			},
			"titles": [],
			"dataProvider": [<?php echo $dailyvalues; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$dpercschart = '
				{"category": "Mon","column-1": "8892.790805434","column-2": "#673ab7"},
				{"category": "Tue","column-1": "9023","column-2": "#673ab7"},
				{"category": "Wed","column-1": "10312.43075","column-2": "#673ab7"},
				{"category": "Thu","column-1": "8020","column-2": "#673ab7"},
				{"category": "Fri","column-1": "6000","column-2": "#673ab7"}
			';
		}
	?>
	// Chart 9 - Performance by Day of the Week
	AmCharts.makeChart("chartdiv9",
		{
			"type": "serial",
			"categoryField": "category",
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"plotAreaBorderColor": "#FFFFFF",
			"zoomOutText": "Reset",
			"sequencedAnimation": false,
			"startDuration": 0,
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"handDrawThickness": 4,
			"usePrefixes": true,
			"categoryAxis": {
				"axisAlpha": 0.09,
				"axisColor": "#FFFFFF",
				"boldPeriodBeginning": false,
				"color": "#78909C",
				"firstDayOfWeek": 6,
				"gridAlpha": 0.09,
				"gridThickness": 0,
				"markPeriodChange": false,
				"minorGridAlpha": 0,
				"minorGridEnabled": true,
				"titleFontSize": 0
			},
			"trendLines": [],
			"graphs": [
				{
					"columnWidth": 1,
					"cornerRadiusTop": 3,
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 15,
					"gapPeriod": 0,
					"id": "AmGraph-2",
					"lineColor": "undefined",
					"lineColorField": "color",
					"lineThickness": 0,
					"negativeFillAlphas": 1,
					"negativeFillColors": "#ff1744",
					"negativeLineAlpha": 0,
					"negativeLineColor": "undefined",
					"tabIndex": -3,
					"title": "graph 1",
					"topRadius": 0,
					"type": "column",
					"valueField": "column-1"
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-2",
					"autoRotateAngle": 90,
					"axisAlpha": 0.09,
					"axisColor": "#FFFFFF",
					"color": "#78909C",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"labelRotation": 48.6,
					"title": "",
					"titleBold": false,
					"titleColor": "#FFFFFF",
					"titleFontSize": 0
				}
			],
			"allLabels": [],
			"balloon": {
				"fixedPosition": false,
				"fontSize": 10,
				"showBullet": true
			},
			"titles": [],
			"dataProvider": [<?php echo $dpercschart; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$gplchart = '
				{"category": "0","column-1": "67592.53","column-2": "#673ab7"},
				{"category": "0","column-1": "151527.98","column-2": "#673ab7"},
				{"category": "0","column-1": "100312.43","column-2": "#673ab7"},
				{"category": "0","column-1": "8892.79","column-2": "#673ab7"},
				{"category": "4","column-1": "8892","column-2": "#673ab7"},
				{"category": "5","column-1": "100312","column-2": "#673ab7"},
				{"category": "6","column-1": "151527","column-2": "#673ab7"},
				{"category": "7","column-1": "67592","column-2": "#673ab7"},
				{"category": "8","column-1": "67592","column-2": "#673ab7"},
				{"category": "9","column-1": "151527","column-2": "#673ab7"},
				{"category": "10","column-1": "100312","column-2": "#673ab7"},
				{"category": "11","column-1": "8892","column-2": "#673ab7"},
				{"category": "12","column-1": "8892","column-2": "#673ab7"},
				{"category": "13","column-1": "100312","column-2": "#673ab7"},
				{"category": "14","column-1": "151527","column-2": "#673ab7"},
				{"category": "15","column-1": "67592","column-2": "#673ab7"},
				{"category": "16","column-1": "67592","column-2": "#673ab7"},
				{"category": "17","column-1": "151527","column-2": "#673ab7"},
				{"category": "18","column-1": "100312","column-2": "#673ab7"},
				{"category": "19","column-1": "8892","column-2": "#673ab7"},
				{"category": "20","column-1": "151527","column-2": "#673ab7"}
			';
		}
	?>
	// Chart 10 - Gross P&L (last 30 traiding days)
	AmCharts.makeChart("chartdiv10",
		{
			"type": "serial",
			"categoryField": "category",
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"plotAreaBorderColor": "#FFFFFF",
			"zoomOutText": "Reset",
			"sequencedAnimation": false,
			"startDuration": 0,
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"fontFamily": "Roboto",
			"handDrawThickness": 4,
			"usePrefixes": true,
			"categoryAxis": {
				"gridPosition": "start",
				"tickPosition": "start",
				"axisAlpha": 0.09,
				"axisColor": "#FFFFFF",
				"boldPeriodBeginning": false,
				"color": "#78909C",
				"firstDayOfWeek": 6,
				"gridAlpha": 0.09,
				"gridThickness": 0,
				"markPeriodChange": false,
				"minorGridAlpha": 0,
				"minorGridEnabled": true
			},
			"trendLines": [],
			"graphs": [
				{
					"columnWidth": 1,
					"cornerRadiusTop": 3,
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 10,
					"gapPeriod": 0,
					"id": "AmGraph-2",
					"lineColor": "undefined",
					"lineColorField": "color",
					"lineThickness": 0,
					"negativeFillAlphas": 1,
					"negativeFillColors": "#ff1744",
					"negativeLineAlpha": 0,
					"negativeLineColor": "undefined",
					"tabIndex": -3,
					"title": "graph 1",
					"topRadius": 0,
					"type": "column",
					"valueField": "column-1"
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-2",
					"autoRotateAngle": 90,
					"axisAlpha": 0.09,
					"axisColor": "#FFFFFF",
					"color": "#78909C",
					"dashLength": 3,
					"gridAlpha": 0.09,
					"gridColor": "#FFFFFF",
					"labelRotation": 48.6,
					"title": "",
					"titleBold": false,
					"titleColor": "#FFFFFF",
					"titleFontSize": 0
				}
			],
			"allLabels": [],
			"balloon": {
				"fixedPosition": false,
				"fontSize": 10,
				"showBullet": true
			},
			"titles": [],
			"dataProvider": [<?php echo $gplchart; ?>]
		}
	);
	<?php
		if($isjounalempty){
			$demotsonchart = '{"category": "Neutral","column-2": "4","Trades": "3"},{"category": "Greedy","column-2": "3","Trades": "2"},{"category": "Fearful","column-2": "1","Trades": "6"},';
		}
	?>
	// Chart 11 - Emotional Statistics
	AmCharts.makeChart("chartdiv11",
		{
			"type": "serial",
			"categoryField": "category",
			"rotate": true,
			"marginTop": 5,
			"sequencedAnimation": false,
			"startDuration": 0,
			"backgroundColor": "#0D1F33",
			"color": "#78909C",
			"usePrefixes": true,
			"categoryAxis": {
				"axisAlpha": 0,
				"axisColor": "#FFFFFF",
				"gridColor": "#FFFFFF",
				"gridThickness": 0
			},
			"trendLines": [],
			"graphs": [
				{
					"balloonText": "[[title]]: [[value]]",
					"fillAlphas": 1,
					"fillColors": "#00E676",
					"fixedColumnWidth": 15,
					"id": "AmGraph-1",
					"lineAlpha": 0,
					"title": "Wins",
					"type": "column",
					"valueField": "Trades",
					"cornerRadiusTop": 3,
				},
				{
					"balloonText": "[[title]]: [[value]]",
					"fillAlphas": 1,
					"fillColors": "#ff1744",
					"fixedColumnWidth": 15,
					"id": "AmGraph-2",
					"lineThickness": 0,
					"title": "Losses",
					"type": "column",
					"valueField": "column-2",
					"cornerRadiusTop": 3,
				}
			],
			"guides": [],
			"valueAxes": [
				{
					"id": "ValueAxis-1",
					"stackType": "regular",
					"axisAlpha": 0.19,
					"axisColor": "#FFFFFF",
					"dashLength": 3,
					"gridAlpha": 0.22,
					"gridColor": "#FFFFFF",
					"title": ""
				}
			],
			"allLabels": [],
			"balloon": {},
			"titles": [],
			"dataProvider": [<?php echo $demotsonchart; ?>]
		}
	);

	<?php
		if($isjounalempty){
			$intowinchartbands = '
			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "55%","alpha": 0.05},
			{ "color": "#0d785a", "startValue": 0, "endValue": 45, "radius": "100%", "innerRadius": "55%", "balloonText": "45%"},

			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "70%","alpha": 0.05},
			{ "color": "#06af68", "startValue": 0, "endValue": 65, "radius": "100%", "innerRadius": "70%", "balloonText": "65%"},

			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "85%","alpha": 0.05},
			{ "color": "#00e676", "startValue": 0, "endValue": 90, "radius": "100%", "innerRadius": "85%", "balloonText": "90%"},';

			$intowinchartlabels = '
			{"text": "Stock 1","x": "49%","y": "7%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
			{"text": "Stock 2","x": "49%","y": "13%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
			{"text": "Stock 3","x": "49%","y": "19%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",}';
		}
	?>
	/* Top Stocks: Winners */
	var gaugeChart = AmCharts.makeChart("topstockswinners", {
	  "type": "gauge",
	  "theme": "none",
	  "sequencedAnimation": false,
	  "startDuration": 0,
	  "axes": [{
		"axisAlpha": 0,
		"tickAlpha": 0,
		"labelsEnabled": false,
		"startValue": 0,
		"endValue": 100,
		"startAngle": 0,
		"endAngle": 270,
		"bands": [<?php echo $intowinchartbands; ?>]
	  }],
	  "allLabels": [<?php echo $intowinchartlabels; ?>],
	});

	<?php
		if($isjounalempty){
			$intolosschartbands = '
			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "55%","alpha": 0.05},
			{ "color": "#442946", "startValue": 0, "endValue": 20, "radius": "100%", "innerRadius": "55%", "balloonText": "20%"},

			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "70%","alpha": 0.05},
			{ "color": "#732546", "startValue": 0, "endValue": 60, "radius": "100%", "innerRadius": "70%", "balloonText": "60%"},

			{"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "85%","alpha": 0.05},
			{ "color": "#b91e45", "startValue": 0, "endValue": 80, "radius": "100%", "innerRadius": "85%", "balloonText": "80%"},
			';

			$intolosschartlabels = '
			{"text": "Stock 1","x": "49%","y": "7%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
			{"text": "Stock 2","x": "49%","y": "13%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
			{"text": "Stock 3","x": "49%","y": "19%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",}';
		}
	?>

	/* Top Stocks: Losers */
	var gaugeChart = AmCharts.makeChart("topstocksLosers", {
	  "type": "gauge",
	  "theme": "none",
	  "sequencedAnimation": false,
	  "startDuration": 0,
	  "axes": [{
		"axisAlpha": 0,
		"tickAlpha": 0,
		"labelsEnabled": false,
		"startValue": 0,
		"endValue": 100,
		"startAngle": 0,
		"endAngle": 270,
		"bands": [<?php echo $intolosschartbands; ?>]
	  }],
	  "allLabels": [<?php echo $intolosschartlabels; ?>],
	});

    jQuery(document).on('keyup change', 'input.number', function (event) {
            // skip for arrow keyssss
            if (event.which >= 37 && event.which <= 40) {
                event.preventDefault();
            }

            var currentVal = jQuery(this).val();
            var testDecimal = testDecimals(currentVal);
            if (testDecimal.length > 1) {
                currentVal = currentVal.slice(0, -1);
            }
            jQuery(this).val(replaceCommas(currentVal));
            
        //});

        function testDecimals(currentVal) {
            var count;
            currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
            return count;
        }

        function replaceCommas(yourNumber) {
            var components = yourNumber.toString().split(".");
            if (components.length === 1) 
                components[0] = yourNumber;
            components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if (components.length === 2)
                components[1] = components[1].replace(/\D/g, "");
            return components.join(".");
        }

    });

</script>


</div>
<?php
require "journal/footer-files.php";
