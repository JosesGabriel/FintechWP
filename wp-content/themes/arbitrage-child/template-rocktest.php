<?php
	/*
	* Template Name: Rocky's test page
	* Template page for Journal Dashboard
	*/

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
                    	<?php // echo do_shortcode("[mytagfriends userid='".$userID."']");?>
                        <?php echo do_shortcode("[mytagfriends userid='7']");?>
                    </div>
                </div>
            </div>
                
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

