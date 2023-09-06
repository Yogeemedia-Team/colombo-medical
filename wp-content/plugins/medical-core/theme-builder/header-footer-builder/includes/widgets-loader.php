<?php
namespace DroitHead\Includes;
defined( 'ABSPATH' ) || exit;

class Widgets_Loader{

    private static $instance;
    
    private static $elementor;

    private $widgets = [];

    public function load(){
        $this->widgets = apply_filters('drdt_header_widgets', [
            'nav-menu' => 'Nav menu',
            'site-logo' => 'Site Logo',
            'back-to-top' => 'Back To Top',
            'search-bar' => 'Search Bar',
            'hover-thumbnails-mega-menu' => 'Mega Menu',
        ]);

        // checking elementor widgets
        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {

            self::$elementor = \Elementor\Plugin::instance();
            
        add_action( 'elementor/elements/categories_registered', [$this, 'register_category' ] );
        add_action( 'elementor/widgets/register', [$this, 'register_widgets' ] );

        }
        
    }



    public function register_category( $categories ) {
		$category = __( 'Droit Header & Footer', 'droithead' );
		$categories->add_category(
			'drit-header-footer',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);
		return $categories;
    }

    public function register_widgets( $widgets_manager ){
        foreach($this->widgets as $k=>$v){
            $files = __DIR__ . '/widgets/'.$k.'.php';
            if( !is_readable($files) || !is_file($files) ){
                continue;
            }
            require_once( $files );
            $clsssName = str_replace([' ', '-', ''], '_', ucwords(str_replace([' ', '-', ''], ' ', $k)) );
            $class = "\Elementor\DRDT_".$clsssName;
            if( class_exists($class) ){
                $widgets_manager->register( new $class()  );
            }
        }
    }

    public static function _instance(){
        if( is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}