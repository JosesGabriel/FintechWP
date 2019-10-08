<?php

/**
 * Plugin Name: Oribi Analytics
 * Description: You’re minutes away from automatic event tracking, user behavior analysis and marketing insights.
 * Author: Oribi
 * Author URI: https://oribi.io
 * Version: 1.0
 * Text Domain: oribi
 */

require plugin_dir_path( __FILE__ ) . '/inc/oribi-admin-settings.php';

$plugin_name = plugin_basename( __FILE__ );

function oribi_plugin_settings_link( $links ){
    $url = esc_url( add_query_arg(
		'page',
		'oribi',
		get_admin_url() . 'admin.php'
	));

	$settings_link = '<a href="' . $url . '">' . __( 'Settings', 'oribi' ) . '</a>';

	array_push(
		$links,
		$settings_link
	);
	return $links;
}
add_filter("plugin_action_links_{$plugin_name}", 'oribi_plugin_settings_link');


function oribi_get_snippet(){
	$snippet = '';

	if ( ! empty( get_option( 'oribi_snippet' ) ) ) {
        $snippet =  get_option( 'oribi_snippet' );
	}

	return $snippet;
}


function oribi_insert_snippet(){
	echo oribi_get_snippet();
}
add_action( 'wp_head', 'oribi_insert_snippet' );