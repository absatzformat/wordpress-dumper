<?php
/*
	Plugin Name: Absatzformat Dumper
	Plugin URI: https://github.com/absatzformat/wp-dumper
	Description: Dump PHP vars to JS console
	Author: Absatzformat GmbH
	Version: 1.0.1
	Author URI: https://absatzformat.de
*/

use Absatzformat\Wordpress\Dumper\Dumper;

defined('WPINC') or die();

require_once __DIR__ . '/src/Dumper.php';

add_action('wp_print_footer_scripts', [Dumper::class, 'print']);
add_action('admin_print_footer_scripts', [Dumper::class, 'print']);

// global dump function
if (!function_exists('_dump')) {

	function _dump()
	{
		$args = func_get_args();
		$dumper = Dumper::getInstance();

		$dumper->backtraceLevel += 1;
		call_user_func_array([$dumper, 'dump'], $args);
		$dumper->backtraceLevel -= 1;
	}
}
