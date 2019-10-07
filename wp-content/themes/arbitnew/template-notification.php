<?php
	/*
	* Template Name: Notification Page
	* Template page for Search Page
	*/
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
require("notification/header-files.php");
require("parts/global-header.php");
date_default_timezone_set('Asia/Manila');
require("parts/sidebar-calc.php");
require("parts/sidebar-varcalc.php");
require("parts/sidebar-avarageprice.php");
?>
<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
		<?php require("parts/global-sidebar.php"); ?>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php echo do_shortcode('[ultimatemember_notifications]'); ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
					<?php
					 			get_template_part('parts/sidebar', 'trendingstocks');
					 			get_template_part('parts/sidebar', 'traders');
								#get_template_part('parts/sidebar', 'latestnews');
								#get_template_part('parts/sidebar', 'watchlist');
								#get_template_part('parts/sidebar', 'topplayers');
                get_template_part('parts/sidebar', 'alert');
					 			get_template_part('parts/sidebar', 'footer');
					 ?>
					 </div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
</div>
<?php require("notification/footer-files.php"); ?>
