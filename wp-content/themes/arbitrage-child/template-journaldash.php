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

get_header('dashboard');

// echo $user->ID ." versis ". $user->ID;


?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


<!-- <script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.js"></script>
<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.min.js"></script> -->




<!-- <link href="../calendar-assets/bootstrap-year-calendar.css" rel="stylesheet">
<link href="../calendar-assets/bootstrap-year-calendar.min.css" rel="stylesheet"> -->

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
<!-- EOF Ledger Data -->
<div class="record_modal">
	<div class="record_main">
		<div class="record_header">
			<span class="record_head_label">Record A Trade<i class="fas fa-close to_closethis_rec"></i></span>
		</div>
		<form action="/journal" method="post">
			<div class="record_body row">
				<div class="col-md-6" style="border-right: 1px solid #1c2d3f;">
					<span class="label_thisleft">Bought</span>
					<div class="groupinput midd rec_label_date">
						<label>Enter Date</label><input type="date" name="boughtdate" class="inpt_data_boardlot_get buySell__date-picker" required="" id="" max="2019-09-16">
					</div>
					<div class="groupinput midd lockedd"><label>Stock</label>
						<!-- <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="" readonly> -->
						<select name="inpt_data_stock_bought" id="inpt_data_stock_bought" style="margin-left: -4px; text-align: left;width: 138px;">
							<option value="">Select Stocks</option>
							<?php foreach($listosstocks as $dstkey => $dstvals): ?>
								<option value='<?php echo $dstvals->symbol; ?>'><?php echo $dstvals->symbol; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="inpt_data_stock" id="dfinstocks">
						<!-- <i class="fa fa-lock" aria-hidden="true"></i> -->
					</div>
					<div class="groupinput midd"><label>Enter Price</label><input type="text" id="" name="inpt_data_price_bought" class="textfield-buyprice number" required></div>
					<div class="groupinput midd" style="margin-bottom: 5px;"><label>Quantity</label><input type="text" id="" name="inpt_data_qty_bought" class="textfield-quantity number" required></div>
					<div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_bought_price" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
				</div>

				<div class="col-md-6">
					<span class="label_thisright">Sold</span>
					<div class="groupinput midd rec_label_date">
						<label>Enter Date</label><input type="date" name="solddate" class="inpt_data_boardlot_get buySell__date-picker" required="" id="" max="2019-09-16">
					</div>
					<div class="groupinput midd"><label>Enter Price</label><input type="text" id="" name="inpt_data_price_sold" class="textfield-buyprice number" required></div>
					<div class="groupinput midd" style="margin-bottom: 5px;"><label>Quantity</label><input type="text" id="" name="inpt_data_qty_sold" class="textfield-quantity number" required></div>
					<div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_sold_price" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
					<div class="groupinput midd lockedd label_cost"><label>Profit/Loss: </label><input readonly="" type="text" class="number" name="inpt_data_total_sold_profitloss" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
				</div>
				<div class="entr_wrapper_mid">
					<div class="entr_col">
						<div class="groupinput selectonly">
							<select name="inpt_data_strategy" class="rnd">
								<option value="" selected>Select Strategy</option>
								<option value="Bottom Picking">Bottom Picking</option>
								<option value="Breakout Play">Breakout Play</option>
								<option value="Trend Following">Trend Following</option>
							</select>
						</div>
					</div>
					<div class="entr_col">
						<div class="groupinput selectonly">
							<select name="inpt_data_tradeplan" class="rnd">
								<option value="" selected>Select Trade Plan</option>
								<option value="Day Trade">Day Trade</option>
								<option value="Swing Trade">Swing Trade</option>
								<option value="Investment">Investment</option>
							</select>
						</div>
					</div>
					<div class="entr_col">
						<div class="groupinput selectonly">
							<select name="inpt_data_emotion" class="rnd">
								<option value="" selected>Select Emotion</option>
								<option value="Neutral">Neutral</option>
								<option value="Greedy">Greedy</option>
								<option value="Fearful">Fearful</option>
							</select>
						</div>
					</div>
					<div class="groupinput">
						<textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
						<!-- <div>this is it</div> -->
					</div>
					</div>
			</div>
			<div class="record_footer row">
				<div class="dbuttonrecord_onmodal">
					<form action="" method="post" class="recordform">
						<!-- <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;"> -->
						<input type="hidden" name="recorddata" value="record">
						<input type="hidden" name="inpt_data_status" value="record">
						<input type="submit" name="record" value="Record" class="record-data-btn recorddata">
					</form>
				</div>
			</div>
		</form>
	</div>
</div>
<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                    	<?php echo get_template_part('parts/sidebar', 'profile'); ?>
						 <?php
                        //   get_template_part('parts/sidebar', 'traders');
                         ?>
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
						                            <li class="<?php echo isset($_GET['pt']) ? 'active' : ''; ?>"><a href="#tab2" data-toggle="tab" class="<?php echo isset($_GET['pt']) ? 'active show' : ''; ?>">Tradelogs</a></li>
						                            <li class="<?php echo isset($_GET['ld']) ? 'active' : ''; ?>"><a href="#tab3" data-toggle="tab" class="<?php echo isset($_GET['ld']) ? 'active show' : ''; ?>">Ledger</a></li>
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
                                                        		<div class="dbuttonenter">
                                                        			<!-- <form action="/journal" method="post"> -->
                                                        				<!-- <input type="submit" name="entertradebtn" value="Trade" class="enter-trade-btn"> -->
																		<a href="#entertrade_mtrade" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Trade</a>
																		<div class="hideformodal">
																			
																			<div class="entertrade dtopentertrade" id="entertrade_mtrade">
																				<div class="entr_ttle_bar">
																					<strong>Enter Buy Order</strong> <span class="datestamp_header"><?php /*echo date('F j, Y g:i a');*/ ?></span>
																				</div>
																				<form action="/journal" method="post" class="dentertrade" autocomplete="off">
																				<div class="entr_wrapper_top">
																						<div class="entr_col">
																							<div class="groupinput fctnlhdn">
																								<label style="width:100%">Buy Date:</label>
																								<input type="hidden" name="inpt_data_buymonth" value="<?php echo date('F'); ?>">
																								<input type="hidden" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
																								<input type="hidden" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
																							</div>
																							<div class="groupinput midd lockedd"><label>Stock</label>
																								<!-- <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="" readonly> -->
																								<select name="inpt_data_stock_y" id="inpt_data_select_stock" style="margin-left: -4px; text-align: left;width: 138px;">
																									<option value="">Select Stocks</option>
																									<?php foreach($listosstocks as $dstkey => $dstvals): ?>
																										<option value='<?php echo json_encode($dstvals); ?>'><?php echo $dstvals->symbol; ?></option>
																									<?php endforeach; ?>
																								</select>
																								<input type="hidden" name="inpt_data_stock" id="dfinstocks">
																								<!-- <i class="fa fa-lock" aria-hidden="true"></i> -->
																							</div>
																							<div class="groupinput midd"><label>Enter Price</label><input type="text" id="entertopdataprice" name="inpt_data_price" class="textfield-buyprice number" required></div>
																							<div class="groupinput midd"><label>Quantity</label><input type="text" id="entertopdataquantity" name="inpt_data_qty" class="textfield-quantity number" required></div>
																							<div class="groupinput midd label_date">
																								<label>Enter Date</label><input type="date" class="inpt_data_boardlot_get buySell__date-picker" required id="journal__trade-btn--date-picker">
																							</div>
																							<div class="groupinput midd lockedd label_funds"><label>Available Funds: </label>
																							<input type="text" name="input_buy_product" id="input_buy_product" class="number" step="0.01" style="margin-left: -4px;" value="<?php echo number_format($buypower, 2, '.', ','); ?>" readonly>
																							<i class="fa fa-lock" aria-hidden="true" style="display: none;"></i></div>
																							<div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_price" value=""><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
																						</div>
																						<div class="entr_col">
																							<div class="groupinput midd lockedd"><label>Curr. Price</label><input readonly type="text" name="inpt_data_currprice" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd"><label>Change</label><input readonly type="text" name="inpt_data_change" value="%"><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd"><label>Open</label><input readonly type="text" name="inpt_data_open" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd"><label>Low</label><input readonly type="text" name="inpt_data_low" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd"><label>High</label><input readonly type="text" name="inpt_data_high" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																						</div>
																						<div class="entr_col">
																							<div class="groupinput midd lockedd"><label>Volume</label><input readonly type="text" name="inpt_data_volume" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd"><label>Value</label><input readonly type="text" name="inpt_data_value" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
																							<div class="groupinput midd lockedd">
																								<label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="" value="0" readonly>
																								<i class="fa fa-lock" aria-hidden="true"></i>
																								<input type="hidden" id="inpt_data_boardlot_get" value="0">
																							</div>

                                                                                            


																						</div>
																						<div class="entr_clear"></div>
																				</div>
																				<div class="entr_wrapper_mid">
																					<div class="entr_col">
																						<div class="groupinput selectonly">
																							<select name="inpt_data_strategy" class="rnd">
																								<option value="" selected>Select Strategy</option>
																								<option value="Bottom Picking">Bottom Picking</option>
																								<option value="Breakout Play">Breakout Play</option>
																								<option value="Trend Following">Trend Following</option>
																							</select>
																						</div>
																					</div>
																					<div class="entr_col">
																						<div class="groupinput selectonly">
																							<select name="inpt_data_tradeplan" class="rnd">
																								<option value="" selected>Select Trade Plan</option>
																								<option value="Day Trade">Day Trade</option>
																								<option value="Swing Trade">Swing Trade</option>
																								<option value="Investment">Investment</option>
																							</select>
																						</div>
																					</div>
																					<div class="entr_col">
																						<div class="groupinput selectonly">
																							<select name="inpt_data_emotion" class="rnd">
																								<option value="" selected>Select Emotion</option>
																								<option value="Neutral">Neutral</option>
																								<option value="Greedy">Greedy</option>
																								<option value="Fearful">Fearful</option>
																							</select>
																						</div>
																					</div>
																					<div class="groupinput">
																						<textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
																						<!-- <div>this is it</div> -->
																					</div>
																					<div class="groupinput">
																							<img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
																						<input type="hidden" value="Live" name="inpt_data_status">
																						<input type="hidden" id="newdate" name="newdate">
																						<input type="submit" class="confirmtrd dloadform green modal-button-confirm" value="Confirm Trade">
																					</div>
																					</div>
																				</form>
																			</div>
																		</div>
                                                        			<!-- </form> -->
                                                        		</div>

                                                                <!--------- Add funds --------------------------------------->

                                                                <div class="button" style="float: right; margin-top: 3px;margin-left: -10px;">
                                                                    <a href="#" data-toggle="modal" data-target="#depositmods" class="arbitrage-button arbitrage-button--primary" style="padding: 5px 10px;font-weight: 400;">Fund</a>
                                                                    <div class="modal" id="depositmods" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-modelbox-margin" role="document" style="left: 0; width: 300px">
                                                                            <div class="modal-content modalfund">
                                                                                <div class="modal-header header-depo">

                                                                                 <span class="fundtabs" id="funds"> 
                                                                                    <ul class="nav panel-tabs">
                                                                                        <li class="active">
                                                                                            <a href="#tabdeposit" data-toggle="tab" class="active show">Deposit</a>
                                                                                        </li>
                                                                                        <?php if ($dbaseaccount > 0): ?>
                                                                                        <li>
                                                                                            <a href="#tabwithdraw" data-toggle="tab" class="">Withdraw</a>
                                                                                        </li>
                                                                                        <?php endif; ?>
                                                                                    </ul>
                                                                                </span> 
                                                                                    <button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
                                                                                        <i class="fas fa-times modal-btn-close-deposit"></i>
                                                                                    </button>
                                                                                </div>
                                                                <div class="tab-content">
                                                                    <div class="tab-pane active show" id="tabdeposit">
                                                                                <hr class="style14 style15">
                                                                                <div class="button-funds groupinput select" style="z-index: 25; margin-bottom: 0; margin-left: 4px;">
                                                                                    <select class="rnd" name="" id="selectdepotype" style="z-index: 20;">
                                                                                        <option class="deposit-modal-btn show-button1" value="deposit">Deposit Funds</option>
                                                                                        <option class="deposit-modal-btn show-button2" value="dividend">Dividend Income</option>
                                                                                    </select>
                                                                                </div>
                                                                                <form action="/journal" method="post" class="add-funds-show depotincome">
                                                                                   <!-- <div class="modal-body depo-body">-->
                                                                                        <div class="dmainform">
                                                                                            <div class="dinnerform">
                                                                                                <div class="dinitem" style="margin: 10px;">
                                                                                                    <h5 class="modal-title title-depo-in" id="exampleModalLabel" style="font-weight: 300;font-size: 13px;">Enter Amount</h5>
                                                                                                    <!-- <div class="dnlabel">Amount</div> -->
                                                                                                    <div class="dninput"><input type="text" name="damount" class="depo-input-field number" style="background: #4e6a85; text-align: right;"></div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                   <!-- </div>-->

                                                                                    <div class="modal-footer footer-depo">
                                                                                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                                                                        <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                                                                        <input type="hidden" name="istype" value="deposit">
                                                                                        <!-- <input type="submit" name="subs" value="Deposit" class="depotbutton arbitrage-button arbitrage-button--primary"> -->
                                                                                        <a href="#" class="depotbutton arbitrage-button arbitrage-button--primary" style="font-size: 12px;font-weight: 300; padding: 3px 14px;">Deposit</a>
                                                                                        <!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
                                                                                    </div>
                                                                                </form>
                                                                                <form action="/journal" method="post" class="add-funds-shows dividincome" style="display: none;">
                                                                                        <div class="modal-body depo-body">
                                                                                            <div class="dmainform">
                                                                                                <div class="dinnerform">
                                                                                                    <div class="dinitem">
                                                                                                        <h5 class="modal-title title-depo-in" id="exampleModalLabel">Dividend Income</h5>
                                                                                                        <!-- <div class="dnlabel">Amount</div> -->
                                                                                                        <div class="dninput modal-title-content-dev"><input type="text" name="damount" class="depo-input-field" style="text-align: right;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer footer-depo">
                                                                                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                                                                            <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                                                                            <input type="hidden" name="istype" value="dividend">
                                                                                            <!-- <input type="submit" name="subs" value="Deposit" class="divibutton arbitrage-button arbitrage-button--primary"> -->
                                                                                            <a href="#" class="divibutton arbitrage-button arbitrage-button--primary">Deposit</a>
                                                                                            <!-- <input type="submit" name="subs" value="Deposit Now!" class="depo-mon-btn"> -->
                                                                                            <!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
                                                                                        </div>
                                                                                </form>
                                                                        </div>
                                                                    <div class="tab-pane" id="tabwithdraw">                                                                                                        
                                                                        <form action="/journal" method="post">
                                                                                        <div class="modal-header header-depo">
                                                                                            <h5 class="modal-title title-depo" id="exampleModalLabel"></h5>
                                                                                        </div>
                                                                                        <hr class="style14 style15">
                                                                                        <div class="modal-body depo-body">
                                                                                            <div class="dmainform-withraw" style="margin-top: 28px;">
                                                                                                <div class="dinnerform">
                                                                                                    <div class="dinitem arb_wdrw">
                                                                                                        <div class="dnlabel arb_wdrw_left" style="font-size: 13px;font-weight: 300;">Enter Amount</div>
                                                                                                        <div class="dninput arb_wdrw_right"><input type="text" class="dwithdrawnum depo-input-field number" style="padding: 3px 11px 3px 11px !important;" data-dpower="<?php echo $dbaseaccount; ?>" name="damount" placeholder="<?php //echo number_format($dbaseaccount, 2, '.', ','); ?>"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer footer-depo">
                                                                                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                                                                            <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                                                                            <input type="hidden" name="istype" value="withraw">
                                                                                            <input type="submit" class="dwidfunds arbitrage-button arbitrage-button--primary" name="subs" value="Withdraw" style="margin-bottom: 3px; margin-top: 10px;">
                                                                                            <!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
                                                                                        </div>
                                                                                    </form>
                                                                                </div>    

                                                                                </div><!---------------------->
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                              <!---- -------------------------------------------------------->

                                                              <!---------------Withdraw----------------->
                                                              <!--
                                                                        <div class="modal" id="withdrawmods" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-modelbox-margin" role="document" style="left: 0;">
                                                                                <div class="modal-content">
                                                                                    <form action="/journal" method="post">
                                                                                        <div class="modal-header header-depo">
                                                                                            <h5 class="modal-title title-depo" id="exampleModalLabel">Withdraw</h5>
                                                                                            <button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
                                                                                            <i class="fas fa-times modal-btn-close-deposit"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <hr class="style14 style15">
                                                                                        <div class="modal-body depo-body">
                                                                                            <div class="dmainform-withraw">
                                                                                                <div class="dinnerform">
                                                                                                    <div class="dinitem arb_wdrw">
                                                                                                        <div class="dnlabel arb_wdrw_left">Please enter your amount</div>
                                                                                                        <div class="dninput arb_wdrw_right"><input type="number" class="dwithdrawnum depo-input-field sss" style="padding: 0px 11px 0px 11px !important;" data-dpower="<?php //echo $dbaseaccount; ?>" name="damount" placeholder="<?php// echo number_format($dbaseaccount, 2, '.', ','); ?>"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer footer-depo">
                                                                                          
                                                                                            <input type="hidden" name="ddate" value="<?php //echo date('Y-m-d'); ?>">
                                                                                            <input type="hidden" name="istype" value="withraw">
                                                                                            <input type="submit" class="dwidfunds arbitrage-button arbitrage-button--primary" name="subs" value="Withdraw" style="margin-bottom: 3px; margin-top: 10px;">
                                                                                          
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div> -->

                                                              <!-------------------------------->

                                                        	</div>
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <div id="live_portfolio" class="dstatstrade overridewidth">
                                                                        <ul>
                                                                            <li class="headerpart">
                                                                            	<div style="width:100%;">
                                                                                    <div style="width:7%; text-align: left !important;">Stocks</div>
                                                                                    <div style="width:8%" class="table-title-live table-title-avprice">Position</div>
                                                                                    <!--<div style="width:11%">Average Price</div>-->
                                                                                    <div style="width:10%" class="table-title-live table-title-avprice">Avg. Price</div>
                                                                                    <div style="width:14%" class="table-title-live table-title-tcost">Total Cost</div>
                                                                                    <!--<div style="width:11%">Market Value</div>-->
                                                                                    <div style="width:14%" class="table-title-live table-title-mvalue">Market Value</div>
                                                                                    <div style="width:14%" class="table-title-live table-title-profit">Profit</div>
                                                                                    <!--<div style="width:9%">Performance</div>-->
                                                                                    <div style="width:7%" class="table-title-live table-title-performance">Perf.</div>
                                                                                    <div style="width:77px; text-align:center;">Action</div>
                                                                                    <!--<div style="width:45px; text-align: right;">Notes</div>-->
                                                                                </div>
                                                                            </li>
                                                                            <?php
																			
                                                                            if ($getdstocks) {
                                                                                foreach ($getdstocks as $key => $value) {
																					
																					

																					if(!$isjounalempty){
																						$dstocktraded = get_user_meta($user->ID, '_trade_'.$value, true);
																					} else {
																						if($value == 'SampleStock_1'){
																							$dstocktraded = [
																								'data' => [
																									[
																										'buymonth' => 'August',
																										'buyday' => 22,
																										'buyyear' => 2019,
																										'stock' => 'MBT',
																										'price' => 100,
																										'qty' => 620,
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
																								'totalstock' => 620,
																								'aveprice' => 2228.5209688868,
																								'totalcost' => 84225991.13847,
																								'stockname' => 'SampleStock_1',
																							];
																						} else {
																							$dstocktraded = [
																								'data' => [
																									[
																										'buymonth' => 'August',
																										'buyday' => 22,
																										'buyyear' => 2019,
																										'stock' => 'MBT',
																										'price' => 90,
																										'qty' => 600,
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
																								'totalstock' => 600,
																								'aveprice' => 2228.5209688868,
																								'totalcost' => 84225991.13847,
																								'stockname' => 'Sample_2',
																							];
																						}
																						
																						
																					}
                                                                                    if ($dstocktraded && $dstocktraded != '') {
																						$key = array_search($value, array_column($gerdqoute->data, 'symbol'));
																						$stockdetails = $gerdqoute->data[$key];

																						$dstockinfo = $stockdetails;
																						if($isjounalempty){
																							$dstockinfo = new \stdClass();
																							$dstockinfo->last = 100.50;
																						}

                                                                                        $totalmarketvalue = 0;
                                                                                        $dtotalcosts = 0;
                                                                                        $dselltotal = 0;
                                                                                        $intcost = 0;
																						$totalquanta = 0;
																						
																						$favtotal = 0;
																						$favvols = 0;
																						

                                                                                        foreach ($dstocktraded['data'] as $dtradeissuekey => $dtradeissuevalue) {
                                                                                            $dmarketvalue = $dtradeissuevalue['price'] * $dtradeissuevalue['qty'];
                                                                                            $dfees = getjurfees($dmarketvalue, 'buy');
                                                                                            $totalmarketvalue += $dmarketvalue;
                                                                                            $dtotalcosts += $dmarketvalue + $dfees;
                                                                                            $totalquanta += $dtradeissuevalue['qty'];
																							$intcost = $dtradeissuevalue['price'];

																							$favvols += $dtradeissuevalue['qty'];
																							$favtotal += $dmarketvalue + $dfees;
																							// calculate averate price
																							// echo ($dmarketvalue + $dfees)."~";
																						}

																						$avrprice = $favtotal / $favvols;
																						
																						// echo $dstockinfo->last;

                                                                                        $dsellmarket = $dstockinfo->last * $dstocktraded['totalstock'];
                                                                                        $dsellfees = getjurfees($dsellmarket, 'sell');
																						$dselltotal += $dsellmarket - $dsellfees;
																						
																						// echo $favtotal;
																						$totalfixmarktcost = $favtotal;

                                                                                        // $totalfixmarktcost = $dstocktraded['totalstock'] * $dstocktraded['aveprice'];
                                                                                        // $totalfinalcost = $totalfixmarktcost + getjurfees($totalfixmarktcost, 'buy');

                                                                                        $totalbuyfee = getjurfees($totalfixmarktcost, 'buy');
                                                                                        $totalfinalcost = $totalfixmarktcost - $totalbuyfee;

                                                                                        $dprofit = ($dselltotal - $totalfixmarktcost);
                                                                                        $profpet = (abs($dprofit) / $totalfixmarktcost) * 100; ?>
																	            	<li>
		                                                                            	<div style="width:99%;">
		                                                                                    <div style="width:7%;color: #fffffe;"><a target="_blank" class="stock-label" href="/chart/<?php echo $value; ?>"><?php echo $value; ?></a>	</div>
		                                                                                    <div style="width:8%" class="table-cell-live"><?php echo number_format($dstocktraded['totalstock'], 0, '.', ','); ?></div>
		                                                                                    <div style="width:10%" class="table-cell-live">&#8369;<?php echo number_format($avrprice, 3, '.', ','); ?></div>
		                                                                                    <div style="width:14%" class="table-cell-live">&#8369;<?php echo number_format($totalfixmarktcost, 2, '.', ','); ?></div>
		                                                                                    <div style="width:14%" class="table-cell-live">&#8369;<?php echo number_format($dselltotal, 2, '.', ','); ?></div>
		                                                                                   <!-- <div style="width:11%" class="<?php //echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart');?>">&#8369;<?php //echo number_format( $dprofit, 2, '.', ',' );?></div>-->
		                                                                                    <div style="width:14%" class="<?php echo $dprofit < 0 ? 'dredpart' : 'dgreenpart'; ?> table-cell-live">&#8369;<?php echo number_format($dprofit, 2, '.', ','); ?></div>
		                                                                                    <!--<div style="width:9%" class="<?php //echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart');?>"><?php //echo ($dprofit < 0 ? '-' : '')?><?php //echo number_format( $profpet, 2, '.', ',' );?>%</div>-->
		                                                                                     <div style="width:7%" class="<?php echo $dprofit < 0 ? 'dredpart' : 'dgreenpart'; ?> table-cell-live"><?php echo $dprofit < 0 ? '-' : ''; ?><?php echo number_format($profpet, 2, '.', ','); ?>%</div>
		                                                                                    <div style="width:77px;text-align:center;"><?php /*?>Action<?php */?>
																							<a href="#entertrade_<?php echo $value; ?>" class="smlbtn fancybox-inline green" style="border: 0px;color:#27ae60;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#27ae60'">BUY</a>
		                                                                                    <a href="#selltrade_<?php echo $value; ?>" class="smlbtn fancybox-inline red" style="border: 0px;color:#e64c3c;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#e64c3c'">SELL</a>
																							
																								<div class="hideformodal">
		                                                                                        	<div class="selltrade selltrade--align" id="selltrade_<?php echo $value; ?>">

																			                            <div class="entr_ttle_bar">
																											<strong>Sell Trade</strong>
																											<!-- <span class="datestamp_header"><?php echo date('F j, Y g:i a'); ?></span> -->
																			                            </div>

																			                            <form action="/journal" method="post">

																			                            <div class="entr_wrapper_top">

																			                                    <div class="entr_col">
																			                                        <div class="groupinput fctnlhdn">
																			                                            <label>Sell Date</label>
																			                                            <select name="inpt_data_sellmonth" style="width:90px;">
																			                                                <option value="<?php echo date('F'); ?>" selected><?php echo date('F'); ?></option>
																			                                                <option value="">- - -</option>
																			                                                <option value="January">January</option>
																			                                                <option value="Febuary">Febuary</option>
																			                                                <option value="March">March</option>
																			                                                <option value="April">April</option>
																			                                                <option value="May">May</option>
																			                                                <option value="June">June</option>
																			                                                <option value="July">July</option>
																			                                                <option value="August">August</option>
																			                                                <option value="September">September</option>
																			                                                <option value="October">October</option>
																			                                                <option value="November">November</option>
																			                                                <option value="December">December</option>
																			                                            </select>
																			                                            <input type="text" name="inpt_data_sellday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
																			                                            <input type="text" name="inpt_data_sellyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
																			                                            </div>

																			                                        <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock"
																			                                        value="<?php echo $value; ?>" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>

																			                                        <div class="groupinput midd lockedd"><label>Position</label><input type="text" name="inpt_data_price"
																			                                        value="<?php echo number_format($dstocktraded['totalstock'], 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>


																			                                    </div>

																			                                    <div class="entr_col">
																			                                    	<div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" name="inpt_avr_price_b"
																			                                        value="&#8369;<?php echo number_format($dstocktraded['aveprice'], 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

																			                                        <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_price"
																			                                        value="&#8369;<?php echo number_format($dstockinfo->last, 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>


																			                                    </div>
																			                                    <div class="entr_col">
																			                                    	<div class="groupinput midd"><label>Sell Price</label><input step="0.01" name="inpt_data_sellprice" class="no-padding" id="sell_price--input" required></div>

																			                                   		<div class="groupinput midd"><label>Qty.</label><input name="inpt_data_qty"
																													value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>" class="no-padding" id="qty_price--input" required></div>
																													
																													<div class="groupinput midd inpt_data_price"><label>Sell Date</label><input type="date" name="selldate" class="buySell__date-picker trade_input changeselldate"></div>
																												</div>

																			                                    <div class="entr_clear"></div>

																			                            </div>
																			                            <div>
																			                                <div style="height: 36px;">
                                                                                                                 <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
                                                                                
																			                                    <input type="hidden" value="Log" name="inpt_data_status">
																			                                    <input type="hidden" value="<?php echo $dstocktraded['aveprice']; ?>" name="inpt_avr_price">
																			                                    <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
																												<input type="hidden" name="dtradelogs" value='<?php echo json_encode($dstocktraded['data']); ?>'>
																												<!-- <input type="hidden" name="selldate" id="selldate"> -->
																			                                    <input type="submit" id="buy-order--submit" class="confirmtrd green buy-order--submit" value="Confirm Trade">
																			                                </div>

																			                             </div>

																			                            </form>
																			                        </div>
		                                                                                        	<div class="entertrade buyaddtrade" id="entertrade_<?php echo $value; ?>">
																	                                    <div class="entr_ttle_bar">
																	                                        <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php echo date('F j, Y g:i a'); ?><input type="date" class="buySell__date-picker" onchange="buydate(this);"></span>
																	                                    </div>
																	                                    <form action="/journal" method="post">
																	                                    <div class="entr_wrapper_top">
																	                                            <div class="entr_col">
																	                                                <div class="groupinput fctnlhdn">
																	                                                  <label style="width:100%">Buy Date:</label>
																	                                                  <input type="hidden" name="inpt_data_buymonth" value="<?php echo date('F'); ?>">
																	                                                  <input type="hidden" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
																	                                                  <input type="hidden" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
																	                                                </div>
																	                                                <div class="groupinput midd lockedd"><label>Stock</label>
																	                                                <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -4px; text-align: left;" value="<?php echo $value; ?>" readonly>
																	                                                <i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>Buy Power</label>
																	                                                <input type="text" name="input_buy_product" id="input_buy_product" class="number" style="margin-left: -4px;" value="<?php echo number_format($buypower, 2, '.', ','); ?>" readonly>
																	                                                <i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd"><label>Buy Price</label><input type="text" name="inpt_data_price" class="textfield-buyprice number" required></div>
																	                                                <div class="groupinput midd"><label>Quantity</label><input type="text" name="inpt_data_qty" class="textfield-quantity number" required></div>
																	                                            </div>
																	                                            <div class="entr_col">
																	                                                <div class="groupinput midd lockedd"><label>Curr. Price</label><input readonly type="text" name="inpt_data_currprice" value="&#8369;<?php echo number_format($dstockinfo->last, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>Change</label><input readonly type="text" name="inpt_data_change" value="<?php echo $dstockinfo->change; ?>%"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>Open</label><input readonly type="text" name="inpt_data_open" value="&#8369;<?php echo number_format($dstockinfo->open, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>Low</label><input readonly type="text" name="inpt_data_low" value="&#8369;<?php echo number_format($dstockinfo->low, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>High</label><input readonly type="text" name="inpt_data_high" value="&#8369;<?php echo number_format($dstockinfo->high, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                            </div>
																	                                            <div class="entr_col">
																	                                                <div class="groupinput midd lockedd"><label>Volume</label><input readonly type="text" name="inpt_data_volume" value="<?php echo number_format_short($dstockinfo->volume); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd"><label>Value</label><input readonly type="text" name="inpt_data_value" value="<?php echo number_format_short($dstockinfo->value); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
																	                                                <div class="groupinput midd lockedd">
																	                                                	<?php
                                                                                                                            $dboard = 0;
																															if ($dstockinfo->last >= 0.0001 && $dstockinfo->last <= 0.0099) {
																																$dboard = 1000000;
																															} elseif ($dstockinfo->last >= 0.01 && $dstockinfo->last <= 0.049) {
																																$dboard = 100000;
																															} elseif ($dstockinfo->last >= 0.05 && $dstockinfo->last <= 0.495) {
																																$dboard = 10000;
																															} elseif ($dstockinfo->last >= 0.5 && $dstockinfo->last <= 4.99) {
																																$dboard = 1000;
																															} elseif ($dstockinfo->last >= 5 && $dstockinfo->last <= 49.95) {
																																$dboard = 100;
																															} elseif ($dstockinfo->last >= 50 && $dstockinfo->last <= 999.5) {
																																$dboard = 10;
																															} elseif ($dstockinfo->last >= 1000) {
																																$dboard = 5;
																															} ?>
																	                                                    <label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="" value="<?php echo $dboard; ?>" readonly>
																	                                                    <i class="fa fa-lock" aria-hidden="true"></i>

																	                                                    <input type="hidden" id="inpt_data_boardlot_get" value="<?php echo $dboard; ?>">
																	                                                </div>
																	                                            </div>
																	                                            <div class="entr_clear"></div>
																	                                    </div>
																	                                    <div class="entr_wrapper_mid">
																	                                        <div class="entr_col">
																	                                            <div class="groupinput selectonly">
																	                                                <select name="inpt_data_strategy" class="rnd">
																	                                                    <option value="" selected>Select Strategy</option>
																	                                                    <option value="Bottom Picking">Bottom Picking</option>
																	                                                    <option value="Breakout Play">Breakout Play</option>
																	                                                    <option value="Trend Following">Trend Following</option>
																	                                                </select>
																	                                            </div>
																	                                        </div>
																	                                        <div class="entr_col">
																	                                            <div class="groupinput selectonly">
																	                                                <select name="inpt_data_tradeplan" class="rnd">
																	                                                    <option value="" selected>Select Trade Plan</option>
																	                                                    <option value="Day Trade">Day Trade</option>
																	                                                    <option value="Swing Trade">Swing Trade</option>
																	                                                    <option value="Investment">Investment</option>
																	                                                </select>
																	                                            </div>
																	                                        </div>
																	                                        <div class="entr_col">
																	                                            <div class="groupinput selectonly">
																	                                                <select name="inpt_data_emotion" class="rnd">
																	                                                    <option value="" selected>Select Emotion</option>
																	                                                    <option value="Nuetral">Neutral</option>
																	                                                    <option value="Greedy">Greedy</option>
																	                                                    <option value="Fearful">Fearful</option>
																	                                                </select>
																	                                            </div>
																	                                        </div>
																	                                        <div class="groupinput">
																	                                            <textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
																	                                            <!-- <div>this is it</div> -->
																	                                        </div>
																	                                        <div class="groupinput">
																	                                        	 <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
																												<input type="hidden" value="Live" name="inpt_data_status">
																												<input type="hidden" value="" name="addstockisdate" id="addstockisdate">
																	                                            <input type="submit" class="confirmtrd green modal-button-confirm" value="Confirm Trade">
																	                                        </div>
																	                                     </div>
																	                                    </form>
																	                                </div>
		                                                                                        </div>
																							</div>
																							<div style="width:27px; text-align:center">
																								<a href="#livetradenotes_<?php echo $value; ?>" class="smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a>
																							</div>
																							<!-- <input type="hidden" id="deletelog1"> -->
																							<div style="width:25px">
																								<a data-stock="<?php echo $value; ?>" data-totalprice="<?php echo $totalfixmarktcost; ?>" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a>
																							</div>
																							<div style="width:25px; margin-left: 2px;">
																								</div>
																							
																							<div class="hidethis" id="hidelogs">
																								<div class="tradelogbox" id="livetradenotes_<?php echo $value; ?>">
																									<div class="entr_ttle_bar">
																										<strong><?php echo $value; ?></strong> <span class="datestamp_header"><?php echo $value; ?></span>
																									</div>
																									<hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
																									<div class="trdlgsbox">

																										<div class="trdleft">
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['strategy']; ?></span></div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['tradeplan']; ?></span></div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['emotion']; ?></span></div>
																											<!-- <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profpet, 2, ".", ","); ?>%</span></div> -->
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo ($dprofit > 0 ? 'Winning' : 'Loosing'); ?></span></div>
																										</div>
																										<div class="trdright darkbgpadd">
																											<div><strong>Notes:</strong></div>
																											<div><?php echo $dstocktraded['data'][0]['tradingnotes']; ?></div>
																										</div>
																										<div class="trdclr"></div>
																									</div>
																								</div>
																							</div>
		                                                                                   
		                                                                                   <!-- <div style="width:40px; text-align: right;"><?php /*?>Notes<?php */?>
		                                                                                    	<a href="#tradingnotes_JFC" class="smlbtn blue fancybox-inline">
		                                                                                    		<i class="fa fa-sticky-note-o" aria-hidden="true"></i>
		                                                                                    	</a>
		                                                                                    </div>-->
		                                                                                </div>
		                                                                            </li>

																	            	<?php
                                                                                    }// if
                                                                                } // foreach
                                                                            } else { // if?>
																	            		<li style="text-align: center;">
																	            			<p>No Live Portfolio yet</p>
																	            		</li>
																	            	<?php
                                                                            }
                                                                                    ?>


                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                	<br class="clear">

													
						                        	<div class="row">
														<div class="col-md-7" style="padding-right: 0;">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Portfolio Snapshot
																</div>
																<div class="box-portlet-content" style="padding-bottom: 0;">
																	<div class="row">
																		<div class="col-md-6" style="padding-right:0;">
																			<div class="inner-portlet">
																				<div class="inner-portlet-content">

                                                                                    <div class="stats-info">
                                                                                        <div class="dstatstrade">
                                                                                            <ul>
                                                                                                <li class="headerpart">
                                                                                                    <div class="widthfull">Trading Results</div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrg1"></span>Capital</div>
                                                                                                    <div class="width35">₱<?php echo number_format($initcapital, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrg2"></span>Year to Date P/L</div>
                                                                                                    <div class="width35">₱<?php echo number_format($dtotalpl, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrg3"></span>Portfolio YTD %</div>
                                                                                                    <div class="width35"><?php echo  ($dtotalpl < 0 ? "-" : "").number_format(((abs($dtotalpl) / $initcapital) * 100), 2, '.', ',');?>%</div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

																				</div>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="inner-portlet">

                                                                                    <div class="stats-info">
                                                                                        <div class="dstatstrade">
                                                                                            <ul>
                                                                                                <li class="headerpart">
                                                                                                    <div class="widthfull">Fund Transfers</div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrb1"></span>Deposits</div>
                                                                                                    <div class="width35">₱<?php echo number_format($porttotaldep, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrb2"></span>Withdrawals</div>
                                                                                                    <div class="width35">₱<?php echo number_format($porttotalwid, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrb3"></span>Equity</div>
                                                                                                    <div class="width35">₱<?php echo number_format($dequityp, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

																			</div>
																		</div>
																	</div>
																	<br class="clear">
																</div>
															</div><br class="clear">
															<div class="box-portlet">
                                                                <div class="box-portlet-header">
                                                                    Monthly Performance
                                                                </div>
                                                                <div class="box-portlet-content" style="padding-right: 0;padding-bottom: 0;">
                                                                    <div class="col-md-12" style="padding: 0px;">
                                                                        <div id="chartdiv2">
																			<div id="preloader" class="trendingpreloader">
																				<div id="status">&nbsp;</div>
																				<div id="status_txt"></div>
																			</div>
																		</div>
                                                                    </div>
                                                                    <br class="clear">
                                                                </div>

															</div>
														</div>
														<div class="col-md-5">
															<div class="box-portlet" style="height:202px;">
																<div class="box-portlet-header" style="text-align:center;">
																	Current Allocation
																</div>
																<div class="box-portlet-content" style="padding:4px 14px 0">
																	<div class="row">
																		<div id="chartdiv1"></div>
																		<br class="clear">
																	</div>
																</div>

															</div><br class="clear">

															<div class="box-portlet">
																<div class="box-portlet-header" style="text-align:center;">
																	Trade Statistics
																	<?php
																		if($isjounalempty){
																			$iswin = 100;
																			$isloss = 60;
																			$totaltrade = 160;
																		}
																	?>
																</div>
                                                                <div class="chartarea col-md-12" style="margin-bottom: -3px;">
                                                                    <div id="chartdiv4a">
																		<div id="preloader" class="trendingpreloader">
																			<div id="status">&nbsp;</div>
																			<div id="status_txt"></div>
																		</div>
																	</div>
                                                                </div>
                                                                <div class="stats-info" style="padding: 0">

                                                                    <div class="row" style="padding: 11px 12px 7px 12px;">
                                                                        <div class="dstatstrade eqpad col-md-6" style="padding-right: 3px;">
                                                                            <ul style="margin-bottom:0 !important;">

                                                                                <li>
                                                                                    <div class="width60"><span class="bulletclrd clrg1"></span> Wins</div>
                                                                                    <div class="width35 dclwin"><?php //echo $iswin; ?></div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width60"><span class="bulletclrd clrr1"></span> Losses</div>
                                                                                    <div class="width35 dclloss"><?php //echo $isloss; ?></div>
                                                                                </li>

                                                                            </ul>
																		</div>
																		<div class="dstatstrade eqpad col-md-6" style="padding-left: 3px;">
                                                                            <ul style="margin-bottom:0 !important;">
																				<?php $totaltrade = $iswin + $isloss; ?>
                                                                                <li>
                                                                                    <div class="width60">Total Trades</div>
                                                                                    <div class="width35 dcltotals"><?php //echo $totaltrade; ?></div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width60"><strong>Win Rate</strong></div>
                                                                                    <div class="width35 dclwinrate"></div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>

															</div>
														</div>
													</div>

                                                    

                                                    	
													<br class="clear">

													<!-- BOF Strategy Statistics -->
													<!-- EOF Strategy Statistics -->
													<div class="row">
														<div class="col-md-12">
															<div class="box-portlet">
                                                            	<style>.dstatstrade ul li div {width: 16%;}</style>

                                                                <div style="padding:5px 15px;" class="col-md-8">
                                                                	<div class="col-md-12" style="padding:0 10px 0 0">

                                                                        <div class="box-portlet-header" style="padding: 13px 0 17px 2px;">
                                                                            Strategy Statistics
                                                                        </div>
																		<?php
																			if($isjounalempty){
																				$stratsinfo = [
																					'Bottom Picking' => [
																						'trwin' => 15,
																						'trloss' => 4,
																						'total_trades' => 19,
																					],
																					'Breakout Play' => [
																						'trwin' => 9,
																						'trloss' => 1,
																						'total_trades' => 10,
																					],
																					'Trend Following' => [
																						'trwin' => 2,
																						'trloss' => 8,
																						'total_trades' => 10,
																					],
																				];
																			}
																		?>
                                                                		<div class="stats-info">
                                                                            <div class="dstatstrade">
                                                                                <ul>
                                                                                    <li class="headerpart">
                                                                                        <div style="width:100%">
                                                                                            <div style="width:150px;text-align:left;">Strategy</div>
                                                                                            <div>Trades</div>
                                                                                            <div>Wins</div>
                                                                                            <div>Loses</div>
                                                                                            <div>Win Rate</div>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
                                                                                    foreach ($strats as $statskey => $statsvalue) {
                                                                                        ?>
                                                                                    	<li>
	                                                                                        <div style="width:99%">
																								<div style="width:150px;"><?php echo $statskey; ?></div>
																								<!-- <span class="legend_circ"></span> -->
	                                                                                            <div style="text-align: center;"><?php echo $statsvalue['total_trades']; ?></div>
	                                                                                            <div style="text-align: center;"><?php echo $statsvalue['trwin']; ?></div>
	                                                                                            <div style="text-align: center;"><?php echo $statsvalue['trloss']; ?></div>
	                                                                                            <div style="text-align: center;"><?php echo ($statsvalue['trwin'] > 0 ? number_format(($statsvalue['trwin'] / ($statsvalue['trwin'] + $statsvalue['trloss'])) * 100, 2) : "0.0"); ?>%</div>
	                                                                                        </div>
	                                                                                    </li>
                                                                                    <?php
                                                                                    } ?>

                                                                                </ul>
                                                                            </div>
                                                                    	</div>

                                                                    </div>
                                                                    <div class="col-md-12" style="padding: 0 12px 0 10px;">
																		<div id="chartdiv5" style="padding-left: 0;"></div>
																	</div>
                                                                    <br class="clear">
                                                                </div>
																<div class="col-md-4" style="padding-left:0;">
                                                                    	<div style="text-align:center;text-transform:uppercase;padding: 45px 0 0;margin-bottom: -6px;">
                                                                        	Win Allocations
                                                                    	</div>
                                                                    	<div class="chartarea">
                                                                            <div id="chartdiv4b"></div>
                                                                        </div>

                                                                        <div class="dstatstrade eqpad">
                                                                            <ul>

                                                                                <li>
                                                                                    <div class="width48"><span class="bulletclrd clrg1"></span> Winning Strategy</div>
                                                                                    <div class="width48" style="text-align: right;"><?php echo $winningstarts; ?></div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width48"><span class="bulletclrd clrr1"></span> Losing Strategy</div>
                                                                                    <div class="width48" style="text-align: right;"><?php echo $lossingstrats; ?></div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                
															</div>
														</div>
														<br class="clear">
													</div>
                                                    <br class="clear">
                                                    <!-- BoF Trade Statistics -->
                                                    <!-- EoF Trade Statistics -->
													<div class="row">

														<div class="col-md-12">
															<div class="box-portlet">
                                                                <div class="topstockgauge">
                                                                	<div class="col-md-4" style="padding:20px 0 0">
                                                                    	<div style="text-align:center;padding-bottom: 5px;text-transform: uppercase;">Winners</div>
                                                                        <div id="topstockswinners"></div>
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-bottom: 15px;">
                                                                    	<div class="box-portlet-header" style="text-align:center;">
                                                                            Top Stocks
                                                                        </div>
                                                                        <div class="inner-portlet" style="margin-top:20px;">
                                                                                <div class="stats-info">
                                                                                    <div class="dstatstrade">
                                                                                        <ul style="overflow: hidden;border-radius: 5px;">
																							<?php
																							
																							if($isjounalempty){
																								$winningstocks = [
																									0 => [
																										'stock' => 'Stock 3',
																										'profit' => 123435
																									],
																									1 => [
																										'stock' => 'Stock 2',
																										'profit' => 12343
																									],
																									2 => [
																										'stock' => 'Stock 1',
																										'profit' => 1234
																									],
																								];

																								$loosingstocks = [
																									0 => [
																										'stock' => 'Stock 1',
																										'profit' => -1234
																									],
																									1 => [
																										'stock' => 'Stock 2',
																										'profit' => -12343
																									],
																									2 => [
																										'stock' => 'Stock 3',
																										'profit' => -123435
																									],
																								];
																							}

																							foreach ($winningstocks as $key => $value) {
																								$dinss = '<li style="background-color: '.($key == 0 ? '#0d785a' : ($key == 1 ? '#06af68' : ($key == 2 ? '#00e676' : ($key >= 3 ? '' : '#00e676')))).';display:'.($key >= 3 ? 'none' : '').';color: #b1e8ce;border: none;">';
                                                                                                $dinss .= '<div class="width60">'. $value['stocks'] .'</div>';
                                                                                                $dinss .= '<div class="width35">&#8369; '.number_format($value['profit'], 2, '.', ',').'</div>';
																								$dinss .= '</li>';
																								echo $dinss;
																								if($key == 3){
																									break;
																								}
																							}

																							foreach ($loosingstocks as $key => $value) {
																								$dinss = '<li style="background-color: '.($key == 0 ? '#b91e45' : ($key == 1 ? '#732546' : ($key == 2 ? '#442946' : ($key >= 3 ? '' : '#b91e45')))).';display:'.($key >= 3 ? 'none' : '').';color: #132941;border: none;">';
                                                                                                $dinss .= '<div class="width60">'.$value['stocks'].'</div>';
                                                                                                $dinss .= '<div class="width35">&#8369; '.number_format($value['profit'], 2, '.', ',').'</div>';
																								$dinss .= '</li>';
																								echo $dinss;
																								if($key == 3){
																									break;
																								}
																							}
                                                                                             ?>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4" style="padding:20px 0 0">
                                                                    	<div style="text-align:center;padding-bottom: 5px;text-transform: uppercase;">Losers</div>
                                                                    	<div id="topstocksLosers"></div>
                                                                    </div>

                                                                </div>

															</div>
														</div>

														<br class="clear">

													</div>
													<br class="clear">
                                                    <div class="row">

                                                        <div class="col-md-12">
															<div class="box-portlet">

																<div class="box-portlet-header" style="padding-bottom:13px;">
																	Emotional Statistics
																</div>
																<?php
																	if($isjounalempty){
																		$emotioninfo = [
																			'Neutral' => [
																				'emotion' => 'Neutral',
																				'trwin' => 3,
																				'trloss' => 4,
																				'total_trades' => 7
																			],
																			'Greedy' => [
																				'emotion' => 'Greedy',
																				'trwin' => 2,
																				'trloss' => 3,
																				'total_trades' => 5
																			],
																			'Fearful' => [
																				'emotion' => 'Fearful',
																				'trwin' => 6,
																				'trloss' => 1,
																				'total_trades' => 7
																			],
																		];
																	}
																?>
                                                                <div class="col-md-6" style="padding-right:0;">

                                                                    <div class="chartarea">
                                                                        <div id="chartdiv11"></div>
                                                                    </div>

                                                                </div>

                                                            	<div class="col-md-6">

																	<div class="stats-info">
                                                                        <div class="dstatstrade dstatsemo">
                                                                            <ul>
                                                                            	<li class="headerpart">
                                                                                    <div>Emotions</div>
                                                                                    <div>Trades</div>
                                                                                    <div>Wins</div>
                                                                                    <div>Losses</div>
                                                                                    <div>Win Rate</div>
                                                                                </li>
																				<?php //$demotsonchart = ''; ?>
                                                                            	<?php foreach ($tremo as $emtkey => $emtvalue) { ?>
                                                                            		<li>
	                                                                                    <div><?php  echo $emtkey; ?></div>
	                                                                                    <div><?php  echo $emtvalue['total_trades']; ?></div>
	                                                                                    <div><?php  echo $emtvalue['trwin']; ?></div>
	                                                                                    <div><?php  echo $emtvalue['trloss']; ?></div>
	                                                                                    <div><?php  echo ($emtvalue['trwin'] > 0 ? number_format(($emtvalue['trwin'] / $emtvalue['total_trades']) * 100, 2, '.', '') : "0"); ?>%</div>
	                                                                                </li>
                                                                            	<?php
                                                    							} ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>

															</div>
														</div>

														<br class="clear">

													</div>
													<br class="clear">

                                                    <!-- BOF expenses report -->
													<!-- EOF expenses report -->
													<div class="expence-report">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Expense Report
																</div>
                                                                <div class="box-portlet-content" style="padding-top: 0; padding-left:0; padding-bottom:0;">
                                                                    <div class="col-md-4" style="padding-right:0;">
																			<?php
																				if($isjounalempty){
																					$fees = [
																						'commissions' => 111.2418925,
																						'vat' => 13.3490271,
																						'transfer' => 0.87229045,
																						'sccp' => 1.7445809,
																						'sell' => 104.674854,
																					];
																				}
																			?>
																			<div class="inner-portlet" style="margin-top:20px;">
                                                                                    <div class="stats-info">
                                                                                        <div class="dstatstrade">
                                                                                            <ul>
                                                                                                <li class="headerpart">
                                                                                                    <div class="widthfull">Breakdown Expenses</div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Commissions</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format($fees['commissions'], 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Value Added Tax</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format($fees['vat'], 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Transfer Fee</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format($fees['transfer'], 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">SCCP</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format($fees['sccp'], 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Sales Tax</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format($fees['sell'], 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
																			</div>

                                                                    </div>
                                                                    <div class="col-md-8" style="padding-right:0;">
                                                                        <div id="chartdiv6"></div>
                                                                    </div>
                                                                    <br class="clear">
																</div>


															</div>
													</div>
													<br class="clear">
													<div class="row">
														<div class="col-md-6" style="padding-right: 0;">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Buy Volume<br />
                                                                    <!--<span>For the last 20 trading days</span>-->
                                                                    <span>Last 20 Trades</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv7"></div>
																</div>

															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Buy Value<br />
                                                                    <!--<span>For the last 20 trading days</span>-->
                                                                    <span>Last 20 Trades</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv8"></div>
																</div>

															</div>
														</div>
													</div>
													<br class="clear">
													<div class="row">
														<div class="col-md-5" style="padding-right: 0;">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Performance <br>
																	<span>By day of the week</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv9"></div>
																</div>

															</div>
														</div>
														<div class="col-md-7">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Gross Profit & Loss<br />
																	<!--<span>Last 20 trading days</span>-->
																	<span>Last 20 Trades</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv10"></div>
																</div>

															</div>
														</div>
													</div>
						                        </div>
						                        <div class="tab-pane <?php echo isset($_GET['pt']) ? 'active show' : ''; ?> testss" id="tab2">

						                        	<div class="tradelogsbox">
                                                        <div class="box-portlet">

                                                            <div class="box-portlet-header" style="padding-bottom: 20px;">
															<span class="title_logss">Tradelogs</span>
																<div class="headright" style="display:none;">
																	<form action="" method="get" id="ptchangenum">
																		<input type="number" id="ptnum" name="ptnum">
																		<input type="hidden" name="pt" value="1">
																		<a href="#" class="dmoveto">Go</a>
																	</form>
																</div>

																<div class="search-tlogs">
																	<form action="" method="get">
																		 <input type="text" name="searchlogs" id="searchlogs" class=" search-logs" style="padding: 0px 10px; width: 150px;font-size: 12px;" placeholder="Search logs..." >
																	</form>
																</div>
																<div class="tradelogsbutton">
																	<div class="dbuttonrecord">
																		<form action="" method="post" class="recordform">
																			<input type="hidden" name="recorddata" value="record">
																			<input type="submit" name="record" value="Record" class="record-data-btn recorddata">
																		</form>
																	</div>
																</div>
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <div class="dstatstrade overridewidth dstatstrade1">
                                                                        <ul>
                                                                        	<li class="headerpart headerpart-tradelogs">
                                                                            	<div style="width:100%;">
                                                                                    <div style="width:45px">Stocks</div>                                                                                	
                                                                                    <div style="width:65px">Date</div>
                                                                                    <div style="width:55px" class="table-title-live">Volume</div>
                                                                                    <div style="width:65px" class="table-title-live">Ave. Price</div>
                                                                                    <div style="width:95px" class="table-title-live">Buy Value</div>
                                                                                    <div style="width:65px" class="table-title-live">Sell Price</div>
                                                                                    <div style="width:88px" class="table-title-live">Sell Value</div>
                                                                                    <div style="width:80px" class="table-title-live">Profit/Loss</div>
                                                                                    <div style="width:65px" class="table-title-live">%</div>
                                                                                    <div style="width:65px; text-align:center">Action</div>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                           <!-- <li class="s-logs" style="display: none;">

	                                                                            		                                                                            	
	                                                                            	
																			</li>-->
																			
																			<?php
																			$trtotals = 0;
																			if(!empty($ismytrades)):
																	
																				foreach ($ismytrades as $key => $value) {
																					$marketvals = $value->tlvolume * $value->tlaverageprice;
																					$selltotal = $value->tlvolume * $value->tlsellprice;
																					$sellvalue = $selltotal - getjurfees($selltotal, 'sell');

																					$profit = $sellvalue - $marketvals;
																					$profitperc = ($profit / $marketvals) * 100;

																					$tliswin = ($profit > 0 ? 'Win' : ($profit < 0 ? 'Loss' : 'Break Even'));

																					$trtotals += $profit;
																					?>
																					<li class="<?php echo $value->tlid; ?> dloglist">
																						<div style="width:99%;">
																							<div style="width:45px" class="tdata" id="tdata<?php echo $value->tlid; ?>"><a href="/chart/<?php echo $value->isstock; ?>" class="stock-label"><?php echo $value->isstock; ?></a></div>
																							<div style="width:65px" class="tdate" id="tdate<?php echo $value->tlid; ?>"><?php echo $value->tldate; ?></div>
																							<div style="width:55px" class="table-cell-live" id="tquantity<?php echo $value->tlid; ?>"><?php echo $value->tlvolume; ?></div>
																							<div style="width:65px" class="table-cell-live" id="tavprice<?php echo $value->tlid; ?>">₱<?php echo number_format($value->tlaverageprice, 3, ".", ","); ?></div>
																							<div style="width:95px" class="table-cell-live" id="tbvalue<?php echo $value->tlid; ?>">₱<?php echo number_format($marketvals, 2, ".", ","); ?></div>
																							<div style="width:65px" class="table-cell-live" id="tsellprice<?php echo $value->tlid; ?>">₱<?php echo number_format($value->tlsellprice, 2, ".", ","); ?></div>
																							<div style="width:88px" class="table-cell-live" id="tsellvalue<?php echo $value->tlid; ?>">₱<?php echo number_format($sellvalue, 2, ".", ","); ?></div>
																							<div style="width:80px" class="<?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?> table-cell-live" id="tploss1">₱<?php echo number_format($profit, 2, ".", ","); ?></div>
																							<div style="width:56px" class="<?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?> table-cell-live" id="tpercent1"><?php echo number_format($profitperc, 2, ".", ","); ?>%</div>
																							<div style="width:27px; text-align:center">
																								<a href="#tradelognotes_<?php echo $value->tlid; ?>" class="smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a>
																							</div>
																							<input type="hidden" id="deletelog1" value="4394">
																							<div style="width:25px">
																								<a class="deletelog smlbtn-delete" data-istl="<?php echo $value->tlid; ?>" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a>
																							</div>
																							<div style="width:25px; margin-left: 2px;">
																								<a href="#editlognotes_<?php echo $value->tlid; ?>" class="editlog smlbtn-edit fancybox-inline" style="cursor:pointer;text-align:center"><i class="fas fa-edit"></i></a>
																							</div>
																						</div>
																						<div class="hidethis" id="hidelogs">
																							<div class="tradelogbox" id="tradelognotes_<?php echo $value->tlid; ?>">
																								<div class="entr_ttle_bar">
																									<strong><?php echo $value->isstock; ?></strong> <span class="datestamp_header"><?php echo $value->tldate; ?></span>
																								</div>
																								<hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
																								<div class="trdlgsbox">

																									<div class="trdleft">
																										<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tlstrats; ?></span></div>
																										<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tltradeplans; ?></span></div>
																										<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tlemotions; ?></span></div>
																										<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profitperc, 2, ".", ","); ?>%</span></div>
																										<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo $tliswin; ?></span></div>
																									</div>
																									<div class="trdright darkbgpadd">
																										<div><strong>Notes:</strong></div>
																										<div><?php echo $value->tlnotes; ?></div>
																									</div>
																									<div class="trdclr"></div>
																								</div>
																							</div>
																						</div>
																						<div class="hidethis" id="hidelogs1">
																							    
																								<div class="tradelogbox" id="editlognotes_<?php echo $value->tlid; ?>">
																									<div class="entr_ttle_bar">
																									<strong><?php echo $value->isstock; ?></strong> <span class="datestamp_header"><?php echo $value->tldate; ?></span>
																									</div>
																									<hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">

                                                                                                    
																									<div class="trdlgsbox">
                                                                                                       <!-- <form method="post" class="edittlogs"> -->
																										<div class="trdleft">
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> 
																													<select class="rnd selecteditlog strat_<?php echo $value->tlid; ?>" name="data_strategy" id="strat">
																														<option  <?php if($value->tlstrats == 'Bottom Picking') echo "selected"; ?> value="Bottom Picking">Bottom Picking</option>
																														<option <?php if($value->tlstrats == 'Breakout Play') echo "selected"; ?> value="Breakout Play">Breakout Play</option>
																														<option <?php if($value->tlstrats == 'Trend Following') echo "selected"; ?> value="Trend Following">Trend Following</option>
																													</select>
																												</div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span>
																												<select class="rnd selecteditlog tplan_<?php echo $value->tlid; ?>" name="data_tradeplan" id="">
																														<option <?php if($value->tltradeplans == 'Day Trade') echo "selected"; ?> value="Day Trade">Day Trade</option>
																														<option <?php if($value->tltradeplans == 'Swing Trade') echo "selected"; ?> value="Swing Trade">Swing Trade</option>
																														<option <?php if($value->tltradeplans == 'Investment') echo "selected"; ?> value="Investment">Investment</option>
																												</select>
																											</div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> 
																												<select class="rnd selecteditlog emot_<?php echo $value->tlid; ?>" name="data_emotion" id="">
																														<option  <?php if($value->tlemotions == 'Neutral') echo "selected"; ?> value="Neutral">Neutral</option>
																														<option <?php if($value->tlemotions == 'Greedy') echo "selected"; ?> value="Greedy">Greedy</option>
																														<option <?php if($value->tlemotions == 'Fearful') echo "selected"; ?> value="Fearful">Fearful</option>
																												</select>
																											</div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profitperc, 2, ".", ","); ?>%</span></div>
																											<div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo $tliswin; ?></span></div>
																										</div>
																										<div class="trdright darkbgpadd">
																											<div><strong>Notes:</strong></div>
																											<div>
																												<textarea rows="3" name="tlnotes" class="tnotes_<?php echo $value->tlid; ?>" style="width: 313px; border-radius: 5px; background: #4e6a85;border: 0; color: #a1adb5;"><?php echo $value->tlnotes; ?></textarea>
																											</div>
																										</div>
																										<div class="trdleft">
                                                                                                            <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px; margin-top: 10px;">
																											<input type="hidden" value="Edit" name="inpt_data_status">
																											<input type="hidden" name="log_id" value="<?php echo $value->tlid; ?>">
																											<input type="hidden" name="logs" value="">
																											<div class="onelnetrd" style="margin-top: 9px;"> 
																												<button class="editmenow arbitrage-button arbitrage-button--primary" name="editbutton" data-istl="<?php echo $value->tlid; ?>" style="float: right;">Update</button>
																											</div>
																										</div>
                                                                                                        <!--</form>-->
    																									<div class="trdclr"></div>
    																									</div>
                                                                                                    
																								</div>
																							
																						</div>

                                                                                        <form method="post" class="edittlogs_<?php echo $value->tlid; ?>">
                                                                                                <input type="hidden" name="to_edit" id="tl_id" value="<?php echo $value->tlid; ?>">
                                                                                                <input type="hidden" name="strategy_<?php echo $value->tlid; ?>" id="strategy" value="">
                                                                                                <input type="hidden" name="trade_plan_<?php echo $value->tlid; ?>" id="trade_plan" value="">
                                                                                                <input type="hidden" name="emotion_<?php echo $value->tlid; ?>" id="emotion" value="">
                                                                                                <input type="hidden" name="tlnotes_<?php echo $value->tlid; ?>" id="tlnotes" value="">
                                                                                        </form>

																					</li>

																			<?php 	 }
																			endif; 

                                                                                // $paginate = (isset($_GET['ptnum']) && @$_GET['ptnum'] != "" ? 1 : $_GET['ptnum']);
                                                                                // echo  $_GET['ptnum'];
                                                                                $paginate = 20;
                                                                                $count = 1;
                                                                                $dpage = 1;
                                                                                $current = (isset($_GET['pt']) ? $_GET['pt'] : 1);
																				$dlisttrade = [];
																				
                                                                                if ($author_posts->have_posts()) {
                                                                                    while ($author_posts->have_posts()) {
																						$author_posts->the_post();
																						$tradelogid = get_the_ID();
                                                                                        // $dlisttrade[$dpage]
                                                                                        if ($count == $paginate) {
                                                                                            $count = 1;
                                                                                            ++$dpage;
                                                                                        } else {
                                                                                            ++$count;
                                                                                        }
                                                                                    }
                                                                                    wp_reset_postdata();
                                                                                }

                                                                            ?>
																		<input type="hidden" name="hsearchlogs" value="<?php echo $tnum; ?>" >
                                                                        </ul>
                                                                    </div>
																	<div class="deleteform">
																		<form class="deleteformitem" action="" method="post">
																			<input type="hidden" value="" name="todelete" id="todelete">
																		</form>
																	</div>
																	<div class="pagination">
																		<div class="pginner">
																			<ul>
																				<?php for ($i = 1; $i <= $dpage; ++$i) {
                                                                                    ?>
																					<li><a href="/journal/?pt=<?php echo $i; ?>"><?php echo $i; ?></a></li>
																				<?php
                                                                                } ?>
																			</ul>
																		</div>
																	</div>	
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                	<br class="clear">

													<div class="totalpl">
														 <p>Total Profit/Loss as of <?php
                                                          echo date('F j, Y'); ?>: <span class="totalplscore <?php echo $trtotals > 0 ? 'txtgreen' : 'txtred'; ?>">₱<?php echo number_format($trtotals, 2, '.', ','); ?></span></p>
													</div>

                                                    <!--<div class="adsbygoogle">
														<div class="box-portlet">

															<div class="box-portlet-content">
                                                            	<small>ADVERTISEMENT</small>
																<div class="adscontainer">
                                                                	<img src="<?php // echo get_home_url(); ?>/ads/addsample728x90_<?php //echo rand(1, 3); ?>.png">
                                                                </div>
															</div>
														</div>
													</div>-->
													<br class="clear">
						                        </div>
												<style type="text/css">
													.swal-overlay--show-modal {
														z-index: 99999999;
													}
													.sss {
														padding-right: 14px !important;
													}
													.sss::placeholder {
														color: #ffffff;
														font-size: 13px;
													}
													.dnlabel {
														font-size: 15px;
														padding-left: 11px;
														margin-bottom: 2px;
														font-weight: 400;
														font-family: 'Roboto', sans-serif;
													}
													.depo-body {
														position: relative;
														padding: 5px 10px;
													}
													.active-funds {
														display: block !important;
													}
													.button-funds {
														padding: 7px 10px 2px 10px;
														display: block;
													}
													/*.dropopen {
														display: block;
													}*/
												</style>
												<script type="text/javascript">
						                        	jQuery(document).ready(function(){
														jQuery('.add-funds-show').show();
														jQuery('.add-funds-shows').hide();
														var x = 0;
														var y = 0;

														jQuery(".show-button2").click(function(e){
															e.preventDefault();
															jQuery('.add-funds-shows').hide();
															jQuery('.add-funds-show').show();
														});
														jQuery(".show-button1").click(function(e){
															e.preventDefault();
															jQuery('.add-funds-show').hide();
															jQuery('.add-funds-shows').show();
														});
														// jQuery('td[name=tcol1]')
														jQuery('.textfield-buyprice').keyup(function(){
															
															var inputVal = jQuery(this).val().length;													
															if(inputVal != 0){
																$('.confirmtrd').prop('disabled', false);
																 x = 1;

															}else{
																$('.confirmtrd').prop('disabled', true);
															}
														});

														jQuery('.textfield-quantity').keyup(function(){
															var inputVal2 = jQuery(this).val().length;
															if(inputVal2 != 0){
																y = 1;
															}
														});

														$(".confirmtrd").click(function(e){

															console.log('==>');
    														//if(x == 1 && y == 1) {
    															$('.chart-loader').css("display","block");
    															$(this).hide();
    														//}
															
														});

													});
						                        </script>
						                        <div class="tab-pane <?php echo isset($_GET['ld']) ? 'active show' : ''; ?>" id="tab3">

						                        	<div class="ledgerbox">
                                                        <div class="box-portlet">

                                                            <div class="box-portlet-header">
                                                                Ledger
																<div class="headright" style="display:none;">
																	<form action="" method="get" id="ldchangenum">
																		<input type="number" id="ldnum" name="ldnum">
																		<input type="hidden" name="ld" value="1">
																		<a href="#" class="lddmoveto">Go</a>
																	</form>
																</div>
                                                                	<!-- Add funds -->
                                                            </div>
                                                            	<?php
                                                                    function date_sort($a, $b)
                                                                    {
                                                                        return strtotime($a->date) - strtotime($b->date);
                                                                    }
                                                                    usort($dledger, 'date_sort');

                                                                    // insert month-year value
                                                                    foreach ($dledger as $addmykey => $addmyvalue) {
                                                                        $addmyvalue->ismonth = date('F Y', strtotime($addmyvalue->date));
                                                                    }

                                                                    // get all month-year
                                                                    $dmonths = [];
                                                                    foreach ($dledger as $getmonthskey => $getmonthsvalue) {
                                                                        array_push($dmonths, $getmonthsvalue->ismonth);
                                                                    }
                                                                    $dmonths = array_unique($dmonths);

                                                                    // filter info as per month-year
                                                                    $dmonthdata = [];
                                                                    $dending = 0;
                                                                    foreach ($dmonths as $sepmonthkey => $sepmonthvalue) {
                                                                        $dmoninner = [];
                                                                        $dmoninner['ismonth'] = $sepmonthvalue;
                                                                        $dmoninner['isdata'] = [];
                                                                        $dmoninner['totalwith'] = 0;
                                                                        $dmoninner['totaldepo'] = 0;
                                                                        foreach ($dledger as $dmntskey => $dmntsvalue) {
                                                                            if ($sepmonthvalue == $dmntsvalue->ismonth) {
                                                                                array_push($dmoninner['isdata'], $dmntsvalue);
                                                                                if ($dmntsvalue->trantype == 'deposit') {
                                                                                    $dmoninner['totaldepo'] += $dmntsvalue->tranamount;
                                                                                    $dending = $dending + $dmntsvalue->tranamount;
                                                                                } elseif ($dmntsvalue->trantype == 'withraw') {
                                                                                    $dmoninner['totalwith'] += $dmntsvalue->tranamount;
                                                                                    $dending = $dending - $dmntsvalue->tranamount;
                                                                                }
                                                                            }
                                                                        }
                                                                        $dmoninner['isenfing'] = $dending;
                                                                        array_push($dmonthdata, $dmoninner);
                                                                    }
                                                                ?>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <div class="dstatstrade overridewidth">
                                                                        <ul>
                                                                            <li class="headerpart">
                                                                            	<div style="width:100%;">
                                                                                    <div style="width:8%">Count</div>
                                                                                    <div style="width:19%">Date</div>
                                                                                    <div style="width:15%">Transaction</div>
                                                                                    <div style="width:18%" class="to-left-align">Debit</div>
                                                                                    <div style="width:19%" class="to-left-align">Credit</div>
                                                                                    <div style="width:18%" class="to-left-align">Balance</div>
                                                                                    <!-- <div style="width:19%">Deposits</div>
                                                                                    <div style="width:19%">Ending Balance</div> -->
                                                                                </div>
                                                                            </li>
																			
                                                                            <?php
                                                                                // $numofitems = (isset($_GET['ldnum']) && @$_GET['ldnum'] != "" ? 1 : $_GET['ldnum']);
                                                                                $numofitems = 20;
                                                                                $ldcount = 1;
                                                                                $ldpages = 1;
                                                                                $listledger = [];
                                                                                foreach ($dmonthdata as $ldskey => $ldsvalue) {
                                                                                    $listledger[$ldpages][$ldcount] = $ldsvalue;

                                                                                    if ($ldcount == $numofitems) {
                                                                                        $ldcount = 1;
                                                                                        ++$ldpages;
                                                                                    } else {
                                                                                        ++$ldcount;
                                                                                    }
																				}

																				$ledcount = 0;
																				$ledbalance = 0;
																				$totdebit = 0;
																				$totcred = 0;
																				foreach ($dledger as $key => $value) {
																					if($value->trantype == "deposit" || $value->trantype == "withraw" || $value->trantype == "dividend"):
																						$ledcount++;
																					?>
																					<li>
																						<div style="width:99%;">
																							<div style="width:7.9%"><?php echo $ledcount; ?></div>
		                                                                                    <div style="width:19%"><?php echo date("F d, Y", strtotime($value->date)); ?></div>
																							<div style="width:15%"><?php echo ($value->trantype == "deposit" ? "Deposit Funds" : ($value->trantype == "withraw" ? "Withdrawal" : "Dividend Income")); ?></div>
																							<div style="width:18%" class="to-left-align">
																								<?php if($value->trantype == "withraw"){
																									echo "₱ ".number_format($value->tranamount, 2, '.', ',');
																									$ledbalance = $ledbalance - $value->tranamount;
																									$totdebit += $value->tranamount;
																								} ?>
																							</div>
																							<div style="width:19%" class="to-left-align">
																								<?php if($value->trantype == "deposit" || $value->trantype == "dividend"){
																									echo "₱ ".number_format($value->tranamount, 2, '.', ',');
																									$ledbalance = $ledbalance + $value->tranamount;
																									$totcred += $value->tranamount;
																								} ?>
																							</div>
		                                                                                    <div style="width:18%" class="to-left-align">₱<?php echo number_format($ledbalance, 2, '.', ',');  ?></div>
		                                                                                </div>
																					</li>
																			<?php
																					endif;
																				}
																			?>
																			<li class="headerpart">
                                                                            	<div style="width:100%;">
                                                                                    <div style="width:8%">&nbsp;</div>
                                                                                    <div style="width:19%">&nbsp;</div>
                                                                                    <div style="width:15%">Total</div>
                                                                                    <div style="width:18%" class="to-left-align"><?php echo "₱ ".number_format($totdebit, 2, '.', ','); ?></div>
                                                                                    <div style="width:19%" class="to-left-align"><?php echo "₱ ".number_format($totcred, 2, '.', ','); ?></div>
                                                                                    <div style="width:18%" class="to-left-align">&nbsp;</div>
                                                                                    <!-- <div style="width:19%">Deposits</div>
                                                                                    <div style="width:19%">Ending Balance</div> -->
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
																	<div class="dledgerpag">
																		<div class="dledinner">
																			<ul>
																				<?php for ($i = 1; $i <= $ldpages; ++$i) {
                                                                                    ?>
																					<li><a href="/journal/?ld=<?php echo $i; ?>"><?php echo $i; ?></a></li>
																				<?php
                                                                                } ?>
																			</ul>
																		</div>
																	</div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal -->

                                                        </div>
                                                    </div>
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
	$( document ).ready(function() {
		new getCurrentAllocation(<?php echo $user->ID; ?>);
		new getMonthlyPerformance(<?php echo $user->ID; ?>);
	});


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
<?php get_footer();
