<?php
/**
 * Enqueue site scripts and styles
 */
function medishop_scripts() {

    /**
     * Enqueueing Stylesheets
     */
	wp_enqueue_style( 'medishop-fonts', medishop_fonts_url() );
	wp_enqueue_style( 'mediaelementplayer', MEDISHOP_VEND . '/media-player/mediaelementplayer.css' );
	wp_enqueue_style( 'fontawesome', MEDISHOP_VEND . '/fontawesome-free-6.0.0-web/css/all.min.css' );
	wp_enqueue_style( 'icomoon-theme', MEDISHOP_VEND . '/icomoon/style.css' );
	wp_enqueue_style( 'nice-select', MEDISHOP_VEND . '/nice-select/nice-select.css' );
	wp_enqueue_style( 'bootstrap', MEDISHOP_CSS . '/bootstrap.min.css' );
	wp_enqueue_style( 'medishop-woocommerce', MEDISHOP_CSS . '/woocommerce.min.css' );
	wp_enqueue_style( 'medishop-main-style', get_theme_file_uri('/assets/css/style.min.css'), array(), MEDISHOP_VERSION );
	wp_enqueue_style( 'medishop-custom-style', get_theme_file_uri('/assets/css/custom.css'), array(), MEDISHOP_VERSION );

	wp_enqueue_style( 'medishop-root', get_stylesheet_uri(), array(), MEDISHOP_VERSION );
    wp_style_add_data( 'medishop-root', 'rtl', 'replace' );


    /**
     * Enqueueing Scripts
     */
	wp_enqueue_script( 'mediaelement-and-player', MEDISHOP_VEND. '/media-player/mediaelement-and-player.min.js', array('jquery'), '4.2.6', true );
	wp_enqueue_script( 'parallaxie', MEDISHOP_VEND. '/parallax/parallaxie.js', array('jquery'), '0.5', true );
	wp_enqueue_script( 'nice-select', MEDISHOP_VEND. '/nice-select/jquery.nice-select.min.js', array('jquery'), '0.5', true );
	wp_enqueue_script( 'medishop-main-js', MEDISHOP_JS . '/main.js', array('jquery'), MEDISHOP_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'medishop_scripts' );