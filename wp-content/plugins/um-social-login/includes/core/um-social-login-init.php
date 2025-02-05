<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class UM_Social_Login_API
 */
class UM_Social_Login_API {


	/**
	 * @var
	 */
	private static $instance;


	/**
	 * @var
	 */
	var $networks;


	/**
	 * @return UM_Social_Login_API
	 */
	static public function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * UM_Social_Login_API constructor.
	 */
	function __construct() {
		// Global for backwards compatibility.
		$GLOBALS['um_social_login'] = $this;

		add_filter( 'um_call_object_Social_Login_API', array( &$this, 'get_this' ) );

		$this->init_networks();

		$this->show_overlay = false;

		$this->shortcode_id = false;

		$this->ajax();

		$this->admin();

		$this->enqueue();

		$this->shortcode();

		add_action( 'plugins_loaded', array(&$this, 'init'), 0);

		add_action( 'template_redirect', array( &$this, 'disconnect' ), 1 );

		add_action('wp_footer', array(&$this, 'show_registration'), 9999 );

		add_filter('query_vars', array(&$this, 'query_vars'), 10, 1 );

		add_action('init', array(&$this, 'redirect_authentication' ), 1 );

		add_action('init',  array(&$this, 'create_taxonomies'), 2);

		add_filter( 'um_settings_default_values', array( &$this, 'default_settings' ), 10, 1 );

		add_action( 'um_mycred_load_hooks', array( &$this, 'um_mycred_social_login_hooks' ) );

		add_action( 'wp_logout', array( &$this, 'um_clear_session_after_logout' ) );

		add_action( 'wp_ajax_um_social_login_change_photo', array( $this->ajax(), 'ajax_change_photo' ) );

		add_filter( 'um_custom_error_message_handler', array( &$this, 'error_message_handler' ), 10, 2 );
	}


	/**
	 * @param $action
	 */
	function um_mycred_social_login_hooks( $action ) {
		require_once um_social_login_path . 'includes/core/hooks/um-mycred-social-login.php';
	}


	/**
	 *
	 */
	function init_networks() {
		$this->networks['facebook'] = array(
			'name' => __('Facebook','um-social-login'),
			'button' => __('Connect with Facebook','um-social-login'),
			'color' => '#fff',
			'bg' => '#4267B2',
			'bg_hover' => '#365899',
			'icon' => 'um-faicon-facebook-square',
			'opts' => array(
				'facebook_app_id' => __('App ID','um-social-login'),
				'facebook_app_secret' => __('App Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'facebook_handle',
				'link' => 'facebook_link',
				'photo_url' => 'http://graph.facebook.com/{id}/picture?type=square',
			),
		);

		$this->networks['twitter'] = array(
			'name' => __('Twitter','um-social-login'),
			'button' => __('Sign in with Twitter','um-social-login'),
			'color' => '#fff',
			'bg' => '#55acee',
			'bg_hover' => '#4997D2',
			'icon' => 'um-faicon-twitter',
			'opts' => array(
				'twitter_consumer_key' => __('Consumer Key','um-social-login'),
				'twitter_consumer_secret' => __('Consumer Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'twitter_handle',
				'link' => 'twitter_link',
				'photo_url_dyn' => 'twitter_photo_url_dyn',
			),
		);

		$this->networks['google'] = array(
			'name' => __('Google','um-social-login'),
			'button' => __('Sign in with Google','um-social-login'),
			'color' => '#fff',
			'bg' => '#4285f4',
			'bg_hover' => '#3574de',
			'icon' => 'um-faicon-google',
			'opts' => array(
				'google_client_id' => __('Client ID','um-social-login'),
				'google_client_secret' => __('Client secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'google_handle',
				'link' => 'google_link',
				'photo_url_dyn' => 'google_photo_url_dyn',
			),
		);

		$this->networks['linkedin'] = array(
			'name' => __('LinkedIn','um-social-login'),
			'button' => __('Sign in with LinkedIn','um-social-login'),
			'color' => '#fff',
			'bg' => '#0976b4',
			'bg_hover' => '#07659B',
			'icon' => 'um-faicon-linkedin',
			'opts' => array(
				'linkedin_api_key' => __('API Key','um-social-login'),
				'linkedin_api_secret' => __('API Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'linkedin_handle',
				'link' => 'linkedin_link',
				'photo_url_dyn' => 'linkedin_photo_url_dyn',
			),
		);

		$this->networks['instagram'] = array(
			'name' => __('Instagram','um-social-login'),
			'button' => __('Sign in with Instagram','um-social-login'),
			'color' => '#fff',
			'bg' => '#3f729b',
			'bg_hover' => '#4480aa',
			'icon' => 'um-faicon-instagram',
			'opts' => array(
				'instagram_client_id' => __('Client ID','um-social-login'),
				'instagram_client_secret' => __('Client Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'instagram_handle',
				'link' => 'instagram_link',
				'photo_url_dyn' => 'instagram_photo_url_dyn',
			),
		);

		$this->networks['vk'] = array(
			'name' => __('VK','um-social-login'),
			'button' => __('Sign in with VK','um-social-login'),
			'color' => '#fff',
			'bg' => '#45668e',
			'bg_hover' => '#395f8e',
			'icon' => 'um-faicon-vk',
			'opts' => array(
				'vk_api_key' => __('API Key','um-social-login'),
				'vk_api_secret' => __('API Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'vk_handle',
				'link' => 'vk_link',
				'photo_url_dyn' => 'vk_photo_url_dyn',
			),
		);

		$this->networks = apply_filters('um_social_login_networks', $this->networks);
	}


	/**
	 * @param $defaults
	 *
	 * @return array
	 */
	function default_settings( $defaults ) {
		$defaults = array_merge( $defaults, $this->setup()->settings_defaults );
		return $defaults;
	}


	/**
	 * Create a post type
	 */
	function create_taxonomies() {

		register_post_type( 'um_social_login', array(
				'labels' => array(
					'name' => __( 'Social Login Shortcodes' ),
					'singular_name' => __( 'Social Login Shortcode' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __('Add New Social Login Shortcode' ),
					'edit_item' => __('Edit'),
					'not_found' => __('You did not create any social login shortcodes yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search social login shortcodes')
				),
				'show_ui' => true,
				'show_in_menu' => false,
				'public' => false,
				'supports' => array('title'),
				'capability_type' => 'page'
			)
		);

	}


	/**
	 * @return $this
	 */
	function get_this() {
		return $this;
	}


	/**
	 * @return um_ext\um_social_login\core\Social_Login_Setup()
	 */
	function setup() {
		if ( empty( UM()->classes['um_social_login_setup'] ) ) {
			UM()->classes['um_social_login_setup'] = new um_ext\um_social_login\core\Social_Login_Setup();
		}
		return UM()->classes['um_social_login_setup'];
	}


	/**
	 * @return um_ext\um_social_login\core\Social_Login_Admin()
	 */
	function admin() {
		if ( empty( UM()->classes['um_social_login_admin'] ) ) {
			UM()->classes['um_social_login_admin'] = new um_ext\um_social_login\core\Social_Login_Admin();
		}
		return UM()->classes['um_social_login_admin'];
	}


	/**
	 * @return um_ext\um_social_login\core\Social_Login_Enqueue()
	 */
	function enqueue() {
		if ( empty( UM()->classes['um_social_login_enqueue'] ) ) {
			UM()->classes['um_social_login_enqueue'] = new um_ext\um_social_login\core\Social_Login_Enqueue();
		}
		return UM()->classes['um_social_login_enqueue'];
	}


	/**
	 * @return um_ext\um_social_login\core\Social_Login_Shortcode()
	 */
	function shortcode() {
		if ( empty( UM()->classes['um_social_login_shortcode'] ) ) {
			UM()->classes['um_social_login_shortcode'] = new um_ext\um_social_login\core\Social_Login_Shortcode();
		}
		return UM()->classes['um_social_login_shortcode'];
	}


	/**
	 * @return um_ext\um_social_login\core\Social_Login_Ajax()
	 */
	function ajax() {
		if ( empty( UM()->classes['um_social_login_ajax'] ) ) {
			UM()->classes['um_social_login_ajax'] = new um_ext\um_social_login\core\Social_Login_Ajax();
		}
		return UM()->classes['um_social_login_ajax'];
	}


	/**
	 * URL for disconnecting from a provider
	 *
	 * @param $provider
	 *
	 * @return string|void
	 */
	function disconnect_url( $provider ) {
		$url = UM()->permalinks()->get_current_url( get_option( 'permalink_structure' ) );

		$url = add_query_arg( array( 'disconnect' => $provider, 'uid' => um_user( 'ID' ) ), $url );
		return $url;
	}


	/**
	 * Get user photo
	 *
	 * @param $user_id
	 * @param $provider
	 *
	 * @return bool|mixed
	 */
	function get_user_photo( $user_id, $provider ) {
		$providers = $this->networks;
		$url = false;
		if ( isset( $providers[$provider]['sync']['photo_url'] ) ) {
			$url = $providers[$provider]['sync']['photo_url'];
			$url = str_replace('{id}', get_user_meta( $user_id, '_uid_'.$provider, true ), $url );
			if ( is_ssl() ) {
				$url = str_replace('http://','https://', $url );
			}
		}
		return $url;
	}


	/**
	 * Get dynamic user photo
	 *
	 * @param $user_id
	 * @param $provider
	 *
	 * @return bool|mixed|string
	 */
	function get_dynamic_user_photo( $user_id, $provider ) {
		$providers = $this->networks;
		$url = false;
		if ( isset( $providers[$provider]['sync']['photo_url_dyn'] ) ) {
			$url = um_user( $providers[$provider]['sync']['photo_url_dyn'] );
			if ( is_ssl() ) {
				$url = str_replace('http://','https://', $url );
			}
		}
		return $url;
	}


	/**
	 * Disconnects a user from network
	 */
	function disconnect() {
		if ( empty( $_REQUEST['disconnect'] ) ) {
			return;
		}

		if ( get_current_user_id() != $_REQUEST['uid'] ) {
			wp_die( __( 'Ehh! hacking?', 'um-social-login' ) );
		}

		$provider = $_REQUEST['disconnect'];

		$networks = $this->networks;
		foreach ( $networks[ $provider ]['sync'] as $k => $v ) {
			delete_user_meta( $_REQUEST['uid'], $k );
		}

		delete_user_meta( $_REQUEST['uid'], '_uid_'. $provider );

		do_action( "um_social_login_after_disconnect", $provider, $_REQUEST['uid'] );
		do_action( "um_social_login_after_{$provider}_disconnect", $_REQUEST['uid'] );

		exit( wp_redirect( UM()->account()->tab_link( 'social' ) ) );
	}


	/**
	 * Init
	 */
	function init() {

		if ( function_exists( 'session_status' ) ) {
			if ( session_status() == PHP_SESSION_NONE ) {
				session_start();
			}
		} else {
			if( ! session_id() ) {
				session_start();
			}
		}

		//++ Providers
		// Facebook
		require_once um_social_login_path . 'includes/libs/facebook/um-social-login-facebook.php';
		// Twitter
		require_once um_social_login_path . 'includes/libs/twitter/um-social-login-twitter.php';
		// Google
		require_once um_social_login_path . 'includes/libs/google/um-social-login-google.php';
		// LinkedIn
		require_once um_social_login_path . 'includes/libs/linkedin/um-social-login-linkedin.php';
		// Instagram
		require_once um_social_login_path . 'includes/libs/instagram/um-social-login-instagram.php';
		// VKontakte
		require_once um_social_login_path . 'includes/libs/vk/um-social-login-vk.php';

		$this->facebook = new UM_Social_Login_Facebook();
		$this->twitter = new UM_Social_Login_Twitter();
		$this->google = new UM_Social_Login_Google();
		$this->linkedin = new UM_Social_Login_LinkedIn();
		$this->instagram = new UM_Social_Login_Instagram();
		$this->vk = new UM_Social_Login_VK();

		// Actions
		require_once um_social_login_path . 'includes/core/actions/um-social-login-form.php';
		require_once um_social_login_path . 'includes/core/actions/um-social-login-admin.php';

		// Filters
		require_once um_social_login_path . 'includes/core/filters/um-social-login-settings.php';
		require_once um_social_login_path . 'includes/core/filters/um-social-login-account.php';
		require_once um_social_login_path . 'includes/core/filters/um-social-login-profile.php';
	}


	/**
	 * Available networks
	 *
	 * @return mixed
	 */
	function available_networks() {
		$networks = $this->networks;
		foreach ( $networks as $id => $arr ) {
			if ( ! UM()->options()->get( 'enable_' . $id ) ) {
				unset( $networks[ $id ] );
			}
		}
		$this->networks = $networks;
		return $this->networks;
	}


	/**
	 * Number of connected users
	 *
	 * @param $id
	 *
	 * @return int
	 */
	function count_users( $id ) {
		$args = array( 'fields' => 'ID', 'number' => 0 );
		$args['meta_query'][] = array(array( 'key' => '_uid_' . $id, 'value' => '','compare' => '!='));
		$users = new WP_User_Query( $args );
		return count($users->results);
	}


	/**
	 * Get the complete registration path
	 *
	 * @return string
	 */
	function get_registration_uri() {
		return trailingslashit( get_bloginfo('url') );
	}


	/**
	 * Get login url
	 *
	 * @param $id
	 *
	 * @return mixed|string|void
	 */
	function login_url( $id ) {
		$login_url = '';
		$login_url = apply_filters("um_social_login_get_authorize_link_{$id}", $login_url );
		if ( !$login_url ) {
			$login_url = $this->{$id}->login_url();
		}
		return $login_url;
	}


	/**
	 * Resume registration
	 *
	 * @param	array		$profile
	 * @param	string	$provider	
	 */
	function resume_registration( $profile, $provider ) {
		$this->profile = $profile;
		$_SESSION['um_social_profile'] = $profile;
		
		/**
		 * UM hook
		 * Before complete registration
		 * @param	UM_Social_Login_API	$this
		 * @param	array								$profile
		 * @param	string							$provider	
		 */
		do_action( 'um_social_login_resume_registration', $this, $profile, $provider );

		if ( is_user_logged_in() ) {
			$this->login( $profile, $provider, 1 );
		}

		$this->login( $profile, $provider );
	}


	/**
	 * This has to be done after resume registration call
	 *
	 * @param $profile
	 * @param $provider
	 * @param int $logged_in
	 */
	function login( $profile, $provider, $logged_in = 0 ) {
		// logged-in user
		if ( $logged_in ) { // Account Social connection


			$connected = $this->is_previously_connected( $profile, $provider );

			if ( $connected ) {

				um_fetch_user( $connected );

				$r = UM()->account()->tab_link('social');

				if ( $connected != get_current_user_id() ) {
					$r = add_query_arg( 'err', $provider . '_exist', $r );
				}

				$this->check_user_status( get_current_user_id() );

				exit( wp_redirect( $r ) );

			} else {

				um_fetch_user( get_current_user_id() );

				$this->check_user_status( get_current_user_id() );

				$this->connect( $profile, $provider );

				exit( wp_redirect( UM()->account()->tab_link('social') ) );

			}

		// guest
		} else {

			$connected = $this->is_previously_connected( $profile, $provider );

			if ( $connected ) {

				um_fetch_user( $connected );

				$redirect_to = '';

				$after = um_user( 'after_login' );
				switch( $after ) {

					case 'redirect_admin':
						$redirect_to = admin_url();
						break;

					case 'redirect_profile':
						$redirect_to = um_user_profile_url();
						break;

					case 'redirect_url':
						$redirect_to = um_user('login_redirect_url');
						break;

					case 'refresh':

						if( ! isset( $_REQUEST['redirect_to'] )  || empty( $_REQUEST['redirect_to'] ) ){

							$redirect = $this->redirect();

							if( $redirect['has_redirect'] == true  || $redirect['is_shortcode'] == 1 ){
								$redirect_to = $redirect['redirect_to'];
							}

						}else{
							$redirect_to = $_SERVER['HTTP_REFERER'];
						}

						if( ! isset( $redirect_to ) || empty( $redirect_to ) ){
								$redirect_to = um_get_core_page('login');
						}

						unset( $_SESSION['um_social_login_redirect'] );
					  unset( $_SESSION['um_social_is_shortcode'] );

						break;
				}

				$this->check_user_status( $connected );

				if( function_exists('um_keep_signed_in') ) {
					if( um_keep_signed_in() ){
						$_REQUEST['rememberme'] = 1;
					}
				}

				do_action( 'um_user_login', $args = array( 'rememberme' => true, 'redirect_to' => $redirect_to ) );

			} elseif ( $user_id = $this->user_exists( $profile, $provider ) ) {

				um_fetch_user( $user_id );
				$this->connect( $profile, $provider, $user_id );

				$after = um_user('after_login');
				switch( $after ) {

					case 'redirect_admin':
						$redirect_to = admin_url();
						break;

					case 'redirect_profile':
						$redirect_to = um_user_profile_url();
						break;

					case 'redirect_url':
						$redirect_to = um_user('login_redirect_url');
						break;

					case 'refresh':

						if( ! isset( $_REQUEST['redirect_to'] )  || empty( $_REQUEST['redirect_to'] ) ){

							$redirect = $this->redirect();

							if( $redirect['has_redirect'] == true  || $redirect['is_shortcode'] == 1 ){
								$redirect_to = $redirect['redirect_to'];
							}
						}else{
							$redirect_to = $_SERVER['HTTP_REFERER'];
						}

						if( ! isset( $redirect_to ) || empty( $redirect_to ) ){
							$redirect_to = um_get_core_page('login');
						}

						unset( $_SESSION['um_social_login_redirect'] );
					  unset( $_SESSION['um_social_is_shortcode'] );

						break;
				}

				$this->check_user_status( $user_id );

				if( function_exists('um_keep_signed_in') ){
					if( um_keep_signed_in() ){
						$_REQUEST['rememberme'] = 1;
					}
				}

				do_action( 'um_user_login', $args = array( 'rememberme' => true, 'redirect_to' => $redirect_to ) );


			} else {

				remove_action('um_after_register_fields', 'um_add_submit_button_to_register', 1000);

				add_action('um_after_register_fields', array(&$this, 'show_submit_button'), 1000);

				add_action('um_after_form_fields', array(&$this, 'show_hidden_inputs'), 1000);

				$this->show_overlay = true;

			}

		}


	}


	/**
	 * @return array
	 */
	public function redirect() {
		if ( isset( $_SESSION['um_social_login_redirect'] ) ) {

			$redirect_to = $_SESSION['um_social_login_redirect'];
			$is_shortcode = $_SESSION['um_social_is_shortcode'];

			unset( $_SESSION['um_social_login_redirect'] );
			unset( $_SESSION['um_social_is_shortcode'] );

			return array( 'has_redirect' => true, 'redirect_to' => $redirect_to, 'is_shortcode' => $is_shortcode );
		}

		return array( 'has_redirect' => false, 'redirect_to' => '', 'is_shortcode' => false );
	}


	/**
	 * Check users status
	 * @param  integer $user_id
	 */
	public function check_user_status( $user_id ) {
		um_fetch_user( $user_id );

		$status = um_user( 'account_status' );
		switch( $status ) {

			// If user can't login to site...
			case 'inactive':
			case 'awaiting_admin_review':
			case 'awaiting_email_confirmation':
			case 'rejected':
			case 'checkmail':

				$checkmail_url = um_user( 'checkmail_url' );
				$checkmail_action = um_user( 'checkmail_action' );

				if ( is_user_logged_in() ) {
					wp_logout();
				}

				if ( ! empty( $checkmail_url ) && $checkmail_action == 'redirect_url' ) {
					wp_redirect( $checkmail_url );
				}

				um_reset_user();
				$error = get_query_var( 'err' );

				if ( empty( $error ) ) {
					exit(
					 	wp_redirect(
					 		add_query_arg( 'err', esc_attr( $status ), um_get_core_page( 'login' ) )
					 	)
					);
				}
			break;

		}
	}


	/**
	 * Connect a user
	 *
	 * @param $profile
	 * @param $provider
	 * @param null $user_id
	 */
	function connect( $profile, $provider, $user_id = null ) {

		if ( $user_id == null ) {
			$user_id = get_current_user_id();
		}

		if( $user_id <= 0 ) {
			return;
		}

		foreach ( $profile as $key => $value ) {
			if ( strstr( $key, '_uid_') ) {
				update_user_meta( $user_id , $key, $value );
			} elseif ( strstr( $key, '_save_') ) {
				$key = str_replace('_save_','',$key);
				if ( $key != 'synced_profile_photo' ) {
					update_user_meta( $user_id , $key, $value );
				}
			} else {
				update_user_meta( $user_id, '_um_sso_'.$provider.'_'.$key, $value );
			}
		}

		do_action( "um_social_login_after_connect", $provider, um_user('ID') );
		do_action( "um_social_login_after_{$provider}_connect", um_user('ID') );
	}


	/**
	 * Check that user exists but not connected yet
	 *
	 * @param $profile
	 * @param $provider
	 *
	 * @return false|int
	 */
	function user_exists( $profile, $provider ) {
		if ( isset( $profile['email_exists'] ) && email_exists( $profile['email_exists'] ) ) {
			return email_exists( $profile['email_exists'] );
		}
		if ( isset( $profile['username_exists'] ) && username_exists( $profile['username_exists'] ) ) {
			return username_exists( $profile['username_exists'] );
		}
		return 0;
	}


	/**
	 * Check that user has connected with that provider
	 *
	 * @param $profile
	 * @param $provider
	 *
	 * @return bool
	 */
	function is_previously_connected( $profile, $provider ) {
		global $wpdb;
		$provider_o = '_uid_' . $provider;

		if( ! empty( $profile[ $provider_o ] ) ){
			$user = $wpdb->get_row( $wpdb->prepare(
				'SELECT * FROM '.$wpdb->usermeta.' WHERE meta_key = %s AND meta_value = %s AND meta_value != "" ',
				$provider_o,
				$profile[ $provider_o ]

			) );
		}

		if ( isset( $user->user_id )  ) {
			return $user->user_id;
		}
		return false;
	}


	/**
	 * Is connected
	 *
	 * @param $user_id
	 * @param $provider
	 *
	 * @return bool
	 */
	function is_connected($user_id, $provider) {
		$connection = get_user_meta( $user_id, '_uid_'.$provider, true );
		if ( $connection )
			return true;
		return false;
	}


	/**
	 * Add hidden inputs to form
	 *
	 * @param $args
	 */
	function show_hidden_inputs( $args ) {
		if ( !isset( $this->profile ) ) return;
		foreach ( $this->profile as $key => $value ) {
			if ( strstr( $key, '_uid_') ) {
				echo '<input type="hidden" name="'. $key . '" id="' . $key . '" value="' . $value . '" />';
			}
			if ( strstr( $key, '_save_') ) {
				echo '<input type="hidden" name="'. $key . '" id="' . $key . '" value="' . $value . '" />';
			}
		}
	}


	/**
	 * Get submit button on form
	 */
	function show_submit_button() {
		?>

		<div class="um-col-alt">

			<input type="hidden" name="_social_login_form" id="_social_login_form" value="true" />

			<div class="socialLogin--btn"><input type="submit" value="<?php _e('Complete Registration','um-social-login'); ?>" class="um-button" /></div>

			<div class="um-clear"></div>

		</div>

		<?php
	}


	/**
	 * Load template
	 *
	 * @param $tpl
	 * @param bool $once
	 */
	function load_template( $tpl, $once = false ) {
		$file       = um_social_login_path . 'templates/' . $tpl . '.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/social-login/' . $tpl . '.php';

		if( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if( file_exists( $file ) ) {
			if( $once ) {
				require_once $file;
			}
			else {
				require $file;
			}
		}
	}


	/**
	 * show form
	 */
	function show_registration() {
		if ( $this->show_overlay ) {
			$this->load_template('form');
		}
	}


	/**
	 * Get form id
	 *
	 * @return mixed|void
	 */
	function form_id() {
		return get_option( 'um_social_login_form_installed' );
	}


	/**
	 * Get redirect url as callback url
	 *
	 * @return string
	 */
	function get_redirect_url() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$redirect_url = um_get_core_page('login');
		} else {
			$redirect_url = UM()->permalinks()->get_current_url();
		}

		$pages = UM()->permalinks()->core;
		$slug = '';

		if ( isset( $pages['account'] ) && ! empty( $pages['account'] ) ){
			$um_post = get_post( $pages['account'] );
			$slug = $um_post->post_name;
		}
		if ( ! empty( $slug ) && strpos( $redirect_url, '/'.$slug.'/' ) > -1 ){
			$redirect_url = trailingslashit(um_get_core_page('account').'social');
		}

		if ( empty( $redirect_url ) ) {
			$redirect_url = $this->get_registration_uri();
		}

		$siteurl = get_bloginfo('url');

		if( strpos( $redirect_url, "www.") <= -1 && strpos($siteurl, "www.") > -1  ){
			if( is_ssl() ){
				$redirect_url = str_replace("https://", "https://www.", $redirect_url );
			}else{
				$redirect_url = str_replace("http://", "http://www.", $redirect_url );
			}
		}

		$arr_blocklist_uris = array(
			'provider',
			'code',
			'state',
			'redirect_to',
			'reauth',
			'um_social_login',
			'um_social_login_ref',
		);

		if( isset( $_REQUEST['redirect_to'] ) ){
			$_SESSION['um_social_login_redirect'] = $_REQUEST['redirect_to'];
		}

		foreach ( $arr_blocklist_uris as $arg ) {
		   $redirect_url = remove_query_arg( $arg, $redirect_url );
		}

		return $redirect_url;
	}


	/**
	 * Set providers session to cookies
	 */
	public function set_provider_session() {

		$enable_set_session = apply_filters('um_social_login_set_session__enable', true );

		if( $enable_set_session ){

			if( !session_id() ){
			    session_start();
			}

			// Store facebook session
			foreach ( $_SESSION as $k => $v ) {
			    if( strpos( $k, "FBRLH_" ) !== FALSE ) {
			        if( setcookie($k, $v) ) {
			            $_COOKIE[ $k ] = $v;
			        }
			    }
			}

			foreach ( $_COOKIE as $k => $v ) {
			    if( strpos( $k, "FBRLH_" ) !== FALSE ) {
			        $_SESSION[ $k ] = $v;
			    }
			}

		}

	}


	/**
	 * Modify global query vars
	 *
	 * @param $public_query_vars
	 *
	 * @return array
	 */
	function query_vars( $public_query_vars ) {
		$public_query_vars[] = 'state';
		$public_query_vars[] = 'code';
		$public_query_vars[] = 'provider';

		return $public_query_vars;
	}


	/**
	 * Redirect after authentification
	 */
	function redirect_authentication() {
		if ( isset( $_REQUEST['um_social_login'] ) ) {
			
			wp_logout();

			$_SESSION['um_social_is_shortcode'] = isset( $_REQUEST['um_social_login_ref'] ) ? 1: 0;
			
			if( isset( $_SESSION['um_social_login_rememberme'] ) ){
			  	setcookie( 'um_social_login_rememberme', $_SESSION['um_social_login_rememberme'], time() + DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
				setcookie( 'um_social_login_rememberme', $_SESSION['um_social_login_rememberme'], time() + DAY_IN_SECONDS, SITECOOKIEPATH, COOKIE_DOMAIN );
				unset( $_SESSION['um_social_login_rememberme'] );
			}
		}
	}


	/**
	 *  Clear session after user logout
	 */
	function um_clear_session_after_logout() {
		unset($_COOKIE['PHPSESSID']);
		setcookie('PHPSESSID', null, -1, '/');
	}


	/**
	 * @param $err
	 * @param $error_code
	 *
	 * @return string|void
	 */
	function error_message_handler( $err, $error_code ){

		switch(  $error_code  ){

			case 'um_social_user_denied':
				return __("We were unable to request application access permissions.",'um-social-login');
			break;

			case 'um_social_unauthorized_scope_error':
				return __("One of the scopes is not authorized by your developer application.",'um-social-login');
			break;

		}
		return $err;
	}

}

//create class var
add_action( 'plugins_loaded', 'um_init_social_login', -10, 1 );
function um_init_social_login() {
	if ( function_exists( 'UM' ) ) {
		UM()->set_class( 'Social_Login_API', true );
	}
}