<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<!-- <footer id="main-footer">
				<div class="on-footer-inner">
					<div class="on-footer-left">
						<div class="on-foot-left-inner">
							<?php
								// wp_nav_menu( array( 'menu' => 'footer-left', 'container_class' => 'custom-menu-class' ) ); 
							?>
						</div>
					</div>
					<div class="on-footer-middle">
						<div class="on-footer-mid-inner">
							<img src="https://arbitrage.ph/wp-content/uploads/2018/12/logo.png">
						</div>
					</div>
					<div class="on-footer-right">
						<div class="on-foot-right-inner">
							<?php
								// wp_nav_menu( array( 'menu' => 'footer-right', 'container_class' => 'custom-menu-class' ) ); 
							?>
						</div>
					</div>
					<br class="clear">
				</div>
			</footer>  -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>
	<div style="display: none;">
		<a id="entry_price">&nbsp;</a>
		<a id="take_profit_point">&nbsp;</a>
		<a id="stop_loss_point">&nbsp;</a>
	</div>
	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js" integrity="sha256-BfIfo/K+ePw1iAn4BFfrfVXmXQPAmKtqeDwVIgCFqTU=" crossorigin="anonymous"></script>
	

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/admin-user.js"></script>
    <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
    <script type="text/javascript">
    	(function($) {
		    jQuery(document).ready(function() {
		    	jQuery(".header-dashboard .user-image").click(function(e){
					e.preventDefault();
					var isopen = jQuery("ul.main-drop > ul").hasClass("dropopen");

					if (isopen) {
						jQuery("ul.main-drop > ul").hide('slow').removeClass("dropopen");
					} else {
						jQuery("ul.main-drop > ul").show('slow').addClass("dropopen");
					}
					
				});

		    });
		})(jQuery);
    	
    </script>
    <script type="text/javascript">
	window.onload = function() {

		// var chart = new CanvasJS.Chart("chartContainer", {
		// 	animationEnabled: true,
		// 	title: {
		// 		text: "Desktop Search Engine Market Share - 2016"
		// 	},
		// 	data: [{
		// 		type: "pie",
		// 		startAngle: 240,
		// 		yValueFormatString: "##0.00\"%\"",
		// 		indexLabel: "{label} {y}",
		// 		dataPoints: [
		// 			{y: 79.45, label: "Google"},
		// 			{y: 7.31, label: "Bing"},
		// 			{y: 7.06, label: "Baidu"},
		// 			{y: 4.91, label: "Yahoo"},
		// 			{y: 1.26, label: "Others"}
		// 		]
		// 	}]
		// });
		// chart.render();

	}
</script>

</body>
</html>
