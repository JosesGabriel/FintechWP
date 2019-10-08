<?php
	/*
	* Template Name: Users Page
	* Template page for Dashboard Social Platform
	*/


global $current_user;
global $wpdb;
$user = wp_get_current_user();
require("userwall/header-files.php");
require("parts/global-header.php");
$profile_id = um_profile_id();
$default_cover = UM()->options()->get( 'default_cover' );
um_fetch_user($profile_id);
$myusersecret = get_user_meta($profile_id, 'user_secret', true);
$ismyprofile = ($user->ID == $profile_id ? true : false);
?>
<?php if (isset($_GET['um_action']) && $_GET['um_action'] == "edit"){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/userwall/userwall-edit-style.css">
	<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.um-faicon-user').html('<img src="/svg/account.svg" style="width: 20px;">');
            jQuery('.um-faicon-user').removeClass('um-faicon-user');
            jQuery('.um-faicon-asterisk').html('<img src="/svg/user-key-account3.svg" style="width: 19px;">');
            jQuery('.um-faicon-asterisk').removeClass('um-faicon-asterisk');
            jQuery('.um-faicon-credit-card').html('<img src="/svg/real-estate2.svg" style="width: 20px;">');
            jQuery('.um-faicon-credit-card').removeClass('um-faicon-credit-card');
            jQuery('.um-faicon-shopping-cart').html('<img src="/svg/shopping-cart1.svg" style="width: 20px;">');
            jQuery('.um-faicon-shopping-cart').removeClass('um-faicon-shopping-cart');
            jQuery('.um-faicon-download').html('<img src="/svg/download.svg" style="width: 20px;">');
            jQuery('.um-faicon-download').removeClass('um-faicon-download');
            jQuery('.um-faicon-lock').html('<img src="/svg/shield1.svg" style="width: 21px;">');
            jQuery('.um-faicon-lock').removeClass('um-faicon-lock');
            jQuery('.um-faicon-envelope').html('<img src="/svg/bell2.svg" style="width: 21px;">');
            jQuery('.um-faicon-envelope').removeClass('um-faicon-envelope');
            jQuery('.um-faicon-bell').html('<img src="/svg/bel-not4.svg" style="width: 21px;">');
            jQuery('.um-faicon-bell').removeClass('um-faicon-bell');
            jQuery('.um-faicon-sign-in').html('<img src="/svg/link1.svg" style="width: 20px;">');
            jQuery('.um-faicon-sign-in').removeClass('um-faicon-sign-in');
            jQuery('.um-faicon-image').html('<img src="/svg/photo1.svg" style="width: 20px;">');
            jQuery('.um-faicon-image').removeClass('um-faicon-image');
            jQuery('.um-faicon-trash-o').html('<img src="/svg/garbage1.svg" style="width: 20px;">');
            jQuery('.um-faicon-trash-o').removeClass('um-faicon-trash-o');
            jQuery(".um-field-nickname").find(".um-field-label label").text('Trading Name');
        });
    </script>
<?php } ?>
<?php
    if(!$ismyprofile && isset($_GET['profiletab']) && isset($_GET['um_action'])){
        wp_redirect( "/user/".um_user('user_login') );
        exit;
    }
?>
<div id="main-content" class="ondashboardpage id<?php echo $profile_id; ?> <?php echo $ismyprofile; ?>">
	<div class="container">
	<div class="the_user_top_page">
		<div class="um um-profile <?php echo (isset($_GET['um_action']) && $_GET['um_action'] == 'edit' ? 'um-editing' : 'um-viewing'); ?> um-11 um-role-administrator uimob800 topbannerprofile">
			<div class="um-form">
				<div class="um-cover <?php echo (isset($_GET['um_action']) && $_GET['um_action'] == 'edit' ? 'has-cover' : ''); ?>" data-user_id="<?php echo $profile_id; ?>" data-ratio="2.7:1" style="height: 320px;">
			<?php
			$default_cover = UM()->options()->get( 'default_cover' );
			$overlay = '<span class="um-cover-overlay">
					<span class="um-cover-overlay-s">
						<ins>
							<i class="um-faicon-picture-o"></i>
							<span class="um-cover-overlay-t">' . __( 'Change your cover photo', 'ultimate-member' ) . '</span>
						</ins>
					</span>
				</span>';
			do_action( 'um_cover_area_content', um_profile_id() );
			if ( UM()->fields()->editing ) {
				$hide_remove = um_profile( 'cover_photo' ) ? false : ' style="display:none;"';
				$items = array(
					'<a href="#" class="um-manual-trigger" data-parent=".um-cover" data-child=".um-btn-auto-width">' . __( 'Change cover photo', 'ultimate-member' ) . '</a>',
					'<a href="#" class="um-reset-cover-photo" data-user_id="' . um_profile_id() . '" ' . $hide_remove . '>' . __( 'Remove', 'ultimate-member' ) . '</a>',
					'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
				);
				UM()->profile()->new_ui( 'bc', 'div.um-cover', 'click', $items );
			}
			UM()->fields()->add_hidden_field( 'cover_photo' );
			echo $overlay; ?>
			<div class="um-cover-e" data-ratio="<?php echo $args['cover_ratio']; ?>">
				<?php if (um_profile( 'cover_photo' )) { ?>
					<?php
					if (UM()->mobile()->isMobile()) {
						if (UM()->mobile()->isTablet()) {
							echo um_user( 'cover_photo', 1000 );
						} else {
							echo um_user( 'cover_photo', 300 );
						}
					} else {
						echo um_user( 'cover_photo', 1000 );
					}
					?>
				<?php } else if ($default_cover && $default_cover['url']) {
					$default_cover = $default_cover['url'];
					echo '<img src="' . $default_cover . '" alt="" />';
				} else {
                    if ($user->ID != $profile_id) {
                        ?>
                        <div style="height:320px"></div>
                        <?php
                    }
					else if (!isset( UM()->user()->cannot_edit )) { ?>
						<a href="#" class="um-cover-add um-manual-trigger" data-parent=".um-cover"
						   data-child=".um-btn-auto-width"><span class="um-cover-add-i"><i
									class="um-icon-plus um-tip-n"
									title="<?php _e( 'Upload a cover photo', 'ultimate-member' ); ?>"></i></span></a>
					<?php }
				} ?>
			</div>
				</div>
				<div class="top-header-gear">
					<div class="top-header-inner">
					</div>
					<div class="profile-name">
						<div class="prof-name-inner">
							<?php
								$unametype = get_user_meta($profile_id, 'disname', true);
								$nickname = get_user_meta($profile_id, 'nickname', true);
							?>
							<?php echo um_user('full_name'); ?>

						</div>
					</div>
				</div>
				<div class="um-header-outer">
					<div class="um-header">
						<?php
						$default_size = str_replace( 'px', '', $args['photosize'] );
						$overlay = '<span class="um-profile-photo-overlay">
								<span class="um-profile-photo-overlay-s">
									<ins>
										<i class="um-faicon-camera"></i>
									</ins>
								</span>
							</span>';
						do_action( 'um_pre_header_editprofile', $args ); ?>
						<div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">
							<a class="um-profile-photo-img"
							   title="<?php echo um_user( 'display_name' ); ?>"><?php echo $overlay . get_avatar( um_user( 'ID' ), $default_size ); ?></a>
							<?php
                           if (!isset( UM()->user()->cannot_edit ) && $user->ID == $profile_id) {
								UM()->fields()->add_hidden_field( 'profile_photo' );
								if (!um_profile( 'profile_photo' )) { // has profile photo
									$items = array(
										'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Upload photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
									);
									$items = apply_filters( 'um_user_photo_menu_view', $items );
									echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
								} else if (UM()->fields()->editing == true) {
									$items = array(
										'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">' . __( 'Change photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-reset-profile-photo" data-user_id="' . um_profile_id() . '" data-default_src="' . um_get_default_avatar_uri() . '">' . __( 'Remove photo', 'ultimate-member' ) . '</a>',
										'<a href="#" class="um-dropdown-hide">' . __( 'Cancel', 'ultimate-member' ) . '</a>',
									);
									$items = apply_filters( 'um_user_photo_menu_edit', $items );
									echo UM()->profile()->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
								}
							}
							?>
						</div>
						<div class="dmetadetails">
							<div class="meta-details-inner">
								<ul>
									<li>
										<div class="oncount"><a class="profile_peers_count"><span class="um-ajax-count-friends">0</span></a></div>
										<div class="onlabel"><a href="/user/<?php echo um_user('user_login') ?>/?getdpage=friends">Peers</a></div>
									</li>
									<li>
										<div class="oncount"><a class="profile_post_count">0</a></div>
										<div class="onlabel"><a href="/user/<?php echo um_user('user_login') ?>/?getdpage=activity">Posts</a></div>
									</li>
								</ul>
							</div>
						</div>
						<div class="profile-meta-data">
							<div class="profile-meta-inner">
								<br class="clear">
							</div>
						</div>
						<div class="dnavtopleft">
							<div class="dnavtopinner">
								<ul>
									<?php if(!$ismyprofile): ?>
										<?php echo $ismyprofile; ?>
										<li>
											<?php echo UM()->Friends_API()->api()->friend_button( $profile_id, get_current_user_id() ); ?>
										</li>
									<?php else: ?>
											<?php if (isset($_GET['um_action']) && $_GET['um_action'] == 'edit'): ?>
											<?php else: ?>
												<li>
													<a href="/user/<?php echo um_user('user_login') ?>/?profiletab=main&amp;um_action=edit" class=" um-button um-alt" >Edit Profile</a>
												</li>
											<?php endif ?>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <?php
    require("parts/sidebar-calc.php");
    require("parts/sidebar-varcalc.php");
    require("parts/sidebar-avarageprice.php");
    ?>

	<div class="inner-placeholder">
		<div class="inner-main-content userprofilepage">
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
                        <?php require("parts/sidebar-profile.php"); ?>
					</div>
				</div>
			</div>
<?php 
	if($_GET['um_action'] == 'edit'){
		?>
		<div class="center-dashboard-part" style="max-width: 900px;">
		<?php
	}
	else{ 
		?>
		<div class="center-dashboard-part">
		<?php
	}

?>
				<div class="inner-center-dashboard">
					<div class="add-post">
					<?php
						if (isset($_GET['getdpage']) && $_GET['getdpage'] == 'friends'):
							?>
							<div class="dpostlet" style="margin-top: 11px;">
								<div class="header-port" style="background: #142c46;">Peers</div>
								<div class="body-port">
									<div class="friends-list-profile"><?php echo do_shortcode('[ultimatemember_friends user_id='.$profile_id.']'); ?></div>
								</div>
							</div>
							<?php
						elseif (isset($_GET['getdpage']) && $_GET['getdpage'] == 'messages'):
							?>
								<div class="open-messages">
									<div class="messages-inner">
										<div class="message-header">Messages</div>
										<div class="message-body">
											<?php echo do_shortcode('[ultimatemember_messages]'); ?>
										</div>
									</div>
								</div>
							<?php
						elseif(isset($_GET['getdpage']) && $_GET['getdpage'] == 'activity'):
							?>
								<div class="profile-post-content">
									<?php echo do_shortcode('[ultimatemember_wall user_id="'.$profile_id.'" user_wall="true" ]'); ?>
								</div>
							<?php
						else:
							?>            
							<?php if (isset($_GET['um_action']) && $_GET['um_action'] == "edit"){ ?>
								<div class="profile-post-content">
									<?php echo do_shortcode('[ultimatemember_account]'); ?>
								</div>
                            <?php }else{ ?>
								<div class="profile-post-content">
									<?php echo do_shortcode('[ultimatemember_wall user_id="'.$profile_id.'" user_wall="true" ]'); ?>
								</div>
                             <?php } ?>
                                
							<?php
						endif;
					?>
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">
					
					<div class="container-sticky">
                    <?php
                    require("parts/sidebar-watchlist.php");
                    //require("watchlist/sidebar-watchlist.php");
                    require("parts/sidebar-footer.php");
					?>
					</div>

				</div>
                
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php
require("userwall/footer-files.php");

?>
