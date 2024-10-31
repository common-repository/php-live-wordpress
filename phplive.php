<?php
	/*
	Plugin Name: PHP Live!
	Plugin URI: http://wordpress.org/extend/plugins/php-live-wordpress/
	Description: PHP Live! WordPress plugin enables PHP Live! integration with your WordPress website.
	Author: phplivesupport
	Author URI: https://www.phplivesupport.com
	Version: 3.6
	*/

	if ( is_admin() ) { require_once(dirname(__FILE__).'/libs/phplive_setup.class.php') ; phplive_admin::get_instance() ; }
	else { require_once( dirname(__FILE__).'/libs/phplive.class.php' ) ; phplive::get_instance() ; }
?>
