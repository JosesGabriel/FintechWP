<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
function apyc_get_plugin_dir(){
	return plugin_dir_path( __FILE__ );
}
$time_zone = get_option('timezone_string');
date_default_timezone_set($time_zone);
/**
 * For autoloading classes
 * */
spl_autoload_register('allteam_directory_autoload_class');
function allteam_directory_autoload_class($class_name){
    if ( false !== strpos( $class_name, 'APYC' ) ) {
		$include_classes_dir = realpath( get_stylesheet_directory( __FILE__  ) ) . DIRECTORY_SEPARATOR;
		$class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
    if( file_exists($include_classes_dir . 'apyc/' . $class_file) ){
			require_once $include_classes_dir . 'apyc/' . $class_file;
		}
	}
}

require_once get_stylesheet_directory() . '/apyc/function-helper.php';

//init
function run_apyc() {
	APYC_Cron::get_instance();
	//APYC_WatchListLimit::get_instance()->init();
	/*if(is_between_times()){
		APYC_WatchListNotify::get_instance()->sendTo();
	}*/
	if(isset($_GET['allan'])){
	}
}
add_action('wp_loaded', 'run_apyc');

function mailtrap($phpmailer) {
  $phpmailer->isSMTP();
  $phpmailer->Host = 'smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = '03bb6f02053c14';
  $phpmailer->Password = 'b34291b889be14';
}

//add_action('phpmailer_init', 'mailtrap');
