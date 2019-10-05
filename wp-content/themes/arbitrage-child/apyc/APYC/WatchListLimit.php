<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Watch List send how many limit per day
 * - once per day for each stock
 * */
class APYC_WatchListLimit {
  /**
	 * instance of this class
	 *
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $user_meta_prefix = '_last_notification';
	protected $check_difference_daily = '24';
	protected $check_difference_by = 'daily';
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

	public function init()
	{
		//$this->reset();
		//echo is_between_times() ? 'y':'n';
	}

	public function getDifference($args)
	{
		//the from key must be from strtotime() function
		$time_difference = $this->check_difference_by;
		$defaults = array(
			'difference_type' => $time_difference,
			'to' => time(),
			'from' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$get_diff = false;
		//apyc_dd($args);
		if(isset($args['from']) && trim($args['from']) != ''){

			$diff = (int) abs( $args['to'] - $args['from'] );

			$difference_type = $args['difference_type'];

			switch($difference_type)
			{
				case 'daily':
				default:
					$get_diff = round( $diff / HOUR_IN_SECONDS );
				break;
			}

		}
		return $get_diff;
	}

	public function defaultTimeDifferenceType()
	{
		switch($this->check_difference_by){
			case 'daily':
			default:
				return 24;
			break;
		}
	}

	public function checkDifference($check_from)
	{
		$check_difference_type = $this->defaultTimeDifferenceType();
		//apyc_dd($check_from['from']);
		//echo date('d/m/y H:s:i', $check_from['from']);
		if($this->getDifference($check_from['from']) > $check_difference_type){
		//if(24 >= $check_difference_type){
			return true;
		}
		return false;
	}

	/**
	* check if already notify
	**/
	public function check($arg)
	{
		$from_time 	= time();
		$user_id 		= isset($arg['user_id']) ? $arg['user_id'] : false;
		$is_valid_checked = false;
		//check if user has notify limit meta already
		if( $user_id ) {
			$arg['single'] = true;
			$check_db = $this->get($arg);
			if(!$check_db){
				//echo 'create';
				$this->store([
					'user_id' => $user_id,
					'value' 	=> $from_time,
					'_prefix' => $arg['_prefix'],
					'from_to' => $from_time,
				]);
				$is_valid_checked =  true;
			}else{
				$check_db 				= $this->get($arg);
				$from_time_check 	= isset($check_db[0]) ? $check_db[0] : 0;
				//apyc_dd($from_time_check);
				$check_past_hour = $this->checkDifference([
					'from' => $from_time_check
				]);
				//echo $check_past_hour ? 'y':'n';
				if($check_past_hour){
					$is_valid_checked =  true;
					$this->store([
						'user_id' => $user_id,
						'value' 	=> $from_time,
						'_prefix' => $arg['_prefix'],
						'from_to' => $from_time,
					]);
				}
			}
			//check if over the time difference
		}
		return $is_valid_checked;
	}

	public function get($arg)
	{
		return $this->userMeta([
			'user_id' => $arg['user_id'],
			'_prefix' 	=> $arg['_prefix'],
		]);
	}

	public function store($args)
	{
		//format 'd/m/y h:i:s'
		//date('d/m/y H:i:s', $from);
		//before store, can be time()
		//$unix_time_stamp strtotime("05/10/2019 15:00:00"); //convert date to unix timestamp
		//echo date('m/d/y H:i:s', $unix_time_stamp);

		$time = $args['from_to'] ? $args['from_to'] : time();
		$arg = [
			'user_id' => $args['user_id'],
			'action' 	=> 'u',
			'value' 	=> $time,
			'_prefix' => $args['_prefix'],
		];
		$this->userMeta($arg);
	}

	public function reset()
	{
		$current_user = wp_get_current_user();
		if ( 0 != $current_user->ID ) {
	    // Not logged in.
			$user_id = $current_user->ID;
			$get_time = $this->get($user_id);
			if(!$get_time){
				$this->userMeta([
					'user_id' => $user_id,
					'action' => 'u',
					'value' => '',
				]);
			}
			$arg = [
				'user_id' => $user_id,
				'from' => $get_time
			];
			if($this->check($arg)){
				$this->userMeta([
					'user_id' => $current_user->ID,
					'action' => 'u',
					'value' => '',
				]);
			}
		}
	}

	public function userMeta($args)
	{
		$prefix = $this->user_meta_prefix . $args['_prefix'];

		if(isset($args['user_id'])) {

			$defaults = array(
				'single' => false,
				'action' => 'r',
				'value' => '',
				'prefix' => $prefix
			);

			$args = wp_parse_args( $args, $defaults );

			switch($args['action']){
				case 'd':
					delete_user_meta($args['user_id'], $args['prefix'], $args['value']);
				break;
				case 'u':
					update_user_meta($args['user_id'], $args['prefix'], $args['value']);
				break;
				case 'r':
					return get_user_meta($args['user_id'], $args['prefix'], $args['single']);
				break;
			}//switch
		}//if

	}

}//end of class
