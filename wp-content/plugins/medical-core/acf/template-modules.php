<?php 

add_action('admin_enqueue_scripts', 'saasland_admin_enqeuue_for_mega_menu');

function saasland_admin_enqeuue_for_mega_menu () {

    wp_enqueue_script('mega_menu_script', SAASLAND_CORE_DIR_JS.'/menu_setting.min.js', [ 'jquery' ]);
    
    global $post_type;

    if( 'droit-templates' == $post_type ){
        // load style
        wp_enqueue_style('dt-tempplate-admin', SAASLAND_CORE_DIR_CSS.'./template_admin.css');
        wp_enqueue_script('header-footer-control', SAASLAND_CORE_DIR_JS.'/template_admin.min.js', [ 'jquery' ]);
        wp_localize_script( 'header-footer-control', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
    }
}

//  Load Header Footer  Builder
require_once __DIR__.'/header-footer/droit-header-footer.php';

// Mega Menu select Control for ACF 
require_once __DIR__.'/mega-menu-select.php';

//  ACF icon fields 

require_once __DIR__.'/acf-icon-picker/acf-icon-fields.php';

//  height Nonce Menu
function wpse28782_remove_menu_items() {
    remove_menu_page( 'edit.php?post_type=none' );
}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );


add_action( 'wp_ajax_my_action', 'my_action' );

function my_action() {

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
         echo "<span>404 page Actice successfully</span>";
     }else{
         echo "<span>404 page deactived</span>";
     }

    wp_die();
}


add_filter( "404_template", 'load_our_custom_tax_template');

function load_our_custom_tax_template( $not_found_content) {

    $args = array(
        'numberposts' => 1,
        'post_type' => 'droit-templates',
        'meta_key'         => 'is_droit_404_active',
        'meta_value'       => 'yes',
    );
  
    $post_id = '';

    $get_post = get_posts($args);

    if(!empty( $get_post )) {
        $post_id = $get_post[0]->ID;
    }
    
    if(class_exists('\Elementor\Plugin') && '' != $post_id) {
         $not_found_content = dirname( __FILE__ ) . '/header-footer/includes/views/404.php';
    }
    return  $not_found_content;
}


