<?php
if ( ! defined( 'ABSPATH' ) ) exit;


class UM_Notifications_API {

    private static $instance;

    static public function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }


	function __construct() {
        // Global for backwards compatibility.
        $GLOBALS['um_notifications'] = $this;
        add_filter( 'um_call_object_Notifications_API', array( &$this, 'get_this' ) );

        $this->enqueue();
        $this->shortcode();

		add_action( 'plugins_loaded', array( &$this, 'init' ), 0 );


        add_filter( "um_core_pages",  array( &$this,'um_notification_core_page' ) );

        add_filter( 'um_settings_default_values', array( &$this, 'default_settings' ), 10, 1 );

        add_filter( 'um_rest_api_get_stats', array( &$this, 'rest_api_get_stats' ), 10, 1 );

		add_action( 'wp_ajax_um_notification_delete_log', array( $this->api(), 'ajax_delete_log' ) );
		add_action( 'wp_ajax_um_notification_mark_as_read', array( $this->api(), 'ajax_mark_as_read' ) );
		add_action( 'wp_ajax_um_notification_check_update', array( $this->api(), 'ajax_check_update' ) );
    }


    function rest_api_get_stats( $response ) {
        global $wpdb;

        $total_notifications = absint( $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}um_notifications" ) );
        $response['stats']['total_notifications'] = $total_notifications;

        return $response;
    }


    function default_settings( $defaults ) {
        $defaults = array_merge( $defaults, $this->setup()->settings_defaults );
        return $defaults;
    }


    /**
     * @return um_ext\um_notifications\core\Notifications_Setup()
     */
    function setup() {
        if ( empty( UM()->classes['um_notifications_setup'] ) ) {
            UM()->classes['um_notifications_setup'] = new um_ext\um_notifications\core\Notifications_Setup();
        }
        return UM()->classes['um_notifications_setup'];
    }


    /***
     ***	@extend core pages
     ***/
    function um_notification_core_page( $pages ) {
        $pages['notifications'] = array( 'title' => __( 'Notifications', 'um-notifications' ) );
        return $pages;
    }


    function get_this() {
        return $this;
    }


    /**
     * @return um_ext\um_notifications\core\Notifications_Main_API()
     */
    function api() {
        if ( empty( UM()->classes['um_notifications_api'] ) ) {
            UM()->classes['um_notifications_api'] = new um_ext\um_notifications\core\Notifications_Main_API();
        }
        return UM()->classes['um_notifications_api'];
    }


    /**
     * @return um_ext\um_notifications\core\Notifications_Enqueue()
     */
    function enqueue() {
        if ( empty( UM()->classes['um_notification_enqueue'] ) ) {
            UM()->classes['um_notification_enqueue'] = new um_ext\um_notifications\core\Notifications_Enqueue();
        }
        return UM()->classes['um_notification_enqueue'];
    }


    /**
     * @return um_ext\um_notifications\core\Notifications_Shortcode()
     */
    function shortcode() {
        if ( empty( UM()->classes['um_notification_shortcode'] ) ) {
            UM()->classes['um_notification_shortcode'] = new um_ext\um_notifications\core\Notifications_Shortcode();
        }
        return UM()->classes['um_notification_shortcode'];
    }


	/***
	***	@Init
	***/
	function init() {
		
		// Actions
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-comment.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-review.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-mycred.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-profile.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-bbpress.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-log-user.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-footer.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-account.php';
		require_once um_notifications_path . 'includes/core/actions/um-notifications-hooks.php';

		// Filters
		require_once um_notifications_path . 'includes/core/filters/um-notifications-settings.php';
		require_once um_notifications_path . 'includes/core/filters/um-notifications-account.php';
		
	}
}

//create class var
add_action( 'plugins_loaded', 'um_init_notifications', -10, 1 );
function um_init_notifications() {
    if ( function_exists( 'UM' ) ) {
        UM()->set_class( 'Notifications_API', true );
    }
}