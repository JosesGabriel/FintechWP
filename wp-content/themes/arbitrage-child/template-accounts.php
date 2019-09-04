<?php
	/*
	* Template Name: Accounts Template
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

	$topargs = array(
	    'role'          =>  '',
	    // 'meta_key'      =>  'account_status',
	    // 'meta_value'    =>  'approved'
	);

	$users = get_users($topargs);
	$newuserlist = array();
	foreach ($users as $key => $value) {
		$userdetails['id'] = $value->ID;
		$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
		$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
		$userdetails['user_nicename'] = $value->data->user_nicename;

		array_push($newuserlist, $userdetails);
	}

	usort($newuserlist, function($a, $b) {
	    return $a['followers'] <=> $b['followers'];
	});
	$toptraiders = array_reverse($newuserlist);


?>
<!--
	background: #142c46;
    border-top-left-radius: 25px;
    border-top-right-radius: 25px; -->


<style type="text/css">
    .btn-tradelog {
        border-radius: 0px;
        margin: 10px 0px;
        background: #273647;
        border: 1px solid #273647;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .side-header .right-image .onto-user-name {
        margin-bottom: 5px;
	    font-family: 'Roboto', sans-serif !important;
	    text-transform: capitalize;
	    font-size: 13px;
    }
	html {
		background: #0d1f33 !important;
	}
	.right-dashboard-part{
	    float: left;
	    width: 30% !important;
	    padding: 21px 0px !important;
	    height: 140%;
	    position: -webkit-sticky;
	    position: sticky;
	    top: -112%;
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
	    background-color: #eb4d5c;
	    border-radius: 50px;
		width: 56px;
	}

	.dbox.green {
	    padding: 6px 12px;
	    background-color: #53b987;
	    border-radius: 50px;
	    width: 56px;
	}

	td.to-stock a {
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
		border: 1.3px solid #6583a8 !important;
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
	    /* bottom: 0; */
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
	    /* margin-top: 19px; */
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

	.um-activity-new-post .um-activity-foot .um-activity-right a {
	    /*color: #ffffff !important;
	    padding: 8px 24px !important;
	    line-height: 1em !important;
	    height: initial !important;
	    margin-top: 10px !important;
	    font-size: 12px !important;
	    font-weight: normal !important;
	     text-transform: uppercase !important;
	    border-radius: 6px !important;
	    background: #2196f3 !important;*/
	    border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    padding: 0px 17px !important;
	    font-family: 'Nunito', sans-serif;
	    color: #6583a8;
	    background-color: none !important;
	    background: none !important;
	}
	.um-activity-left .um-activity-actions {
		display: none !important;
	}
	.um-activity-widget .um-activity-foot.status div > a {
		background: none !important;
		border-radius: 50px;
	}
	.um-activity-actions {
	    width: 100%;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bearish {
	    margin-left: 10px;/*
	    background: #142c46;*/
	    width: auto;
	    display: inline-block;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish {
	    margin-left: 17px;/*
	    background: #142c46;*/
	    display: inline-block;
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
	    background: #142c46;
	    padding: 7px 6px;
	    border-radius: 50px;
	    -webkit-transition: all .5s ease-in-out;
	    -moz-transition: all .5s ease-in-out;
	    -o-transition: all .5s ease-in-out;
	    transition: all .5s ease-in-out;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bearish a span.diconbase {
	    background: #142c46;
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
	.watch-list-inner .to-top-title,
	.top-stocks .to-top-title,
	.top-traiders-inner .to-top-title,
	.watch-list-inner .to-bottom-title,
	.top-traiders-inner .to-bottom-title,
	.top-stocks .to-bottom-title,
	.latest-news .to-top-title,
	.latest-news .to-bottom-title{
		background: transparent;
		padding: 10px 14px 10px 1px;
		font-size: 15px;
		font-weight: normal;
	}
	.watch-list-inner .to-top-title {
        padding: 10px 14px 0px 14px !important;
    }
    .style18 {
    	width: 92% !important;
    	margin-bottom: 0;
    	margin-top: 9px;
    }
    .watch-list {
    	background: #142c46;
    	margin-top: 15px;
    }
    .latest-news {
    	background: #142c46;
    	margin-top: 15px;
    }
    .latest-news .to-top-title {
	    padding: 10px 14px 2px 14px !important
	}
	.srr-tab-wrap > li.srr-active-tab {
	    border-bottom: solid 2px #ffeb3b !important;
	    background: none !important;
	    border-radius: 0;
	}
	.srr-tab-wrap li {
		border: none;
	}
    .srr-tab-wrap {
	    margin: 0px 0 10px!important;
	    background: none!important;
	    border: none!important;
	    padding: 0!important;
	}
	.srr-tab-wrap > li {
	    background: none;
	    border: none !important;
	    font-size: 11px;
	    text-transform: uppercase;
	}
	.latest-news .to-content-part {
		height: 279px;
	}
	.srr-tab-wrap li {
    	margin: 0px 5px 0 0!important;
	}
	.um-activity-bodyinner-photo {
		padding-top: 4px;
    	background-color: #142c46;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish a span.diconbase {
		/*border: #25ae5f solid 2px !important;*/
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish:hover a span.diconbase {
		transform: scale(1.3);
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bearish a span.diconbase {
		/*border: #d04234 solid 2px !important;*/
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bearish:hover a span.diconbase {
		transform: scale(1.3);
	}
	.um-activity-comment-data {
		background-color: #2b405b3d;
	    padding: 6px 12px 7px 14px;
	    border-radius: 25px;
	}
	.um-activity-comment-child {
	    border-left: none !important;
	}
	.um-activity-comment-meta {
		padding-left: 15px;
	}
	.um-activity-commentl .um-activity-comment-area .um-activity-comment-avatar {
	    width: 31px;
	    height: 31px;
		visibility: visible;
	    position: absolute;
	    z-index: 9999;
	}
	.add-post .um-activity-comments .um-activity-commentl.um-activity-comment-area .um-activity-comment-avatar {
	    left: 5px;
	    top: 5px;
	    visibility: visible;
	    position: absolute;
	    z-index: 0;
	}
	.um-activity-comment-avatar.hidden-0 {
	    margin-left: 5px !important;
	    position: absolute !important;
	    top: -3px;
	}
	.um-activity-comment-info .um-activity-comment-avatar img, .um-activity-comment-child .um-activity-comment-avatar img  {
	    width: 100%;
	    height: 100%;
	    top: 5px;
    	position: relative;
	}
	.um-activity-comment-info .um-activity-comment-avatar img, .um-activity-comment-child .um-activity-comment-avatar img .um-avatar-uploaded  {
	    width: 100% !important;
	    height: 100% !important;
	    top: 0px;
    	position: relative;
	}
	.um-activity-comment-info .um-activity-comment-area {
	    margin-top: 8px;
	    padding-bottom: 2px !important;
	}
	.um-activity-comment-child {
	    padding-left: 5px;
	}
	.um a.um-link {
	    color: #6583a8 !important;
	    text-transform: capitalize;
	}
	.um-activity-widget .um-activity-comments .um-activity-comment-text {
	    color: #fff !important;
	    font-size: 13px !important;
	    letter-spacing: 0.1px;
	}
	.um-activity-ccommentload {
		padding-top: 10px;
	}
	.um-activity-commentl.is-child .um-activity-comment-hidden {
	    padding-top: 7px;
	}
	.um-activity-comment-textarea .ui-autocomplete-input .ui-autocomplete-loading {
		height: auto !important;
	}
	.auto-height {
		height: 40px !important;
	}
	.arb_watchlst_cont table tbody tr td {
		text-align: left !important;
	}
	.vertical-box table tbody tr td div {
	     display: block !important;
	     padding-bottom: 3px !important;
	}
	.vertical-box table tbody tr td {
	    padding-left: 6px !important;
	}
	.et_fixed_nav.et_show_nav #page-container, .et_non_fixed_nav.et_transparent_nav.et_show_nav #page-container {
		padding-top: 0;
	}
	.um-account-nav a {
		color: #fffffe;
	}
	.left-dashboard-part {
		display: none;
	}
	.center-dashboard-part {
		width: 80%;
	}
	div.uimob800 .um-account-side {
    	padding: 0 0px;
	    /*padding-top: 14px;*/
	    /*background: #142c46;*/
    	border-radius: 4px;
	    width: 24%;
    	/* text-align: center; */
	    /* text-align: center; */
	}
	.um-account-meta {
	    text-align: center;
	    margin-bottom: 20px;
	    border-radius: 100px;
	    overflow: hidden;
	}
	div.uimob800 .um-account-meta a, div.uimob800 .um-account-meta img {
	    display: block;
	    overflow: hidden;
	    -moz-border-radius: 3px;
	    -webkit-border-radius: 3px;
	    border-radius: 100px;
	    max-width: 100%;
	    height: auto;
	    border: solid #142c46 3px;
	    margin-left: auto !important;
    	margin-right: auto !important;
	}
	.um-account-meta img {
	    margin: 0 !important;
	    position: static !important;
	    float: none !important;
	    display: inline-block;
	}
	div.uimob800 .um-account-meta a {
		border: none;
	}
	div.uimob800 .um-account-side ul li a {
	    overflow: hidden;
	    width: 100%;
	    height: 38px;
	    margin: 0 0;
	    border-radius: 0 !important;
	}
	div.uimob800 .um-account-side ul li a.current {
		background: none;
	}
	div.uimob800 .um-account-side ul li a span span {
		background: none;
		font-size: 12px;
		color: #fffffe;
		font-family: 'Roboto', sans-serif !important;
		padding-left: 12px;
		font-weight: 500;
	}
	div.uimob800 .um-account-side li a span.um-account-icontip {
	    display: block;
	    float: left;
	    text-align: left;
	    width: 100%;
	    height: 100%;
	    font-size: 22px;
	    line-height: 29px;
	    padding-left: 9px;
	    padding: 2px 7px;
	    border-radius: 4px;
	}
	div.uimob800 .um-account-side li a span.um-account-icontip:hover {
	    background: #12273e;
	    text-decoration: none;
	    border-radius: 4px;
	}
	.um-account-side li a.current, .um-account-side li a.current:hover {
		font-weight: 400;
	}
	div.uimob800 .um-account-main {
		width: 75%;
	}
	.account_page {
	    width: 100%;
	    margin: 11px auto;
	}
	div.uimob800 .um-account-side ul li a.current {
	    background: #142c46 !important;
	    border-radius: 4px !important;
	}
	div.uimob800 .um-account-side ul li a.current:hover {
	    background: #12273e !important;
	    border-radius: 4px !important;
	}
	div.uimob800 .um-account-side ul li a:hover {
	    background: #12273e !important;
	    border-radius: 4px !important;
	}
	.um-account-main {
	    float: left;
	    width: 50%;
	    padding: 0 15px !important;
	    box-sizing: border-box;
	}
	div.uimob800 .um-account-side ul li {
		margin-bottom: 0 !important;
	}
	.um-account-main div.um-account-heading {
		padding-left: 15px;
	}
	.um-account-main .um-account-tab .um-field .um-field-area input, .um-account-main .um-account-tab .um-field .um-field-area select {
	    background: #142c46 !important;
	    color: #fff;
	    font-size: 13px !important;
	    border: 0 none !important;
	    border-radius: 50px;
	}
	.um-account-main .um-account-tab input[type="submit"] {
		border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    /* padding: 0px 17px !important; */
	    font-family: 'Roboto', sans-serif;
	    color: #6583a8;
	    background: none !important;
	    text-transform: capitalize !important;
	}
	.um-left {
	    float: right;
	}
	.um-account-main .um-account-tab input[type="submit"]:hover {
		background: #091523 !important;
	    color: #6482a7 !important;
	}
	input[type=submit].um-button, input[type=submit].um-button:focus {
		padding: 10px 15px !important;
		font-size: 12px;
	}
	.um-account-meta {
		display: none;
	}
	.select2.select2-container .select2-selection {
		background: #142c46 !important;
	    color: #fff !important;
	    font-size: 13px !important;
	    border: 0 none !important;
	    border-radius: 50px !important;
	}
	.select2.select2-container .select2-selection .select2-selection__arrow {
		top: 3px !important;
		right: 3px !important;
	}
	.select2.select2-container .select2-selection .select2-selection__arrow:before {
		content: "\f3d0" !important;
	    font-size: 20px !important;
	    font-family: "Ionicons" !important;
	    width: 100% !important;
	    display: block;
	    height: 100%;
	    line-height: 35px;
	    color: #f7fff8;
	}
	.select2-container.select2-container--open .select2-dropdown {
		border: none;
	}
	.select2-dropdown {
		background-color: #142c46;
	    border: 1px solid #aaa;
	    border-radius: 4px;
	    box-sizing: border-box;
	    display: block;
	    position: absolute;
	    left: -100000px;
	    width: 100%;
	    z-index: 1051;
	}
	.select2-container.select2-container--open .select2-dropdown {
		border: none !important;
	}
	.select2-search--dropdown {
		display: block;
    	padding: 6px;
	}
	.select2-container--default .select2-search--dropdown .select2-search__field {
		border: none;
	    background: #102235;
	    border-radius: 5px;
	    margin: 3px auto;
	    color: #fffffe !important;
	}
	.select2-container--default .select2-results__option[aria-selected=true] {
		background-color: #0d1d2d;
    	border-radius: 25px;
	}
	.select2-results li {
		color: #fffffe !important;
	}
	.select2-results li.select2-results__option.select2-results__option--highlighted {
		background: #102235 !important;
	    color: #fffffe !important;
	    border-radius: 25px;
	}
	.select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		border-radius: 11px;
		background-color: #0f121d;
	}

	.select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar
	{
		width: 10px;
		border-radius: 25px;
		background-color: none;
	}

	.select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar-thumb
	{
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
		background-color: #34495e;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #fffffe;
	}
	.select2-container--open .select2-dropdown--above {
		border-bottom-left-radius: 6px;
		border-bottom-right-radius: 6px;
	}
	.um-form input[type=text], .um-form input[type=tel],
	.um-form input[type=number], .um-form input[type=password],
	.um-form input[type=email] {
		padding: 0 12px !important;
	    width: 100%;
	    display: block !important;
	    -moz-border-radius: 2px;
	    -webkit-border-radius: 2px;
	    border-radius: 2px;
	    outline: none !important;
	    cursor: text !important;
	    font-size: 15px !important;
	    height: 40px !important;
	    box-sizing: border-box !important;
	    box-shadow: none !important;
	    margin: 0 !important;
	    position: static;
	    outline: none !important;
	}
	.um-field {
		color: #bfbfbf;
	}
	.um-field-half {
	    width: 20%;
	    float: left;
	    margin-left: 15px;
	}
	.um-field-half.right {
	    float: left;
	}
	.um-field-radio:hover i {
		color: #3ba1da;
	}
	.um-icon-android-radio-button-off:hover i {
		color: #3ba1da !important;
	}
	span.um-field-checkbox-option {
		display: block;
	}
	.um-field-checkbox {
		margin-left: 15px;
	}
	#um_user_photos_download_all {
	    background: none;
	    /* border: 2px solid #d7a60e !important; */
	    border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    /* padding: 0px 17px !important; */
	    font-family: 'Roboto', sans-serif;
	    color: #6583a8;
	    background: none !important;
	    text-transform: capitalize !important;
	    width: 48%;
	    float: left;
	    padding: 10px 15px !important;
	    margin: 0px 7px 0px 0px;
	}
	#um_user_photos_delete_all {
		border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    /* padding: 0px 17px !important; */
	    font-family: 'Roboto', sans-serif;
	    color: #6583a8;
	    background: none !important;
	    text-transform: capitalize !important;
	    width: 49%;
	    padding: 10px 15px !important;
	    /* margin: 0px 5px; */
	}
	#um_user_photos_delete_all:hover {
		background: #091523 !important;
	    color: #6482a7 !important;
	}
	#um_user_photos_download_all:hover {
		background: #091523 !important;
	    color: #6482a7 !important;
	}
	.um-account-tab-delete p {
	    color: #bfbfbf;
	}
	.um-form input[type=text], .um-form input[type=tel],
	.um-form input[type=number], .um-form input[type=password],
	.um-form input[type=email] {
		padding: 0 16px !important;
	}
	label {
		margin-bottom: 2px !important
	}
	.um-account-main p {
		margin-left: 15px !important;
	}
	.um-provider-conn {
		margin-left: 15px;
	}
	.um-account-main .um-account-tab .um-field .um-provider-title {
		margin-left: 15px;
	}
	.um-field {
		position: relative;
	    padding: 15px 3px 0 3px;
	}
	.um-field-billing_first_name {
		width: 48%;
		display: inline-block !important;
	}
	.um-field-billing_last_name {
		width: 48%;
		display: inline-block !important;
	}
	.um-field-billing_address_1 {
		width: 48%;
		display: inline-block !important;
	}
	.um-field-billing_address_2 {
		width: 48%;
		display: inline-block !important;
	}
	.select2-dropdown--below {
    	top: 3px;
    	border-radius: 5px;
    	border-top-left-radius: 5px !important;
    	border-top-right-radius: 5px !important;
	}
	.select2-dropdown--above {
    	top: -3px;
    	border-radius: 5px;
	}
	.select2-search--dropdown {
    	border-top-left-radius: 5px !important;
    	border-top-right-radius: 5px !important;
	}
	.inner-placeholder {
		padding-top: 0%;
	}
	#droppouts {
	    font-size: 13px !important;
	    /* display: none; */
	    position: absolute !important;
	    right: -1px !important;
	    background: #142c46 !important;
	    min-width: 200px !important;
	    text-align: left !important;
	    margin-top: 9px !important;
	    border: none !important;
	    border-radius: 4px !important;
	    box-shadow: rgba(7, 13, 19, 0.52) 0px 2px 4px 1px;
	}
	ul.main-drop > ul:before {
	    bottom: 100%;
	    right: 2%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-color: rgba(194, 225, 245, 0);
	    border-bottom-color: #142c46;
	    border-width: 10px;
	    margin-left: -36px;
	}
	ul.main-drop > ul li {
	    padding: 5px 15px;
	    font-family: 'roboto',sans-serif;
	}

	ul.main-drops > ul li:hover {
	    background: #0d1f33 !important;
	}


</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.um-faicon-user').html('<img src="https://arbitrage.ph/svg/account.svg" style="width: 20px;">');
		jQuery('.um-faicon-user').removeClass('um-faicon-user');

		jQuery('.um-faicon-asterisk').html('<img src="https://arbitrage.ph/svg/user-key-account3.svg" style="width: 19px;">');
		jQuery('.um-faicon-asterisk').removeClass('um-faicon-asterisk');

		jQuery('.um-faicon-credit-card').html('<img src="https://arbitrage.ph/svg/real-estate2.svg" style="width: 20px;">');
		jQuery('.um-faicon-credit-card').removeClass('um-faicon-credit-card');

		jQuery('.um-faicon-shopping-cart').html('<img src="https://arbitrage.ph/svg/shopping-cart1.svg" style="width: 20px;">');
		jQuery('.um-faicon-shopping-cart').removeClass('um-faicon-shopping-cart');

		jQuery('.um-faicon-download').html('<img src="https://arbitrage.ph/svg/download.svg" style="width: 20px;">');
		jQuery('.um-faicon-download').removeClass('um-faicon-download');

		jQuery('.um-faicon-lock').html('<img src="https://arbitrage.ph/svg/shield1.svg" style="width: 21px;">');
		jQuery('.um-faicon-lock').removeClass('um-faicon-lock');

		jQuery('.um-faicon-envelope').html('<img src="https://arbitrage.ph/svg/bell2.svg" style="width: 21px;">');
		jQuery('.um-faicon-envelope').removeClass('um-faicon-envelope');

		jQuery('.um-faicon-bell').html('<img src="https://arbitrage.ph/svg/bel-not4.svg" style="width: 21px;">');
		jQuery('.um-faicon-bell').removeClass('um-faicon-bell');

		jQuery('.um-faicon-sign-in').html('<img src="https://arbitrage.ph/svg/link1.svg" style="width: 20px;">');
		jQuery('.um-faicon-sign-in').removeClass('um-faicon-sign-in');

		jQuery('.um-faicon-image').html('<img src="https://arbitrage.ph/svg/photo1.svg" style="width: 20px;">');
		jQuery('.um-faicon-image').removeClass('um-faicon-image');

		jQuery('.um-faicon-trash-o').html('<img src="https://arbitrage.ph/svg/garbage1.svg" style="width: 20px;">');
		jQuery('.um-faicon-trash-o').removeClass('um-faicon-trash-o');

		jQuery(".um-field-nickname").find(".um-field-label label").text('Trading Name');
	});


</script>

<div id="main-content" class="ondashboardpage">

	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                    	<?php get_template_part('parts/sidebar', 'profile'); ?>

                        <?php get_template_part('parts/sidebar', 'traders'); ?>

					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 936px;">
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php //echo do_shortcode('[ultimatemember_activity form_id=dashboardwall]'); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
						the_content();
						endwhile; else: ?>
						<p>Sorry, no posts matched your criteria.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

                	<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>

                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>

                    <?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>

			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php

get_footer();
