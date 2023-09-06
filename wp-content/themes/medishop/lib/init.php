<?php 

/**
 * Include require file 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require MEDISHOP_THEMEROOT_DIR . '/lib/options/opt-config.php';

/**
 * Saving automatically the ACF group fields json files
 */
add_filter('acf/settings/save_json', function ( $path ) {

	// update path
	$path = get_stylesheet_directory() . '/lib/acf-json';

	// return
	return $path;

});

/**
 * Loading the saved ACF fields
 */
add_filter('acf/settings/load_json', function ( $paths ) {
	// append path
	$paths[] = get_stylesheet_directory() . '/lib/acf-json';
	// return
	return $paths;
});

