<?php
// Header Section
Redux::set_section( 'medishop_opt', array(
    'title'            => esc_html__( 'Header', 'medishop' ),
    'id'               => 'header_settings_opt',
    'customizer_width' => '400px',
    'icon'             => 'dashicons dashicons-arrow-up-alt2',
));


// Logo
Redux::set_section( 'medishop_opt', array(
    'title'            => esc_html__( 'Logo', 'medishop' ),
    'id'               => 'upload_logo_opt',
    'subsection'       => true,
    'icon'             => '',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Upload logo', 'medishop' ),
            'subtitle'  => esc_html__( 'Upload here a image file for your logo', 'medishop' ),
            'id'        => 'logo',
            'type'      => 'media',
            'default'   => array(
                'url'   => MEDISHOP_IMAGES.'/default_logo/logo.svg'
            )
        ),

        array(
            'title'     => esc_html__( 'Sticky header logo', 'medishop' ),
            'id'        => 'sticky_logo',
            'type'      => 'media',
            'default'   => array(
                'url'   => MEDISHOP_IMAGES.'/default_logo/logo_sticky.svg'
            )
        ),

        array(
            'title'     => esc_html__( 'Retina Logo', 'medishop' ),
            'subtitle'  => esc_html__( 'The retina logo should be double (2x) of your original logo', 'medishop' ),
            'id'        => 'retina_logo',
            'type'      => 'media',
        ),

        array(
            'title'     => esc_html__( 'Retina Sticky Logo', 'medishop' ),
            'subtitle'  => esc_html__( 'The retina logo should be double (2x) of your original logo', 'medishop' ),
            'id'        => 'retina_sticky_logo',
            'type'      => 'media',
        ),

        array(
            'title'     => esc_html__( 'Logo dimensions', 'medishop' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload logo.', 'medishop' ),
            'id'        => 'logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array( 'em','px','%' ),
            'output'    => '.logo_info .navbar-brand img'
        ),

        array(
            'title'     => esc_html__( 'Padding', 'medishop' ),
            'subtitle'  => esc_html__( 'Padding around the logo. Input the padding as clockwise (Top Right Bottom Left)', 'medishop' ),
            'id'        => 'logo_padding',
            'type'      => 'spacing',
            'output'    => array( '.logo_info .navbar-brand img' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
        ),
    )
) );


/**
 * Menu Settings
 */
Redux::set_section( 'medishop_opt', array(
    'title'            => esc_html__( 'Header Styling', 'medishop' ),
    'id'               => 'header_styling_opt',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
         array(
            'id'       => 'search_icon_toggle',
            'type'     => 'button_set',
            'title'    => esc_html__('Show Search Icon', 'medishop'),
            'options' => array(
                'yes' => esc_html__('Yes', 'medishop'), 
                'no' => esc_html__('No', 'medishop'), 
             ), 
            'default' => 'yes'
        )

    )
));