<?php
	/*
	* Template Name: Search Page
	* Template page for Search Page
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');


	$search_term = get_search_query();

	$topargs = array(
	    'role'          =>  '',
	    'search'     => '*' . esc_attr( $search_term ) . '*',
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

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE');
curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
$gerdqoute = curl_exec($curl);
curl_close($curl);

$gerdqoute = json_decode($gerdqoute);
$dstockinfo = $gerdqoute->data;

?>
<pre>
    <?php //print_r($dstockinfo); ?>
</pre>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>


<style type="text/css">

.center-dashboard-part {
    width: 70%;
    margin-top: -18px;
}
.to-content-part ul {
    margin: 0;
    list-style: none;
    padding: 0;
}
.inner-center-dashboard {
    padding: 0;
    /* margin-top: 75px; */
}
.search-posts {
    display: block;
    padding: 5px 10px;
    font-size: 12px;
    color: #ecf0f1;
}
h2.search-permalink {
    display: block;
    padding: 5px 10px;
    font-size: 12px;
    color: #ecf0f1;
}
.search-posts p {
    display: block;
    padding: 5px 10px;
    font-size: 12px;
    color: #ecf0f1;
}
 .side-header .right-image .onto-user-name {
    margin-bottom: 5px;
    font-family: 'Montserrat', sans-serif;
}
 .inner-main-content, .header-dashboard-inner {
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    padding-top: 10px;
}
 .side-header .right-image .onto-user-meta-details {
    color: #ffffff;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
}
 
 ul.nav.panel-tabs {
    display: table;
    width: 100%;
    table-layout: fixed;
    box-shadow: 0px 1px 2px -1px rgba(4,13,23,1) !important;
    border-radius: 10px;
    /*border: 1px solid #142b46;*/
}

 .panel-tabs > li {
    float: left;
    margin-bottom: 0px;
    width: 25%;
    text-align: center;
    border: 10px;
}

 .panel-tabs > li > a:hover {
    border-bottom: 2px solid #ffeb3b !important;
    background-color: #142c46 !important;}

 .panel-tabs > li > a.active, 
 .panel-tabs > li > a.active:hover, 
 .panel-tabs > li > a.active:focus {
    color: #fff;
    cursor: default;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 0px;
    background-color: #142c46;
    border-bottom: 2px solid #ffeb3b;
}
 .panel-primary>.panel-heading {
    color: #fff;
    background: #0d1f33;
    padding: 0px 0px;
    border-color: #233649 !important;
    /* border-radius: 4px 4px 0px 4px; */
}

.panel-body {
    padding: 0px !important;
    margin: 0px !important;
    background: #0c1e33;
}

.panel-tabs > li > a {
    border-bottom:2px solid #152c45;
	font-family: 'Nunito', sans-serif;
}

 .tab-content {
    background: #0c1e33;
    /* padding: 10px; */
}
 .panel-primary {
    border-color: #0b1d33 !important;
    border-radius: 10px;
    /* box-shadow: 0px 0px 20px 12px #142c46; */
}
 .oncommonsidebar .post-content {
    padding: 15px !important;
}

.to-top-title {
    padding: 12px 0px;
    font-size: 18px !important;
    font-weight: 800 !important;
}

.onbfdata {
    padding: 5px 15px !important;
    width: initial !important;
    min-width: initial;
    font-size: 10px;
    background: none;
    color: #fff;
}
.top-traiders .to-content-part .trader-item .traider-image {
    width: 13%;
    display: inline-block;
    margin-top: 0px;
    margin-right: 6px;
    margin-left: 10px;
}
.inner-placeholder {
    background: #0d1f33;
    color: #d8d8d8;
    padding-top: 0% !important;
}
.onbfdata {
    /* border-radius: 26px !important; */
    /* border: 1.3px solid #6583a8 !important; */
    padding: 0px !important;
    font-family: 'Nunito', sans-serif;
    font-size: 13px;
    color: #6583a8 !important;
    margin-right: 0px;
    margin-top: 5px;
}

#mingle-btn {
    border-radius: 26px !important;
    border: 1.3px solid #e77e24 !important;
    padding: 5px 20px !important;
    font-family: 'Nunito', sans-serif;
    color: #6583a8;
    font-size: 12px;
}

.to-top-title-search {
    padding: 5px 10px;
    font-size: 18px;
    /* border: 1px solid #142c46; */
    font-size: 16px !important;
    font-weight: 800 !important;
}

.nav li {
	position: relative;
    line-height: 2em !important;
}

.onbfollow {
    position: absolute;
    right: 50px;
    margin-top: -20px;
}

.traider-image .side-image {
    background-size: cover !important;
    height: 65px;
    width: 65px;
    border-radius: 50px;
     border: none !important; 
     padding: 9px !important; 

}



.top-traiders .to-content-part .trader-item {
	margin: 15px 0;
    padding: 0px 15px;
}

textarea.um-activity-textarea-elem.ui-autocomplete-input {
    background: #142c46 !important;
    border-radius: 5px;
}
.um-activity-widget.um-activity-new-post:first-child {
    margin-top: 15px;
    border-radius: 7px;
    overflow: hidden !important;
}
.top-traiders .to-content-part .trader-item .traider-image img {
    border-radius: 50px;
}

.top-traiders .to-content-part .trader-item .traider-details .traider-name {
    margin-top: 5px;
    font-size: 15px;
    line-height: 1em;
    color: #fffffe;
    font-size: 13px !important;
    font-weight: 500 !important;
    /* width: 30% !important; */
}
.top-traiders .to-content-part .trader-item .traider-details .traider-name a {
    color: #ecf0f1;
    font-size: 16px;
    line-height: 1em;
    /* text-transform: uppercase; */
}
.top-traiders .to-content-part .trader-item .traider-details .traider-follower {
    margin-top: 2px;
    color: #6f8ead;
    /* width: 100% !important; */
}
.top-traiders .to-content-part .trader-item .traider-details {
    display: inline-block;
    width: 50%;
    vertical-align: top;
    font-size: 13px;
    line-height: 1em;
    margin-top: 5px;
}
.border-colored {
    height: 4px;
    background-image: linear-gradient(to right, #894b9d, #eb8023, #c2b819, #49ba6f, #2581bc); 
}
.border-colored > div {
    float: left;
    width: 25%;
}
.border-colored .blue {
    background: #3597d3;
}
.border-colored .red {
    background: #c13a2c;
}
.border-colored .orange {
    background: #d35728;
}
.border-colored .yellow {
    background: #f49d1e;
}
.side-content {
    border: none !important;
    background: transparent;
    border-radius: 0 0 5px 5px;
    /*padding: 10px 0px;*/
}
ul.main-drop {
    position: relative;
}
/*ul.main-drop:hover > ul {
    display: block;
}*/
ul.main-drop > ul {
    display: none;
    position: absolute;
    right: 0;
    background: #2e3746;
    min-width: 200px;
    text-align: left;
    /*padding: 10px 0 10px 0;*/
    margin-top: 9px;
    border: 2px solid #506889;
    border-radius: 5px;
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
    border-bottom-color: #4f6987;
    border-width: 10px;
    margin-left: -36px;
}

.dashboard-sidebar-left {
    position: sticky;
}


hr.style14 {
    border: 0;
    height: 1px;
    width: 98%;
    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
}
hr.style13 {
    border: 0;
    height: 1px;
    width: 98%;
    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
    margin-bottom: .6rem !important;
}
hr.style12 {
    border: 0;
    height: 1px;
    width: 98%;
    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
    margin-top: .4rem !important;
    margin: 0 1em;
}

.to-content-part {
    background: #142c46 !important;
    padding: 15px;
    border-radius: 5px;
    padding-bottom: 0px;
}

.stockprice-bg-up {
    background-color: #09bca8;
}

.stockbox {
    color: #fff;
    text-align: center;
    margin-right: 15px;
    padding: 5px 5px;
    width: 65px;
    height: 65px;
    border-radius: 50px;
    position: relative;
}

.stockcompanypriceitem {
    font-size: 20px;
    font-weight: 700;
}

.stockprice-up {
    color: #09bca8;
}

.stock-up-caret {
    border-top: 0;
    border-bottom: 6px solid;
    border-right: 6px solid transparent;
    border-left: 6px solid transparent;
    top: auto;
    bottom: 100%;
    margin-bottom: 1px;
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 2px;
    vertical-align: middle;
}

span.stockdetailbox.ng-binding {
    text-align: center;
    font-size: 15px;
    font-weight: 800;
    margin-left: 5px;
}


.stockprice-bg-down {
    background-color: #ff6862;
}


.stockprice-down {
    color: #ff6862;
}

.stock-down-caret {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 2px;
    vertical-align: middle;
    border-top: 6px solid;
    border-right: 6px solid transparent;
    border-left: 6px solid transparent;
}

.stock-row {
    padding: 10px 10px;
}

.top-traiders {
    
    margin-top: 10px;
}


.stocks-body {
    background: #142c46 !important;
    padding: 15px 15px;
    border-radius: 5px;
    padding-bottom: 5px;
    margin: 20px 0px;
}


.stocks-body .to-top-title {
    padding: 2px 0;
}

/* .to-content-part.to-back-back .to-top-title {padding:5px 15px 5px 15px;} */

.nav>li>a {
    
    padding: 4px 15px !important;
}

.stocks-body hr.style14.style12 {
    border: 0;
    height: 1px;
    width: 98%;
    background-image: -webkit-linear-gradient(left, #1e3554, #1e3554, #1e3554);
    margin-top: .4rem !important;
    margin: .3rem 0;
}

.um-activity-left.um-activity-insert {
    display:none;
}

.um-activity-textarea {  display:none;}

.um-activity-comments {display:none;}

.um-activity-widget{
    padding: 0px 10px;
}

form.um-activity-publish {
    display:none
}

.um-activity-ava {
    width: 70px;
}

.um-activity-author-url {
    display: inline-block;
    
    vertical-align: top;
    font-size: 13px !important;
    line-height: 1em;
    margin-top: 5px;
}

.um-activity-widget .um-activity-head .um-activity-author .um-activity-author-meta .um-activity-author-url a {
    color: #ecf0f1;
    font-size: 15px !important;
    text-transform: capitalize;
}

.um-activity-metadata {
      padding: 0px !important;
    font-family: 'Nunito', sans-serif;
    font-size: 13px;
    color: #6583a8 !important;
    margin-right: 0px;
    margin-top: 5px;
}

.um-activity-head {
    padding:0px;
    margin-top: 15px;
}

.um-activity-body {
    padding-top: 20px;
}


.um-activity-author-meta {
    margin-top: -1px;
    margin-left: 65px;
}

.um-activity-right {
    display:none;
}


/*.um-activity-bullish.notyours, .um-activity-bearish.notyours {display:none !important;}*/
/*.um-activity-left.um-activity-actions hr.style14.style11 { display:none !important}*/

#page-container {
    background: #0c1e33 !important;
}

html {
    background: #0c1e33 !important;
}


.um-activity-bodyinner {
    position: relative;
    display: inline;
}

.um-activity-bodyinner-txt {
    width: 60%;
    display: inline-block;
    vertical-align: middle;
}

.um-activity-bodyinner-photo {
    width: 30%;
    display: inline-table;
    float: right;
    margin-top: -70px;
}

.um-activity-bodyinner-photo img {
    height: 19px;
}

a.um-photo-modal img {
    /* width: 100px; */
}

.top-stocks .to-top-title {
    padding-top: 10px !important;
    padding-left: 15px !important;
    padding-bottom: 0 !important;
    font-size: 13px !important;
}

.um-activity-ava {
    width: 40px;
}
.um-activity-ava {
    position: absolute;
    top: 0;
    left: 15px;   
}

.um-activity-author {
    position: relative;
    padding-left: 5px;
    min-height: 40px;
}

.um-activity-foot.status {
    padding-bottom: 10px !important;
}
.um-activity-widget .um-activity-head.status {
    background: none;
}
.um-activity-widget .um-activity-body.status {
    background: none;
}
.um-activity-widget .um-activity-foot.status {
    background: none;
}
.um-activity-widget {
    box-shadow: none !important;
}
    .um-activity-widget .um-activity-foot.status .um-activity-bullish a span.diconbase {
        background: none;
        padding: 7px 6px;
        border-radius: 50px;
        -webkit-transition: all .5s ease-in-out;
        -moz-transition: all .5s ease-in-out;
        -o-transition: all .5s ease-in-out;
        transition: all .5s ease-in-out;
        border: #25ae5f solid 2px !important;
    }
    .um-activity-widget .um-activity-foot.status .um-activity-bullish:hover a span.diconbase {
        transform: scale(1.3);
        background: #25ae5f;
    }
    .um-activity-widget .um-activity-foot.status .um-activity-bearish a span.diconbase {
        background: none;
        padding: 7px 6px;
        border-radius: 50px;
        -webkit-transition: all .5s ease-in-out;
        -moz-transition: all .5s ease-in-out;
        -o-transition: all .5s ease-in-out;
        transition: all .5s ease-in-out;
        border: #d04234 solid 2px !important;
    }

    .um-activity-widget .um-activity-foot.status .um-activity-bearish:hover a span.diconbase {
        transform: scale(1.3);
        background: #d04234;
    }
    div.um .um-profile-body.activity, div.um-activity {
        margin-top: 15px;
        margin-bottom: 16px;
        margin-left: 10px !important;
        margin-right: 10px !important;
        padding: 0 !important;
    }

</style>

<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
								<div class="post-content">
									<div>
										<div class="row">
											<div class="col-md-12">
									            <div class="panel panel-primary">
									               <div class="panel-heading">
									                    
									                    <span class="">
									                        <!-- Tabs -->
									                        <ul class="nav panel-tabs">
									                            <li class="ggmenu active"><a href="#tab1" data-toggle="tab" class="active show">
									                            	<!-- <img src="https://arbitrage.ph/svg/layout.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">All</span></a></a></li>
									                            <li class="ggmenu"><a href="#tab2" data-toggle="tab"> <!-- <img src="https://arbitrage.ph/svg/user-outline.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">People</span></a></li>
									                            <li class="ggmenu"><a href="#tab3" data-toggle="tab" class=""> <!-- <img src="https://arbitrage.ph/svg/bar-chart.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Stocks</span></a></li>
									                            <li class="ggmenu"><a href="#tab4" data-toggle="tab" class=""> <!-- <img src="https://arbitrage.ph/svg/edit1.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Posts</span></a></li>
									                        </ul>
									                    </span>
									                </div>
									                <div class="panel-body">
									                    <div class="tab-content">
									                        <div class="tab-pane show active" id="tab1">
								                                    <div class="top-traiders">
								                                        <div class="top-traiders-inner">
								                                      
								                                            <div class="to-content-part to-back-back" style="padding-bottom: 5px">
								                                            	<div class="to-top-title">People</div>
								                                            
								                                                <div class="content-inner-part">
								                                                    <?php
								                                                        $i=0;
								                                                        foreach ($toptraiders as $key => $value) { ?>
								                                                        	<hr class="style14 style12">
								                                                            <div class="trader-item">
								                                                                <div class="traider-inner">
								                                                                    <div class="traider-image">
								                                                                        <div class="circle-frame">
								                                                                        <div class="side-image" style="background: url('<?php echo esc_url( get_avatar_url( $value['id'] ) ); ?>') no-repeat center center;">&nbsp;</div>
								                                                                        </div>
								                                                                    </div>
								                                                                    <div class="traider-details">
								                                                                        <div class="traider-name"><a href="https://arbitrage.ph/user/<?php echo $value['user_nicename']; ?>"><?php echo $value['displayname']; ?></a>
								                                                                        
								                                                                        <div class="login"></div>
								                                                                        </div>
								                                                                        <div class="traider-follower">
								                                                                            <div class="onbfdata"><!-- <img src="https://arbitrage.ph/svg/connection.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <?php echo $value['followers']; ?> Connections </div>
								                                                                            <div class="onbfollow">
                                                                                                                <?php echo UM()->Friends_API()->api()->friend_button( $value['id'], $user->ID ); ?>
								                                                                                <!-- <a href="#" class="um-friend-btn um-button um-alt outmingle" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->ID; ?>">Mingle</a> -->
								                                                                            </div>
								                                                                            <!-- <div class="onbfollow">
								                                                                                <a href="#" id="removes-btn" class="add-friend-btn um-button um-alt" data-user_id1="<?php //echo $value['id']; ?>" data-user_id2="<?php //echo $user->ID; ?>">Remove</a>
								                                                                            </div> -->
								                                                                        </div>
								                                                                    </div>
								                                                                </div>
								                                                            </div>

								                                                            
								                                                    <?php 
								                                                            $i++;
								                                                            if($i==5) break;
								                                                        } 
								                                                    ?>
								                                                </div>
								                                            </div>
								                                            
								                                        </div>
								                                    </div>

																	<div class="stocks-body" style="margin-top: 10px">
																		<div class="to-top-title">Stocks</div>
                                                                           <?php

                                                                            $args = array(
                                                                                'post_type'      => 'page',
                                                                                's' => $_GET['s'],
                                                                                'posts_per_page' => -1,
                                                                                'post_parent'    => 504
                                                                             );


                                                                            $parent = new WP_Query( $args );

                                                                            if ( $parent->have_posts() ) : ?>
                                                                                    <ul>    
                                                                                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                                                                    <?php
                                                                                        $dstock = get_the_title();
                                                                                        $key = array_search($dstock, array_column($dstockinfo, 'symbol'));
                                                                                        $price = $dstockinfo[$key]->last;
                                                                                        $change = $dstockinfo[$key]->change;



                                                                                        $dsubtitle = get_post_meta( get_the_id(), 'stock_subtitle', true );
                                                                                    ?>
                                                                                    <hr class="style14 style12">
                                                                        
                                                                                    <div class="row col-xs-12 stock-row">
                                                                                        <a style="line-height: 1.4; text-decoration: none;" class="pr-2" href="../../Stock/BDO">
                                                                                            <div class="stockbox stockprice-bg-up" style="background-color: #<?php echo random_color(); ?>;">
                                                                                                <br> <span class="stockdetailbox ng-binding"><?php echo get_the_title(); ?></span> <br>
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="d-flex flex-column">
                                                                                            <div style="margin-top: 3px;"> <strong class="ng-binding"><?php echo get_the_title(); ?> <?php echo ($dsubtitle ? '- '.$dsubtitle : ''); ?></strong> </div>
                                                                                            <div class="stockcompanypriceitem ng-binding"> &#8369;<?php echo number_format($price,2,".",","); ?> </div>
                                                                                            <?php if ($change > 0): ?>
                                                                                                <div class="ng-binding stockprice-up"> <span class="stock-up-caret"> </span> <?php echo $change; ?>% </div>
                                                                                            <?php else: ?>
                                                                                                <div class="ng-binding stockprice-down"> <span class="stock-down-caret"> </span> <?php echo $change; ?>% </div>
                                                                                            <?php endif ?>
                                                                                            
                                                                                        </div>
                                                                                    </div>

                                                                                <?php endwhile; ?>
                                                                                    </ul>
                                                                            <?php endif; wp_reset_postdata(); ?>
                                                                        
																		
																	</div>
																	

																		<div class="top-traiders">
									                                        <div class="top-traiders-inner">
									                                            
									                                            
									                                            <div class="to-content-part to-back-back">
                                                                                    
									                                            	<div class="to-top-title">Posts</div>
									                                            	<hr class="style14 style12">
									                                                <div class="content-inner-part">
                                                                                        <?php
                                                                                            global $wpdb;    
                                                                                            $result = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%".$_GET['s']."%'");
                                                                                               
                                                                                        ?>
                                                                                            <?php foreach ($result as $key => $value) { ?>
                                                                                                <?php $dcontent = $value->post_content; ?>
                                                                                                <?php if (strpos($dcontent, 'has just followed') === false): ?>

                                                                                                    <?php echo do_shortcode('[ultimatemember_activity user_wall="false" wall_post="'.$value->ID.'" template="activity" mode="activity" form_id="um_activity_id" ]'); ?>
                                                                                                    
                                                                                                    
                                                                                               <?php endif ?>
                                                                                            <?php } ?>
                                                                                        
									                                                </div>
									                                            </div>
									                                            
									                                        </div>
									                                    </div>
				
									                        </div>

									                        <div class="tab-pane" id="tab2">
																 <div class="top-traiders">
								                                        <div class="top-traiders-inner">
								                                      
								                                            <div class="to-content-part to-back-back" style="padding-bottom: 5px">
								                                            	<div class="to-top-title">People</div>
								                                            
								                                                <div class="content-inner-part">
								                                                    <?php
								                                                        $i=0;
								                                                        foreach ($toptraiders as $key => $value) { ?>
								                                                        	<hr class="style14 style12">
								                                                            <div class="trader-item">
								                                                                <div class="traider-inner">
								                                                                    <div class="traider-image">
								                                                                        <div class="circle-frame">
								                                                                        <div class="side-image" style="background: url('<?php echo esc_url( get_avatar_url( $value['id'] ) ); ?>') no-repeat center center;">&nbsp;</div>
								                                                                        </div>
								                                                                    </div>
								                                                                    <div class="traider-details">
								                                                                        <div class="traider-name"><a href="https://arbitrage.ph/user/<?php echo $value['user_nicename']; ?>"><?php echo $value['displayname']; ?></a>
								                                                                        
								                                                                        <div class="login"></div>
								                                                                        </div>
								                                                                        <div class="traider-follower">
								                                                                            <div class="onbfdata"><!-- <img src="https://arbitrage.ph/svg/connection.svg" style="width: 19px;vertical-align: sub;height: 18px;"> --> <?php echo $value['followers']; ?> Connections </div>
								                                                                            <div class="onbfollow">
								                                                                                <a href="#" id="mingle-btn" class="mingle-btn um-button um-alt" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->ID; ?>">Mingle</a>
								                                                                            </div>
								                                                                            <!-- <div class="onbfollow">
								                                                                                <a href="#" id="removes-btn" class="add-friend-btn um-button um-alt" data-user_id1="<?php //echo $value['id']; ?>" data-user_id2="<?php //echo $user->ID; ?>">Remove</a>
								                                                                            </div> -->
								                                                                        </div>
								                                                                    </div>
								                                                                </div>
								                                                            </div>

								                                                            
								                                                    <?php 
								                                                            $i++;
								                                                            if($i==5) break;
								                                                        } 
								                                                    ?>
								                                                </div>
								                                            </div>
								                                            
								                                        </div>
								                                    </div>
									                        </div>


									                        <div class="tab-pane" id="tab3">
									                        		<div class="stocks-body" style="margin-top: 10px !important">
																		<div class="to-top-title" style="margin-top: -10px">Stocks</div>
																			<?php

                                                                            $args = array(
                                                                                'post_type'      => 'page',
                                                                                's' => $_GET['s'],
                                                                                'posts_per_page' => -1,
                                                                                'post_parent'    => 504
                                                                             );


                                                                            $parent = new WP_Query( $args );

                                                                            if ( $parent->have_posts() ) : ?>
                                                                                    <ul>    
                                                                                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                                                                    <?php
                                                                                        $dstock = get_the_title();
                                                                                        $price = $dstockinfo->$dstock->last;
                                                                                        $change = $dstockinfo->$dstock->change;

                                                                                        $dsubtitle = get_post_meta( get_the_id(), 'stock_subtitle', true );
                                                                                    ?>
                                                                                    <hr class="style14 style12">
                                                                        
                                                                                    <div class="row col-xs-12 stock-row">
                                                                                        <a style="line-height: 1.4; text-decoration: none;" class="pr-2" href="../../Stock/BDO">
                                                                                            <div class="stockbox stockprice-bg-up" style="background-color: #<?php echo random_color(); ?>;">
                                                                                                <br> <span class="stockdetailbox ng-binding"><?php echo get_the_title(); ?></span> <br>
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="d-flex flex-column">
                                                                                            <div style="margin-top: 3px;"> <strong class="ng-binding"><?php echo get_the_title(); ?> <?php echo ($dsubtitle ? '- '.$dsubtitle : ''); ?></strong> </div>
                                                                                            <div class="stockcompanypriceitem ng-binding"> &#8369;<?php echo number_format($price,2,".",","); ?> </div>
                                                                                            <?php if ($change > 0): ?>
                                                                                                <div class="ng-binding stockprice-up"> <span class="stock-up-caret"> </span> <?php echo $change; ?>% </div>
                                                                                            <?php else: ?>
                                                                                                <div class="ng-binding stockprice-down"> <span class="stock-down-caret"> </span> <?php echo $change; ?>% </div>
                                                                                            <?php endif ?>
                                                                                            
                                                                                        </div>
                                                                                    </div>

                                                                                <?php endwhile; ?>
                                                                                    </ul>
                                                                            <?php endif; wp_reset_postdata(); ?>
                                                                            
																		
																		
																	</div>
									                        </div>

									                        <div class="tab-pane" id="tab4">
									                        	<div class="top-traiders">
									                                        <div class="top-traiders-inner">									                                           
									                                            <div class="to-content-part to-back-back">

									                                            	<div class="to-top-title">Posts</div>

									                                                   <div class="content-inner-part">
                                                                                        <?php
                                                                                            global $wpdb;    
                                                                                            $result = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%".$_GET['s']."%'");
                                                                                             
                                                                                        ?>
                                                                                            <?php foreach ($result as $key => $value) { ?>
                                                                                                <?php $dcontent = $value->post_content; ?>
                                                                                                <?php if (strpos($dcontent, 'has just followed') === false): ?>

                                                                                                    <?php echo do_shortcode('[ultimatemember_activity user_wall="false" wall_post="'.$value->ID.'" template="activity" mode="activity" form_id="um_activity_id" ]'); ?>
                                                                                                    
                                                                                                    
                                                                                               <?php endif ?>
                                                                                            <?php } ?>
                                                                                        
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


			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					  <?php get_template_part('parts/sidebar', 'trendingstocks'); ?>

                       <?php // get_template_part('parts/sidebar', 'ads'); ?>
	

				</div>
				<div class="ontofooter">
					<div class="ontonowfooter">
						<ul class="footmore">
							<li><a href="#">Privacy</a></li>
							<li><a href="#">Terms</a></li>
							<li><a href="#">Business</a></li>
							<li class="nobar">
								<a href="#" class="moretoclick">More</a>
								<ul class="closehideme">
									<li class="ontohidebase"><a href="#">About</a></li>
									<li class="ontohidebase"><a href="#">FAQ</a></li>
									<li class="ontohidebase"><a href="#">Companies</a></li>
									<li class="ontohidebase"><a href="#">Contact Us</a></li>
								</ul>
							</li>
						</ul>
						<div class="copyright">Arbitrage &copy; 2019</div>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<div class="script">
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" async></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" async></script>

</div>



<?php
get_footer('all');
get_footer('dashboard');

