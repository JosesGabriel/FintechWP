<?php
	/*
	* Template Name: Latest News Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
include 'phpsimpledom/simple_html_dom.php';
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila'); ?>

<style type="text/css">
	html {
		background: #0d1f33 !important;
	}
	.inner-main-content, .header-dashboard-inner {
		max-width: 1000px !important;
    	width: 85% !important;
	}
	.center-dashboard-part {
	    float: left;
	    width: 85%;
	    margin-top: 10px;
	}
	.right-dashboard-part{
	    float: left;
	    width: 100% !important;
	    padding: 21px 0px !important;
	    height: 140%;
	    position: -webkit-sticky;
	    position: sticky;
	    top: -177%;
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
        text-transform:
        capitalize !important;
	    /* text-overflow: ellipsis !important; */
	    white-space: nowrap;
	    overflow: hidden;
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
		color: #6583a8;
		font-size: 20px;
		margin-top: 7px;
    	margin-right: 7px;
	}
	.to-content-part {
		background: none !important;
		padding: 5px 12px !important;
	}
	.top-stocks .to-content-part ul li.even,
	.watch-list-inner .to-content-part ul li.even {
	    background: none;
	    /* margin-top: 19px; */
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
	.um-activity-dialog.um-activity-tool-dialog {display:none;}
	.top-stocks .to-content-part ul li a {
	    font-size: 12px;
	    color: #ecf0f1;
	    overflow: visible;
	    white-space: normal;
	    display: inline-block;
	    width: 100% !important;
	    padding: 6px 2px 2px 2px !important;
	    position: relative;
	    vertical-align: middle;
	    text-overflow: ellipsis;
	}
	.top-stocks {
		margin-bottom: 0 !important;
		margin-top: 8px !important;
		/*display: none;*/
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
        padding: 0px 14px 0px 14px !important;
    }
    .style18 {
    	width: 92% !important;
    	margin-bottom: 0;
    	margin-top: 9px;
    }
    .watch-list {
    	background: #142c46;
    	margin-top: 0;
    }
    .latest-news {
    	background: #142c46;
    	margin-top: 15px;
		width: 100%;
	}
    .latest-news .to-top-title {
	    padding: 10px 14px 2px 14px !important
	}
	.srr-tab-wrap > li.srr-active-tab {
	    border-left: none !important;
	    background: none !important;
	}
	.srr-tab-wrap li {
		border-radius: 0;
		margin: 0px 0px 0 0!important;
	    width: 100%;
	    text-align: center;
	   	padding: 3px 7px !important;
	}
	.et_pb_widget ul li:hover {
		border-bottom: none !important;
		background: #12283f;
	}
    .srr-tab-wrap {
	    margin: 0 !important;
	    border: none!important;
	    position: absolute;
	    background: #142c46 !important;
	    z-index: 2;
	    right: 4px;
	    padding: 0px !important;
	    margin-top: -12px !important;
	    border-radius: 4px;
	    overflow: hidden;
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
	.adsbygoogle {
		background: none !important;
	    display: block !important;
	    margin-top: 0 !important;
	    border-radius: 5px;
	    overflow: hidden;
	     padding-bottom: 0 !important;
	    /* padding: 10px 15px 15px 15px; */
	}
	.adsbygoogles {
		background: none !important;
	    display: block !important;
	    margin-top: 0 !important;
	    border-radius: 5px;
	    overflow: hidden;
	     padding-bottom: 0 !important;
	    /* padding: 10px 15px 15px 15px; */
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
    	margin-top: 0px !important;
	    /* padding-top: 13px; */
	}
	.srr-wrap .srr-item > * {
      margin-bottom: 0 !important;
    }
    .srr-wrap .srr-item {
	    width: 90% !important;
    }
	time.srr-date {
		font-size: 18px !important;
    	line-height: 1.1;
    	font-weight: 300;
    	color: #ffeb3b;
	}
	time.srr-date div {
		font-size: 11px !important;
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
	    display: -webkit-box !important;
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
	.et_fixed_nav.et_show_nav #page-container, .et_non_fixed_nav.et_transparent_nav.et_show_nav #page-container {
		padding-top: 0 !important;
	}
	.to-top-dropdown {
		float: right;
		font-size: 12px;
		color: #fffffe;
    	line-height: 1.7;
    	cursor: pointer;
	}
	.banner-try {
		background: #142c46;
		border-radius: 5px;
		padding-bottom: 12px;
		margin-top: 15px;
		display: none;
	}
	.cont-try-premium {
		padding: 0 14px;
	}
	.to-top-create {
		float: right;
		color: #6583a8;
	}
	.abcds {
		padding-right: 5px;
		padding-left: 5px;
	}
	.srr-wrap .dnewstitle {
		word-break: break-word;
	    position: relative;
	    width: 90%;
	}
	.srr-item .srr-item-cont {
		margin: 8px 0 !important;
	}
	.to-rss-inner {
		height: 240px;
	    overflow-y: hidden;
	    overflow-x: hidden;
	}
	.to-rss-inner:hover {
	    overflow-y: scroll;
	}
	ul.srr-tab-wrap.srr-tab-style-none.srr-clearfix {
	    height: 50px;
	}
	#main-content .container {
		padding-top: 0;
	}
	.to-top-title p {
	    color: #fffffe;
	    font-size: 17px !important;
	    font-weight: 200 !important;
	    padding-left: 5px;
	    padding-top: 5px;
	    padding-bottom: 5px !important;
	    border-left: #ffeb3b solid 3px;
	    font-family: 'Roboto', sans-serif;
	    margin: 0;
	}
	.container {
	    padding-right: 0;
	    padding-left: 0;
	}
	.adsbygoogle .to-top-title {
		display: none;
	}
	.box-portlet {border: none;}
	.adsbygoogle .box-portlet-content {
		padding: 0 27px 27px 27px !important;
	}
	.adsbygoogles .box-portlet-content {
		padding: 0 27px 27px 27px !important;
	}
	.left-dashboard-part {
		position: sticky;
    	top: 35px !important;
	}
	.tte-spons h6 {
		color: #fffffe;
    	font-size: 20px !important;
    	font-weight: 500 !important;
	    margin: 0;
	    vertical-align: middle;
	    position: relative;
	    padding: 29% 0 29% 0;
	}
	#tableStock .even {
	    display: flex !important;
	}

	.ico-pluss {
	    text-align: center;
	    padding: 45px 0;
	}
	.ico-pluss-hover {
		transition-duration: .5s;
	}
	.ico-pluss-hover:hover {
		background: #10253c;
	}
	.ico-pluss-hover:hover div i {
		color: #b3b3b3;
	}
	.ico-pluss-hover div i {
		font-size: 20px;
		color: #d8d8d8;
	}
	pre{
		background: #fff;
	}
</style>
<?php //get_template_part('parts/sidebar', 'alert'); ?>
<?php get_template_part('parts/global', 'css'); ?>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>
<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="left-dashboard-part-inner">
					<?php get_template_part('parts/sidebar', 'profile'); ?>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 800px;">
				<div class="center-dashboard-part-inner">
					<div class="container">
						<div class="row">
							<div class="col-md-12 abcds">
		                		<?php //get_template_part('parts/sidebar', 'stockslatestnews'); ?>
		                	</div>
						</div>
					</div>
                <div class="nws-container">
<!--                 <div class="adsbygoogles">
					<div class="box-portlet">
						<div class="box-portlet-content">
							<small>ADVERTISEMENT</small>
							<div class="adscontainer">
							<img width="100%" src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1,3); ?>.png">
							</div>
						</div>
					</div>
				</div> -->
				<?php
					$html = file_get_html('http://news.google.com/search?q=Philippine%20stock%20exchange&hl=en-PH&gl=PH&ceid=PH%3Aen');

					// titles
					$titles = [];
					foreach ($html->find('div.NiLAwe h3') as $key => $value) {
						$titles[$key] = $value->plaintext;
					}

					$desc = [];
					foreach ($html->find('div.NiLAwe span.xBbh9') as $key => $value) {
						$newdata = str_replace('bookmark_bordershare', '', $value->plaintext);
						$newdata = str_replace('more_vert', '', $newdata);
						$desc[$key] = $newdata;
					}

					$link = [];
					foreach ($html->find('div.NiLAwe a.VDXfz') as $key => $value) {
						$link[$key] = $value->href;
					}

					$link = array_unique($link);
					$link = array_values($link);

					$images = [];
					foreach ($html->find('div.NiLAwe img') as $key => $value) {
						$images[$key] = $value->src;

						if ($images < 1) {
							$images = preg_replace('/(<a\b[^><]*)>/i', '$1 style="xxxx:yyyy;">', $images);
						}
					}

					$source = [];
					foreach ($html->find('div.NiLAwe .wEwyrc') as $key => $value) {
						$source[$key] = $value->plaintext;
					}

				?>
					<div class="wh-container">
                	<div class="nws-inner">
                		<div class="container">
                			<div class="nws-businesstitle">Business News</div>
	                		<div class="row msbusinesstit">
								<!-- first news -->
				                <div class="col-md-8" style="padding-right: 10px;">
				                	<div class="nws-thumbnstopimg sss" style="background: url('<?php echo $images[0]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
					                	<div class="nws-toptitle">
					                		<p><a href="https://news.google.com/<?php echo $link[0]; ?>" target="_blank"><?php echo (strlen($titles[0]) > 59 ? substr($titles[0], 0, 60) . '...' : $titles[0])?></a></p>
							                <p class="ellpnews"><?php echo (strlen($desc[0]) > 200 ? substr($desc[0], 0, 200) . '...' : $desc[0]) ?></p>
											<p><?php echo (strlen($source[0]) > 25 ? substr($source[0], 0, 25) . '...' : $source[0]) ?></p>
										</div>
										<div class="ddtopimg" style="background: url('<?php echo $images[0]; ?>');background-position: center center;background-size: auto 100%;background-repeat: no-repeat;">
										</div>
							        </div>
				                </div>
				                <div class="col-md-4" style="padding-left: 0px;">
				                	<div class="main-innertop">
										<!-- 7 to 11 -->
										<?php for ($topright=1; $topright <=4 ; $topright++) { ?>
											<div class="nws-conttype llll">
												<div class="nws-thumbns sss" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
							                		<div class="ddimg" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
							                		</div>
							                	</div>
						                		<div class="nws-thumbnsdesc">
						                			<p><a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank"><?php echo (strlen($titles[$topright]) > 45 ? substr($titles[$topright], 0, 45) . '...' : $titles[$topright])?></a></p>
						                			<p class="ellpnews"><?php echo (strlen($desc[$topright]) > 33 ? substr($desc[$topright], 0, 33) . '...' : $desc[$topright]) ?></p>
													<p><?php echo (strlen($source[$topright]) > 25 ? substr($source[$topright], 0, 25) . '...' : $source[$topright]) ?></p>
						                			<!-- <p class="nws-toplinks"><a href="/bulletins/">/bulletins/</a></p> -->
						                		</div>
					                		</div>
										<?php } ?>
			                		</div>
			                	</div>
			                </div>
			                <div class="row cisz" style="padding-top: 0px; margin-top: -3px;">
		                		<div class="hksi col-md-8">
		                			<div class="row">
									<!-- 1 to 6 -->
									<?php for ($topright=5; $topright <= 8 ; $topright++) { ?>
											<div class="col-md-6" style="padding-right: 0px;">
						                		<div class="nws-part">
							                		<div class="img_sep">
							                			<div class="ccc" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
									                		</div>
							                		</div>
							                		<div class="nws-seprator">
							                			<div class="nws-title">
							                				<p>
							                					<strong>
							                						<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
							                					<?php echo (strlen($titles[$topright]) > 51 ? substr($titles[$topright], 0, 51) . '...' : $titles[$topright])?></a>
							                					</strong>
							                				</p>
							                			</div>
							                			<div class="nws-description">
								                			<p><?php echo (strlen($desc[$topright]) > 120 ? substr($desc[$topright], 0, 120) . '...' : $desc[$topright])?></p>
															<p><?php echo $source[$topright]; ?></p>
							                			</div>
							                		</div>
						                		</div>
						                	</div>
									<?php } ?>





			                		</div>
			                	</div>


			                	<div class="nws-part col-md-4" style="margin-top: 0px;">
									<?php // get_template_part('parts/sidebar', 'ads');?>

						                		<div class="nws-part">
							                		<div class="img_sep">
							                			<div class="ccc" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
									                		</div>
							                		</div>
							                		<div class="nws-seprator">
							                			<div class="nws-title">
							                				<p>
							                					<strong>
							                						<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
							                					<?php echo (strlen($titles[$topright]) > 51 ? substr($titles[$topright], 0, 51) . '...' : $titles[$topright])?></a>
							                					</strong>
							                				</p>
							                			</div>
							                			<div class="nws-description">
								                			<p><?php echo (strlen($desc[$topright]) > 120 ? substr($desc[$topright], 0, 120) . '...' : $desc[$topright])?></p>
															<p><?php echo $source[$topright]; ?></p>
							                			</div>
							                		</div>
						                		</div>

						                		<?php //get_template_part('parts/sidebar', 'ads');?>
						                	
								</div>


							</div>
	                	</div>
                	</div>
                </div>
                <div class="nws-containersss">
                	<div class="nws-inner">
                		<div class="container">
		                		<?php //get_template_part('parts/sidebar', 'watchlistlatestnews'); ?>



		             <!--   	<div class="adsbygoogle">
								<div class="box-portlet row" style="padding: 0px 0%;">-->
									<!--<div class="tte-spons col-md-2">
										<h6>Sponsor</h6>
									</div>-->
								<!--	<div class="box-portlet-content col-md-10" style="padding: 0 !important;">-->
										<!-- <small>ADVERTISEMENT</small> -->
									<!--	<div class="adscontainer" style="width: 900px;">
										<img src="/ads/addsample728x90_1.png" style="width: 783px;padding-left: 16px;">
										</div>
									</div>
								</div>
							</div>-->

                			<!-- <div class="nws-businesstitle">Market News</div> -->

                			<!-- ========================================= Second section =============================================== -->

	                		<div class="row">
								<!-- for 11 -->
	                			<div class="col-md-4">
				                	<div class="main-innertop klaska">
										<div class="nws-part">
					                		<div class="img_sep" style="width: 252px;">
					                			<div class="ccc" style="background: url('<?php echo $images[19]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
						                		</div>
					                		</div>
					                		<div class="nws-seprator" style="width: 237px;height: 231px;">
					                			<div class="nws-title">
					                				<p>
					                					<strong>
					                						<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
					                					<?php echo (strlen($titles[9]) > 51 ? substr($titles[9], 0, 51) . '...' : $titles[9])?></a>
					                					</strong>
					                				</p>
					                			</div>
					                			<div class="nws-description">
						                			<p><?php echo (strlen($desc[9]) > 120 ? substr($desc[9], 0, 120) . '...' : $desc[9])?></p>
													<p><?php echo $source[9]; ?></p>
					                			</div>
					                		</div>
				                		</div>
			                		</div>
			                	</div>
				                <div class="col-md-8">
				                	<div class="nws-thumbnstopimg sss xls nws-part" style="background: url('<?php echo $images[10]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
				                	<div class="nws-toptitle">
				                		<p><a href="https://news.google.com/<?php echo $link[10]; ?>" target="_blank"><?php echo (strlen($titles[10]) > 39 ? substr($titles[10], 0, 40) . '...' : $titles[10])?></a></p>
						                <p class="ellpnews"><?php echo (strlen($desc[10]) > 199 ? substr($desc[10], 0, 200) . '...' : $desc[10]) ?></p>
										<p><?php echo (strlen($source[10]) > 25 ? substr($source[10], 0, 25) . '...' : $source[10]) ?></p>
									</div>
										<div class="ddtopimg" style="background: url('<?php echo $images[10]; ?>');background-position: center center;background-size: auto 100%;background-repeat: no-repeat;">
										</div>
							        </div>
				                </div>
				            </div>
				                <div class="row">
								<?php for ($bottomnews=11; $bottomnews <=19 ; $bottomnews++) { ?>
								<div class="col-md-4" style="padding-right: 0px; margin-top: -10px;">
				                	<div class="main-innertop">
										<div class="nws-part">
					                		<div class="img_sep">
					                			<div class="ccc" style="background: url('<?php echo $images[$bottomnews]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
						                		</div>
					                		</div>
					                		<div class="nws-seprator">
					                			<div class="nws-title">
					                				<p>
					                					<strong>
					                						<a href="https://news.google.com/<?php echo $link[$bottomnews]; ?>" target="_blank">
					                					<?php echo (strlen($titles[$bottomnews]) > 45 ? substr($titles[$bottomnews], 0, 45) . '...' : $titles[$bottomnews])?></a>
					                					</strong>
					                				</p>
					                			</div>
					                			<div class="nws-description">
						                			<p><?php echo (strlen($desc[$bottomnews]) > 120 ? substr($desc[$bottomnews], 0, 120) . '...' : $desc[$bottomnews])?></p>
													<p><?php echo $source[$bottomnews]; ?></p>
					                			</div>
					                		</div>
				                		</div>
			                		</div>
			                	</div>
								<?php } ?>
		                	</div>
	                	</div>
                	</div>
                </div>
				</div>
			</div>
				<style type="text/css">
				</style>
				<div class="banner-try">
					<div class="to-top-title">Sponsored <div class="to-top-create">Create ads</div>
				<hr class="style14 style15" style="width: 100% !important;margin-bottom: 9px !important;margin-top: 5px !important;/* margin: 5px 0px !important; */">
			</div>

					<div class="cont-try-premium">
						<img src="<?php echo get_home_url(); ?>//svg/try-primium.jpg">
					</div>
				</div>


			<br class="clear">
		</div>
	</div>
</div>
 <!-- #main-content -->

<?php

get_footer();
