<?php
	/*
	* Template Name: Buy/Sell Template
	* Template page for Journal Dashboard
	*/
// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );
// include_once(get_theme_file_path().'/arphie-function.php');
// include_once(get_theme_file_path().'/ab-functions.php');

$curuserid = $current_user->ID;

// calculate fees
function getfees($funmarketval, $funtype) {
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
function number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}

	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}

if( isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == "Live" ){
	

	$tradeinfo = [];
	$tradeinfo['buymonth'] = $_POST['inpt_data_buymonth'];
	$tradeinfo['buyday'] = $_POST['inpt_data_buyday'];
	$tradeinfo['buyyear'] = $_POST['inpt_data_buyyear'];
	$tradeinfo['stock'] = $_POST['inpt_data_stock'];
	$tradeinfo['price'] = $_POST['inpt_data_price'];
	$tradeinfo['qty'] = $_POST['inpt_data_qty'];
	$tradeinfo['currprice'] = $_POST['inpt_data_currprice'];
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

	$dlistofstocks = get_user_meta(get_current_user_id(), '_trade_list', true);
	if ($dlistofstocks && is_array( $dlistofstocks ) && in_array($_POST['inpt_data_stock'], $dlistofstocks )) {

		$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$_POST['inpt_data_stock'], true);

		array_push($dstocktraded['data'], $tradeinfo);
		$dstocktraded['totalstock'] = $dstocktraded['totalstock'] + $_POST['inpt_data_qty'];

		$totalprice = 0;
		$totalquanta = 0;
		foreach ($dstocktraded['data'] as $ddatakey => $ddatavalue) {
			$dmarkvval = $ddatavalue['price'] * $ddatavalue['qty'];
			$dfees = getfees($dmarkvval, 'buy');
			$totalprice += $dmarkvval + $dfees;
			$totalquanta += $ddatavalue['qty'];
		}
		$dstocktraded['aveprice'] = ($totalprice / $totalquanta);

		update_user_meta(get_current_user_id(), '_trade_'.$tradeinfo['stock'], $dstocktraded);

	} else {

		$finaldata = [];
		$finaldata['data'] =[];
		array_push($finaldata['data'], $tradeinfo);
		$finaldata['totalstock'] = $_POST['inpt_data_qty'];
		$dmarkvval = $tradeinfo['price'] * $tradeinfo['qty'];
		$dfees = getfees($dmarkvval, 'buy');
		$finaldata['aveprice'] = ($dmarkvval + $dfees) / $tradeinfo['qty'];
		update_user_meta(get_current_user_id(), '_trade_'.$tradeinfo['stock'], $finaldata);

		if (!$dlistofstocks) {
			$djournstocks = array( $tradeinfo['stock'] );
		} else {
			$djournstocks = $dlistofstocks;
			array_push($djournstocks, $tradeinfo['stock']);
		}
		update_user_meta(get_current_user_id(), '_trade_list', $djournstocks);
		
	}


	wp_redirect( '/buysell' );
	exit;

}

// Save trading data to trade logs
if( isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == "Log" ){

	$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$_POST['inpt_data_stock'], true);
	$user_idd = $curuserid;
	$user_namee = $current_user->user_login;
	$data_postid = $_POST['inpt_data_postid'];
	
	// Update journal data.
	$journalpostlog = array(
		// 'ID'           	=> $data_postid,
		'post_title'    => 'Trading Log - '.rand(123456,987654).' ('.$user_namee.')',
		'post_status'   => 'publish',
		'post_author'   => $user_idd,
		'post_category' => array(19,20),
		'post_content'  => 'Trading Log - '.rand(123456,987654).' ('.$user_namee.')',
		'meta_input'	=> array(
			'data_sellmonth'	=> $_POST['inpt_data_sellmonth'],
			'data_sellday'		=> $_POST['inpt_data_sellday'],
			'data_sellyear'		=> $_POST['inpt_data_sellyear'],

			'data_stock'		=> $_POST['inpt_data_stock'],
			'data_dprice'		=> $_POST['inpt_data_price'],

			'data_sell_price'	=> $_POST['inpt_data_sellprice'],
			'data_quantity'		=> $_POST['inpt_data_qty'],

			'data_trade_info'	=> $_POST['dtradelogs'],
			'data_userid'		=> get_current_user_id()
		)
	);

	$dstocktraded['totalstock'] = $dstocktraded['totalstock'] - $_POST['inpt_data_qty'];

	// Update existing data.
	wp_insert_post( $journalpostlog );
	update_user_meta(get_current_user_id(), '_trade_'.$_POST['inpt_data_stock'], $dstocktraded);
	

	wp_redirect( '/buysell' );
	exit;

}

 ?>
<style>
	body, html {
		margin:0;
		padding:0;
		background: #1b1b1b;
	}
	body, html, p, a, span {
		color: #ecf0f1;
		font-family: 'Roboto', sans-serif;
		font-size:13px;
		font-weight:300;
	}
	.hideformodal {display:none;}
	
	/* Enter Trade Form */
	.groupinput label {
		display: inline-block;
		width: 46px;
		font-weight: 300;
		font-size: 13px;
		height: 27px;
		line-height: 27px;
		padding: 0 0 0 7px;
		background-color: #34495e;
		border: none;
		color: #ecf0f1;
		border-radius: 3px 0 0 3px;
		margin-bottom: 0;
	}
	.groupinput input[type="text"] {
		display: inline-block;
		border-radius: 0 3px 3px 0;
		width: 172px;
		font-weight: 300;
		font-size: 13px;
		height: 27px;
		line-height: 27px;
		padding: 0 0 0 7px;
		background-color: #4e6a85;
		border: 1px solid #4e6a85;
		color: #ecf0f1;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
	}
	.groupinput select {
		display: inline-block;
		border-radius: 0 3px 3px 0;
		width: 140px;
		font-weight: 300;
		font-size: 13px;
		height: 27px;
		line-height: 27px;
		padding: 0 0 0 3px;
		background-color: #4e6a85;
		margin: 0 0 0 -4px;
		border: 1px solid #4e6a85;
		color: #ecf0f1;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
	}
	.confirmtrd,
	input[type="submit"].confirmtrd {
		background-color: #3597d3;
		border: 0;
		line-height: 34px;
		height: 34px;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 12px;
		padding: 0 22px;
		border-radius: 25px;
		color: #fff;
		cursor: pointer;
		font-family: 'Roboto', sans-serif;
		display:inline-block;
	}
	.confirmtrd:hover,
	input[type="submit"].confirmtrd:hover {
		background-color: #1870a6;
		color: #fff;
		text-decoration:none;
	}
	.confirmtrd.green {
		background-color: #27ae60 !important;
	}
	.confirmtrd.green:hover {
		background-color: #167b41 !important;
	}
	.confirmtrd.red {
		background-color: #e64c3c !important;
	}
	.confirmtrd.red:hover {
		background-color: #bb3527 !important;
	}
	.groupinput {
		margin-bottom: 10px;
	}
	textarea.darktheme {
		background-color: #4e6a85;
		border: 1px solid #4e6a85;
		height: 115px;
		max-width: 448px;
		width: 100%;
		padding: 10px;
		border-radius: 4px;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
		color: #ecf0f1;
		margin-top: 10px;
	}
	.entr_col {
		width:33%;
		float:left;
	}
	.entr_clear {clear:both;}
	.selltrade,
	.entertrade {
		width: 720px;
		margin: auto;
	}
	.groupinput.midd label {
		width:80px;
	}
	.groupinput.midd select {
		width:157px;
	}
	.groupinput.midd input {
		width:138px;
	}
	.entr_wrapper_top {
		padding:20px 0 15px 20px;
		background-color:#0c1f33;
	}
	.entr_wrapper_mid {
		padding: 20px 0 15px 20px;
		background-color: #142b46;
		border-radius: 4px;
	}
	.entr_wrapper_bot {
		padding:25px 0 25px 25px;
		background-color:#2c3e50;
	}
	.rnd {border-radius:3px !important;}
	.selectonly select {
		width:219px;
		margin:0;
	}
	.entr_ttle_bar {
		background-color: #142b46;
		padding: 12px;
		border-radius: 4px;
	}
	.entr_ttle_bar img {
		width: 22px;
		vertical-align: middle;
		margin: 0 7px 0 0;
	}
	.entr_ttle_bar strong {
		font-size: 14px;
		text-transform: uppercase;
		display: inline-block;
		font-weight:700 !important;
		vertical-align: middle;
	}
	.entr_successmsg {
		border-radius: 3px;
		background-color: #27ae60;
		color: #fff;
		padding: 4px 7px;
		width: 100%;
		margin: 0 auto;
		margin-bottom: 10px;
	}
	span.selldot {
		display: inline-block;
		background-color: #e84c3c;
		width: 10px;
		height: 10px;
		border-radius: 10px;
		vertical-align: middle;
		margin: -1px 0 0px 5px;
	}
	span.buydot {
		display: inline-block;
		background-color: #27ae60;
		width: 10px;
		height: 10px;
		border-radius: 10px;
		vertical-align: middle;
		margin: -1px 0 0px 5px;
	}
	span.datestamp_header {
		color: #a1adb5;
		display: inline-block;
		vertical-align: middle;
		margin: 0 0 0px 10px;
	}
	.fctnlhdn {
		visibility:hidden; 
		opacity:0;
		position:absolute;
		z-index:-1;
	}
	
	/* Popup Overrides */
	div#fancybox-content {
		border-color: #2c3e50 !important;
		background: #2c3e50 !important;
	}
	#fancybox-outer {
		background: #2c3e50 !important;
		box-shadow: none !important;
		-moz-box-shadow: none !important;
		-webkit-box-shadow: none !important;
		border-radius: 6px;
		overflow: hidden;
	}
	#fancybox-close {top: 18px;right: 18px;}
	.lockedd {position:relative;}
	.lockedd i.fa.fa-lock {
		top: 7px;
		position: absolute;
		right: 21px;
		font-size: 14px;
	}
	
	/* Table CSS */
	.tradelogtable {
		width:100%; 
		margin-bottom:0;
	}
	.tradelogtable td {
		padding: 2px;
	}
	textarea.darktheme::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		color: #ecf0f1;
	}
	textarea.darktheme::-moz-placeholder { /* Firefox 19+ */
		color: #ecf0f1;
	}
	textarea.darktheme:-ms-input-placeholder { /* IE 10+ */
		color: #ecf0f1;
	}
	textarea.darktheme:-moz-placeholder { /* Firefox 18- */
		color: #ecf0f1;
	}
	.tradelogscont {
		background-color:#34495e;
		max-width:1125px;
		width:100%;
		margin:0 auto;
	}
	.tradelogscont .innerr {
		padding:25px 0;
	}
	a.smlbtn {
		background-color: #e64c3c;
		color: #fff;
		padding: 2px 8px;
		display: inline-block;
		font-size: 12px;
		border-radius: 4px;
		font-weight: bold;
		text-decoration:none;
	}
	a.smlbtn.blue {
		background-color: #3597d3;
	}
	a.smlbtn.green {
		background-color: #27ae60;
	}
	a.smlbtn:hover {
		background-color: #bb3527;
	}
	a.smlbtn.blue:hover {
		background-color: #1870a6;
	}
	a.smlbtn.green:hover {
		background-color: #167b41;
	}
	.sysoutput {background-color: #313131;}
	.sysoutput span {
		display: inline-block;
		margin: 0 -4px 0 0px;
		color: #9a9a9a;
		background-color: #313131;
		padding: 2px 8px;
	}
	.tradelogtable strong {
		font-weight: 700 !important;
	}
	.tradingnotescont {
		width:300px;
		min-height:250px;
	}
	
	.panel-tabs > li.active > a, .panel-tabs > li.active > a:hover, .panel-tabs > li.active > a:focus {
		border-radius: 4px 4px 0 0;
		padding-bottom: 10px;
	}
	.panel-tabs > li a {
		margin-left: 5px;
	}
	.panel {
    	background-color: #273647;
		border-radius: 5px 5px 0 0;
	}
	.side-content {
		background: #3a5168;
		border: 1px solid #273647;
	}
	.side-content ul li {
    	background: #3a5168;
	}
	.side-content-inner {
		padding-top: 15px;
	}
	.side-header .right-image .onto-user-meta-details {
		color: #b2bbc4;
		font-size: 12px;
		font-weight: 400;
	}
	.box-portlet {
		border: 1px solid #273647;
		border-radius: 5px;
		overflow: hidden;
		background-color: #3a5168;
	}
	.side-header {
		border-radius: 5px 5px 0 0;
		border-bottom: none;
	}
	.dlistofsold table {
		width: 100%;
	}
	.greenbase {
	    color: #27ae60;
	    font-weight: 700;
	}
	.redbase {
		color: #e64b3c;
    	font-weight: 700;
	}
	.dlistofsold table tbody tr {
	    border-top: 1px solid #3a5168;
	    color: #c3c3c3;
	}
	.dlistofsold table tbody tr.redbar {
	    background: rgba(230, 76, 60, 0.15);
	}
	.dlistofsold table tbody tr.greenbar {
	    background: rgba(39, 174, 96, 0.15);
	}
</style>
<?php
	$getdstocks = get_user_meta(get_current_user_id(), '_trade_list', true);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$gerdqoute = curl_exec($curl);
	curl_close($curl);

	$gerdqoute = json_decode($gerdqoute);


?>


<div class="box-portlet" style="padding-top: 51px;">
    <div class="box-portlet-header">
        Live Portfolio
    </div>
    <div class="box-portlet-content">
    	<table class="tradelogtable" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr style="border-bottom: 1px solid #4f6379">
					<td><strong>No</strong></td>
					<td><strong>Stock</strong></td>
					<td><strong>Position</strong></td>
					<td><strong>Average Price</strong></td>
					<td><strong>Total Cost</strong></td>
					<td><strong>Market Value</strong></td>
					<td><strong>Current Value</strong></td>
					<td><strong>Gain/Loss</strong></td>
					<td><strong>Gain/Loss %</strong></td>
					<td style="text-align: center;"><strong>Action</strong></td>
					<td style="text-align: right;"><strong>Notes</strong></td>
				</tr>
				<?php 
            		foreach ($getdstocks as $key => $value) {
            			$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$value, true);
            			$dstockinfo = $gerdqoute->data->$value;
            			
            			$totalmarketvalue = 0;
            			$dtotalcosts = 0;
            			$dselltotal = 0;

            			$totalquanta = 0;
            			foreach ($dstocktraded['data'] as $dtradeissuekey => $dtradeissuevalue) {
            				$dmarketvalue = $dtradeissuevalue['price'] * $dtradeissuevalue['qty'];
            				$dfees = getfees($dmarketvalue, 'buy');
                			$totalmarketvalue += $dmarketvalue;
                			$dtotalcosts += $dmarketvalue + $dfees;
                			$totalquanta += $dtradeissuevalue['qty'];
            			}

            			$dsellmarket = round($dstockinfo->last, 2) * $dstocktraded['totalstock'];
            			$dsellfees = getfees($dsellmarket, 'sell');
            			$dselltotal += $dsellmarket - round($dsellfees, 2);

            			$totalfixmarktcost = $dstocktraded['totalstock'] * round($dstocktraded['aveprice'], 2);
            			$totalfinalcost = $totalfixmarktcost + getfees($totalfixmarktcost, 'buy');

            	?>
        			<tr>
						<td><?php echo $key + 1; ?></td>
						<td><a target="_blank" href="/chart/<?php echo $value; ?>"><?php echo $value; ?></a></td>
						<td><?php echo number_format($dstocktraded['totalstock'], 0, '.', ',' ); ?></td>
						<td>&#8369;<?php echo number_format( $dstocktraded['aveprice'], 2, '.', ',' ); ?></td>
						<td>&#8369;<?php echo number_format( $totalfixmarktcost, 2, '.', ',' ); ?></td>
						<td>&#8369;<?php echo number_format( $totalfinalcost, 2, '.', ',' ); ?></td>
						<td>&#8369;<?php echo number_format( $dstockinfo->last, 2, '.', ',' ); ?></td>
						<td>
							<div class="<?php echo ($dselltotal > $totalfinalcost ? 'dgreenitem' : 'dreditem') ?>">
								&#8369;<?php echo number_format( ($dselltotal - $totalfinalcost), 2, '.', ',' ); ?>
							</div>
						</td>
						<td>
							<div class="<?php echo ($dselltotal > $totalfinalcost ? 'dgreenitem' : 'dreditem') ?>">
								<?php echo ($dselltotal > $totalfinalcost ? '+' : '-') ?><?php echo number_format( ( (abs($dselltotal - $totalfinalcost) / $totalfinalcost) * 100 ), 2, '.', '' ); ?>%
							</div>
						</td>
						<td style="text-align: center;">
							<a href="#entertrade_<?php echo $value; ?>" class="smlbtn fancybox-inline green">BUY</a>
							<a href="#selltrade_<?php echo $value; ?>" class="smlbtn fancybox-inline">SELL</a>
							<div class="hideformodal">
								<div class="tradingnotescont" id="tradingnotes_1">
									<div class="entr_ttle_bar">
										<img src="/wp-content/uploads/2018/12/logo.png" alt="Arbitrage"> <strong>Trading Notes</strong>
									</div>
									<div style="padding:10px 0 0 0">this is the notes</div>
								</div>
							</div>
						</td>
						<td style="text-align: right;"><a href="#tradingnotes_<?php echo $value; ?>" class="smlbtn blue fancybox-inline">
							<i class="fa fa-sticky-note-o" aria-hidden="true"></i></a>
							<div class="hideformodal">
					                    
		                        <div class="selltrade" id="selltrade_<?php echo $value; ?>">
		                        
		                            <div class="entr_ttle_bar">
		                                <strong>Sell Trade</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
		                            </div>
		                            
		                            <form action="/buysell" method="post">
		                            
		                            <div class="entr_wrapper_top">
		                            
		                                    <div class="entr_col">
		                                        <div class="groupinput fctnlhdn">
		                                            <label>Sell Date</label>
		                                            <select name="inpt_data_sellmonth" style="width:90px;">
		                                                <option value="<?php echo date("F"); ?>" selected><?php echo date("F"); ?></option>
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
		                                            <input type="text" name="inpt_data_sellday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
		                                            <input type="text" name="inpt_data_sellyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
		                                            </div>
		                                        
		                                        <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock" 
		                                        value="<?php echo $value; ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

		                                        <div class="groupinput midd lockedd"><label>Position</label><input type="text" name="inpt_data_price"
		                                        value="<?php echo $dstocktraded['totalstock']; ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
		                                        
		                                       
		                                    </div>
		                                    
		                                    <div class="entr_col">
		                                    	<div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" name="inpt_data_price"
		                                        value="&#8369;<?php echo number_format( ($dtotalcosts / $dstocktraded['totalstock']), 2, '.', ',' ); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

		                                        <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_price"
		                                        value="&#8369;<?php echo number_format($dstockinfo->last, 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

		                                       
		                                    </div>
		                                    <div class="entr_col">
		                                    	<div class="groupinput midd"><label>Sell Price</label><input type="text" name="inpt_data_sellprice"></div>
		                                   		
		                                   		<div class="groupinput midd"><label>Qty.</label><input type="text" name="inpt_data_qty"
		                                        value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>"></div>
		                                   </div>
		                                    
		                                    <div class="entr_clear"></div>
		                                
		                            </div>
		                            <div class="entr_wrapper_mid">
		                                <div>
		                                    <input type="hidden" value="Log" name="inpt_data_status">
		                                    <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
		                                    <input type="hidden" name="dtradelogs" value='<?php echo json_encode($dstocktraded['data']); ?>'>
		                                    <input type="submit" class="confirmtrd red" value="Sell Trade">
		                                </div>
		                                
		                             </div>
		                                     
		                            </form>
		                        </div> 

		                         <div class="entertrade" id="entertrade_<?php echo $value; ?>">
                                    <div class="entr_ttle_bar">
                                        <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
                                    </div>
                                    <form action="/buysell" method="post">
                                    <div class="entr_wrapper_top">
                                            <div class="entr_col">
                                                <div class="groupinput fctnlhdn">   
                                                  <label style="width:100%">Buy Date:</label>
                                                  <input type="hidden" name="inpt_data_buymonth" value="<?php echo date("F"); ?>">
                                                  <input type="hidden" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
                                                  <input type="hidden" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
                                                </div>
                                                <div class="groupinput midd lockedd"><label>Stock</label>
                                                <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px;" value="<?php echo $value; ?>" readonly>
                                                <i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd"><label>Buy Price</label><input type="text" name="inpt_data_price"></div>
                                                <div class="groupinput midd"><label>Quantity</label><input type="text" name="inpt_data_qty"></div>
                                            </div>
                                            <div class="entr_col">
                                                <div class="groupinput midd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" value="&#8369;<?php echo number_format( $dstockinfo->last, 2, '.', ',' ); ?>"></div>
                                                <div class="groupinput midd"><label>Change</label><input type="text" name="inpt_data_change" value="<?php echo $dstockinfo->change; ?>%"></div>
                                                <div class="groupinput midd"><label>Open</label><input type="text" name="inpt_data_open" value="&#8369;<?php echo number_format( $dstockinfo->open, 2, '.', ',' ); ?>"></div>
                                                <div class="groupinput midd"><label>Low</label><input type="text" name="inpt_data_low" value="&#8369;<?php echo number_format( $dstockinfo->low, 2, '.', ',' ); ?>"></div>
                                                <div class="groupinput midd"><label>High</label><input type="text" name="inpt_data_high" value="&#8369;<?php echo number_format( $dstockinfo->high, 2, '.', ',' ); ?>"></div>
                                            </div>
                                            <div class="entr_col">
                                                <div class="groupinput midd"><label>Volume</label><input type="text" name="inpt_data_volume" value="<?php echo number_format_short($dstockinfo->volume); ?>"></div>
                                                <div class="groupinput midd"><label>Value</label><input type="text" name="inpt_data_value" value="<?php echo number_format_short($dstockinfo->value); ?>"></div>
                                                <div class="groupinput midd lockedd">
                                                	<?php
                                                    	$dboard = 0;
                                                    	if ( $dstockinfo->last >= 0.0001 && $dstockinfo->last <= 0.0099){
                                                                $dboard = 1000000;
                                                          } else if ( $dstockinfo->last >= 0.01 && $dstockinfo->last <= 0.049){
                                                                $dboard = 100000;
                                                          } else if ( $dstockinfo->last >= 0.05 && $dstockinfo->last <= 0.495){
                                                                $dboard = 10000;
                                                          } else if ( $dstockinfo->last >= 0.5 && $dstockinfo->last <= 4.99){
                                                                $dboard = 1000;
                                                          } else if ( $dstockinfo->last >= 5 && $dstockinfo->last <= 49.95){
                                                                $dboard = 100;
                                                          } else if ( $dstockinfo->last >= 50 && $dstockinfo->last <= 999.5){
                                                               $dboard = 10;
                                                          } else if ( $dstockinfo->last >= 1000){
                                                               $dboard = 5;
                                                          }
                                                    ?>
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
                                            <div>this is it</div>
                                        </div>
                                        <div class="groupinput">
                                            <input type="hidden" value="Live" name="inpt_data_status">
                                            <input type="submit" class="confirmtrd green" value="Confirm Trade">
                                        </div>
                                     </div>
                                    </form>
                                </div> 
		                    
		                    </div>
						</td>
					</tr>

            	<?php 
            		}
            	?>
				
			</tbody>
        </table>
        
    </div>
</div>
<div class="dlistoftrades">
	<h3>Trade Logs</h3>
	<div class="dlistofsold">
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Stock</th>
					<th>Volume</th>
					<th>Sell Price</th>
					<th>Gain/Loss</th>
					<th>Gain/Loss %</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					 $author_query = array(
						'posts_per_page' => '-1',
						'meta_key' => 'data_userid',
						'meta_value'  => get_current_user_id()
					);
					$author_posts = new WP_Query($author_query);
					// The Loop
					if ( $author_posts->have_posts() ) {
						while ( $author_posts->have_posts() ) { $author_posts->the_post();

							$data_sellmonth = get_post_meta(get_the_ID(), 'data_sellmonth', true);
							$data_sellday = get_post_meta(get_the_ID(), 'data_sellday', true);
							$data_sellyear = get_post_meta(get_the_ID(), 'data_sellyear', true);

							$data_stock = get_post_meta(get_the_ID(), 'data_stock', true);
							$data_dprice = get_post_meta(get_the_ID(), 'data_dprice', true);
							$data_dprice = str_replace('₱', '', $data_dprice);

							$data_sell_price = get_post_meta(get_the_ID(), 'data_sell_price', true);
							$data_quantity = get_post_meta(get_the_ID(), 'data_quantity', true);

							$data_trade_info = get_post_meta(get_the_ID(), 'data_trade_info', true);

							// get prices
							$soldplace = $data_quantity * $data_sell_price;
							$baseprice = $data_quantity * $data_dprice;

							$dprofit = $soldplace - $baseprice;

							// get percentage
							$dgainperc = abs($dprofit)/$data_quantity;

							?>
							<tr class="<?php echo ($soldplace > $baseprice ? 'greenbar' : 'redbar'); ?>">
								<td><?php echo $data_sellmonth; ?> <?php echo $data_sellday; ?>, <?php echo $data_sellyear; ?></td>
								<td><?php echo $data_stock; ?></td>
								<td><?php echo number_format( $data_quantity, 0, '.', ',' ); ?></td>
								<td>&#8369;<?php echo number_format( $data_sell_price, 2, '.', ',' ); ?></td>
								<td>
									<div class="<?php echo ($soldplace > $baseprice ? 'greenbase' : 'redbase'); ?>">
										&#8369;<?php echo number_format( $dprofit, 2, '.', ',' ); ?>
									</div>
								</td>
								<td>
									<div class="<?php echo ($soldplace > $baseprice ? 'greenbase' : 'redbase'); ?>">
										<?php echo ($soldplace > $baseprice ? '+' : '-'); ?><?php echo number_format( $dgainperc, 2, '.', ',' ); ?>%
									</div>
								</td>
								<td>
									<div class="dbox <?php echo ($soldplace > $baseprice ? 'greenbase' : 'redbase'); ?>">
										<?php echo ($soldplace > $baseprice ? 'Gain' : 'Loss'); ?>
									</div>
								</td>
							</tr>
							<?php
						}
						wp_reset_postdata();
					} else {
						?>
							<tr>No Trades yet.</tr>
						<?php
					}
				?>
				
			</tbody>
		</table>
	</div>
	
</div>
<div class="pulls">
	<?php
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://pse.tools/api/stocks');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dwatchinfo = curl_exec($curl);
		curl_close($curl);

		$dstocks = json_decode($dwatchinfo);

		$listofstocks = [];
		foreach ($dstocks->data as $key => $value) {
			$dlistofstocks = [];
			$dlistofstocks['symbol'] = $value->symbol;
			$dlistofstocks['name'] = $value->name;
			array_push($listofstocks, $dlistofstocks);
		}
	?>
	<pre>
		<?php print_r($listofstocks); ?>
	</pre>
</div>
<?php
get_footer('admin');