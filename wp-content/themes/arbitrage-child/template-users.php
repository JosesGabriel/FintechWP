<?php
	/*
	* Template Name: Users Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
global $wpdb;
$user = wp_get_current_user();
get_header( 'dashboard' );

$profile_id = um_profile_id();
$default_cover = UM()->options()->get( 'default_cover' );
um_fetch_user($profile_id);

$myusersecret = get_user_meta($profile_id, 'user_secret', true);

$ismyprofile = ($user->ID == $profile_id ? true : false);


	// $topargs = array(
	//     'role'          =>  '',
	// );

	// $users = get_users($topargs);
	// $newuserlist = array();
	// foreach ($users as $key => $value) {
	// 	$userdetails['id'] = $value->ID;
	// 	$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
	// 	$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );

	// 	array_push($newuserlist, $userdetails);
	// }

	// usort($newuserlist, function($a, $b) {
	//     return $a['followers'] <=> $b['followers'];
	// });
	// $toptraiders = array_reverse($newuserlist);
?>

<style type="text/css">
	#main-content .container:before {
		background-color: none !important;
	}
	.um-header-outer {
	    background: #142c46 !important;
	    border-bottom-left-radius: 8px;
	    border-bottom-right-radius: 8px;
	}
	.the_user_top_page {
		background: none !important;
	}
	a.um-follow-btn.um-button.um-alt:hover {
		background: #091523 !important;
	}
	a.um-follow-btn.um-button.um-alt {
		-webkit-transition: all .5s ease-in-out !important;
	    -moz-transition: all .5s ease-in-out !important;
	    -o-transition: all .5s ease-in-out !important;
	    transition: all .5s ease-in-out !important;
	}
	a.um-friend-btn.um-button.um-alt:hover {
		background: #091523 !important;
	}
	a.um-friend-btn.um-button.um-alt {
		-webkit-transition: all .5s ease-in-out !important;
	    -moz-transition: all .5s ease-in-out !important;
	    -o-transition: all .5s ease-in-out !important;
	    transition: all .5s ease-in-out !important;
	}

    /*	.right-dashboard-part{
	    float: left;
	    width: 27%;
	    padding: 10px 0px !important;
	    height: 140%;
	    position: -webkit-sticky;
	    position: sticky;
	    top: -112%;
	}*/
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

	td.to-stock a {
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
	.srr-tab-wrap li {
    	margin: 0px 5px 0 0!important;
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
	    z-index: 9999;
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
	    top: 8px;
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
	.um-cover {
		height: 320px !important
	}
	.um-cover-add {
		height: 320px !important;
	}
	.um-dropdown {
	    z-index: 999999;
	    position: absolute;
	    height: auto;
	    background: #142c46;
	    -moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
	    z-index: 10;
	    display: none;
	    border: none;
	    box-sizing: border-box;
	    -webkit-box-shadow: 0 0 2px rgba(0,0,0,0.1);
	    box-shadow: 0px 2px 3px 0px rgba(7, 13, 19, 0.52);
	}
	#main-header {
		z-index: 999999;
	}
	.um-profile.um .um-profile-headericon a {
		color: #fffffe;
	}
	.um-icon-arrow-up-b {
		color: #213f58;
	}
	.um-dropdown li:last-child a {
	    border-top: 1px solid #1e3554;
	    padding: 7px;
	}
	.um-profile.um .um-profile-headericon a:hover, .um-profile.um .um-profile-edit-a.active {
	    color: #00bcd4 !important;
	}

</style>

<?php if (isset($_GET['um_action']) && $_GET['um_action'] == "edit"){ ?>
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

        .cgitem li{
        	list-style-type: none !important;
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

        .cgitem ul li{
        	list-style-type: none !important;
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
            top: 8px;
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
            font-size: 12px !important;
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
            font-size: 12px !important;
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
            right: -1px;
            background: #142c46 !important;
            min-width: 200px;
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
<?php } ?>
<?php
    if(!$ismyprofile && isset($_GET['profiletab']) && isset($_GET['um_action'])){
        wp_redirect( "https://arbitrage.ph/user/".um_user('user_login') );
        exit;
    }
?>
<div id="main-content" class="ondashboardpage id<?php echo $profile_id; ?> <?php echo $ismyprofile; ?>">
	<div class="container">
	<div class="the_user_top_page">
		<div class="um um-profile <?php echo (isset($_GET['um_action']) && $_GET['um_action'] == 'edit' ? 'um-editing' : 'um-viewing'); ?> um-11 um-role-administrator uimob800 topbannerprofile">
			<div class="um-form">
				<div class="um-cover <?php echo (isset($_GET['um_action']) && $_GET['um_action'] == 'edit' ? 'has-cover' : ''); ?>" data-user_id="<?php echo $profile_id; ?>" data-ratio="2.7:1" style="height: 320px;">

			<?php

			$default_cover = UM()->options()->get( 'default_cover' );

			$overlay = '<span class="um-cover-overlay">
					<span class="um-cover-overlay-s">
						<ins>
							<i class="um-faicon-picture-o"></i>
							<span class="um-cover-overlay-t">' . __( 'Change your cover photo', 'ultimate-member' ) . '</span>
						</ins>
					</span>
				</span>';

			do_action( 'um_cover_area_content', um_profile_id() );
			if ( UM()->fields()->editing ) {

				$hide_remove = um_profile( 'cover_photo' ) ? false : ' style="display:none;"';

				$items = array(
					'<a href="#" class="um-manual-trigger" data-parent=".um-cover" data-child=".um-btn-auto-width">' . __( 'Change cover photo', 'ultimate-member' ) . '</a>',
					'<a href="#" class="um-reset-cover-photo" data-user_id="' . um_profile_id() . '" ' . $hide_remove . '>' . __( 'Remove', 'ultimate-member' ) . '</a>',
					'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
				);

				UM()->profile()->new_ui( 'bc', 'div.um-cover', 'click', $items );
			}

			UM()->fields()->add_hidden_field( 'cover_photo' );

			echo $overlay; ?>

			<div class="um-cover-e" data-ratio="<?php echo $args['cover_ratio']; ?>">

				<?php if (um_profile( 'cover_photo' )) { ?>

					<?php

					if (UM()->mobile()->isMobile()) {
						if (UM()->mobile()->isTablet()) {
							echo um_user( 'cover_photo', 1000 );
						} else {
							echo um_user( 'cover_photo', 300 );
						}
					} else {
						echo um_user( 'cover_photo', 1000 );
					}

					?>

				<?php } else if ($default_cover && $default_cover['url']) {

					$default_cover = $default_cover['url'];

					echo '<img src="' . $default_cover . '" alt="" />';

				} else {

                    if ($user->ID != $profile_id) {
                        ?>
                        <div style="height:320px"></div>
                        <?php
                    }
					else if (!isset( UM()->user()->cannot_edit )) { ?>

						<a href="#" class="um-cover-add um-manual-trigger" data-parent=".um-cover"
						   data-child=".um-btn-auto-width"><span class="um-cover-add-i"><i
									class="um-icon-plus um-tip-n"
									title="<?php _e( 'Upload a cover photo', 'ultimate-member' ); ?>"></i></span></a>

					<?php }

				} ?>

			</div>

				</div>
				<div class="top-header-gear">
					<div class="top-header-inner">
					</div>
					<div class="profile-name">
						<div class="prof-name-inner">
							<?php
								$unametype = get_user_meta($profile_id, 'disname', true);
								$nickname = get_user_meta($profile_id, 'nickname', true);
							?>
							<?php echo um_user('full_name'); ?>

						</div>
					</div>
				</div>
				<div class="um-header-outer">
					<div class="um-header">

						<?php

						$default_size = str_replace( 'px', '', $args['photosize'] );

						$overlay = '<span class="um-profile-photo-overlay">
								<span class="um-profile-photo-overlay-s">
									<ins>
										<i class="um-faicon-camera"></i>
									</ins>
								</span>
							</span>';

						do_action( 'um_pre_header_editprofile', $args ); ?>

						<div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

							<a class="um-profile-photo-img"
							   title="<?php echo um_user( 'display_name' ); ?>"><?php echo $overlay . get_avatar( um_user( 'ID' ), $default_size ); ?></a>

							<?php
                           if (!isset( UM()->user()->cannot_edit ) && $user->ID == $profile_id) {

								UM()->fields()->add_hidden_field( 'profile_photo' );

								if (!um_profile( 'profile_photo' )) { // has profile photo

									$items = array(
										'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Upload photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
									);

									$items = apply_filters( 'um_user_photo_menu_view', $items );

									echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

								} else if (UM()->fields()->editing == true) {

									$items = array(
										'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Change photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-reset-profile-photo" data-user_id="' . um_profile_id() . '" data-default_src="' . um_get_default_avatar_uri() . '">' . __( 'Remove photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
									);

									$items = apply_filters( 'um_user_photo_menu_edit', $items );

									echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );

								}

							}

							?>

						</div>
						<div class="dmetadetails">
							<div class="meta-details-inner">
								<ul>
									<li>
										<div class="oncount"><a class="profile_peers_count" href="https://arbitrage.ph/user/<?php echo um_user('user_login') ?>/?getdpage=friends"><span class="um-ajax-count-friends">0</span></a></div>
										<div class="onlabel">Peers</div>
									</li>
									<li>
										<div class="oncount"><a class="profile_post_count" href="https://arbitrage.ph/user/<?php echo um_user('user_login') ?>/?getdpage=activity">0</a></div>
										<div class="onlabel">Posts</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="profile-meta-data">
							<div class="profile-meta-inner">
								<br class="clear">

							</div>
						</div>
						<div class="dnavtopleft">
							<div class="dnavtopinner">
								<ul>
									<?php if(!$ismyprofile): ?>
										<?php echo $ismyprofile; ?>
                                        <?php if(UM()->Friends_API()->api()->is_friend($profile_id, get_current_user_id())): ?>
                                            <li>
                                                <a href="https://arbitrage.ph/vyndue/?us=<?php echo $myusersecret; ?>" class="um-button um-alt" style="margin-top: -25px;">Message</a>
                                            </li>
                                        <?php endif; ?>
										<li>
											<?php echo UM()->Friends_API()->api()->friend_button( $profile_id, get_current_user_id() ); ?>
										</li>
									<?php else: ?>
											<?php if (isset($_GET['um_action']) && $_GET['um_action'] == 'edit'): ?>

											<?php else: ?>
												<li>
													<a href="https://arbitrage.ph/user/<?php echo um_user('user_login') ?>/?profiletab=main&amp;um_action=edit" class=" um-button um-alt" >Edit Profile</a>
												</li>
											<?php endif ?>


									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.side-header {
		display: none;
	}
	.inner-center-dashboard {
		padding: 0;
    	margin-top: 9px;
	}
	.inner-placeholder {
		padding-top: 0 !important;
	}
    .dashboard-sidebar-left-inner {
        position: sticky;
        position: -webkit-sticky;
        top: 44px;
    }
</style>
    <?php get_template_part('parts/sidebar', 'calc'); ?>
    <?php get_template_part('parts/sidebar', 'varcalc'); ?>
    <?php get_template_part('parts/sidebar', 'avarageprice'); ?>

	<div class="inner-placeholder">
		<div class="inner-main-content userprofilepage">
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                    	<?php get_template_part('parts/sidebar', 'profile'); ?>

					</div>
				</div>
			</div>

<?php 

	if($_GET['um_action'] == 'edit'){
		?>
		<div class="center-dashboard-part" style="max-width: 900px;">
		<?php
	}
	else{ 
		?>
		<div class="center-dashboard-part">
		<?php
	}

?>

				<div class="inner-center-dashboard">
					<div class="add-post">
					<?php
						if (isset($_GET['getdpage']) && $_GET['getdpage'] == 'friends'):
							?>
							<div class="dpostlet" style="margin-top: 11px;">
								<div class="header-port" style="background: #142c46;">Peers</div>
								<div class="body-port">
									<div class="friends-list-profile"><?php echo do_shortcode('[ultimatemember_friends user_id='.$profile_id.']'); ?></div>
								</div>
							</div>
							<?php
						elseif (isset($_GET['getdpage']) && $_GET['getdpage'] == 'messages'):
							?>
								<div class="open-messages">
									<div class="messages-inner">
										<div class="message-header">Messages</div>
										<div class="message-body">
											<?php echo do_shortcode('[ultimatemember_messages]'); ?>
										</div>
									</div>
								</div>
							<?php
							// echo do_shortcode('[ultimatemember_messages]');
						elseif(isset($_GET['getdpage']) && $_GET['getdpage'] == 'activity'):
							?>
								<div class="profile-post-content">
									<?php echo do_shortcode('[ultimatemember_wall user_id="'.$profile_id.'" user_wall="true" ]'); ?>
								</div>
							<?php
						else:
							?>
                            
							<?php if (isset($_GET['um_action']) && $_GET['um_action'] == "edit"){ ?>
								<div class="profile-post-content">
									<?php echo do_shortcode('[ultimatemember_account]'); ?>
								</div>
                            <?php }else{ ?>
								<div class="profile-post-content load-social-wall">
									<?php //echo do_shortcode('[ultimatemember_wall user_id="'.$profile_id.'" user_wall="true" ]'); ?>
								</div>
                             <?php } ?>
                                
							<?php
						endif;
					?>

					</div>
				</div>
			</div>
			<div class="right-dashboard-part" style="padding: 10px 0px !important;">
				<div class="right-dashboard-part-inner">

                	<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>
                    <?php get_template_part('parts/sidebar', 'watchlist'); ?>
                    <?php get_template_part('parts/sidebar', 'traders'); ?>
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
                
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->
<style type="text/css">
    .arb_calcbox {
        top: 0;
    }
	#main-content {
	    background-color: #0d1f33 !important;
	}
	#main-content .container {
	    padding-top: 0px;
	}
	.et_fixed_nav.et_show_nav #page-container {
		padding-top: 45px !important;
	}
	.um-header-outer {
	    background: #142c46 !important;
	}
	.um-11.um .um-profile-photo a.um-profile-photo-img {
	    width: 180px;
	    height: 180px;
	    top: -6px;
	    left: 15px;
	}
	.top-header-inner .um-profile-edit {
    	right: initial;
    	top: -42px;
	    margin-left: 17px;
    }
    .prof-name-inner {
	    text-transform: capitalize;
	    font-size: 30px;

	}
	.the_user_top_page .um-cover-e {
	    background: #1e3554;
	    -webkit-transition: background-color 0.5s ease-out;
		-moz-transition: background-color 0.5s ease-out;
		-o-transition: background-color 0.5s ease-out;
		transition: background-color 0.5s ease-out;
	}
	.the_user_top_page .um-cover-e:hover {
	    background: #091523;
	}
	.um-ajax-count-followers {
		color: #2ea3f2;
	}
	.top-header-gear .profile-name .prof-name-inner {
		position: absolute;
	    top: -63px;
	    left: 26%;
	    color: #fff;
	    text-shadow: 2px 2px 4px #333;
	}
	.dmetadetails {
	    float: left;
	    position: relative;
	    display: block;
	    left: 24%;
	}

	li.cgitem {
	    display: inline-block !important;
	    padding: 2px 6px;
	    background-color: #213f58 !important;
	    margin: 0 0 0 3px;
	    font-size: 13px;
	    color: #d8d8d8;
	    border-radius: 4px;
	}




	.top-header-inner .um-profile-edit {
	    right: initial;

	}
	#main-content .container:before {
		position: absolute;
		top: 0;
		width: 1px;
		height: 100%;
		background-color: #e2e2e2;
		display: none;
	}
	.container {
	    width: 100%;
	    padding-right: 31px;
	    padding-left: 31px;
	}
	.dnavtopinner ul {
	    margin: 0;
	    padding: 0;
	    padding-right: 20px;
	    padding-top: 3px;
	}
	a.um-follow-btn.um-button.um-alt {
	    display: table-cell !important;
	    border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    padding: 8px 27px !important;
	    padding-top: 10px !important;
	    font-family: 'Nunito', sans-serif;
	    color: #6583a8 !important;
	    background: none !important;
	}


	a.um-unfriend-btn.um-button.um-alt {
	    display: table-cell !important;
	    border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    padding: 5px 5px !important;
	    padding-top: 5px !important;
	    font-family: 'Nunito', sans-serif;
	    color: #6583a8 !important;
	    background: none !important;
	    font-size: 13px !important;
	    line-height: 12px !important;
	    min-width: 90px !important;
	}


	a.um-friend-btn.um-button.um-alt {
	    display: table-cell !important;
	    vertical-align: middle !important;
	    text-align: center;
	    border-radius: 26px !important;
	    border: 1.3px solid #6583a8 !important;
	    padding: 5px 5px !important;
	    padding-top: 5px !important;
	    font-family: 'Nunito', sans-serif;
	    color: #6583a8 !important;
	    background: none !important;
	    line-height: 12px !important;
	    font-size: 13px !important;
	    min-width: 90px !important;
	}
	.meta-details-inner ul li .oncount a {
	    color: #00bcd4;
	}
	.meta-details-inner ul li .oncount span {
	    color: #00bcd4;
	}
</style>

<script>
(function ($) {
    
    $(document).ready(function () {
        $.ajax({
            url: '/apipge/?daction=user-posts-count&user-id=<?php echo $profile_id ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                let count = 0;
                if (response.success) {
                    count = response.data.posts_count;
                }
                $('.profile_post_count').html(count);
            }
        })

        $.ajax({
            url: '/apipge/?daction=user-peers-count&user-id=<?php echo $profile_id ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                let html = '<span class="um-ajax-count-friends">0</span>';
                if (response.success) {
                    html = response.data.peers_count;
                }
                $('.profile_peers_count').html(html)
            }
        })

        if ($('.profile-post-content').hasClass('load-social-wall')) {
            $.ajax({
                url: '/apipge/?daction=user-social-wall&user-id=<?php echo $profile_id ?>',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    let html = 'Unable to load posts.';
                    if (response.success) {
                        html = response.data.contents;
                    }
                    $('.profile-post-content').html(html);
                }
            })
        }
    });

})(jQuery);
</script>
<?php

get_footer();
