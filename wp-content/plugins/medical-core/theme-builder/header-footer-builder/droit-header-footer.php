<?php

// define the main file 
define( 'DROIT_HEAD_FILE_', __FILE__ );
 
// controller page
include 'controller.php';

// load of controller files
// after theme switch
add_action( 'after_switch_theme', 'drdt_head_active' );
// when plugin active
register_activation_hook(__FILE__, 'drdt_head_active');

function drdt_head_active(){
    $cpt_support = get_option( 'elementor_cpt_support', [ 'page', 'post', 'portfolio' ] );
    foreach ( $cpt_support as $cpt_slug ) {
        add_post_type_support( $cpt_slug, 'elementor' );
    }
    // add custom posttype
    if( !in_array('droit-templates', $cpt_support) ){
        add_post_type_support( 'droit-templates', 'elementor' );
        $cpt_support[] = 'droit-templates';
        update_option('elementor_cpt_support', $cpt_support);
        flush_rewrite_rules();
    }
   
}

function drdt_kses_html( $content = ''){
    return $content;
}

// load plugin
add_action( 'plugins_loaded', function(){
	// load text domain
	load_plugin_textdomain( 'droithead', false, basename( dirname( __FILE__ ) ) . '/languages'  );
	// load plugin instance
    \DroitHead\Dtdr_Controller::instance()->load();

    // load include
    \DroitHead\Includes\Dtdr_Load::_instance()->_init();

}, 10); 


add_action( 'wp_ajax_theme_404_page_active', 'theme_404_page_active' );

function theme_404_page_active() {

    //  get post current status 

        
    $args = array(
        'numberposts' => -1,
        'post__not_in' => array( $_POST['post_id'] ),
        'post_type' => 'droit-templates',
        'meta_key'         => 'is_droit_404_active',
        'meta_value'       => 'yes',
    );
  
    $post_id = [];
    $get_post = get_posts($args);
    foreach($get_post as $post) {
        $post_id[] =  $post->ID;
    }
    
    if(!empty($post_id)) {
        foreach($post_id as $id) {
            update_post_meta($id, 'is_droit_404_active', 'no');
        }
    }
    update_post_meta($_POST['post_id'], 'is_droit_404_active',  $_POST['status']);
     
     if($_POST['status'] == 'yes') {
           
         echo '<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                     404 page active successfully
                        <div class="mt-2 pt-2 border-top">
                        </div>
                    </div>
              </div>';
     }else{
         echo '<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="toast-body">
            404 page deactivated
             <div class="mt-2 pt-2 border-top">
             </div>
         </div>
   </div>';
     }

    wp_die();
}
