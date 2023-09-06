<?php


if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'ACF_ICOMOON_VER', '1.0.7' );
define( 'ACF_ICOMOON_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ICOMOON_DIR', plugin_dir_path( __FILE__ ) );

class acf_field_icomoon_plugin {

	/**
	 * Constructor.
	 *
	 * Load plugin's translation and register icomoon fields.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Register ACF fields
		add_action( 'acf/include_field_types', array( __CLASS__, 'register_field' ) );
	}

	/**
	 * Register Icomoon field for ACF v5.
	 *
	 * @since 1.0.0
	 */
	public static function register_field() {

		$enqueue_select2 = acf_get_setting( 'enqueue_select2' );
		if ( is_null( $enqueue_select2 ) ) {
			acf_update_setting( 'enqueue_select2', true );
		}

		$select2_version = acf_get_setting( 'select2_version' );
		if ( is_null( $select2_version ) ) {
			acf_update_setting( 'select2_version', 3 );
		}

		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-base-field.php' );
		include_once( ACF_ICOMOON_DIR . 'fields/icomoon-v5.php' );
	}
}

/**
 * Init plugin.
 *
 * @since 1.0.0
 */
function acf_field_icomoon_load() {
	new acf_field_icomoon_plugin();
}
add_action( 'plugins_loaded', 'acf_field_icomoon_load' );
