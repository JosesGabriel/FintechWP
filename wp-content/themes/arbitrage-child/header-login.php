<?php
global $current_user;
$user = wp_get_current_user();
	elegant_description();
	elegant_keywords();
	elegant_canonical();

	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	do_action( 'et_head_meta' );

	$template_directory_uri = get_template_directory_uri();
	$homeurlgen = get_home_url();
?>
<!DOCTYPE html><!-- Bidvertiser2000920 -->
<html <?php language_attributes(); ?>><head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta property="og:title" content="Arbitrage | Free Stock Trading Platform" />
	<!-- <meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/uploads/2019/09/2f2a3a12-3a4bc05c-arbitrage-og-02.jpg" /> -->
	<meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/themes/arbitrage-child/images/ogimage_mage.png" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
	
	<?php // Countdown ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/css/demo.css">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/login_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style>
	<?php if (isset($_GET['b'])){ 
		$getrand = $_GET['b'];
		$get_bgfimage = "loginbg".$getrand.".jpg";?>
		html {background: url("<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>") 50% 0 no-repeat #2c3e50 fixed;background-size: cover;}
	<?php } ?>
    #status {
		width: 50px;
		height: 50px;
		position: absolute;
		left: 50%;
		top: 35%;
		background-image: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg);
		background-size:50px;
		background-repeat: no-repeat;
		background-position: center;
		margin: -25px 0 0 -25px;
	}
    </style>
	<link href="<?php echo $homeurlgen; ?>/assets/css/preloader.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> 
    <script language="javascript">
	
		jQuery(window).on('load', function(){
			jQuery("#status, #status_txt").fadeOut();
			jQuery("#preloader").delay(400).fadeOut("slow");
			jQuery(".um-field-checkbox-option").html("");
			jQuery(".forgotpass-wrapper .um-button").val("Reset password");
			// jQuery(".um-field-error").html("!");
		});
		jQuery(document).ready(function(){
			jQuery("#emailNotify__form").submit(function(){
				var hasemail = jQuery("#email--input").val().length;
				var email = jQuery("#email--input").val();
				if( hasemail >= 1 ) {
					jQuery.ajax({
						method: "POST",
						url: "https://arbitrage.ph/apipge/?daction=notify_me_email",
						// url: 'https://api2.pse.tools/api/quotes',
						data: {
							'email' : email
						},
						success: function(data) {
							jQuery("#email__text").show();
						},
						error: function(requestObject, error, errorThrown) {

						}
					});
				}
			});
		});
		
	</script>
    <?php /* Global Header Scritps */ //get_template_part('parts/global', 'scripts'); ?>
</head>
<body <?php body_class(); ?>>
	  <?php /* Responsive 2 */ //get_template_part('parts/global', 'responsivetwo'); ?>

<div class="form-success-email">
	<div class="success--content">
		<!-- <i class="far fa-check-circle"></i> -->
		<span class="success-word"> Thank you for signing up, talk to you soon!</span>
	</div>
</div>
<!-- Countdown -->
<!--
<div class="header contercontrol">
    <center><img class="header-image" src="<?php //echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png"></center>
</div>
<div class="title-header contercontrol">
       <center> COMING SOON</center>
</div>
<div class="countdown countdown-container container contercontrol">
    
    <div class="clock row" style="margin-top: 124px;">
        <div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-days" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-days type-time">DAYS</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clock-item clock-hours countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-hours" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-hours type-time">HOURS</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clock-item clock-minutes countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-minutes" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-minutes type-time">MINUTES</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clock-item clock-seconds countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-seconds" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-seconds type-time">SECONDS</p>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="notif-container row">

	
        <div class="notif--subb">
		<p style="text-align: center;color: #25ae5f;display:none;" id="email__text">Email successfully added!</p>
        	 <form method="post" id="emailNotify__form">
	            <input type="email" name="email" placeholder="Place your email here to be notified when we launch" class="email--field" id="email--input" required>
	            <input type="submit" name="send" value="Notify Me" class="email--btn arbitrage-button arbitrage-button--primary" id="email--button">
            </form>
        </div>
     
    </div>
</div>-->



<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/js/kinetic.js"></script>
<script type="text/javascript" src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/jquery.final-countdown.js"></script>
<script type="text/javascript">  
    $('document').ready(function() {
        'use strict';
       
        const timestamp = parseInt(Date.now()/1000);

    	$('.countdown').final_countdown({
            'start': 1565338684,
            'end': 1568595600,
            'now': timestamp     
        });
    });
</script>
	
	
	
<?php 
	if(isset($_GET['active'])){
		//   $all_meta_for_user = get_user_meta( $_GET['active'] );
		//   print_r( $all_meta_for_user );
	}
?>
<?php /* Global CSS Overrides  get_template_part('parts/global', 'css'); */ ?>
<div id="preloader">
    <div id="status">&nbsp;</div>
    <div id="status_txt"></div>
</div>
<?php
	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo $page_container_style; ?>>
<?php
	if ( $product_tour_enabled || is_page_template( 'page-template-blank.php' ) ) {
		return;
	}

	$et_secondary_nav_items = et_divi_get_top_nav_items();
	$et_phone_number = $et_secondary_nav_items->phone_number;
	$et_email = $et_secondary_nav_items->email;
	$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;
	$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;
	$et_secondary_nav = $et_secondary_nav_items->secondary_nav;
	$et_top_info_defined = $et_secondary_nav_items->top_info_defined;
	$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;
?>

	<?php if ( $et_top_info_defined && ! $et_slide_header || is_customize_preview() ) : ?>
		<?php ob_start(); ?>
		<div id="top-header"<?php echo $et_top_info_defined ? '' : 'style="display: none;"'; ?>>
			<div class="container clearfix">

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
				<?php endif; ?>

				<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>

				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div> <!-- #et-info -->

			<?php endif; // true === $et_contact_info_defined ?>

				<div id="et-secondary-menu">
				<?php
					if ( ! $et_contact_info_defined && true === $show_header_social_icons ) {
						get_template_part( 'includes/social_icons', 'header' );
					} else if ( $et_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="et_duplicate_social_icons">
								%1$s
							</div>',
							$duplicate_social_icons
						);
					}

					if ( '' !== $et_secondary_nav ) {
						echo $et_secondary_nav;
					}

					et_show_cart_total();
				?>
				</div> <!-- #et-secondary-menu -->

			</div> <!-- .container -->
		</div> <!-- #top-header -->
	<?php
		$top_header = ob_get_clean();

		/**
		 * Filters the HTML output for the top header.
		 *
		 * @since ??
		 *
		 * @param string $top_header
		 */
		echo apply_filters( 'et_html_top_header', $top_header );
	?>
	<?php endif; // true ==== $et_top_info_defined ?>

	<?php if ( $et_slide_header || is_customize_preview() ) : ?>
		<?php ob_start(); ?>
		<div class="et_slide_in_menu_container">
			<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) || is_customize_preview() ) { ?>
				<span class="mobile_menu_bar et_toggle_fullscreen_menu"></span>
			<?php } ?>

			<div class="et_pb_fullscreen_nav_container">
				<?php
					$slide_nav = '';
					$slide_menu_class = 'et_mobile_menu';

					$slide_nav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
					$slide_nav .= wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
				?>

				<ul id="mobile_menu_slide" class="<?php echo esc_attr( $slide_menu_class ); ?>">

				<?php
					if ( '' == $slide_nav ) :
				?>
						<?php if ( 'on' == et_get_option( 'divi_home_link' ) ) { ?>
							<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
						<?php }; ?>

						<?php show_page_menu( $slide_menu_class, false, false ); ?>
						<?php show_categories_menu( $slide_menu_class, false ); ?>
				<?php
					else :
						echo( $slide_nav );
					endif;
				?>

				</ul>
			</div>
		</div>
	<?php
		$slide_header = ob_get_clean();

		/**
		 * Filters the HTML output for the slide header.
		 *
		 * @since ??
		 *
		 * @param string $top_header
		 */
		echo apply_filters( 'et_html_slide_header', $slide_header );
	?>
	<?php endif; // true ==== $et_slide_header ?>

	<?php ob_start(); ?>
	
    <?php // get_template_part('parts/global', 'header'); ?>
    
	<?php
		$main_header = ob_get_clean();

		/**
		 * Filters the HTML output for the main header.
		 *
		 * @since ??
		 *
		 * @param string $main_header
		 */
		echo apply_filters( 'et_html_main_header', $main_header );
	?>
		<div id="et-main-area">
	<?php
		/**
		 * Fires after the header, before the main content is output.
		 *
		 * @since ??
		 */
		do_action( 'et_before_main_content' );
