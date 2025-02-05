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

?>

<!-- BOF BUY trades -->
<?php
    if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Live') {
		$buypower = str_replace(",", "", $_POST['input_buy_product']);

		$stockquantity = str_replace(",", "", $_POST['inpt_data_qty']);
		$butstockprice = str_replace(",", "", $_POST['inpt_data_price']);

		$total_stocks_price = bcadd($stockquantity, $butstockprice);

		

		if ($total_stocks_price > $buypower) {
			// echo $total_stocks_price ." ~ ". $buypower;
			wp_redirect('/journal');
			exit;
		}

		

        $tradeinfo = [];

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

		// print_r($_POST);
		// die;
		 
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

    // if(isset($_POST['to_edit'])){
    //     //echo $_POST['inpt_data_status'];
    //     $log_id = $_POST['to_edit'];
    //     $strategy = $_POST['strategy_'. $log_id];
    //     $tradepan = $_POST['trade_plan_'. $log_id];
    //     $emotion = $_POST['emotion_'. $log_id];
    //     $notes = $_POST['tlnotes_'. $log_id];

    //      $updatelogs = "UPDATE arby_tradelog set tlstrats = '$strategy', tltradeplans = '$tradepan', tlemotions = '$emotion', tlnotes = '$notes'  where tlid = '$log_id' and isuser ='$user->ID'";
    //      $wpdb->query($updatelogs);

    //     $data_trade_info = array_search('data_trade_info', array_column($postmetas, 'meta_key'));

    //     update_post_meta($log_id,  'data_trade_info', $strategy);
    //    // update_post_meta($log_id,  'data_trade_info', $data_trade_info[0]->strategy, 'test');
    //     wp_redirect('/journal');
    //     exit;
    // }



?>
<!-- EOF Deposit -->


<!-- BOF SELL trades -->
<?php
    if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Log') {
        $dstocktraded = get_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock'], true);
        $user_idd = $curuserid;
        $user_namee = $current_user->user_login;
		
		$sellmonth = date('F', strtotime($_POST['selldate']));
		$sellday = date('d', strtotime($_POST['selldate']));
		$sellyear = date('Y', strtotime($_POST['selldate']));
		$selldayname = date('l', strtotime($_POST['selldate']));

		$toparsesell = $_POST['inpt_data_sellprice'];
		$sellprice = rtrim($toparsesell, ',');
		$sellqty = rtrim($_POST['inpt_data_qty'], ',');

		$pzemos = "";
		$pzplans = "";
		$pzstrats = "";
        $pznotes = "";

        print_r($_POST);
        
        

		if(isset($_POST['formsource']) && $_POST['formsource'] == "fromchart"){
			$buyyinginfo = unserialize(stripslashes($_POST['dtradelogs']));
			$pzemos = $buyyinginfo['data'][0]['emotion'];;
			$pzplans = $buyyinginfo['data'][0]['tradeplan'];;
			$pzstrats = $buyyinginfo['data'][0]['strategy'];;
			$pznotes = $buyyinginfo['data'][0]['tradingnotes'];;
		} else {
            $buyyinginfo = json_decode(stripslashes($_POST['dtradelogs']));
			$pzemos = $buyyinginfo->emotion;
			$pzplans = $buyyinginfo->tradeplan;
			$pzstrats = $buyyinginfo->strategy;
            $pznotes = $buyyinginfo->tradingnotes;
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

		// print_r($_POST);
		$inserttrade = "insert into arby_tradelog (tldate, tlvolume, tlaverageprice, tlsellprice, tlstrats, tltradeplans, tlemotions, tlnotes, isuser, isstock) values ('".$_POST['solddate']."','".$_POST['inpt_data_qty_sold']."','".$_POST['inpt_data_price_bought']."','".$_POST['inpt_data_price_sold']."','".$_POST['inpt_data_strategy']."','".$_POST['inpt_data_tradeplan']."','".$_POST['inpt_data_emotion']."','".$_POST['inpt_data_tradingnotes']."', '".$user->ID."', '".$_POST['inpt_data_stock_bought']."')";
		
		// echo $inserttrade;
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

<!-- BOF Trade Logs Data from DB -->
<?php

    if (isset($_POST) && strtolower(@$_POST['deletedata']) == 'reset') {

		
        $dlistofstocks = get_user_meta($user->ID, '_trade_list', true);

        // Delete Live Trade
        foreach ($dlistofstocks as $delkey => $delvalue) {
            update_user_meta($user->ID, '_trade_'.$delvalue, '');
            delete_user_meta($user->ID, '_trade_'.$delvalue);

            // $dsotcksss = get_user_meta($user->ID, '_trade_'.$delvalue, true);
        }
		delete_user_meta($user->ID, '_trade_list');
		

		update_user_meta($user->ID, 'issampleactivated', 'no');
        // delete ledger
        $wpdb->get_results('delete from arby_ledger where userid = '.$user->ID);
        $wpdb->get_results('delete from arby_usermeta where meta_key like "%_trade_%" and user_id = '.$user->ID);
		$deletelogs = 'delete from arby_tradelog where isuser ='.$user->ID;
		$wpdb->query($deletelogs);
        wp_redirect('/journal');
        exit;
    }
?>
<!-- Delete Data -->
<!-- BOF Record a Trade -->
	<?php require "journal/record-trade.php";?>
<!-- EOF Record a Trade -->


<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
                <div class="swipeleft-area-l"></div>
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

						<?php require("parts/global-sidebar.php"); ?>

					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 1000px !important;">
                <div class="swipecenterl"></div>
                <div class="swipecenter-area-r"></div>
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    <span id="journal" class="journaltabs">
						                        <!-- Tabs -->
						                        <ul class="nav testss">
						                            <li class="<?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active'; ?>"><a href="#tab1" data-toggle="tab" class="<?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active show'; ?>">Dashboard</a></li>
						                            <li class="<?php echo isset($_GET['pt']) ? 'active' : ''; ?>"><a href="#tab2" data-toggle="tab" class="<?php echo isset($_GET['pt']) ? 'active show' : ''; ?> opentradelogtab">Tradelogs</a></li>
						                            <li class="<?php echo isset($_GET['ld']) ? 'active' : ''; ?>"><a href="#tab3" data-toggle="tab" class="<?php echo isset($_GET['ld']) ? 'active show' : ''; ?> openledger">Ledger</a></li>
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane <?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active'; ?>" id="tab1">
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
						                        <div class="tab-pane <?php echo isset($_GET['pt']) ? 'active' : ''; ?>" id="tab2">
													<?php require "journal/tradelogs.php";?>
						                        </div>
						                        <div class="tab-pane <?php echo isset($_GET['ld']) ? 'active' : ''; ?>" id="tab3">
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
get_template_part('parts/sidebar', 'alert');
require "journal/footer-files.php";
