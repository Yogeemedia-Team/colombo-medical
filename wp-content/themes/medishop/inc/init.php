<?php 


require MEDISHOP_THEMEROOT_DIR . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/template-functions.php';
/**
 * Medishop helper 
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/helper.php';

/**
 * Medishop comment area
*/
require MEDISHOP_THEMEROOT_DIR.'/inc/classes/comment_walker.php';
/**
 * Medishop nav walker
*/
require MEDISHOP_THEMEROOT_DIR.'/inc/classes/main-nav-walker.php';
/**
 * Customizer additions.
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/customizer.php';

/**
 * Medishop Enqueue 
 */

require MEDISHOP_THEMEROOT_DIR . '/inc/static_enqueue.php';

/**
 * Medishop Admin Enqueue 
 */

require MEDISHOP_THEMEROOT_DIR . '/inc/admin_enqueue.php';


/**
 * Medishop breadcrumbs
 */

require MEDISHOP_THEMEROOT_DIR . '/inc/breadcrumbs.php';

/**
 * Medishop Tgm
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/plugin_activation.php';


/**
 * Medishop Demo import
 */
require MEDISHOP_THEMEROOT_DIR . '/inc/one_click_demo_config.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require MEDISHOP_THEMEROOT_DIR . '/inc/jetpack.php';
}

/**
 * WooCommerce functilly 
 */

	require MEDISHOP_THEMEROOT_DIR . '/inc/woo/woocommerce.php';
