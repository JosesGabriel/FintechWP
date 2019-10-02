<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Test Only
 * */
class APYC_Cron {
  /**
	 * instance of this class
	 *
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct()
	{
		//register_deactivation_hook(__FILE__, array($this, 'my_deactivation'));
		register_activation_hook(__FILE__, array($this, 'activateCron'));
		add_action('wp', array($this, 'activateCron'));
		add_action('arbitrage_cron_event', array($this, 'init'));
		add_filter('cron_schedules', array($this, 'cronSchedules') );
	}

	public function cronSchedules( $schedules ) {
	  $schedules['every_minutes'] = array(
        'interval'  => 60,
        'display'   => __( 'Every Minutes', 'textdomain' )
	  );

	  return $schedules;
	}

	public function activateCron() {
		if (! wp_next_scheduled ( 'arbitrage_cron_event' )) {
			wp_schedule_event(time(), 'every_minutes', 'arbitrage_cron_event');
		}
	}

	public function my_deactivation() {
		wp_clear_scheduled_hook('every_minutes');
	}

	public function init()
	{
		if(is_between_times()){
				APYC_WatchListNotify::get_instance()->sendTo();
		}
		
	}

}
