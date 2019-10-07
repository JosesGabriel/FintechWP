<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header("dashboard"); ?>
<style>
html, .home body.et_cover_background {
    background-color: #354960 !important;
}
</style>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main" style="padding:10% 0">

			<header class="page-header">

				<!--<h1 class="page-title" style="color:#fff; text-align:center"><?php _e( 'Woops! Sorry...', 'arbitrage' ); ?></h1>-->
			</header>

			<div class="page-wrapper">
				<div class="page-content" style="text-align:center; color:#fff; background-color:#354960;">
					<a href="/"><img src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/images/Comp-2.gif" width="50%" style="mix-blend-mode: lighten;"></a>
					<!--<h3 style="color:#fff; font-weight:300;"><?php echo 'We&rsquo;re unable to locate the page you&rsquo;re trying to access.'; ?></h3>-->
				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer("dashboard"); ?>