<?php /* Template Name: Calculator */

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila'); ?>
<script type="text/javascript">
	jQuery(document).scrollTop(0);
</script>
<style type="text/css">
	html {
		background: #0d1f33 !important;
	}
	.right-dashboard-part{
	    float: left;
	    width: 27%;
	    padding: 21px 0px !important;
	    height: 140%;
	    position: -webkit-sticky;
	    position: sticky;
	    top: -60%;
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
		color: #6583a8;
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
		border-radius: 0;
		margin: 0px 0px 0 0!important;
	    width: 50%;
	    text-align: center;
	    padding: 0 !important;
	}
	.et_pb_widget ul li:hover {
		border-bottom: solid 2px #9a8e26 !important;
	}
    .srr-tab-wrap {
	    margin: 5px 0 15px!important;
	    background: none!important;
	    border: none!important;
	    padding: 0!important;
	}
	.srr-tab-wrap > li {
	    background: none;
	    border-bottom: solid 2px #1e3554 !important;
	    border:none;
	    font-size: 11px;
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
		background: #142c46;
	    display: block !important;
	    margin-top: 15px;
	    border-radius: 5px;
	    overflow: hidden;
	     padding-bottom: 8px; 
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
		color: #6583a8;
	}
	.srr-item-cont {
		display: block !important;
	    padding-top: 0px !important;
	    padding-left: 1px !important;
	    padding-right: 13px !important;
	    text-align: center !important;
	    top: -1px;
    	position: relative;
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
    	margin-top: -5px;
	}
	.srr-wrap .srr-item > * {
		margin-bottom: 16px!important;
	}
	.srr-wrap .srr-item > *:last-child {
		margin-bottom: 0px !important;
	}
	.dauthor {
		color: #878a8e;
	}
	.left-dashboard-part {
		position: sticky;
    	top: 6%;
	}
	.inner-placeholder {
		padding: 0 !important;
	}


</style>
<?php get_template_part('parts/global', 'css'); ?>
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
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
						
						<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
						<style type="text/css">
						.arb_calcbox {
							color:#FFFFFF;
							padding:35px;
							max-width:550px;
							width:100%;
							margin:0 auto;
							font-size:13px;
						}
						.arb_calcbox input[type="number"] {
							border:0;
							border-radius: 4px;
							padding: 5px 6px;
							background-color: #4e6a85;
						    border: 1px solid #4e6a85;
							color: #ecf0f1;
						    font-family: 'Roboto', sans-serif;
							display:block;
							width:90%;
							margin-top:3px;
						}
						.arb_calcbox h3 {
						    font-size: 17px;
						    padding-bottom: 0;
							font-weight:normal;
						}
						.arb_calcbox h3 strong {
						    text-transform: uppercase;
						}
						.arb_calcbox h4 {
						    font-size: 15px;
						    padding-bottom: 0;
							font-weight:normal;
						}
						.arb_calcbox h4 strong {
						    text-transform: uppercase;
						}
						.arb_calcbox small {
							font-size:11px;
							display:block;
						}
						.arb_clear {clear:both;}
						.arb_calcbox_left {
							float:left;
							width:60%;
						}
						.arb_calcbox_right {
							float:right;
							width:40%;
						}
						.padbott {
							padding-bottom:5px;
						}
						.arb_buyfees, .arb_sellfees {position: relative;}
						.feedetails_sell, .feedetails_buy {display:none;}
						.feedetails_sell,
						.feedetails_buy {
						    position: absolute;
						    left: -1px;
						    top: 0;
						    padding: 12px;
						    border-radius: 5px;
						    background-color: #2b3d4f;
							width:90%;
						}
						.smlinline {
						    display: inline-block !important;
						    vertical-align: text-top;
							cursor:pointer;
						}
						.clcbxttl {
						    border-bottom: 1px solid #4e6a85;
						    margin-top: -5px;
						    margin-bottom: 5px;
						    padding-bottom: 5px;
						}
						.arb_dvdr {
						    border-bottom: 1px solid #4e6a85;
						    width: 90%;
						    margin: 8px 0 10px;
						}
						.arb_breakeven {
						    width: 90%;
						    margin: 4px 0 0;
						    border-radius: 4px;
						    overflow: hidden;
						}
						.arbredtxt {color: #e64c3c; }
						.arbgreentxt {color: #25ae5f; }
						.alleft {float:left}
						.alright {float:right}
						.arbleveling {
						    padding: 3px 7px 3px;
						    line-height: 20px;
						}
						</style>
						<div class="arb_calcbox">

						    <h3><strong>Profit/Loss</strong> Calculator</h3>
						    
						    <div class="arb_calcshares" style="padding-bottom: 12px;">Number of Shares: 
						        <input name="numofshares" id="numofshares" type="number" step="0.01" value="0" style="width:96%;">
						    </div>

						    <div class="arb_calcbox_left">
						    
						        <div class="arb_buyprice padbott"><strong>Buy Price:</strong> <input name="buyprice" id="buyprice" step="0.01" type="number" value="0"></div>
						        <div class="arb_buyvalue padbott">Value: ₱<span id="buyvalue">0.00</span></div>
						        <div class="arb_buyfees padbott">
						            Fees: ₱<span id="buyfees">0.00</span> <i class="fas fa-info-circle" style="padding-right: 5px;"></i>
						            <div class="feedetails_buy">
						                <div class="clcbxttl">Fees<small class="smlinline" style="float:right;">close</small></div>
						                <small>Commission: ₱<span id="buycommadjst">0.00</span></small>
						                <small>Value Added Tax: ₱<span id="buyvatfix">0.00</span></small>
						                <small>Transfer Fee: ₱<span id="buypsetffix">0.00</span></small>
						                <small>SCCP: ₱<span id="buysccpfix">0.00</span></small>
						            </div>
						        </div>
						        <div class="arb_buytotal padbott">Buy Total: <span id="buytotal">0.00</span></div>
						        
						        <div class="arb_dvdr"></div>
						        
						        <div class="arb_sellprice padbott"><strong>Sell Price:</strong> <input name="sellprice" id="sellprice" step="0.01" type="number" value="0"></div>
						        <div class="arb_sellvalue padbott">Value: ₱<span id="sellvalue">0.00</span></div>
						        <div class="arb_sellfees padbott">
						            Fees: ₱<span id="sellfees">0.00</span> <i class="fas fa-info-circle" style="padding-right: 5px;"></i>
						            <div class="feedetails_sell">
						                <div class="clcbxttl">Fees<small class="smlinline" style="float:right;">close</small></div>
						                <small>Commission: ₱<span id="sellcommadjst">0.00</span></small>
						                <small>Value Added Tax: ₱<span id="sellvatfix">0.00</span></small>
						                <small>Transfer Fee: ₱<span id="sellpsetffix">0.00</span></small>
						                <small>SCCP: ₱<span id="sellsccpfix">0.00</span></small>
						                <small>Sales Tax: ₱<span id="sellsaletxfix">0.00</span></small>
						            </div>
						        </div>
						        <div class="arb_selltotal">Sell Total: <span id="selltotal">0.00</span></div>
						        
						        <div class="arb_dvdr"></div>
						        
						        <div class="arbnetprofit padbott">
						    		<h4 class="textchangecolor"><strong>Net Profit: ₱<span id="arbnetprofitf">0.00</span> (<span id="arbperctg">0</span>%)</strong></h4>
						    	</div>
						        
						    </div>

						    <div class="arb_calcbox_right">
						    	
						        <strong>Break-Even Analysis</strong>
						        
						        <div class="arb_breakeven">
						        
						        	<div class="arbleveling" style="background-color: rgba(44, 174, 95, 1.0);">
						                <div class="alleft">₱ <span id="brkevn200">0.00</span></div> <div class="alright">20.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.8);">
						                <div class="alleft">₱ <span id="brkevn100">0.00</span></div> <div class="alright">10.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.6);">
						                <div class="alleft">₱ <span id="brkevn75">0.00</span></div> <div class="alright">7.50%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.4);">
						                <div class="alleft">₱ <span id="brkevn50">0.00</span></div> <div class="alright">5.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.2);">
						                <div class="alleft">₱ <span id="brkevn25">0.00</span></div> <div class="alright">2.50%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling">
						                <div class="alleft">₱ <span id="brkevnflat">0.00</span></div> <div class="alright">0.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.2);">
						                <div class="alleft">₱ -<span id="negbrkevn25">0.00</span></div> <div class="alright">-2.50%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.4);">
						                <div class="alleft">₱ -<span id="negbrkevn50">0.00</span></div> <div class="alright">-5.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.6);">
						                <div class="alleft">₱ -<span id="negbrkevn75">0.00</span></div> <div class="alright">-7.50%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.8);">
						                <div class="alleft">₱ -<span id="negbrkevn100">0.00</span></div> <div class="alright">-10.00%</div> 
						                <div class="arb_clear"></div>
						            </div>
						            
						            <div class="arbleveling" style="background-color: rgba(230, 76, 60, 1.0);">
						                <div class="alleft">₱ -<span id="negbrkevn200">0.00</span></div> <div class="alright">-20.00%</div> 
						                <div class="arb_clear"></div>
						            </div>

						    	</div>
						      
						    </div>
						    
						    <div class="arb_clear padbott"></div>
						    
						</div>
						<script language="javascript">
							jQuery(document).ready(function(){
								
								jQuery(".arb_sellfees").click(function(){
									jQuery(".feedetails_sell").slideToggle("fast");
								});
								jQuery(".arb_buyfees").click(function(){
									jQuery(".feedetails_buy").slideToggle("fast");
								});
								
								jQuery("#buyprice, #sellprice").keyup(function(){execlc();});
								jQuery("#buyprice, #sellprice").click(function(){execlc();});
								
								function execlc(){
									
									var vrnumofshares = document.getElementById("numofshares").value;
									
									/* Buy */
									var vrbuyprice = document.getElementById("buyprice").value;
									var vrbuyvalue = Math.round(vrnumofshares * vrbuyprice);
									jQuery("#buyvalue").html(numeral(vrbuyvalue).format('0,0.00'));
									
									/* Buy Fees */
									var vrbuycommcheck = vrbuyvalue * 0.0025;
									var vrbuycommadjst;
									if(vrbuycommcheck <= 20){vrbuycommadjst = 20;}else{vrbuycommadjst = vrbuyvalue * 0.0025;}
									jQuery("#buycommadjst").html(numeral(vrbuycommadjst).format('0,0.0000'));
									var vrbuyvatfix = vrbuycommadjst * 0.12;
									jQuery("#buyvatfix").html(numeral(vrbuyvatfix).format('0,0.0000'));
									var vrbuypsetffix = vrbuyvalue * 0.00005;
									jQuery("#buypsetffix").html(numeral(vrbuypsetffix).format('0,0.0000'));
									var vrbuysccpfix = vrbuyvalue * 0.0001;
									jQuery("#buysccpfix").html(numeral(vrbuysccpfix).format('0,0.0000'));
									
									/* Buy Totals */
									var vrbuyfees = vrbuycommadjst + vrbuyvatfix + vrbuypsetffix + vrbuysccpfix;
									jQuery("#buyfees").html(numeral(vrbuyfees).format('0,0.00'));
									var vrbuytotal = vrbuyfees + vrbuyvalue;
									jQuery("#buytotal").html(numeral(vrbuytotal).format('0,0.00'));
									
									/* Sell */
									var vrsellprice = document.getElementById("sellprice").value;
									var vrsellvalue = Math.round(vrnumofshares * vrsellprice);
									jQuery("#sellvalue").html(numeral(vrsellvalue).format('0,0.00'));
									
									/*Sell Fees*/
									var vrsellcommcheck = vrsellvalue * 0.0025;
									var vrsellcommadjst;
									if(vrsellcommcheck <= 20){vrsellcommadjst = 20;}else{vrsellcommadjst = vrsellvalue * 0.0025;}
									jQuery("#sellcommadjst").html(numeral(vrsellcommadjst).format('0,0.0000'));
									var vrsellvatfix = vrsellcommadjst * 0.12;
									jQuery("#sellvatfix").html(numeral(vrsellvatfix).format('0,0.0000'));
									var vrsellpsetffix = vrsellvalue * 0.00005;
									jQuery("#sellpsetffix").html(numeral(vrsellpsetffix).format('0,0.0000'));
									var vrsellsccpfix = vrsellvalue * 0.0001;
									jQuery("#sellsccpfix").html(numeral(vrsellsccpfix).format('0,0.0000'));
									var vrsellsaletxfix = vrsellvalue * 0.006;
									jQuery("#sellsaletxfix").html(numeral(vrsellsaletxfix).format('0,0.0000'));
									
									/* Sell Totals */
									var vrsellfees = vrsellcommadjst + vrsellvatfix + vrsellpsetffix + vrsellsccpfix + vrsellsaletxfix;
									jQuery("#sellfees").html(numeral(vrsellfees).format('0,0.00'));
									var vrselltotal = vrsellvalue - vrsellfees;
									jQuery("#selltotal").html(numeral(vrselltotal).format('0,0.00'));
									
									var vrarbnetprofitf = vrselltotal - vrbuytotal;
									jQuery("#arbnetprofitf").html(numeral(vrarbnetprofitf).format('0,0.00'));
									
									var vrarbperctg = vrarbnetprofitf/vrbuytotal * 100;
									jQuery("#arbperctg").html(numeral(vrarbperctg).format('0,0.00'));
									
									if (vrbuytotal > vrselltotal){
										jQuery(".textchangecolor").addClass( "arbredtxt" );
										jQuery(".textchangecolor").removeClass( "arbgreentxt" );
									}else{
										jQuery(".textchangecolor").addClass( "arbgreentxt" );
										jQuery(".textchangecolor").removeClass( "arbredtxt" );
									}
									
									/*Breakeven*/
									
									var vrbrkevnflat1 = vrbuyprice * 0.011;
									var vrbrkevnflat2 = Number(vrbuyprice) + Number(vrbrkevnflat1);
									jQuery("#brkevnflat").html(numeral(vrbrkevnflat2).format('0,0.00'));

									var vrbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
									var vrbrkevn2002 = Number(vrbrkevnflat2) + Number(vrbrkevn2001);
									jQuery("#brkevn200").html(numeral(vrbrkevn2002).format('0,0.00'));
									
									var vrbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
									var vrbrkevn1002 = Number(vrbrkevnflat2) + Number(vrbrkevn1001);
									jQuery("#brkevn100").html(numeral(vrbrkevn1002).format('0,0.00'));
									
									var vrbrkevn751 = Number(vrbrkevnflat2) * 0.075;
									var vrbrkevn752 = Number(vrbrkevnflat2) + Number(vrbrkevn751);
									jQuery("#brkevn75").html(numeral(vrbrkevn752).format('0,0.00'));
									
									var vrbrkevn501 = Number(vrbrkevnflat2) * 0.05;
									var vrbrkevn502 = Number(vrbrkevnflat2) + Number(vrbrkevn501);
									jQuery("#brkevn50").html(numeral(vrbrkevn502).format('0,0.00'));
									
									var vrbrkevn251 = Number(vrbrkevnflat2) * 0.025;
									var vrbrkevn252 = Number(vrbrkevnflat2) + Number(vrbrkevn251);
									jQuery("#brkevn25").html(numeral(vrbrkevn252).format('0,0.00'));
											
									var vrnegbrkevn251 = Number(vrbrkevnflat2) * 0.025;
									var vrnegbrkevn252 = Number(vrbrkevnflat2) - Number(vrnegbrkevn251);
									jQuery("#negbrkevn25").html(numeral(vrnegbrkevn252).format('0,0.00'));
									
									var vrnegbrkevn501 = Number(vrbrkevnflat2) * 0.05;
									var vrnegbrkevn502 = Number(vrbrkevnflat2) - Number(vrnegbrkevn501);
									jQuery("#negbrkevn50").html(numeral(vrnegbrkevn502).format('0,0.00'));
									
									var vrnegbrkevn751 = Number(vrbrkevnflat2) * 0.075;
									var vrnegbrkevn752 = Number(vrbrkevnflat2) - Number(vrnegbrkevn751);
									jQuery("#negbrkevn75").html(numeral(vrnegbrkevn752).format('0,0.00'));
									
									var vrnegbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
									var vrnegbrkevn1002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn1001);
									jQuery("#negbrkevn100").html(numeral(vrnegbrkevn1002).format('0,0.00'));
									
									var vrnegbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
									var vrnegbrkevn2002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn2001);
									jQuery("#negbrkevn200").html(numeral(vrnegbrkevn2002).format('0,0.00'));
									
								}
							});
						</script>
					</div>



				</div>
			</div>
				<style type="text/css">
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
				</style>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
					
                
                	<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'watchlist'); ?>
                    
                    
                    
                    

				</div>
                
			</div>
				<div class="banner-try">
					<div class="to-top-title">Sponsored <div class="to-top-create">Create ads</div>
				<hr class="style14 style15" style="width: 100% !important;margin-bottom: 9px !important;margin-top: 5px !important;/* margin: 5px 0px !important; */">
			</div>

					<div class="cont-try-premium">
						<img src="<?php echo get_home_url(); ?>/svg/try-primium.jpg">
					</div>
				</div>
			<?php get_template_part('parts/sidebar', 'ads'); ?>
			<?php get_template_part('parts/sidebar', 'footer'); ?>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php

get_footer();
