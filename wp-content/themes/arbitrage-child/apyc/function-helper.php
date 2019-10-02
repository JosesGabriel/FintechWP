<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function apyc_dd($array, $die = false){
  echo '<pre>';
    print_r($array);
  echo '</pre>';
  if($die){
    wp_die();
  }
}
function is_between_times( $start = null, $end = null ) {
    if ( $start == null ) $start = '09:00';
    if ( $end == null ) $end = '15:30';
    return ( $start <= date( 'H:i' ) && date( 'H:i' ) <= $end );
}
/**
* get the template path
**/
function arbitrage_partial($template) {
  $template_path = apyc_get_plugin_dir() . 'partials/' . $template;
  return file_exists($template_path) ? $template_path : false;
}
/**
* send mail
* use the class APYC_Mail method send()
* check to see acceptable parameters of send method
* @param  $args | array
**/
function arbitrage_send_mail($args = []) {
  APYC_Mail::get_instance()->send($args);
}

function arbitrage_get_psi_quote() {
	$ret = APYC_PseQuoteHttp::get_instance()->get();
	$data = [];
	if($ret['response_code'] == 200){
		$data = (array)$ret['decode_body']->data;
	}
	return $data;
}

function arbitrage_get_user_watchlist() {
	$get = APYC_WatchList::get_instance()->getUser();
	return $get;
}

function arbitrage_watch_alert_mail_verbage()
{
	return [
		'stop_loss' => [
			'subject' => 'Stop Loss',
		],
		'take_profit' => [
			'subject' => 'Take Profit',
		],
		'entry_price' => [
			'subject' => 'Entry Price',
		],
	];
}

// a function for comparing two float numbers
// float 1 - The first number
// float 2 - The number to compare against the first
// operator - The operator. Valid options are =, <=, <, >=, >, <>, eq, lt, lte, gt, gte, ne
//http://biostall.com/php-function-to-compare-floating-point-numbers/
function compareFloatNumbers($float1, $float2, $operator='=')
{
    // Check numbers to 5 digits of precision
    $epsilon = 0.00001;

    $float1 = (float)$float1;
    $float2 = (float)$float2;

    switch ($operator)
    {
        // equal
        case "=":
        case "eq":
        {
            if (abs($float1 - $float2) < $epsilon) {
                return true;
            }
            break;
        }
        // less than
        case "<":
        case "lt":
        {
            if (abs($float1 - $float2) < $epsilon) {
                return false;
            }
            else
            {
                if ($float1 < $float2) {
                    return true;
                }
            }
            break;
        }
        // less than or equal
        case "<=":
        case "lte":
        {
            if (compareFloatNumbers($float1, $float2, '<') || compareFloatNumbers($float1, $float2, '=')) {
                return true;
            }
            break;
        }
        // greater than
        case ">":
        case "gt":
        {
            if (abs($float1 - $float2) < $epsilon) {
                return false;
            }
            else
            {
                if ($float1 > $float2) {
                    return true;
                }
            }
            break;
        }
        // greater than or equal
        case ">=":
        case "gte":
        {
            if (compareFloatNumbers($float1, $float2, '>') || compareFloatNumbers($float1, $float2, '=')) {
                return true;
            }
            break;
        }
        case "<>":
        case "!=":
        case "ne":
        {
            if (abs($float1 - $float2) > $epsilon) {
                return true;
            }
            break;
        }
        default:
        {
            die("Unknown operator '".$operator."' in compareFloatNumbers()");
        }
    }

    return false;
}
