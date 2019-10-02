<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Watch List
 * */
class APYC_WatchList {
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

	}

	public function getUser()
	{
		global $wpdb;

		$user_meta = [];

		$args = array(
			'meta_query' => array(
					array(
						'key'     => '_watchlist_instrumental',
						'compare' => '='
					)
			)
		);
		$user_query = new WP_User_Query( $args );
		$get_user = $user_query->get_results();
		if ( ! empty( $get_user ) ) {
			foreach($get_user as $k => $v) {
				$get_user_meta = get_user_meta($v->ID, '_watchlist_instrumental', true);
				$user_meta[] = [
					'user_id' 		=> $v->ID,
					'email'				=> $v->user_email,
					'watch_list'	=> $get_user_meta,
				];
			}
		}
		return $user_meta;
	}

}//end of class
