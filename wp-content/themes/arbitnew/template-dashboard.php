<?php
	/*
    * Template Name: Dashboard
    */


global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
require("dashboard/header-files.php");
require("parts/global-header.php");

date_default_timezone_set('Asia/Manila'); ?>

<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>
<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
	
<?php require("parts/global-sidebar.php"); ?>	

			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php echo do_shortcode('[ultimatemember_activity]'); ?>
						<?php //if ( have_posts() ) : while ( have_posts() ) : the_post();
						//the_content();
						//endwhile; else: ?>
						<?php //endif; ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
					<?php //get_template_part('parts/sidebar', 'trendingstocks'); ?>
					
					<?php //get_template_part('parts/sidebar', 'traders'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'watchlist'); ?>

                    <?php //get_template_part('parts/sidebar', 'topplayers'); ?>

                    <?php //get_template_part('parts/sidebar', 'alert'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div>

<?php

get_footer();
