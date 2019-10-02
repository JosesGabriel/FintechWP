<?php
	/*
	* Template Name: Test Page Lerroux
	* Template page for Testing
	*/

?>
<?php
get_header( 'ed' );

$user = wp_get_current_user();
?>

<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                    	<?php //get_template_part('parts/sidebar', 'profile'); ?>

					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
						<?php //echo do_shortcode('[ultimatemember_activity]'); ?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">



				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div>



<?php
//get_footer('dashboard');
?>