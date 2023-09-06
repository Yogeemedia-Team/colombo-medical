<?php 
get_header();

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

if(class_exists('\Elementor\Plugin')) {
    $pluginElementor = \Elementor\Plugin::instance();
    echo $contentElementor = $pluginElementor->frontend->get_builder_content($post_id);
}


get_footer();