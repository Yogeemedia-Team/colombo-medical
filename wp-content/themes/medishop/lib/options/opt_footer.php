<?php
Redux::set_section('medishop_opt', array(
	'title'     => esc_html__( 'Footer', 'medishop' ),
	'id'        => 'footer_settings_opt',
	'icon'      => 'dashicons dashicons-arrow-down-alt2',
));

// page Title Bar
Redux::set_section('medishop_opt', array(
	'title'         => esc_html__( 'Contents', 'medishop' ),
	'id'            => 'footer_contents_opt',
	'icon'          => '',
    'subsection'    => true,
	'fields'        => array(

	    array(
            'title'     => esc_html__('Copyright Text', 'medishop'),
            'id'        => 'footer_copyright_txt',
            'type'      => 'editor',
            'default'   => 'Copyright &copy; 2022 <a href="https://droitthemes.com/">DroitThemes</a> | All rights reserved',
            'args'      => array(
                'wpautop'       => true,
                'media_buttons' => false,
                'textarea_rows' => 10,
                'teeny'         => false,
            )
        ),
	)
));

