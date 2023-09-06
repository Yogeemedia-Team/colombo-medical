<?php
// public function core
if( !function_exists('drdt_th_core')){
    function drdt_th_core(){
        $obj = new \stdClass();
        $obj->self = \TH_ESSENTIAL\DRTH_Plugin::instance();
        $obj->version = \TH_ESSENTIAL\DRTH_Plugin::version();
        $obj->url = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url();
        $obj->dir = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_dir();
        $obj->assets = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'assets/';
        $obj->js = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'assets/js/';
        $obj->css = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'assets/css/';
        $obj->vendor = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'assets/vendor/';
        $obj->images = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'assets/images/';
        $obj->elementor = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'elementor/';
        $obj->elementor_dir = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_dir() . 'elementor/';
        $obj->framework = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'framework/';
        $obj->framework_dir = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_dir() . 'framework/';
        $obj->posttype = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'posttype/';
        $obj->posttype_dir = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_dir() . 'posttype/';
        $obj->core = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_url() . 'core/';
        $obj->core_dir = \TH_ESSENTIAL\DRTH_Plugin::dtdr_th_dir() . 'core/';
    
        $obj->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        $obj->minify = '.min';
        
        return $obj;
    }
}

//  mini card load 

add_filter( 'woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment', 30, 1 );
function header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start();

    ?>
    <a class="cart-btn nav-link" href="<?php echo esc_url(wc_get_cart_url()); ?>"> <i class="icon-cart"></i><span class="num"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span></a>
    <?php
    $fragments['a.cart-btn'] = ob_get_clean();

    return $fragments;
}
//  mini cart
add_filter( 'woocommerce_add_to_cart_fragments', 'medisho_mini_cart_ajax_content', 10, 1 );

function medisho_mini_cart_ajax_content( $fragments ) {
	if(!empty(WC()->cart->get_cart_contents_count())){

		ob_start();
		echo '<div class="header-mini-cart">';
		woocommerce_mini_cart();
		echo '</div>';
		$fragments['div.header-mini-cart'] = ob_get_clean();
	}
    
    return $fragments;
    
}

if(!function_exists( 'woocommerce_mini_cart')) {
    function woocommerce_mini_cart( $args = array() ) {

		$defaults = array(
			'list_class' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		wc_get_template( 'cart/mini-cart.php', $args );
	}
}