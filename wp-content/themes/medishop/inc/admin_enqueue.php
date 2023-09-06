<?php 
/**
 * Medishop admin Enqueue 
 */

add_action( 'admin_enqueue_scripts', 'medishop_admin_enqueues');

function medishop_admin_enqueues() {
  
    if(function_exists('get_current_screen')){
    
        $screen = get_current_screen(); 
        
        if ( $screen->base == 'toplevel_page_medishop_options' ) {
            wp_enqueue_style( 'medishop-redux-style', MEDISHOP_CSS.'/redux-style.css' );
        }
    }
    
}
