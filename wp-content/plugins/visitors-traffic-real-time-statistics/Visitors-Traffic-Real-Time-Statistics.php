<?php
/*
Plugin Name: Visitors Traffic Real Time Statistics Free
Description: Hits counter that shows analytical numbers of your WordPress site visitors and hits. <a href="admin.php?page=ahc_hits_counter_menu_free">Dashboard</a> | <a href="http://www.wp-buy.com/product/visitors-traffic-real-time-statistics-pro">Upgrade to pro.</a> 
Author: wp-buy
Author URI: https://www.wp-buy.com/
Version: 1.14

*/

//date_default_timezone_set(date_default_timezone_get());




define('AHCFREE_PLUGIN_MAIN_FILE', __FILE__);
define('AHCFREE_PLUGIN_ROOT_DIR', dirname(__FILE__));

require_once(AHCFREE_PLUGIN_ROOT_DIR. "/functions.php");
require_once(AHCFREE_PLUGIN_ROOT_DIR."/init.php");

if( !function_exists('get_plugin_data') ){
	include_once( ABSPATH. 'wp-admin/includes/plugin.php' );
}

if ( function_exists('get_plugin_data') ) {
	$woodhl_detail = get_plugin_data( __FILE__ );
	$installed_version = get_option( 'visitors-traffic-real-time-statistics-free-version' );
	if( $installed_version != $woodhl_detail['Version'] ){
		add_action( 'plugins_loaded', 'ahcfix_init' );
		update_option( 'visitors-traffic-real-time-statistics-free-version', $woodhl_detail['Version'] );
	}
}


function ahcfree_HideMessageAjaxFunction()
	{  
		add_option( 'ahcfree_upgrade_message','yes');
	}  

	
function ahcfree_after_plugin_row($plugin_file, $plugin_data, $status) {
	        
			if(get_option('ahcfree_upgrade_message') !='yes')
			{
				$class_name = $plugin_data['slug'];
				
				$upgradeMsg = '<tr id="' .$class_name. '-plugin-update-tr" class="plugin-update-tr active">';
		        $upgradeMsg .= '<td  colspan="3" class="plugin-update">';
		        $upgradeMsg .= '<div id="' .$class_name. '-upgradeMsg" class="update-message" style="background:#FFF8E5; padding-left:10px; border-left:#FFB900 solid 4px" >';

				$upgradeMsg .= 'You are running visitors traffic free. To get more features (<b style="color:red">Online users, GEO locations and visitors on the map</b>), you can <a href="https://www.wp-buy.com/product/visitors-traffic-real-time-statistics-pro/#plugins-page" target="_blank"><strong>upgrade now</strong></a> or ';
				        
				$upgradeMsg .= '<span id="HideMe" style="cursor:pointer" ><a href="javascript:void(0)"><strong>dismiss</strong></a> this message</span>';
				$upgradeMsg .= '</div>';
		        $upgradeMsg .= '</td>';
		        $upgradeMsg .= '</tr>';
		        
				
		        echo $upgradeMsg;
		        ?>
		        
		        <script type="text/javascript">
			    jQuery(document).ready(function() {
				    var row = jQuery('#<?php echo $class_name;?>-plugin-update-tr').closest('tr').prev();
				    jQuery(row).addClass('update');
					
					
					jQuery("#HideMe").click(function(){ 
					  
					jQuery("#<?php echo $class_name;?>-upgradeMsg").empty(); 
					jQuery("#<?php echo $class_name;?>-upgradeMsg").removeAttr("style"); 
					
					localStorage.setItem("vtrts_hide_upgrade_message", "hide_msg");

					  
				  });
				  
				  if(localStorage.getItem("vtrts_hide_upgrade_message") == "hide_msg")
				  {
					 
					  jQuery("#<?php echo $class_name;?>-upgradeMsg").empty(); 
					  jQuery("#<?php echo $class_name;?>-upgradeMsg").removeAttr("style"); 
				  }
  
			    });
			    </script>
		        
		        
		        <?php
				
			}
	    }
$path = plugin_basename( __FILE__ );		
add_action("after_plugin_row_{$path}", 'ahcfree_after_plugin_row', 10, 3);
add_action( 'wp_ajax_nopriv_ahcfree_HideMessageAjaxFunction', 'ahcfree_HideMessageAjaxFunction' );  
add_action( 'wp_ajax_ahcfree_HideMessageAjaxFunction', 'ahcfree_HideMessageAjaxFunction' ); 



//--------------------------------------------
?>