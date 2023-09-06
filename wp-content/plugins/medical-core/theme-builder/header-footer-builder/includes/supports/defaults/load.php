<?php
namespace DroitHead\Includes\Supports\Defaults;

defined( 'ABSPATH' ) || exit;

use \DroitHead\Includes\Supports\Support as Support;

class Load Extends Support{

    public static $instance;

    public function __construct(){
        
        if(  $this->get_method() == 'method2'){
            add_action( 'wp', [ $this, 'apply_method2' ] );
        } else {
            add_action( 'wp', [ $this, 'apply_method1' ] );
        }
        if($this->get_404_template() != '') {
            add_filter( "404_template", [$this, 'replace_404_page']);
          }

          
            add_action('__themename_banner', [$this, 'banner']);
        
    }
    public function banner() {
        $id = $this->get_templates('banner');
        if(!$id){
            get_template_part('template-parts/banner/banner', 'page');
        }
       echo drdt_kses_html(\Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id ) );
    }
    public function apply_method1(){
        // render header template
       //


    }
    
    public function apply_method2(){

       //
    }
    public function replace_404_page ( $templates ) {
       $templates = dirname( __FILE__ ) . '/404.php';
       return $templates;
   
      }
    public function replace_header(){
        require __DIR__ . '/header.php';

		$templates   = [];
		$templates[] = 'header.php';
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
        ob_get_clean();
        
    }

    public function replace_header_method2(){
        $templates   = [];
        $templates[] = 'header.php';
        locate_template( $templates, true );
        if ( ! did_action( 'wp_body_open' ) ) {
            did_action('droithead_header');
        }
    }

    public function replace_footer(){
        require __DIR__ . '/footer.php';

		$templates   = [];
		$templates[] = 'footer.php';
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();  
    }

    public function replace_footer_method2(){

    }


    public static function _instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }
}