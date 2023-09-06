<?php
namespace DROIT_ELEMENTOR_PRO\Widgets;

use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Woo_Product_Brand extends \Elementor\Widget_Base {

    public function get_name() {
        return 'droit-woo-product-brand';
    }

    public function get_title() {
        return esc_html__('Product Brand', 'droit-addons-pro');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['droit_addons_pro'];
    }

    public function get_keywords() {
        return [
            'Woocommerces',
            'woocommerces',
            'WC',
            'Woocommerces Category Grid',
            'Woocommerces Woo Product Category Grid',
            'woocommerces woo grid',
            'woo-cat-grid',
            'woo-product-cat-grid',
            'wc grid',
            'wc product cart grid',
            'wc product category grid',
            'category grid',
            'WC grid',
            'category grid',
            'droit Woocommerces',
            'dl Woocommerces',
            'droit',
            'dl',
            'addons',
            'addon',
            'pro',
        ];
    }

    protected function register_controls() {
        do_action('dl_widgets/woo-product-cat-grid/register_control/start', $this);

        if( class_exists('\Woocommerce') ){
            

        } else {
            $this->start_controls_section(
				'_section_woo',
				[
					'label' =>  __( 'Missing Notice', 'droit-addons-pro' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'_woo_missing_notice',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						__( 'Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'droit-addons-pro' ),
						'<a href="'.esc_url( admin_url( 'plugin-install.php?s=Woocommerce&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Woocommerce</a>',
						\wp_get_current_user()->display_name
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
				$link = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
			}else{
				$link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
			}

			$this->add_control(
				'_dl_woolist_install',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<a href="'. $link .'" target="_blank" rel="noopener">Click to install or activate Woocommerce</a>',
				]
			);
			$this->end_controls_section();
        }
       
        do_action('dl_widgets/woo-product-cat-grid/register_control/end', $this);

        do_action('dl_widget/section/style/custom_css', $this);
    }


    // define get query settings
    public function get_query_settings() {
		$settings = $this->get_settings_for_display();
        extract($settings);
	}

    // define rander preview
    protected function render() {

        $settings = $this->get_settings_for_display();
        extract($settings);

		$program_cats = get_terms(array(
			'taxonomy' => 'pwb-brand',
			'hide_empty' => true
		));

		if(is_array($program_cats)) {
			foreach ( $program_cats as $brand ) { 
				$brandLogo = get_term_meta( $brand->term_id, 'pwb_brand_image', true );
           		 $brandLogo = wp_get_attachment_url( $brandLogo );
			?>
			<div class="brand-logo">
				<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'pwb-brand' ) ); ?>">
					<img src="<?php echo $brandLogo;  ?>" alt="<?php echo $brand->name ?>">
				</a>
			</div>
			<?php
			}
		} 

    }

    
}