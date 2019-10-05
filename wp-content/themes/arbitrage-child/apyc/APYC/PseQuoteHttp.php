<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Use to get pse quote
 * https://api2.pse.tools/api/quotes
 * */
class APYC_PseQuoteHttp {
  /**
	 * instance of this class
	 *
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $url = 'https://api2.pse.tools/api/quotes';
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

	/**
	* get the quote api results
	**/
	public function get()
	{
		$url = $this->url;

		$res = [];

		$get_res = wp_remote_get($url);

		if ( is_array( $get_res ) ) {
			$result = $get_res;
			$res['body'] 					= wp_remote_retrieve_body($result);
			$res['decode_body'] 	= json_decode(wp_remote_retrieve_body($result));
			$res['header'] 				= wp_remote_retrieve_headers($result);
			$res['response_code'] = wp_remote_retrieve_response_code($result);
		}

		return $res;
	}

}
