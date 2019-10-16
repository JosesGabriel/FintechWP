<?php
	/*
	* Template Name: Members Directory
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
require("members/header-files.php");
require("parts/global-header.php");
date_default_timezone_set('Asia/Manila'); ?>

<style type="text/css">
	/* Member Directory Overrides */
	div.uimob800 .um-member {
		width: 250px;
		min-height: 250px;
	}
	.um-members-edit-btn,
	.um-members-follow-stats,
	.um-members-friend-stats,
	.um-members-follow-btn {
		display:none !important;
	}
	.um-member {
		border-radius: 5px;
		overflow: hidden;
		border: 1px solid #142c46;
		margin-bottom: 10px;
		background-color: #142c46;
	}
	.um-member-name a {
		font-size: 14px;
		line-height: 26px;
		color: #d8d8d8 !important;
		font-weight: 600;
	}
	.um-member-photo img {
		border: 3px solid #213f58;
		background: #213f58;
	}
	.arbpage_pagetitle {
		font-family: 'Montserrat', sans-serif;
		font-weight: 700;
		font-size: 17px;
		margin-bottom: 10px;
	}
	.um-member-cover {
		background: url(<?php echo get_home_url(); ?>/assets/img/arb_default_bg_2.jpg) 0 0 no-repeat #6583a8;
		background-size: cover;
	}
	.um-members a.um-friend-btn.um-button.um-alt,
	.um-members a.um-unfriend-btn.um-button.um-alt,
	.um-members a.um-unfriend-btn.um-button.um-alt.um-unfriend-btn2 {
		border-radius: 26px !important;
		border: 1.3px solid #6583a8 !important;
		font-family: 'Nunito', sans-serif;
		color: #6583a8 !important;
		padding: 7px 15px !important;
		line-height: 18px !important;
		background-color: transparent;
	}
</style>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

                        <?php //get_template_part('parts/sidebar', 'tasks'); ?>
                    	<?php get_template_part('parts/sidebar', 'profile'); ?>
						<?php //get_template_part('parts/sidebar', 'traders'); ?>

					</div>

				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                    		<h1 class="arbpage_pagetitle">Members</h1>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
							the_content();
						endwhile; else: ?>
						<p>Sorry, no posts matched your criteria.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
                	<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>
					<?php //get_template_part('parts/sidebar', 'watchlist'); ?>

					<?php //get_template_part('parts/sidebar', 'topplayers'); ?>
                    <?php //get_template_part('parts/sidebar', 'alert'); ?>
                    <div class="forsticky">
                    <?php // get_template_part('parts/sidebar', 'ads'); ?>

                    <?php get_template_part('parts/sidebar', 'footer'); ?>
                	</div>
				</div>

				<?php /*?><div class="banner-try">
					<div class="to-top-title">Sponsored <div class="to-top-create">Create ads</div>
						<hr class="style14 style15" style="width: 100% !important;margin-bottom: 9px !important;margin-top: 5px !important;">
                    </div>
                        <div class="cont-try-premium">
                        <img src="<?php echo get_home_url(); ?>/svg/try-primium.jpg">
                    </div>
				</div><?php */?>


                <br class="clear">
			</div>

		</div>
	</div>

</div>

 <!-- #main-content -->

<?php require("members/footer-files.php"); ?>
