<?php
	/*
    * Template Name: Dashboard
    */
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
require("dashboard/header-files.php");
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
				<div class="swipecenterl"></div>
				<div class="swipecenter-area-r"></div>
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php echo do_shortcode('[ultimatemember_activity]'); ?>
					</div>
				</div>

				<div class="swipecenterr"></div>
			</div>
			<div class="right-dashboard-part">
				<div class="swiperight-area-r"></div>
				<div class="swiperight-area-r2"></div>
				<div class="right-dashboard-part-inner">
					<?php
						get_template_part('parts/sidebar', 'trendingstocks');
						get_template_part('parts/sidebar', 'traders');
						get_template_part('parts/sidebar', 'alert');
						get_template_part('parts/sidebar', 'latestnews');
					?>
					<div class="container-sticky">
					<?php
						get_template_part('parts/sidebar', 'watchlist');
						#get_template_part('parts/sidebar', 'topplayers');
						get_template_part('parts/sidebar', 'footer');
					 ?>	
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
</div>
<?php require("dashboard/footer-files.php"); ?>

<div class="modal fade" id="vynduemodals" tabindex="" role="dialog" aria-labelledby="vynduemodalsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vynduemodalsLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>