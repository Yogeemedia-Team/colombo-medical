<?php
namespace Elementor;

if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Minicart extends \Elementor\Widget_Base{

    public function get_name()
    {
        return 'droit-minicart';
    }

    public function get_title()
    {
        return esc_html__('Mini Cart', 'droit-addons-pro');
    }

    public function get_icon()
    {
        return 'eicon-editor-list-ul addons-icon';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [
            'Woocommerces',
            'woocommerces',
            'WC',
            'Woocommerces post',
            'droit Woocommerces',
            'droit Woocommerces',
            'droit Woocommerces',
            'dl Woocommerces',
            'dl Woocommerces',
            'dl Woocommerces',
            'droit',
            'dl',
            'addons',
            'addon',
            'Mini Cart',
        ];
    }

    protected function register_controls()
    {

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        global $woocommerce;  
        ?>
        <div class="header-cart">
            <a class="cart-btn nav-link" href="<?php echo esc_url(wc_get_cart_url()); ?>"> <i class="icon-cart"></i><span class="num"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span></a>
            <div class="header-mini-cart">
                 <?php 
                  
                  if(function_exists('woocommerce_mini_cart')) {
                    woocommerce_mini_cart();
                  }
                 
                 ?>
          
            </div>
         </div>
        <?php 
    }

    protected function content_template()
    {}
}