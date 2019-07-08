<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Watch List notify
 * */
class APYC_WatchListNotify {
  /**
	 * instance of this class
	 *
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $check_data 				= [];
	protected $check_entry_price 	= [];
	protected $check_take_profit 	= [];
	protected $check_stop_loss 		= [];
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
		$this->check_entry_price = [];
		$this->check_take_profit = [];
		$this->check_stop_loss = [];
		$this->check_data = [];
	}

	public function setEntryPrice($price)
	{
		if($price != '') {
				$this->check_entry_price[] = $price;
		}
	}

	public function getEntryPrice()
	{
		return $this->check_entry_price;
	}

	public function checkEntryPrice($my_price, $quote_price)
	{
		$compare = compareFloatNumbers($my_price, $quote_price);
		return $compare;
	}

	public function setTakeProfit($price)
	{
		if($price != '') {
				$this->check_take_profit[] = $price;
		}
	}

	public function getTakeProfit()
	{
		return $this->check_take_profit;
	}

	public function checkTakeProfit($my_price, $quote_price)
	{
		$compare = compareFloatNumbers($my_price, $quote_price, '<');
		return $compare;
	}

	public function setStopLoss($price)
	{
		if($price != '') {
				$this->check_stop_loss[] = $price;
		}
	}

	public function getStopLoss()
	{
		return $this->check_stop_loss;
	}

	public function checkStopLoss($my_price, $quote_price)
	{
		$compare = compareFloatNumbers($my_price, $quote_price, '>');
		return $compare;
	}

	public function getWatchList()
	{
		return $this->check_data;
	}
	/**
	* this will check the user watch list data to the quote
	**/
	public function check()
	{
		$get_quote 					= arbitrage_get_psi_quote();
		//apyc_dd($get_quote);
		$get_watchlist = [];
		$get_user_watchlist = arbitrage_get_user_watchlist();
		//apyc_dd($get_user_watchlist);
		if($get_user_watchlist){
			foreach($get_user_watchlist as $k => $v){
				if(!empty($v['watch_list'])){
					foreach($v['watch_list'] as $w_k => $w_v){
						$quote_price = $get_quote[$w_v['stockname']]->last;

						$my_entry_price  = isset($w_v['dconnumber_entry_price']) ? $w_v['dconnumber_entry_price'] : '';

						$ret_data = [
							'user_id' => $v['user_id'],
							'email' => $v['email'],
							'my_price' => $my_entry_price,
							'quote_price' => $quote_price,
							'stock_name' => $w_v['stockname'],
							'delivery_type' => $w_v['delivery_type'],
						];

						if( $this->checkEntryPrice($my_entry_price, $quote_price) ){
							//$this->setEntryPrice($my_entry_price);
							$this->check_data['entry_price'][] = $ret_data;
						}

						if( $this->checkTakeProfit($my_entry_price, $quote_price) ){
							//$this->setTakeProfit($my_entry_price);
							$this->check_data['take_profit'][] = $ret_data;
						}

						if( $this->checkStopLoss($my_entry_price, $quote_price) ){
							//$this->setStopLoss($my_entry_price);
							$this->check_data['stop_loss'][] = $ret_data;
						}

					}
				}
			}
		}
		$get_ep = $this->getEntryPrice();
		//apyc_dd($get_ep);
		$get_tp = $this->getTakeProfit();
		//apyc_dd($get_tp);
		$get_sl = $this->getStopLoss();
		//apyc_dd($get_sl);
		//apyc_dd($this->check_data);
		return $this->getWatchList();
	}

	private function sendToMail($arg_data)
	{
		$verbage = arbitrage_watch_alert_mail_verbage();
		$arg_mail = [
			'subject' => $verbage[$arg_data['type']]['subject'],
			'to' 			=> $arg_data['to_email'],
			'data' 		=> $arg_data['data'],
		];
		//echo count($arg_mail);
		//apyc_dd($arg_mail);
		sleep(3);
		arbitrage_send_mail($arg_mail);
	}

	public function sendTo()
	{
		$ret = $this->check();
		//echo count($ret);
		foreach($ret as $k => $v){
			if(!empty($v)){
				foreach($v as $ret_k => $ret_v){
					$arr = [
						'type' => $k,
						'to_email' => $ret_v['email'],
						'data' => $ret_v,
					];
					if(!empty($ret_v['delivery_type'])){
						$check_arg = [
							'user_id' => $ret_v['user_id'],
							'_prefix' => '_'.$ret_v['stock_name'],
						];
						//apyc_dd($ret_v);
						$check_notify_limit = APYC_WatchListLimit::get_instance()->check($check_arg);
						$in_delivery = in_array('web-notif', $ret_v['delivery_type']);
						//echo $in_delivery ? 'y':'n';
						//echo $check_notify_limit ? 'y':'n';
						if($check_notify_limit && $in_delivery){
							$this->sendToMail($arr);
						}
					}
				}
			}
		}
	}

}
