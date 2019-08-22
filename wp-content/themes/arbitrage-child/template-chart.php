<?php
	/*
	* Template Name: Chart Page
	* Template page for Trading Chart
	*/
	global $current_user;
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( $homeurlgen.'/login/', 301 );
		exit;
	}
	
	/* temp-disabled
	$homeurlgen = get_home_url();
	$user_id = $user->ID;
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
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
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
		    width: 164px;
		    right: -54px;
		    top: -1px;
		    background-color: transparent;
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
		padding: 7px 5px 0 5px;
		background: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg) no-repeat 50% 50% transparent;
		background-size: 50px;
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
		padding: 45px 0 0;
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
		margin:-3px 2px 0px;
	}
	.bullbearsents .bbs_bear img {
		width:15px;
	}
	.bullbearsents .bbs_bull img {
		width:18px;
	}
	.bullbearsents .bbs_bull {
		background-color: #25ae5f;
		padding: 6px;
		border-radius: 20px;
	}
	.bullbearsents .bbs_bull:hover {
		background-color: #229a55;	
	}
	.bullbearsents .bbs_bear {
		background-color: #e64c3c;
		padding: 6px;
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
		margin-bottom: -5px;
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

	}
	.bbs_bull_bar, .bbs_bear_bar {
		margin-top: 11px;
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
	.dopensentiment,
	.openmenow > .arb_bullbear {
		display: block !important;
	}
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
			top: 49px;
			left: -78px;
			width: 72px;
			text-align: right;
			background-color: #2c3e50;
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
		bottom: -167px;
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
	    max-width: 550px;
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
	    height: 40em;
	    overflow: auto;
	}
	.halfts::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		border-radius: 11px;
		background-color: #0f121d;
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
			forevertickerinit();
			function forevertickerinit() {
				$('.marqueethis').animate({'width': '+=100px'}, 2000, "linear", function() {
					foreverticker();
				});
			}
			function foreverticker() {
				$('.marqueethis').animate({'width': '+=100px'}, 2000, "linear", function() {
					forevertickerinit();
				});
			}
			
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
	<div class="chart_logo_arbitrage"><a href="https://arbitrage.ph/" target="_blank"><img src="https://arbitrage.ph/wp-content/uploads/2018/12/logo.png"></a></div>
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
        <a href="<?php echo $homeurlgen; ?>/messages/" class="arb-side-icon"><img src="<?php echo $homeurlgen; ?>/svg/ico_messager_white.svg" style="width: 18px;display: inline-block;vertical-align: top;margin-top:5px"></a>
        <a href="<?php echo $homeurlgen; ?>/account/" class="arb-side-icon"><?php
            if ( $user ) : ?>
                <img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" style="width: 24px;height: 24px;margin-left: 5px;" class="arb_proficon" />
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
                                                <div class="arb_buysell">
                                                    <a class="arb_buy" data-fancybox data-src="#entertrade" href="javascript:;"><i class="fas fa-arrow-up"></i> Buy</a>
                                                    <a class="arb_sell" data-fancybox data-src="#buytrade" href="javascript:;"><i class="fas fa-arrow-down"></i> Sell</a>
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
                                                    <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
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
                                                            <div class="groupinput midd lockedd"><label>Buy Power</label><input type="text" class="input_buy_power" name="input_buy_power" data-dbaseval="<?php echo $dbaseaccount; ?>" value="<?php echo number_format( $dbaseaccount, 2, '.', ',' ); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                            <div class="groupinput midd"><label>Buy Price</label><input type="text" class="inpt_data_price" name="inpt_data_price" required></div>
                                                            <div class="groupinput midd"><label>Quantity</label><input type="text" class="inpt_data_qty" name="inpt_data_qty" required></div>
                                                            <div class="groupinput midd lockedd"><label>Total Cost</label><input type="text" class="inpt_total_cost" name=""><i class="fa fa-lock" aria-hidden="true"></i></div>
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
                                                                    });
                                                                
                                                                <?php 
                                                                $getcururl = $_SERVER['REQUEST_URI'];
                                                                if ($getcururl == "/chart/"){ ?>
                                                                    $('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/pleaseselect.html");
                                                                    $( ".ng-scope" ).click(function() {
                                                                        var getthestocksym = $('#inpt_data_stock').val();
                                                                        $('#bullbearframe').prop('src', "<?php echo $homeurlgen; ?>/sentiments/"+getthestocksym);
                                                                    }); <?php
                                                                }else{
                                                                    $remchrt = str_replace("/chart/", "", $getcururl);
                                                                    $getfsymb = str_replace("/", "", $remchrt); ?>
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
                                                <div class="derrormes" style="color: red;"></div>
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
                                                        <iframe class="bidaskbox" id="bidaskbox" src="<?php echo $homeurlgen; ?>/preloader.html"></iframe>
                                                    </div>
                                                    <div class="groupinput">
                                                    	<img class="chart-loader" src="https://arbitrage.ph/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right; margin-right: 20px;">
                                                        <input type="hidden" value="Live" name="inpt_data_status">
                                                        <input type="submit" class="confirmtrd green" value="Confirm Trade">
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
                                                    <span ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0}" style="
                                                        font-size: 14px;
                                                        line-height: 1.42857143;">
                                                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">{{stock.displayDifference}}</span> 
                                                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">({{stock.displayChange}}%)</span>
                                                    </span>
                                                    <small class="arb_markcap">Market Capitalization: 23.5B</small>
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
                                                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock_details[stock.symbol].wiklo52 > stock.last, 'text-red': stock_details[stock.symbol].wiklo52 < stock.last}">{{stock_details[stock.symbol].wiklo52 | price}}</strong></td>
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
                                                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock_details[stock.symbol].wikhi52 > stock.last, 'text-red': stock_details[stock.symbol].wikhi52 < stock.last}">{{stock_details[stock.symbol].wikhi52 | price}}</strong></td>
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
                                                            <h2><img src="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/logo.png" style="vertical-align:baseline">RBITRAGE</h2>
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
                                                            	<div class=" arb_padding_5 b0 arb_bullbear  {{dshowsentiment}}" style="<?php echo ($page != "chart" ? 'display:block;' : 'display:none;'); ?>height: 67px;overflow: hidden;">
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
                                                                    <li class="active">
                                                                        <a href="#tab-marketepth" data-toggle="tab" style="padding: 5px 15px;margin-right: 0px;font-weight: bold;">
                                                                            <small>Bids & Asks</small>
                                                                        </a>
                                                                    </li>
                                                                    <li>
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
                                                                                <div class="vertical-box tab-pane fade in active" id="tab-marketepth">
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
                                                                                                <div data-scrollbar="true" data-height="90%" class="">
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px; width:97%">
                                                                                                            <col width="16.67%">
                                                                                                            <col width="16.67%">
                                                                                                            <col width="16.67%">
                                                                                                            <col width="16.67%">
                                                                                                            <col width="16.67%">
                                                                                                            <col width="16.67%">
                                                                                                            <tbody>
                            <tr ng-repeat="bidask in marketdepth | orderBy: 'index' | limitTo: 20 track by bidask.index">
                                <td class="text-center" change="bidask.bid_count"><span>{{bidask.bid_count > 0 ? bidask.bid_count : ''}}</span></td>
                                <td class="text-left text-uppercase" change="bidask.bid_volume"><span>{{bidask.bid_volume > 0 ? (bidask.bid_volume | abbr) : ''}}</span></td>
                                <td class="text-left" ng-class="{'text-green': bidask.bid_price > stock.previous, 'text-red': bidask.bid_price < stock.previous}" change="bidask.bid_price"><strong>{{bidask.bid_price > 0 ? (bidask.bid_price | price) : ''}}</strong></td>
                                <td class="text-right" ng-class="{'text-green': bidask.ask_price > stock.previous, 'text-red': bidask.ask_price < stock.previous}" change="bidask.ask_volume"><strong>{{bidask.ask_price > 0 ? (bidask.ask_price | price) : ''}}</strong></td>
                                <td class="text-right text-uppercase" change="bidask.ask_volume"><span>{{bidask.ask_volume > 0 ? (bidask.ask_volume | abbr) : ''}}</span></td>
                                <td class="text-right" style="padding-right: 12px !important;" change="bidask.ask_count"><span>{{bidask.ask_count > 0 ? bidask.ask_count : ''}}</span></td>
                            </tr>
                            <tr ng-show="marketdepth.length == 0"><td colspan="5" align="center"><br /><br />Please select a stock</td></tr>
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
                                                                                <!-- Transactions -->
                                                                                <div class="vertical-box tab-pane fade" id="tab-transaxtions">
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
                            <td style="font-weight: bold;" class="text-default text-right" nowrap="nowrap"><strong ng-class="::{'text-green': transaction.price > stock.previous, 'text-red': transaction.price < stock.previous}" style="font-weight: bold;">{{::transaction.price | price}}</strong></td>
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
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('symbol')" style="padding: 3px 12px 3px 6px !important; cursor: pointer;">
                                                                            STOCK
                                                                            <i ng-if="sort == 'symbol'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
                                                                        </th>
                                                                        <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('last')" style="padding: 3px 15px 3px 4px !important; cursor: pointer;">
                                                                            LAST
                                                                            <i ng-if="sort == 'last'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
                                                                        </th>
                                                                        <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('change')" style="padding: 3px !important; cursor: pointer;">
                                                                            CHANGE
                                                                            <i ng-if="sort == 'change'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
                                                                        </th>
                                                                        <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('value')" style="padding: 3px !important; cursor: pointer;">
                                                                            VALUE
                                                                            <i ng-if="sort == 'value'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
                                                                        </th>
                                                                        <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('trades')" style="padding: 3px !important; cursor: pointer;">
                                                                            TRADES
                                                                            <i ng-if="sort == 'trades'" class="fa" ng-class="{'fa-caret-down':reverse, 'fa-caret-up':!reverse}"></i>
                                                                        </th>
                                                                        <?php /*?><th class="text-default border-default text-right" nowrap="nowrap" style="padding-right: 10px;">
                                                                            <a ng-if="watchlists[watchlist] != 'stocks' && watchlists[watchlist] != 'new' && watchlist != 'Default Watchlist'" href="javascript:void(0);" ng-click="deleteWatchlist(watchlist)" class="text-red-darker" title="Delete Watchlist"><i class="fa fa-fw fa-trash"></i></a>
                                                                        </th><?php */?>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <table class="dstocklistitems table table-condensed m-b-0 text-inverse border-default" style="font-size: 10px; border-bottom: 1px solid; width:97%">
                                                                <tbody>
                                                                    <tr 
                                                                        ng-show="watchlists[watchlist] == 'stocks' || watchlists[watchlist].indexOf(stock.symbol) !== -1" 
                                                                        ng-repeat="stock in stocks | orderBy: sort : reverse track by stock.symbol" 
                                                                        ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-default': stock.change == 0, 'bg-grey-transparent-5': stock.symbol == $parent.stock.symbol}" 
                                                                        change-alt="stock"
                                                                        style="font-weight: bold;" 
                                                                        >
                                                                        <td class="text-default dspecitem" style="padding: 0px 7px 0 7px !important;" ng-click="select(stock.symbol)" style="cursor: pointer;">
                                                                            <div style="width: 0; height: 0; overflow: hidden; display: block;">
                                                                                <input type="radio" name="selected_stock" ng-model="selectedStock" value="{{::stock.symbol}}" id="select-{{::stock.symbol}}"/>
                                                                            </div>
                                                                            <div class="ditemone">{{::stock.symbol}}</div>
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
	                                                            			<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;">Stock</th>
	                                                            			<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;">Day Range</th>
	                                                            			<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;">Price</th>
	                                                            			<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;">Change</th>
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
																	?>
                                                            		<tbody>
                                                            			
                                                            			<?php $havemeta = get_user_meta($user_id, '_watchlist_instrumental', true); ?>
                                                            			<?php if ($havemeta): ?>
                                                            				
                                                            			
                                                            			<?php foreach ($havemeta as $key => $value) { ?>
																		<?php

																			$dstock = $value['stockname'];
																			$dprice = $stockinfo->$dstock->last;
																			$dchange = $stockinfo->$dstock->change;
																			?>
																			<tr class="tr-background">
		                                                            			<td ng-click="select('<?php echo $value['stockname']; ?>')">	<div class="block"><?php echo $value['stockname']; ?></div></td>
		                                                            			<td ng-click="select('<?php echo $value['stockname']; ?>')"><?php echo number_format( $stockinfo->$dstock->low, 2, '.', ',' ); ?> ~ <?php echo number_format( $stockinfo->$dstock->high, 2, '.', ',' ); ?></td>
		                                                            			<td style="text-align: left;" ng-click="select('<?php echo $value['stockname']; ?>')">
		                                                            				<?php if ($dchange > 0): ?>
		                                                            					<div class="chgreen-price">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
		                                                            				<?php else: ?>
		                                                            					<div class="chred-price">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
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
<!-- end theme-panel -->		<!-- end #content -->
<div class="modal modal-special fade" id="chat-modal" data-backdrop="false" data-keyboard="false" ng-controller="chat">
    <div class="modal-dialog modal-sm" style="margin: 0; width: 300px; height: 454px;">
        <div class="modal-content">
            <!-- begin widget-chat -->
            <div class="widget-chat widget-chat-rounded" style="border: 1px solid #ccc;">
                <!-- begin widget-chat-header -->
                <div class="widget-chat-header" style="cursor: move;">
                    <div class="widget-chat-header-icon">
                        <i class="fa fa-comment-alt width-30 height-30 f-s-20 bg-grey text-inverse text-center rounded-corner" style="line-height: 30px"></i>
                    </div>
                    <div class="widget-chat-header-content">
                        <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button>
                        <a href="javascript:void(0);" class="pull-right" onclick="window.open('/chat', 'chat', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=728,height=600,left=0,top=0');"><i class="fa fa-external-link-alt"></i></a>
                        <h4 class="widget-chat-header-title">Chatroom</h4>
                        <p class="widget-chat-header-desc">{{active_users}} online users</p>
                    </div>
                </div>
                <!-- end widget-chat-header -->
                <!-- begin widget-chat-body -->
                <div class="widget-chat-body" data-scrollbar="true" data-height="300px" data-start="bottom" scroll-glue="glued">
                    <div class="widget-chat-item with-media left" ng-repeat="message in messages">
                        <div class="widget-chat-media" style="border: 1px solid #999;">
                            <a href="/messages/{{message.u | lowercase}}" target="_blank">
                                <img alt="{{::message.u}}" ng-src="{{::message.image | https}}" style="height: 36px; width: 36px;"/>
                            </a>
                        </div>
                        <div class="widget-chat-info">
                            <div class="widget-chat-info-container">
                            <a class="widget-chat-name" ng-click="::reply(message.u)" style="cursor: pointer; font-weight: bold; text-decoration: none;">@{{::message.u}}</a>
                            <a ng-if="::message.admin" style="cursor: pointer; text-decoration: none;" title="Admin"><small><span class="label label-inverse"><b>ADMIN</b></span></small></a>
                            <a ng-if="::message.moderator" style="cursor: pointer; text-decoration: none;" title="Moderator"><small><span class="label label-inverse"><b>MOD</b></span></small></a>
                            <a ng-if="::message.symbol" ng-click="::goToChart(message.symbol)" style="cursor: pointer; text-decoration: none;"><small><span class="label label-primary"><b>{{::message.symbol}}</b></span></small></a>
                            <a class="pull-right text-inverse" href="/messages/{{message.u | lowercase}}" target="_blank" title="Send {{message.u | lowercase}} a private message"><small><i class="fa fa-envelope"></i></small></a>
                                <div class="widget-chat-message" style="width: 191px; overflow: hidden; white-space: normal; text-overflow: initial;">
                                    <span ng-bind-html="::message.m | embed:{linkTarget:'_blank'} | nl2br | stringHashtagsAndMention"></span>
                                    <div ng-if="::message.attached">
                                        <a data-fancybox="chat" data-caption="{{::message.m | embed:{linkTarget:'_blank'} | nl2br | stringHashtagsAndMention}}" href="{{::message.attached}}"><img ng-src="{{::message.attached}}" class="img-responsive"></a>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <a ng-if="message.admin != true && message.moderator != true" class="text-danger" ng-click="::block(message.u)" style="cursor: pointer; text-decoration: none;"><small>block</small></a>
                                    <a ng-if="admin && message.admin != true && message.moderator != true" class="text-danger" ng-click="::ban(message.id, message.u)" style="cursor: pointer; text-decoration: none;"><small> | ban</small></a><br/>
                                </div>
                                <div class="widget-chat-time">{{message.t | timeAgo}}</div> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget-chat-body -->
                <!-- begin widget-input -->
                <div class="widget-input widget-input-rounded">
                    <form name="messageForm" ng-submit="send(messageForm);">
                        <div class="widget-input-container">
                            <div class="widget-input-icon">
                                <a href="javascript:void(0);" ng-click="upload(messageForm)" class="text-primary"><i class="fa fa-camera"></i></a>
                            </div>
                            <div class="widget-input-box">
                                <textarea id="m" ng-model="messageForm.content" class="form-control form-control-sm" placeholder="Type a message..." ng-keypress="keypress($event, messageForm)" ng-disabled="messageForm.disabled" style="min-height: 30px; height: 30px; padding: 5px 10px; border-radius: 3px; line-height: 1.5; font-size: 12px; resize: vertical;"/></textarea>
                            </div>
                            <div class="widget-input-icon">
                                <a href="javascript:void(0);" ng-click="send(messageForm);" class="text-primary"><i class="fa fa-paper-plane"></i></a>
                            </div>
                        </div>
                        <div class="text-center" style="margin-bottom: 10px;">
                            <small>
                                Add <b style="color: #007bff;">$</b> in mentioning stock symbols. ex. <a href="javascript:void(0);" onclick="goToChart('PSEI')" style="font-weight: bold;">$PSEI</a><br/>
                                <a href="/messages/kaiser018" target="_blank" style="font-weight: bold;">Click here</a> for questions, feedbacks, and suggestions.<br/>
                            </small>
                        </div>
                    </form>
                </div>
                <!-- end widget-input -->
            </div>
            <!-- end widget-chat -->
        </div>
    </div>
</div>		
<div class="modal modal-special fade" id="calculator-modal" data-backdrop="false" data-keyboard="false" ng-controller="calculator">
    <div class="modal-dialog modal-sm" style="margin: 0; width: 300px; height: 521px;">
        <div class="modal-content">
            <div class="widget-chat widget-chat-rounded" style="border: 1px solid #ccc;">
                <!-- begin widget-chat-header -->
                <div class="widget-chat-header" style="cursor: move;">
                    <div class="widget-chat-header-icon">
                        <i class="fa fa-calculator width-30 height-30 f-s-20 bg-grey text-inverse text-center rounded-corner" style="line-height: 30px"></i>
                    </div>
                    <div class="widget-chat-header-content">
                        <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="widget-chat-header-title">Calculator</h4>
                        <p class="widget-chat-header-desc">Profit / Loss Calculator</p>
                    </div>
                </div>
                <!-- end widget-chat-header -->
                <div class="widget-chat-body">
                    <div class="form-group">
                        <label class="control-label">No. of Shares</label>
                        <input type="number" class="form-control form-control-sm" placeholder="No. of Shares" ng-model="calculatorNoOfShares" min="0.00" step="any"/>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="control-label">Buy Price</label>
                                <input type="number" class="form-control form-control-sm" ng-model="calculatorBuyPrice" placeholder="Buy Price" min="0.00" step="any"/>
                                <div class="help-block" style="margin-bottom: 0;">
                                    <strong>Value: </strong><span class="pull-right">{{calculatorBuyValue = calculatorNoOfShares * calculatorBuyPrice | numeraljs: '0,0.00'}}</span><br/>
                                    <strong>Fees: </strong><span class="pull-right">{{calculatorBuyFee = computeBuyFee(calculatorBuyValue) | numeraljs: '0,0.00'}}</span><br/>
                                    <strong>Total: </strong><strong class="pull-right">{{calculatorBuyTotal = calculatorBuyValue + calculatorBuyFee | numeraljs: '0,0.00'}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="control-label">Sell Price</label>
                                <input type="number" class="form-control form-control-sm" ng-model="calculatorSellPrice" placeholder="Sell Price" min="0.00" step="any"/>
                                <div class="help-block" style="margin-bottom: 0;">
                                    <strong>Value: </strong><span class="pull-right">{{calculatorSellValue = calculatorNoOfShares * calculatorSellPrice | numeraljs: '0,0.00'}}</span><br/>
                                    <strong>Fees: </strong><span class="pull-right">{{calculatorSellFee = computeSellFee(calculatorSellValue) | numeraljs: '0,0.00'}}</span><br/>
                                    <strong>Total: </strong><strong class="pull-right">{{calculatorSellTotal = calculatorSellValue - calculatorSellFee | numeraljs: '0,0.00'}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin: 10px 0;">
                        <strong>Profit / Loss: </strong>
                        <strong class="pull-right" ng-class="{'text-success': calculatorProfit > 0, 'text-danger': calculatorProfit < 0, 'text-warning': calculatorProfit == 0}">({{calculatorSellTotal == 0 ? 0 : (calculatorProfit / calculatorBuyTotal) | numeraljs: '0,0.00%'}}) {{calculatorProfit = calculatorSellTotal - calculatorBuyTotal | numeraljs: '0,0.00'}}</strong>
                    </div>
                    <table class="table table-condensed" style="margin-bottom: 0;">
                        <tr>
                            <th>Sell Price</th>
                            <th class="text-right">% Profit / Loss</th>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(10, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-success"><b>10.00%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(7.5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-success"><b>7.50%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-success"><b>5.00%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(2.5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-success"><b>2.50%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(0, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-warning"><b>0.00%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(-2.5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-danger"><b>-2.50%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(-5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-danger"><b>-5.00%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(-7.5, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-danger"><b>-7.50%</b></td>
                        </tr>
                        <tr>
                            <td align=""><b>{{sellAt(-10, calculatorNoOfShares, calculatorBuyPrice, calculatorBuyTotal) | price}}</b></td>
                            <td align="right" class="text-danger"><b>-10.00%</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>		
	</div>
    
    <div class="arbmobilebtns">
    	<ul>
        	<li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
	<!-- end page container -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
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
        var socket = io.connect('https://websocket2.pse.tools', {transports:['websocket'], upgrade:false});
        socket.on('reconnect', function() {
            console.log('reconnected to websocket');
        });
        socket.on('disconnect', function() {
        	console.log('You have been disconnected!');
        });
		$(document).ready(function() {
			App.init();
		    $( function () {
		        $(".stocks-select2").select2({placeholder:"Stock", width: '100%'})
		    });
		});
		var _stocks = {"2GO":{"symbol":"2GO","description":"2GO GROUP, INC.","type":"Common","wikhi52":"23.7500","wiklo52":"9.5000","pricescale":"100","last":"11.2800","display_name":"$2GO - 2GO GROUP, INC."},"8990P":{"symbol":"8990P","description":"8990 HOLDINGS, INC. SERIES A PERPETUAL PREFER","type":"Preferred","wikhi52":"102.4000","wiklo52":"93.0000","pricescale":"100","last":"96.0500","display_name":"$8990P - 8990 HOLDINGS, INC. SERIES A PERPETUAL PREFER"},"AAA":{"symbol":"AAA","description":"ASIA AMALGAMATED HOLDINGS","type":"Common","wikhi52":"2.2500","wiklo52":"1.2100","pricescale":"100","last":"1.6100","display_name":"$AAA - ASIA AMALGAMATED HOLDINGS"},"AB":{"symbol":"AB","description":"ATOK-BIG WEDGE COMPANY, INC. \"A\"","type":"Common","wikhi52":"43.0000","wiklo52":"12.0000","pricescale":"100","last":"15.0600","display_name":"$AB - ATOK-BIG WEDGE COMPANY, INC. \"A\""},"ABA":{"symbol":"ABA","description":"ABACORE CAPITAL HOLDINGS, INC.","type":"Common","wikhi52":"0.4800","wiklo52":"0.2000","pricescale":"1000","last":"0.4800","display_name":"$ABA - ABACORE CAPITAL HOLDINGS, INC."},"ABC":{"symbol":"ABC","description":"ALLIED BANKING CORPORATION - 15% CUM. CONVERT","type":"Preferred","wikhi52":"850.0000","wiklo52":"850.0000","pricescale":"1","last":"1000.0000","display_name":"$ABC - ALLIED BANKING CORPORATION - 15% CUM. CONVERT"},"ABG":{"symbol":"ABG","description":"ASIABEST GROUP INTERNATIONAL INC.","type":"Common","wikhi52":"46.0000","wiklo52":"15.7000","pricescale":"100","last":"26.4000","display_name":"$ABG - ASIABEST GROUP INTERNATIONAL INC."},"ABS":{"symbol":"ABS","description":"ABS-CBN CORPORATION","type":"Common","wikhi52":"39.5000","wiklo52":"20.0000","pricescale":"100","last":"21.3000","display_name":"$ABS - ABS-CBN CORPORATION"},"ABSP":{"symbol":"ABSP","description":"ABS-CBN HOLDINGS CORPORATION - PHIL. DEPOSIT ","type":"Philippine Deposit Receipts","wikhi52":"39.9500","wiklo52":"18.7000","pricescale":"100","last":"21.0000","display_name":"$ABSP - ABS-CBN HOLDINGS CORPORATION - PHIL. DEPOSIT "},"AC":{"symbol":"AC","description":"AYALA CORPORATION","type":"Common","wikhi52":"1116.0000","wiklo52":"867.5000","pricescale":"100","last":"910.0000","display_name":"$AC - AYALA CORPORATION"},"ACE":{"symbol":"ACE","description":"ACESITE (PHILIPPINES) HOTEL CORPORATION","type":"Common","wikhi52":"1.7500","wiklo52":"1.2200","pricescale":"100","last":"1.3700","display_name":"$ACE - ACESITE (PHILIPPINES) HOTEL CORPORATION"},"ACPA":{"symbol":"ACPA","description":"AYALA CORPORATION PREFERRED CLASS \"A\" SHARES","type":"Preferred","wikhi52":"540.0000","wiklo52":"489.0000","pricescale":"100","last":"500.0000","display_name":"$ACPA - AYALA CORPORATION PREFERRED CLASS \"A\" SHARES"},"ACPB1":{"symbol":"ACPB1","description":"AYALA CORPORATION PREFERRED CLASS \"B\" SHARES","type":"Preferred","wikhi52":"550.0000","wiklo52":"460.0000","pricescale":"100","last":"460.0000","display_name":"$ACPB1 - AYALA CORPORATION PREFERRED CLASS \"B\" SHARES"},"ACPB2":{"symbol":"ACPB2","description":"AYALA CORPORATION CLASS \"B\" SERIES 2 PREFERRE","type":"Preferred","wikhi52":"540.0000","wiklo52":"489.0000","pricescale":"100","last":"495.0000","display_name":"$ACPB2 - AYALA CORPORATION CLASS \"B\" SERIES 2 PREFERRE"},"ACR":{"symbol":"ACR","description":"ALSONS CONSOLIDATED RESOURCES, INC.","type":"Common","wikhi52":"1.4300","wiklo52":"1.0800","pricescale":"100","last":"1.3000","display_name":"$ACR - ALSONS CONSOLIDATED RESOURCES, INC."},"AEV":{"symbol":"AEV","description":"ABOITIZ EQUITY VENTURES, INC.","type":"Common","wikhi52":"79.0000","wiklo52":"44.1000","pricescale":"100","last":"47.8000","display_name":"$AEV - ABOITIZ EQUITY VENTURES, INC."},"AGI":{"symbol":"AGI","description":"ALLIANCE GLOBAL GROUP, INC.","type":"Common","wikhi52":"16.5000","wiklo52":"11.4000","pricescale":"100","last":"11.9000","display_name":"$AGI - ALLIANCE GLOBAL GROUP, INC."},"ALCO":{"symbol":"ALCO","description":"ARTHALAND CORPORATION","type":"Common","wikhi52":"1.0800","wiklo52":"0.5600","pricescale":"100","last":"0.6400","display_name":"$ALCO - ARTHALAND CORPORATION"},"ALCPB":{"symbol":"ALCPB","description":"ARTHALAND CORPORATION SERIES \"B\" PERPETUAL PR","type":"Preferred","wikhi52":"109.0000","wiklo52":"98.0000","pricescale":"100","last":"100.3000","display_name":"$ALCPB - ARTHALAND CORPORATION SERIES \"B\" PERPETUAL PR"},"ALHI":{"symbol":"ALHI","description":"ANCHOR LAND HOLDINGS, INC.","type":"Common","wikhi52":"29.2500","wiklo52":"8.0100","pricescale":"100","last":"11.0000","display_name":"$ALHI - ANCHOR LAND HOLDINGS, INC."},"ALI":{"symbol":"ALI","description":"AYALA LAND, INC.","type":"Common","wikhi52":"47.5000","wiklo52":"36.0500","pricescale":"100","last":"40.9000","display_name":"$ALI - AYALA LAND, INC."},"ALL":{"symbol":"ALL","description":"All Shares","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$ALL - All Shares"},"ANI":{"symbol":"ANI","description":"AGRINURTURE, INC.","type":"Common","wikhi52":"18.3200","wiklo52":"9.4400","pricescale":"100","last":"18.1000","display_name":"$ANI - AGRINURTURE, INC."},"ANS":{"symbol":"ANS","description":"A. SORIANO CORPORATION","type":"Common","wikhi52":"7.9000","wiklo52":"5.9500","pricescale":"100","last":"6.1500","display_name":"$ANS - A. SORIANO CORPORATION"},"AP":{"symbol":"AP","description":"ABOITIZ POWER CORP.","type":"Common","wikhi52":"42.7500","wiklo52":"31.8000","pricescale":"100","last":"35.1500","display_name":"$AP - ABOITIZ POWER CORP."},"APC":{"symbol":"APC","description":"APC GROUP, INC.","type":"Common","wikhi52":"0.9100","wiklo52":"0.4200","pricescale":"1000","last":"0.4350","display_name":"$APC - APC GROUP, INC."},"APL":{"symbol":"APL","description":"APOLLO GLOBAL CAPITAL, INC.","type":"Common","wikhi52":"0.0720","wiklo52":"0.0370","pricescale":"10000","last":"0.0410","display_name":"$APL - APOLLO GLOBAL CAPITAL, INC."},"APO":{"symbol":"APO","description":"ANGLO PHILIPPINE HOLDINGS CORPORATION","type":"Common","wikhi52":"1.1800","wiklo52":"0.8000","pricescale":"100","last":"0.8800","display_name":"$APO - ANGLO PHILIPPINE HOLDINGS CORPORATION"},"APX":{"symbol":"APX","description":"APEX MINING COMPANY, INC. \"A\"","type":"Common","wikhi52":"2.0800","wiklo52":"1.4000","pricescale":"100","last":"1.5900","display_name":"$APX - APEX MINING COMPANY, INC. \"A\""},"AR":{"symbol":"AR","description":"ABRA MINING & INDUSTRIAL CORPORATION","type":"Common","wikhi52":"0.0038","wiklo52":"0.0021","pricescale":"10000","last":"0.0023","display_name":"$AR - ABRA MINING & INDUSTRIAL CORPORATION"},"ARA":{"symbol":"ARA","description":"ARANETA PROPERTIES, INC.","type":"Common","wikhi52":"2.6100","wiklo52":"1.8100","pricescale":"100","last":"1.9400","display_name":"$ARA - ARANETA PROPERTIES, INC."},"AT":{"symbol":"AT","description":"ATLAS CONSOLIDATED MINING & DEVELOPMENT CORPO","type":"Common","wikhi52":"5.2100","wiklo52":"2.6000","pricescale":"100","last":"2.6100","display_name":"$AT - ATLAS CONSOLIDATED MINING & DEVELOPMENT CORPO"},"ATI":{"symbol":"ATI","description":"ASIAN TERMINALS, INC.","type":"Common","wikhi52":"16.9800","wiklo52":"10.9600","pricescale":"100","last":"13.4800","display_name":"$ATI - ASIAN TERMINALS, INC."},"ATN":{"symbol":"ATN","description":"ATN HOLDINGS, INC. \"A\"","type":"Common","wikhi52":"1.6900","wiklo52":"0.3500","pricescale":"100","last":"1.1700","display_name":"$ATN - ATN HOLDINGS, INC. \"A\""},"ATNB":{"symbol":"ATNB","description":"ATN HOLDINGS, INC. \"B\"","type":"Common","wikhi52":"1.7000","wiklo52":"0.3100","pricescale":"100","last":"1.1900","display_name":"$ATNB - ATN HOLDINGS, INC. \"B\""},"AUB":{"symbol":"AUB","description":"ASIA UNITED BANK CORPORATION","type":"Common","wikhi52":"60.1000","wiklo52":"55.2000","pricescale":"100","last":"59.4500","display_name":"$AUB - ASIA UNITED BANK CORPORATION"},"BC":{"symbol":"BC","description":"BENGUET CORPORATION \"A\"","type":"Common","wikhi52":"2.0000","wiklo52":"0.9700","pricescale":"100","last":"1.2200","display_name":"$BC - BENGUET CORPORATION \"A\""},"BCB":{"symbol":"BCB","description":"BENGUET CORPORATION \"B\"","type":"Common","wikhi52":"2.1800","wiklo52":"0.8700","pricescale":"100","last":"1.4900","display_name":"$BCB - BENGUET CORPORATION \"B\""},"BCOR":{"symbol":"BCOR","description":"BERJAYA PHILIPPINES, INC.","type":"Common","wikhi52":"12.8200","wiklo52":"1.4600","pricescale":"100","last":"1.6900","display_name":"$BCOR - BERJAYA PHILIPPINES, INC."},"BCP":{"symbol":"BCP","description":"BENGUET CORPORATION - 8% CUMULATIVE CONVERTIB","type":"Preferred","wikhi52":"44.5500","wiklo52":"12.0200","pricescale":"100","last":"12.0200","display_name":"$BCP - BENGUET CORPORATION - 8% CUMULATIVE CONVERTIB"},"BDO":{"symbol":"BDO","description":"BDO UNIBANK, INC.","type":"Common","wikhi52":"167.7000","wiklo52":"106.6000","pricescale":"100","last":"119.8000","display_name":"$BDO - BDO UNIBANK, INC."},"BEL":{"symbol":"BEL","description":"BELLE CORPORATION","type":"Common","wikhi52":"4.1000","wiklo52":"2.3000","pricescale":"100","last":"2.3800","display_name":"$BEL - BELLE CORPORATION"},"BH":{"symbol":"BH","description":"BHI HOLDINGS, INC.","type":"Common","wikhi52":"2990.0000","wiklo52":"1051.0000","pricescale":"1","last":"1400.0000","display_name":"$BH - BHI HOLDINGS, INC."},"BHI":{"symbol":"BHI","description":"BOULEVARD HOLDINGS, INC.","type":"Common","wikhi52":"0.0820","wiklo52":"0.0520","pricescale":"10000","last":"0.0560","display_name":"$BHI - BOULEVARD HOLDINGS, INC."},"BKR":{"symbol":"BKR","description":"BRIGHT KINDLE RESOURCES & INVESTMENTS INC.","type":"Common","wikhi52":"2.6000","wiklo52":"1.2700","pricescale":"100","last":"1.4400","display_name":"$BKR - BRIGHT KINDLE RESOURCES & INVESTMENTS INC."},"BLFI":{"symbol":"BLFI","description":"BDO LEASING & FINANCE, INC.","type":"Common","wikhi52":"4.3600","wiklo52":"2.1900","pricescale":"100","last":"2.2700","display_name":"$BLFI - BDO LEASING & FINANCE, INC."},"BLOOM":{"symbol":"BLOOM","description":"BLOOMBERRY RESORTS CORPORATION","type":"Common","wikhi52":"14.8600","wiklo52":"7.8400","pricescale":"100","last":"8.7400","display_name":"$BLOOM - BLOOMBERRY RESORTS CORPORATION"},"BMM":{"symbol":"BMM","description":"BOGO-MEDELLIN MILLING COMPANY","type":"Common","wikhi52":"265.0000","wiklo52":"90.1500","pricescale":"100","last":"100.0000","display_name":"$BMM - BOGO-MEDELLIN MILLING COMPANY"},"BPI":{"symbol":"BPI","description":"BANK OF THE PHILIPPINE ISLANDS","type":"Common","wikhi52":"125.4500","wiklo52":"78.9000","pricescale":"100","last":"82.9500","display_name":"$BPI - BANK OF THE PHILIPPINE ISLANDS"},"BRN":{"symbol":"BRN","description":"A. BROWN COMPANY, INC.","type":"Common","wikhi52":"1.2800","wiklo52":"0.6900","pricescale":"100","last":"0.7800","display_name":"$BRN - A. BROWN COMPANY, INC."},"BSC":{"symbol":"BSC","description":"BASIC ENERGY CORPORATION","type":"Common","wikhi52":"0.3150","wiklo52":"0.2030","pricescale":"1000","last":"0.2180","display_name":"$BSC - BASIC ENERGY CORPORATION"},"CA":{"symbol":"CA","description":"CONCRETE AGGREGATES CORPORATION \"A\"","type":"Common","wikhi52":"105.0000","wiklo52":"53.0000","pricescale":"100","last":"66.9500","display_name":"$CA - CONCRETE AGGREGATES CORPORATION \"A\""},"CAB":{"symbol":"CAB","description":"CONCRETE AGGREGATES CORPORATION \"B\"","type":"Common","wikhi52":"168.0000","wiklo52":"76.0500","pricescale":"100","last":"80.2500","display_name":"$CAB - CONCRETE AGGREGATES CORPORATION \"B\""},"CAT":{"symbol":"CAT","description":"CENTRAL AZUCARERA DE TARLAC","type":"Common","wikhi52":"51.2000","wiklo52":"16.1000","pricescale":"100","last":"16.8000","display_name":"$CAT - CENTRAL AZUCARERA DE TARLAC"},"CDC":{"symbol":"CDC","description":"CITYLAND DEVELOPMENT CORPORATION","type":"Common","wikhi52":"1.2700","wiklo52":"0.8500","pricescale":"100","last":"0.9200","display_name":"$CDC - CITYLAND DEVELOPMENT CORPORATION"},"CEB":{"symbol":"CEB","description":"CEBU AIR, INC.","type":"Common","wikhi52":"113.4000","wiklo52":"64.5000","pricescale":"100","last":"64.5000","display_name":"$CEB - CEBU AIR, INC."},"CEI":{"symbol":"CEI","description":"CROWN EQUITIES, INC.","type":"Common","wikhi52":"0.3850","wiklo52":"0.1980","pricescale":"1000","last":"0.2100","display_name":"$CEI - CROWN EQUITIES, INC."},"CEU":{"symbol":"CEU","description":"CENTRO ESCOLAR UNIVERSITY","type":"Common","wikhi52":"9.3800","wiklo52":"6.1400","pricescale":"100","last":"7.8000","display_name":"$CEU - CENTRO ESCOLAR UNIVERSITY"},"CHI":{"symbol":"CHI","description":"CEBU HOLDINGS, INC.","type":"Common","wikhi52":"8.9000","wiklo52":"5.0500","pricescale":"100","last":"5.3500","display_name":"$CHI - CEBU HOLDINGS, INC."},"CHIB":{"symbol":"CHIB","description":"CHINA BANKING CORPORATION","type":"Common","wikhi52":"37.5000","wiklo52":"28.1000","pricescale":"100","last":"28.5000","display_name":"$CHIB - CHINA BANKING CORPORATION"},"CHP":{"symbol":"CHP","description":"CEMEX HOLDINGS PHILIPPINES, INC.","type":"Common","wikhi52":"5.5300","wiklo52":"1.8900","pricescale":"100","last":"2.2200","display_name":"$CHP - CEMEX HOLDINGS PHILIPPINES, INC."},"CIC":{"symbol":"CIC","description":"CONCEPCION INDUSTRIAL CORPORATION","type":"Common","wikhi52":"67.5000","wiklo52":"34.0000","pricescale":"100","last":"39.4500","display_name":"$CIC - CONCEPCION INDUSTRIAL CORPORATION"},"CIP":{"symbol":"CIP","description":"CHEMICAL INDUSTRIES OF THE PHILIPPINES","type":"Common","wikhi52":"460.0000","wiklo52":"151.1000","pricescale":"100","last":"190.0000","display_name":"$CIP - CHEMICAL INDUSTRIES OF THE PHILIPPINES"},"CLC":{"symbol":"CLC","description":"CHELSEA LOGISTICS HOLDINGS CORP.","type":"Common","wikhi52":"10.3600","wiklo52":"4.4000","pricescale":"100","last":"5.6700","display_name":"$CLC - CHELSEA LOGISTICS HOLDINGS CORP."},"CLI":{"symbol":"CLI","description":"CEBU LANDMASTERS, INC.","type":"Common","wikhi52":"5.1400","wiklo52":"4.2100","pricescale":"100","last":"4.3900","display_name":"$CLI - CEBU LANDMASTERS, INC."},"CNPF":{"symbol":"CNPF","description":"CENTURY PACIFIC FOOD, INC.","type":"Common","wikhi52":"17.8000","wiklo52":"12.9000","pricescale":"100","last":"13.4800","display_name":"$CNPF - CENTURY PACIFIC FOOD, INC."},"COAL":{"symbol":"COAL","description":"COAL ASIA HOLDINGS INC.","type":"Common","wikhi52":"0.3900","wiklo52":"0.2900","pricescale":"1000","last":"0.3050","display_name":"$COAL - COAL ASIA HOLDINGS INC."},"COL":{"symbol":"COL","description":"COL FINANCIAL GROUP, INC.","type":"Common","wikhi52":"16.8200","wiklo52":"15.0000","pricescale":"100","last":"15.7000","display_name":"$COL - COL FINANCIAL GROUP, INC."},"COSCO":{"symbol":"COSCO","description":"COSCO CAPITAL, INC.","type":"Common","wikhi52":"8.5600","wiklo52":"5.6000","pricescale":"100","last":"6.7000","display_name":"$COSCO - COSCO CAPITAL, INC."},"CPG":{"symbol":"CPG","description":"CENTURY PROPERTIES GROUP INC.","type":"Common","wikhi52":"0.5300","wiklo52":"0.3950","pricescale":"1000","last":"0.4200","display_name":"$CPG - CENTURY PROPERTIES GROUP INC."},"CPM":{"symbol":"CPM","description":"CENTURY PEAK METALS HOLDINGS CORPORATION","type":"Common","wikhi52":"2.0900","wiklo52":"1.5100","pricescale":"100","last":"1.9000","display_name":"$CPM - CENTURY PEAK METALS HOLDINGS CORPORATION"},"CPV":{"symbol":"CPV","description":"CEBU PROPERTY VENTURE & DEVELOPMENT \"A\"","type":"Common","wikhi52":"9.1500","wiklo52":"5.5200","pricescale":"100","last":"6.5000","display_name":"$CPV - CEBU PROPERTY VENTURE & DEVELOPMENT \"A\""},"CPVB":{"symbol":"CPVB","description":"CEBU PROPERTY VENTURE & DEVELOPMENT \"B\"","type":"Common","wikhi52":"9.0000","wiklo52":"5.5200","pricescale":"100","last":"6.5000","display_name":"$CPVB - CEBU PROPERTY VENTURE & DEVELOPMENT \"B\""},"CROWN":{"symbol":"CROWN","description":"CROWN ASIA CHEMICALS CORPORATION","type":"Common","wikhi52":"2.2100","wiklo52":"1.6000","pricescale":"100","last":"1.6000","display_name":"$CROWN - CROWN ASIA CHEMICALS CORPORATION"},"CSB":{"symbol":"CSB","description":"CITYSTATE SAVINGS BANK, INC.","type":"Common","wikhi52":"10.0000","wiklo52":"3.5000","pricescale":"100","last":"6.8700","display_name":"$CSB - CITYSTATE SAVINGS BANK, INC."},"CYBR":{"symbol":"CYBR","description":"CYBER BAY CORPORATION","type":"Common","wikhi52":"0.5300","wiklo52":"0.3650","pricescale":"1000","last":"0.3900","display_name":"$CYBR - CYBER BAY CORPORATION"},"DAVIN":{"symbol":"DAVIN","description":"DA VINCI CAPITAL HOLDINGS, INC.","type":"Common","wikhi52":"7.3000","wiklo52":"4.0000","pricescale":"100","last":"4.5000","display_name":"$DAVIN - DA VINCI CAPITAL HOLDINGS, INC."},"DD":{"symbol":"DD","description":"DOUBLEDRAGON PROPERTIES CORP.","type":"Common","wikhi52":"43.0000","wiklo52":"17.8400","pricescale":"100","last":"20.1500","display_name":"$DD - DOUBLEDRAGON PROPERTIES CORP."},"DDPR":{"symbol":"DDPR","description":"DOUBLEDRAGON PROPERTIES CORP. PERPETUAL PREFE","type":"Preferred","wikhi52":"107.5000","wiklo52":"97.7000","pricescale":"100","last":"97.7000","display_name":"$DDPR - DOUBLEDRAGON PROPERTIES CORP. PERPETUAL PREFE"},"DELM":{"symbol":"DELM","description":"DEL MONTE PACIFIC LIMITED","type":"Common","wikhi52":"12.5000","wiklo52":"6.5500","pricescale":"100","last":"7.0000","display_name":"$DELM - DEL MONTE PACIFIC LIMITED"},"DFNN":{"symbol":"DFNN","description":"DFNN, INC.","type":"Common","wikhi52":"10.0000","wiklo52":"6.5000","pricescale":"100","last":"8.0000","display_name":"$DFNN - DFNN, INC."},"DIZ":{"symbol":"DIZ","description":"DIZON COPPER SILVER MINES, INC.","type":"Common","wikhi52":"8.8000","wiklo52":"6.8000","pricescale":"100","last":"7.2800","display_name":"$DIZ - DIZON COPPER SILVER MINES, INC."},"DMC":{"symbol":"DMC","description":"DMCI HOLDINGS, INC.","type":"Common","wikhi52":"15.9400","wiklo52":"9.8200","pricescale":"100","last":"12.3400","display_name":"$DMC - DMCI HOLDINGS, INC."},"DMCP":{"symbol":"DMCP","description":"DMCI HOLDINGS, INC. - CUMULATIVE CONVERTIBLE ","type":"Preferred","wikhi52":"1400.0000","wiklo52":"1400.0000","pricescale":"1","last":"1400.0000","display_name":"$DMCP - DMCI HOLDINGS, INC. - CUMULATIVE CONVERTIBLE "},"DMPA1":{"symbol":"DMPA1","description":"DEL MONTE PACIFIC LIMITED U.S. DOLLAR DENOMIN","type":"Preferred","wikhi52":"10.9000","wiklo52":"10.0000","pricescale":"100","last":"10.0000","display_name":"$DMPA1 - DEL MONTE PACIFIC LIMITED U.S. DOLLAR DENOMIN"},"DMPA2":{"symbol":"DMPA2","description":"DEL MONTE PACIFIC LIMITED U.S. DOLLAR DENOMIN","type":"Preferred","wikhi52":"10.6000","wiklo52":"9.7000","pricescale":"100","last":"10.0000","display_name":"$DMPA2 - DEL MONTE PACIFIC LIMITED U.S. DOLLAR DENOMIN"},"DMW":{"symbol":"DMW","description":"D.M. WENCESLAO & ASSOCIATES, INCORPORATED","type":"Common","wikhi52":"11.8000","wiklo52":"7.5200","pricescale":"100","last":"7.9900","display_name":"$DMW - D.M. WENCESLAO & ASSOCIATES, INCORPORATED"},"DNA":{"symbol":"DNA","description":"PHILAB HOLDINGS CORP.","type":"Common","wikhi52":"6.6500","wiklo52":"2.8000","pricescale":"100","last":"2.8600","display_name":"$DNA - PHILAB HOLDINGS CORP."},"DNL":{"symbol":"DNL","description":"D&L INDUSTRIES, INC.","type":"Common","wikhi52":"12.7600","wiklo52":"9.5500","pricescale":"100","last":"10.8000","display_name":"$DNL - D&L INDUSTRIES, INC."},"DTEL":{"symbol":"DTEL","description":"PLDT INC.","type":"Common Dollar","wikhi52":"10.2500","wiklo52":"10.2500","pricescale":"100","last":"10.2600","display_name":"$DTEL - PLDT INC."},"DWC":{"symbol":"DWC","description":"DISCOVERY WORLD CORPORATION","type":"Common","wikhi52":"4.2000","wiklo52":"2.0000","pricescale":"100","last":"2.1900","display_name":"$DWC - DISCOVERY WORLD CORPORATION"},"EAGLE":{"symbol":"EAGLE","description":"EAGLE CEMENT CORPORATION","type":"Common","wikhi52":"16.6800","wiklo52":"13.8200","pricescale":"100","last":"14.7600","display_name":"$EAGLE - EAGLE CEMENT CORPORATION"},"ECP":{"symbol":"ECP","description":"EASYCALL COMMUNICATIONS PHILS., INC.","type":"Common","wikhi52":"76.5000","wiklo52":"3.1200","pricescale":"100","last":"14.1200","display_name":"$ECP - EASYCALL COMMUNICATIONS PHILS., INC."},"EDC":{"symbol":"EDC","description":"ENERGY DEVELOPMENT CORPORATION","type":"Common","wikhi52":"7.2900","wiklo52":"4.9200","pricescale":"100","last":"7.2700","display_name":"$EDC - ENERGY DEVELOPMENT CORPORATION"},"EEI":{"symbol":"EEI","description":"EEI CORPORATION","type":"Common","wikhi52":"13.6200","wiklo52":"7.7500","pricescale":"100","last":"8.0000","display_name":"$EEI - EEI CORPORATION"},"EG":{"symbol":"EG","description":"IP E-GAME VENTURES, INC.","type":"Common","wikhi52":"0.0160","wiklo52":"0.0086","pricescale":"10000","last":"0.0094","display_name":"$EG - IP E-GAME VENTURES, INC."},"EIBA":{"symbol":"EIBA","description":"EXPORT AND INDUSTRY BANK, INC.","type":"Common","wikhi52":"0.2800","wiklo52":"0.1300","pricescale":"1000","last":"0.2600","display_name":"$EIBA - EXPORT AND INDUSTRY BANK, INC."},"EIBB":{"symbol":"EIBB","description":"EXPORT AND INDUSTRY BANK \"B\"","type":"Common","wikhi52":"0.2800","wiklo52":"0.1400","pricescale":"1000","last":"0.2600","display_name":"$EIBB - EXPORT AND INDUSTRY BANK \"B\""},"ELI":{"symbol":"ELI","description":"EMPIRE EAST LAND HOLDINGS, INC.","type":"Common","wikhi52":"0.7500","wiklo52":"0.5300","pricescale":"100","last":"0.5300","display_name":"$ELI - EMPIRE EAST LAND HOLDINGS, INC."},"EMP":{"symbol":"EMP","description":"EMPERADOR INC.","type":"Common","wikhi52":"8.9600","wiklo52":"6.8000","pricescale":"100","last":"7.0000","display_name":"$EMP - EMPERADOR INC."},"EURO":{"symbol":"EURO","description":"EURO-MED LABORATORIES PHILS., INC.","type":"Common","wikhi52":"1.9300","wiklo52":"1.5000","pricescale":"100","last":"1.5000","display_name":"$EURO - EURO-MED LABORATORIES PHILS., INC."},"EVER":{"symbol":"EVER","description":"EVER-GOTESCO RESOURCES & HOLDINGS, INC.","type":"Common","wikhi52":"0.1640","wiklo52":"0.1030","pricescale":"1000","last":"0.1050","display_name":"$EVER - EVER-GOTESCO RESOURCES & HOLDINGS, INC."},"EW":{"symbol":"EW","description":"EAST WEST BANKING CORPORATION","type":"Common","wikhi52":"24.0700","wiklo52":"11.1400","pricescale":"100","last":"11.4000","display_name":"$EW - EAST WEST BANKING CORPORATION"},"FAF":{"symbol":"FAF","description":"FIRST ABACUS FINANCIAL HOLDINGS CORP.","type":"Common","wikhi52":"0.7300","wiklo52":"0.6000","pricescale":"100","last":"0.6000","display_name":"$FAF - FIRST ABACUS FINANCIAL HOLDINGS CORP."},"FB":{"symbol":"FB","description":"SAN MIGUEL FOOD AND BEVERAGE, INC.","type":"Common","wikhi52":"104.0000","wiklo52":"30.6000","pricescale":"100","last":"84.1500","display_name":"$FB - SAN MIGUEL FOOD AND BEVERAGE, INC."},"FBP":{"symbol":"FBP","description":"SAN MIGUEL FOOD AND BEVERAGE, INC. - PREFERRE","type":"Preferred","wikhi52":"1060.0000","wiklo52":"997.0000","pricescale":"1","last":"1011.0000","display_name":"$FBP - SAN MIGUEL FOOD AND BEVERAGE, INC. - PREFERRE"},"FBP2":{"symbol":"FBP2","description":"SAN MIGUEL FOOD AND BEVERAGE, INC. PERPETUAL ","type":"Preferred","wikhi52":"1020.0000","wiklo52":"920.0000","pricescale":"1","last":"1000.0000","display_name":"$FBP2 - SAN MIGUEL FOOD AND BEVERAGE, INC. PERPETUAL "},"FDC":{"symbol":"FDC","description":"FILINVEST DEVELOPMENT CORPORATION","type":"Common","wikhi52":"8.1500","wiklo52":"6.8300","pricescale":"100","last":"7.1000","display_name":"$FDC - FILINVEST DEVELOPMENT CORPORATION"},"FERRO":{"symbol":"FERRO","description":"FERRONOUX HOLDINGS, INC.","type":"Common","wikhi52":"5.1100","wiklo52":"3.0000","pricescale":"100","last":"4.1000","display_name":"$FERRO - FERRONOUX HOLDINGS, INC."},"FEU":{"symbol":"FEU","description":"FAR EASTERN UNIVERSITY, INC.","type":"Common","wikhi52":"1020.0000","wiklo52":"890.0000","pricescale":"100","last":"900.0000","display_name":"$FEU - FAR EASTERN UNIVERSITY, INC."},"FFI":{"symbol":"FFI","description":"FILIPINO FUND, INC.","type":"Common","wikhi52":"14.2400","wiklo52":"7.0000","pricescale":"100","last":"7.8100","display_name":"$FFI - FILIPINO FUND, INC."},"FGEN":{"symbol":"FGEN","description":"FIRST GEN CORPORATION","type":"Common","wikhi52":"18.7200","wiklo52":"14.1000","pricescale":"100","last":"15.9000","display_name":"$FGEN - FIRST GEN CORPORATION"},"FGENF":{"symbol":"FGENF","description":"FIRST GEN CORPORATION- SERIES \"F\" (FGENF)","type":"Preferred","wikhi52":"115.0000","wiklo52":"80.0000","pricescale":"100","last":"102.0000","display_name":"$FGENF - FIRST GEN CORPORATION- SERIES \"F\" (FGENF)"},"FGENG":{"symbol":"FGENG","description":"FIRST GEN CORPORATION (PREFERRED)","type":"Preferred","wikhi52":"118.7000","wiklo52":"90.4000","pricescale":"100","last":"100.8000","display_name":"$FGENG - FIRST GEN CORPORATION (PREFERRED)"},"FIN":{"symbol":"FIN","description":"Financials","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$FIN - Financials"},"FJP":{"symbol":"FJP","description":"F & J PRINCE HOLDINGS CORPORATION \"A\"","type":"Common","wikhi52":"8.6100","wiklo52":"4.0100","pricescale":"100","last":"5.6300","display_name":"$FJP - F & J PRINCE HOLDINGS CORPORATION \"A\""},"FJPB":{"symbol":"FJPB","description":"F & J PRINCE HOLDINGS CORPORATION \"B\"","type":"Common","wikhi52":"6.3800","wiklo52":"4.5000","pricescale":"100","last":"5.0000","display_name":"$FJPB - F & J PRINCE HOLDINGS CORPORATION \"B\""},"FLI":{"symbol":"FLI","description":"FILINVEST LAND, INC.","type":"Common","wikhi52":"2.0200","wiklo52":"1.4000","pricescale":"100","last":"1.4300","display_name":"$FLI - FILINVEST LAND, INC."},"FMETF":{"symbol":"FMETF","description":"FIRST METRO PHILIPPINE EQUITY EXCHANGE TRADED","type":"Common","wikhi52":"133.2000","wiklo52":"102.6000","pricescale":"100","last":"107.4000","display_name":"$FMETF - FIRST METRO PHILIPPINE EQUITY EXCHANGE TRADED"},"FNI":{"symbol":"FNI","description":"GLOBAL FERRONICKEL HOLDINGS, INC.","type":"Common","wikhi52":"3.1700","wiklo52":"1.7500","pricescale":"100","last":"1.8100","display_name":"$FNI - GLOBAL FERRONICKEL HOLDINGS, INC."},"FOOD":{"symbol":"FOOD","description":"ALLIANCE SELECT FOODS INTERNATIONAL, INC.","type":"Common","wikhi52":"1.3000","wiklo52":"0.5200","pricescale":"100","last":"0.9600","display_name":"$FOOD - ALLIANCE SELECT FOODS INTERNATIONAL, INC."},"FPH":{"symbol":"FPH","description":"FIRST PHILIPPINE HOLDINGS CORPORATION","type":"Common","wikhi52":"69.0000","wiklo52":"60.7500","pricescale":"100","last":"65.0000","display_name":"$FPH - FIRST PHILIPPINE HOLDINGS CORPORATION"},"FPHP":{"symbol":"FPHP","description":"FIRST PHILIPPINE HOLDINGS CORPORATION (PREFER","type":"Preferred","wikhi52":"108.0000","wiklo52":"100.5000","pricescale":"100","last":"101.4000","display_name":"$FPHP - FIRST PHILIPPINE HOLDINGS CORPORATION (PREFER"},"FPHPC":{"symbol":"FPHPC","description":"FIRST PHILIPPINE HOLDINGS CORPORATION SERIES ","type":"Preferred","wikhi52":"518.0000","wiklo52":"451.0000","pricescale":"100","last":"480.0000","display_name":"$FPHPC - FIRST PHILIPPINE HOLDINGS CORPORATION SERIES "},"FPI":{"symbol":"FPI","description":"FORUM PACIFIC, INC.","type":"Common","wikhi52":"0.2700","wiklo52":"0.1800","pricescale":"1000","last":"0.2050","display_name":"$FPI - FORUM PACIFIC, INC."},"FYN":{"symbol":"FYN","description":"FILSYN CORPORATION \"A\"","type":"Common","wikhi52":"3.0000","wiklo52":"3.0000","pricescale":"100","last":"3.0000","display_name":"$FYN - FILSYN CORPORATION \"A\""},"FYNB":{"symbol":"FYNB","description":"FILSYN CORPORATION \"B\"","type":"Common","wikhi52":"10.0000","wiklo52":"10.0000","pricescale":"100","last":"5.0000","display_name":"$FYNB - FILSYN CORPORATION \"B\""},"GEO":{"symbol":"GEO","description":"GEOGRACE RESOURCES PHILIPPINES, INC.","type":"Common","wikhi52":"0.2750","wiklo52":"0.1750","pricescale":"1000","last":"0.2120","display_name":"$GEO - GEOGRACE RESOURCES PHILIPPINES, INC."},"GERI":{"symbol":"GERI","description":"GLOBAL-ESTATE RESORTS, INC.","type":"Common","wikhi52":"1.6300","wiklo52":"0.9600","pricescale":"100","last":"1.0800","display_name":"$GERI - GLOBAL-ESTATE RESORTS, INC."},"GLO":{"symbol":"GLO","description":"GLOBE TELECOM, INC.","type":"Common","wikhi52":"2380.0000","wiklo52":"1475.0000","pricescale":"1","last":"1915.0000","display_name":"$GLO - GLOBE TELECOM, INC."},"GLOPA":{"symbol":"GLOPA","description":"GLOBE TELECOM, INC. - PREFERRED A","type":"Preferred","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"100","last":"5.0000","display_name":"$GLOPA - GLOBE TELECOM, INC. - PREFERRED A"},"GLOPP":{"symbol":"GLOPP","description":"GLOBE TELECOM, INC. SERIES A NON-VOTING PERPE","type":"Preferred","wikhi52":"540.5000","wiklo52":"482.0000","pricescale":"100","last":"482.2000","display_name":"$GLOPP - GLOBE TELECOM, INC. SERIES A NON-VOTING PERPE"},"GMA7":{"symbol":"GMA7","description":"GMA NETWORK, INC. (COMMON)","type":"Common","wikhi52":"6.5500","wiklo52":"4.9900","pricescale":"100","last":"5.1800","display_name":"$GMA7 - GMA NETWORK, INC. (COMMON)"},"GMAP":{"symbol":"GMAP","description":"GMA HOLDINGS, INC. (PDR)","type":"Philippine Deposit Receipts","wikhi52":"6.4000","wiklo52":"4.9300","pricescale":"100","last":"4.9500","display_name":"$GMAP - GMA HOLDINGS, INC. (PDR)"},"GPH":{"symbol":"GPH","description":"GRAND PLAZA HOTEL CORPORATION","type":"Common","wikhi52":"22.7500","wiklo52":"10.1000","pricescale":"100","last":"11.3200","display_name":"$GPH - GRAND PLAZA HOTEL CORPORATION"},"GREEN":{"symbol":"GREEN","description":"GREENERGY HOLDINGS INCORPORATED","type":"Common","wikhi52":"1.2000","wiklo52":"0.3500","pricescale":"1000","last":"0.3700","display_name":"$GREEN - GREENERGY HOLDINGS INCORPORATED"},"GSMI":{"symbol":"GSMI","description":"GINEBRA SAN MIGUEL, INC.","type":"Common","wikhi52":"32.9000","wiklo52":"15.1200","pricescale":"100","last":"25.9000","display_name":"$GSMI - GINEBRA SAN MIGUEL, INC."},"GTCAP":{"symbol":"GTCAP","description":"GT CAPITAL HOLDINGS, INC.","type":"Common","wikhi52":"1400.9700","wiklo52":"660.5000","pricescale":"100","last":"728.5000","display_name":"$GTCAP - GT CAPITAL HOLDINGS, INC."},"GTPPA":{"symbol":"GTPPA","description":"GT CAPITAL HOLDINGS, INC. NON-VOTING PERPETUA","type":"Preferred","wikhi52":"1050.0000","wiklo52":"832.0000","pricescale":"100","last":"886.5000","display_name":"$GTPPA - GT CAPITAL HOLDINGS, INC. NON-VOTING PERPETUA"},"GTPPB":{"symbol":"GTPPB","description":"GT CAPITAL HOLDINGS, INC. NON-VOTING PERPETUA","type":"Preferred","wikhi52":"1045.0000","wiklo52":"881.5000","pricescale":"100","last":"881.5000","display_name":"$GTPPB - GT CAPITAL HOLDINGS, INC. NON-VOTING PERPETUA"},"H2O":{"symbol":"H2O","description":"PHILIPPINE H2O VENTURES CORP.","type":"Common","wikhi52":"10.8000","wiklo52":"4.1000","pricescale":"100","last":"4.9700","display_name":"$H2O - PHILIPPINE H2O VENTURES CORP."},"HDG":{"symbol":"HDG","description":"Holding Firms","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$HDG - Holding Firms"},"HI":{"symbol":"HI","description":"HOUSE OF INVESTMENTS, INC.","type":"Common","wikhi52":"9.0000","wiklo52":"5.7000","pricescale":"100","last":"5.9500","display_name":"$HI - HOUSE OF INVESTMENTS, INC."},"HLCM":{"symbol":"HLCM","description":"HOLCIM PHILIPPINES, INC.","type":"Common","wikhi52":"12.4200","wiklo52":"5.7800","pricescale":"100","last":"6.4000","display_name":"$HLCM - HOLCIM PHILIPPINES, INC."},"HOUSE":{"symbol":"HOUSE","description":"8990 HOLDINGS, INC.","type":"Common","wikhi52":"7.9600","wiklo52":"4.8600","pricescale":"100","last":"7.1000","display_name":"$HOUSE - 8990 HOLDINGS, INC."},"HVN":{"symbol":"HVN","description":"GOLDEN BRIA HOLDINGS, INC.","type":"Common","wikhi52":"392.0000","wiklo52":"17.0200","pricescale":"100","last":"310.0000","display_name":"$HVN - GOLDEN BRIA HOLDINGS, INC."},"I":{"symbol":"I","description":"I-REMIT, INC.","type":"Common","wikhi52":"2.1500","wiklo52":"1.4600","pricescale":"100","last":"1.6900","display_name":"$I - I-REMIT, INC."},"ICT":{"symbol":"ICT","description":"INTERNATIONAL CONTAINER TERMINAL SERVICES, IN","type":"Common","wikhi52":"115.0000","wiklo52":"76.9500","pricescale":"100","last":"95.0000","display_name":"$ICT - INTERNATIONAL CONTAINER TERMINAL SERVICES, IN"},"IDC":{"symbol":"IDC","description":"ITALPINAS DEVELOPMENT CORPORATION","type":"Common","wikhi52":"13.0900","wiklo52":"3.7500","pricescale":"100","last":"4.9500","display_name":"$IDC - ITALPINAS DEVELOPMENT CORPORATION"},"IMI":{"symbol":"IMI","description":"INTEGRATED MICRO-ELECTRONICS, INC.","type":"Common","wikhi52":"21.6600","wiklo52":"11.1800","pricescale":"100","last":"11.9000","display_name":"$IMI - INTEGRATED MICRO-ELECTRONICS, INC."},"IMP":{"symbol":"IMP","description":"IMPERIAL RESOURCES, INC.","type":"Common","wikhi52":"3.7200","wiklo52":"1.8200","pricescale":"100","last":"2.0000","display_name":"$IMP - IMPERIAL RESOURCES, INC."},"IND":{"symbol":"IND","description":"Industrial","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$IND - Industrial"},"ION":{"symbol":"ION","description":"IONICS, INC.","type":"Common","wikhi52":"3.2000","wiklo52":"1.6200","pricescale":"100","last":"1.7000","display_name":"$ION - IONICS, INC."},"IPM":{"symbol":"IPM","description":"IPM HOLDINGS, INC.","type":"Common","wikhi52":"9.0000","wiklo52":"7.5100","pricescale":"100","last":"7.8000","display_name":"$IPM - IPM HOLDINGS, INC."},"IPO":{"symbol":"IPO","description":"IPEOPLE, INC.","type":"Common","wikhi52":"16.5000","wiklo52":"11.0000","pricescale":"100","last":"12.3800","display_name":"$IPO - IPEOPLE, INC."},"IRC":{"symbol":"IRC","description":"IRC PROPERTIES, INC","type":"Common","wikhi52":"2.8000","wiklo52":"0.6600","pricescale":"100","last":"2.3000","display_name":"$IRC - IRC PROPERTIES, INC"},"IS":{"symbol":"IS","description":"ISLAND INFORMATION AND TECHNOLOGY, INC.","type":"Common","wikhi52":"0.1780","wiklo52":"0.1020","pricescale":"1000","last":"0.1100","display_name":"$IS - ISLAND INFORMATION AND TECHNOLOGY, INC."},"ISM":{"symbol":"ISM","description":"ISM COMMUNICATIONS CORPORATION","type":"Common","wikhi52":"3.6400","wiklo52":"1.3200","pricescale":"100","last":"3.2100","display_name":"$ISM - ISM COMMUNICATIONS CORPORATION"},"JAS":{"symbol":"JAS","description":"JACKSTONES, INC.","type":"Common","wikhi52":"5.6200","wiklo52":"2.9000","pricescale":"100","last":"3.0400","display_name":"$JAS - JACKSTONES, INC."},"JFC":{"symbol":"JFC","description":"JOLLIBEE FOODS CORPORATION","type":"Common","wikhi52":"305.4000","wiklo52":"240.2000","pricescale":"100","last":"265.0000","display_name":"$JFC - JOLLIBEE FOODS CORPORATION"},"JGS":{"symbol":"JGS","description":"JG SUMMIT HOLDINGS, INC.","type":"Common","wikhi52":"81.0000","wiklo52":"43.9500","pricescale":"100","last":"48.0000","display_name":"$JGS - JG SUMMIT HOLDINGS, INC."},"JOH":{"symbol":"JOH","description":"JOLLIVILLE HOLDINGS CORPORATION","type":"Common","wikhi52":"7.7000","wiklo52":"4.2000","pricescale":"100","last":"4.8900","display_name":"$JOH - JOLLIVILLE HOLDINGS CORPORATION"},"KEP":{"symbol":"KEP","description":"KEPPEL PHILIPPINES PROPERTIES, INC.","type":"Common","wikhi52":"5.0000","wiklo52":"4.0100","pricescale":"100","last":"4.0900","display_name":"$KEP - KEPPEL PHILIPPINES PROPERTIES, INC."},"KPH":{"symbol":"KPH","description":"KEPPEL PHILIPPINE HOLDINGS, INC. \"A\"","type":"Common","wikhi52":"6.6000","wiklo52":"4.4700","pricescale":"100","last":"5.7900","display_name":"$KPH - KEPPEL PHILIPPINE HOLDINGS, INC. \"A\""},"KPHB":{"symbol":"KPHB","description":"KEPPEL PHILIPPINE HOLDINGS, INC. \"B\"","type":"Common","wikhi52":"6.3800","wiklo52":"5.3300","pricescale":"100","last":"5.3500","display_name":"$KPHB - KEPPEL PHILIPPINE HOLDINGS, INC. \"B\""},"LAND":{"symbol":"LAND","description":"CITY & LAND DEVELOPERS, INC.","type":"Common","wikhi52":"1.2100","wiklo52":"0.5200","pricescale":"100","last":"0.9200","display_name":"$LAND - CITY & LAND DEVELOPERS, INC."},"LBC":{"symbol":"LBC","description":"LBC EXPRESS HOLDINGS, INC.","type":"Common","wikhi52":"19.9000","wiklo52":"14.0000","pricescale":"100","last":"14.8000","display_name":"$LBC - LBC EXPRESS HOLDINGS, INC."},"LC":{"symbol":"LC","description":"LEPANTO CONSOLIDATED MINING COMPANY \"A\"","type":"Common","wikhi52":"0.1875","wiklo52":"0.1070","pricescale":"1000","last":"0.1100","display_name":"$LC - LEPANTO CONSOLIDATED MINING COMPANY \"A\""},"LCB":{"symbol":"LCB","description":"LEPANTO CONSOLIDATED MINING COMPANY \"B\"","type":"Common","wikhi52":"0.1970","wiklo52":"0.0950","pricescale":"1000","last":"0.1120","display_name":"$LCB - LEPANTO CONSOLIDATED MINING COMPANY \"B\""},"LFM":{"symbol":"LFM","description":"LIBERTY FLOUR MILLS, INC.","type":"Common","wikhi52":"70.0000","wiklo52":"26.4000","pricescale":"100","last":"59.0000","display_name":"$LFM - LIBERTY FLOUR MILLS, INC."},"LIHC":{"symbol":"LIHC","description":"LODESTAR INVESTMENT HOLDINGS CORPORATION","type":"Common","wikhi52":"0.8700","wiklo52":"0.5200","pricescale":"100","last":"0.5300","display_name":"$LIHC - LODESTAR INVESTMENT HOLDINGS CORPORATION"},"LMG":{"symbol":"LMG","description":"LMG CHEMICALS CORPORATION","type":"Common","wikhi52":"5.6000","wiklo52":"3.8300","pricescale":"100","last":"4.7900","display_name":"$LMG - LMG CHEMICALS CORPORATION"},"LOTO":{"symbol":"LOTO","description":"PACIFIC ONLINE SYSTEMS CORPORATION","type":"Common","wikhi52":"15.4000","wiklo52":"10.0000","pricescale":"100","last":"10.5600","display_name":"$LOTO - PACIFIC ONLINE SYSTEMS CORPORATION"},"LPZ":{"symbol":"LPZ","description":"LOPEZ HOLDINGS CORPORATION","type":"Common","wikhi52":"6.4000","wiklo52":"3.5400","pricescale":"100","last":"4.4400","display_name":"$LPZ - LOPEZ HOLDINGS CORPORATION"},"LR":{"symbol":"LR","description":"LEISURE & RESORTS WORLD CORPORATION","type":"Common","wikhi52":"7.4900","wiklo52":"3.2200","pricescale":"100","last":"3.6000","display_name":"$LR - LEISURE & RESORTS WORLD CORPORATION"},"LRP":{"symbol":"LRP","description":"LEISURE AND RESORTS WORLD CORPORATION PREFERR","type":"Preferred","wikhi52":"1.1400","wiklo52":"1.0100","pricescale":"100","last":"1.0200","display_name":"$LRP - LEISURE AND RESORTS WORLD CORPORATION PREFERR"},"LRW":{"symbol":"LRW","description":"LEISURE AND RESORTS WORLD CORPORATION WARRANT","type":"Warrants","wikhi52":"5.1500","wiklo52":"2.1600","pricescale":"100","last":"2.4500","display_name":"$LRW - LEISURE AND RESORTS WORLD CORPORATION WARRANT"},"LSC":{"symbol":"LSC","description":"LORENZO SHIPPING CORPORATION","type":"Common","wikhi52":"1.6700","wiklo52":"0.8200","pricescale":"100","last":"0.8500","display_name":"$LSC - LORENZO SHIPPING CORPORATION"},"LTG":{"symbol":"LTG","description":"LT GROUP, INC.","type":"Common","wikhi52":"25.3000","wiklo52":"12.7800","pricescale":"100","last":"13.2800","display_name":"$LTG - LT GROUP, INC."},"M-O":{"symbol":"M-O","description":"Mining and Oil","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$M-O - Mining and Oil"},"MA":{"symbol":"MA","description":"MANILA MINING CORPORATION \"A\"","type":"Common","wikhi52":"0.0110","wiklo52":"0.0068","pricescale":"10000","last":"0.0076","display_name":"$MA - MANILA MINING CORPORATION \"A\""},"MAB":{"symbol":"MAB","description":"MANILA MINING CORPORATION \"B\"","type":"Common","wikhi52":"0.0120","wiklo52":"0.0052","pricescale":"10000","last":"0.0070","display_name":"$MAB - MANILA MINING CORPORATION \"B\""},"MAC":{"symbol":"MAC","description":"MACROASIA CORPORATION","type":"Common","wikhi52":"23.0800","wiklo52":"13.9500","pricescale":"100","last":"18.2200","display_name":"$MAC - MACROASIA CORPORATION"},"MACAY":{"symbol":"MACAY","description":"MACAY HOLDINGS, INC.","type":"Common","wikhi52":"26.4000","wiklo52":"11.5200","pricescale":"100","last":"13.0000","display_name":"$MACAY - MACAY HOLDINGS, INC."},"MAH":{"symbol":"MAH","description":"METRO ALLIANCE HOLDINGS & EQUITIES CORP. \"A\"","type":"Common","wikhi52":"5.5000","wiklo52":"1.3500","pricescale":"100","last":"1.3900","display_name":"$MAH - METRO ALLIANCE HOLDINGS & EQUITIES CORP. \"A\""},"MAHB":{"symbol":"MAHB","description":"METRO ALLIANCE HOLDINGS & EQUITIES CORP. \"B\"","type":"Common","wikhi52":"5.4500","wiklo52":"1.3600","pricescale":"100","last":"1.6300","display_name":"$MAHB - METRO ALLIANCE HOLDINGS & EQUITIES CORP. \"B\""},"MARC":{"symbol":"MARC","description":"MARCVENTURES HOLDINGS, INC.","type":"Common","wikhi52":"2.0800","wiklo52":"1.1000","pricescale":"100","last":"1.3100","display_name":"$MARC - MARCVENTURES HOLDINGS, INC."},"MAXS":{"symbol":"MAXS","description":"MAX'S GROUP, INC.","type":"Common","wikhi52":"19.8400","wiklo52":"10.5000","pricescale":"100","last":"10.9000","display_name":"$MAXS - MAX'S GROUP, INC."},"MB":{"symbol":"MB","description":"MANILA BULLETIN PUBLISHING CORPORATION","type":"Common","wikhi52":"0.6000","wiklo52":"0.4000","pricescale":"1000","last":"0.4100","display_name":"$MB - MANILA BULLETIN PUBLISHING CORPORATION"},"MBC":{"symbol":"MBC","description":"MANILA BROADCASTING COMPANY","type":"Common","wikhi52":"24.0000","wiklo52":"15.0000","pricescale":"100","last":"15.1000","display_name":"$MBC - MANILA BROADCASTING COMPANY"},"MBT":{"symbol":"MBT","description":"METROPOLITAN BANK & TRUST COMPANY","type":"Common","wikhi52":"104.9700","wiklo52":"64.0000","pricescale":"100","last":"66.0500","display_name":"$MBT - METROPOLITAN BANK & TRUST COMPANY"},"MED":{"symbol":"MED","description":"MEDCO HOLDINGS, INC.","type":"Common","wikhi52":"0.7000","wiklo52":"0.4300","pricescale":"1000","last":"0.4850","display_name":"$MED - MEDCO HOLDINGS, INC."},"MEG":{"symbol":"MEG","description":"MEGAWORLD CORPORATION","type":"Common","wikhi52":"5.8500","wiklo52":"3.9800","pricescale":"100","last":"4.4000","display_name":"$MEG - MEGAWORLD CORPORATION"},"MER":{"symbol":"MER","description":"MANILA ELECTRIC COMPANY","type":"Common","wikhi52":"395.0000","wiklo52":"280.4000","pricescale":"100","last":"346.8000","display_name":"$MER - MANILA ELECTRIC COMPANY"},"MFC":{"symbol":"MFC","description":"MANULIFE FINANCIAL CORPORATION","type":"Common","wikhi52":"1050.0000","wiklo52":"770.0000","pricescale":"100","last":"786.0000","display_name":"$MFC - MANULIFE FINANCIAL CORPORATION"},"MFIN":{"symbol":"MFIN","description":"MAKATI FINANCE CORPORATION","type":"Common","wikhi52":"4.3400","wiklo52":"1.5600","pricescale":"100","last":"2.9200","display_name":"$MFIN - MAKATI FINANCE CORPORATION"},"MG":{"symbol":"MG","description":"MILLENNIUM GLOBAL HOLDINGS, INC.","type":"Common","wikhi52":"0.2550","wiklo52":"0.1670","pricescale":"1000","last":"0.1750","display_name":"$MG - MILLENNIUM GLOBAL HOLDINGS, INC."},"MGH":{"symbol":"MGH","description":"METRO GLOBAL HOLDINGS CORPORATION","type":"Common","wikhi52":"1.0000","wiklo52":"0.2000","pricescale":"100","last":"1.0000","display_name":"$MGH - METRO GLOBAL HOLDINGS CORPORATION"},"MHC":{"symbol":"MHC","description":"MABUHAY HOLDINGS CORPORATION","type":"Common","wikhi52":"0.8400","wiklo52":"0.2600","pricescale":"100","last":"0.5300","display_name":"$MHC - MABUHAY HOLDINGS CORPORATION"},"MJC":{"symbol":"MJC","description":"MANILA JOCKEY CLUB, INC.","type":"Common","wikhi52":"6.8200","wiklo52":"2.7100","pricescale":"100","last":"5.1000","display_name":"$MJC - MANILA JOCKEY CLUB, INC."},"MJIC":{"symbol":"MJIC","description":"MJC INVESTMENTS CORPORATION","type":"Common","wikhi52":"4.0100","wiklo52":"3.1500","pricescale":"100","last":"3.3200","display_name":"$MJIC - MJC INVESTMENTS CORPORATION"},"MPI":{"symbol":"MPI","description":"METRO PACIFIC INVESTMENTS CORPORATION","type":"Common","wikhi52":"6.9400","wiklo52":"4.2000","pricescale":"100","last":"4.9500","display_name":"$MPI - METRO PACIFIC INVESTMENTS CORPORATION"},"MRC":{"symbol":"MRC","description":"MRC ALLIED INCORPORATED","type":"Common","wikhi52":"0.9400","wiklo52":"0.2900","pricescale":"100","last":"0.6100","display_name":"$MRC - MRC ALLIED INCORPORATED"},"MRP":{"symbol":"MRP","description":"MELCO RESORTS","type":"Common","wikhi52":"9.2700","wiklo52":"5.0200","pricescale":"100","last":"7.1100","display_name":"$MRP - MELCO RESORTS"},"MRSGI":{"symbol":"MRSGI","description":"METRO RETAIL STORES GROUP, INC.","type":"Common","wikhi52":"4.2000","wiklo52":"2.1200","pricescale":"100","last":"2.2200","display_name":"$MRSGI - METRO RETAIL STORES GROUP, INC."},"MVC":{"symbol":"MVC","description":"MABUHAY VINYL CORPORATION","type":"Common","wikhi52":"4.0000","wiklo52":"2.9300","pricescale":"100","last":"3.3800","display_name":"$MVC - MABUHAY VINYL CORPORATION"},"MWC":{"symbol":"MWC","description":"MANILA WATER COMPANY, INC.","type":"Common","wikhi52":"32.4000","wiklo52":"23.3500","pricescale":"100","last":"25.8000","display_name":"$MWC - MANILA WATER COMPANY, INC."},"MWIDE":{"symbol":"MWIDE","description":"MEGAWIDE CONSTRUCTION CORP.","type":"Common","wikhi52":"25.0000","wiklo52":"14.0200","pricescale":"100","last":"16.9800","display_name":"$MWIDE - MEGAWIDE CONSTRUCTION CORP."},"MWP":{"symbol":"MWP","description":"MEGAWIDE CONSTRUCTION CORPORATION PERPETUAL P","type":"Preferred","wikhi52":"112.9000","wiklo52":"95.1000","pricescale":"100","last":"100.0000","display_name":"$MWP - MEGAWIDE CONSTRUCTION CORPORATION PERPETUAL P"},"NI":{"symbol":"NI","description":"NIHAO MINERAL RESOURCES INTERNATIONAL, INC.","type":"Common","wikhi52":"1.8500","wiklo52":"0.9700","pricescale":"100","last":"1.0700","display_name":"$NI - NIHAO MINERAL RESOURCES INTERNATIONAL, INC."},"NIKL":{"symbol":"NIKL","description":"NICKEL ASIA CORPORATION","type":"Common","wikhi52":"4.3200","wiklo52":"2.3100","pricescale":"100","last":"2.7400","display_name":"$NIKL - NICKEL ASIA CORPORATION"},"NOW":{"symbol":"NOW","description":"NOW CORPORATION","type":"Common","wikhi52":"20.0000","wiklo52":"2.1700","pricescale":"100","last":"5.2900","display_name":"$NOW - NOW CORPORATION"},"NRCP":{"symbol":"NRCP","description":"NATIONAL REINSURANCE CORPORATION OF THE PHILI","type":"Common","wikhi52":"1.9300","wiklo52":"0.7800","pricescale":"100","last":"0.9300","display_name":"$NRCP - NATIONAL REINSURANCE CORPORATION OF THE PHILI"},"NXGEN":{"symbol":"NXGEN","description":"NEXTGENESIS CORPORATION","type":"Common","wikhi52":"7.7000","wiklo52":"4.4500","pricescale":"100","last":"7.0000","display_name":"$NXGEN - NEXTGENESIS CORPORATION"},"OM":{"symbol":"OM","description":"OMICO CORPORATION","type":"Common","wikhi52":"0.7800","wiklo52":"0.4050","pricescale":"100","last":"0.6100","display_name":"$OM - OMICO CORPORATION"},"OPM":{"symbol":"OPM","description":"ORIENTAL PETROLEUM AND MINERALS CORPORATION \"","type":"Common","wikhi52":"0.0140","wiklo52":"0.0110","pricescale":"10000","last":"0.0130","display_name":"$OPM - ORIENTAL PETROLEUM AND MINERALS CORPORATION \""},"OPMB":{"symbol":"OPMB","description":"ORIENTAL PETROLEUM AND MINERALS CORPORATION \"","type":"Common","wikhi52":"0.0140","wiklo52":"0.0120","pricescale":"10000","last":"0.0130","display_name":"$OPMB - ORIENTAL PETROLEUM AND MINERALS CORPORATION \""},"ORE":{"symbol":"ORE","description":"ORIENTAL PENINSULA RESOURCES GROUP, INC.","type":"Common","wikhi52":"1.5300","wiklo52":"0.8400","pricescale":"100","last":"1.0500","display_name":"$ORE - ORIENTAL PENINSULA RESOURCES GROUP, INC."},"OV":{"symbol":"OV","description":"THE PHILODRILL CORPORATION","type":"Common","wikhi52":"0.0130","wiklo52":"0.0110","pricescale":"10000","last":"0.0120","display_name":"$OV - THE PHILODRILL CORPORATION"},"PA":{"symbol":"PA","description":"PACIFICA, INC.","type":"Common","wikhi52":"0.0570","wiklo52":"0.0360","pricescale":"10000","last":"0.0370","display_name":"$PA - PACIFICA, INC."},"PAL":{"symbol":"PAL","description":"PAL HOLDINGS, INC.","type":"Common","wikhi52":"12.5600","wiklo52":"7.5000","pricescale":"100","last":"8.3800","display_name":"$PAL - PAL HOLDINGS, INC."},"PAX":{"symbol":"PAX","description":"PAXYS, INC.","type":"Common","wikhi52":"4.2100","wiklo52":"2.7200","pricescale":"100","last":"3.1400","display_name":"$PAX - PAXYS, INC."},"PBB":{"symbol":"PBB","description":"PHILIPPINE BUSINESS BANK","type":"Common","wikhi52":"13.7000","wiklo52":"10.8000","pricescale":"100","last":"11.1000","display_name":"$PBB - PHILIPPINE BUSINESS BANK"},"PBC":{"symbol":"PBC","description":"PHILIPPINE BANK OF COMMUNICATIONS","type":"Common","wikhi52":"26.0000","wiklo52":"18.5400","pricescale":"100","last":"19.8800","display_name":"$PBC - PHILIPPINE BANK OF COMMUNICATIONS"},"PCOR":{"symbol":"PCOR","description":"PETRON CORPORATION","type":"Common","wikhi52":"10.3400","wiklo52":"8.2000","pricescale":"100","last":"8.2500","display_name":"$PCOR - PETRON CORPORATION"},"PCP":{"symbol":"PCP","description":"PICOP RESOURCES, INC.","type":"Common","wikhi52":"0.7500","wiklo52":"0.1800","pricescale":"1000","last":"0.2050","display_name":"$PCP - PICOP RESOURCES, INC."},"PERC":{"symbol":"PERC","description":"PETROENERGY RESOURCES CORPORATION","type":"Common","wikhi52":"6.6600","wiklo52":"3.6200","pricescale":"100","last":"4.1500","display_name":"$PERC - PETROENERGY RESOURCES CORPORATION"},"PGOLD":{"symbol":"PGOLD","description":"PUREGOLD PRICE CLUB, INC.","type":"Common","wikhi52":"55.0500","wiklo52":"39.6000","pricescale":"100","last":"40.4000","display_name":"$PGOLD - PUREGOLD PRICE CLUB, INC."},"PHA":{"symbol":"PHA","description":"PREMIERE HORIZON ALLIANCE CORPORATION","type":"Common","wikhi52":"0.5300","wiklo52":"0.3200","pricescale":"1000","last":"0.3550","display_name":"$PHA - PREMIERE HORIZON ALLIANCE CORPORATION"},"PHC":{"symbol":"PHC","description":"PHILCOMSAT HOLDINGS CORPORATION","type":"Common","wikhi52":"1.8000","wiklo52":"0.7800","pricescale":"100","last":"1.4000","display_name":"$PHC - PHILCOMSAT HOLDINGS CORPORATION"},"PHEN":{"symbol":"PHEN","description":"PHINMA ENERGY CORPORATION","type":"Common","wikhi52":"1.8900","wiklo52":"0.9400","pricescale":"100","last":"0.9700","display_name":"$PHEN - PHINMA ENERGY CORPORATION"},"PHES":{"symbol":"PHES","description":"PHILIPPINE ESTATES CORPORATION","type":"Common","wikhi52":"0.6000","wiklo52":"0.2950","pricescale":"1000","last":"0.4150","display_name":"$PHES - PHILIPPINE ESTATES CORPORATION"},"PHN":{"symbol":"PHN","description":"PHINMA CORPORATION","type":"Common","wikhi52":"9.9000","wiklo52":"7.5000","pricescale":"100","last":"9.0000","display_name":"$PHN - PHINMA CORPORATION"},"PIP":{"symbol":"PIP","description":"PEPSI-COLA PRODUCTS PHILIPPINES, INC.","type":"Common","wikhi52":"3.1000","wiklo52":"1.5100","pricescale":"100","last":"1.6500","display_name":"$PIP - PEPSI-COLA PRODUCTS PHILIPPINES, INC."},"PIZZA":{"symbol":"PIZZA","description":"SHAKEY'S PIZZA ASIA VENTURES, INC.","type":"Common","wikhi52":"17.4800","wiklo52":"10.5000","pricescale":"100","last":"11.4000","display_name":"$PIZZA - SHAKEY'S PIZZA ASIA VENTURES, INC."},"PLC":{"symbol":"PLC","description":"PREMIUM LEISURE CORP.","type":"Common","wikhi52":"1.4600","wiklo52":"0.8100","pricescale":"100","last":"0.8400","display_name":"$PLC - PREMIUM LEISURE CORP."},"PMPC":{"symbol":"PMPC","description":"PANASONIC MANUFACTURING PHILIPPINES CORPORATI","type":"Common","wikhi52":"11.6800","wiklo52":"5.1600","pricescale":"100","last":"6.3900","display_name":"$PMPC - PANASONIC MANUFACTURING PHILIPPINES CORPORATI"},"PMT":{"symbol":"PMT","description":"PRIMETOWN PROPERTY GROUP, INC.","type":"Common","wikhi52":"0.4700","wiklo52":"0.3700","pricescale":"1000","last":"0.3700","display_name":"$PMT - PRIMETOWN PROPERTY GROUP, INC."},"PNB":{"symbol":"PNB","description":"PHILIPPINE NATIONAL BANK","type":"Common","wikhi52":"60.2000","wiklo52":"40.0500","pricescale":"100","last":"41.4000","display_name":"$PNB - PHILIPPINE NATIONAL BANK"},"PNC":{"symbol":"PNC","description":"PHILIPPINE NATIONAL CONSTRUCTION CORPORATION","type":"Common","wikhi52":"6.3000","wiklo52":"3.6000","pricescale":"100","last":"4.9000","display_name":"$PNC - PHILIPPINE NATIONAL CONSTRUCTION CORPORATION"},"PNX":{"symbol":"PNX","description":"PHOENIX PETROLEUM PHILIPPINES, INC.","type":"Common","wikhi52":"13.8400","wiklo52":"10.1000","pricescale":"100","last":"10.8000","display_name":"$PNX - PHOENIX PETROLEUM PHILIPPINES, INC."},"PNX3A":{"symbol":"PNX3A","description":"PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN","type":"Common","wikhi52":"106.0000","wiklo52":"99.5000","pricescale":"100","last":"100.1000","display_name":"$PNX3A - PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN"},"PNX3B":{"symbol":"PNX3B","description":"PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN","type":"Common","wikhi52":"115.0000","wiklo52":"100.0000","pricescale":"100","last":"102.0000","display_name":"$PNX3B - PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN"},"PNXP":{"symbol":"PNXP","description":"PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN","type":"Preferred","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"100","last":"100.0000","display_name":"$PNXP - PHOENIX PETROLEUM PHILIPPINES, INC. NON-VOTIN"},"POPI":{"symbol":"POPI","description":"PRIME ORION PHILIPPINES, INC.","type":"Common","wikhi52":"4.1000","wiklo52":"2.0400","pricescale":"100","last":"2.4100","display_name":"$POPI - PRIME ORION PHILIPPINES, INC."},"PORT":{"symbol":"PORT","description":"GLOBALPORT 900, INC.","type":"Common","wikhi52":"14.4800","wiklo52":"5.1000","pricescale":"100","last":"7.3000","display_name":"$PORT - GLOBALPORT 900, INC."},"PPC":{"symbol":"PPC","description":"PRYCE CORPORATION","type":"Common","wikhi52":"7.0700","wiklo52":"5.5500","pricescale":"100","last":"5.8500","display_name":"$PPC - PRYCE CORPORATION"},"PPG":{"symbol":"PPG","description":"PHINMA PETROLEUM AND GEOTHERMAL, INC.","type":"Common","wikhi52":"4.8300","wiklo52":"1.8800","pricescale":"100","last":"4.2000","display_name":"$PPG - PHINMA PETROLEUM AND GEOTHERMAL, INC."},"PRC":{"symbol":"PRC","description":"PHILIPPINE RACING CLUB, INC.","type":"Common","wikhi52":"11.9800","wiklo52":"7.7000","pricescale":"100","last":"8.5000","display_name":"$PRC - PHILIPPINE RACING CLUB, INC."},"PRF2A":{"symbol":"PRF2A","description":"PETRON CORPORATION PERPETUAL PREFERRED SHARES","type":"Preferred","wikhi52":"1075.0000","wiklo52":"990.0000","pricescale":"1","last":"1010.0000","display_name":"$PRF2A - PETRON CORPORATION PERPETUAL PREFERRED SHARES"},"PRF2B":{"symbol":"PRF2B","description":"PETRON CORPORATION PERPETUAL PREFERRED SHARES","type":"Preferred","wikhi52":"1175.0000","wiklo52":"1000.0000","pricescale":"1","last":"1019.0000","display_name":"$PRF2B - PETRON CORPORATION PERPETUAL PREFERRED SHARES"},"PRIM":{"symbol":"PRIM","description":"PRIME MEDIA HOLDINGS, INC.","type":"Common","wikhi52":"1.8800","wiklo52":"1.0200","pricescale":"100","last":"1.2000","display_name":"$PRIM - PRIME MEDIA HOLDINGS, INC."},"PRMX":{"symbol":"PRMX","description":"PRIMEX CORPORATION","type":"Common","wikhi52":"7.4100","wiklo52":"2.4800","pricescale":"100","last":"3.1900","display_name":"$PRMX - PRIMEX CORPORATION"},"PRO":{"symbol":"PRO","description":"Property","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$PRO - Property"},"PSB":{"symbol":"PSB","description":"PHILIPPINE SAVINGS BANK","type":"Common","wikhi52":"90.0000","wiklo52":"70.0000","pricescale":"100","last":"78.4000","display_name":"$PSB - PHILIPPINE SAVINGS BANK"},"PSE":{"symbol":"PSE","description":"THE PHILIPPINE STOCK EXCHANGE, INC.","type":"Common","wikhi52":"259.8000","wiklo52":"184.0000","pricescale":"100","last":"189.9000","display_name":"$PSE - THE PHILIPPINE STOCK EXCHANGE, INC."},"PSEI":{"symbol":"PSEI","description":"Philippine Stock Exchange Index","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$PSEI - Philippine Stock Exchange Index"},"PTC":{"symbol":"PTC","description":"PHILIPPINE TRUST COMPANY","type":"Common","wikhi52":"220.0000","wiklo52":"95.0000","pricescale":"100","last":"102.4000","display_name":"$PTC - PHILIPPINE TRUST COMPANY"},"PTT":{"symbol":"PTT","description":"PHILIPPINE TELEGRAPH & TELEPHONE CORPORATION","type":"Common","wikhi52":"0.5300","wiklo52":"0.0900","pricescale":"1000","last":"0.3300","display_name":"$PTT - PHILIPPINE TELEGRAPH & TELEPHONE CORPORATION"},"PX":{"symbol":"PX","description":"PHILEX MINING CORPORATION","type":"Common","wikhi52":"7.9500","wiklo52":"3.1900","pricescale":"100","last":"3.2200","display_name":"$PX - PHILEX MINING CORPORATION"},"PXP":{"symbol":"PXP","description":"PXP ENERGY CORPORATION","type":"Common","wikhi52":"19.4200","wiklo52":"7.0900","pricescale":"100","last":"16.0600","display_name":"$PXP - PXP ENERGY CORPORATION"},"RCB":{"symbol":"RCB","description":"RIZAL COMMERCIAL BANKING CORPORATION","type":"Common","wikhi52":"58.9900","wiklo52":"24.8500","pricescale":"100","last":"28.3000","display_name":"$RCB - RIZAL COMMERCIAL BANKING CORPORATION"},"RCI":{"symbol":"RCI","description":"ROXAS AND COMPANY, INC.","type":"Common","wikhi52":"4.9500","wiklo52":"1.8200","pricescale":"100","last":"2.3200","display_name":"$RCI - ROXAS AND COMPANY, INC."},"REG":{"symbol":"REG","description":"REPUBLIC GLASS HOLDINGS CORPORATION","type":"Common","wikhi52":"5.8500","wiklo52":"2.4700","pricescale":"100","last":"2.6900","display_name":"$REG - REPUBLIC GLASS HOLDINGS CORPORATION"},"RFM":{"symbol":"RFM","description":"RFM CORPORATION","type":"Common","wikhi52":"5.4700","wiklo52":"4.5200","pricescale":"100","last":"4.8000","display_name":"$RFM - RFM CORPORATION"},"RLC":{"symbol":"RLC","description":"ROBINSONS LAND CORPORATION","type":"Common","wikhi52":"25.9100","wiklo52":"17.5000","pricescale":"100","last":"21.4500","display_name":"$RLC - ROBINSONS LAND CORPORATION"},"RLT":{"symbol":"RLT","description":"PHILIPPINE REALTY & HOLDINGS CORPORATION","type":"Common","wikhi52":"0.7100","wiklo52":"0.3750","pricescale":"1000","last":"0.4300","display_name":"$RLT - PHILIPPINE REALTY & HOLDINGS CORPORATION"},"ROCK":{"symbol":"ROCK","description":"ROCKWELL LAND CORPORATION","type":"Common","wikhi52":"2.7800","wiklo52":"1.8100","pricescale":"100","last":"1.9400","display_name":"$ROCK - ROCKWELL LAND CORPORATION"},"ROX":{"symbol":"ROX","description":"ROXAS HOLDINGS, INC.","type":"Common","wikhi52":"5.7800","wiklo52":"2.7100","pricescale":"100","last":"2.8300","display_name":"$ROX - ROXAS HOLDINGS, INC."},"RRHI":{"symbol":"RRHI","description":"ROBINSONS RETAIL HOLDINGS, INC.","type":"Common","wikhi52":"101.8000","wiklo52":"73.5500","pricescale":"100","last":"76.5000","display_name":"$RRHI - ROBINSONS RETAIL HOLDINGS, INC."},"RWM":{"symbol":"RWM","description":"TRAVELLERS INTERNATIONAL HOTEL GROUP, INC.","type":"Common","wikhi52":"5.4500","wiklo52":"3.3300","pricescale":"100","last":"5.2100","display_name":"$RWM - TRAVELLERS INTERNATIONAL HOTEL GROUP, INC."},"SBS":{"symbol":"SBS","description":"SBS PHILIPPINES CORPORATION","type":"Common","wikhi52":"11.8000","wiklo52":"5.4000","pricescale":"100","last":"6.7200","display_name":"$SBS - SBS PHILIPPINES CORPORATION"},"SCC":{"symbol":"SCC","description":"SEMIRARA MINING AND POWER CORPORATION","type":"Common","wikhi52":"43.9000","wiklo52":"24.0000","pricescale":"100","last":"29.5000","display_name":"$SCC - SEMIRARA MINING AND POWER CORPORATION"},"SECB":{"symbol":"SECB","description":"SECURITY BANK CORPORATION","type":"Common","wikhi52":"266.0000","wiklo52":"132.1000","pricescale":"100","last":"152.5000","display_name":"$SECB - SECURITY BANK CORPORATION"},"SEVN":{"symbol":"SEVN","description":"PHILIPPINE SEVEN CORPORATION \"COMMON\"","type":"Common","wikhi52":"195.0000","wiklo52":"98.0000","pricescale":"100","last":"111.9000","display_name":"$SEVN - PHILIPPINE SEVEN CORPORATION \"COMMON\""},"SFI":{"symbol":"SFI","description":"SWIFT FOODS, INC.","type":"Common","wikhi52":"0.1900","wiklo52":"0.1220","pricescale":"1000","last":"0.1220","display_name":"$SFI - SWIFT FOODS, INC."},"SFIP":{"symbol":"SFIP","description":"SWIFT FOODS, INC. - CONVERTIBLE PREFERRED","type":"Preferred","wikhi52":"4.3800","wiklo52":"1.8500","pricescale":"100","last":"1.8500","display_name":"$SFIP - SWIFT FOODS, INC. - CONVERTIBLE PREFERRED"},"SGI":{"symbol":"SGI","description":"SOLID GROUP, INC.","type":"Common","wikhi52":"2.1000","wiklo52":"1.3200","pricescale":"100","last":"1.4000","display_name":"$SGI - SOLID GROUP, INC."},"SGP":{"symbol":"SGP","description":"SYNERGY GRID & DEVELOPMENT PHILS., INC.","type":"Common","wikhi52":"1100.0000","wiklo52":"175.1000","pricescale":"100","last":"320.0000","display_name":"$SGP - SYNERGY GRID & DEVELOPMENT PHILS., INC."},"SHLPH":{"symbol":"SHLPH","description":"PILIPINAS SHELL PETROLEUM CORPORATION","type":"Common","wikhi52":"66.5000","wiklo52":"48.1000","pricescale":"100","last":"50.6500","display_name":"$SHLPH - PILIPINAS SHELL PETROLEUM CORPORATION"},"SHNG":{"symbol":"SHNG","description":"SHANG PROPERTIES, INC.","type":"Common","wikhi52":"3.5900","wiklo52":"3.0100","pricescale":"100","last":"3.1200","display_name":"$SHNG - SHANG PROPERTIES, INC."},"SLF":{"symbol":"SLF","description":"SUN LIFE FINANCIAL, INC.","type":"Common","wikhi52":"2000.0000","wiklo52":"1805.0000","pricescale":"1","last":"1820.0000","display_name":"$SLF - SUN LIFE FINANCIAL, INC."},"SLI":{"symbol":"SLI","description":"STA. LUCIA LAND, INC.","type":"Common","wikhi52":"1.2200","wiklo52":"0.9800","pricescale":"100","last":"1.1200","display_name":"$SLI - STA. LUCIA LAND, INC."},"SM":{"symbol":"SM","description":"SM INVESTMENTS CORPORATION","type":"Common","wikhi52":"1142.0000","wiklo52":"826.0000","pricescale":"100","last":"865.0000","display_name":"$SM - SM INVESTMENTS CORPORATION"},"SMC":{"symbol":"SMC","description":"SAN MIGUEL CORPORATION","type":"Common","wikhi52":"180.1000","wiklo52":"100.6000","pricescale":"100","last":"158.0000","display_name":"$SMC - SAN MIGUEL CORPORATION"},"SMC2A":{"symbol":"SMC2A","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"76.9000","wiklo52":"74.0000","pricescale":"100","last":"74.0000","display_name":"$SMC2A - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2B":{"symbol":"SMC2B","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"91.0000","wiklo52":"75.0000","pricescale":"100","last":"76.0000","display_name":"$SMC2B - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2C":{"symbol":"SMC2C","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"82.9500","wiklo52":"75.0000","pricescale":"100","last":"77.0000","display_name":"$SMC2C - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2D":{"symbol":"SMC2D","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"78.5000","wiklo52":"72.0000","pricescale":"100","last":"74.7000","display_name":"$SMC2D - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2E":{"symbol":"SMC2E","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"79.0000","wiklo52":"73.3000","pricescale":"100","last":"75.0000","display_name":"$SMC2E - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2F":{"symbol":"SMC2F","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"82.7000","wiklo52":"74.0000","pricescale":"100","last":"75.2000","display_name":"$SMC2F - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2G":{"symbol":"SMC2G","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"79.5000","wiklo52":"74.2500","pricescale":"100","last":"75.0000","display_name":"$SMC2G - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2H":{"symbol":"SMC2H","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"79.6000","wiklo52":"72.5000","pricescale":"100","last":"74.9000","display_name":"$SMC2H - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMC2I":{"symbol":"SMC2I","description":"SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S","type":"Preferred","wikhi52":"81.7000","wiklo52":"72.7500","pricescale":"100","last":"74.7000","display_name":"$SMC2I - SAN MIGUEL CORPORATION SERIES \"2\" PREFERRED S"},"SMCP1":{"symbol":"SMCP1","description":"SAN MIGUEL CORPORATION PREF. SERIES \"1\"","type":"Preferred","wikhi52":"80.0000","wiklo52":"73.0000","pricescale":"100","last":"75.5000","display_name":"$SMCP1 - SAN MIGUEL CORPORATION PREF. SERIES \"1\""},"SMPH":{"symbol":"SMPH","description":"SM PRIME HOLDINGS, INC.","type":"Common","wikhi52":"39.7000","wiklo52":"32.1000","pricescale":"100","last":"34.5000","display_name":"$SMPH - SM PRIME HOLDINGS, INC."},"SOC":{"symbol":"SOC","description":"SOCRESOURCES, INC.","type":"Common","wikhi52":"1.1000","wiklo52":"0.7400","pricescale":"100","last":"0.8100","display_name":"$SOC - SOCRESOURCES, INC."},"SPC":{"symbol":"SPC","description":"SPC POWER CORPORATION","type":"Common","wikhi52":"7.0000","wiklo52":"4.5700","pricescale":"100","last":"5.1900","display_name":"$SPC - SPC POWER CORPORATION"},"SPM":{"symbol":"SPM","description":"SEAFRONT RESOURCES CORPORATION","type":"Common","wikhi52":"3.3400","wiklo52":"2.5200","pricescale":"100","last":"2.5500","display_name":"$SPM - SEAFRONT RESOURCES CORPORATION"},"SRDC":{"symbol":"SRDC","description":"SUPERCITY REALTY DEVELOPMENT CORPORATION","type":"Common","wikhi52":"0.8000","wiklo52":"0.8000","pricescale":"100","last":"0.8000","display_name":"$SRDC - SUPERCITY REALTY DEVELOPMENT CORPORATION"},"SSI":{"symbol":"SSI","description":"SSI GROUP, INC.","type":"Common","wikhi52":"4.3000","wiklo52":"1.8000","pricescale":"100","last":"2.6300","display_name":"$SSI - SSI GROUP, INC."},"SSP":{"symbol":"SSP","description":"SFA SEMICON PHILIPPINES CORPORATION","type":"Common","wikhi52":"2.9800","wiklo52":"1.3700","pricescale":"100","last":"1.5700","display_name":"$SSP - SFA SEMICON PHILIPPINES CORPORATION"},"STI":{"symbol":"STI","description":"STI EDUCATION SYSTEMS HOLDINGS, INC.","type":"Common","wikhi52":"1.9300","wiklo52":"0.5900","pricescale":"100","last":"0.7900","display_name":"$STI - STI EDUCATION SYSTEMS HOLDINGS, INC."},"STN":{"symbol":"STN","description":"STENIEL MANUFACTURING CORPORATION","type":"Common","wikhi52":"0.7800","wiklo52":"0.1100","pricescale":"1000","last":"0.2600","display_name":"$STN - STENIEL MANUFACTURING CORPORATION"},"STR":{"symbol":"STR","description":"STARMALLS, INC.","type":"Common","wikhi52":"32.0000","wiklo52":"5.3000","pricescale":"100","last":"6.0000","display_name":"$STR - STARMALLS, INC."},"SUN":{"symbol":"SUN","description":"SUNTRUST HOME DEVELOPERS, INC.","type":"Common","wikhi52":"0.9200","wiklo52":"0.7000","pricescale":"100","last":"0.7500","display_name":"$SUN - SUNTRUST HOME DEVELOPERS, INC."},"SVC":{"symbol":"SVC","description":"Services","type":"index","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"0","last":"0.0000","display_name":"$SVC - Services"},"T":{"symbol":"T","description":"TKC METALS CORPORATION","type":"Common","wikhi52":"1.4500","wiklo52":"0.8300","pricescale":"100","last":"0.9000","display_name":"$T - TKC METALS CORPORATION"},"TBGI":{"symbol":"TBGI","description":"TRANSPACIFIC BROADBAND GROUP INTERNATIONAL, I","type":"Common","wikhi52":"0.8400","wiklo52":"0.1850","pricescale":"100","last":"0.5400","display_name":"$TBGI - TRANSPACIFIC BROADBAND GROUP INTERNATIONAL, I"},"TECB2":{"symbol":"TECB2","description":"CIRTEK HOLDINGS PHILIPPINES CORPORATIONUS DOL","type":"Preferred","wikhi52":"1.0600","wiklo52":"0.8000","pricescale":"100","last":"1.0100","display_name":"$TECB2 - CIRTEK HOLDINGS PHILIPPINES CORPORATIONUS DOL"},"TECH":{"symbol":"TECH","description":"CIRTEK HOLDINGS PHILIPPINES CORPORATION","type":"Common","wikhi52":"65.0000","wiklo52":"28.5000","pricescale":"100","last":"36.9500","display_name":"$TECH - CIRTEK HOLDINGS PHILIPPINES CORPORATION"},"TEL":{"symbol":"TEL","description":"PLDT INC.","type":"Common","wikhi52":"1762.0000","wiklo52":"1100.0000","pricescale":"1","last":"1430.0000","display_name":"$TEL - PLDT INC."},"TFC":{"symbol":"TFC","description":"PTFC REDEVELOPMENT CORPORATION","type":"Common","wikhi52":"59.9000","wiklo52":"27.7500","pricescale":"100","last":"38.9500","display_name":"$TFC - PTFC REDEVELOPMENT CORPORATION"},"TFHI":{"symbol":"TFHI","description":"TOP FRONTIER INVESTMENT HOLDINGS, INC.","type":"Common","wikhi52":"320.0000","wiklo52":"251.0000","pricescale":"100","last":"277.0000","display_name":"$TFHI - TOP FRONTIER INVESTMENT HOLDINGS, INC."},"TLII":{"symbol":"TLII","description":"PLDT CONV. SERIES II","type":"Preferred","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"100","last":"10.0000","display_name":"$TLII - PLDT CONV. SERIES II"},"TLJJ":{"symbol":"TLJJ","description":"PLDT CONV. SERIES JJ","type":"Preferred","wikhi52":"0.0000","wiklo52":"0.0000","pricescale":"100","last":"10.0000","display_name":"$TLJJ - PLDT CONV. SERIES JJ"},"TUGS":{"symbol":"TUGS","description":"HARBOR STAR SHIPPING SERVICES, INC.","type":"Common","wikhi52":"6.0900","wiklo52":"2.2100","pricescale":"100","last":"2.6300","display_name":"$TUGS - HARBOR STAR SHIPPING SERVICES, INC."},"UBP":{"symbol":"UBP","description":"UNION BANK OF THE PHILIPPINES","type":"Common","wikhi52":"90.0200","wiklo52":"64.5000","pricescale":"100","last":"66.4000","display_name":"$UBP - UNION BANK OF THE PHILIPPINES"},"UNI":{"symbol":"UNI","description":"UNIOIL RESOURCES & HOLDINGS COMPANY, INC.","type":"Common","wikhi52":"0.3100","wiklo52":"0.2100","pricescale":"1000","last":"0.2460","display_name":"$UNI - UNIOIL RESOURCES & HOLDINGS COMPANY, INC."},"UPM":{"symbol":"UPM","description":"UNITED PARAGON MINING CORPORATION","type":"Common","wikhi52":"0.0120","wiklo52":"0.0057","pricescale":"10000","last":"0.0070","display_name":"$UPM - UNITED PARAGON MINING CORPORATION"},"URC":{"symbol":"URC","description":"UNIVERSAL ROBINA CORPORATION","type":"Common","wikhi52":"174.0000","wiklo52":"111.3000","pricescale":"100","last":"145.9000","display_name":"$URC - UNIVERSAL ROBINA CORPORATION"},"V":{"symbol":"V","description":"VANTAGE EQUITIES, INC.","type":"Common","wikhi52":"1.3800","wiklo52":"1.1700","pricescale":"100","last":"1.1800","display_name":"$V - VANTAGE EQUITIES, INC."},"VITA":{"symbol":"VITA","description":"VITARICH CORPORATION","type":"Common","wikhi52":"4.2000","wiklo52":"1.5500","pricescale":"100","last":"1.6500","display_name":"$VITA - VITARICH CORPORATION"},"VLL":{"symbol":"VLL","description":"VISTA LAND & LIFESCAPES, INC.","type":"Common","wikhi52":"7.3000","wiklo52":"5.3200","pricescale":"100","last":"5.4100","display_name":"$VLL - VISTA LAND & LIFESCAPES, INC."},"VMC":{"symbol":"VMC","description":"VICTORIAS MILLING COMPANY, INC.","type":"Common","wikhi52":"3.3800","wiklo52":"2.4100","pricescale":"100","last":"2.4100","display_name":"$VMC - VICTORIAS MILLING COMPANY, INC."},"VUL":{"symbol":"VUL","description":"VULCAN INDUSTRIAL & MINING","type":"Common","wikhi52":"2.8200","wiklo52":"0.6000","pricescale":"100","last":"2.6000","display_name":"$VUL - VULCAN INDUSTRIAL & MINING"},"VVT":{"symbol":"VVT","description":"VIVANT CORPORATION","type":"Common","wikhi52":"29.9500","wiklo52":"16.0000","pricescale":"100","last":"19.9800","display_name":"$VVT - VIVANT CORPORATION"},"WEB":{"symbol":"WEB","description":"PHILWEB CORPORATION","type":"Common","wikhi52":"9.9900","wiklo52":"3.3800","pricescale":"100","last":"3.5800","display_name":"$WEB - PHILWEB CORPORATION"},"WIN":{"symbol":"WIN","description":"WELLEX INDUSTRIES, INC.","type":"Common","wikhi52":"0.4200","wiklo52":"0.1720","pricescale":"1000","last":"0.2310","display_name":"$WIN - WELLEX INDUSTRIES, INC."},"WLCON":{"symbol":"WLCON","description":"WILCON DEPOT, INC.","type":"Common","wikhi52":"12.3000","wiklo52":"8.0000","pricescale":"100","last":"11.2000","display_name":"$WLCON - WILCON DEPOT, INC."},"WPI":{"symbol":"WPI","description":"WATERFRONT PHILIPPINES, INC.","type":"Common","wikhi52":"1.3500","wiklo52":"0.5600","pricescale":"100","last":"0.5900","display_name":"$WPI - WATERFRONT PHILIPPINES, INC."},"X":{"symbol":"X","description":"XURPAS INC.","type":"Common","wikhi52":"5.9300","wiklo52":"1.8500","pricescale":"100","last":"1.9100","display_name":"$X - XURPAS INC."},"ZHI":{"symbol":"ZHI","description":"ZEUS HOLDINGS, INC.","type":"Common","wikhi52":"0.2800","wiklo52":"0.1500","pricescale":"1000","last":"0.2100","display_name":"$ZHI - ZEUS HOLDINGS, INC."}};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage';
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
<script src="/assets/js/angular/functions.js?v=1.218"></script>
<script src="/assets/js/angular/controllers.js?v=1.228"></script>
<script src="/assets/js/angular/directives.js?v=1.218"></script>
<script src="/assets/js/angular/filters.js?v=1.218"></script>
<script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
<script src="/assets/js/datafeed.js?v=1.218"></script>
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
		 	// console.log( $('.inpt_data_qty').val() );
		 	var buyprice = $('.inpt_data_price').val();
		 	var buyquanti = $('.inpt_data_qty').val();
		 	console.log(buyprice +" ~ "+ buyquanti);
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
		
		$(".bbs_bull, .bbs_bear").click(function(e){
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
				// console.log(dpathl);

				jQuery.ajax({
				 	method: "POST",
					url: "<?php echo $homeurlgen; ?>/apipge/?daction=sentiment&stock="+dpathl+"&userid=<?php echo $user_id; ?>&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
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
					  console.log(data);

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

			} else {
				console.log('Cant Click');
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
		var dpurprice = $(".inpt_data_price").val();
		var dpurqty = $(".inpt_data_qty").val();

		console.log(dbuypower);
		console.log(dpurprice+"x"+dpurqty+"="+(parseFloat(dpurprice) * parseFloat(dpurqty)));
	
		
		if (parseFloat(dbuypower) < (parseFloat(dpurprice) * parseFloat(dpurqty))) {
			e.preventDefault();
			$(".derrormes").text('You can only purchase a maximum of '+parseInt(dbuypower / dpurprice)+' stocks if the price is ₱'+dpurprice);
			// console.log('You can only purchase a maximum of '+parseInt(dbuypower / dpurprice)+' stocks if the price is 	₱'+dpurprice);
		}else {
			if(x == 1 && y == 1){
			$('.chart-loader').css("display","block");
			$(this).hide();
		 }
		}
	
	});

	});
</script>
</body>
</html>