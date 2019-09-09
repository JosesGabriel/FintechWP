<?php
	/*
	* Template Name: Message Page_monicar
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );

?>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script
  src="https://code.jquery.com/jquery-migrate-3.0.1.min.js"
  integrity="sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4="
  crossorigin="anonymous"></script>
	<script type="text/javascript">
		jQuery(function(){
	    	jQuery(".chatroomFriendsFilter").hide() // try to hide google navigation bar
	   	});
	</script>
	<style type="text/css">
		.chatroomFriendsFilter {
			display: none;
		}
		#cr-private-search{ 
			border-bottom: none;
		    padding: 5px;
		    padding-left: 0;
		}
		#chatroomSearchFriends {
			width: 80% !important;
			padding: 12px !important;
			color: #fff;
    		font-size: 15px;
		}
		.cr_relative {
		}
		.chatroomWindow {
		    width: 100%;
		    padding-right: 0 !important;
		    padding-top: 8px;
		}
		.to-top-title {
			background-color: #1e2832 !important;
		}
		.to-bottom-title {
			display: none;
		}
		.cl-background {
			background-color: #1f2d3a;
		}
		.cr-left {
			width: 100%;
		}
		.latest-news {
			border: none;
		}
		i.chatStatus{
		    margin: 31px 0px 0 26px;
			border: 3px solid #1f2d3a;
		    border-radius: 50%;
		    width: 15px;
		    height: 15px;
		}
		.chatroomFriendsRow{
		   padding: 5px 23px;
		}
		.chatroomFriendsImage {
		    width: 43px;
		    height: 43px;
		}
		.cr_user_info {
			font-family: 'Roboto', sans-serif;
    		color: #fff;
		}
		.cr_user_info {
			font-size: 13px;
		}
		.cr_profile_image {
			border-radius: 50%;
		}
		.me {
			margin: 17px 0px 0 20px !important;
			border: 3px solid #1f2d3a;
		    border-radius: 50% !important;
		    width: 15px !important;
		    height: 15px !important;
		    position: relative;
    		top: 33px;
    		left: 42px;
		}
		.cr_col.cr_onethird:hover {
		    overflow-y: scroll;
		}
		.row {
			margin-right: 0px;
		}
		.chatroomContent {
    		color: #ffffff !important;
    	}
    	.chatroomBody {
    		padding-right: 0 !important;
    	}
    	.cr_separate_chat {
    		height: 183px;
    	}
	</style>

				<div class="cl-background cr-left">

					<div class="row">
						<div class="cr-row-room col-md-9">
						<?php 
							echo do_shortcode("[chatroom]");
						 ?>
						 	
						 </div>
					
					</div>	 

					<div class="cr-row-rightroom col-md-3">
						<div class="latest-news">
							<div class="to-top-title" style="color: #fff; background: none !important;">Latest News</div>
							<div class="to-content-part">
								<div class="to-rss-inner">
									<?php dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
									<br class="clear">
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>

				

<script src="/assets/js/angular/functions.js?v=1.218"></script>
<script src="/assets/js/angular/controllers.js?v=1.218"></script>
<script src="/assets/js/angular/directives.js?v=1.218"></script>
<script src="/assets/js/angular/filters.js?v=1.218"></script>
<script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
<script src="/assets/js/datafeed.js?v=2.218"></script>

<?php

get_footer('dashboard');
