<?php

/*
Plugin Name: Walk Me
Plugin URI: http://drunkencoding.us
Description: Provides easy integration between the Walk Me service and WordPress
Version: 1.0.1
Author: Ryan Hoover
Author URI: http://ryan.hoover.ws
*/

$path = plugin_dir_path( __FILE__ );

require_once( $path . 'lib/walkme-class.php' );
require_once( $path . 'lib/admin.php' );

if ( class_exists( 'WalkMe' ) ) {
	$walkme = WalkMe::get_instance();
}

if ( class_exists( 'WalkMeAdmin' ) ) {
	$walkme_admin = WalkMeAdmin::get_instance();
}

