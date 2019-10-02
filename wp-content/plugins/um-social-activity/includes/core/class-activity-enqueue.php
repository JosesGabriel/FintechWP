<?php
namespace um_ext\um_social_activity\core;

if ( ! defined( 'ABSPATH' ) ) exit;

class Activity_Enqueue {

	function __construct() {
	
		$priority = apply_filters( 'um_activity_enqueue_priority', 0 );
		
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), $priority );
	}


	/**
	 * Enqueue scripts
	 */
	function wp_enqueue_scripts() {
		wp_register_style('um_activity', um_activity_url . 'assets/css/um-activity.css' );
		wp_enqueue_style('um_activity');

		wp_register_style('um_activity_responsive', um_activity_url . 'assets/css/um-activity-responsive.css' );
		wp_enqueue_style('um_activity_responsive');

		wp_register_script( 'um_autosize', um_activity_url . 'assets/js/autoresize-mod.jquery.js', array( 'jquery' ), um_activity_version, true );
		wp_register_script( 'um_autosize-old', um_activity_url . 'assets/js/autosize.min.js', array( 'jquery' ), um_activity_version, true );
		wp_register_script( 'um_activity', um_activity_url . 'assets/js/um-activity.js', array( 'jquery', 'jquery-ui-autocomplete','um_autosize', 'um_autosize-old', 'wp-util' ), um_activity_version, true );
		wp_enqueue_script( 'um_activity' );
		
	}

}