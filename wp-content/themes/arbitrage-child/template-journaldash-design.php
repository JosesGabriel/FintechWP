<?php
	/*
	* Template Name: Journal Design
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.js"></script>
<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.min.js"></script>

<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>

<link href="../calendar-assets/bootstrap-year-calendar.css" rel="stylesheet">
<link href="../calendar-assets/bootstrap-year-calendar.min.css" rel="stylesheet">

<style type="text/css">
	.hideformodal {
		display:none !important;
	}
    .btn-tradelog {
        border-radius: 0px;
        margin: 10px 0px;
        background: #273647;
        border: 1px solid #273647;
        font-weight: 600;
    }

    .side-header .right-image .onto-user-name {
        margin-bottom: 5px;
        text-transform: capitalize !important;
    }

    .onto-user-name {
    	font-size: 13px;
    	padding-left: 12px;
	    color: #fffffe;
	    padding-top: 10;
	    margin-bottom: 0px !important;
    }

    .table{
    	margin-bottom: 0px !important
    }

	tr.to-watch-data td {
	    display: table-cell;
	    vertical-align: middle;
	    padding:12px 5px;
	    color:#ecf0f1;
		position:relative;

	}
	.to-watch-data {
		border-bottom: #1e3554 solid 1px;
	}
	td.to-stock {
	    margin-left:10px;
	}

	.table td, .table th {
	    border-top:none !important;
	}

	.dbox.red {
	    padding: 6px 7px;
	    background: #eb4d5c;
	    border-radius: 50px;
	}

	.dbox.green {
	    padding: 6px 12px;
	    background: #53b987;
	    border-radius: 50px;
	}

	td.to-stock a {
	    margin-left: 7px;
	}
	.stockperc {
		width: 42px;
		text-align: center;
	}
	.trading-name {
		font-family: 'Nunito', sans-serif;
	    color: #999999;
	    font-size: 13px;
	    padding-left: 10px;
	}
	.one {
		font-weight: 500;
	}
	.two {
		font-weight: 500;
		margin-top: 13px;
	}
	.two a {
		border-radius: 4px;
	}
	.third {
		font-weight: 500;
	}
	.fourth {
		font-weight: 500;
	}
	.five {
		font-weight: 500;
	}
	.side-content-inner {
	    margin-top: 10px !important;
	}
	.site-header {
		padding-bottom: 0px !important;
		margin-bottom: 22px !important;
		padding: 0px 0px 0px 0px !important;
	}
	.active {

	}
	#mingle-btn {
		border-radius: 26px !important;
		border: 1.3px solid #e77e24 !important;
    	padding: 5px 14px !important;
    	font-family: 'Nunito', sans-serif;
    	color: #6583a8;
	}
	#removes-btn {
		border-radius: 26px !important;
		border: 1.3px solid #6583a8 !important;
    	padding: 5px 11px !important;
    	font-family: 'Nunito', sans-serif;
    	color: #6583a8;
    	margin-left: 3px !important;
	}
	a.add-btn {

	}
	.true-name {
		padding-left: 10px;
		font-size: 14px;
		font-weight: 500;
	}
	.following-people {
		width: 33.3%;
	    float: left;
	    text-align: left;
	    font-size: 12px;
	    color: #999999;
	    font-family: 'Nunito', sans-serif;
	    display: inline-block;
	}
	.your-posts {
		width: 28.3%;
	    text-align: left;
	    font-size: 12px;
	    color: #999999;
	    font-family: 'Nunito', sans-serif;
	    display: inline-block;
	    float: left;
	    margin-left: 1px;
	}
	.your-followers {
		width: 31.3%;
	    text-align: left;
	    font-size: 12px;
	    color: #999999;
	    font-family: 'Nunito', sans-serif;
	    display: inline-block;
	}
	.num-followers {
		font-size: 12px;
		color: #fffffe;
	}
	.num-posts {
		font-size: 12px;
		color: #fffffe;
	}
	.num-following {
		font-size: 12px;
		color: #fffffe;
	}
	.top-traiders-inner {
		padding-top: 0px;
   		padding-left: 4px;
	}
	.dplsicon {
		display: inline-block !important;
		float: right;
	}
	.dplsicon a {
		color: #fff
	}
	.um-activity-head {
    	border-radius: 6px 6px 0 0;
		padding-top:13px;
		padding-bottom: 9px !important;
	}
	.um-activity-author-meta {
		padding-top: 4px;
    	padding-left: 11px;
	}
	.hidden-bttn {
		visibility: hidden;
	}
	.hidden-bttn:hover {
		cursor: pointer;
	}
	.traider-inner:hover .hidden-bttn{
		visibility: visible;
	}
	.hidden-bttn {
		color: black;
		font-size: 14px;
		float: right;
	    color: #fff;
	}
	.remm-sm {
	    display: none;
	    margin-top: -1px;
	    position: absolute;
	    background-color: #f9f9f9;
	    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	    z-index: 1;
	    right: 22px;
	    color: #fff;
	    background-color: #2b405b;
	    font-size: 10px;
	    padding: 6px 10px;
	    border-radius: 25px;
	}
	.hidden-bttn:hover .remm-sm {
		display:block;
	}
	.drop-over-post {
		color: #fff;
		font-size: 20px;
		margin-top: 7px;
    	margin-right: 7px;
	}
	.to-content-part {
		background: none;
	}
	.top-stocks .to-content-part ul li.even,
	.watch-list-inner .to-content-part ul li.even {
	    background: none;
	}
	.to-content-part {
    	background: #142c46;
	}
	.um-activity-widget .um-activity-foot.status {
	    background: #142c46;
	    padding: 9px 0px 0px 0px;
	    border: 0 none;
	}
	hr.style15 {
	    border: 0;
	    height: 1px;
	    width: 96%;
	    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
	    margin-top: 0rem !important;
	    margin-bottom: 2.5px !important;
	    display: flex;
	}
	hr.style11 {
	    border: 0;
	    height: 1px;
	    width: 100%;
	    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
	    margin-top: 0.5rem !important;
	    margin-bottom: 1.5px !important;
	    display: flex;
	}
	hr.style10 {
	    border: 0;
	    height: 1px;
	    width: 96%;
	    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
	    margin-top: 10px !important;
	    margin-bottom: 3px !important;
	}
	.top-traiders .to-content-part .trader-item .traider-image {
	    width: 20%;
	    display: inline-block;
	    margin-top: 5px;
	    margin-right: 12px;
	}
	.um-activity-widget .upload {
		padding: 9px 10px;
    	top: -4px;
	}
	.upload.photo-upload-cont:hover {
		background-color: #0d1f33 !important;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish a span.diconbase {
	    background: #2d3d51;
	    padding: 7px 6px;
	    border-radius: 50px;
	    -webkit-transition: all .5s ease-in-out;
	    -moz-transition: all .5s ease-in-out;
	    -o-transition: all .5s ease-in-out;
	    transition: all .5s ease-in-out;
	}
	.um-activity-widget div.um-activity-textarea textarea,
	.um-activity-widget div.um-activity-textarea textarea:hover,
	.um-activity-widget div.um-activity-textarea textarea:focus {
		height: 90px !important;
	    border-radius: 0 !important;
	    padding: 22px 15px 10px 65px !important;
	}
	img.arb_newpostimg {
		width: 41px !important;
	}
	.add-post .um-activity-widget .um-activity-ava a {
	    width: 41px;
	    height: 41px;
	}
	.to-content-part {
    	padding: 5px;
	}
	.um-activity-dialog.um-activity-tool-dialog {display:none;}
	.top-stocks .to-content-part ul li a {
	    display: block;
	    padding: 11px 10px;
	    font-size: 12px;
	    color: #ecf0f1;
	    white-space: nowrap;


	    overflow: hidden;
	    text-overflow: ellipsis;
	}
	/* Calendar Overrides */
	/*.month-container.col-xs-3 {
		border: none;
		border-radius: 5px;
		overflow: hidden;
		background: #142c46;
		background: -moz-linear-gradient(45deg, #0a1c31 0%, #1a3550 100%);
		background: -webkit-linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a1c31', endColorstr='#1a3550',GradientType=1 );
		box-shadow: -7px 8px 8px -3px rgba(4,13,23,0.3);
		padding: 15px 0 0 0px;
		height: 245px;
		width: 23%;
		margin: 0 15px 15px 0px;
	}*/
	.calendar .calendar-header table th {
		font-size: 18px;
		padding: 10px 10px;
	}
	.calendar .calendar-header table th:hover {
		background-color: transparent !important;
		color: #01afc8 !important;
	}
	.calendar .calendar-header {
		width: 100%;
		margin-bottom: 20px;
		background: #142c46;
		background: -moz-linear-gradient(45deg, #0a1c31 0%, #1a3550 100%);
		background: -webkit-linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a1c31', endColorstr='#1a3550',GradientType=1 );
		box-shadow: -7px 8px 8px -3px rgba(4,13,23,0.3);
		border: none;
	}

	/* Journal Overrides */
/*	.inner-placeholder {
		padding-top: 0 !important;
	}*/
	.searchbar input[type="text"] {
    	height: 26px !important;
	}
	.searchbar {margin-left: 3px !important;}
	.left-dashboard-part {padding: 19px 0px 0 !important;}
	.oncommonsidebar .post-content {
		padding: 0 0 0 15px;
	}
	.panel-primary>.panel-heading {
		color: #fff;
		border: none;
		background: transparent;
		padding:0;
	}
	.journaltabs ul.nav.panel-tabs a {
		border-bottom: 3px solid rgba(18, 40, 64, 0.5);
	}
	.journaltabs li {
		width: 33.3%;
		text-align: center;
	}
	.journaltabs .nav>li>a {
		padding: 15px 0;
		border-radius: 6px 6px 0 0;
	}
	.journaltabs .nav>li>a:hover,
	.journaltabs .nav>li>a:focus {
		background-color: rgba(18, 40, 64, 0.8);
	}
	.journaltabs ul.nav.panel-tabs .active a {
		border-bottom: 3px solid #01afc8;
		background-color: rgba(18, 40, 64, 0.5);
		color: #fff;
	}
	.gain_c {
		background-color: rgba(37, 174, 95, 0.5);
	}
	.gain_c:hover {
		background-color: rgba(37, 174, 95, 1) !important;
	}
	.gain_c {
		background-color: rgba(37, 174, 95, 0.5);
	}
	.gain_c:hover {
		background-color: rgba(37, 174, 95, 1) !important;
	}
	.loss_c {
		background-color: rgba(230, 76, 60, 0.5);
	}
	.loss_c:hover {
		background-color: rgba(230, 76, 60, 1) !important;
	}
	.blue_c {
		background-color: rgba(69, 166, 255,0.5);
	}
	.blue_c:hover {
		background-color: rgba(69, 166, 255,1.0) !important;
	}
	.box-portlet {
		border: none;
		border-radius: 5px;
		overflow: hidden;
		background: #142c46;
		background: -moz-linear-gradient(45deg, #0a1c31 0%, #1a3550 100%);
		background: -webkit-linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a1c31', endColorstr='#1a3550',GradientType=1 );
		box-shadow: -7px 8px 8px -3px rgba(4,13,23,0.3);
	}
	.box-portlet-header, .box-portlet-footer {
		background: transparent;
		font-weight: bold;
		padding: 13px 17px 0px 17px;
		font-size: 17px;
		text-align: left;
	}
	.nav>li>a {
		color: #999;
	}
	.box-portlet-content {
		padding: 15px;
	}
	.panel-primary {
		border: none;
		background: transparent;
	}
	.inner-center-dashboard {margin-top: 27px;}
	.panel-body {padding: 15px 0;}
	.inner-portlet .inner-portlet-title {
    	background: #213f58;
	}
	.dstatstrade ul li.headerpart {
		background: rgba(36, 65, 90, 0.4) !important;
		padding: 10px 15px;
		margin-bottom: 0;
	}
	.dstatstrade ul li {
		line-height: 150%;
		padding: 5px 5px 5px 15px;
		font-size: 12px;
		border-bottom: 1px solid #18314a;
	}
	.inner-portlet-content {
		font-size: 12px !important;
		line-height: 150% !important;
	}
	.box_inner_adjust {
		padding: 15px !important;
		background-color: rgba(33, 63, 88, 0.5);
		border-radius: 5px;
		line-height: 180% !important;
	}

	/* AMChart */
	.amcharts-main-div a {display:none !important;}
	.piemp_override {
		padding: 0px;
		background-color: #0d1f33;
		border-radius: 5px;
		margin-top: 35px;
		min-height: 215px;
		padding-top: 9px;
	}
	#chartdiv1 {
		width: 100%;
		height: 230px;
	}
	#chartdiv1 .amcharts-main-div {
		margin-top: -37px;
	}
	#chartdiv2 {
		width: 100%;
		height: 250px;
	}
	#chartdiv3 {
		width: 100%;
		height: 200px;
	}
	#chartdiv4a {
		width: 100%;
		height: 220px;
	}
	#chartdiv4b {
		width: 100%;
		height: 260px;
	}
	#chartdiv5 {
		width: 100%;
		height: 260px;
	}
	#chartdiv6 {
		width: 100%;
		height: 233px;
	}
	#chartdiv7 {
		width: 100%;
		height: 200px;
	}
	#chartdiv8 {
		width: 100%;
		height: 200px;
	}
	#chartdiv9 {
		width: 100%;
		height: 200px;
	}
	#chartdiv10 {
		width: 100%;
		height: 200px;
	}
	#chartdiv11 {
		width: 100%;
		height: 200px;
	}
	#topstockswinners {
		width: 100%;
		height: 230px;
	}
	#topstocksLosers {
		width: 100%;
		height: 230px;
	}
	.hidethis {
		display:none !important;
	}
	.tradelogbox {
		max-width:450px;
		width:100%;
	}

	/* Minitable overrides */
	.widthfull, .widthhalf, .width60, .width40 {display: inline-block;}
	.widthfull {width: 100% !important;}
	.widthhalf {width: 50% !important;}
	.width60 {width: 60% !important;}
	.width48 {width: 48% !important;}
	.width40 {width: 40% !important;}
	.width35 {
		width: 35% !important;
		text-align: right;
	}
	.dstatstrade ul li:hover {
		background: rgba(10, 29, 50, 0.5);
	}
	.inner-portlet .inner-portlet-content {
    	padding: 0;
	}
	.bulletclrd {
		border-radius: 50px;
		height:10px;
		width:10px;
		display:inline-block;
		margin-right: 5px;
	}
	.bulletclrd.clrg1 {background-color: #25ae5f; } /* green 1 */
	.bulletclrd.clrg2 {background-color: #49bb79; } /* green 2 */
	.bulletclrd.clrg3 {background-color: #a9f7ae; } /* green 3 */

	.bulletclrd.clrr1 {background-color: #e64c3c; } /* red 1 */
	.bulletclrd.clrr2 {background-color: #ec5f50; } /* red 2 */
	.bulletclrd.clrr3 {background-color: #ef7062; } /* red 3 */

	.bulletclrd.clrb1 {background-color: #1590ff; } /* blue 1 */
	.bulletclrd.clrb2 {background-color: #4faafc; } /* blue 2 */
	.bulletclrd.clrb3 {background-color: #87c3f9; } /* blue 3 */

	.bulletclrd.clrg1 {background-color: #25ae5f; } /* green 1 */
	.bulletclrd.clrg2 {background-color: #49bb79; } /* green 2 */
	.bulletclrd.clrg3 {background-color: #a9f7ae; } /* green 3 */

	.dstatstrade.overridewidth ul li div {
		width: auto;
	}

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
	input[type="submit"].green {
		border: #27ae60 solid 2px !important;
	    background: none;
	    line-height: 29px;
	    font-weight: bold;
	    font-size: 12px;
	    padding: 0 12px;
	    border-radius: 25px;
	    color: #fff;
	    cursor: pointer;
	    font-family: 'Roboto', sans-serif;
	    display: inline-block;
	}
	.confirmtrd:hover,
	input[type="submit"].green:hover {
		background-color: #e64c3c;
		color: #fff;
		text-decoration:none;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out;
		transform: scale(1.07);
	}
	.confirmtrd,
	input[type="submit"].red {
		background: none;
	    line-height: 29px;
	    font-weight: bold;
	    font-size: 12px;
	    padding: 0 12px;
	    border-radius: 25px;
	    color: #fff;
	    cursor: pointer;
	    font-family: 'Roboto', sans-serif;
	    display: inline-block;
	}
	.confirmtrd:hover,
	input[type="submit"].red:hover {
		background-color: #e64c3c;
		color: #fff;
		text-decoration:none;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out;
		transform: scale(1.07);
	}
	div#fancybox-overlay {
		background-color: rgb(0, 0, 0) !important;
	}

	.confirmtrd.green {
		background-color: none;
		border: 2px solid #27ae60 !important;
	}
	.confirmtrd.green:hover {
		background-color: #27ae60 !important;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out;
		transform: scale(1.07);
	}
	.confirmtrd.red {
		background-color: none;
		border: 2px solid #e64c3c !important;
	}
	.confirmtrd.red:hover {
		background-color: #e64c3c !important;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		transition: all .5s ease-in-out;
		transform: scale(1.07);
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
		font-size: 11px;
		border-radius: 4px;
		font-weight: normal;
		text-decoration:none;
		-webkit-transition: all .1s ease-in-out;
	    -moz-transition: all .1s ease-in-out;
	    -o-transition: all .1s ease-in-out;
	    transition: all .1s ease-in-out;
	}
	a.smlbtn.blue {
		line-height: 19px;
		padding: 0;
		width: 23px;
		height: 23px;
		text-align: center;
		border: 2px solid #3597d3;
		background-color: transparent;
		border-radius: 20px;
		color: #fff;
		font-size: 10px;
	}
	a.smlbtn.blue:hover {
		background-color: #3597d3;
		color:#FFFFFF;
	}
	.smlbtn.green {
		background-color: transparent;
		border: 2px solid #27ae60;
		color: #ffffff;
		margin-right: -5p;
		line-height: 14px;
		border-radius: 15px;
		padding: 2px 6px 2px 6px;
		width: 47px;
		text-align: center;
	}
	a.smlbtn.green:hover {
		background-color: #27ae60;
		color:#FFFFFF;
	}
	a.smlbtn.red {
		background-color: transparent;
		border: 2px solid #e64c3c;
		color: #fff;
		margin-right: 0;
		line-height: 14px;
		border-radius: 15px;
		padding: 2px 7px;
		width: 47px;
		text-align: center;
	}
	a.smlbtn.red:hover {
		background-color: #e64c3c;
		color:#FFFFFF;
	}
	a.smlbtn:hover {
		background-color: #bb3527;
	}
	/* .dstatstrade ul li div {color:#fff;} */
	.dstatstrade.overridewidth ul li div.ddetailshere,
	.dstatstrade.overridewidth ul li div.ddetailshere .inner {
		width: 100%;
	}
	.dstatstrade.overridewidth ul li div.ddetailshere table {
	    display: block;
	    width: 100%;
	}
	.dspecitem .ddetailshere {
		display: none;
	}
	.txtgreen {color: #27ae60 !important;}
	.txtred {color: #e64c3c !important;}
	.entr_ttle_bar {color:#fff;}
	.trdlgsbox {
		color:#FFFFFF;
		padding:10px;
	}
	.trdleft {
		width:50%;
		float:left;
	}
	.trdright {
		width:50%;
		float:left;
	}
	.trdclr {
		clear:both;
	}
	.darkbgpadd {
		background-color: #34495e;
		padding: 12px 15px;
		border-radius: 6px;
	}
	.onelnetrd {
		line-height: 25px;
	}
	.onelnetrd span {
		display:inline-block;
		line-height: 32px;
	}
	.onelnetrd > span {
		width:105px;
	}
	.dredpart {
	    color: #e44c3c !important;
	}
	.dgreenpart {
	    color: #27ae60 !important;
	}
	.dltbutton {
		width: auto;
    	float: right;
	}
	.delete-data-btn {
		float: right;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #f1f3f4;
	    background: none;
	    border: 2px #e91e63 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px;
	}
	.enter-trade-btn {
		float: right;
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #ffffff;
	    background: none;
	    border: 2px #00bcd4 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px;
	}
	.dbuttondelete {
		display: inline-block;
	}
	.dbuttonenter {
		display: inline-block;
	}
	input.delete-data-btn:hover {
	    background: #e91e63;
	    transition: all .3s ease-out;
	}
	input.enter-trade-btn:hover {
	    background: #00bcd4;
	    transition: all .3s ease-out;
	}
	.dividend-btn {
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #6583a8 !important;
	    background: none;
	    border: 1px #6583a8 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px 4px 9px;
	    font-weight: 500;
	    text-decoration: none;
	}
	.dividend-btn:hover {
		color: #fff;
		text-decoration: none;
	    background: #123;
	    transition: all .3s ease-out;
	}
	.deposit-btn {
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #6583a8 !important;
	    background: none;
	    border: 1px #6583a8 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px 4px 9px;
	    font-weight: 500;
	    text-decoration: none;
	    margin-right: 3px
	}
	.deposit-btn:hover {
		color: #fff;
		text-decoration: none;
	    background: #123;
	    transition: all .3s ease-out;
	}
	.deposit-modal-btn {
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #6583a8 !important;
	    background: none;
	    border: 1px #6583a8 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 5px 9px 4px 9px;
	    font-weight: 500;
	    text-decoration: none;
	    margin-right: 3px;
	    cursor: pointer;
	}
	.deposit-modal-btn:hover {
		color: #fff;
		text-decoration: none;
	    background: #123;
	    transition: all .3s ease-out;
	}
	.withdraw-btn {
	    font-family: 'Roboto', sans-serif;
	    font-size: 12px;
	    color: #6583a8 !important;
	    background: none;
	    border: 1px #6583a8 solid;
	    height: auto;
	    border-radius: 25px;
	    padding: 3px 9px 4px 9px;
	    font-weight: 500;
	    text-decoration: none;
	}
	.withdraw-btn:hover {
		color: #fff;
		text-decoration: none;
	    background: #123;
	    transition: all .3s ease-out;
	}
	.modal-content {
		background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
	}

	/* New CSS */
	.box-portlet-header {
		font-family: 'Montserrat', sans-serif;
		font-weight: 700;
		line-height: 18px;
	}
	.box-portlet-header span {
		font-size: 13px;
		font-weight: 300;
		font-family: 'Roboto', Arial;
	}
	.dstatsemo ul li div {
		width:19% !important;
	}
	.amcharts-pie-slice {
		transform: scale(1.2);
		transform-origin: 50% 50%;
		transition-duration: 0.3s;
		transition: all .3s ease-out;
		-webkit-transition: all .3s ease-out;
		-moz-transition: all .3s ease-out;
		-o-transition: all .3s ease-out;
		cursor: pointer;
		box-shadow: 0 0 30px 0 #000;
	}

	.amcharts-pie-slice:hover {
		transform: scale(1.3);
		filter: url(#shadow);
	}
	.dstatstrade.eqpad ul li {
		line-height: 150%;
		padding: 5px !important;
	}
</style>
<?php
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
?>
<!-- BOF Deposit -->
<?php
	if (isset($_POST['istype'])) {

		if ($_POST['damount'] > 0) {
			$wpdb->insert('arby_ledger', array(
			    'userid' => get_current_user_id(),
			    'date' => $_POST['ddate'],
			    'trantype' => $_POST['istype'],
			    'tranamount' => $_POST['damount'], // ... and so on
			));
		}



		wp_redirect( '/journal' );
		exit;
	}
?>
<!-- EOF Deposit -->


<!-- BOF BUY trades -->
<?php
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
			if ($dstocktraded && $dstocktraded != "") {
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
			}


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
		$dtotalpurchse =  $_POST['inpt_data_price'] * $_POST['inpt_data_qty'];
		echo $dtotalpurchse;

		$stockcost = ($_POST['inpt_data_price'] * $_POST['inpt_data_qty']);
		$purchasefee = getfees($stockcost, 'buy');

		$wpdb->insert('arby_ledger', array(
			    'userid' => get_current_user_id(),
			    'date' => date('Y-m-d'),
			    'trantype' => 'purchase',
			    'tranamount' => $stockcost + $purchasefee, // ... and so on
			));




		wp_redirect( '/chart/'.$tradeinfo['stock'] );
		exit;

	}
?>
<!-- EOF BUY trades -->

<!-- BOF SELL trades -->
<?php
	if( isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == "Log" ){

		// echo "<pre>";
		// 	print_r($_POST);
		// echo "</pre>";

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

				'data_isdateofw'		=> date('l'),

				'data_stock'		=> $_POST['inpt_data_stock'],
				'data_dprice'		=> $_POST['inpt_data_price'],

				'data_sell_price'	=> $_POST['inpt_data_sellprice'],
				'data_quantity'		=> $_POST['inpt_data_qty'],
				'data_avr_price'	=> $_POST['inpt_avr_price'],

				'data_trade_info'	=> $_POST['dtradelogs'],
				'data_userid'		=> get_current_user_id()
			)
		);
		$dstocktraded['totalstock'] = $dstocktraded['totalstock'] - $_POST['inpt_data_qty'];

		wp_insert_post( $journalpostlog );
		if ($dstocktraded['totalstock'] <= 0) {
			$dlisroflive = get_user_meta(get_current_user_id(), '_trade_list', true);
			foreach ($dlisroflive as $rmkey => $rmvalue) {
				if ($rmvalue == $_POST['inpt_data_stock']) {
					unset($dlisroflive[$rmkey]);
					delete_user_meta(get_current_user_id(), '_trade_'.$_POST['inpt_data_stock']);
				}
			}
			update_user_meta(get_current_user_id(), '_trade_list', $dlisroflive);
		} else {
			// Update existing data.

			update_user_meta(get_current_user_id(), '_trade_'.$_POST['inpt_data_stock'], $dstocktraded);
		}

		$stockcost = ($_POST['inpt_data_sellprice'] * $_POST['inpt_data_qty']);
		$purchasefee = getfees($stockcost, 'sell');

		$wpdb->insert('arby_ledger', array(
			    'userid' => get_current_user_id(),
			    'date' => date('Y-m-d'),
			    'trantype' => 'selling',
			    'tranamount' => $stockcost - $purchasefee, // ... and so on
			));

		wp_redirect( '/journal' );
		exit;

	}
?>
<!-- EOF SELL trades -->
<?php
	$getdstocks = get_user_meta(get_current_user_id(), '_trade_list', true);

	// $curl = curl_init();
	// curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes');
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	// $gerdqoute = curl_exec($curl);
	// curl_close($curl);
	//
	// $gerdqoute = json_decode($gerdqoute);
	$gerdqoute = [];
?>
<!-- BOF get the tradelogs -->
<?php
	$author_query = array(
		'posts_per_page' => '-1',
		'meta_key' => 'data_userid',
		'meta_value'  => get_current_user_id()
	);
	$author_posts = new WP_Query($author_query);
?>
<!-- EOF get the tradelogs -->



<!-- BOF SORT DATA FOR JOURNAL -->
<?php
	$alltradelogs = [];
	if ( $author_posts->have_posts() ) {
		while ( $author_posts->have_posts() ) { $author_posts->the_post();
			$tradeitems = [];
			$tradeitems['id'] = get_the_ID();
			$tradeitems['data_sellmonth'] = get_post_meta(get_the_ID(), 'data_sellmonth', true);
			$tradeitems['data_sellday'] = get_post_meta(get_the_ID(), 'data_sellday', true);
			$tradeitems['data_sellyear'] = get_post_meta(get_the_ID(), 'data_sellyear', true);

			$tradeitems['data_stock'] = get_post_meta(get_the_ID(), 'data_stock', true);
			$tradeitems['data_dprice'] = get_post_meta(get_the_ID(), 'data_dprice', true);

			$tradeitems['data_sell_price'] = get_post_meta(get_the_ID(), 'data_sell_price', true);
			$tradeitems['data_quantity'] = get_post_meta(get_the_ID(), 'data_quantity', true);
			$tradeitems['data_quantity'] = get_post_meta(get_the_ID(), 'data_quantity', true);

			$data_avr_price = get_post_meta(get_the_ID(), 'data_avr_price', true);
			$dlistofinfo = json_decode(get_post_meta(get_the_ID(), 'data_trade_info', true));

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
	} else {}

	// Months
	$months = array('January','February','March','April','May','June','July ','August','September','October','November','December');
?>
<!-- EOF SORT DATA FOR JOURNAL -->

<!-- BOF Sort LIVE Portfolio -->
<?php
if ($getdstocks && $getdstocks != "") {
	$dtradeingfo = [];
	foreach ($getdstocks as $dstockskey => $dstocksvalue) {
		$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$dstocksvalue, true);
		if ($dstocktraded && $dstocktraded != "") {
			$dstockinfo = $gerdqoute->data->$dstocksvalue;
			$marketval = $dstockinfo->last * $dstocktraded['totalstock'];
			$dsellfees = getfees($marketval, 'sell');
			$dtotal = $marketval - $dsellfees;

			$dstocktraded['totalcost'] = $dtotal;
			$dstocktraded['stockname'] = $dstocksvalue;
			array_push($dtradeingfo, $dstocktraded);
		}

	}
}

?>
<!-- EOF Sort LIVE Portfolio -->
<!-- BOF Ledger Data -->
<?php
	$duseridmo = get_current_user_id();
	$dledger = $wpdb->get_results( "SELECT * FROM arby_ledger where userid = ".$duseridmo);

	$buypower = 0;
	foreach ($dledger as $getbuykey => $getbuyvalue) {
		if ($getbuyvalue->trantype == 'deposit' || $getbuyvalue->trantype == 'selling') {
			$buypower = $buypower + $getbuyvalue->tranamount;
		} else{
			$buypower = $buypower - $getbuyvalue->tranamount;
		}
	}
?>
<!-- BOF Current Allocation Data -->
<?php
	$dequityp = $buypower;

	$aloccolors = array("#5c65c6","#925cc6","#735cc6","#c65c9a","#b35cc6","#c65cb9","#5ca4c6","#78bddd");
	$currentalocinfo = '{"category" : "Cash", "column-1" : "'.number_format( $buypower, 2, '.', '' ).'"},';
	$currentaloccolor = '"#5c65c6",';
	if ($dtradeingfo) {
		foreach ($dtradeingfo as $trinfokey => $trinfovalue) {
			$dinforstocl = $trinfovalue["stockname"];
			$dstockinfo = $gerdqoute->data->$dinforstocl;
			$marketval = $dstockinfo->last * $dstocktraded['totalstock'];
			$dsellfees = getfees($marketval, 'sell');
			$dtotal = $marketval - $dsellfees;

			$dequityp += $dtotal;
			$currentalocinfo .= '{"category" : "'.$trinfovalue["stockname"].'", "column-1" : "'.number_format( $trinfovalue["totalcost"], 2, '.', '' ).'"},';
			$currentaloccolor .= '"'.$aloccolors[$trinfokey + 1].'",';
		}
	}

?>
<!-- EOF Current Allocation Data -->


<!-- Delete Data -->
<?php
	if (isset($_POST) && $_POST['deletedata'] == "Reset Data") {
		$dlistofstocks = get_user_meta(get_current_user_id(), '_trade_list', true);

		// Delete Live Trade
		foreach ($dlistofstocks as $delkey => $delvalue) {
			update_user_meta(get_current_user_id(), '_trade_'.$delvalue, '');
			delete_user_meta(get_current_user_id(), '_trade_'.$delvalue);

			// $dsotcksss = get_user_meta(get_current_user_id(), '_trade_'.$delvalue, true);
		}
		delete_user_meta(get_current_user_id(), '_trade_list');

		// delete all trade logs
		foreach ($alltradelogs as $delpostkey => $delpostvalue) {
			echo $delpostvalue['id']."~";
			wp_delete_post( $delpostvalue['id'], true);
		}

		//delete ledger
		$wpdb->get_results( "delete from arby_ledger where userid = ".get_current_user_id());

		wp_redirect( '/journal' );
		exit;

	}
?>
<!-- Delete Data -->
<!-- EOF Ledger Data -->
<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                    	<?php echo get_template_part( 'parts/sidebar', 'profile' ); ?>
                    	 <?php get_template_part('parts/sidebar', 'traders'); ?>
					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 900px !important;">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    <span class="journaltabs">
						                        <!-- Tabs -->
						                        <ul class="nav panel-tabs">
						                            <li class="active"><a href="#tab1" data-toggle="tab" class="active show">Dashboard</a></li>
						                            <li class=""><a href="#tab2" data-toggle="tab">Tradelogs</a></li>
						                            <li class=""><a href="#tab3" data-toggle="tab" class="">Ledger</a></li>
						                            <!-- <li class=""><a href="#tab4" data-toggle="tab" class="">Calendar</a></li> -->
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane show active" id="tab1">

                                                    <div class="liveportfoliobox">
                                                        <div class="box-portlet">
                                                        	<?php
                                                        		function date_lvp_sort($a, $b) {
																    return strtotime($a->date) - strtotime($b->date);
																}
																usort($dledger, "date_lvp_sort");
                                                        		$dbaseaccount = 0;
                                                        		$porttotaldep = 0;
                                                        		$porttotalwid = 0;

                                                        		foreach ($dledger as $dbaseledgekey => $dbaseledgevalue) {
                                                        			if ($dbaseledgevalue->trantype == "deposit") {
                                                        				$dbaseaccount = $dbaseaccount + $dbaseledgevalue->tranamount;
                                                        				$porttotaldep += $dbaseledgevalue->tranamount;
                                                        			} elseif($dbaseledgevalue->trantype == "withraw") {
                                                        				$dbaseaccount = $dbaseaccount - $dbaseledgevalue->tranamount;
                                                        				$porttotalwid += $dbaseledgevalue->tranamount;
                                                        			}
                                                        		}


                                                        		// echo $dbaseaccount;
                                                        	?>
                                                        	<!-- <div class="dltbutton">
                                                        		<div class="dbuttondelete">
                                                        			<form action="/journal" method="post">
                                                        				<input type="submit" name="deletedata" value="Reset Data">
                                                        			</form>
                                                        		</div>
                                                        	</div> -->
                                                            <div class="box-portlet-header">
                                                                Live Portfolio
                                                                <div class="dltbutton">
                                                        		<div class="dbuttondelete">
                                                        			<form action="/journal" method="post">
                                                        				<input type="submit" name="deletedata" value="Reset Data" class="delete-data-btn">
                                                        			</form>
                                                        		</div>
                                                        		<div class="dbuttonenter">
                                                        			<form action="" method="post">
                                                        				<input type="submit" name="entertradebtn" value="Enter Trade" class="enter-trade-btn">
                                                        			</form>
                                                        		</div>
                                                        	</div>
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <div class="dstatstrade overridewidth">
                                                                        <ul>
                                                                            <li class="headerpart">
                                                                            	<div style="width:100%;">
                                                                                    <div style="width:8%">Stocks</div>
                                                                                    <div style="width:9%">Position</div>
                                                                                    <div style="width:11%">Average Price</div>
                                                                                    <div style="width:11%">Total Cost</div>
                                                                                    <div style="width:11%">Market Value</div>
                                                                                    <div style="width:11%">Profit</div>
                                                                                    <div style="width:9%">Performance</div>
                                                                                    <div style="width:112px; text-align:center;">Action</div>
                                                                                    <div style="width:45px; text-align: right;">Notes</div>
                                                                                </div>
                                                                            </li>
                                                                            <?php
                                                                            if ($getdstocks) {
                                                                            	foreach ($getdstocks as $key => $value) {
															            			$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$value, true);
															            			if ($dstocktraded && $dstocktraded != "") {
															            				# code...

															            			$dstockinfo = $gerdqoute->data->$value;

															            			$totalmarketvalue = 0;
															            			$dtotalcosts = 0;
															            			$dselltotal = 0;
															            			$intcost = 0;
															            			$totalquanta = 0;
															            			foreach ($dstocktraded['data'] as $dtradeissuekey => $dtradeissuevalue) {
															            				$dmarketvalue = $dtradeissuevalue['price'] * $dtradeissuevalue['qty'];
															            				$dfees = getfees($dmarketvalue, 'buy');
															                			$totalmarketvalue += $dmarketvalue;
															                			$dtotalcosts += $dmarketvalue + $dfees;
															                			$totalquanta += $dtradeissuevalue['qty'];
															                			$intcost = $dtradeissuevalue['price'];
															            			}

															            			$dsellmarket = $dstockinfo->last * $dstocktraded['totalstock'];
															            			$dsellfees = getfees($dsellmarket, 'sell');
															            			$dselltotal += $dsellmarket - $dsellfees;

															            			$totalfixmarktcost = $dstocktraded['totalstock'] * $dstocktraded['aveprice'];
															            			// $totalfinalcost = $totalfixmarktcost + getfees($totalfixmarktcost, 'buy');

															            			$totalbuyfee = getfees($totalfixmarktcost, 'buy');
															            			$totalfinalcost = $totalfixmarktcost - $totalbuyfee;

															            			$dprofit = ($dselltotal - $totalfixmarktcost);
															            			$profpet = (abs($dprofit) / $totalfixmarktcost) * 100;
																	            	?>
																	            	<li>
		                                                                            	<div style="width:99%;">
		                                                                                    <?php /*?><div data-invest="<?php echo $intcost; ?>" style="width:4%"><?php echo $key + 1; ?></div><?php */?>
		                                                                                    <div style="width:8%;color: #fffffe;"><a target="_blank" href="/chart/<?php echo $value; ?>"><?php echo $value; ?></a>	</div>
		                                                                                    <div style="width:9%"><?php echo number_format($dstocktraded['totalstock'], 0, '.', ',' ); ?></div>
		                                                                                    <div style="width:11%">&#8369;<?php echo number_format( $dstocktraded['aveprice'], 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:11%">&#8369;<?php echo number_format( $totalfixmarktcost, 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:11%">&#8369;<?php echo number_format( $dselltotal, 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:11%" class="<?php echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart'); ?>">&#8369;<?php echo number_format( $dprofit, 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:9%" class="<?php echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart'); ?>"><?php echo ($dprofit < 0 ? '-' : '') ?><?php echo number_format( $profpet, 2, '.', ',' ); ?>%</div>
		                                                                                    <div style="width:112px;text-align:center;"><?php /*?>Action<?php */?>
		                                                                                        <a href="#entertrade_<?php echo $value; ?>" class="smlbtn fancybox-inline green" style="border: 0px;color:#27ae60;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#27ae60'">BUY</a>
		                                                                                        <a href="#selltrade_<?php echo $value; ?>" class="smlbtn fancybox-inline red" style="border: 0px;color:#e64c3c;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#e64c3c'">SELL</a>
		                                                                                        <div class="hideformodal">
		                                                                                        	<div class="selltrade" id="selltrade_<?php echo $value; ?>">

																			                            <div class="entr_ttle_bar">
																			                                <strong>Sell Trade</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
																			                            </div>

																			                            <form action="/journal" method="post">

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
																			                                    	<div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" name="inpt_avr_price_b"
																			                                        value="&#8369;<?php echo number_format( $dstocktraded['aveprice'], 2, '.', ',' ); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

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
																			                                    <input type="hidden" value="<?php echo $dstocktraded['aveprice']; ?>" name="inpt_avr_price">
																			                                    <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
																			                                    <input type="hidden" name="dtradelogs" value='<?php echo json_encode($dstocktraded['data']); ?>'>
																			                                    <input type="submit" class="confirmtrd red" value="Confirm trade">
																			                                </div>

																			                             </div>

																			                            </form>
																			                        </div>
		                                                                                        	<div class="entertrade" id="entertrade_<?php echo $value; ?>">
																	                                    <div class="entr_ttle_bar">
																	                                        <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
																	                                    </div>
																	                                    <form action="/journal" method="post">
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
																	                                                <div class="groupinput midd lockedd"><label>Buy Power</label>
																	                                                <input type="text" name="input_buy_product" id="input_buy_product" style="margin-left: -3px;" value="<?php echo $buypower; ?>" readonly>
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
																	                                            <!-- <div>this is it</div> -->
																	                                        </div>
																	                                        <div class="groupinput">
																	                                            <input type="hidden" value="Live" name="inpt_data_status">
																	                                            <input type="submit" class="confirmtrd green" value="Confirm trade">
																	                                        </div>
																	                                     </div>
																	                                    </form>
																	                                </div>
		                                                                                        </div>
		                                                                                    </div>
		                                                                                    <div style="width:40px; text-align: right;"><?php /*?>Notes<?php */?>
		                                                                                    	<a href="#tradingnotes_JFC" class="smlbtn blue fancybox-inline">
		                                                                                    		<i class="fa fa-sticky-note-o" aria-hidden="true"></i>
		                                                                                    	</a>
		                                                                                    </div>
		                                                                                </div>
		                                                                            </li>

																	            	<?php
																	            }// if
																	            		} // foreach
																	            	} else{ // if ?>
																	            		<li style="text-align: center;">
																	            			<p>No Live Portfolio yet</p>
																	            		</li>
																	            	<?php }
																	            	?>


                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                	<br class="clear">
                                                	<?php
                                                		$disyear = date('Y');
                                                		$dismonth = date('n');
                                                		$dmonths = [];
                                                		for ($i=1; $i <= $dismonth; $i++) {
                                                			$dmonnum = sprintf("%02d", $i);

                                                			$dateObj = DateTime::createFromFormat('!m', $dmonnum);
                                                			$monthName = $dateObj->format('F');

                                                			array_push($dmonths, $monthName);
                                                		}

                                                		$dlistofsells = [];
                                                		$dtotalpl = 0;
                                                		foreach ($dmonths as $dmonprofkey => $dmonprofvalue) {
                                                			foreach ($alltradelogs as $dlogsmkey => $dlogsmvalue) {
                                                				if ($dmonprofvalue == $dlogsmvalue['data_sellmonth'] && $disyear == $dlogsmvalue['data_sellyear']) {
                                                					array_push($dlistofsells, $dlogsmvalue);

                                                					$dcurprice = $dlogsmvalue['data_quantity'] * str_replace("₱", "", $dlogsmvalue['data_avr_price']);
                                                					$selprice = $dlogsmvalue['data_quantity'] * str_replace("₱", "", $dlogsmvalue['data_sell_price']);
                                                					$sellfee = getfees($selprice, 'sell');

                                                					$dtotalpl += (($selprice - $sellfee) - $dcurprice);
                                                				}
                                                			}
                                                		}


                                                	?>
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
                                                                                                    <div class="width35">₱<?php echo number_format($dledger[0]->tranamount, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrg2"></span>Year to Date P/L</div>
                                                                                                    <div class="width35">₱<?php echo number_format($dtotalpl, 2, '.', ','); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60"><span class="bulletclrd clrg3"></span>Portfolio YTD %</div>
                                                                                                    <div class="width35">
                                                                                                    	<?php
                                                                                                    		if ($dtotalpl > 0) {
                                                                                                    			echo number_format((($dtotalpl / $dequityp) * 100), 2, '.', ',');
                                                                                                    		} else {
                                                                                                    			echo '0.00';
                                                                                                    		}


                                                                                                    	?>%</div>
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

															</div>
														</div>
														<div class="col-md-5">
															<div class="box-portlet" style="height:208px;">
																<div class="box-portlet-header" style="text-align:center;">
																	Current Allocation
																</div>
																<div class="box-portlet-content" style="padding:4px 14px 0">
																	<div class="row">
																		<div id="chartdiv1"></div>
																		<br class="clear">
																	</div>
																</div>

															</div>
														</div>
													</div>
													<br class="clear">

                                                    <div class="_adsbygoogle">
														<div class="box-portlet" style="background:none !important; box-shadow: none !important; overflow:visible';">

															<div class="box-portlet-content" style="padding:0;">
                                                            	<?php /*?><small>ADVERTISEMENT</small><?php */?>
																<div class="adscontainer" style="text-align:center;">
                                                                	<img src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png" style="box-shadow: -7px 8px 8px -3px rgba(4,13,23,0.3);">
                                                                </div>
															</div>
														</div>
													</div>
													<br class="clear">

                                                    <?php
                                                    	$percaspermonth = [];
                                                    	foreach ($month as $monfkey => $monfvalue) {
                                                    		$dinpart = [];
                                                    		$dinpart['ismonth'] = date('M', strtotime($monfvalue));
                                                    		$dinpart['performance'] = 0;
                                                    		$dinpart['isperc'] = "";
                                                    		foreach ($alltradelogs as $atlkey => $atlvalue) {
                                                    			if ($atlvalue['data_sellmonth'] == $monfvalue) {
                                                    				$sellprice = $atlvalue['data_quantity'] * str_replace("₱", "", $atlvalue['data_sell_price']);
                                                    				$projectprice = $atlvalue['data_quantity'] * str_replace("₱", "", $atlvalue['data_avr_price']);
                                                    				$sellfee = getfees($sellprice, 'sell');

                                                    				$istotal = ($sellprice - $sellfee) - $projectprice;
                                                    				$dinpart['performance'] += $istotal;
                                                    				$dinpart['isperc'] = ($istotal > 0 ? "win" : "loss");
                                                    			}
                                                    		}
                                                    		array_push($percaspermonth, $dinpart);
                                                    	}

                                                    	$monthperc = "";
                                                    	foreach ($percaspermonth as $spmkey => $spmvalue) {
                                                    		$monthperc .= '{';
																$monthperc .= '"category": "'.$spmvalue['ismonth'].'",';
																$monthperc .= '"column-1": "'.$spmvalue['performance'].'"';
															$monthperc .= '},';
                                                    	}

                                                    	$ismpwin = 0;
                                                    	$ismplost = 0;
                                                    	foreach ($alltradelogs as $atlkey => $tmvalue) {
                                            				$sellprice = $tmvalue['data_quantity'] * str_replace("₱", "", $tmvalue['data_sell_price']);
                                            				$projectprice = $tmvalue['data_quantity'] * str_replace("₱", "", $tmvalue['data_avr_price']);
                                            				$sellfee = getfees($sellprice, 'sell');

                                            				$istotal = ($sellprice - $sellfee) - $projectprice;


                                            				if ($istotal > 0) {
                                            					$ismpwin++;
                                            				} else {
                                            					$ismplost++;
                                            				}
                                                		}
                                                    ?>
													<div class="row monthly">
														<?php
															// get lits of combi strats
															$lisfofcombi = [];
															foreach ($alltradelogs as $sskey => $ssvalue) {
																$dinfor = [];

																$dinfor['stratplan'] = "";
																foreach ($ssvalue['strategy_plans'] as $stratkey => $stratvalue) {
																	if ($stratvalue != "") {
																		$dinfor['stratplan'] = $stratvalue;
																		break;
																	}
																}

																$dinfor['emots'] = "";
																foreach ($ssvalue['emotions'] as $emokey => $emovalue) {
																	if ($emovalue != "") {
																		$dinfor['emots'] = $emovalue;
																		break;
																	}
																}
																$dinfor['stops'] = str_replace(" ", "_", $dinfor['stratplan'])."_".str_replace(" ", "_", $dinfor['emots']);
																$sbp = str_replace('₱', '', $ssvalue['data_avr_price']);

																$dsellprice = $ssvalue['data_sell_price'] * $ssvalue['data_quantity'];
																$dbaseprice = $sbp * $ssvalue['data_quantity'];
																$sellfee = getfees($dsellprice, 'sell');

																$isprofit = ($dsellprice - $sellfee) - $dbaseprice;

																$dinfor['iswin'] = ($isprofit > 0 ? 'win' : 'loss');
																array_push($lisfofcombi, $dinfor);

															}

															// partial list of strats
															$dstrats = [];
															foreach ($lisfofcombi as $combikey => $combivalue) {
																array_push($dstrats, $combivalue['stops']);
															}
															$dstrats = array_unique($dstrats);

															$finaldstrats = [];
															foreach ($dstrats as $dxstrkey => $dxstrvalue) {
																$dwinls = [];
																$dwinls['wincount'] = 0;
																$dwinls['losscount'] = 0;
																$dwinls['tradecount'] = 0;
																foreach ($lisfofcombi as $fndkey => $fndvalue) {
																	if ($fndvalue['stops'] == $dxstrvalue) {
																		$dwinls['stratplan'] = $fndvalue['stratplan'];
																		$dwinls['emots'] = $fndvalue['emots'];
																		$dwinls['tradecount']++;
																		if ($fndvalue['iswin'] == 'win') {
																			$dwinls['wincount'] ++;
																		} else {
																			$dwinls['losscount'] ++;
																		}

																	}
																}

																array_push($finaldstrats, $dwinls);
															}

															function sortByOrder($a, $b) {
															    return $b['tradecount'] - $a['tradecount'];
															}
															usort($finaldstrats, 'sortByOrder');

															// sort data for chart
															$dlistofstrat = [];
															foreach ($finaldstrats as $lstrkey => $lstrvalue) {
																array_push($dlistofstrat, $lstrvalue['stratplan']);
															}
															$dlistofstrat = array_unique($dlistofstrat);
															$dlistofstrat = array_filter($dlistofstrat);

															$dstratfinal = [];
															foreach ($dlistofstrat as $dshhkey => $dshhvalue) {
																$dstratpartial = [];
																$dstratpartial['strats'] = $dshhvalue;
																$dstratpartial['iswin'] = 0;
																$dstratpartial['isloss'] = 0;
																$dstratpartial['trade_count'] = 0;
																foreach ($finaldstrats as $dsjjkey => $dsjjvalue) {
																	if ($dshhvalue == $dsjjvalue['stratplan']) {
																		$dstratpartial['iswin'] += $dsjjvalue['wincount'];
																		$dstratpartial['isloss'] += $dsjjvalue['losscount'];
																		$dstratpartial['trade_count'] += $dsjjvalue['tradecount'];
																	}
																}
																array_push($dstratfinal, $dstratpartial);
															}

															$forchart = "";
															foreach ($dstratfinal as $dcdskey => $dcdsvalue) {
																$forchart .= "{";
																$forchart .= '"category": "'.$dcdsvalue['strats'].'",';
																$forchart .= '"Wins": "'.$dcdsvalue['iswin'].'",';
																$forchart .= '"Losses": "'.$dcdsvalue['isloss'].'",';
																$forchart .= '"Trades Strategy ": "'.$dcdsvalue['trade_count'].'"';
																$forchart .= "},";
															}
														?>
                                                    <?php
	                                                    	$months = array(
																'January',
																'February',
																'March',
																'April',
																'May',
																'June',
																'July ',
																'August',
																'September',
																'October',
																'November',
																'December',
															);

                                                        // get lits of combi strats
															$iswin = 0;
															$isloss = 0;
															$totaltrade = 0;
															foreach ($alltradelogs as $key => $value) {
																$data_sellmonth = $value['data_sellmonth'];
																$data_sellday = $value['data_sellday'];
																$data_sellyear = $value['data_sellyear'];

																$data_stock = $value['data_stock'];
																$data_dprice = $value['data_dprice'];
																$data_dprice = str_replace('₱', '', $data_dprice);

																$data_sell_price = $value['data_sell_price'];
																$data_quantity = $value['data_quantity'];

																$data_trade_info = $value['data_trade_info'];
																// $data_trade_info = json_decode($data_trade_info);
																$data_avr_price = $value['data_avr_price'];

																// get prices
																$soldplace = $data_quantity * $data_sell_price;
																$baseprice = $data_quantity * $data_dprice;

																$sellfee = getfees($soldplace, 'sell');

																//profit or loss
																$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																// profperc
																$dtlprofperc = (abs($dprofit)/($data_quantity * $data_avr_price)) * 100;
																$totalprofit += $dprofit;

																$totaltrade++;
																if ($dprofit > 0) {
																	$iswin++;
																} else {
																	$isloss++;
																}

															}

															$listmonth = [];
															foreach ($months as $ismkey => $ismvalue) {
																$innermonth = [];
																$innermonth['dmonth'] = $ismvalue;
																$innermonth['dprofit'] = 0;
																foreach ($alltradelogs as $trdkey => $trdvalue) {
																	if ($trdvalue['data_sellmonth'] == $ismvalue) {
																		$data_sellmonth = $trdvalue['data_sellmonth'];
																		$data_sellday = $trdvalue['data_sellday'];
																		$data_sellyear = $trdvalue['data_sellyear'];

																		$data_stock = $trdvalue['data_stock'];
																		$data_dprice = $trdvalue['data_dprice'];
																		$data_dprice = str_replace('₱', '', $data_dprice);

																		$data_sell_price = $trdvalue['data_sell_price'];
																		$data_quantity = $trdvalue['data_quantity'];

																		$data_trade_info = $trdvalue['data_trade_info'];
																		// $data_trade_info = json_decode($data_trade_info);
																		$data_avr_price = $trdvalue['data_avr_price'];

																		// get prices
																		$soldplace = $data_quantity * $data_sell_price;
																		$baseprice = $data_quantity * $data_dprice;

																		$sellfee = getfees($soldplace, 'sell');

																		//profit or loss
																		$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																		// $totalprofit += $dprofit;
																		$innermonth['dprofit'] += $dprofit;
																	}
																}
																array_push($listmonth, $innermonth);
															}

															$formonthperc = "";
															foreach ($listmonth as $lomkey => $lomvalue) {
																$formonthperc .= '{';
																	$formonthperc .= '"category": "'.date('M', strtotime($lomvalue['dmonth'])).'",';
																	$formonthperc .= '"column-1": "'.number_format($lomvalue['dprofit'],2).'"';
																$formonthperc .= '},';
															}


                                                        ?>

                                                    	<div class="col-md-7">
                                                            <div class="box-portlet">
                                                                <div class="box-portlet-header">
                                                                    Monthly Performance
                                                                </div>
                                                                <div class="box-portlet-content" style="padding-right: 0;padding-bottom: 0;">
                                                                    <div class="col-md-12" style="padding: 0px;">
                                                                        <div id="chartdiv2"></div>
                                                                    </div>
                                                                    <br class="clear">
                                                                </div>

                                                            </div>
                                                        </div>

														<div class="col-md-5">
															<div class="box-portlet">
																<div class="box-portlet-header" style="text-align:center;">
																	Trade Statistics
																</div>
                                                                <div class="chartarea" style="margin-bottom: -3px;">
                                                                    <div id="chartdiv4a"></div>
                                                                </div>
                                                                <div class="stats-info" style="padding: 0">

                                                                    <div class="col-md-6" style="padding: 0 5px 0 10px;">
                                                                        <div class="dstatstrade eqpad">
                                                                            <ul>

                                                                                <li>
                                                                                    <div class="width60"><span class="bulletclrd clrg1"></span> Wins</div>
                                                                                    <div class="width35"><?php echo $iswin; ?></div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width60"><span class="bulletclrd clrr1"></span> Losses</div>
                                                                                    <div class="width35"><?php echo $isloss; ?></div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                	<div class="col-md-6" style="padding: 0 10px 0 5px;">
                                                                        <div class="dstatstrade eqpad">
                                                                            <ul>

                                                                                <li>
                                                                                    <div class="width60">Total Trades</div>
                                                                                    <div class="width35"><?php echo $totaltrade; ?></div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width60"><strong>Win Rate</strong></div>
                                                                                    <div class="width35"><strong><?php
                                                                                        if ($iswin > 0) {
                                                                                            echo number_format( ($iswin / $totaltrade) * 100, 2, '.', ',' );
                                                                                        } else {
                                                                                            echo "0.00";
                                                                                        }
                                                                                     ?>%</strong></div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>

															</div>
														</div>

                                                        <br class="clear">

													</div>
													<br class="clear">

													<!-- BOF Strategy Statistics -->
														<?php

															$dstrategies = [];
															foreach ($alltradelogs as $liofstratkey => $liofstratvalue) {
																$dinformattion = array_values(array_filter($liofstratvalue['strategy_plans']));
																array_push($dstrategies, $dinformattion[0]);
															}
															$startslists = array_unique($dstrategies);

															$stratsinfo = [];
															foreach ($startslists as $dlskey => $dlsvalue) {
																$dinfostrt = [];
																$dinfostrt['dstrat'] = $dlsvalue;
																$dinfostrt['winrate'] = 0;
																$dinfostrt['lossrate'] = 0;
																$dinfostrt['trades'] = 0;
																foreach ($alltradelogs as $dalltrkey => $dalltrvalue) {
																	$dinformattion = array_values(array_filter($dalltrvalue['strategy_plans']));
																	if ($dinformattion[0] == $dlsvalue) {

																		# code...
																		$data_sellmonth = $dalltrvalue['data_sellmonth'];
																		$data_sellday = $dalltrvalue['data_sellday'];
																		$data_sellyear = $dalltrvalue['data_sellyear'];

																		$data_stock = $dalltrvalue['data_stock'];
																		$data_dprice = $dalltrvalue['data_dprice'];
																		$data_dprice = str_replace('₱', '', $data_dprice);

																		$data_sell_price = $dalltrvalue['data_sell_price'];
																		$data_quantity = $dalltrvalue['data_quantity'];

																		$data_trade_info = $dalltrvalue['data_trade_info'];
																		// $data_trade_info = json_decode($data_trade_info);
																		$data_avr_price = $dalltrvalue['data_avr_price'];

																		// get prices
																		$soldplace = $data_quantity * $data_sell_price;
																		$baseprice = $data_quantity * $data_dprice;

																		$sellfee = getfees($soldplace, 'sell');

																		//profit or loss
																		$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																		// $totalprofit += $dprofit;
																		// $dinfostrt['dprofit'] += $dprofit;
																		$dinfostrt['trades']++;
																		if ($dprofit > 0) {
																			$dinfostrt['winrate']++;
																		} else {
																			$dinfostrt['lossrate']++;
																		}

																	}
																}

																array_push($stratsinfo, $dinfostrt);
															}



															// sort data for chart
															$dlistofstrat = [];
															foreach ($finaldstrats as $lstrkey => $lstrvalue) {
																array_push($dlistofstrat, $lstrvalue['stratplan']);
															}
															$dlistofstrat = array_unique($dlistofstrat);
															$dlistofstrat = array_filter($dlistofstrat);

															$dstratfinal = [];
															foreach ($dlistofstrat as $dshhkey => $dshhvalue) {
																$dstratpartial = [];
																$dstratpartial['strats'] = $dshhvalue;
																$dstratpartial['iswin'] = 0;
																$dstratpartial['isloss'] = 0;
																$dstratpartial['trade_count'] = 0;
																foreach ($finaldstrats as $dsjjkey => $dsjjvalue) {
																	if ($dshhvalue == $dsjjvalue['stratplan']) {
																		$dstratpartial['iswin'] += $dsjjvalue['wincount'];
																		$dstratpartial['isloss'] += $dsjjvalue['losscount'];
																		$dstratpartial['trade_count'] += $dsjjvalue['tradecount'];
																	}
																}
																array_push($dstratfinal, $dstratpartial);
															}

															$forchart = "";
															foreach ($dstratfinal as $dcdskey => $dcdsvalue) {
																$forchart .= "{";
																$forchart .= '"category": "'.$dcdsvalue['strats'].'",';
																$forchart .= '"Wins": "'.$dcdsvalue['iswin'].'",';
																$forchart .= '"Losses": "'.$dcdsvalue['isloss'].'",';
																$forchart .= '"Trades Strategy ": "'.$dcdsvalue['trade_count'].'"';
																$forchart .= "},";
															}
														?>
													<!-- EOF Strategy Statistics -->
													<div class="row">
														<div class="col-md-12">
															<div class="box-portlet">
                                                            	<style>.dstatstrade ul li div {width: 16%;}</style>

                                                                <div style="padding:5px 15px;">
                                                                	<div class="col-md-8" style="padding:0 10px 0 0">

                                                                        <div class="box-portlet-header" style="padding: 13px 0 17px 2px;">
                                                                            Strategy Statistics
                                                                        </div>

                                                                		<div class="stats-info">
                                                                            <div class="dstatstrade">
                                                                                <ul>
                                                                                    <li class="headerpart">
                                                                                        <div style="width:100%">
                                                                                            <div style="width:150px;">Strategy</div>
                                                                                            <div>Trades</div>
                                                                                            <div>Wins</div>
                                                                                            <div>Loses</div>
                                                                                            <div>Win Rate</div>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
																					$stratstrg = "";
																					$wincharts = "";
																					foreach ($stratsinfo as $statskey => $statsvalue) { ?>
                                                                                    	<li>
	                                                                                        <div style="width:99%">
	                                                                                            <div style="width:150px;"><?php echo $statsvalue['dstrat']; ?></div>
	                                                                                            <div><?php echo $statsvalue['trades']; ?></div>
	                                                                                            <div><?php echo $statsvalue['winrate']; ?></div>
	                                                                                            <div><?php echo $statsvalue['lossrate']; ?></div>
	                                                                                            <div><?php echo number_format(($statsvalue['winrate'] / $statsvalue['trades']) * 100,2); ?>%</div>
	                                                                                        </div>
	                                                                                    </li>
	                                                                                    <?php
	                                                                                    	$stratstrg .= '{';
																								$stratstrg .= '"category": "'.$statsvalue['dstrat'].'",';
																								$stratstrg .= '"column-2": "'.$statsvalue['lossrate'].'",';
																								$stratstrg .= '"Trades": "'.$statsvalue['winrate'].'",';
																								$stratstrg .= '"colors": "#06af68",';
																								$stratstrg .= '"colorsred": "#b7193f"';
																							$stratstrg .= '},';

																							$wincharts .= '{';
																							  $wincharts .= '"strategy": "'.$statsvalue['dstrat'].'",';
																							  $wincharts .= '"winvals": '.$statsvalue['winrate'].'';
																							$wincharts .= '},';

	                                                                                    ?>
                                                                                    <?php } ?>

                                                                                </ul>
                                                                            </div>
                                                                    	</div>

                                                                    </div>
                                                                    <div class="col-md-4" style="padding:0">
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
                                                                                    <div class="width48" style="text-align: right;">Trend Following</div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="width48"><span class="bulletclrd clrr1"></span> Losing Strategy</div>
                                                                                    <div class="width48" style="text-align: right;">Breakout</div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>

                                                                    </div>
                                                                    <br class="clear">

                                                                </div>

                                                                <div style="padding: 0 12px 0 10px;">
                                                                    <div id="chartdiv5"></div>
                                                                </div>
																<br class="clear">

															</div>
														</div>
														<br class="clear">
													</div>
                                                    <br class="clear">
                                                    <!-- BoF Trade Statistics -->
													<?php
														// get all stocks that has been traded
														$dstocks = [];
														foreach ($alltradelogs as $dstockskey => $dstocksvalue) {
															array_push($dstocks, $dstocksvalue['data_stock']);
														}
														$dstocks = array_unique($dstocks);

														// identify is stock profit
														$dlistofstocks = [];
														foreach ($dstocks as $sxdkey => $sxdvalue) {
															$dinitbb = [];
															$dinitbb['dstock'] = $sxdvalue;
															$dinitbb['dprofit'] = 0;

															foreach ($alltradelogs as $alllogskey => $alllogsvalue) {

																if ($sxdvalue == $alllogsvalue['data_stock']) {
																	$data_sellmonth = $alllogsvalue['data_sellmonth'];
																	$data_sellday = $alllogsvalue['data_sellday'];
																	$data_sellyear = $alllogsvalue['data_sellyear'];

																	$data_stock = $alllogsvalue['data_stock'];
																	$data_dprice = $alllogsvalue['data_dprice'];
																	$data_dprice = str_replace('₱', '', $data_dprice);

																	$data_sell_price = $alllogsvalue['data_sell_price'];
																	$data_quantity = $alllogsvalue['data_quantity'];

																	$data_trade_info = $alllogsvalue['data_trade_info'];
																	// $data_trade_info = json_decode($data_trade_info);
																	$data_avr_price = $alllogsvalue['data_avr_price'];

																	// get prices
																	$soldplace = $data_quantity * $data_sell_price;
																	$baseprice = $data_quantity * $data_dprice;

																	$sellfee = getfees($soldplace, 'sell');

																	//profit or loss
																	$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																	$dinitbb['dprofit'] += $dprofit;
																}

															}

															array_push($dlistofstocks, $dinitbb);
														}

														$iswinstocks = [];
														$islossstocks = [];
														foreach ($dlistofstocks as $dwlkey => $dwlvalue) {
															if ($dwlvalue['dprofit'] > 0) {
																array_push($iswinstocks, $dwlvalue);
															} else {
																array_push($islossstocks, $dwlvalue);
															}

														}

														function sortprofits($a, $b) {
														    return $a['dprofit'] - $b['dprofit'];
														}

														function winningsort($a, $b) {
														    return $b['dprofit'] - $a['dprofit'];
														}

														// winning stocks
														// usort($iswinstocks, 'sortprofits');
														$totalwin = 0;
														$finalwinning = [];
														foreach ($iswinstocks as $pxwinkey => $pxwinvalue) {
															array_push($finalwinning, $pxwinvalue);
															$totalwin += $pxwinvalue['dprofit'];
															if ($pxwinkey >= 4) {
																break;
															}
														}
														// usort($finalwinning, 'winningsort');

														$finalloss = [];
														$totalloss = 0;
														foreach ($islossstocks as $pxlosskey => $pxlossvalue) {
															array_push($finalloss, $pxlossvalue);
															$totalloss += $pxlossvalue['dprofit'];
															if ($pxlosskey >= 4) {
																break;
															}
														}


													?>
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
                                                                                            <?php /*?><li class="headerpart">
                                                                                                <div class="widthfull">
                                                                                                    <span class="bulletclrd clrg1" style="background-color:#00E676"></span>Winners
                                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                    <span class="bulletclrd clrr1" style="background-color:#ff1744"></span>Losers
                                                                                                </div>
                                                                                            </li><?php */?>
                                                                                            <?php /*?> Winners <?php */?>
																							<?php
																							$dwinning = "";
																							$intowinchartbands = "";
																							$intowinchartlabels = "";
																							foreach ($finalwinning as $fwinkey => $fwinvalue) {
																								$dinss = '<li style="background-color: '.($fwinkey == 0 ? '#115350' : ($fwinkey == 1 ? '#0d785a' : ($fwinkey == 2 ? '#06af68' : '#00e676'))).';color: #b1e8ce;border: none;">';
	                                                                                                $dinss .= '<div class="width60">'.$fwinvalue['dstock'].'</div>';
	                                                                                                $dinss .= '<div class="width35">&#8369; '.number_format( $fwinvalue['dprofit'], 2, '.', ',' ).'</div>';
	                                                                                            $dinss .= '</li>';
																								$dwinning = $dwinning.$dinss;

																								$intowinchartbands .= '{';
																								  $intowinchartbands .= '"color": "#ffffff",';
																								  $intowinchartbands .= '"startValue": 0,';
																								  $intowinchartbands .= '"endValue": 100,';
																								  $intowinchartbands .= '"radius": "100%",';
																								  $intowinchartbands .= '"innerRadius": "85%",';
																								  $intowinchartbands .= '"alpha": 0.05';
																								$intowinchartbands .= '}, {';
																								 $intowinchartbands .= ' "color": "#00e676",';
																								 $intowinchartbands .= ' "startValue": 0,';
																								 $intowinchartbands .= ' "endValue": '.number_format( ($fwinvalue['dprofit']/$totalwin) * 100, 2, '.', ',' ).',';
																								 $intowinchartbands .= ' "radius": "100%",';
																								 $intowinchartbands .= ' "innerRadius": "85%",';
																								 $intowinchartbands .= ' "balloonText": "'.number_format( ($fwinvalue['dprofit']/$totalwin) * 100, 2, '.', ',' ).'%"';
																								$intowinchartbands .= '},';

																								$intowinchartlabels .= '{';
																								  $intowinchartlabels .= '"text": "'.$fwinvalue['dstock'].'",';
																								  $intowinchartlabels .= '"x": "49%",';
																								  $intowinchartlabels .= '"y": "'.($fwinkey == 0 ? '6.5' : ($fwinkey == 1 ? '15' : ($fwinkey == 2 ? '24' : '33'))).'%",';
																								  $intowinchartlabels .= '"size": 11,';
																								  $intowinchartlabels .= '"bold": false,';
																								  $intowinchartlabels .= '"color": "#d8d8d8",';
																								  $intowinchartlabels .= '"align": "right",';
																								$intowinchartlabels .= '},';



																							}
																							 ?>
																							 <?php echo $dwinning; ?>
                                                                                            <!-- <li style="background-color: #00e676;color: #132941;border: none;">
                                                                                                <div class="width60">ISM</div>
                                                                                                <div class="width35">&#8369; <?php echo number_format( rand(40000,48000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #06af68;color: #132941;border: none;">
                                                                                                <div class="width60">HLCM</div>
                                                                                                <div class="width35">&#8369; <?php echo number_format( rand(20000,25000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #0d785a;color: #b1e8ce;border: none;">
                                                                                                <div class="width60">BPI</div>
                                                                                                <div class="width35">&#8369; <?php echo number_format( rand(10000,15000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #115350;color: #b1e8ce;border: none;">
                                                                                                <div class="width60">SMPH</div>
                                                                                                <div class="width35">&#8369; <?php echo number_format( rand(5000,10000), 2, '.', ',' ); ?></div>
                                                                                            </li> -->
                                                                                            <?php /*?> Losers <?php */?>
																							<?php
																							$dlossing = "";
																							$intolosschartbands = "";
																							$intolosschartlabels = "";
																							foreach ($finalloss as $flosskey => $flossvalue) {
																								$dinss = '<li style="background-color: '.($flosskey == 0 ? '#442946' : ($flosskey == 1 ? '#732546' : ($flosskey == 2 ? '#b91e45' : '#ff1744'))).';color: #132941;border: none;">';
	                                                                                                $dinss .= '<div class="width60">'.$flossvalue['dstock'].'</div>';
	                                                                                                $dinss .= '<div class="width35">&#8369; '.number_format( $flossvalue['dprofit'], 2, '.', ',' ).'</div>';
	                                                                                            $dinss .= '</li>';
																								$dlossing = $dlossing.$dinss;

																								$intolosschartbands .= '{';
																								  $intolosschartbands .= '"color": "#ffffff",';
																								  $intolosschartbands .= '"startValue": 0,';
																								  $intolosschartbands .= '"endValue": 100,';
																								  $intolosschartbands .= '"radius": "100%",';
																								  $intolosschartbands .= '"innerRadius": "85%",';
																								  $intolosschartbands .= '"alpha": 0.05';
																								$intolosschartbands .= '}, {';
																								 $intolosschartbands .= ' "color": "#00e676",';
																								 $intolosschartbands .= ' "startValue": 0,';
																								 $intolosschartbands .= ' "endValue": '.number_format( ($fwinvalue['dprofit']/$totalwin) * 100, 2, '.', ',' ).',';
																								 $intolosschartbands .= ' "radius": "100%",';
																								 $intolosschartbands .= ' "innerRadius": "85%",';
																								 $intolosschartbands .= ' "balloonText": "'.number_format( ($fwinvalue['dprofit']/$totalwin) * 100, 2, '.', ',' ).'%"';
																								$intolosschartbands .= '},';

																								$intolosschartlabels .= '{';
																								  $intolosschartlabels .= '"text": "'.$fwinvalue['dstock'].'",';
																								  $intolosschartlabels .= '"x": "49%",';
																								  $intolosschartlabels .= '"y": "'.($fwinkey == 0 ? '6.5' : ($fwinkey == 1 ? '15' : ($fwinkey == 2 ? '24' : '33'))).'%",';
																								  $intolosschartlabels .= '"size": 11,';
																								  $intolosschartlabels .= '"bold": false,';
																								  $intolosschartlabels .= '"color": "#d8d8d8",';
																								  $intolosschartlabels .= '"align": "right",';
																								$intolosschartlabels .= '},';
																							 }
																							 ?>
																							 <?php echo $dlossing; ?>
                                                                                            <!-- <li style="background-color: #442946;color: #fdbebe;border: none;">
                                                                                                <div class="width60">2GO</div>
                                                                                                <div class="width35">- &#8369; <?php echo number_format( rand(5000,10000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #732546;color: #fdbebe;border: none;">
                                                                                                <div class="width60">X</div>
                                                                                                <div class="width35">- &#8369; <?php echo number_format( rand(12000,20000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #b91e45;color: #fdbebe;border: none;">
                                                                                                <div class="width60">CHP</div>
                                                                                                <div class="width35">- &#8369; <?php echo number_format( rand(25000,35000), 2, '.', ',' ); ?></div>
                                                                                            </li>
                                                                                            <li style="background-color: #ff1744;color: #fdbebe;border: none;">
                                                                                                <div class="width60">NOW</div>
                                                                                                <div class="width35">- &#8369; <?php echo number_format( rand(36000,49000), 2, '.', ',' ); ?></div>
                                                                                            </li> -->
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
                                                    <?php
                                                    	// this is for the emotional part
                                                    	// pull emotions
                                                    	$listofemotions = [];
                                                    	foreach ($alltradelogs as $lomkey => $lomvalue) {
                                                    		$dinformattion = array_values(array_filter($lomvalue['emotions']));
                                                    		array_push($listofemotions, $dinformattion[0]);
                                                    	}
                                                    	$emotionsused = array_unique($listofemotions);

                                                    	// get win loss as per emotions
                                                    	$emotioninfo = [];
                                                    	foreach ($emotionsused as $emoskey => $emosvalue) {
                                                    		$demoinfo = [];
                                                    		$demoinfo['emotion'] = $emosvalue;
                                                    		$demoinfo['iswin'] = 0;
                                                    		$demoinfo['isloss'] = 0;
                                                    		$demoinfo['totaltrades'] = 0;
                                                    		foreach ($alltradelogs as $alltrkey => $alltrvalue) {
	                                                    		$dinformattion = array_values(array_filter($alltrvalue['emotions']));
	                                                    		if ($dinformattion[0] == $emosvalue) {

	                                                    			$data_sellmonth = $alltrvalue['data_sellmonth'];
																	$data_sellday = $alltrvalue['data_sellday'];
																	$data_sellyear = $alltrvalue['data_sellyear'];

																	$data_stock = $alltrvalue['data_stock'];
																	$data_dprice = $alltrvalue['data_dprice'];
																	$data_dprice = str_replace('₱', '', $data_dprice);

																	$data_sell_price = $alltrvalue['data_sell_price'];
																	$data_quantity = $alltrvalue['data_quantity'];

																	$data_trade_info = $alltrvalue['data_trade_info'];
																	// $data_trade_info = json_decode($data_trade_info);
																	$data_avr_price = $alltrvalue['data_avr_price'];

																	// get prices
																	$soldplace = $data_quantity * $data_sell_price;
																	$baseprice = $data_quantity * $data_dprice;

																	$sellfee = getfees($soldplace, 'sell');

																	//profit or loss
																	$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																	// profperc
																	$dtlprofperc = (abs($dprofit)/($data_quantity * $data_avr_price)) * 100;
																	$totalprofit += $dprofit;

																	$totaltrade++;
																	if ($dprofit > 0) {
																		$demoinfo['iswin']++;
																	} else {
																		$demoinfo['isloss']++;
																	}

	                                                    			$demoinfo['totaltrades']++;
	                                                    		}

	                                                    	}
	                                                    	array_push($emotioninfo, $demoinfo);
                                                    	}

                                                    ?>
                                                    <div class="row">

                                                        <div class="col-md-12">
															<div class="box-portlet">

																<div class="box-portlet-header" style="padding-bottom:13px;">
																	Emotional Statistics
																</div>

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
																				<?php $demotsonchart = ""; ?>
                                                                            	<?php foreach ($emotioninfo as $emtkey => $emtvalue) { ?>
                                                                            		<li>
	                                                                                    <div><?php  echo $emtvalue['emotion']; ?></div>
	                                                                                    <div><?php  echo $emtvalue['totaltrades']; ?></div>
	                                                                                    <div><?php  echo $emtvalue['iswin']; ?></div>
	                                                                                    <div><?php  echo $emtvalue['isloss']; ?></div>
	                                                                                    <div><?php  echo number_format(($emtvalue['iswin'] / $emtvalue['totaltrades']) * 100, 2, '.', ''); ?>%</div>
	                                                                                </li>
																					<?php
																					$demotsonchart .= '{';
																					    $demotsonchart .= '"category": "'.$emtvalue['emotion'].'",';
																					    $demotsonchart .= '"column-2": "'.$emtvalue['isloss'].'",';
																					    $demotsonchart .= '"Trades": "'.$emtvalue['iswin'].'"';
																					$demotsonchart .= '},';
																					?>
																					<?php if ($emtkey >= 4) { break; }  ?>
                                                                            	<?php } ?>
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
                                                    <?php
                                                    	$dlistoflivetrades = [];
														foreach ($getdstocks as $dtdkey => $dtdvalue) {
															$dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$dtdvalue, true);
															if ($dstocktraded && $dstocktraded != "") {
																foreach ($dstocktraded['data'] as $dtfkey => $dtfvalue) {
																	array_push($dlistoflivetrades, $dtfvalue);
																}
															}


														}

														$commissions = 0;
														$vat = 0;
														$transfer_fee = 0;
														$sccp = 0;
														$sales_tax = 0;

														// fron live portfolio
														foreach ($dlistoflivetrades as $dsubkey => $dsubvalue) {

															$dsmarketval = $dsubvalue['qty'] * str_replace("₱", "", $dsubvalue['currprice']);

															$partialcommissions = $dsmarketval * 0.0025;
															$commissions += ($partialcommissions > 20 ? $partialcommissions : 20);

															$vat += $commissions * 0.12;
															$transfer_fee += $dsmarketval * 0.00005;
															$sccp += $dsmarketval * 0.0001;
														}

														// from selling
														foreach ($alltradelogs as $dsellkey => $dsellvalue) {
															$dsmarketval = $dsellvalue['data_quantity'] * str_replace("₱", "", $dsellvalue['data_sell_price']);

															$partialcommissions = $dsmarketval * 0.0025;
															$commissions += ($partialcommissions > 20 ? $partialcommissions : 20);

															$vat += $commissions * 0.12;
															$transfer_fee += $dsmarketval * 0.00005;
															$sccp += $dsmarketval * 0.0001;
															$sales_tax += $dsmarketval * 0.006;
														}

														// for months

														$feepermonth = [];
														foreach ($months as $monkey => $monvalue) {
															$dmonth = [];
															$dmonth['month'] = $monvalue;
															// $dmonth['data'] = [];

															$dmonth['commissions'] = 0;
															$dmonth['vat'] = 0;
															$dmonth['transfer_fee'] = 0;
															$dmonth['sccp'] = 0;
															$dmonth['sales_tax'] = 0;

															foreach ($dlistoflivetrades as $dbuykey => $dbuyvalue) {
																if ($dbuyvalue['buymonth'] == $monvalue) {
																	// array_push($dmonth['data'], $dbuyvalue);
																	$buymarket = $dbuyvalue['qty'] * str_replace("₱", "", $dbuyvalue['currprice']);

																	$buycommission = $buymarket * 0.0025;
																	$dmonth['commissions'] += ($buycommission > 20 ? $buycommission : 20);

																	$dmonth['vat'] += $dmonth['commissions'] * 0.12;
																	$dmonth['transfer_fee'] += $buymarket * 0.00005;
																	$dmonth['sccp'] += $buymarket * 0.0001;
																}
															}

															foreach ($alltradelogs as $fdsellkey => $fdsellvalue) {
																if ($fdsellvalue['data_sellmonth'] == $monvalue) {
																	$sellmarket = $fdsellvalue['data_quantity'] * str_replace("₱", "", $fdsellvalue['data_sell_price']);

																	$sellcommission = $sellmarket * 0.0025;
																	$dmonth['commissions'] += ($sellcommission > 20 ? $sellcommission : 20);

																	$dmonth['vat'] += $dmonth['commissions'] * 0.12;
																	$dmonth['transfer_fee'] += $sellmarket * 0.00005;
																	$dmonth['sccp'] += $sellmarket * 0.0001;
																	$dmonth['sales_tax'] += $sellmarket * 0.006;
																}
															}
															$dmonth['totalfee'] = $dmonth['commissions'] + $dmonth['vat'] + $dmonth['transfer_fee'] + $dmonth['sccp'] + $dmonth['sales_tax'];

															array_push($feepermonth, $dmonth);
														}

														// $expencetochart = "";
														// foreach ($feepermonth as $tochartkey => $tochartvalue) {
														// 	$expencetochart .= '{';
														// 		$expencetochart .= '"date": "2019-'.sprintf("%02d", ($tochartkey + 1)).'",';
														// 		$expencetochart .= '"column-1": '.number_format( $tochartvalue['totalfee'], 2, '.', '' );
														// 	$expencetochart .= '},';
														// }

														$feeschart = "";
														foreach ($feepermonth as $spmkey => $spmvalue) {
															$feeschart .= '{';
																$feeschart .= '"category": "'.date('M', strtotime($spmvalue['month'])).'",';
																$feeschart .= '"column-1": "'.$spmvalue['totalfee'].'"';
															$feeschart .= '},';
														}
													?>
                                                    <!-- EOF expenses report -->
													<div class="expence-report">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Expense Report
																</div>
                                                                <div class="box-portlet-content" style="padding-top: 0; padding-left:0; padding-bottom:0;">
                                                                    <div class="col-md-4" style="padding-right:0;">

																			<div class="inner-portlet" style="margin-top:20px;">
                                                                                    <div class="stats-info">
                                                                                        <div class="dstatstrade">
                                                                                            <ul>
                                                                                                <li class="headerpart">
                                                                                                    <div class="widthfull">Breakdown Expenses</div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Commissions</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format( $commissions, 2, '.', ',' ); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Value Added Tax</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format( $vat, 2, '.', ',' ); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Transfer Fee</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format( $transfer_fee, 2, '.', ',' ); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">SCCP</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format( $sccp, 2, '.', ',' ); ?></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="width60">Sales Tax</div>
                                                                                                    <div class="width35">&#8369;<?php echo number_format( $sales_tax, 2, '.', ',' ); ?></div>
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
													<?php
														// get last 20 traiding days
														$volumes = [];
														$values = [];
														foreach ($dlistoflivetrades as $ltwkey => $ltwvalue) {
															array_push($volumes, $ltwvalue['qty']);
															array_push($values, $ltwvalue['price']);
															if ($ltwkey >= 20) {
																break;
															}
														}

														for ($i=count($volumes); $i <= 20 ; $i++) {
															array_push($volumes, '0');
														}

														for ($j=count($values); $j <= 20 ; $j++) {
															array_push($values, '0');
														}

														$dailyvolumes = "";
														foreach ($volumes as $dvolkey => $dvolvalue) {
															$dailyvolumes .= '{';
																$dailyvolumes .= '"category": "'.$dvolkey.'",';
																$dailyvolumes .= '"column-1": '.$dvolvalue.'';
															$dailyvolumes .= '},';
														}

														$dailyvalues = "";
														foreach ($values as $dvalkey => $dvalvalue) {
															$dailyvalues .= '{';
																$dailyvalues .= '"category": "'.$dvalkey.'",';
																$dailyvalues .= '"column-1": '.$dvalvalue.'';
															$dailyvalues .= '},';
														}
													?>
													<br class="clear">
													<div class="row">
														<div class="col-md-6" style="padding-right: 0;">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Volume<br />
                                                                    <span>For the last 20 trading days</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv7"></div>
																</div>

															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Value<br />
                                                                    <span>For the last 20 trading days</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv8"></div>
																</div>

															</div>
														</div>
													</div>
													<br class="clear">

                                                    <div class="_adsbygoogle">
														<div class="box-portlet" style="background:none !important; box-shadow: none !important; overflow:visible';">

															<div class="box-portlet-content" style="padding:0;">
                                                            	<?php /*?><small>ADVERTISEMENT</small><?php */?>
																<div class="adscontainer" style="text-align:center;">
                                                                	<img src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png" style="box-shadow: -7px 8px 8px -3px rgba(4,13,23,0.3);">
                                                                </div>
															</div>
														</div>
													</div>
													<br class="clear">

													<?php
														$dates = [];
														array_push($dates, date('Y-m-d'));
														for ($i=1; $i <= 20; $i++) {
															array_push($dates, date('Y-m-d', strtotime('today - '.$i.' days')));
														}
														$dates = array_reverse($dates);

														$args = array(
														    'posts_per_page' => -1,
														    'post_type' => 'post',
														    'orderby' => 'comment_count',
														    'order' => 'DESC',
														    'date_query' => array(
														        'after' => date('Y-m-d', strtotime('-20 days'))
														    ),
														    'meta_key' => 'data_userid',
															'meta_value'  => get_current_user_id()
														);
														$posts = get_posts($args);

														$dlistofpost = [];
														foreach ($dates as $ddateskey => $ddatesvalue) {
															$dlls = [];
															$dlls[$ddatesvalue] = [];
															$dlls['profit'] = 0;
															foreach ($posts as $dpostkey => $dpostvalue) {
																if ($ddatesvalue == date('Y-m-d', strtotime($dpostvalue->post_date))) {

																	$dsellprice = get_post_meta($dpostvalue->ID, 'data_sell_price', true);
																	$dbuyprice = get_post_meta($dpostvalue->ID, 'data_dprice', true);
																	$dquantity = get_post_meta($dpostvalue->ID, 'data_quantity', true);
																	$data_avr_price = get_post_meta($dpostvalue->ID, 'data_avr_price', true);

																	$dbuyprice = str_replace('₱', '', $dbuyprice);
																	// get prices
																	$soldplace = $dquantity * $dsellprice;
																	$baseprice = $dquantity * $dbuyprice;

																	$sellfee = getfees($soldplace, 'sell');

																	$dprofit = ($soldplace - $sellfee) - ($dquantity * $data_avr_price);
																	$dlls['profit'] += $dprofit;
																	array_push($dlls[$ddatesvalue], $profit);
																}
															}
															array_push($dlistofpost, $dlls['profit']);
														}

														$dtrades = [];
														$gplchart = "";
														$counter = 0;
														foreach ($posts as $dpostkey => $dpostvalue) {
															$instrade = [];
															$instrade['count'] = $counter;

															$dsellprice = get_post_meta($dpostvalue->ID, 'data_sell_price', true);
															$dbuyprice = get_post_meta($dpostvalue->ID, 'data_dprice', true);
															$dquantity = get_post_meta($dpostvalue->ID, 'data_quantity', true);
															$data_avr_price = get_post_meta($dpostvalue->ID, 'data_avr_price', true);

															$dbuyprice = str_replace('₱', '', $dbuyprice);
															// get prices
															$soldplace = $dquantity * $dsellprice;
															$baseprice = $dquantity * $dbuyprice;

															$sellfee = getfees($soldplace, 'sell');

															$dprofit = ($soldplace - $sellfee) - ($dquantity * $data_avr_price);
															$instrade['profit'] = $dprofit;
															array_push($dtrades, $instrade);

															$gplchart .= '{';
																$gplchart .= '"category": "'.$counter.'",';
																$gplchart .= '"column-1": "'.number_format( $dprofit, 2, '.', '' ).'",';
																$gplchart .= '"column-2": "#673ab7"';
															$gplchart .= '},';

															if ($counter >= 20) {
																break;
															}
														}

														// add empty on string
														for ($i=count($dtrades); $i <= 20 ; $i++) {
															$gplchart .= '{';
																$gplchart .= '"category": "'.$i.'",';
																$gplchart .= '"column-1": "0",';
																$gplchart .= '"column-2": "#673ab7"';
															$gplchart .= '},';
														}

														$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
														$xdays = [];
														foreach ($days as $xdayskey => $xdaysvalue) {
															$indays = [];
															$indays['dday'] = $xdaysvalue;

															$indays['data'] = [];
															$indays['profit'] = 0;
															$tuespostargs = array(
															    'posts_per_page' => -1,
															    'post_type' => 'post',
																'meta_query'       => array(
															        'relation'    => 'AND',
															        array(
															            'key'          => 'data_userid',
															            'value'        => get_current_user_id(),
															            'compare'      => 'like',
															        ),
															        array(
															            'key'          => 'data_isdateofw',
															            'value'        => $xdaysvalue,
															            'compare'      => 'like',
															        )
															    ),
															);
															$dinfobase = get_posts($tuespostargs);
															foreach ($dinfobase as $xdsskey => $xdssvalue) {
																$dsellprice = get_post_meta($xdssvalue->ID, 'data_sell_price', true);
																$dbuyprice = get_post_meta($xdssvalue->ID, 'data_dprice', true);
																$dquantity = get_post_meta($xdssvalue->ID, 'data_quantity', true);
																$data_avr_price = get_post_meta($xdssvalue->ID, 'data_avr_price', true);

																$dbuyprice = str_replace('₱', '', $dbuyprice);
																// get prices
																$soldplace = $dquantity * $dsellprice;
																$baseprice = $dquantity * $dbuyprice;

																$sellfee = getfees($soldplace, 'sell');

																$dprofit = ($soldplace - $sellfee) - ($dquantity * $data_avr_price);
																$indays['profit'] += $dprofit;
															}

															array_push($xdays, $indays);
														}

														$dpercschart = "";
														foreach ($xdays as $xdaykey => $xdayvalue) {
															$basedate =  date('D', strtotime($xdayvalue['dday']));
															$dpercschart .= '{';
																$dpercschart .= '"category": "'.$basedate.'",';
																$dpercschart .= '"column-1": "'.$xdayvalue['profit'].'",';
																$dpercschart .= '"column-2": "#673ab7"';
															$dpercschart .= '},';
														}

													?>
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
																	<span>Last 20 trading days</span>
																</div>
																<div class="box-portlet-content" style="padding-right:0;">
																	<div id="chartdiv10"></div>
																</div>

															</div>
														</div>
													</div>
						                        </div>
						                        <div class="tab-pane" id="tab2">

						                        	<div class="tradelogsbox">
                                                        <div class="box-portlet">

                                                            <div class="box-portlet-header">
                                                                Tradelogs
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <div class="dstatstrade overridewidth">
                                                                        <ul>
                                                                        	<li class="headerpart">
                                                                            	<div style="width:100%;">
                                                                                	<div style="width:20px">#</div>
                                                                                    <div style="width:70px">Date</div>
                                                                                    <div style="width:60px">Stocks</div>
                                                                                    <div style="width:65px">Volume</div>
                                                                                    <div style="width:70px">Ave. Price</div>
                                                                                    <div style="width:95px">Buy Value</div>
                                                                                    <div style="width:65px">Sell Price</div>
                                                                                    <div style="width:95px">Sell Value</div>
                                                                                    <div style="width:85px">Profit/Loss</div>
                                                                                    <div style="width:30px">%</div>
                                                                                    <div style="width:38px; text-align:right">Notes</div>
                                                                                </div>
                                                                            </li>
                                                                            <?php
																				$totalprofit = 0;
																				// The Loop
																				$logcount = 1;
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
																						$data_trade_info = json_decode($data_trade_info);
																						$data_avr_price = get_post_meta(get_the_ID(), 'data_avr_price', true);

																						// get prices
																						$soldplace = $data_quantity * $data_sell_price;
																						$baseprice = $data_quantity * $data_dprice;

																						$sellfee = getfees($soldplace, 'sell');

																						//profit or loss
																						$dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

																						// profperc
																						$dtlprofperc = (abs($dprofit)/($data_quantity * $data_avr_price)) * 100;
																						$totalprofit += $dprofit;
																						?>
																						<li>
			                                                                            	<div style="width:99%;">
			                                                                                	<div style="width:20px"><?php echo $logcount; ?></div>
			                                                                                    <div style="width:70px"><?php echo date('m', strtotime($data_sellmonth)); ?>/<?php echo $data_sellday; ?>/<?php echo $data_sellyear; ?></div>
			                                                                                    <div style="width:60px"><?php echo $data_stock; ?></div>
			                                                                                    <div style="width:65px"><?php echo $data_quantity; ?></div>
			                                                                                    <div style="width:70px">₱<?php echo number_format( $data_avr_price, 2, '.', ',' ); ?></div>
			                                                                                    <div style="width:95px">₱<?php echo number_format( ($data_quantity * $data_avr_price), 2, '.', ',' ); ?></div>
			                                                                                    <div style="width:65px">₱<?php echo number_format( $data_sell_price, 2, '.', ',' ); ?></div>
			                                                                                    <div style="width:95px">₱<?php echo number_format( $soldplace, 2, '.', ',' ); ?></div>
			                                                                                    <div style="width:85px" class="<?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>">₱<?php echo number_format( $dprofit, 2, '.', ',' ); ?></div>
			                                                                                    <div style="width:30px" class="<?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo ($dprofit > 0 ? '+' : '-'); ?><?php echo number_format( $dtlprofperc, 2, '.', ',' ); ?>%</div>
			                                                                                    <div style="width:38px; text-align:right">
			                                                                                    	<a href="#tradelognotes_<?php echo $data_stock; ?>" class="smlbtn blue fancybox-inline">
					                                                                                	<i class="fa fa-sticky-note-o" aria-hidden="true"></i>
					                                                                                </a>
			                                                                                    </div>
			                                                                                </div>

																							<div class="hidethis">
			                                                                                	<div class="tradelogbox" id="tradelognotes_<?php echo $data_stock; ?>">
			                                                                                    	<div class="entr_ttle_bar">
																				                    	<strong><?php echo $data_stock; ?></strong> <span class="datestamp_header"><?php echo $data_sellmonth; ?> <?php echo $data_sellday; ?>, <?php echo $data_sellyear; ?></span>
																				                    </div>
			                                                                                        <div class="trdlgsbox">

			                                                                                        	<div class="trdleft">
			                                                                                                <div class="onelnetrd"><span><strong>Strategy:</strong></span> <span><?php echo $data_trade_info[0]->strategy; ?></span></div>
			                                                                                                <div class="onelnetrd"><span><strong>Trade Plan:</strong></span> <span><?php echo $data_trade_info[0]->tradeplan; ?></span></div>
			                                                                                                <div class="onelnetrd"><span><strong>Emotion:</strong></span> <span><?php echo $data_trade_info[0]->emotion; ?></span></div>
			                                                                                                <div class="onelnetrd"><span><strong>Performance:</strong></span> <span class="<?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo ($dprofit > 0 ? '+' : '-'); ?><?php echo number_format( $dtlprofperc, 2, '.', ',' ); ?>%</span></div>
			                                                                                                <div class="onelnetrd"><span><strong>Outcome:</strong></span> <span class="<?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo ($dprofit > 0 ? 'Gain' : 'Loss'); ?></span></div>
			                                                                                            </div>
			                                                                                            <div class="trdright darkbgpadd">
			                                                                                            	<div><strong>Notes:</strong></div>
			                                                                                                <div><?php echo $data_trade_info[0]->tradingnotes; ?></div>
			                                                                                            </div>

			                                                                                        <div class="trdclr"></div>
			                                                                                        </div>

			                                                                                    </div>
			                                                                                </div>

			                                                                            </li>
																						<?php
																						$logcount++;
																					}
																					wp_reset_postdata();
																				} else {
																					?>
																						<li>No Trades yet.</li>
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

													<div class="totalpl">
														 <p>Total Profit/Loss as of <?php
														 date_default_timezone_set("Asia/Manila");
														  echo date("F j, Y"); ?>: <span class="totalplscore <?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>">₱<?php echo number_format( $totalprofit, 2, '.', ',' ); ?></span></p>
													</div>

                                                    <div class="adsbygoogle">
														<div class="box-portlet">

															<div class="box-portlet-content">
                                                            	<small>ADVERTISEMENT</small>
																<div class="adscontainer">
                                                                	<img src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png">
                                                                </div>
															</div>
														</div>
													</div>
													<br class="clear">
						                        </div>
						                        <style type="text/css">
						                        	.header-depo {
						                        		padding: 10px;
    													border-bottom: none;
						                        	}
						                        	.title-depo {
						                        		font-weight: 500;
						                        		font-family: 'Roboto', sans-serif;
						                        		font-size: 19px;
						                        		margin: 0;
						                        		color: #ffffff;
													    line-height: 1.428571429;
													    padding-bottom: 0 !important;
						                        	}
						                        	.close-depo {
						                        		opacity: 1;
						                        		padding: 0 !important;
						                        		margin: 0 !important;
						                        	}
						                        	.x-close-depo {
						                        		line-height: 0;
													    color: #ffffff;
													    text-shadow: none;
													    border: none;
													    font-weight: 400;
						                        	}
						                        	.footer-depo {
						                        		border: none;
													    padding: 0px 21px 10px 10px;
													    margin-top: 0;
													    text-align: right;
													    border-top: none;
						                        	}
						                        	.depo-mon-btn {
						                        		border-radius: 26px !important;
													    border: 1.3px solid #6583a8 !important;
													    padding: 4px 17px 2px 17px !important;
													    font-family: 'Nunito', sans-serif;
													    color: #6583a8;
													    background: none !important;
													    font-size: 15px;
    													font-weight: 500;
						                        	}
						                        	.depo-mon-btn:hover {
						                        		background-color: #123;
						                        	}
						                        	.depo-input-field {
						                        		background: #0b1d33 !important;
													    border: 1px solid #1e3554 !important;
													    border-radius: 25px;
													    width: 100%;
													    height: 40px;
													    color: #FFFFFE !important;
													    padding-left: 14px !important;
													    padding-bottom: 4px !important;
													    font-size: 13px;
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
													    padding-left: 16px;
													    margin-bottom: 2px;
													    font-weight: 400;
						                        	}
						                        	.depo-body {
						                        		position: relative;
    													padding: 0px 20px 10px 20px;
						                        	}
						                        	.active-funds {
						                        		display: block !important;
						                        	}
						                        	.button-funds {
						                        		padding: 6px 21px 0px 0px;
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
													});

													// 	var isopen1 = jQuery(".add-funds-show").hasClass("dropopen");

													// 	if (isopen1) {
													// 		jQuery(".add-funds-shows").hide().removeClass("dropopen");

													// 	} else {
													// 		jQuery(".add-funds-shows").hide().removeClass("dropopen");
													// 		jQuery(".add-funds-show").show().addClass("dropopen");
													// 	}

													// });

													// jQuery(".show-button2").click(function(e){
													// 	e.preventDefault();
													// 	var isopen1 = jQuery(".add-funds-shows").hasClass("dropopen");

													// 	if (isopen1) {
													// 		jQuery(".add-funds-show").hide().removeClass("dropopen");

													// 	} else {
													// 		jQuery(".add-funds-show").hide().removeClass("dropopen");
													// 		jQuery(".add-funds-shows").show().addClass("dropopen");
													// 	}

													// });
						                        </script>
						                        <div class="tab-pane" id="tab3">

						                        	<div class="ledgerbox">
                                                        <div class="box-portlet">

                                                            <div class="box-portlet-header">
                                                                Ledger
                                                                	<div class="button" style="float: right;">
                                                                	<a href="#" data-toggle="modal" data-target="#depositmods" class="deposit-btn">Add funds</a>
                                                                	<div class="modal fade" id="depositmods" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document" style="left: 0;">
																			<div class="modal-content">
																				<div class="modal-header header-depo">
																					<h5 class="modal-title title-depo" id="exampleModalLabel">Add Funds</h5>
																					<button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
																					<span aria-hidden="true" class="x-close-depo">&times;</span>
																					</button>
																				</div>
																				<hr class="style14 style15">
																				<div class="button-funds">
																					<a class="deposit-modal-btn show-button1" style="float: right;">Dividend Income</a>
																					<a class="deposit-modal-btn show-button2" style="float: right;">Deposit Funds</a>
																				</div>
																				<form action="/journal" method="post" class="add-funds-show">
																					<div class="modal-body depo-body">
																						<div class="dmainform">
																							<div class="dinnerform">
																								<div class="dinitem">
																									<h5 class="modal-title title-depo" id="exampleModalLabel">Deposit</h5>
																									<div class="dnlabel">Amount</div>
																									<div class="dninput"><input type="text" name="damount" class="depo-input-field"></div>
																								</div>
																							</div>
																						</div>
																					</div>

																					<div class="modal-footer footer-depo">
																						<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
																						<input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
																						<input type="hidden" name="istype" value="deposit">
																						<input type="submit" name="subs" value="Deposit now" class="depo-mon-btn">
																						<!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
																					</div>
																				</form>
																				<form action="/journal" method="post" class="add-funds-shows" style="display: none;">
																						<div class="modal-body depo-body">
																							<div class="dmainform">
																								<div class="dinnerform">
																									<div class="dinitem">
																										<h5 class="modal-title title-depo" id="exampleModalLabel">Dividend Income</h5>
																										<div class="dnlabel">Amount</div>
																										<div class="dninput"><input type="text" name="damount" class="depo-input-field"></div>
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="modal-footer footer-depo">
																							<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
																							<input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
																							<input type="hidden" name="istype" value="dividend">
																							<input type="submit" name="subs" value="Deposit now" class="depo-mon-btn">
																							<!-- <input type="submit" name="subs" value="Deposit Now!" class="depo-mon-btn"> -->
																							<!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
																						</div>
																				</form>
																			</div>
																		</div>
																	</div>
																	<?php if ($dbaseaccount > 0): ?>
																		<a href="#" data-toggle="modal" data-target="#withdrawmods" class="withdraw-btn">Withdraw</a>
																		<div class="modal fade" id="withdrawmods" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																			<div class="modal-dialog" role="document" style="left: 0;">
																				<div class="modal-content">
																					<form action="/journal" method="post">
																						<div class="modal-header header-depo">
																							<h5 class="modal-title title-depo" id="exampleModalLabel">Withdraw</h5>
																							<button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
																							<span aria-hidden="true" class="x-close-depo">&times;</span>
																							</button>
																						</div>
																						<hr class="style14 style15">
																						<div class="modal-body depo-body">
																							<div class="dmainform">
																								<div class="dinnerform">
																									<div class="dinitem">
																										<div class="dnlabel">Amount</div>
																										<div class="dninput"><input type="number" class="dwithdrawnum depo-input-field sss" data-dpower="<?php echo $dbaseaccount; ?>" name="damount" placeholder="<?php echo number_format($dbaseaccount, 2, '.', ',' ); ?>"></div>
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="modal-footer footer-depo">
																							<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
																							<input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
																							<input type="hidden" name="istype" value="withraw">
																							<input type="submit" class="dwidfunds depo-mon-btn" name="subs" value="Withraw funds">
																							<!-- <button type="button" class="btn btn-primary">Deposit Now!</button> -->
																						</div>
																					</form>
																				</div>
																			</div>
																		</div>
																		<!-- Button trigger modal -->
																		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
																		Launch demo modal
																		</button>

																		<!-- Modal -->
																		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																			</div>
																			<div class="modal-body">
																			...
																			</div>
																			<div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																			<button type="button" class="btn btn-primary">Save changes</button>
																			</div>
																		</div>
																		</div>
																		</div>
																	<?php endif ?>
                                                                </div>
                                                            </div>
                                                            	<?php
                                                            		function date_sort($a, $b) {
																	    return strtotime($a->date) - strtotime($b->date);
																	}
																	usort($dledger, "date_sort");

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
																		$dmoninner =[];
																		$dmoninner['ismonth'] = $sepmonthvalue;
																		$dmoninner['isdata'] = [];
																		$dmoninner['totalwith'] = 0;
																		$dmoninner['totaldepo'] = 0;
																		foreach ($dledger as $dmntskey => $dmntsvalue) {
																			if ($sepmonthvalue == $dmntsvalue->ismonth) {
																				array_push($dmoninner['isdata'], $dmntsvalue);
																				if ($dmntsvalue->trantype == "deposit") {
																					$dmoninner['totaldepo'] += $dmntsvalue->tranamount;
																					$dending = $dending + $dmntsvalue->tranamount;
																				} elseif($dmntsvalue->trantype == "withraw") {
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
                                                                                    <div style="width:19%">Month</div>
                                                                                    <div style="width:19%">Starting Balance</div>
                                                                                    <!-- <div style="width:14%">Perfomance</div> -->
                                                                                    <!-- <div style="width:14%">Profit/Loss</div> -->
                                                                                    <div style="width:19%">Withdrawals</div>
                                                                                    <div style="width:19%">Deposits</div>
                                                                                    <div style="width:19%">Ending Balance</div>
                                                                                </div>
                                                                            </li>
                                                                            <?php
                                                                            	$mstart = 0;
                                                                            	foreach ($dmonthdata as $dmdkey => $dmdvalue) { ?>
                                                                            		<li class="dspecitem">
		                                                                            	<div style="width:99%;">
		                                                                                    <div style="width:19%"><?php echo $dmdvalue['ismonth']; ?></div>
		                                                                                    <div style="width:19%">₱<?php echo number_format( $mstart, 2, '.', ',' ); ?></div>
		                                                                                    <!-- <div style="width:14%"><?php /*?>Perfomance<?php */?>15.20%</div> -->
		                                                                                    <!-- <div style="width:14%"><?php /*?>Profit/Loss<?php */?>₱15,199.00</div> -->
		                                                                                    <div style="width:19%">₱<?php echo number_format( $dmdvalue['totalwith'], 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:19%">₱<?php echo number_format( $dmdvalue['totaldepo'], 2, '.', ',' ); ?></div>
		                                                                                    <div style="width:19%">₱<?php echo number_format( $dmdvalue['isenfing'], 2, '.', ',' ); ?></div>
		                                                                                </div>
		                                                                                <div class="ddetailshere">
		                                                                                	<div class="inner">
		                                                                                		<ul>
		                                                                                			<li class="dtitle">
		                                                                                				<div style="width:99%;">
		                                                                                					<div style="width:33%">Date</div>
			                                                                                				<div style="width:33%">Transacrion</div>
			                                                                                				<div style="width:33%">Amount</div>
		                                                                                				</div>
		                                                                                			</li>
		                                                                                			<?php foreach ($dmdvalue['isdata'] as $dsubdkey => $dsubdvalue): ?>
		                                                                                				<?php if ($dsubdvalue->trantype == 'deposit' || $dsubdvalue->trantype == 'withdraw'): ?>
		                                                                                					<li>
		                                                                                						<div style="width:33%"><?php echo date("F d, Y", strtotime($dsubdvalue->date)); ?></div>
		                                                                                						<div style="width:33%"><span class="dtrantype"><?php echo $dsubdvalue->trantype; ?></span></div>
		                                                                                						<div style="width:33%">₱<?php echo number_format( $dsubdvalue->tranamount, 2, '.', ',' ); ?></div>
		                                                                                					</li>
		                                                                                				<?php endif ?>
	                                                                                				<?php endforeach ?>
		                                                                                	</div>
		                                                                                </div>
		                                                                            </li>
                                                                            	<?php
                                                                            	$mstart = $dmdvalue['isenfing'];
                                                                            	}
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal -->

                                                        </div>
                                                    </div>
                                                	<br class="clear">

                                                    <div class="adsbygoogle">
														<div class="box-portlet">

															<div class="box-portlet-content">
                                                            	<small>ADVERTISEMENT</small>
																<div class="adscontainer">
                                                                	<img src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png">
                                                                </div>
															</div>
														</div>
													</div>
													<br class="clear">

						                        </div>
						                        <div class="tab-pane" id="tab4">

                                               		<div data-provide="calendar"></div>

                                                    <div class="adsbygoogle">
														<div class="box-portlet">

															<div class="box-portlet-content">
                                                            	<small>ADVERTISEMENT</small>
																<div class="adscontainer">
                                                                	<img src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png">
                                                                </div>
															</div>
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
    <script type="text/javascript">
        function editEvent(event) {
        jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
        jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
        jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
        jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
        jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
        jQuery('#event-modal').modal();
    }

    function deleteEvent(event) {
        var dataSource = jQuery('#calendar').data('calendar').getDataSource();

        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource.splice(i, 1);
                break;
            }
        }

        jQuery('#calendar').data('calendar').setDataSource(dataSource);
    }

    function saveEvent() {
        var event = {
            id: jQuery('#event-modal input[name="event-index"]').val(),
            name: jQuery('#event-modal input[name="event-name"]').val(),
            location: jQuery('#event-modal input[name="event-location"]').val(),
            startDate: jQuery('#event-modal input[name="event-start-date"]').datepicker('getDate'),
            endDate: jQuery('#event-modal input[name="event-end-date"]').datepicker('getDate')
        }

        var dataSource = jQuery('#calendar').data('calendar').getDataSource();

        if(event.id) {
            for(var i in dataSource) {
                if(dataSource[i].id == event.id) {
                    dataSource[i].name = event.name;
                    dataSource[i].location = event.location;
                    dataSource[i].startDate = event.startDate;
                    dataSource[i].endDate = event.endDate;
                }
            }
        }
        else
        {
            var newId = 0;
            for(var i in dataSource) {
                if(dataSource[i].id > newId) {
                    newId = dataSource[i].id;
                }
            }

            newId++;
            event.id = newId;

            dataSource.push(event);
        }

        jQuery('#calendar').data('calendar').setDataSource(dataSource);
        jQuery('#event-modal').modal('hide');
    }

    jQuery(function() {
        var currentYear = new Date().getFullYear();

        jQuery('#calendar').calendar({
            enableContextMenu: true,
            enableRangeSelection: true,
            contextMenuItems:[
                {
                    text: 'Update',
                    click: editEvent
                },
                {
                    text: 'Delete',
                    click: deleteEvent
                }
            ],
            selectRange: function(e) {
                editEvent({ startDate: e.startDate, endDate: e.endDate });
            },
            mouseOnDay: function(e) {
                if(e.events.length > 0) {
                    var content = '';

                    for(var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                        + '<div class="event-location">' + e.events[i].location + '</div>'
                                    + '</div>';
                    }

                    jQuery(e.element).popover({
                        trigger: 'manual',
                        container: 'body',
                        html:true,
                        content: content
                    });

                    jQuery(e.element).popover('show');
                }
            },
            mouseOutDay: function(e) {
                if(e.events.length > 0) {
                    jQuery(e.element).popover('hide');
                }
            },
            dayContextMenu: function(e) {
                jQuery(e.element).popover('hide');
            },
            dataSource: [
                {
                    id: 0,
                    name: 'Google I/O',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 4, 28),
                    endDate: new Date(currentYear, 4, 29)
                },
                {
                    id: 1,
                    name: 'Microsoft Convergence',
                    location: 'New Orleans, LA',
                    startDate: new Date(currentYear, 2, 16),
                    endDate: new Date(currentYear, 2, 19)
                },
                {
                    id: 2,
                    name: 'Microsoft Build Developer Conference',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 3, 29),
                    endDate: new Date(currentYear, 4, 1)
                },
                {
                    id: 3,
                    name: 'Apple Special Event',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 8, 1),
                    endDate: new Date(currentYear, 8, 1)
                },
                {
                    id: 4,
                    name: 'Apple Keynote',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 8, 9),
                    endDate: new Date(currentYear, 8, 9)
                },
                {
                    id: 5,
                    name: 'Chrome Developer Summit',
                    location: 'Mountain View, CA',
                    startDate: new Date(currentYear, 10, 17),
                    endDate: new Date(currentYear, 10, 18)
                },
                {
                    id: 6,
                    name: 'F8 2015',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 2, 25),
                    endDate: new Date(currentYear, 2, 26)
                },
                {
                    id: 7,
                    name: 'Yahoo Mobile Developer Conference',
                    location: 'New York',
                    startDate: new Date(currentYear, 7, 25),
                    endDate: new Date(currentYear, 7, 26)
                },
                {
                    id: 8,
                    name: 'Android Developer Conference',
                    location: 'Santa Clara, CA',
                    startDate: new Date(currentYear, 11, 1),
                    endDate: new Date(currentYear, 11, 4)
                },
                {
                    id: 9,
                    name: 'LA Tech Summit',
                    location: 'Los Angeles, CA',
                    startDate: new Date(currentYear, 10, 17),
                    endDate: new Date(currentYear, 10, 17)
                }
            ]
        });

        jQuery('#save-event').click(function() {
            saveEvent();
        });
    });
	jQuery(document).ready(function(){
		jQuery("li.dspecitem").click(function(e){
			if (jQuery(this).hasClass("ledgeopened")) {
				jQuery(this).removeClass("ledgeopened");
				jQuery(this).find(".ddetailshere").hide('slow');
			} else {
				jQuery(this).addClass("ledgeopened");
				jQuery(this).find(".ddetailshere").show('slow');
			}

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
	});
    </script>

<script language="javascript">
	// Chart 1 - Current Allocation
	AmCharts.makeChart("chartdiv1",
		{
			"type": "pie",
			"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
			"innerRadius": "40%",
			"labelRadius": 10,
			"colors": [
				<?php echo $currentaloccolor; ?>
			],
			"labelColorField": "#FFFFFF",
			"labelsEnabled": false,
			"labelTickAlpha": 1,
			"labelTickColor": "#FFFFFF",
			"pullOutDuration": 11,
			"startEffect": "easeOutSine",
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
				"valueWidth": 55
			},
			"titles": [],
			"dataProvider": [
				<?php echo $currentalocinfo; ?>
			]
		}
	);
	// Chart 2 - Monthly Performance (Bar)
	AmCharts.makeChart("chartdiv2",
		{
			"type": "serial",
			"categoryField": "category",
			"columnWidth": 0,
			"minSelectedTime": 5,
			"mouseWheelScrollEnabled": true,
			"addClassNames": true,
			"autoMarginOffset": 0,
			"marginTop": 10,
			"plotAreaBorderColor": "#FFFFFF",
			"zoomOutText": "Reset",
			"startDuration": 1,
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

	// Chart 4a - Trade Statistics (chartdiv4a)
	var chart = AmCharts.makeChart("chartdiv4a", {
	  "type": "pie",
	  "startDuration": 0,
	  "theme": "none",
	  "marginBottom": 0,
	  "marginTop": 0,
	  "marginLeft": 0,
	  "marginRight": 0,
	  "labelsEnabled": false,
	  "addClassNames": true,
	  "fontFamily": "Roboto",
	  "fontSize": 11,
	  "color": "#d8d8d8",
	  "innerRadius": "30%",
	  "colors": [
		"#00E676",
		"#ff1744"
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
	  "dataProvider": [{
		"stats": "Win",
		"vals": <?php echo $iswin; ?>
	  }, {
		"stats": "Losses",
		"vals": <?php echo $isloss; ?>
	  }],
	  "valueField": "vals",
	  "titleField": "stats",
	  "export": {
		"enabled": false
	  }
	});

	// Chart 4b - Win Allocations (chartdiv4b)
	var chart = AmCharts.makeChart("chartdiv4b", {
	  "type": "pie",
	  "startDuration": 0,
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
		"valueWidth": 25
	  },
	  "color": "#d8d8d8",
	  "innerRadius": "30%",
	  "colors": [
		"#00e676",
		"#02d471",
		"#04c16d",
		"#06af68",
		"#089c63",
		"#0b7d55",
		"#0d6d52",
		"#0f5a4f",
		"#11484c",
		"#133e4a"
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

	// Chart 5 - Strategy Statistics
	AmCharts.makeChart("chartdiv5",
{
	"type": "serial",
	"categoryField": "category",
	"rotate": true,
	"autoMarginOffset": 5,
	"marginLeft": 10,
	"marginRight": 10,
	"marginTop": 5,
	"startDuration": 1,
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
			"fixedColumnWidth": 10,
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
			"yField": "color"
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
			"fixedColumnWidth": 10,
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
			"yField": "color"
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
			"startDuration": 1,
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
			"dataProvider": [<?php echo $dailyvolumes; ?>]
		}
	);

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
			"startDuration": 1,
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
			"startDuration": 1,
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
			"startDuration": 1,
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

	// Chart 11 - Emotional Statistics
	AmCharts.makeChart("chartdiv11",
		{
			"type": "serial",
			"categoryField": "category",
			"rotate": true,
			"marginTop": 5,
			"startDuration": 1,
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
					"valueField": "Trades"
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
					"valueField": "column-2"
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

	/* Top Stocks: Winners */
	var gaugeChart = AmCharts.makeChart("topstockswinners", {
	  "type": "gauge",
	  "theme": "none",
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

	/* Top Stocks: Losers */
	var gaugeChart = AmCharts.makeChart("topstocksLosers", {
	  "type": "gauge",
	  "theme": "none",
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

</script>

</div>
<?php get_footer();
