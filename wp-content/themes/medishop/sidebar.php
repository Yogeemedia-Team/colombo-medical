<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package medishop
 */

if ( ! is_active_sidebar( 'blog_sidebar' ) ) {
	return;
}
// shop_sidebar

$sidebar = 'blog_sidebar';
$sidbar_class = 'widget-area col-lg-4 sidebar_right blog';
if(function_exists('is_woocommerce') && is_woocommerce()) {
	$sidebar = 'shop_sidebar';
	$sidbar_class = 'widget-area col-lg-3 sidebar_right shop';
}
?>
<aside id="secondary" class="<?php echo esc_attr($sidbar_class,'medishop'); ?>">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- #secondary -->
