﻿=== Remove & Disable XML-RPC Pingback ===
Contributors: WebFactory, wpreset, googlemapswidget, securityninja, underconstructionpage
Tags: xmlrpc, xml-rpc, ping, pingback, disable ping, disable xmlrpc, disable pingback, disable xml-rpc
Requires at least: 4.0
Requires PHP: 5.2
Tested up to: 5.2
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Prevent pingback, XML-RPC and denial of service attacks by disabling the XML-RPC pingback functionality.

== Description ==

Prevent your WordPress site from participating and being a victim of pingback denial of service attacks. **After activation the plugin automatically disables XML-RPC. There's no need to configure anything.**

By disabling the XML-RPC pingback you'll:
* lower your server CPU usage
* prevent malicious scripts from using your site to run pingback denial of service attacks
* prevent malicious scripts to run denial of service attacks on your site via pingback

From sucuri.net:

> Any WordPress site with Pingback enabled (which is on by default) can be used in DDOS attacks against other sites.

= Learn More =

* [How To Prevent WordPress From Participating In Pingback Denial of Service Attacks](http://wptavern.com/how-to-prevent-wordpress-from-participating-in-pingback-denial-of-service-attacks) - wptavern.com
* [More Than 162,000 WordPress Sites Used for Distributed Denial of Service Attack](http://blog.sucuri.net/2014/03/more-than-162000-wordpress-sites-used-for-distributed-denial-of-service-attack.html) - sucuri.net
* [xmlrpc.php and Pingbacks and Denial of Service Attacks, Oh My!](http://hackguard.com/xmlrpc-php-ping-backs-hackers-denial-service-attacks) - hackguard.com

= Is Your Site Attacking Others? =

Use [Sucuri's WordPress DDOS Scanner](http://labs.sucuri.net/?is-my-wordpress-ddosing) to check if your site is DDOS’ing other websites

= Why Not Just Disable XMLRPC Altogether? =

Yes, you can choose to do that using the plugin [Disable XML-RPC](http://wordpress.org/plugins/disable-xml-rpc/), but if you use popular plugins like JetPack (that use XMLRPC) then those plugins will stop working 100%. That is why this small plugin exists.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Remove XMLRPC Pingback Ping'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `remove-xmlrpc-pingback-ping.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `remove-xmlrpc-pingback-ping.zip`
2. Extract the `remove-xmlrpc-pingback-ping` directory to your computer
3. Upload the `remove-xmlrpc-pingback-ping` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Screenshots ==

1. Postman: Without the plugin installed
2. Postman: With the plugin installed

== Frequently Asked Questions ==

= Is My Site Attacking Others? =

It could be! Use [Sucuri's WordPress DDOS Scanner](http://labs.sucuri.net/?is-my-wordpress-ddosing) to check if your site is DDOS’ing other websites

== Changelog ==

= 1.1 =
* 2019/04/09
* version bump

= 1.0.0 =
* First release
