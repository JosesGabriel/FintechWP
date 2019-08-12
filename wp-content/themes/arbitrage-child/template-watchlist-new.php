<?php

	/*
	* Template Name: Watchlist Page New
	* Template page for Watchlist Page Platform
    */

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');

?>    

    <?php get_template_part('parts/global', 'css'); ?>
    <?php get_template_part('parts/sidebar', 'calc'); ?>
    <?php get_template_part('parts/sidebar', 'varcalc'); ?>
    <?php get_template_part('parts/sidebar', 'avarageprice'); ?>    

    <div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
						
						<?php get_template_part('parts/sidebar', 'tasks'); ?>
                    
                    	<?php get_template_part('parts/sidebar', 'profile'); ?>
                        
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                        <?php echo 'Content Here'; ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
					
					<?php get_template_part('parts/sidebar', 'traders'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'watchlist'); ?>

                    <?php get_template_part('parts/sidebar', 'alert'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>

			<br class="clear">
		</div>
	</div>

</div>
