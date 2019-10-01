<?php
	/*
	* Template Name: Message Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );

?>


<style type="text/css">
		.ifc-admin-tick-icon-new.glyphicon {
	    color: #fff !important;
	}
	.ifc-admin-tick-icon-new.glyphicon {
    color: #fff !important;
	}

	.ifc-chat-window-message-body-username-text-name {
	    color: #fff !important;
	}

	.ifc-chat-window-message-body-message {
	    color: #fff !important;
	}

	button.ifc-chat-window-options-icon {
    color: #fff !important;
	}

	.ifc-chat-display-time {
	    color: #fff !important;
	}

	button.ifc-chat-window-options-send.ifc-chat-window-options-send-default {
	    color: #fff !important;
	}
	.messages-page-inner .ifc-chat-window-message-wrapper-compact.ifc-chat-window-message.ifc-window-message-self {
	    background: #2f4962 !important;
	    width: 90% !important;
	    margin-left: 80px;
	    padding: 10px !important;
	    border-radius: 6px;
	    color: #fff !important;
	}
	.ifc #ifc-app-container.ifc-light .ifc-chat-window .ifc-chat-window-content .ifc-chat-window-message-wrapper-compact:hover {
	    background-color: #243648 !important;
	}

	.arb_top_ticker {display:block;}
	.arb_top_ticker {
			position:absolute;
			top:0;
			left:0;
			z-index:9;
			width:100%;
		}

	.ifc-chat-list-roster {
    background: #fff !important;
	}


	.messages-page-inner {
	    width: 100%;
	    padding-right: 15px;
	    padding-left: 0px !important;
	    margin-right: auto;
	    margin-left: auto;
}	
</style>


<div class="messages-page">
	<div class="messages-page-inner">
		<div class="row">
				<div class="col-md-9">
					<div class="iflychat-embed-full-chat" data-height="500px" data-width="100%"></div>
					<?php do_shortcode('[chatroom]'); ?>
				</div>
				<div class="col-md-3">
					<div class="latest-news">
						<div class="to-top-title" style="color: #fff">Latest News</div>
						<div class="to-content-part">
							<div class="to-rss-inner">
								<?php dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
								<br class="clear">
							</div>
						</div>
						<div class="to-bottom-title">
							<!-- powerd by Google News -->
							<a href="#" class="to-view-more">View all News</a>
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
