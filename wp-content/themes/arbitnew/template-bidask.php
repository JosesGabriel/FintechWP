<?php
	/*
	* Template Name: Bid/Ask Area
	* Template page for Bidask Area
	*/
	global $current_user; 
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( '/login/', 301 );
		exit;
	}
	$cdnorlocal = get_home_url();
?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<?php if (WP_PROD_ENV != null && WP_PROD_ENV): ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-147416476-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-147416476-1');
	</script>
	
	<!-- Google Ads -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-7982031973729040",
            enable_page_level_ads: true
        });
    </script>
	<?php endif ?>

	<title>Bid/Ask</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?php echo $cdnorlocal; ?>/images/arb_icon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/animate.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/style.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/theme/default.css" id="theme" />
    <link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/ng-embed/dist/ng-embed.min.css" />
    <link href="<?php echo $cdnorlocal; ?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo $cdnorlocal; ?>/assets/css/style-chart.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<style type="text/css">
	.arb_right_icons_trans {display:none;}
	.arb_buysell {
		position: absolute;
		top: 51px;
		right: 184px;
		z-index: 999999;
	}
	.arb_buy {
		display: block;
		height: 22px;
		width: 60px;
		text-align: center;
		color: #6ce09d;
		background-color: #25ae5f;
		margin-right: 0;
		padding: 0 0 0 0;
		text-transform: uppercase;
		font-size: 14px;
	}
	.arb_sell {
		display: block;
		height: 22px;
		width: 60px;
		text-align: center;
		color: #f59c93;
		background-color: #e64c3c;
		margin-right: 0;
		padding: 3px 0 0 0;
		text-transform: uppercase;
		font-size: 14px;
	}
	.arb_sell:focus,
	.arb_buy:focus,
	.arb_sell:active,
	.arb_buy:active,	
	.arb_sell:hover,
	.arb_buy:hover {
		color:#fff !important;
		text-decoration:none !important;
	}
	.arb_top_ticker {
		position:absolute;
		top:0;
		left:0;
		z-index:9;
		width:100%;
	}
	.arb_right_icons_trans {
		position: absolute;
		width: 180px;
		right: 7px;
		top: 0;
		background-color: transparent;
		z-index: 9999999;
	}
	.arb-side-icon i {
		border: 2px solid #fff;
		border-radius: 100%;
		width: 32px;
		height: 32px;
		line-height: 30px;
		font-size: 15px;
		background-color: #34495e;
	}
	.nav-tabs>li>a {
		margin-right: 5px;
		line-height: 20px;
		background-color: #34495e;
		color: #fff;
		border-radius: 0;
	}
	tr {
		font-size: 11px;
	}
    .hideformodal {display:none;}
	.page-content-full-height .content {
		top: 15px;
	}
	.areattl {color: #ecf0f1;padding: 1px 1px 1px 3px;}
	html, body, .vertical-box-cell tr:nth-child(odd), .vertical-box-cell tr:nth-child(even) {
		background-color: #0c1f33 !important;
	}
	.dbar > div {
	    float: left;
		height:6px;
	}
	.bidme {
	    background: #32a932;
	    color: #fff;
	    text-align: center;
		border-radius: 5px 0 0 5px;
		margin-bottom: 2px;
	}
	.askme {
	    background: #ff5b57;
	    color: #fff;
	    text-align: center;
		border-radius: 0 5px 5px 0;
		margin-bottom: 2px;
	}
	.arb_left {float:left !important;}
	.arb_right {float:right !important;}
	.arb_clear {clear:both;}
	.bidaskbar {
		margin: 3px 0 0 3px;
		width: 97%;
	}
	.table tr td, .ng-scope td {
		background-color: #0c1f33 !important;
	}
</style>
</head>
<body>
	<div id="page-container" class="fade page-content-full-height page-without-sidebar" ng-controller="template">
	<div class="areattl" style="margin-top: -2px;">Market Depth: <strong style="color: #ffb6c1"><?php echo $_GET['stocksym']; ?></strong></div>
		<div id="content" class="content content-full-width">
            <div data-scrollbar="true" data-height="100%" ng-controller="chart">
            <div class="vertical-box tab-pane fade in active" id="tab-marketepth">
                <table class="table table-condensed m-b-0 text-default" style="font-size: 10px;">
                    <col width="8%">
                    <col width="19%">
                    <col width="19%">
                    <col width="16.67%">
                    <col width="16.67%">
                    <col width="16.67%">
                    <thead>
                        <tr>
                            <th class="border-default text-default text-left" style="padding: 3px !important;">#</th>
                            <th class="border-default text-default text-left" style="padding: 3px !important;">VOL</th>
                            <th class="border-default text-default text-left" style="padding: 3px 0 3px 0 !important;">BID</th>
                            <th class="border-default text-default text-right" style="padding: 3px 0 3px 0 !important;">ASK</th>
                            <th class="border-default text-default text-right" style="padding: 3px 0 3px 0 !important;">VOL</th>
                            <th class="border-default text-default text-right" style="padding: 3px 4px 3px 3px !important;">#</th>
                        </tr>
                    </thead>
                </table>
                <div class="vertical-box-row">
                    <div class="vertical-box-cell">
                        <div class="vertical-box-inner-cell">
                            <div data-scrollbar="true" data-height="100%">
                                <table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
                                    <col width="8%">
                                    <col width="19%">
                                    <col width="19%">
                                    <col width="16.67%">
                                    <col width="16.67%">
                                    <col width="16.67%">
                                    <tbody >
                                      <tr class="ditems" ng-repeat="bidask in marketdepth | orderBy: 'index' | limitTo: 5 track by bidask.index">
                                          <td class="text-left dbidnum" change="bidask.bid_count" data-bidnum="{{bidask.bid_count > 0 ? bidask.bid_count : ''}}"><span>{{bidask.bid_count > 0 ? bidask.bid_count : ''}}</span></td>
                                          <td class="text-left text-uppercase dbidvolume" change="bidask.bid_volume" data-bidval="{{bidask.bid_volume}}"><span>{{bidask.bid_volume > 0 ? (bidask.bid_volume | abbr) : ''}}</span></td>
                                          <td class="text-left" ng-class="{'text-green': bidask.bid_price > stock.previous, 'text-red': bidask.bid_price < stock.previous}" 
                                          change="bidask.bid_price" style="padding:0 !important">
                                                <strong>{{bidask.bid_price > 0 ? (bidask.bid_price | price) : ''}}</strong></td>
                                          <td class="text-right" ng-class="{'text-green': bidask.ask_price > stock.previous, 'text-red': bidask.ask_price < stock.previous}" 
                                          change="bidask.ask_volume" style="padding:0 !important">
                                                <strong>{{bidask.ask_price > 0 ? (bidask.ask_price | price) : ''}}</strong></td>
                                          <td class="text-right text-uppercase" change="bidask.ask_volume" style="padding:0 !important">
                                          		<span>{{bidask.ask_volume > 0 ? (bidask.ask_volume | abbr) : ''}}</span></td>
                                          <td class="text-right" style="padding-right: 4px !important;" change="bidask.ask_count">
                                          		<span>{{bidask.ask_count > 0 ? bidask.ask_count : ''}}</span></td>
                                          </tr>
                                      <tr ng-show="marketdepth.length == 0"><td colspan="5" align="center">Loading data, please wait...</td></tr>
                                    </tbody>
                                </table>
	<?php
		if (isset($_GET['stocksym']) && $_GET['stocksym'] != ""):
			# code...
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://marketdepth.pse.tools/api/market-depth?symbol='.$_GET['stocksym']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dwatchinfo = curl_exec($curl);
		curl_close($curl);
		$infos = json_decode($dwatchinfo);
		$totalbidvolumelimit = 0;
		$totalaskolumelimit = 0;
		foreach ($infos->data as $key => $value) {
			$totalbidvolumelimit += $value->bid_volume;
			$totalaskolumelimit += $value->ask_volume;
			if (isset($_GET['bartype']) && $_GET['bartype'] == "fulldepth") {
			} else{
				if ($key == 4) {
					break;
				}
			}
		}
		$totalbids = $totalbidvolumelimit + $totalaskolumelimit;
		$perbid = ($totalbidvolumelimit / $totalbids) * 100;
		$perask = ($totalaskolumelimit / $totalbids) * 100;
	?>
    <div class="bidaskbar">
    	<div class="dbar">
    		<div class="bidme" style="width: <?php echo $perbid; ?>%;"><?php // echo $totalbidvolumelimit; ?></div>
    		<div class="askme" style="width: <?php echo $perask; ?>%;"><?php // echo $totalaskolumelimit; ?></div>
            <div class="arb_clear"></div>
            <div class="arb_left" style="font-size:11px; color:#c9ccce;">
            BUYERS <strong style="color:#fff"><?php echo number_format((float) $perbid, 2, '.', ''); ?>%</strong></div>
            <div class="arb_right" style="font-size:11px; color:#c9ccce;">
            <strong style="color:#fff"><?php echo number_format((float) $perask, 2, '.', ''); ?>%</strong> SELLERS</div>
            <div class="arb_clear"></div>
    	</div>
    </div>
    <?php
    	endif;
    ?>
                                                                                                        <!-- <div ng-show="marketdepth.length != 0"> -->
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                                                                </div>
                                </div>
        </div>
<!-- end #content -->
	</div>
	<!-- end page container -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/js/apps.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-numeraljs/2.0.1/angular-numeraljs.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment/1.2.0/angular-moment.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/angular-timeago@0.4.6/dist/angular-timeago.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.6/angular-sanitize.min.js"></script>
	<script src="//cdn.rawgit.com/Luegg/angularjs-scroll-glue/master/src/scrollglue.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/ng-embed/dist/ng-embed.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/js/jquery.fullscreen-min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="<?php echo $cdnorlocal; ?>/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo $cdnorlocal; ?>/assets/js/aes.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
	<script>
		var modalzindex = 10000;
    	var nightmode = localStorage.getItem('theme') == 'dark';
        var socket = io.connect('https://dev-socket-api.arbitrage.ph');

		jQuery(document).ready(function() {
			App.init();
		    jQuery( function () {
		        jQuery(".stocks-select2").select2({placeholder:"Stock", width: '100%'})
		    });
		});
		jQuery(window).load(function(){
		  var dtotalbid = 0;
			jQuery(".ditems").each(function( index ) {
				var dsinglebid = jQuery(this).find('.dbidnum').attr('data-bidnum');
				dtotalbid += parseInt(dsinglebid);
			});
		});
		var _stocks     = {};
		var _admin 		= true;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '000001'
		var _username 	= 'guest';
		var _symbol 	= '<?php echo $_GET['stocksym']; ?>';
	</script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/functions.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/controllers.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/directives.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/filters.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/datafeed.js?v=2.218"></script>
<style type="text/css">
#tv_chart_container {
	width: 100% !important;
}
.tradingview-widget-container, div#tradingview_1cb87 {
	height: 100%;
}
div#tv_chart_container_manual {
	border: none !important;
}
.tradingview-widget-copyright {
	display: none;
}
div#tradingview_8c000 {
	height: 100%;
}
.nav-tabs {background: transparent;}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	font-family: "Roboto", Arial !important;
	font-weight: normal !important;
	padding: 0px 7px 0 3px !important;
	border: none !important;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
	color: #fff !important;
	background-color: #34495e !important;
	border-top: 4px solid #34495e !important;
    border-radius: 0;
	padding-top:2px !important;
}
a.arb-btm-icon {
	float: left;
	text-align: center;
	width: 20%;
	font-size: 20px;
	color: #667f98;
	padding: 6px 0 0;
}
a.arb-btm-icon span {
	text-align: center;
	font-size: 11px;
	color: #fff;
	display:block;
}
a.arb-side-icon {
    float: left;
    text-align: center;
    width: 25%;
    font-size: 20px;
    color: #ffffff;
    padding: 14px 0 9px;
}
a.arb-side-icon span {
	text-align: center;
	font-size: 11px;
	color: #fff;
	display:block;
}
#stock-details, .wrapper.text-center.border-bottom-1.border-default {
	text-align: left !important;
}
.nav-tabs .nav-item, .nav-tabs.nav-justified>li, .nav-tabs>li {
	margin-bottom: 0;
	width: 50%;
	text-align: center;
	border-radius:0 !important;
}
.nav>li>a:focus, .nav>li>a:hover,
.nav-tabs li:hover {border-radius:0 !important;}
small.arb_markcap {
	display: block;
	color: #ccc;
	font-size: 12px;
	font-weight: 300;
}
.arb_bottom_control_l {
	float:left;
	width:50%;
	max-width:700px;
}
.arb_bottom_control_r {
	float:right;
	width:270px;
}
.arb_right_icons_trans {display:block;}
</style>
</body>
</html>