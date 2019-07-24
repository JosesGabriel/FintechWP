<?php
$user = wp_get_current_user();
if ( is_user_logged_in() ) {
    // echo 'Welcome, registered user!';
} else {
    wp_redirect( 'https://arbitrage.ph/login/', 301 );
    exit;
}
$profile_id = um_profile_id();
$default_cover = UM()->options()->get( 'default_cover' );
um_fetch_user($profile_id);
$ismyprofile = ($user->id == $profile_id ? true : false);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> ng-app="arbitrage_wl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
	<link rel="manifest" href="/manifest.json">     
	<meta name="msapplication-TileColor" content="#142c46">
	<meta name="msapplication-TileImage" content="/assets/icons/launcher-icon-4x.png">
	<meta name="theme-color" content="#0d1f33">
	<!-- THIS IS WHERE JQUERY IS -->
	<script
	  src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
<?php
global $current_user;
$user = wp_get_current_user();
  if (!is_page(26)){ 
	  	$user_id = $user->ID;
		if(isset($_POST['check_user_share_input'])){
		  $sharecheck = $_POST['check_user_share_input'];
		  update_user_meta($user_id, 'check_user_share', $sharecheck);
		}
		$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
		$checkfbshare = get_user_meta( $user_id, "_um_sso_facebook_email", true );
		if(!$checksharing){
			if($checkfbshare){
				header('Location: https://arbitrage.ph/share/?'.rand(12345 ,89019));
				die(); 
			}else{
				header('Location: https://arbitrage.ph/verify/?'.rand(12345 ,89019));
				die();
			}
		}
		/* if($checksharing == "shared"){
		}elseif($checksharing == "verified"){
		}elseif(!$checksharing){
			if ($checkfbshare && !$checksharing){
				header('Location: https://arbitrage.ph/share/?'.rand(12345 ,89019));
				die();
			}else{
				header('Location: https://arbitrage.ph/verify/?'.rand(12345 ,89019));
				die();
			}
		} */
	  /*if(isset($_POST['check_user_share_input'])){
			$sharecheck = $_POST['check_user_share_input'];
			update_user_meta($user_id, 'check_user_share', $sharecheck);
	  }
	  $checksharing1 = get_user_meta( $user_id, "_um_sso_facebook_email", true );
	  $checksharing2 = get_user_meta( $user_id, "check_user_share", true );
	  if ($checksharing1 && !$checksharing2){
			echo '<script type="text/javascript">window.location.href = "https://arbitrage.ph/share/?'.rand(12345 ,89019).'";</script>';
	  }else{
		  	echo '<script type="text/javascript">window.location.href = "https://arbitrage.ph/verify/?'.rand(12345 ,89019).'";</script>';
	  }*/
  }
  if (isset($_GET['resetshare'])){
	    $user_id = $user->ID;
		update_user_meta($user_id, 'check_user_share', "");
		header('Location: https://arbitrage.ph/share/?'.rand(12345 ,89019));
		die();
  } 
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
	$cdnorlocal = get_home_url();
	$template_directory_uri = get_template_directory_uri();
?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="shortcut icon" href="https://arbitrage.ph/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" integrity="sha256-Qc3yyFhqacL9loe3ItFKo9WaSdTwZhpZRMYBvEpR2Cw=" crossorigin="anonymous" />
	<link href="https://arbitrage.ph/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
	<script type="text/javascript">
			$(".ms-ctn .ms-sel-ctn").append("<i class='fas fa-search'></i>");
	</script>
	<?php if (isset($_GET['arbitaction']) && $_GET['arbitaction'] == "editphoto"): ?>
	<script>
		jQuery(document).ready(function () {
			jQuery('.um-profile-photo .um-btn-auto-width').trigger('click');
			UM_hide_menus();
		})
	</script>
	<?php endif ?>
	<?php if (isset($_GET['arbitaction']) && $_GET['arbitaction'] == "editcover"): ?>
	<script>
		jQuery(document).ready(function () {
			jQuery('.um-cover .um-btn-auto-width').trigger('click');
			UM_hide_menus();
		})
	</script>
	<?php endif ?>
    <style type="text/css">
    	ul.main-drops > ul {
		    display: none;
		    position: absolute;
		    right:5px;
		    background: #2e3746;
		    min-width: 200px;
		    text-align: left;
		    margin-top: 9px;
		    border: 2px solid #506889;
		    border-radius: 5px;
		}
		ul.main-drops > ul li:hover {
		    background: #50678b;
		}
		ul.main-drops > ul li a:hover {
		    text-decoration: none !important;
		}
		ul.main-drops > ul li a {
		    color: #fff;
		    display: block;
		    font-size: 13px;
		}
		ul.main-drops > ul li {
		    padding: 5px 15px;
		}
		ul.main-drops {
		    display: inline-block;
		    vertical-align: top;
			position:relative;
		}
		ul.main-drops > ul:before {
		    bottom: 100%;
		    right: 2%;
		    border: solid transparent;
		    content: " ";
		    height: 0;
		    width: 0;
		    position: absolute;
		    pointer-events: none;
		    border-color: rgba(194, 225, 245, 0);
		    border-bottom-color: #4f6987;
		    border-width: 10px;
		    margin-left: -36px;
		}
		input.et_pb_searchsubmit {
		    display: none;
		}
		.minichartt .ng-scope {
			overflow:hidden;
		}
		.minichartt .stocklnk {
			position:absolute;
			width:100%;
			height:100%;
			top:0;
			left:0;
		}
		#page-container {
			/*padding-top:0 !important;*/
			height:100%;
		}
		.chatroomWindow,
		#et-main-area, .row,
		.cl-background cr-left {
			height:100%;
		}
		.page-id-1871 {
			overflow:hidden;
		}
	.um-activity-widget div.um-activity-textarea textarea, .um-activity-widget div.um-activity-textarea textarea:hover, .um-activity-widget div.um-activity-textarea textarea:focus {
		height: 90px !important;
		border-radius: 0 !important;
		padding: 18px 15px 10px 54px !important;
	}
	.um-activity-widget div.um-activity-textarea textarea {
		height:90px;
	}
	.um-activity-new-post .um-activity-body .um-activity-textarea {
		position:relative;
	}
	img.arb_newpostimg {
		width: 32px;
		height: auto;
		border-radius: 35px;
		position: absolute;
		top: 15px;
		left: 13px;
	}
	a.um-social-login-avatar-change {
		display: none !important;
	}	
	/* Bootstrap Overrides */
	dl, ol, ul {
		margin-bottom: 0;
	}
    </style>
	<?php if (is_page(array(739,1862,13,18)) || is_front_page()){ ?>
        <?php /*?><link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/minichart.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.min.js"></script>
        <script src="https://rawgit.com/krispo/angular-nvd3/v1.0.4/dist/angular-nvd3.js"></script><?php */?>
    <?php } ?>
    <script language="javascript">
		jQuery(document).ready(function(e) {
            jQuery(".add-post .um-activity-new-post .um-activity-textarea textarea").attr("placeholder", "Hey <?php echo ucfirst(um_user('first_name')); ?>, penny for your thoughts?");
			jQuery(".um-activity-new-post .um-activity-body .um-activity-textarea").append('<img class="arb_newpostimg" src="<?php 
			echo esc_url( get_avatar_url( $user->ID ) ); ?>" alt="<?php echo ucfirst(um_user('first_name')); ?>">')
			jQuery("#et-main-area").click(function(e){
				jQuery(".dropdown_tools, .dropdown_user").hide('slow');	
			});
        });
	</script>
    <?php /* Global Header Scritps */ get_template_part('parts/global', 'scripts'); ?>
</head>
<body <?php body_class(); ?>>
<?php /* Global CSS Overrides */ get_template_part('parts/global', 'css'); ?>
<?php /* Responsive 1 */ get_template_part('parts/global', 'responsive'); ?>
<?php /* Responsive 2 */ // get_template_part('parts/global', 'responsivetwo'); ?>
<?php
	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo $page_container_style; ?>>

<div class="slidecloseoverlay" id="slidecloseoverlay"></div>
<div class="left-slide-trigger" id="left-slide-trigger"></div>
<!--<div class="right-slide-trigger" id="right-slide-trigger"></div>-->
<div class="top-slide-trigger" id="top-slide-trigger"></div>
		
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
			<?php
				if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
					<div class="et_slide_menu_top">
					<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
						<div class="et_pb_top_menu_inner">
					<?php } ?>
			<?php }
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				}
				et_show_cart_total();
			?>
			<?php if ( false !== et_get_option( 'show_search_icon', true ) || is_customize_preview() ) : ?>
				<?php if ( 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) { ?>
					<div class="clear"></div>
				<?php } ?>
				<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
							esc_attr__( 'Search &hellip;', 'Divi' ),
							get_search_query()
						);
					?>
					<button type="submit" id="searchsubmit_header"></button>
				</form>
			<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>
			<?php if ( $et_contact_info_defined ) : ?>
				<div id="et-info">
				<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>
				</div> <!-- #et-info -->
			<?php endif; // true === $et_contact_info_defined ?>
			<?php if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
				<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
					</div> <!-- .et_pb_top_menu_inner -->
				<?php } ?>
				</div> <!-- .et_slide_menu_top -->
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
        <?php get_template_part('parts/global', 'header'); ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.um-activity-post').html('Post');
			});
		</script>
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
	?>
	<script data-obct type="text/javascript">
	  /** DO NOT MODIFY THIS CODE**/
	  !function(_window, _document) {
	    var OB_ADV_ID='00dd522c52b0f61db8089b1a2293a364e0';
	    if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}
	    var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);
	obApi('track', 'PAGE_VIEW');
	</script>
