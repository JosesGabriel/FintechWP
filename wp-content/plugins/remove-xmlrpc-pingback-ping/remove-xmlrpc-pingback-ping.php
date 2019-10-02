<?php
 /*
 Plugin Name:       Remove XMLRPC Pingback Ping
 Plugin URI:        http://wordpress.org/plugins/remove-xmlrpc-pingback-ping
 Description:       Prevent WordPress from participating in and being a victim of pingback denial of service attacks.
 Version:           1.1
 Author:            WebFactory Ltd
 Author URI:        https://www.webfactoryltd.com/
 License:           GPL-2.0+
 License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 
 Copyright 2014 - 2019  Web factory Ltd  (email: support@webfactoryltd.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );

function remove_xmlrpc_pingback_ping( $methods ) {
  unset( $methods['pingback.ping'] );
  return $methods;
}
