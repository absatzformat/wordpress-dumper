<?php
/*
	Plugin Name: Absatzformat Dumper
	Plugin URI: https://gitlab.com/absatzformat/wordpress/dumper
	Description: Dump PHP vars to JS console
	Author: Absatzformat GmbH
	Version: 1.0.0
	Author URI: https://absatzformat.de
*/

use Absatzformat\Wordpress\Dumper\Dumper;

defined('WPINC') or die();

define('Absatzformat\Wordpress\Dumper\PLUGIN_VERSION', '1.0.0');
define('Absatzformat\Wordpress\Dumper\PLUGIN_PATH', plugin_dir_path(__FILE__));
define('Absatzformat\Wordpress\Dumper\PLUGIN_URL', plugin_dir_url(__FILE__));
define('Absatzformat\Wordpress\Dumper\PLUGIN_SLUG', pathinfo(__FILE__, PATHINFO_FILENAME));
define('Absatzformat\Wordpress\Dumper\MENU_SLUG', Absatzformat\Wordpress\Dumper\PLUGIN_SLUG);

require_once 'dumper.class.php';

// TODO: add wp admin page for settings

add_action('wp_print_footer_scripts', [Dumper::class, 'print']);
add_action('admin_print_footer_scripts', [Dumper::class, 'print']);

// global dump function
if(!function_exists('_dump')){

	function _dump(){

		$args = func_get_args();
		$dumper = Dumper::getInstance();

		$dumper->backtraceLevel += 1;
		call_user_func_array([$dumper, 'dump'], $args);
		$dumper->backtraceLevel -= 1;
	}
}