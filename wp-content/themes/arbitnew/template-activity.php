<?php
	/*
	* Template Name: Activity Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila'); ?>

<?php
	$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);

	function working_days_ago($days) {
	    $count = 0;
	    $day = strtotime('-2 day');
	    while ($count < $days || date('N', $day) > 5) {
	       $count++;
	       $day = strtotime('-1 day', $day);
	    }
	    return date('Y-m-d', $day);
	}

?>

<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
                    
                    	<?php get_template_part('parts/global', 'css'); ?>

                    	<?php get_template_part('parts/sidebar', 'profile'); ?>

                    	<?php get_template_part('parts/sidebar', 'treaders'); ?>
                        
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php echo do_shortcode('[ultimatemember_activity user_wall="false" wall_post="'.$_GET['wall_post'].'" template="activity" mode="activity" form_id="um_activity_id" ]'); ?>
						<?php
						//  if ( have_posts() ) : while ( have_posts() ) : the_post();
						// the_content();
						// endwhile; else:
						 ?>
						<!-- <p>Sorry, no posts matched your criteria.</p> -->
						<?php //endif; ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
                
                	<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>

                    <?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php

get_footer();

