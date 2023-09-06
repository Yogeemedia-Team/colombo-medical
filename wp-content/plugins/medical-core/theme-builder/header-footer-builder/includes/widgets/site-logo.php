<?php
namespace Elementor;

defined( 'ABSPATH' ) || exit;

class DRDT_Site_Logo Extends Widget_Base{
    
    public function get_name() {
		return 'drdt-sitelogo';
    }

    public function get_title() {
		return __( 'medishop Menu Logo', 'medishop-core' );
    }
    
    public function get_icon() {
		return 'eicon-image';
	}

    public function get_categories() {
		return ['drth_custom_theme'];
    }
    
    public function get_script_depends() {
		return [];
	}

    protected function register_controls() {
		$this->render_content_section();
	}
    
    public function render_content_section(){
        
        $this->start_controls_section(
			'drdt_site_logo_sections',
			[
				'label' => __( 'Logo', 'medishop-core' ),
			]
		);

		$this->add_control(
			'drdt_logo_custom',
			[
				'label' => esc_html__( 'Use Custom Logo', 'medishop-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'medishop-core' ),
				'label_off' => esc_html__( 'No', 'medishop-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
      
        $this->add_control(
			'main_logo',
			[
				'label'     => __( 'Main Logo', 'medishop-core' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'condition' => [
                    'drdt_logo_custom' => 'yes'
                ]
			]
		);

        $this->add_control(
			'sticky_logo',
			[
				'label'     => __( 'Sticky Logo', 'medishop-core' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'condition' => [
                    'drdt_logo_custom' => 'yes'
                ]
			]
		);

        $this->add_control(
            'logo_max_width',
            [
                'label' => __( 'Max Width', 'medishop-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .drdt_custom_site_logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'main_logo_alignment',
            [
                'label' => __( 'Alignment', 'medishop-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'medishop-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'medishop-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'medishop-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}}  .drdt_site_logo' => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings         = $this->get_settings_for_display();
        extract($settings);
        $opt = get_option('medishop_opt');
        $logo = isset( $opt['logo']['url'] ) ? $opt['logo']['url'] : MEDISHOP_IMAGES.'/default_logo/logo.png';
        $logo_sticky = isset( $opt['sticky_logo']['url'] ) ? $opt['sticky_logo']['url'] : MEDISHOP_IMAGES.'/default_logo/logo.png';

    ?>
    <?php
     if($settings['drdt_logo_custom'] == 'yes') {
    ?>
    <div class="drdt_site_logo">
        <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="drdt_custom_site_logo">
        <img class="main_logo" src="<?php echo esc_url($main_logo['url']); ?>">
        <img class="sticky_logo" src="<?php echo esc_url($sticky_logo['url']); ?>">
        </a>
    </div>
    <?php 
     }else{
    ?>
    <div class="drdt_site_logo">
        <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="drdt_custom_site_logo">
        <img class="main_logo" src="<?php echo esc_url($logo); ?>">
        <img class="sticky_logo" src="<?php echo esc_url($logo_sticky); ?>">
        </a>
    </div>
    <?php 
     }
    ?>
    <?php

    }
}