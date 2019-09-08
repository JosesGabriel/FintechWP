<?php
	/*
	* Template Name: Members Directory
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

// add_user_meta( 19, 'user_secret', 'a67890');
// echo get_user_meta(5, 'user_secret', true);

date_default_timezone_set('Asia/Manila'); ?>

<style type="text/css">
	html {
		background: #0d1f33 !important;
	}
    .btn-tradelog {
        border-radius: 0px;
        margin: 10px 0px;
        background: #273647;
        border: 1px solid #273647;
        font-weight: 600;
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
	    border-radius: 50px !important;
	    color: #eb4d5c !important;
	}

	.dbox.green {
	    border-radius: 50px !important;
	    color: #53b987 !important;
	}

	td.to-stock a {
	}
	.stockperc {
		/*width: 42px;*/
		text-align: right;
		margin-top: 3px;
		font-weight: 400;
		font-size: 12px;
	}
	.one {
		font-weight: 500;
	}
	.two {
		font-weight: 500;
	}
	.twos {
		font-weight: 500;
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
	.six {
		font-weight: 500;
	}
	.seven {
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
    	color: #e77e24;
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
		color: #6583a8 !important;
		font-size: 20px;
		margin-top: 7px;
    	margin-right: 7px;
	}
	.to-content-part {
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
	.um-activity-new-post .um-activity-foot .um-activity-right a {
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
	.um-activity-dialog.um-activity-tool-dialog {
		display:none;
		right: 9px;
    	top: 24px;
	}
	.top-stocks {
		margin-bottom: 15px !important;
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
    .abcds .watch-list {
    	background: none !important;
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
	    border-left: none !important;
	    background: #11273e !important;
	}
	.srr-tab-wrap li {
		border-radius: 0;
		margin: 0px 0px 0 0!important;
	    width: 100%;
	    text-align: center;
	   	padding: 3px 7px !important;
	   	cursor: pointer;
	}
	.et_pb_widget ul li:hover {
		border-bottom: none !important;
		background: #12283f;
	}
    .srr-tab-wrap {
	    margin: 0 !important;
	    border: none!important;
	    position: absolute;
	    background: #123 !important;
	    z-index: 2;
	    right: 9px;
	    padding: 0px !important;
	    margin-top: -7px !important;
	    border-radius: 2px;
	    box-shadow: rgba(7, 13, 19, 0.42) 0px 2px 5px 0.1px;
	}
	.srr-tab-wrap > li {
	    background: none;
	    border-bottom: none !important;
	    border:none;
	    font-size: 11px;
	    font-weight: 400;
	    text-align: left;
	    text-transform: uppercase;
	}
	.latest-news .to-content-part {
		height: auto;
	}
	.um-activity-bodyinner-photo {
		padding-top: 4px;
    	background-color: #142c46;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish a span.diconbase {
		border: #25ae5f solid 2px !important;
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bullish:hover a span.diconbase {
		transform: scale(1.3);
	}
	.um-activity-widget .um-activity-foot.status .um-activity-bearish a span.diconbase {
		border: #d04234 solid 2px !important;
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
	.add-post .um-activity-wall .um-activity-body {
		background: #142c46;
	}
	.um-activity-left.um-activity-actions > div .dnumof {
		padding: 8px 0px 6px 0;
	}
	.ondashboardpage .um-activity-widget .um-activity-comments .um-activity-comment-box textarea.um-activity-comment-textarea {
		background: #11273e;
    	border: 1px solid #1e3554 !important;
	}
	.um-activity-widget .upload {
		height: 22px !important;
	}
	ul.main-drop > ul {
	    font-size: 13px !important;
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
	ul.main-drop > ul li a {
	    color: #fff !important;
	    display: block !important;
	    font-size: 12px !important;
	    font-weight: 500 !important;
	    font-family: 'roboto', sans-serif !important;
	}
	ul.main-drop > ul:before {
	    border-bottom-color: #142c46 !important;
	}
	ul.main-drop > ul li:hover {
	    background: #0d1f33;
	}
	ul.main-drop > ul li {
	    padding: 6px 15px;
	}
	ul.main-drop > ul li:first-child {
	    border-top-left-radius: 4px;
	    border-top-right-radius: 4px;
	}
	ul.main-drop > ul li:last-child {
	    border-bottom-left-radius: 4px;
	    border-bottom-right-radius: 4px;
	}
	ul.main-drop > ul li.onto-last-element {
		border-top: none;
	}
	.main-drops:hover {
		cursor: pointer;
	}
	.fa-plus-circle {
		color: #fffffe;
	}
	.srr-item-cont {
		display: block !important;
	    padding-top: 0px !important;
	    padding-left: 1px !important;
	    padding-right: 13px !important;
	    text-align: center !important;
	    top: -1px;
    	position: relative;
    	margin-bottom: 7px!important;
    	margin-top: 8px;
	    /* padding-top: 13px; */
	}
	time.srr-date {
		font-size: 20px;
    	line-height: 1.1;
    	font-weight: 300;
    	color: #ffeb3b;
	}
	time.srr-date div {
		font-size: 12px;
    	margin-top: -4px;
    	text-transform: uppercase;
	}
	.srr-wrap .srr-item > * {
		margin-bottom: 7px;
	}
	.srr-wrap .srr-item > *:last-child {
		margin-bottom: 0px !important;
	}
	.dauthor {
		color: #878a8e;
	}
	.um-activity-bodyinner-txt span.post-meta {
		width: 100%;
	}
	.srr-wrap.srr-style-none .srr-item {
		padding: 5px 0px 5px 0px !important;
	}
	.top-traiders .to-content-part .trader-item .traider-details .traider-name a {
		text-transform: capitalize;
	}
	.um-activity-widget .um-activity-body .um-activity-bodyinner .um-activity-bodyinner-txt {
		color: #fff;
	    background-color: #142c46;
	    padding-left: 0;
	}
	.um-padding-none {
		padding-left: 18px;
	}
	.even .to-watch-data:last-child {
		border: none;
	}
	.dcontent-wrap {
		padding-left: 0;
	}
	.popname ul {
	    margin: 0;
	    padding: 2px 9px;
	    text-align: left;
	}
	.popname ul li {
	    display: inline-block;
	    padding: 5px 6px;
	    line-height: 1em;
	    color: #fff;
	    border: none;
	    border-radius: 5px;
	    margin: 1px;
	    font-size: 12px;
	}
	.popname ul li:hover {
	    transition-duration: 0.3s;
	    background: #123;
	    cursor: pointer;
	}
	.add-post .um-activity-comments .um-activity-commentl.um-activity-comment-area {
		position: relative;
    	padding: 0 0 10px;
	}
	hr.style20 {
		position: relative;
	    top: 0px;
	    margin-top: 0rem !important;
	    margin-left: -15px;
	    border: 0;
	    height: 1px;
	    width: 107%;
	    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
	    margin-bottom: -1px !important;
	    display: flex;
	}
	.um-activity-confirm {
		color: #fff;
		background: #142c46;
		box-shadow: 0 1px 3px #111;
	}
	.um-activity-confirm-b a {
		color: #fff;
	}
	.um-activity-confirm-m {
		border-bottom: 1px solid #1e3554;
	}
	.um-activity-confirm-b a:hover, .um-activity-confirm-b a:active {
	    color: #fff;
	    text-decoration: none;
	    background: #1122338c !important;
	}
	.um-activity-dialog a:hover {
		background: #11273e !important;
	    text-decoration: none;
	    cursor: pointer;
	}
	.um-activity-dialog:before {
	    bottom: 100%;
	    right: 2%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-color: rgba(194, 225, 245, 0);
	    border-bottom-color: #112233;
	    border-width: 8px;
	    margin-left: -36px;
	}
	.srr-tab-wrap:before {
	    bottom: 100%;
	    right: 2%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-color: rgba(194, 225, 245, 0);
	    border-bottom-color: #112233;
	    border-width: 8px;
	    margin-left: -36px;
	}
	.srr-tab-wrap > li.srr-active-tab > .srr-tab-wrap :before {
	    bottom: 100%;
	    right: 2%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-color: rgba(194, 225, 245, 0);
	    border-bottom-color: #11273e;
	    border-width: 8px;
	    margin-left: -36px;
	}
	.add-post .um-activity-new-post .um-activity-body .um-activity-preview{
		padding: 0 5px;
	}
	.um-activity-preview img {
		max-height: 91px;
    	border-radius: 9px;
	}
	.add-post .um-activity-new-post .um-activity-foot .upload-statusbar {
		font-size: 12px;
	    line-height: 1.3em;
	    background: #112233 !important;
	    padding: 5px 10px;
	    border-radius: 20px;
	    margin-top: 2px;
	    margin-bottom: 4px;
	    margin-left: 8px;
	    display: inline-block;
	    width: initial;
	    color: #fff!important;
	}
	.um-notification-live-feed-inner {
		position: relative;
	    height: 100%;
	    overflow: auto;
	    border-bottom-color: #152d46 !important;
	}
	.um-notification-live-feed {
		overflow: visible !important;
	}
	.um-notification-live-feed-inner::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		border-radius: 11px;
		background-color: #0f121d;
	}

	.um-notification-live-feed-inner::-webkit-scrollbar
	{
		width: 8px;
		border-radius: 10px;
		background-color: none;
	}

	.um-notification-live-feed-inner::-webkit-scrollbar-thumb
	{
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
		background-color: #34495e;
	}
	.um-notification-header {
		border-radius: 6px 6px 0px 0px;
		width: 27.05%;
	}
	div.um .um-form .um-activity-comment-box textarea.um-activity-comment-textarea:focus {
	    border-color: #1e3554 !important;
	}
	.um-activity-foot.status {
		border-radius: 6px !important;
	}
	.add-post .um-activity-wall .um-activity-body {
		max-height: 461px !important;
	}
	.um-activity-bodyinner-txt {
		padding: 0 !important;
	}
	.um-activity-bodyinner-txt span.post-meta {
		border: none;
	    box-shadow: none;
	    display: block;
	    color: #fff;
	    margin: 12px 0 0 0;
	    padding-bottom: 10px;
	    background: #142c46 !important;
	}
	.um-activity-bodyinner-txt span.post-title {
		font-weight: bold;
	    color: #d8d8d8 !important;
	    padding: 10px 12px 0 12px;
	    margin: 0;
	    font-size: 14px;
	    /*display: block;*/
	    font-family: 'Montserrat', sans-serif;
	    display: -webkit-box;
	    -webkit-line-clamp: 1;
	    -webkit-box-orient: vertical;
	    overflow: hidden;
	}
	.um-activity-bodyinner-txt span.post-excerpt {
		margin: 5px 12px 0 12px;
	    color: #aaa !important;
	    font-size: 12px;
	    line-height: 14px;
	    display: block;
	    display: -webkit-box;
	    -webkit-line-clamp: 2;
	    -webkit-box-orient: vertical;
	    overflow: hidden;
	}
	.um-activity-bodyinner-txt span.post-domain {
		margin: 5px 12px 0 12px;
	    color: #aaa !important;
	    font-size: 11px;
	    line-height: 18px;
	    text-transform: uppercase;
	    display: block;
	}
	.md-handlerurl {
		background-color: rgba(13, 31, 49, 0.91);
	    position: relative;
	    padding: 11px 5px;
	    top: 9px;
	}
	.um-activity-featured-img {
		max-width: 100%;
	    width: 100%;
	    height: auto;
	    margin-bottom: -117px;
	}
	a:hover {
		text-decoration: none !important;
	}
	.dcontent-wrap a {
		color: #00bcd4;
	}
	.banner-try {
		background: #142c46;
		border-radius: 5px;
		padding-bottom: 12px;
		margin-top: 15px;
		display: none;
	}
	.banner-try .to-top-title {
		padding-top: 10px !important;
		padding-left: 15px !important;
		padding-right: 15px !important;
		padding-bottom: 0 !important;
		margin-bottom: 5px !important;
	}
	.adsbygoogle .to-top-title {
		padding-top: 6px;
		padding-left: 13px;
		padding-right: 13px;
		padding-bottom: 0;
		margin-bottom: 5px;
	}
	.cont-try-premium {
		padding: 0 14px;
	}
	.to-top-create {
		float: right;
		color: #6583a8;
	}
	.um-activity-comments-loop {
		padding-top: 0px;
	}
	.um-activity-comments {
		padding: 9px 15px 0 15px !important;
	}
	.um-activity-commentwrap {
		padding-top: 13px;
	}
	.um-form textarea {
		line-height: 18px;
	}
	.inner-center-dashboard {
		padding: 11px 15px 20px 15px;
	}
	
	/* Member Directory Overrides */
	div.uimob800 .um-member {
		width: 48%;
		min-height: 250px;
	}
	.um-members-edit-btn,
	.um-members-follow-stats,
	.um-members-friend-stats,
	.um-members-follow-btn {
		display:none !important;
	}
	.um-member {
		border-radius: 5px;
		overflow: hidden;
		border: 1px solid #142c46;
		margin-bottom: 20px;
		background-color: #142c46;
	}
	.um-member-name a {
		font-size: 14px;
		line-height: 26px;
		color: #d8d8d8 !important;
		font-weight: 600;
	}
	.um-member-photo img {
		border: 3px solid #213f58;
		background: #213f58;
	}
	.arbpage_pagetitle {
		font-family: 'Montserrat', sans-serif;
		font-weight: 700;
		font-size: 17px;
		margin-bottom: 0;
	}
	.um-member-cover {
		background: url(<?php echo get_home_url(); ?>/assets/img/arb_default_bg_2.jpg) 0 0 no-repeat #6583a8;
		background-size: cover;
	}
	.um-members a.um-friend-btn.um-button.um-alt,
	.um-members a.um-unfriend-btn.um-button.um-alt,
	.um-members a.um-unfriend-btn.um-button.um-alt.um-unfriend-btn2 {
		border-radius: 26px !important;
		border: 1.3px solid #6583a8 !important;
		font-family: 'Nunito', sans-serif;
		color: #6583a8 !important;
		padding: 7px 15px !important;
		line-height: 18px !important;
		background-color: transparent;
	}
</style>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
						
                        <?php //get_template_part('parts/sidebar', 'tasks'); ?>
                    	<?php get_template_part('parts/sidebar', 'profile'); ?>
						<?php //get_template_part('parts/sidebar', 'traders'); ?>
						
					</div>
                    
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                    		<h1 class="arbpage_pagetitle">Members</h1>
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
					<?php get_template_part('parts/sidebar', 'watchlist'); ?>
					
					<?php //get_template_part('parts/sidebar', 'topplayers'); ?>
                    <?php //get_template_part('parts/sidebar', 'alert'); ?>
                    <div class="forsticky">
                    <?php // get_template_part('parts/sidebar', 'ads'); ?>

                    <?php get_template_part('parts/sidebar', 'footer'); ?>
                	</div>
				</div>

				<?php /*?><div class="banner-try">
					<div class="to-top-title">Sponsored <div class="to-top-create">Create ads</div>
						<hr class="style14 style15" style="width: 100% !important;margin-bottom: 9px !important;margin-top: 5px !important;">
                    </div>
                        <div class="cont-try-premium">
                        <img src="<?php echo get_home_url(); ?>/svg/try-primium.jpg">
                    </div>
				</div><?php */?>

                
                <br class="clear">
			</div>

		</div>
	</div>

</div>

 <!-- #main-content -->

<?php get_footer();