<?php
	/*
	* Template Name: Chart Page
    * Template page for Trading Chart
    * Ralph was here - Enter Buy Order
	*/
	global $current_user;
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( $homeurlgen.'/login/', 301 );
		exit;
	}
	
	
	$homeurlgen = get_home_url();
	$user_id = $user->ID;
	/* temp-disabled
	$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
	$checkfbshare = get_user_meta( $user_id, "_um_sso_facebook_email", true );
	
	if(!$checksharing){
		if($checkfbshare){
			header('Location: '.$homeurlgen.'/share/?'.rand(12345 ,89019));
			die(); 
		}else{
			header('Location: '.$homeurlgen.'/verify/?'.rand(12345 ,89019));
			die();
		}
	} temp-disabled */

?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Arbitrage Trading Tools | Chart</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-270x270.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" />
	<link rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/assets/css/animate.min.css" />
	<link rel="stylesheet" href="/assets/css/style.min.css" />
	<link rel="stylesheet" href="/assets/css/theme/default.css" id="theme" />
    <link rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" href="/assets/plugins/ng-embed/dist/ng-embed.min.css" />
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>"> 
		<!-- Madaot calcs sa chart if dili ni iload ang duha ka css. To be refractored -->
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <style type="text/css">
		html, body, .page-content-full-height .content {overflow:hidden;}
		.arb_buysell {
			position: absolute;
		    top: 6px;
		    left: -320px;
		    z-index: 999999;
		}
		.arb_buy {
			display: inline-block;
			height: 26px;
			line-height: 27px;
			text-align: center;
			color: #fff;
			padding: 1.4px 13px 0 13px;
			margin-right: 1px;
			text-transform: uppercase;
			font-size: 12px;
			border-radius: 50px;
			font-weight: 300;
			vertical-align: top;
			border: #25ae5f solid 2px !important;
		    line-height: 21px;
		}
		.arb_buy:hover {
			background-color: #25ae5f;
			-webkit-transition: all .5s ease-in-out;
		    -moz-transition: all .5s ease-in-out;
		    -o-transition: all .5s ease-in-out;
		    transition: all .5s ease-in-out;
		    transform: scale(1.07); 
		}
		.arb_sell {
			display: inline-block;
			height: 26px;
			line-height: 27px;
			text-align: center;
			color: #fff;
			padding: 1.4px 10px 0 10px;
			text-transform: uppercase;
			font-size: 12px;
			border-radius: 50px;
			font-weight: 300;
			vertical-align: top;
			border: #e64c3c solid 2px !important;
		    line-height: 21px;
		}
		.arb_sell:hover {
			background-color: #d04234;
			-webkit-transition: all .5s ease-in-out;
		    -moz-transition: all .5s ease-in-out;
		    -o-transition: all .5s ease-in-out;
		    transition: all .5s ease-in-out;
		    transform: scale(1.07); 
		}
		.arb_buysell i.fas {
			color: #fff;
			font-size: 10px;
			margin-top: -3px;
			vertical-align: middle;
			display: none;
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
		    width: 275px;
		    right: -54px;
		    top: 2px;
			padding-left: 110px;
		    background: linear-gradient(to right, #2c3e5000 26%, #34495e 43%);
		    z-index: 9;
		}
		.arb-side-icon i {
			border: none;
			border-radius: 100%;
			width: 30px;
			height: 30px;
			line-height: 30px;
			font-size: 16px;
			background-color: rgba(44, 62, 80,0.8);
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
		span.bidaskbar_btn {
			display: block;
			cursor: pointer;
		}
		.bidaskbar_opt {
			position: absolute;
			background-color: #2c3e50;
			width: 80px;
			right: 57px;
			z-index: 9;
		}
		.bidaskbar_opt ul {
			margin: 0;
			padding: 3px 7px;
			list-style: none;
			border: 1px solid #34495e;
			text-align: center;
		}
		.bidaskbar_opt li {
			padding: 3px 0;
			text-align:right;
		}
		.bidaskbar_opt ul li a {
			color:#bdc3c7;
		}
		.bidaskbar_opt ul li a:hover {
			color:#fff;
			text-decoration:none;
		}
		.bidaskbar_opt {display:none;}
		.text-white {color: #bdc3c7 !important;}
		#tv_chart_container iframe,
		#tv_chart_container {
			height: 100%;
		}
		.arb_padding_5.b0.bidaskbar,
		.arb_padding_5.b0.arb_bullbear {
			border-top: 4px #34495e solid;
		}
		.sd_border_btm {
			border-bottom: 4px #34495e solid;
		}
		.sd_border_top {
			border-top: 4px #34495e solid;
		}
		.allstocksbox {
			height: 56%;
			overflow: hidden;
			display: block;
			padding: 5px 0 5px 0;
		}
		.list-inline>li{display:inline-block;}
		.list-inline>li+li{margin-bottom:5px !important;}

		.arb_watchlst_cont table thead tr th {
			color: #dedede;
		text-align: center;
		}
		.arb_watchlst_cont table thead tr th:first-child {
			color: #dedede;
		text-align: center;
		}
		.arb_watchlst_cont table tbody tr td {
			color: #dedede;
			text-align: center;
	    	padding: 2px 4px;
	    	padding-left: 0px !important;
	    	cursor: pointer;
		}
		.arb_watchlst_cont table tbody tr td:hover .arb_watchlst_cont table tbody tr {
			background: #ffffff !important;
		}
		.arb_watchlst_cont table tbody {
			border-top: 6px solid #ffffff00;
		}
		.chred {
			color: #fffffe;
			padding: 0.5px 0 2px 0px;
		    background: #e64c3c;
		    border-radius: 50px;
		}
		.chgreen {
			color: #fffffe;
			padding: 0.5px 0 2px 0px;
		    background: #25ae5f;
		    border-radius: 50px;
		}
		.chred-price {
			color: #e64c3c !important;
		}
		.chgreen-price {
			color: #25ae5f !important;
		}
		.block {
			font-weight: normal;
			text-align: left !important;

		}
		.vertical-box-cell tr:nth-child(odd) {
			background: none !important;
		}
    </style>

    <?php /*?> Enter Trade CSS <?php */?>
	<style>
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
		position: relative;
		left: 535px;
		border: 0;
		line-height: 26px;
		height: 32px;
		font-weight: 300;
		font-size: 14px;
		padding: 0 18px;
		border-radius: 50px;
		color: #fff;
		cursor: pointer;
		font-family: 'Roboto', sans-serif;
		display: inline-block;
		background: none;
		border: #25ae5f solid 2px !important;
    }
    .confirmtrd:hover,
    input[type="submit"].confirmtrd:hover {
        color: #fff;
        text-decoration:none;
        background-color: #25ae5f !important;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out;
		transform: scale(1.07);
    }
    .confirmtrd.green {
        /*background-color: #27ae60 !important;*/
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
		height: 152px;
		max-width: 444px;
		width: 100%;
		padding: 10px;
		border-radius: 4px;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
		color: #ecf0f1;
		margin-top: 0;
		margin-right: 2px;
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
        padding: 20px 0 2px 20px;
        background-color: #142b46;
        border-radius: 4px;
        min-height: 260px;
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
        background-color: #34495e;
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
		color:#fff;
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
	iframe.bidaskbox {
		max-width: 217px;
		width: 100%;
		height: 152px;
		border: 1px solid #4e6a85;
		border-radius: 5px;
		padding: 5px;
		background: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg) no-repeat 50% 50% transparent;
		background-size: 50px;
		background-color: #0c1f33;
	}
	iframe.bullbearframe {
		background: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg) no-repeat 50% 50% #2b3d4f;
		background-size: 35px;
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
        right: 14px;
        font-size: 14px;
		color: #ecf0f1;
    }
    .tradelogtable {
        width:100%; 
        margin-bottom:15px;
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
	.arb_bar_red,
	.arb_bar_green {
		margin: 1px 0 3px;
	}
	.fancybox-content {
		background: #0c1f33;
		padding: 10px;
	}
	.fancybox-slide--html .fancybox-close-small {
		right: 8px;
		top: 10px;
		color: #fff;
	}
	.arb_top_ticker {
		display:none;
	}
	.list-inline>li,
	.list-inline>li+li {
		margin-left: 0px !important;
		border-left: 4px solid #34495e !important;
		margin-bottom: 0 !important;
		padding: 5px 7px 7px 7px !important;
		height:40px !important;
		overflow:hidden;
		vertical-align:top;
		transition: all 1s;
	}
	.normpadd {padding: 5px 7px 7px 7px !important;}
	.list-inline>li+li span {transition:1s all;}
	.greybarbg {
		height: 4px;
		background-color: #34495e;
		border-radius: 5px;
	}
	.arb_logo_placehldr h2 {
		font-size: 22px;
		color: #bdc3c7;
	}
	.arb_logo_placehldr {
		padding: 9px 0 0;
		text-align: center;
	}
	.vertical-box-row>.vertical-box-cell>.vertical-box-inner-cell {
		overflow: visible;
	}
	.arb_watchlst_cont {
		padding:5px;
		text-align:center;
		color:#bdc3c7;
	}
	.arb_watchlst_cont > table {
	    width: 100%;
	}
	.marqueethis {
		width:0;
		height:40px;
		right:-100px;
	}
	.arb_custom_ticker {
		font-size: 10px;
		line-height: 12px;
		padding: 0; 
		display:block !important;
		margin-bottom: 0; 
		position:absolute;
		overflow:hidden; 
	}
	.arb_custom_ticker li {text-align:right;}
	.arb_custom_ticker_wrapper {
		height:40px;
		position: relative;
		overflow: hidden; 
		background-color:#2c3e50; 
		text-align:left;
	}
	.bullbearsents_voted,
	.bullbearsents {
		text-align:center;
		padding:0 0 4px 0;
	}
	.bullbearsents a {
		display:inline-block;
		vertical-align:middle;
	}
	.bullbearsents .bbs_bear,
	.bullbearsents .bbs_bull {
		margin: -3px 2px 0px;
		/* position: relative;
    	top: -47px; */
	}
	.bbs_bull {
		position: relative;
		/* left: 10px; */
	}
	.bbs_bear {
		position: relative;
		/* right: 10px; */
	}
	.bullbearsents .bbs_bear img {
		width:15px;
	}
	.bullbearsents .bbs_bull img {
		width:18px;
	}
	.bullbearsents .bbs_bull {
		background-color: #25ae5f;
		padding: 6px 5px;
		border-radius: 20px;
	}
	.bullbearsents .bbs_bull:hover {
		background-color: #229a55;	
	}
	.bullbearsents .bbs_bear {
		background-color: #e64c3c;
		padding: 6px 7px;
		border-radius: 20px;
	}
	.bullbearsents .bbs_bear:hover {
		background-color: #d13c2c;
	}
	.bullbearsents span {
		display: block;
		color: #FFF;
	}
	span.bullbearsents_label {
		margin-bottom: 2px;
	}
	.bbs_bear_bar {margin-left:-2px; text-align:right;}
	.bbs_bull_bar {margin-right:-2px; text-align:left;}
	.bbs_bear_bar_inner {background-color: #e64c3c; height:4px; border-radius: 0 5px 5px 0;}
	.bbs_bull_bar_inner {background-color: #25ae5f; height:4px; border-radius: 5px 0 0 5px;}
	.bbs_bear_bar, 
	.bbs_bull_bar {
		width:0;
		vertical-align:middle;
		display:inline-block;
	}
	.bbs_bear_bar span,
	.bbs_bull_bar span {display:none;}
	.dbaronchart {
		display: inline-block;
		width: 0%;
		overflow: hidden;
		left: -1px;
		position: relative;
		height: 31px;
	}
	.bbs_bull_bar, .bbs_bear_bar {
		margin-top: 11px;
	}
	.bbs_bull_bar {
		float: left;
	}
	#preloader {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #354960;
		z-index: 99999999;
		height: 100%;
	}
	#status {
		width: 50px;
		height: 50px;
		position: absolute;
		left: 50%;
		top: 45%;
		background-image: url(<?php echo get_home_url(); ?>/wp-content/plugins/um-social-activity/assets/img/loader.svg);
		background-size:50px;
		background-repeat: no-repeat;
		background-position: center;
		margin: -25px 0 0 -25px;
	}
	#status_txt {
		width:100%;
		position: absolute;
		top:50%;
		left:0;
		z-index:99;
		color:#fff;
		text-align:center;
		font-size:11px;
	}
	.chart_logo_arbitrage{
		position: absolute;
		z-index: 9;
		top: 4px;
		left: 9px;
	}
	#tv_chart_container iframe {background-color: #34495e !important;}
	.vertical-box-column.width-250 {
		border-right: 5px solid #34495e;
	}
	.width-250 {
		width: 260px!important;
	}
	.showsidemobile {
		position: absolute;
		z-index: 999;
		color: #fff;
		background-color: #2c3e50;
		font-size: 25px;
		padding: 1px 7px 2px;
		left: -41px;
		top: 0px;
	}
	.mobileinithide .fa-indent {display:none;}
	.chartlocker {
		display:none;
		position:absolute;
		z-index: 998;
		width:100%;
		left: 0;
		height:100%;
		background-color: rgba(44, 62, 80,0.8);
	}
	.fixbrdebtm {
		height: 5px;
		position: absolute;
		bottom: 0;
		right: 0;
		z-index: 9999;
		width: 100%;
		background-color: #34495e;
	}
	tr.ng-scope:focus,
	tr.ng-scope:active {
		background-color: #eb4d5c!important;
	}
	/* .dopensentiment,
	.openmenow > .arb_bullbear {
		display: block !important;
	} */
	/* Responsive */
	@media screen and (max-width: 767px){
		.table-responsive {
			border: none;
		}
	}
	@media only screen and (max-width: 667px) { 
		.width-250.mobileinithide {
			width: 265px !important;
			position: absolute;
			z-index: 999;
			right: -260px;
			border-left: 5px solid #34495e;
		}
		.arb_buysell {
			top: 76px;
			left: -78px;
			width: 72px;
			text-align: right;
			background-color: rgba(255,255,255,.15);
		}
		.arb_buy, .arb_sell {width: 66px; margin-bottom:5px;border-radius: 50px 0 0 50px;}
		.vertical-box-column.mobilefull {
			width: 100%;
		}
		.groupinput.midd input {width: 59%;}
		.groupinput.midd label {width: 40%;}
		.groupinput {width: 95%;}
		iframe.bidaskbox {max-width: 100%;}
		.entr_col {width: 100%;}
	}
	.arb_watchlst_cont table thead tr th:first-child {
	    text-align: left;
	}
	.background {
		background: #ffffff !important;
	}
	.closesidebar {
	    position: relative;
		z-index:9999;
	}
	.closesidebar a {
		width: 10px;
		height: 28px;
		display: block;
		line-height: 27px;
		left: 3px;
		bottom: -77px;
		position: absolute;
		background-color: #131722;
		text-align: center;
		border-radius: 10px;
		border: 1px solid #363c4e;
	}
	.opensidebar a:hover,
	.closesidebar a:hover {
		background-color:#299dcd;
		border-bottom-color:#3bb3e4;
	}
    .closesidebar a img {
        height: 7px;
    }
    .opensidebar {
	    position: relative;
	    display:none;
		z-index:9999;
	}
	.opensidebar a {
		width: 9px;
		height: 28px;
		display: block;
		line-height: 27px;
		left: -9px;
		top: 143px;
		position: absolute;
		background-color: #131722;
		text-align: center;
		border-radius: 10px;
		border: 1px solid #363c4e;
	}
    .opensidebar a img {
        height: 7px;
    }
    .showsidebar {
        width: 260px !important;
        border-right: 5px solid #34495e !important;
        /*transition: all 0.5s ease !important;*/
    }
    ul.main-drops-chart > ul:before {
	    bottom: 100% !important;
	    right: 2% !important;
	    border: solid transparent !important;
	    content: " " !important;
	    height: 0 !important;
	    width: 0 !important;
	    position: absolute !important;
	    pointer-events: none !important;
	    margin-left: -36px !important;
		border-bottom-color: #142c46 !important;
	    border-width: 9px !important;
	}
	ul.main-drops-chart > ul {
		font-size: 13px !important;
	    position: absolute !important;
		right: 139px !important;
	    top: 37px !important;
	    background: #142c46 !important;
	    min-width: 180px !important;
	    text-align: left !important;
	    border: none !important;
	    border-radius: 4px !important;
	    list-style: none !important;
	    padding: 0 !important;
	}
	ul.main-drops-chart {
	    display: inline-block !important;
	    width: 12% !important;
	    padding-left: 0 !important;
	}
	ul.main-drops-chart > ul li a {
	    color: #fff !important;
	    display: block !important;
	    font-size: 12px !important;
	    text-decoration: none !important;
	    font-weight: 500 !important;
	    font-family: 'roboto', sans-serif !important;
	}
	ul.main-drops-chart > ul:before {
	    border-bottom-color: #142c46 !important;
	    right: 4% !important;
	    border-width: 9px !important;
	}
	ul.main-drops-chart > ul li:hover {
	    background: #0d1f33;
	}
	ul.main-drops-chart > ul li {
	    padding: 6px 15px;
	}
	ul.main-drops-chart > ul li:first-child {
	    border-top-left-radius: 4px !important;
	    border-top-right-radius: 4px !important;
	}
	ul.main-drops-chart > ul li:last-child {
	    border-bottom-left-radius: 4px !important;
	    border-bottom-right-radius: 4px !important;
	}
	.dropopen {
	    display: block !important;
	}
	.um-notification.unread {
	    background: #0e111b !important;
	}
	.add-postsis{
	    border-radius: 5px;
	    overflow: hidden;
	    display: flex;
	    justify-content: center;
	    background: #123;
	}
	.arb_calcbox {
	    max-width: 100%;
	    width: 100%;
	    height: 100%;
	    margin: 0 auto;
	    font-size: 13px;
	    background: rgba(94, 115, 138, 0.52);
	    position: fixed;
	    z-index: 99999999000;
		display: flex;
	    align-items: center;
	}
	.bkcalcbox {
	    padding: 20px 20px 20px 20px;
	    color: #fff;
	    max-width: 450px;
	    border-radius: 5px;
	    margin: 0 auto;
	    width: 100%;
	    background: #142c46;
	}
	.bkcalcboxess {
	    padding: 20px 20px 20px 20px;
	    color: #fff;
	    max-width: 611px;
	    border-radius: 5px;
	    margin: 0 auto;
	    width: 100%;
	    background: #142c46;
	}
	.toclassclose {
		cursor: pointer;
		font-size: 14px;
    	color: #d8d8d8;
		float: right;
	}
	.toclassclosess {
		cursor: pointer;
		font-size: 14px;
    	color: #d8d8d8;
		float: right;
	}
	.toclasscloserss {
		cursor: pointer;
		font-size: 14px;
    	color: #d8d8d8;
		float: right;
		margin-top: 2px;
	}
	.sccas{
	    padding: 20px 20px 20px 20px !important;
		max-width: 365px !important;
		background: linear-gradient(#11273e,#24405f);
	}
	.halfts {
	    /* height: 40em; */
	    overflow: auto;
	}
	.halfts::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		border-radius: 11px;
		background-color: #0f121d;
	}
	input#risktoler, input#targetprof {
		margin-right: 8px;
	}
	.bbs_bear_bar span {
		float: right;
	}

	.halfts::-webkit-scrollbar
	{
		width: 8px;
		border-radius: 10px;
		background-color: none;
	}

	.halfts::-webkit-scrollbar-thumb
	{
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
		background-color: #34495e;
	}
	.arb_calcshares input {
	    background: #11273e !important;
	    border: 1px solid #1e3554 !important;
	    border-radius: 25px !important;
	    height: 35px;
	}
	.arb_buyprice input {
	    background: #11273e !important;
	    border: 1px solid #1e3554 !important;
	    border-radius: 25px !important;
	    height: 35px;
	}
	.arb_sellprice input {
	    background: #11273e !important;
	    border: 1px solid #1e3554 !important;
	    border-radius: 25px !important;
	    height: 35px;
	}
	.doneitem li {
	    width: 48.4%;
	    display: inline-block;
	}
	input.dpri {
		padding-left: 16px !important;
	    width: 100%;
	    height: 42px;
	    border-radius: 25px !important;
	    color: #d8d8d8 !important;
	    font-family: 'Roboto', sans-serif !important;
	    font-size: 15px;
	}
	input.dpos {
		padding-left: 16px !important;
	    width: 100%;
	    height: 42px;
	    border-radius: 25px !important;
	    color: #d8d8d8 !important;
	    font-family: 'Roboto', sans-serif !important;
	    font-size: 15px;
	}
	.paramlist .jjaajs {
	    margin-top: 15px !important;
	    height: 100px;
    	overflow-y: scroll;
	}
	.doneitem li span {
	    padding-left: 17px;
	}
	.additems a{
		cursor: pointer;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    background: none;
		border: 2px #CDDC39 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 10px;
	    color: #fff;
	    text-decoration: none;
	}
	.calculate a{
		cursor: pointer;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    background: none;
	    border: 2px #e91e63 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px;
	    color: #fff;
	    text-decoration: none;
	}
	.clearbtn a{
		cursor: pointer;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    background: none;
	    border: 2px #03A9F4 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 20px;
	    color: #fff;
	    text-decoration: none;
	}
	.tobottomsit {
	    margin: 10px 0px 25px 14px;
	}
	span.totalcost {
	    font-size: 26px;
	    font-weight: 200;
	}
	span.totalposition {
	    font-size: 26px;
	    font-weight: 200;
	}
	span.totalprice {
	    font-size: 26px;
	    font-weight: 200;
	}
	.tobottomsit ul li {
		line-height: 1.2;
	    text-align: left;
	    margin-bottom: 7px;
		border-bottom: 1px solid rgba(17, 39, 62, 0.32941176470588235);
    	width: 94%;
	}
	.adprams {
	    text-align: right;
	    margin-top: 11px;
	}
	.um-notification span.b2 i img {
	    width: 14px;
	    margin-top: -3px;
	}
	.adprams div {
	    display: inline-block;
	}
	.um-woo-downloads .woocommerce-Message {
	    background: none;
	    font-size: 14px !important;
	    color: #d8d8d8 !important;
	}
	.toborderbotcalc {
		border-bottom: 2px solid #FFC107;
		font-size: 20px;
	}
	.toborderbotvar {
		border-bottom: 2px solid #FFEB3B;
		font-size: 20px;
	}
	.toborderbotvar strong {
		padding-bottom: 11px;
		display: inline-block;
	}
	.toborderbot {
		border-bottom: 2px solid #E91E63;
		font-size: 20px;
	}
    .arb_calcshares {
    	margin-top: 5px;
    }
    ul {
	    text-decoration: none;
	    list-style: none;
	    padding: 0;
	    margin-bottom: 0;
	}
	b, strong {
	    font-weight: bolder;
	    font-family: 'Roboto', sans-serif;
	}
	.allcaps strong {
	    font-weight: 700;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	}
	.entr_wrapper_top input {
		text-align: right;
		padding-right: 25px !important;
	}
	.bbbutton-sen {
		position: relative;
		bottom: 13px;
	}
	table.dstocklistitems.table.table-condensed.m-b-0.text-inverse.border-default {
		margin-top: 20px !important;
	}
    
    </style>
	<script language="javascript">
		$(document).ready(function() {
			
			$(window).load(function() {
				$("#status, #status_txt").fadeOut("fast");
				$("#preloader").delay(400).fadeOut("slow");
			})
			
			function changicotonormal() {
				var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = '<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png';
				document.getElementsByTagName('head')[0].appendChild(link);
			}
			$( "body" ).mousemove(function() {
			  changicotonormal();
			});
			$( ".bidaskbar_btn" ).click(function() {
			  $( ".bidaskbar_opt" ).slideToggle("fast");
			});
            $(".bidaskbar_opt ul li a").click(function(e){
                e.preventDefault();
                var dtype = $(this).attr('data-istype');
                $(this).parents(".bidaskbar").find(".arb_bar").hide();
                $(this).parents(".bidaskbar").find("."+dtype).show();
                $(this).parents(".bidaskbar_opt").hide();
            });
			
			// $('.tr-background').mouseenter(function(){
			// 	$('.tr-background').addClass('background');
			// });
			// $('.tr-background').mouseleave(function(){
			// 	$('.tr-background').removeClass('background');
			// });
		});
    </script>
    <script type="text/javascript">
    	jQuery(document).ready(function(){
			jQuery("ul.main-drops-chart").click(function(e){
                event.stopPropagation();
                var isopen = jQuery("ul.main-drops-chart > ul").hasClass("dropopen");

                if (isopen) {
                    jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
                } else {
                    jQuery("ul.main-drops-chart > ul").show().addClass("dropopen");
                }

            });
			jQuery(document).on("click", function () {
	            jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
	            jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
	            jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
	        });
		});
		jQuery(document).ready(function(){
            jQuery("ul.main-drops-chart > ul li:first-child").on("click", function () {
                event.stopPropagation();
                 var openthis = jQuery("#showplease").hasClass("dropthiss");
                 if ( openthis ) {
                     jQuery("#toghandle").hide().removeClass("dropthiss");
                } else {
                	jQuery("#toghandle").show().addClass("dropthiss");
                }
            });
            jQuery("ul.main-drops-chart > ul li:nth-child(2)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlings").show().addClass("dropthiss");

            });
            jQuery("ul.main-drops-chart > ul li:nth-child(3)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlingers").show().addClass("dropthiss");
            });
        });
        jQuery(document).ready(function(){
            // jQuery("#toghandle").on('click', function(){
            //     jQuery("#toghandle").hide().removeClass("dropthiss");
            // });
            // jQuery("#toghandlings").on('click', function(){
            //     jQuery("#toghandlings").hide().removeClass("dropthiss");
            // });

            jQuery(".toclassclose").on('click', function(){
                jQuery("#toghandle").hide().removeClass("dropthiss");
            });
            jQuery(".toclassclosess").on('click', function(){
                jQuery("#toghandlings").hide().removeClass("dropthiss");
            });
            jQuery(".toclasscloserss").on('click', function(){
                jQuery("#toghandlingers").hide().removeClass("dropthiss");
            });
        });
	</script>
</head>
<body>
	<div id="preloader">
		<div id="status">&nbsp;</div>
		<div id="status_txt"></div>
	</div>
    <?php get_template_part('parts/sidebar', 'calc'); ?>

	<?php get_template_part('parts/sidebar', 'varcalc'); ?>

	<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

	<?php
		$userid = get_current_user_id();
		$dledger = $wpdb->get_results( "SELECT * FROM arby_ledger where userid = ".$userid);
	?>

	<div>
		<div class="chart_logo_arbitrage"><a href="<?php echo $homeurlgen; ?>" target="_blank"><img src="https://arbitrage.ph/wp-content/themes/arbitrage-child/images/arblogo_svg1.svg" style="width: 33px;"></a></div>

		<iframe style="border:0;width:100%;height: 40px;border-bottom: 4px #34495e solid;overflow: hidden;" scrolling="no" src="<?php echo $homeurlgen; ?>/stock-ticker/"></iframe>

		<?php //get_template_part('parts/global', 'css'); ?>

		<div class="arb_right_icons_trans">
			<?php /*?> Top Icons <?php */?>
			<ul class="main-drops-chart">
				<a href="#" class="arb-side-icon">
					<img src="<?php echo $homeurlgen; ?>/svg/menu.svg" style="width: 17px;display: inline-block;vertical-align: top;margin-top: 6px;">
				</a>
				<ul id="droppouts" style="box-shadow: 0px 2px 4px 1px rgba(7, 13, 19, 0.52);display: none;">
						<li><a href="#">Buy/Sell Calculator</a></li>
						<li><a href="#">VAR Calculator</a></li>
						<li><a href="#">Average Price Calculator</a></li>
						<li><a href="<?php echo get_home_url(); ?>/multicharts/">Multichart</a></li>
				</ul>
			</ul>
			<a href="<?php echo $homeurlgen; ?>/notifications/" class="arb-side-icon"><img src="<?php echo $homeurlgen; ?>/svg/bell.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 5px;"></a>
			<a href="<?php echo $homeurlgen; ?>/vyndue/" class="arb-side-icon"><img src="<?php echo $homeurlgen; ?>/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
			<a href="<?php echo $homeurlgen; ?>/account/" class="arb-side-icon"><?php
				if ( $user ) : ?>
					<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" class="arb_proficon" />
				<?php else: ?>
					<i class="fas fa-user-tie"></i>
				<?php endif; ?></a>
			<div style="clear:both"></div>
		</div>    
	</div>

	<div id="page-container" class="fade page-content-full-height page-without-sidebar" ng-controller="template">
		<div id="content" class="content content-full-width" style="top: 40px; padding: 0;">
			<div class="vertical-box">
				<style type="text/css">
					#ticker {
						height: 60px;  
						padding: 5px 0;
						overflow: hidden; 
						white-space: nowrap; 
						padding-right: 0;
						border-bottom: 1px solid #ccc;
						margin-bottom: 0;
						text-transform: uppercase;
					}
					.text-grey {color:#bdc3c7}
					#ticker {
						height: 46px;
						padding: 5px 0;
						overflow: hidden;
						white-space: nowrap;
						padding-right: 0;
						border-bottom: 1px solid #2c3e50;
						margin-bottom: 0;
						text-transform: uppercase;
					}
					#ticker {background-color: #131722;}
					ul.nav.navbar-nav.navbar-right {
						background-color: #131722;
						margin-top: -1px;
					}
					.fa-arrow-up {
						color: #25ae5f;
					}
					.fa-arrow-down {
						color: #e64c3c;
					}
				</style>
				<div class="vertical-box-row">
					<div class="vertical-box-cell">
						<div class="vertical-box-inner-cell">
							<div style="height:100%" data-height="100%" ng-controller="chart">
								<div class="vertical-box">		
									<div class="vertical-box-column mobilefull" style="position: relative; height: 100%;">
										<div class="vertical-box" style="height: 100%;">
											<div class="vertical-box-row" style="height: 100%;">
												<div class="vertical-box-cell" style="height: 100%;">
													<div class="vertical-box-inner-cell" ng-controller="tradingview" style="height: 100%;">
														<div id="tv_chart_container"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="vertical-box-column width-250 mobileinithide" id="right-sidebar" ng-show="settings.right">
										<div class="showsidemobile">
											<i class="fa fa-outdent" aria-hidden="true"></i>
											<i class="fa fa-indent" aria-hidden="true"></i>
										</div>

										<div class="closesidebar">
											<a href="#"><img src="<?php echo get_home_url(); ?>/svg/close_verysmall.svg"></a>
										</div>

										<div class="opensidebar">
											<a href="#"><img src="<?php echo get_home_url(); ?>/svg/open_verysmall.svg"></a>
										</div>

										<div class="vertical-box">
											<div class="vertical-box-row ">
												<div class="vertical-box-cell">
													<div class="vertical-box-inner-cell">
														<div class="vertical-box">
															<div class="vertical-box-column">
																<div class="vertical-box">
																	<div class="vertical-box-row" style="height: 165px; overflow:hidden; display: block;">
																		<div id="stock-details" style="display:block" ng-show="stock">
																			<div class="arb_buysell" id="draggable_buysell">
																				<button class="buysell-grip-btn">
																					<i class="fa fa-grip-vertical fa-lg" style="color: white;"></i>
																				</button>
																				<div class="buttons">
																					<a class="arb_buy" data-fancybox data-src="#entertrade" href="javascript:;"><i class="fas fa-arrow-up"></i> Buy</a>
																					<a class="arb_sell" data-fancybox data-src="#buytrade" href="javascript:;"><i class="fas fa-arrow-down"></i> Sell</a>
																				</div>
																			</div>

																			<div class="hideformodal">  
																				<div class="entertrade" style="display:none" id="entertrade">
																					<?php
																						$dbaseaccount = 0;
																						foreach ($dledger as $dbaseledgekey => $dbaseledgevalue) {
																							if ($dbaseledgevalue->trantype == "deposit" || $dbaseledgevalue->trantype == "selling") {
																								$dbaseaccount = $dbaseaccount + $dbaseledgevalue->tranamount;
																							} else {
																								$dbaseaccount = $dbaseaccount - $dbaseledgevalue->tranamount;
																							}
																						}
																					?>

																					<div class="entr_ttle_bar">
																						<strong>Enter Buy Order</strong>
																					</div>

																					<form action="/journal" method="post">
																						<div class="entr_wrapper_top">
																							<div class="entr_col">
																								<div class="groupinput fctnlhdn">   
																								<label style="width:100%">Buy Date:</label>
																								<select name="inpt_data_buymonth" style="width:90px;">
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
																								<input type="text" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
																								<input type="text" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
																								</div>

																								<div class="groupinput midd lockedd"><label>Stock</label>
																								<input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="{{stock_details[stock.symbol].symbol}}" readonly>
																								<i class="fa fa-lock" aria-hidden="true"></i></div>

																								<div class="groupinput midd"><label>Buy Price</label><input type="text" class="inpt_data_price number" name="inpt_data_price" required></div>
																								<div class="groupinput midd"><label>Quantity</label><input type="text" class="inpt_data_qty number" name="inpt_data_qty" required></div>
																								<div class="groupinput midd label_date">
																									<label>Enter Date</label><input type="date" class="inpt_data_boardlot_get buySell__date-picker" required="" id="journal__trade-btn--date-picker">
																								</div>
																								<div class="midd lockedd"><label style="color: white;">Available Funds</label><input type="text" class="input_buy_power" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;" name="input_buy_power" data-dbaseval="<?php echo $dbaseaccount; ?>" value="<?php echo number_format( $dbaseaccount, 2, '.', ',' ); ?>" readonly></div>
																								<div class="midd lockedd"><label style="color: white;">Total Cost</label><input type="text" class="inpt_total_cost" name="" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;"></div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" value="{{stock.displayLast}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Change</label><input type="text" name="inpt_data_change" value="{{stock.displayChange}}%" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Open</label><input type="text" name="inpt_data_open" value="{{stock.displayOpen}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Low</label><input type="text" name="inpt_data_low" value="{{stock.displayLow}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>High</label><input type="text" name="inpt_data_high" value="{{stock.displayHigh}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput midd lockedd"><label>Volume</label><input type="text" name="inpt_data_volume" value="{{stock.volume | abbr}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Value</label><input type="text" name="inpt_data_value" value="{{stock.displayValue}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd">
																									<label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="inpt_data_boardlot" value="" readonly>
																									<i class="fa fa-lock" aria-hidden="true"></i>
																									<input type="hidden" id="inpt_data_boardlot_get" value="{{stock.displayLast}}">
																								</div>
																								<script>
																									$(document).ready(function() {
																										$( ".arb_buy" ).hover(function() {
																											var boardlotget = $("#inpt_data_boardlot_get").val();
																											if ( boardlotget >= 0.0001 && boardlotget <= 0.0099){
																													$("#inpt_data_boardlot").val(1000000);
																											} else if ( boardlotget >= 0.01 && boardlotget <= 0.049){
																													$("#inpt_data_boardlot").val(100000);
																											} else if ( boardlotget >= 0.05 && boardlotget <= 0.495){
																													$("#inpt_data_boardlot").val(10000);
																											} else if ( boardlotget >= 0.5 && boardlotget <= 4.99){
																													$("#inpt_data_boardlot").val(1000);
																											} else if ( boardlotget >= 5 && boardlotget <= 49.95){
																													$("#inpt_data_boardlot").val(100);
																											} else if ( boardlotget >= 50 && boardlotget <= 999.5){
																													$("#inpt_data_boardlot").val(10);
																											} else if ( boardlotget >= 1000){
																													$("#inpt_data_boardlot").val(5);
																											}
																											var getthestocksym = $('#inpt_data_stock').val();
																											$('#bidaskbox').prop('src', "<?php echo $homeurlgen; ?>/bidask-box/?stocksym="+getthestocksym);
																											console.log('joses ' + "/bidask-box/?stocksym="+getthestocksym);
																										});
																									<?php 
																										$getcururl = $_SERVER['REQUEST_URI'];
																										if ($getcururl == "/chart/"){ 
																									?>
																										$('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/pleaseselect.html");
																										$( ".ng-scope" ).click(function() {
																											var getthestocksym = $('#inpt_data_stock').val();
																											$('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/sentiments/"+getthestocksym);
																										});
																									<?php
																										} else {
																											$remchrt = str_replace("/chart/", "", $getcururl);
																											$getfsymb = str_replace("/", "", $remchrt); 
																									?>
																										$('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/sentiments/<?php echo $getfsymb; ?>");
																										$( ".ng-scope" ).click(function() {
																											var getthestocksym = $('#inpt_data_stock').val();
																											$('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/sentiments/"+getthestocksym);
																										});
																									<?php } ?>
																									});
																								</script>
																							</div>

																							<div class="entr_clear"></div>
																						</div>

																						<div class="derrormes" style="color: #f44336;"></div>

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
																								<!-- <iframe class="bidaskbox" id="bidaskbox" src="<?php //echo $homeurlgen; ?>/preloader.html"></!--> -->
																							</div>

																							<div class="groupinput">
																								<img class="chart-loader" src="https://arbitrage.ph/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right; margin-right: 20px;">
																								<input type="hidden" value="Live" name="inpt_data_status">
																								<input type="submit" class="confirmtrd green" style="outline: none;" value="Confirm Trade">
																							</div>
																						</div>
																					</form>
																				</div> 
																			</div>

																			<div style="padding: 3px 5px 5px 40px; margin-bottom: 2px;" id="sval" class="sd_border_btm">
																				<div class="arb_stock_name"><!-- STOCK NAME -->
																					<i class="fas " ng-class="{'fa-arrow-up': stock.change > 0, 'fa-arrow-down': stock.change < 0}" style="font-size: 35px;position: absolute; left: 4px;"></i>
																					<div class="name text-uppercase text-default" style="font-size: 15px; font-weight: bold; white-space: nowrap; width: 100%; overflow: hidden; 
																					text-overflow: ellipsis;">{{stock_details[stock.symbol].description}}</div>
																					<div class="figures" style="margin-top: 0; overflow: visible; white-space: nowrap;">
																						<span style="
																							font-size: 25px;
																							font-weight: bold;
																							letter-spacing: -1px;" class="text-default">{{stock.displayLast}}</span>
																						<span ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-yellow': stock.change == 0}" style="
																							font-size: 14px;
																							line-height: 1.42857143;">
																							<span style="font-size: 17px;font-weight: bold;margin-left: 5px;">{{stock.displayDifference}}</span> 
																							<span style="font-size: 17px;font-weight: bold;margin-left: 5px;">({{stock.displayChange}}%)</span>
																						</span>
																						<small class="arb_markcap">Market Capitalization: {{stock.displayMarketCap}}</small>
																					</div>
																				</div>
																			</div>

																			<div class="border-default" style="min-height: 77px;">
																				<div style="float: left; width: 50%;">
																					<table class="table table-condensed m-b-0 ">
																						<tbody style="font-size: 10px;">
																							<tr>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Previous</td>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-default"><strong>{{stock.displayPrevious}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Low</td>
																								<td style="font-weight: bold; padding: 5px;" class="" changediv="stock.low"><strong ng-class="{'text-green': stock.low > stock.previous, 'text-red': stock.low < stock.previous}">{{stock.displayLow}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkLow</td>
																								<td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearLow > stock.last, 'text-red': stock.weekYearLow < stock.last}">{{stock.weekYearLow}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Volume</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.volume"><strong>{{stock.volume | abbr}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Trades</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-default" changediv="stock.trades"><strong>{{stock.trades | numeraljs: '0,0'}}</strong></td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																				
																				<div style="float: left; width: 50%;">
																					<table class="table table-condensed m-b-0 sd_border_btm">
																						<tbody style="font-size: 10px;">
																							<tr>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Open</td>
																								<td style="border-top: none; font-weight: bold; padding: 5px;"><strong ng-class="{'text-green': stock.open > stock.previous, 'text-red': stock.open < stock.previous}">{{stock.displayOpen}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">High</td>
																								<td style="font-weight: bold; padding: 5px;" changediv="stock.high"><strong ng-class="{'text-green': stock.high > stock.previous, 'text-red': stock.high < stock.previous}">{{stock.displayHigh}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkHigh</td>
																								<td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearHigh > stock.last, 'text-red': stock.weekYearHigh < stock.last}">{{stock.weekYearHigh}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Value</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.value"><strong>{{stock.displayValue}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Average</td>
																								<td style="font-weight: bold; padding: 5px;" changediv="stock.average"><strong ng-class="{'text-green': stock.average > stock.previous, 'text-red': stock.average < stock.previous}">{{stock.displayAverage}}</strong></td>
																							</tr>
																						</tbody>
																					</table>
																				</div>

																				<div class="clearfix"></div>
																			</div>
																		</div>

																		<div class="arb_logo_placehldr">
																			<h2><img src="<?php echo $homeurlgen; ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:53%;;vertical-align:baseline"></h2>
																		</div>
																	</div>

																	<?php /*?> Bullish & Beasish <?php */
																		$link = $_SERVER['REQUEST_URI'];
																		$link_array = explode('/',$link);
																		$dxlink = array_filter($link_array);
																		$page = end($dxlink);

																		$dsentilist = get_post_meta( 504, '_sentiment_'.$page.'_list', true );
																		/* temp-disabled
																		if ($dsentilist && is_array( $dsentilist ) && in_array( get_current_user_id(), $dsentilist )) {
																			// echo "already voted";
																			// get the page sentiment
																			$dpullbear = get_post_meta( 504, '_sentiment_'.$page.'_bear', true );
																			$dpullbull = get_post_meta( 504, '_sentiment_'.$page.'_bull', true );

																			$curl = curl_init();	
																			curl_setopt($curl, CURLOPT_URL, 'https://marketdepth.pse.tools/api/market-depth?symbol='.$page );
																			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
																			$dwatchinfo = curl_exec($curl);
																			curl_close($curl);

																			$dstockidepthinfo = json_decode($dwatchinfo);
																			$dfinfodp = $dstockidepthinfo->data;

																			$dbidvol = ($dpullbear != "" ? $dpullbear : 0);
																			$daskvol = ($dpullbull != "" ? $dpullbull : 0);
																			foreach ($dfinfodp as $dpinfokey => $dpinfovalue) {
																				$dbidvol += $dpinfovalue->bid_volume;
																				$daskvol += $dpinfovalue->ask_volume;
																			}

																			$totalvols = $dbidvol + $daskvol;
																			$percbid = ($dbidvol / $totalvols) * 100;
																			$percask = ($daskvol / $totalvols) * 100;

																			

																		} else {
																			// echo "go vote";
																			$percbid = 0;
																			$percask = 0;
																		} temp-disabled */

																		

																		// echo $dpullbull." - ".$dpullbear;

																	?>

																	<div class="regsentiment">
																		<div class=" arb_padding_5 b0 arb_bullbear  {{dshowsentiment}}" style="<?php echo ($page != "chart" ? 'display:block;' : 'display:none;'); ?>height: 80px;overflow: hidden;">
																			<div class="bullbearsents" data-bull="{{fullbidtotal}}" data-bear="{{fullasktotal}}">
																				<span class="bullbearsents_label">Register your sentiments</span>
																				<a href="#" class="bbs_bull"><img src="<?php echo $homeurlgen; ?>/svg/ico_bullish_no_ring.svg"></a>
																				<div class="dbaronchart" style="width: <?php echo ($percbid > 0 ? '70' : ''); ?>%;">
																					<div class="bbs_bull_bar" style="width: <?php echo $percbid; ?>%;">
																						<div class="bbs_bull_bar_inner"></div>
																						<span style="<?php echo ($percbid > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percbid,2); ?>%</span>
																					</div>
																					<div class="bbs_bear_bar" style="width: <?php echo $percask; ?>%;">
																						<div class="bbs_bear_bar_inner"></div>
																						<span style="<?php echo ($percask > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percask,2); ?>%</span>
																					</div>
																				</div>
																				<a href="#" class="bbs_bear"><img src="<?php echo $homeurlgen; ?>/svg/ico_bearish_no_ring.svg"></a>
																			</div>
																			
																			
																			<div class="arb_clear"></div>
																		</div>
																	</div>

																	<?php /*?> Market Depth & Transactions <?php */?>

																	<div class="vertical-box-row" style="height: 138px; overflow:hidden; display: block; padding: 5px 0 0 0;">
																		<ul class="nav nav-tabs" style="border-radius: 0;">
																			<li>
																				<a href="#tab-marketepth" data-toggle="tab" style="padding: 5px 15px;margin-right: 0px;font-weight: bold;">
																					<small>Bids & Asks</small>
																				</a>
																			</li>
																			<li class="active">
																				<a href="#tab-transaxtions" data-toggle="tab" style="padding: 5px 15px;margin-right: 0px;font-weight: bold;">
																					<small>Time & Trades</small>
																				</a>
																			</li>
																		</ul>

																		<div class="vertical-box-cell">
																			<div class="vertical-box-inner-cell">
																				<div class="vertical-box">
																					<div class="vertical-box-column">
																						<!--Market Depth-->
																						<div class="vertical-box tab-pane fade" id="tab-marketepth">
																							<table class="table table-condensed m-b-0 text-default" style="font-size: 10px; width:97%">
																								<col width="8">
																								<col width="17%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<thead>
																									<tr>
																										<th class="border-default text-default text-center" style="padding: 3px 9px 3px 0 !important;">#</th>
																										<th class="border-default text-default text-left" style="padding: 3px !important;">VOL</th>
																										<th class="border-default text-default text-left" style="padding: 3px !important;">BID</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">ASK</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">VOL</th>
																										<th class="border-default text-default text-right" style="padding: 3px 12px 3px 3px !important;">#</th>
																									</tr>
																								</thead>
																							</table>
																							<div class="vertical-box-row">
																								<div class="vertical-box-cell">
																									<div class="vertical-box-inner-cell">
																										<div data-scrollbar="true" data-height="90%" class="" ng-if="enableBidsAndAsks">
																											<div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="8.335%">
																													<col width="8.335%">
																													<col width="8.335%">
																													<tbody>
																														<tr ng-repeat="bid in bids | orderBy: '-price'">
																															<td class="text-center" change="bid.count"><span>{{bid.count > 0 ? bid.count : ''}}</span></td>
																															<td class="text-left text-uppercase" change="bid.volume"><span>{{bid.volume > 0 ? (bid.volume | abbr) : ''}}</span></td>
																															<td class="text-left" ng-class="{'text-green': bid.price > stock.previous, 'text-red': bid.price < stock.previous}" change="bid.price"><strong>{{bid.price > 0 ? (bid.price | price) : ''}}</strong></td>
																														</tr>
																													</tbody>
																												</table>
																											</div><!--
																											--><div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="8.335%">
																													<col width="8.335%">
																													<col width="8.335%">
																													<tbody>
																														<tr ng-repeat="ask in asks">
																															<td class="text-right" ng-class="{'text-green': ask.price > stock.previous, 'text-red': ask.price < stock.previous}" change="ask.volume"><strong>{{ask.price > 0 ? (ask.price | price) : ''}}</strong></td>
																															<td class="text-right text-uppercase" change="ask.volume"><span>{{ask.volume > 0 ? (ask.volume | abbr) : ''}}</span></td>
																															<td class="text-right" style="padding-right: 12px !important;" change="ask.count"><span>{{ask.count > 0 ? ask.count : ''}}</span></td>
																														</tr>
																													</tbody>
																												</table>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>

																						<!-- Transactions -->
																						<div class="vertical-box tab-pane fade in active" id="tab-transaxtions">
																							<table class="table table-condensed m-b-0 text-default" style="font-size: 10px;">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<thead>
																									<tr>
																										<th class="border-default text-default" style="padding: 3px !important;">TIME</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">VOLUME</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">PRICE</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">BUYER</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">SELLER</th>
																									</tr>
																								</thead>
																							</table>

																							<div class="vertical-box-row">
																								<div class="vertical-box-cell">
																									<div class="vertical-box-inner-cell">
																										<div data-scrollbar="true" data-height="100%" class="">
																											<div class="table-responsive">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<tbody>
																														<tr ng-repeat="transaction in transactions">
																														<td class="text-default text-left" nowrap="nowrap">{{::transaction.time}}</td>
																														<td style="font-weight: bold;" class="text-default text-right text-uppercase" nowrap="nowrap">{{::transaction.shares | abbr}}</td>
																														<td style="font-weight: bold;" class="text-default text-right" nowrap="nowrap"><strong ng-class="{'text-green': transaction.price > stock.previous, 'text-red': transaction.price < stock.previous}" style="font-weight: bold;">{{::transaction.price}}</strong></td>
																														<td class="text-default text-right" nowrap="nowrap">{{::transaction.buyer | trim: 4}}</td>
																														<td style="padding-right: 10px;" class="text-default text-right" nowrap="nowrap">{{::transaction.seller | trim: 4}}</td>
																														</tr>
																														<tr ng-show="transactions.length == 0"><td colspan="5" align="center"><br />No recent transactions</td></tr>
																													</tbody>
																												</table>
																											</div>
																											<!-- <div ng-show="marketdepth.length != 0"> -->
																											<!-- </div> -->
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

																	<?php /*?> Bid/Ask Bar <?php */?>

																	<div class="arb_padding_5 b0 bidaskbar">
																		<span class="bidaskbar_btn">Bid/Ask Bar: <span>Top Five</span> <i class="fa ng-scope fa-caret-down"></i></span>

																		<div class="bidaskbar_opt">
																			<ul>
																				<li><a href="#" data-istype="topfive" class="topfive">Top Five</a></li>
																				<li><a href="#" data-istype="fullbar" class="fullbar">Full Depth</a></li>
																			</ul>
																			<script>
																				$(document).ready(function() {
																					$( ".bidaskbar_opt .topfive" ).click(function() {
																					$( ".bidaskbar_btn span" ).html("Top Five");
																					});
																					$( ".bidaskbar_opt .fullbar" ).click(function() {
																					$( ".bidaskbar_btn span" ).html("Full Depth");
																					});
																				});
																			</script>
																		</div>

																		<div class="arb_bar topfive">
																			<div class="greybarbg">
																				<div class="arb_bar_green" style="width:{{bidperc}}%">&nbsp;</div>
																				<div class="arb_bar_red" style="width:{{askperc}}%">&nbsp;</div>
																			</div>
																			<div class="arb_clear"></div>
																			<div class="dlabels">
																				<div class="buyers">
																					<span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{bidperc | number : 2}}%
																				</div>
																				<div class="sellers">
																					{{askperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
																				</div>
																			</div>
																			<div class="arb_clear"></div>
																		</div>

																		<div class="arb_bar fullbar" style="display: none">
																			<div class="arb_bar_green" style="width:{{fullbidperc}}%">&nbsp;</div>
																			<div class="arb_bar_red" style="width:{{fullaskperc}}%">&nbsp;</div>
																			<div class="arb_clear"></div>
																			<div class="dlabels">
																				<div class="buyers">
																					<span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{fullbidperc | number : 2}}%
																				</div>
																				<div class="sellers">
																					{{fullaskperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
																				</div>
																			</div>
																			<div class="arb_clear"></div>
																		</div>
																	</div>

																	<?php /*?> All stocks / Watchlist <?php */?>


																	<div class="fixbrdebtm"></div>

																	<div class="vertical-box-row allstocksbox" style="border-bottom-width:6px;">
																		<ul class="nav nav-tabs" style="border-radius: 0;">
																			<li class="active">
																				<a href="#allstock" data-toggle="tab" style="padding: 5px 15px; margin-right: 0px;font-weight: bold;" aria-expanded="true">
																					<small>All Stocks</small>
																				</a>
																			</li>
																			<li class="">
																				<a href="#watchlists" data-toggle="tab" style="padding: 5px 15px; margin-right: 0px;font-weight: bold;" aria-expanded="false">
																					<small>Watchlist</small>
																				</a>
																			</li>
																		</ul>

																		<div style="clear:both"></div>

																		<div class="vertical-box">
																			<div class="vertical-box-row">
																				<div class="vertical-box-cell">
																					<div class="tab-content vertical-box-inner-cell" style="background-color: transparent; border-radius: 0; padding: 0; margin-bottom: 0;">
																						<div data-scrollbar="true" data-height="100%" style="height: 100%;">
																							<div class="vertical-box tab-pane fade in active" id="allstock">
																								<table class="table table-condensed m-b-0" style="font-size: 10px; width:90%;">
																									<thead style="position: fixed; background-color: #2c3e50">
																										<tr>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('symbol')" style="padding: 3px 12px 3px 6px !important; cursor: pointer;">
																												<strong>STOCK</strong>
																												<i ng-if="sort == 'symbol'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('last')" style="padding: 3px 15px 3px 4px !important; cursor: pointer;">
																												<strong>LAST</strong>
																												<i ng-if="sort == 'last'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('change_percentage')" style="padding: 3px !important; cursor: pointer;">
																												<strong>CHANGE</strong>
																												<i ng-if="sort == 'change'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('value')" style="padding: 3px !important; cursor: pointer;">
																												<strong>VALUE</strong>
																												<i ng-if="sort == 'value'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('trades')" style="padding: 3px !important; cursor: pointer;">
																												<strong>TRADES</strong>
																												<i ng-if="sort == 'trades'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
																											</th>
																											<?php /*?><th class="text-default border-default text-right" nowrap="nowrap" style="padding-right: 10px;">
																												<a ng-if="watchlists[watchlist] != 'stocks' && watchlists[watchlist] != 'new' && watchlist != 'Default Watchlist'" href="javascript:void(0);" ng-click="deleteWatchlist(watchlist)" class="text-red-darker" title="Delete Watchlist"><i class="fa fa-fw fa-trash"></i></a>
																											</th><?php */?>
																										</tr>
																									</thead>
																								</table>

																								<table class="dstocklistitems table table-condensed m-b-0 text-inverse border-default" style="font-size: 10px; border-bottom: 1px solid; width:97%; margin-top: 19px;">
																									<tbody>
																										<tr 
																											ng-show="watchlists[watchlist] == 'stocks' || watchlists[watchlist].indexOf(stock.symbol) !== -1" 
																											ng-repeat="stock in stocks | orderBy: sort : reverse track by stock.symbol" 
																											ng-class="{'text-green': stock.displayChange > 0, 'text-red': stock.displayChange < 0, 'text-yellow': stock.displayChange == 0, 'bg-grey-transparent-5': stock.symbol == $parent.stock.symbol, 'hidden': sort != 'symbol' && !latest_trading_date.isSame(stock.lastupdatetime, 'day')}" 
																											change-alt="stock"
																											style="font-weight: bold;" 
																											>
																											<td class="text-default dspecitem" style="padding: 0px 7px 0 7px !important;" ng-click="select(stock.symbol)" style="cursor: pointer;">
																												<div style="width: 0; height: 0; overflow: hidden; display: block;">
																													<input type="radio" name="selected_stock" ng-model="selectedStock" value="{{::stock.symbol}}" id="select-{{::stock.symbol}}"/>
																												</div>
																												<div class="ditemone" style="cursor: pointer;">{{::stock.symbol}}</div>
																											</td>
																											<td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.displayLast}}</td>
																											<td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;text-align: center;">{{stock.displayChange}}%</td>
																											<td align="left" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.displayValue}}</td>
																											<td align="right" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.trades | numeraljs:'0,0'}}</td>
																											<?php /*?><td align="right" class="text-default" style="padding-right: 10px; font-weight: normal;">
																												<a ng-if="watchlists[watchlist] == 'stocks'" href="javascript:void(0);" ng-click="addToWatchlist(stock.symbol)" class="text-default"><i class="fa fa-fw fa-plus"></i></a>
																												<a ng-if="watchlists[watchlist] != 'stocks'" href="javascript:void(0);" ng-click="removeFromWatchlist(watchlists[watchlist], stock.symbol)" class="text-red-darker" title="Remove Stock"><i class="fa fa-fw fa-trash"></i></a>
																											</td><?php */?>
																										</tr>
																										<tr ng-if="watchlists[watchlist].length == 0">
																											<td colspan="5" align="center">No Data Found</td>
																										</tr>
																									</tbody>
																								</table>
																							</div>

																							<div class="vertical-box tab-pane fade" id="watchlists">
																								<div class="arb_watchlst_cont">
																									<table>
																										<thead style="text-transform: uppercase;font-weight: normal !important;font-family: 'Roboto', Arial !important;">
																											<tr>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Stock</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Day Range</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Price</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Change</strong></th>
																											</tr>
																										</thead>
																										<?php
		/* temp-disabled
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dwatchinfo = curl_exec($curl);
		curl_close($curl);
		$genstockinfo = json_decode($dwatchinfo);
		$stockinfo = $genstockinfo->data;
		temp-disabled */

		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE' );
		  curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
		  curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	      $dhistofronold = curl_exec($curl);
	      curl_close($curl);

	      $dhistoforchart = json_decode($dhistofronold);
	      $stockinfo = $dhistoforchart->data;

		  $userID = $current_user->ID;
																										?>
			<tbody>
				<?php $havemeta = get_user_meta($userID, '_watchlist_instrumental', true); ?>
				<?php if ($havemeta): ?>
				
				<?php foreach ($havemeta as $key => $value) { ?>
				<?php

					$dstock = $value['stockname'];
					//$dprice = $stockinfo->$dstock->last;
					//$dchange = $stockinfo->$dstock->change;

					$dprice = 0;
					$dchange = 0;

						foreach($stockinfo as $stkey => $stvals){
                              if($stvals->symbol == $dstock ){
                                $dprice = $stvals->last;
								$dchange = $stvals->changepercentage;
								$dlow = $stvals->low;
								$dhigh = $stvals->high;
                              }
                          }

						
						//echo " --- ". $dpr;
						
					?>
					<tr class="tr-background">
						<td ng-click="select('<?php echo $value['stockname']; ?>')">	<div class="block"><?php echo $value['stockname']; ?></div></td>
						<td ng-click="select('<?php echo $value['stockname']; ?>')"><?php echo number_format( $dlow, 2, '.', ',' ); ?> ~ <?php echo number_format( $dhigh, 2, '.', ',' ); ?></td>
						<td style="text-align: left;" ng-click="select('<?php echo $value['stockname']; ?>')">
							<?php if ($dchange > 0): ?>
								<div class="chgreen-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
							<?php else: ?>
								<div class="chred-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
							<?php endif ?>
						</td>
						<td style="padding-left: 4px !important;" ng-click="select('<?php echo $value['stockname']; ?>')">
							<?php if ($dchange > 0): ?>
								<div class="chgreen"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
							<?php else: ?>
								<div class="chred"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
							<?php endif ?>
							
						</td>
					</tr>
				<?php } ?>
				<?php endif ?>

			</tbody>
																									</table>
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
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>	
										
									<div class="chartlocker"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end #content -->

		<!-- begin theme-panel -->
		<div class="theme-panel">
			<a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn" style="border: 1px solid #ccc; border-right: none; display: none;"><i class="fa fa-cog"></i></a>
			<div class="theme-panel-content">
				<h5 class="m-t-0">Settings</h5>
				<div class="row m-t-10">
					<div class="col-md-5 control-label double-line">Chart</div>
					<div class="col-md-7">
						<select name="header-styling" class="form-control input-sm" ng-model="settings.chart" ng-change="updateSettings('chart')">
							<option value="1">Volume On</option>
							<option value="0">Mute</option>
						</select>
					</div>
				</div>
				<?php /* ?>
				<div class="row m-t-10">
					<div class="col-md-5 control-label double-line">Chat</div>
					<div class="col-md-7">
						<select name="header-styling" class="form-control input-sm" ng-model="settings.chat" ng-change="updateSettings('chat')">
							<option value="1">Volume On</option>
							<option value="0">Mute</option>
						</select>
					</div>
				</div>
				<?php */ ?>
				<div class="row m-t-10">
					<div class="col-md-5 control-label double-line">Disclosure</div>
					<div class="col-md-7">
						<select name="sidebar-styling" class="form-control input-sm" ng-model="settings.disclosure" ng-change="updateSettings('disclosure')">
							<option value="1">Show</option>
							<option value="0">Disable</option>
						</select>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-12">
						<button type="button" class="btn btn-inverse btn-block btn-sm" data-click="theme-panel-expand">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- end theme-panel -->
		
	</div>
    <!-- end page container -->

    <div class="arbmobilebtns">
    	<ul>
        	<li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script>
	$( function() {
		$('#draggable_buysell').draggable({cancel:false});
	} );
	</script>
	<script>
		var today = new Date();
		var currentDate = today.getFullYear()+'-'+ ('0' + (today.getMonth()+1)).slice(-2) +'-'+ ("0" + today.getDate()).slice(-2);	
		jQuery(".buySell__date-picker").attr('max',currentDate);
	</script>
	<!--[if lt IE 9]>
		<script src="/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="/assets/crossbrowserjs/respond.min.js"></script>
		<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="/assets/js/apps.min.js"></script>
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
	<script src="/assets/plugins/ng-embed/dist/ng-embed.min.js"></script>
	<script src="/assets/js/jquery.fullscreen-min.js"></script>
	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/js/aes.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
	<script src="https://platform.twitter.com/widgets.js"></script>
	<script>
		var modalzindex = 10000;
		var nightmode = localStorage.getItem('theme') == 'dark';
        var socket = io.connect('https://dev-socket-api.arbitrage.ph');
		$(document).ready(function() {
			App.init();
		    $( function () {
		        $(".stocks-select2").select2({placeholder:"Stock", width: '100%'})
		    });
		});
		var _stocks     = {};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '<?php echo $user->ID; ?>'
		var _username 	= '<?php echo $user->user_email; ?>';
		var _symbol 	= '<?php 
		$getcururl = $_SERVER['REQUEST_URI'];
		if ($getcururl == "/chart/"){
			echo "PSEI";
		}else{
			$remchrt = str_replace("/chart/", "", $getcururl);
			$getfsymb = str_replace("/", "", $remchrt);
			echo strtoupper($getfsymb);
		}
		?>';
	</script>
	<script src="/assets/js/angular/functions.js?v=1.220"></script>
	<script src="/assets/js/angular/controllers.js?v=<?php echo time() ?>"></script>
	<script src="/assets/js/angular/directives.js?v=1.218"></script>
	<script src="/assets/js/angular/filters.js?v=1.218"></script>
	<script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
	<script src="/assets/js/datafeed.js?v=2.218"></script>
	<!-- <script src="<?php // echo get_stylesheet_directory_uri(); ?>/js/arphie-script.js"></script> -->
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
		.nav-tabs {
			background: #34495e;
			padding-top: 4px;
		}
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			font-family: "Roboto", Arial !important;
			font-weight: normal !important;
			padding: 0px 7px 0 3px !important;
			border: none !important;
		}
		.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
			color: #fff !important;
			background-color: #2c3e50 !important;
			border-radius: 0;
			padding-top:5px !important;
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
			text-align: center;
			width: 13%;
			font-size: 20px;
			color: #ffffff;
			padding: 4px 0 0;
			display: inline-block;
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
			border-radius: 6px 6px 0 0 !important;
			overflow: hidden;
		}
		.nav>li>a:focus, .nav>li>a:hover,
		.nav-tabs li:hover {border-radius:4px 4px 0 0 !important;}
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
		/*background: rgba(0,0,0,0.3);*/
		.arb_top_ticker {display:block;}
		.hidesidebar {
			width: 3px !important;
			/*transition: all 0.1s ease;*/
			border-right: 0 !important;
			border-left: 4px solid #34495e !important;
		}
		svg {
			border: 2px solid white;
			border-radius: 20px;
			background: black;
		}
		.arb_buysell {
			background-color: rgba(215, 215, 215, .15);
			position: absolute;
			padding: 5px 20px 5px 30px;
			border-radius: 10px;
		}
		.buttons {
			border-left: 1px solid white;
			padding-left: 3px;
		}
		.buysell-grip-btn {
			background: transparent;
			border: 0px;
			position: absolute;
			left: 5px;
			bottom: 6px;
			outline: none;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			var x = 0;
			var y = 0;

			function fees(marketval) {

				//commission
				var dpartcommission = marketval * 0.0025;
				var dcommission = (dpartcommission > 20 ? dpartcommission : 20);

				var dtax = dcommission * 0.12;
				var dtransferfee = marketval * 0.00005;
				var dsccp = marketval * 0.0001;

				return dcommission + dtax + dtransferfee + dsccp;
			}
			function format_number(n) {
			return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
			}

			$('.inpt_data_price, .inpt_data_qty').keyup(function() {
				var buyprice = $('.inpt_data_price').val().replace(/[^0-9\.]/g, '');
				var buyquanti = $('.inpt_data_qty').val().replace(/[^0-9\.]/g, '');

				if (parseFloat(buyprice) > 0 && parseFloat(buyquanti) > 0) {
					var marketvalx = parseFloat(buyprice) * parseFloat(buyquanti);
					var dfees = fees(marketvalx);

					var totalcost = marketvalx + dfees;

					$(".inpt_total_cost").val(format_number(totalcost));
				} else {
					$(".inpt_total_cost").val('00.00');
				}
				
			});

			
		
		$( ".closesidebar a" ).click(function(){
			$( ".mobileinithide" ).addClass("hidesidebar", function(){
				$(".closesidebar").fadeOut("fast", function(){
					$(".opensidebar").fadeIn();
				});
			});
		});
		
		$( ".opensidebar a" ).click(function(){
			$( ".mobileinithide" ).addClass("showsidebar", function(){
				$(".opensidebar").fadeOut("fast", function(){
					$( ".mobileinithide" ).removeClass("hidesidebar");
					$( ".closesidebar" ).fadeIn();
				});
			});
		});
		
		
		$( ".mobileinithide .fa-outdent" ).click(function(){
			$( ".mobileinithide" ).animate({right: "0px"},500, function(){
				$( ".chartlocker" ).fadeIn(500);
				$( ".mobileinithide .fa-outdent" ).fadeOut(500, function(){
					$( ".mobileinithide .fa-indent, .arb_buysell" ).fadeIn();
				});
			});
		});
		$( ".mobileinithide .fa-indent" ).click(function(){
			$( ".mobileinithide" ).animate({right: "-260px"},500, function(){
				$( ".mobileinithide .fa-indent" ).fadeOut(500, function(){
					$( ".mobileinithide .fa-outdent, .arb_buysell" ).fadeIn();
				});
				$( ".chartlocker" ).fadeOut(500);
			});
		});
			
			$(".bbs_bull").click(function(e){
				e.preventDefault();
				if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {
					var pathname = window.location.pathname;

					$(this).parents('.bullbearsents').addClass("clickedthis");

					var dbull = $(this).parents('.bullbearsents').attr('data-bull');
					var dbear = $(this).parents('.bullbearsents').attr('data-bear');

					var dclass = $(this).attr('class');

					var dpathl = pathname.split("/");
					dpathl = dpathl.filter(function(el) { return el; });
					dpathl = dpathl[(parseInt(dpathl.length) - 1)];

					jQuery.ajax({
						method: "POST",
						url: "<?php echo $homeurlgen; ?>/apipge/?daction=sentimentbull&stock="+dpathl+"&userid=<?php echo $user_id; ?>&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
						dataType: 'json',
						data: {
							'action' : 'post_sentiment',
							'stock' : dpathl,
							'postid' : '<?php echo get_the_id(); ?>',
							'userid' : '<?php echo $user_id; ?>',
							'dbasebull': dbull,
							'dbasebear': dbear,
							'dbuttonact' : dclass
						},
						success: function(data) {

						// jQuery(".bbs_bull_bar").removeAttr('style').css({"width" : data.dbull+"%", "margin-top" : "11px"});
						// jQuery(".bbs_bear_bar").removeAttr('style').css({"width" : data.dbear+"%", "margin-top" : "11px"});

							$( ".dbaronchart" ).animate({
								width: "70%"
							},500, function(){
								// $( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
									$( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
							});

							$( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

							$( ".bbs_bear_bar" ).animate({
								width: data.dbear+"%"
							},500, function(){
								$( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
								$( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bull_bar" ).animate({
								width: data.dbull+"%"
							},500, function(){
								$( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
								$( ".bbs_bull_bar span" ).fadeIn("fast");
							});

							$(".bullbearsents_label").html("Members sentiments");

						}
					});

				} 
			});

			$(".bbs_bear").click(function(e){
				e.preventDefault();
				if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {
					var pathname = window.location.pathname;

					$(this).parents('.bullbearsents').addClass("clickedthis");

					var dbull = $(this).parents('.bullbearsents').attr('data-bull');
					var dbear = $(this).parents('.bullbearsents').attr('data-bear');

					var dclass = $(this).attr('class');

					var dpathl = pathname.split("/");
					dpathl = dpathl.filter(function(el) { return el; });
					dpathl = dpathl[(parseInt(dpathl.length) - 1)];

					jQuery.ajax({
						method: "POST",
						url: "<?php echo $homeurlgen; ?>/apipge/?daction=sentimentbear&stock="+dpathl+"&userid=<?php echo $user_id; ?>&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
						dataType: 'json',
						data: {
							'action' : 'post_sentiment',
							'stock' : dpathl,
							'postid' : '<?php echo get_the_id(); ?>',
							'userid' : '<?php echo $user_id; ?>',
							'dbasebull': dbull,
							'dbasebear': dbear,
							'dbuttonact' : dclass
						},
						success: function(data) {

						// jQuery(".bbs_bull_bar").removeAttr('style').css({"width" : data.dbull+"%", "margin-top" : "11px"});
						// jQuery(".bbs_bear_bar").removeAttr('style').css({"width" : data.dbear+"%", "margin-top" : "11px"});

							$( ".dbaronchart" ).animate({
								width: "70%"
							},500, function(){
								// $( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
									$( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
							});

							$( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

							$( ".bbs_bear_bar" ).animate({
								width: data.dbear+"%"
							},500, function(){
								$( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
								$( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bull_bar" ).animate({
								width: data.dbull+"%"
							},500, function(){
								$( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
								$( ".bbs_bull_bar span" ).fadeIn("fast");
							});

							$(".bullbearsents_label").html("Members sentiments");

						}
					});

				} 
			});

		jQuery('.inpt_data_price').keyup(function(){
			var inputVal = jQuery(this).val().length;
			if(inputVal != 0){
				y = 1
			}
		});
		jQuery('.inpt_data_qty').keyup(function(){
			var inputVal2 = jQuery(this).val().length;
			if(inputVal2 != 0){
				x = 1
			}
		});

		$(".confirmtrd").click(function(e){

			var dbuypower = $(".input_buy_power").attr('data-dbaseval');
			var dpurprice = $(".inpt_data_price").val().replace(/[^0-9\.]/g, '');
			var dpurqty = $(".inpt_data_qty").val().replace(/[^0-9\.]/g, '');		
			
			if (parseFloat(dbuypower) < (parseFloat(dpurprice) * parseFloat(dpurqty))) {
				e.preventDefault();
				$(".derrormes").text('You can only purchase a maximum of '+ numeral(dbuypower / dpurprice).format('0,0.00') +' stocks if the price is ₱'+ numeral(dpurprice).format('0,0.00')  );
			}else {
				if(x == 1 && y == 1){
				$('.chart-loader').css("display","block");
				$(this).hide();
			}
			}
		
		});

        jQuery('input.number').keyup(function (event) {
                // charts
				// skip for arrow keys
				if (event.which >= 37 && event.which <= 40) {
					event.preventDefault();
				}

				var currentVal = jQuery(this).val();
				var testDecimal = testDecimals(currentVal);
				if (testDecimal.length > 1) {
					currentVal = currentVal.slice(0, -1);
				}
				jQuery(this).val(replaceCommas(currentVal));

			});

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
</body>
</html>