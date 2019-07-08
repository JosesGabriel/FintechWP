<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Test Only
 * */
class APYC_Mail {
  /**
	 * instance of this class
	 *
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $from_name = 'Arbitrage';
	protected $from_email = 'support@mail.com';
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

	public function config()
	{

	}

	/**
	* Use to set From Name
	* @param $from_name	| string
	* @return string
	**/
	public function setFromName($from_name)
	{
		$this->from_name = $from_name;
	}

	/**
	* Get from name
	**/
	public function getFromName()
	{
		return $this->from_name;
	}

	/**
	* Use to set From Email
	* @param $from_email	| string
	* @return string
	**/
	public function setFromEmail($from_email)
	{
		$this->from_email = $from_email;
	}

	/**
	* Get from name
	**/
	public function getFromEmail()
	{
		return $this->from_email;
	}

	/**
	* Use to send mail notification
	* @param $args | array
	* 	data => this data is a variable use for the template as variables
	*			$data['name'] = 'Name' | will be $name on the template
	*		template => if this is set it will require the template file, make sure to add it on
	*				/partials/mail/
	*		subject => the subject of the email
	*		to => to for send
	*		attachments => array path of file attach
	* @return wp_mail
	*	@see https://developer.wordpress.org/reference/functions/wp_mail/
	**/
	public function send($args)
	{
		//get the from name
		$from_name = $this->getFromName();
		//get from email
		$from_name_email = $this->getFromEmail();

		/**
		 * Define the array of defaults
		 */
		$defaults = array(
			'template' 		=> 'mail.php',
			'headers' 		=> [
				'From: '.$from_name.' <'.$from_name_email.'>',
				'Return-Path: '.$from_name_email.'',
				'MIME-Version: 1.0',
				'Content-Type: text/html; charset=UTF-8',
			],
			'attachments' => [],
			'subject' 		=> '',
			'to'					=> '',
			'data' 				=> [],
		);

		/**
		 * Parse incoming $args into an array and merge it with $defaults
		 */
		$args = wp_parse_args( $args, $defaults );

		//get the template
		$template_file = arbitrage_partial('mail/' . $args['template']);
		if( $template_file ){
			//use to get the template file and dump to body variable
			ob_start();
	    APYC_View::get_instance()->display($template_file, $args['data']);
	    $body = ob_get_contents();
	    ob_end_clean();
			//send
			return wp_mail($args['to'], $args['subject'], $body, $args['headers'], $args['attachments']);
		}
	}

}
