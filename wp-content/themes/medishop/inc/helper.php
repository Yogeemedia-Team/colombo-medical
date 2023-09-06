<?php 

/**
 * helper function for medishop 
 */

 /**
  * medishop return 
  */

if ( !function_exists('medishop_return') ) {

    function medishop_return( $html ){
        return $html;
    }
}

/**
 * Get editor data 
 */
if ( !function_exists('medishop_editor_data') ) {

    function medishop_editor_data( $data ) {
        return wp_kses_post( $data );
    }

}


/*
 * Resize media image 
 * To get instant resize 
 */

if ( !function_exists('medishop_get_image') ) {

    function medishop_get_image( $id, $size = 'full', $icon= false,  $attr = '') {
       
       echo  wp_get_attachment_image($id, $size, $icon, $attr);

    }
    
}

/**
 * medishop kses
 */
if ( !function_exists('medishop_kses') ) {

    function medishop_kses ( $data ) {

        $allowed_tags = array(
            'a'								 => array(
                'class'	 => array(),
                'href'	 => array(),
                'rel'	 => array(),
                'title'	 => array(),
            ),
            'abbr'							 => array(
                'title' => array(),
            ),
            'b'								 => array(),
            'blockquote'					 => array(
                'cite' => array(),
            ),
            'cite'							 => array(
                'title' => array(),
            ),
            'code'							 => array(),
            'del'							 => array(
                'datetime'	 => array(),
                'title'		 => array(),
            ),
            'dd'							 => array(),
            'div'							 => array(
                'class'	 => array(),
                'title'	 => array(),
                'style'	 => array(),
            ),
            'dl'							 => array(),
            'dt'							 => array(),
            'em'							 => array(),
            'h1'							 => array(),
            'h2'							 => array(),
            'h3'							 => array(),
            'h4'							 => array(),
            'h5'							 => array(),
            'h6'							 => array(),
            'i'								 => array(
                'class' => array(),
            ),
            'img'							 => array(
                'alt'	 => array(),
                'class'	 => array(),
                'height' => array(),
                'src'	 => array(),
                'width'	 => array(),
            ),
            'li'							 => array(
                'class' => array(),
            ),
            'ol'							 => array(
                'class' => array(),
            ),
            'p'								 => array(
                'class' => array(),
            ),
            'q'								 => array(
                'cite'	 => array(),
                'title'	 => array(),
            ),
            'span'							 => array(
                'class'	 => array(),
                'title'	 => array(),
                'style'	 => array(),
            ),
            'strike'						 => array(),
            'br'							 => array(),
            'strong'						 => array(),
            'data-wow-duration'				 => array(),
            'data-wow-delay'				 => array(),
            'data-wallpaper-options'		 => array(),
            'data-stellar-background-ratio'	 => array(),
            'ul'							 => array(
                'class' => array(),
            ),
        );
       
        return wp_kses($data, $allowed_tags);
    }
}

/**
 * get medishop option 
 */

if ( !function_exists('medishop_opt') ) {

    function medishop_opt ( $section_id, $default = '' ) {

        $medishop_option_data = $default;

        if ( class_exists( 'Redux' ) ) {

            global $medishop_opt;
            $medishop_option_data = (isset($medishop_opt[$section_id]) && (!empty($medishop_opt[$section_id]))) ? $medishop_opt[$section_id] : $default;

        }

        return $medishop_option_data;

    }

 }

 /**
 * get medishop option 
 */

if(!function_exists('medishop_page_meta')){

    function medishop_page_meta ( $meta_id, $id, $default = '' ) {

       $metadata =  $default; 

       if(function_exists('get_field')) {
         $metadata = (get_field($meta_id, $id) != '') ? get_field($meta_id, $id): $default;
       }
      
       return $metadata;

    }

 }

/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
function medishop_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = '';

    /* Body font */
    if (  'off' !== 'on'  ) {
        $fonts[] = "Poppins:400,500,600,700,800,900";
    }

    $is_ssl = is_ssl() ? 'https' : 'http';

    if ( $fonts ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts  ) ),
            'subset' => urlencode( $subsets ),
        ), "$is_ssl://fonts.googleapis.com/css" );
    }

    return $fonts_url;
}