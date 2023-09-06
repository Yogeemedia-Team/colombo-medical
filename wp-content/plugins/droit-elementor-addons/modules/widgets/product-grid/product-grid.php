<?php
namespace DROIT_ELEMENTOR\Widgets;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Product_grid extends \Elementor\Widget_Base {

    public function get_name()
    {
        return 'droit-product-grid';
    }

    public function get_title()
    {
        return esc_html__('Product Grid', 'droit-addons');
    }

    public function get_icon()
    {
        return 'eicon-products addons-icon';
    }

    public function get_categories()
    {
        return ['droit_addons'];
    }

    public function get_keywords() {
        return [
            'product Grid heading',
            'heading',
            'Product_grid Product_grid',
            'Product_grid text',
            'toggle',
            'droit woo list',
            'dl woo Grid',
            'dl advanced woo Grid',
            'panel',
            'navigation',
            'group',
            'woo list content',
            'product woo Grid',
            'droit',
            'dl',
            'addons',
            'addon'
        ];
    }
    

    protected function register_controls()
    {
        if( class_exists('\Woocommerce') ){
            $this->start_controls_section(
                '_dl_product_grid_query_section',
                [
                    'label' => esc_html__('Query Settings', 'droit-addons'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                '_dl_product_grid_per_page', [
                    'label' => esc_html__('Per Page', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Enter Number', 'droit-addons'),
                    'default' => 3,
                ]
            );

            $this->add_control(
                '_dl_product_grid_order_by',
                [
                    'label' => __('Order By', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'modified' => __('Modified', 'droit-addons'),
                        'date' => __('Date', 'droit-addons'),
                        'rand' => __('Rand', 'droit-addons'),
                        'ID' => __('ID', 'droit-addons'),
                        'title' => __('Title', 'droit-addons'),
                        'author' => __('Author', 'droit-addons'),
                        'name' => __('Name', 'droit-addons'),
                        'parent' => __('Parent', 'droit-addons'),
                        'menu_order' => __('Menu Order', 'droit-addons'),
                    ],
                ]
            );
            $this->add_control(
                '_dl_product_grid_order',
                [
                    'label' => __('Order', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'ase',
                    'options' => [
                        'ase' => __('Ascending Order', 'droit-addons'),
                        'desc' => __('Descending Order', 'droit-addons'),
                    ],
                ]
            );

            $this->add_responsive_control(
                '_dl_product_woocommerces_per_row',
                [
                    'label' => __( 'Posts Per Row', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '12'  => __( '01', 'droit-addons' ),
                        '6' => __( '02', 'droit-addons' ),
                        '4' => __( '03', 'droit-addons' ),
                        '3' => __( '04', 'droit-addons' ),
                        '2' => __( '06', 'droit-addons' ),
                    ],
                ]
            );
            $this->end_controls_section(); 
            
            
            // start content box style
            $this->start_controls_section(
                '_dl_product_grid_content_style_section',
                [
                    'label' => __( 'Content Box', 'droit-addons' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    
                ]
            );

            
            $this->add_control(
                'dl_product_grid_all_alignment',
                [
                    'label'     => __('Content Alignment', 'droit-addons'),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'   => [
                            'title' => __('Left', 'droit-addons'),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'droit-addons'),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'  => [
                            'title' => __('Right', 'droit-addons'),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_info'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => '_dl_product_grid_product_content_background',
                    'label' => __( 'Background', 'droit-addons' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .dl_product_grid',
                ]
            );
            $this->add_responsive_control(
                '_dl_product_grid_product_content_margin',
                [
                    'label' => esc_html__('Margin', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                '_dl_product_grid_product_content_padding',
                [
                    'label' => esc_html__('Padding', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => '_dl_product_grid_product_content_border',
                    'label' => esc_html__('Border', 'droit-addons'),
                    'selector' => '{{WRAPPER}} .dl_product_grid',
                ]
            );

            $this->add_responsive_control(
                '_dl_product_grid_product_content_Radious',
                [
                    'label' => esc_html__('Border Radius', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    ],
                ]
            );

            $this->end_controls_section();
            // End Contain Box Style 


            //  badge style
            $this->start_controls_section(
                '_dl_product_grid_badge_style_section',
                [
                    'label' => __( 'Badge', 'droit-addons' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    
                ]
            );

            $this->add_control(
                'dl_item_position',
                [
                    'label'        => __( 'Offset', 'droit-addons' ),
                    'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                    'label_off'    => __( 'Default', 'droit-addons' ),
                    'label_on'     => __( 'Custom', 'droit-addons' ),      
                    'return_value' => 'yes',
                ]
            );
    
            $this->start_popover();
    
            $this->add_responsive_control(
                'dl_offset_x',
                [
                    'label' => __( 'Offset', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                        'vw' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                        'vh' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'size' => '0',
                    ],
                    'size_units' => [ 'px', '%', 'vw', 'vh' ],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_img .onsale' => 'left: {{SIZE}}{{UNIT}}',
                    ],
                                       
                ]
            );
    
            $this->add_responsive_control(
                'dl_offset_y',
                [
                    'label' => __( 'Offset', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                        'vh' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                        'vw' => [
                            'min' => -200,
                            'max' => 200,
                        ],
                    ],
                    'size_units' => [ 'px', '%', 'vh', 'vw' ],
                    'default' => [
                        'size' => '0',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_img .onsale' => 'top: {{SIZE}}{{UNIT}}',
                    ]
                    ]
                );
           
            $this->end_popover();

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'dl_product_list_badge_typography',
                    'label' => __( 'Typography', 'droit-addons' ),
                    'selector' => '{{WRAPPER}} .dl_product_grid .onsale',
                ]
            );

            $this->add_responsive_control(
                '_dl_product_grid_badge_position_padding',
                [
                    'label' => esc_html__('Padding', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid > .dl_product_img .onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => '_dl_product_grid_badge_position_border',
                    'label' => esc_html__('Border', 'droit-addons'),
                    'selector' => '{{WRAPPER}} .dl_product_grid > .dl_product_img .onsale',
                ]
            );
            
            $this->add_responsive_control(
                '_dl_product_grid_badge_border_Radious',
                [
                    'label' => esc_html__('Border Radius', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid > .dl_product_img .onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => '_dl_product_grid_button_background',
                    'label' => __( 'Background', 'droit-addons' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .dl_product_grid > .dl_product_img .onsale',
                ]
            );

            $this->add_control(
                '_dl_product_grid_button_color',
                [
                    'label' => __( 'Color', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid > .dl_product_img .onsale' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_section();

            // style Thumbnail Images Style 
            $this->start_controls_section(
                '_dl_product_grid_feature_image_style',
                [
                    'label' => esc_html__('Thumbnail', 'droit-addons'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
            if( did_action('droitPro/loaded') ){
                $this->add_group_control(
                    \DROIT_ELEMENTOR_PRO\DL_Image::get_type(),
                    [
                        'name' => '_dl_product_grid_feature_image_setting',
                        'label' => __('Image Setting', 'droit-addons'),
                        'selector' => '{{WRAPPER}} .dl_product_grid .dl_product_img img',
                        'fields_options' => [
                            'image_setting' => [
                                'default' => '',
                            ],
                            '_dl_product_grid_feature_image_setting' => 'custom',
                            'image_width' => [
                                'default' => [
                                    'size' => '',
                                    'unit' => 'px',
                                ],
                            ],
                        ],
            
                    ]
                );
            }

            $this->add_responsive_control(
                '_dl_product_grid_feature_image_spacing',
                [
                    'label' => __('Space', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_img img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->end_controls_section();
            // End Thumbnail Controls

            // Title Style 
            $this->start_controls_section(
                '_dl_product_grid_title_style_section',
                [
                    'label' => esc_html__('Title', 'droit-addons'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'dl_product_grid_title_typography',
                    'label' => __( 'Typography', 'droit-addons' ),
                    'selector' => '{{WRAPPER}} .dl_product_info .dl_product_name',
                ]
            );
            $this->add_control(
                'dl_product_grid_title_color',
                [
                    'label' => __( 'Color', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_info .dl_product_name a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_responsive_control(
                'dl_product_grid_title_padding',
                [
                    'label' => esc_html__('Padding', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_info .dl_product_name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->end_controls_section();

            // Start Price Style 
            $this->start_controls_section(
                'dl_product_grid_price_section',
                [
                    'label' => __( 'Price Style', 'droit-addons' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_product_grid_price_typography',
                'label' => __( 'Typography', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_product_grid p.dl_price span.price',
            ]
            );
        
            $this->add_control(
                'dl_product_list_price_color',
                [
                    'label' => __( 'Regular Price Color', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} span.price del' => 'color: {{VALUE}}',
                    ],
                ]
                );
    
                $this->add_control(
                    'dl_product_list_ins_price_color',
                    [
                        'label' => __( 'Discount Price Color', 'droit-addons' ),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} span.price ins' => 'color: {{VALUE}}',
                        ],
                    ]
                );

            $this->add_control(
            'dl_product_grid_price_spacing',
            [
                'label' => __( 'Spacing', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_product_grid p.dl_price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
            );
            $this->end_controls_section();
            // End Price Style

            $this->start_controls_section(
                'dl_product_list_desc_section',
                [
                    'label' => __( 'Description Style', 'droit-addons' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'dl_product_grid_show_desc',
                [
                    'label'        => __( 'Show Description', 'droit-addons' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Show', 'droit-addons' ),
                    'label_off'    => __( 'Hide', 'droit-addons' ),
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'dl_product_list_desc_typography',
                    'label' => __( 'Typography', 'droit-addons' ),
                    'selector' => '{{WRAPPER}} p.dl_product_desc',
                ]
                );
            
                $this->add_control(
                'dl_product_list_desc_color',
                [
                    'label' => __( 'Color', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} p.dl_product_desc' => 'color: {{VALUE}}',
                    ],
                ]
                );

                $this->add_control(
                    'dl_product_list_desc_spacing',
                    [
                        'label' => __( 'Spacing', 'droit-addons' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 20,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} p.dl_product_desc' => 'display: block; margin-bottom: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                    );



            $this->end_controls_section();

            // Start Button Style 
            $this->start_controls_section(
                'dl_product_grid_button_section',
                [
                    'label' => __( 'Cart Button', 'droit-addons' ),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'dl_product_show_cart_button',
                [
                    'label'        => __( 'Show Cart', 'droit-addons' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Show', 'droit-addons' ),
                    'label_off'    => __( 'Hide', 'droit-addons' ),
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->start_controls_tabs(
                '_dl_product_grid_cart_style_tabs'
            );

            $this->start_controls_tab(
                '_dl_product_grid_cart_normal_tab',
                [
                    'label' => __( 'Normal', 'droit-addons' ),
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => '_dl_product_grid_cart_button_background',
                    'label' => __( 'Background', 'droit-addons' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a',
                ]
            );
            $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_product_grid_cart_typography',
                'label' => __( 'Typography', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a',
            ]
            );
        
            $this->add_control(
            'dl_product_grid_cart_color',
            [
                'label' => __( 'Color', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a.added_to_cart.wc-forward' => 'color: {{VALUE}}',
                ],
            ]
            );
            $this->add_control(
                'dl_product_grid_cart_alignment',
                [
                    'label'     => __('Text Alignment', 'droit-addons'),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'   => [
                            'title' => __('Left', 'droit-addons'),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'droit-addons'),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'  => [
                            'title' => __('Right', 'droit-addons'),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_add_cart'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                '_dl_product_grid_button_margin',
                [
                    'label' => esc_html__('Margin', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_add_cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                '_dl_product_grid_button_padding',
                [
                    'label' => esc_html__('Padding', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => '_dl_product_grid_button_border',
                    'label' => esc_html__('Border', 'droit-addons'),
                    'selector' => '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a',
                ]
            );
            $this->add_responsive_control(
                '_dl_product_grid_button_border_Radious',
                [
                    'label' => esc_html__('Border Radius', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    ],
                ]
            );
            $this->end_controls_tab();

            $this->start_controls_tab(
                'dl_product_grid_button_hover_style',
                [
                    'label' => __( 'Hover', 'droit-addons' ),
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => '_dl_product_grid_cart_button_hover_background',
                    'label' => __( 'Background', 'droit-addons' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a:hover',
                ]
            );
        
            $this->add_control(
            'dl_product_grid_cart_hover_color',
            [
                'label' => __( 'Color', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a:hover' => 'color: {{VALUE}}',
                ],
            ]
            );

            $this->add_control(
                'dl_product_grid_cart_hover_border_color',
                [
                    'label' => __( 'Border Color', 'droit-addons' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .dl_product_grid .dl_product_add_cart a:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
                );
            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->end_controls_section();
            // End Button Style 

         // end all controls
        }else{

            $this->start_controls_section(
				'_section_woo',
				[
					'label' =>  __( 'Missing Notice', 'droit-addons' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'_woo_missing_notice',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						__( 'Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'droit-addons' ),
						'<a href="'.esc_url( admin_url( 'plugin-install.php?s=Woocommerce&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Woocommerce</a>',
						\wp_get_current_user()->display_name
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
				$link = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
			}else{
				$link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
			}

			$this->add_control(
				'_dl_woolist_install',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<a href="'. $link .'" target="_blank" rel="noopener">Click to install or activate Woocommerce</a>',
				]
			);
			$this->end_controls_section();
        }

    }

    //Html render
    protected function render(){

        $settings = $this->get_settings_for_display();
        extract($settings);
        if( class_exists('\Woocommerce') ){
        $post_query = new \WP_Query( array(
		    'post_type'      => 'product',
		    'posts_per_page' => $settings['_dl_product_grid_per_page'],
		    'order'          => $settings['_dl_product_grid_order'],
            'orderby'          => $settings['_dl_product_grid_order_by'],
		    'post__not_in'   => ! empty( $settings['exclude'] ) ? explode( ',', $settings['exclude'] ) : ''
	    ) );
        ?>
        <div class="dl_row">
        <?php
            if ( $post_query->have_posts() ) {
            while( $post_query->have_posts()) : 
                $post_query->the_post();
                global $product;
            ?>

            <div class="dl_col_lg_<?php echo $settings['_dl_product_woocommerces_per_row']; ?> dl_col_sm_6">
                <div class="dl_product_grid">
                        <a href="<?php the_permalink();?>" class="dl_product_img">
                            <?php  the_post_thumbnail( 'Full' ); ?>
                            <?php woocommerce_show_product_loop_sale_flash(); ?>
                        </a>
                    <div class="dl_product_info">
                        <h4 class="dl_product_name"> <a href="<?php the_permalink();?>"><?php echo get_the_title();?></a></h4>
                        <p class="dl_price"><?php woocommerce_template_loop_price(); ?></p>
                        <?php if( $dl_product_grid_show_desc === 'yes' ): ?>
                            <p class="dl_product_desc"><?php echo get_the_excerpt(); ?></p>
                        <?php endif; ?>
                        <?php if( $dl_product_show_cart_button === 'yes' ): ?>
                            <div class="dl_product_add_cart">
                                <?php
                                $arg['class'] = implode( ' ', [
                                    'button',
                                    'product_type_' . $product->get_type(),
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                    'droit_add_to_cart'
                                ]);
                                woocommerce_template_loop_add_to_cart($arg);
                                ?>
                            </div>
                        <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        } 
        ?>          
        </div>
        <?php }else{ 
            echo esc_html__("Woocommerces Plugin not activated", 'droit-addons');
        } 
     }
        
    protected function content_template(){}
  }