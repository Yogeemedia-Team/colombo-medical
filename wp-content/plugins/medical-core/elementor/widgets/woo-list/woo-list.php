<?php
namespace Elementor;

if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Woo_List extends \Elementor\Widget_Base{

    public function get_name()
    {
        return 'droit-woo-list';
    }

    public function get_title()
    {
        return esc_html__('Woo List', 'droit-addons-pro');
    }

    public function get_icon()
    {
        return 'eicon-editor-list-ul addons-icon';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [
            'Woocommerces',
            'woocommerces',
            'WC',
            'Woocommerces post',
            'Woocommerces Product',
            'post',
            'posts',
            'droit Woocommerces',
            'droit Woocommerces',
            'droit Woocommerces',
            'dl Woocommerces',
            'dl Woocommerces',
            'dl Woocommerces',
            'droit',
            'dl',
            'addons',
            'addon',
            'pro',
        ];
    }

    protected function register_controls()
    {
        do_action('dl_widgets/woo-list/register_control/start', $this);

        if( class_exists('\Woocommerce') ){
            // preset
            $this->__preset();
            // layout
            $this->__layout();

            // woo query
            $this->__query();

            // content order
            $this->__ordering_controls();

            // style control
            $this->__style();
        } else {
            $this->start_controls_section(
				'_section_woo',
				[
					'label' =>  __( 'Missing Notice', 'droit-addons-pro' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'_woo_missing_notice',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						__( 'Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'droit-addons-pro' ),
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
       
        do_action('dl_widgets/woo-list/register_control/end', $this);

        do_action('dl_widget/section/style/custom_css', $this);
    }

    //Preset
    protected function __preset()
    {
        $this->start_controls_section(
            '_dl_woo_preset_section',
            [
                'label' => __('Preset', 'droit-addons-pro'),
            ]
        );

        $this->add_control(
            '_dl_woo_skin',
            [
                'label' => esc_html__('Design Layout', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => false,
                'options' => apply_filters('dl_widgets/woo-list/pro/presets', [
                    '' => 'Default',
                ]),
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function __layout()
    {
        $this->start_controls_section(
            '_dl_woo_layout_section',
            [
                'label' => __('Layout', 'droit-addons-pro'),
            ]
        );

        $this->add_control(
            '_dl_woo_layout',
            [
                'label' => esc_html__('Layout', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => false,
                'options' => apply_filters('dl_widgets/woo-list/pro/presets', [
                    'dl_woo_top' => 'Default',
                    'dl_woo_left' => 'Left',
                    'dl_woo_right' => 'Right',
                    'dl_woo_bottom' => 'Bottom',
                ]),
                'default' => 'dl_woo_top',
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_specing',
            [
                'label' => __('Specing', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '10',
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper.dl_woo_left .dl_woolist_item_thumb' =>'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dl_pro_woolist_wrapper.dl_woo_right .dl_woolist_item_thumb' =>'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dl_pro_woolist_wrapper.dl_woo_top .dl_woolist_item_thumb' =>'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dl_pro_woolist_wrapper.dl_woo_bottom .dl_woolist_item_thumb' =>'margin-top: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );

        $this->add_control(
			'_dl_woolist_alignment',
			[
				'label' => __( 'Alignment', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'droit-addons-pro' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'droit-addons-pro' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'droit-addons-pro' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
                'default' => 'center',
				'toggle' => true,
                'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item' => 'align-items: {{VALUE}}; justify-content: {{VALUE}};',
				]
                
			]
		);

        $this->end_controls_section();
    }


    // woo Query
    protected function __query()
    {
        
        $this->start_controls_section(
            '_dl_woolist_query_section',
            [
                'label' => esc_html__('Query', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            '_dl_woolist_filter',
            array(
                'label' => __('Source', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post' => __('Recent Post', 'droit-addons-pro'),
                    'category' => __('Category Post', 'droit-addons-pro'),
                    'by_id' => __('Manual Selection', 'droit-addons-pro'),
                ],
                'default' => 'post',
            )
        );

        $this->add_control(
            '_dl_woolist_manual_include',
            [
                'label'       => __('Posts', 'droit-addons-pro'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'show_label'  => false,
                'label_block' => true,
                'multiple'    => true,
                'options'     => self::get_posts('product'),
                'condition'   => [
                    '_dl_woolist_filter' => ['by_id'],
                ],
            ]
        );

        $this->add_control('_dl_woolist_category',
            [
                'label' => esc_html__('Select Categories', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'default' => [],
                'options' => self::get_category('product_cat'),
                'condition' => [
                    '_dl_woolist_filter' => ['category'],
                ],
            ]
        );
        $this->add_control(
            '_dl_woolist_ignore_sticky_posts', [
                'label' => __('Ignore Sticky product', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __('Sticky-product ordering is visible on frontend only', 'droit-addons-pro'),
                'condition' => [
                    '_dl_woolist_filter!' => ['by_id'],
                ],
                'separator' => 'before',
                
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_per_page', [
                'label' => esc_html__('Per Page', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Enter Number', 'droit-addons-pro'),
                'default' => 3,
                'condition' => [
                    '_dl_woolist_filter!' => ['by_id'],
                ],
            ]
        );
        $this->add_control(
            '_dl_woolist_offset', [
                'label' => esc_html__('Offset', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'min' => '0',
                'label_block' => false,
                'description' => __('This option is used to exclude number of initial product from being display.)', 'droit-addons-pro'),
                'condition' => [
                    '_dl_woolist_filter!' => ['by_id'],
                ],
            ]
        );

        $this->add_control(
            '_dl_woolist_order_by',
            [
                'label' => __('Order By', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'modified' => __('Modified', 'droit-addons-pro'),
                    'date' => __('Date', 'droit-addons-pro'),
                    'rand' => __('Rand', 'droit-addons-pro'),
                    'ID' => __('ID', 'droit-addons-pro'),
                    'title' => __('Title', 'droit-addons-pro'),
                    'author' => __('Author', 'droit-addons-pro'),
                    'name' => __('Name', 'droit-addons-pro'),
                    'parent' => __('Parent', 'droit-addons-pro'),
                    'menu_order' => __('Menu Order', 'droit-addons-pro'),
                ],
                'condition' => [
                    '_dl_woolist_filter!' => ['by_id'],
                ],
            ]
        );
        $this->add_control(
            '_dl_woolist_order',
            [
                'label' => __('Order', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ase',
                'options' => [
                    'ase' => __('Ascending Order', 'droit-addons-pro'),
                    'desc' => __('Descending Order', 'droit-addons-pro'),
                ],
                'condition' => [
                    '_dl_woolist_filter!' => ['by_id'],
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_column', [
                'label' => esc_html__('Columns', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Enter Column', 'droit-addons-pro'),
                'default' => 3,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_row_gap',
            [
                'label' => __('Rows Spacing', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper.dl_woo_top .dl_woolist_item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_column_gap', [
                'label' => esc_html__('Columns Gap', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -0,
                        'max' => 2000,
                        'step' => 1,
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
                    '{{WRAPPER}} .dl_pro_woolist_wrapper' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __ordering_controls(){
        $this->start_controls_section(
            '_dl_woo_repeater_order_section',
            [
                'label' => esc_html__('Content', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            '_dl_woo_order_enable',
            [
                'label' => __('Enable', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        $repeater->add_control(
            '_dl_woo_order_label',
            [
                'label' => __('Label', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
            ]
        );
        $repeater->add_control(
            '_dl_woo_order_id',
            [
                'label' => __('Id', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
            ]
        );
        
        $this->add_control(
            '_dl_woo_ordering_data',
            [
                'label' => __('Re-order', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'item_actions' =>[
                    'duplicate' => false,
                    'add' => false,
                    'remove' => false
                ],
                'fields' => $repeater->get_controls(),
                'default' => [
                    
                    [
                        '_dl_woo_order_enable' => 'yes',
                        '_dl_woo_order_label' => 'Product Category',
                        '_dl_woo_order_id' => 'product_category',
                    ],
                    [
                        '_dl_woo_order_enable' => 'yes',
                        '_dl_woo_order_label' => 'Product Title',
                        '_dl_woo_order_id' => 'product_title',
                    ],
                    [
                        '_dl_woo_order_enable' => '',
                        '_dl_woo_order_label' => 'Product Content',
                        '_dl_woo_order_id' => 'product_content',
                    ],
                    [
                        '_dl_woo_order_enable' => 'yes',
                        '_dl_woo_order_label' => 'Price',
                        '_dl_woo_order_id' => 'product_price',
                    ],
                    [
                        '_dl_woo_order_enable' => 'yes',
                        '_dl_woo_order_label' => 'Rating',
                        '_dl_woo_order_id' => 'product_ratting',
                    ],
                    [
                        '_dl_woo_order_enable' => '',
                        '_dl_woo_order_label' => 'Meta',
                        '_dl_woo_order_id' => 'product_meta',
                    ],

                    [
                        '_dl_woo_order_enable' => '',
                        '_dl_woo_order_label' => 'Extra Info',
                        '_dl_woo_order_id' => 'extra_info',
                    ],
                    
                    [
                        '_dl_woo_order_enable' => 'yes',
                        '_dl_woo_order_label' => 'Buy now',
                        '_dl_woo_order_id' => 'product_button',
                    ],
                   
                ],
                'title_field' => '<i class="eicon-editor-list-ul"></i>{{{ _dl_woo_order_label }}}',
            ]
        );

        $this->add_control(
            '_dl_woolist_show_thumb',
            [
                'label' => __('Show Thumb', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_off' => __('Hide', 'droit-addons-pro'),
                'label_on' => __('Show', 'droit-addons-pro'),
            ]
        );
        $this->add_control(
            '_dl_woolist_show_badge',
            [
                'label' => __('Show Badge', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_off' => __('Hide', 'droit-addons-pro'),
                'label_on' => __('Show', 'droit-addons-pro'),
            ]
        );
        $this->add_control(
            '_dl_woolist_content_type',
            [
                'label' => __('Content Type', 'droit-addons-pro'),
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => ['excerpt'],
                'options' => [
                    'excerpt' => __('Excerpt', 'droit-addons-pro'),
                    'content' => __('Content', 'droit-addons-pro'),
                ],
            ]
        );
        $this->add_control(
            '_dl_woolist_excerpt_length',
            [
                'label' => __('Excerpt Length', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => apply_filters('excerpt_length', 40),
            ]
        );
        $this->add_control(
			'_dl_woolist_addcart_icon',
			[
				'label' => esc_html__( 'Icon', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-cart-plus',
                    'library' => 'solid',
				]
			]
		);

		$this->add_control(
			'_dl_woolist_addcart_icon_position',
			[
				'label' 	=> esc_html__( 'Position', 'droit-addons-pro' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> 'dlicon-left',
				'options' 	=> [
					'dlicon-left' 	=> esc_html__( 'Left', 'droit-addons-pro' ),
					'dlicon-right' => esc_html__( 'Right', 'droit-addons-pro' ),
				]
			]
		);

        $this->end_controls_section();
    }

    protected function __style(){

        //  General style
        $this->start_controls_section(
            '_dl_woolist_column_style_section',
            [
                'label' => __( 'General', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_control(
            'dl_woolist_title_alignment',
            [
                'label'     => __('Alignment', 'droit-addons'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item_content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_product_item_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item'
                
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_product_margin',
            [
                'label' => esc_html__('Margin', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_product_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_product_position_border',
                'label' => esc_html__('Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item',
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_product_border_Radious',
            [
                'label' => esc_html__('Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
        $this->end_controls_section();
        // End General Style 

        // start content box style
        $this->start_controls_section(
            '_dl_woolist_content_style_section',
            [
                'label' => __( 'Content Box', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_product_content_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item_content',
            ]
        );
        
        $this->add_responsive_control(
            '_dl_woolist_product_content_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_product_content_border',
                'label' => esc_html__('Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item_content',
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_product_content_Radious',
            [
                'label' => esc_html__('Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper .dl_woolist_item_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();
        // End Contain Box Style 

        
        //  badge style
        $this->start_controls_section(
			'_dl_woolist_badge_style_section',
			[
				'label' => __( 'Badge', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				
			]
		);

        $this->add_control(
			'_dl_woolist_badge_position_align',
			[
				'label' => __( 'Alignment', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
                        'icon'  => 'eicon-text-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'plugin-domain' ),
                        'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'toggle' => true,
				
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_woolist_badge_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale',
            ]
        ); 

        $this->add_responsive_control(
			'_dl_woolist_badge_position_height',
			[
				'label' => __( 'Height', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'height: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

        $this->add_responsive_control(
			'_dl_woolist_badge_position_width',
			[
				'label' => __( 'Width', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'width: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

        $this->add_responsive_control(
			'_dl_woolist_badge_position_top',
			[
				'label' => __( 'Top', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				],
				'condition' => [
					'_dl_woolist_badge_position_align!' => '',
				],
			]
		);

        $this->add_responsive_control(
			'_dl_woolist_badge_modal_position_left',
			[
				'label' => __( 'Left', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => [
					'_dl_woolist_badge_position_align' => ['left'],
				],
			]
		);
        $this->add_responsive_control(
			'_dl_woolist_badge_position_right',
			[
				'label' => __( 'Right', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
				'condition' => [
					'_dl_woolist_badge_position_align' => ['right'],
				],
			]
		);
        $this->add_responsive_control(
            '_dl_woolist_badge_position_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_badge_position_border',
                'label' => esc_html__('Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale',
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_badge_border_Radious',
            [
                'label' => esc_html__('Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => '_dl_woolist_button_background',
				'label' => __( 'Background', 'droit-addons-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale',
			]
		);
		$this->add_control(
			'_dl_woolist_button_color',
			[
				'label' => __( 'Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl_pro_woolist_wrapper > .dl_woolist_item .onsale' => 'color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        // End Badge Style 

        // style Thumbnail Images Style 
        $this->start_controls_section(
            '_dl_woolist_feature_image_style',
            [
                'label' => esc_html__('Thumbnail', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => '_dl_woolist_feature_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

        $this->add_group_control(
            \DROIT_ELEMENTOR_PRO\DL_Image::get_type(),
            [
                'name' => '_dl_woolist_feature_image_setting',
                'label' => __('Image Setting', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_thumb img',
                'fields_options' => [
                    'image_setting' => [
                        'default' => '',
                    ],
                    '_dl_woolist_feature_image_setting' => 'custom',
                    'image_width' => [
                        'default' => [
                            'size' => '',
                            'unit' => 'px',
                        ],
                    ],
                ],
    
            ]
        );

        $this->end_controls_section();
        // End Thumbnail Controls

        // Title Style 
        $this->start_controls_section(
            '_dl_woolist_title_style_section',
            [
                'label' => esc_html__('Title', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->start_controls_tabs('_dl_woolist_title_tabs');
    
        $this->start_controls_tab('_dl_woolist_title_normal_tab',
            [
                'label' => esc_html__('Normal', 'droit-addons-pro'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_woolist_title_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_title h2',
            ]
        );
        $this->add_control(
            'dl_woolist_title_color',
            [
                'label' => __( 'Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_title h2' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'dl_woolist_title_spacing',
            [
                'label' => __( 'Spacing', 'droit-addons-pro' ),
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
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_title h2' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       
        $this->end_controls_tab();
    
        $this->end_controls_tab();
    
        $this->start_controls_tab('_dl_woolist_title_hover',
            [
                'label' => esc_html__('Hover', 'droit-addons-pro'),
            ]
        );
        $this->add_control(
            '_dl_pro_woolist_hover_title_color',
            [
                'label' => __('Color', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_title h2:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
    
        $this->end_controls_tabs();
        $this->end_controls_section();
        // End Title Style 

        // Category Style 
        $this->start_controls_section(
            '_dl_woolist_category_style_section',
            [
                'label' => esc_html__('Category', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('_dl_woolist_cate_tabs');

        $this->start_controls_tab('_dl_woolist_cate_normal_tab',
            [
                'label' => esc_html__('Normal', 'droit-addons-pro'),
            ]
        );

        $this->add_control(
            'dl_woolist_category_spacing',
            [
                'label' => __( 'Category Spacing', 'droit-addons-pro' ),
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
                    '{{WRAPPER}} .dl_woolist_item_content .dl_post_category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dl_woolist_cate_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a',
            ]
        );
        
        $this->add_control(
            'dl_woolist_cate_color',
            [
                'label' => __( 'Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_woolist_cate_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
                'selector' => '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a',
            ]
        );
        
        $this->add_responsive_control(
            '_dl_woolist_category_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_category_border',
                'label' => esc_html__('Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a',
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_category_border_Radious',
            [
                'label' => esc_html__('Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tab();

        $this->start_controls_tab('_dl_woolist_cate_hover',
            [
                'label' => esc_html__('Hover', 'droit-addons-pro'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dl_woolist_cate_hover_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a:hover',
            ]
        );

        $this->add_control(
            '_dl_pro_woolist_hover_cate_color',
            [
                'label' => __('Color', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item_content .dl_post_category a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
        // End Category Style 


        // Start Content Style 
        $this->start_controls_section(
        'dl_woolist_content_section',
        [
            'label' => __( 'Content ', 'droit-addons-pro' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'dl_woolist_description_typography',
            'label' => __( 'Typography', 'droit-addons-pro' ),
            'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_content',
        ]
        );
    
        $this->add_control(
        'dl_woolist_description_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_content' => 'color: {{VALUE}}',
            ],
        ]
        );
        $this->add_control(
        'dl_woolist_description_spacing',
        [
            'label' => __( 'Spacing', 'droit-addons-pro' ),
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
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
        );
        $this->end_controls_section();
        // End Content Style 
        // Start Price Style 
        $this->start_controls_section(
            'dl_woolist_price_section',
            [
                'label' => __( 'Price ', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dl_woolist_price_position',
            [
                'label'     => __('Position', 'droit-addons'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'relative',
                'options' => [
					'relative'  => __( 'Relative', 'droit-addons-pro' ),
					'absolute' => __( 'Absolute', 'droit-addons-pro' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .dl_post_price .price'   => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_dl_woolist_price_icon_position',
            [
                'label' => __( 'Offset', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'droit-addons-pro' ),
                'label_on' => __( 'Custom', 'droit-addons-pro' ),
                'return_value' => 'yes',
                
            ]
        );

        $this->start_popover();

        $this->add_control(
            'dl_woolist_price_toggle_top',
            [
                'label' => __( 'Top', 'droit-addons-pro' ),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_post_price .price' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dl_woolist_price_toggle_left',
            [
                'label' => __( 'Left', 'droit-addons-pro' ),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_post_price .price' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->start_controls_tabs(
			'dl_woolist_price_section_tabs'
		);

		$this->start_controls_tab(
			'dl_woolist_price_section_normal_tab',
			[
				'label' => __( 'Regular Price', 'droit-addons-pro' ),
			]
		);

        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'dl_woolist_price_typography',
            'label' => __( 'Typography', 'droit-addons-pro' ),
            'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_price',
        ]
        );
    
        $this->add_control(
        'dl_woolist_regular_price_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.price del bdi' => 'color: {{VALUE}}',
                
            ],
        ]
        );

        $this->add_control(
        'dl_woolist_price_spacing',
        [
            'label' => __( 'Spacing', 'droit-addons-pro' ),
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
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_tab();

		$this->start_controls_tab(
			'dl_woolist_price_sales',
			[
				'label' => __( 'Sales Price', 'droit-addons-pro' ),
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_woolist_sales_price_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_price ins',
            ]
        );
    
        $this->add_control(
            'dl_woolist_sales_price_color',
            [
                'label' => __( 'Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.price > ins' => 'color: {{VALUE}}',
                    '{{WRAPPER}} span.price bdi' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dl_woolist_sales_price_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_price ins',
            ]
        );
        $this->add_responsive_control(
            'dl_woolist_sales_price_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_price ins' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        // End Price Style
        // Start Ratting Style 
        $this->start_controls_section(
            'dl_woolist_ratting_section',
            [
                'label' => __( 'Rating ', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'dl_woolist_ratting_style',
			[
				'label' => __( 'Rating Format', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'star',
				'options' => [
					'text'  => __( 'Text Format', 'droit-addons-pro' ),
					'star'  => __( 'Star Format', 'droit-addons-pro' ),
				],
			]
		);

        $this->add_control(
            'dl_woolist_ratting_alignment',
            [
                'label'     => __('Rating Alignment', 'droit-addons'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'   => [
                        'title' => __('Left', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'  => [
                        'title' => __('Right', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_ratting' => 'justify-content: {{VALUE}}; display:flex; align-items:center',
                ],
            ]
        );

        $this->start_controls_tabs(
			'dl_woolist_ratting_section_tabs'
		);

		$this->start_controls_tab(
			'dl_woolist_Ratting_section_normal_tab',
			[
				'label' => __( 'Text Format', 'droit-addons-pro' ),
			]
		);

        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'dl_woolist_ratting_typography',
            'label' => __( 'Typography', 'droit-addons-pro' ),
            'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_ratting',
        ]
        );
    
        $this->add_control(
        'dl_woolist_ratting_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_ratting' => 'color: {{VALUE}}',
            ],
        ]
        );
        $this->add_control(
        'dl_woolist_ratting_spacing',
        [
            'label' => __( 'Spacing', 'droit-addons-pro' ),
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
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_post_ratting' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
			'dl_woolist_Ratting_section_star_tab',
			[
				'label' => __( 'Star Format', 'droit-addons-pro' ),
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dl_woolist_ratting_star_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_post_ratting .rating .fa-star',
            ]
            );
        $this->add_control(
        'dl_woolist_ratting_default_color',
        [
            'label' => __( 'Default Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_post_ratting .rating .fa-star' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_control(
        'dl_woolist_ratting_check_color',
        [
            'label' => __( 'Check Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_post_ratting .rating .fa-star.checked' => 'color: {{VALUE}}',
            ],
        ]
        );
    
        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->end_controls_section();
        // End Ratting Style 
        // Start Author Style 
        $this->start_controls_section(
            'dl_woolist_author_section',
            [
                'label' => __( 'Author', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'dl_woolist_author_typography',
            'label' => __( 'Typography', 'droit-addons-pro' ),
            'selector' => '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_entry_meta',
        ]
        );
    
        $this->add_control(
        'dl_woolist_author_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_entry_meta' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_control(
            'dl_woolist_author_spacing',
            [
                'label' => __( 'Spacing', 'droit-addons-pro' ),
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
                    '{{WRAPPER}} .dl_woolist_item .dl_woolist_item_content .dl_entry_meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        // End Author Style 

        // Start Extra Icon Style 
        $this->start_controls_section(
            '_dl_woolist_extra_icon_style_section',
            [
                'label' => __( 'Extra Style', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_control(
            '_dl_woolist_extra_compare_view', [
                'label' => __('Show Compare View', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',     
            ]
        );

        $this->add_control(
            '_dl_woolist_extra_cart_view', [
                'label' => __('Show Cart View', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',     
            ]
        );

        $this->add_control(
            '_dl_woolist_extra_show_quick_view', [
                'label' => __('Show Quick View', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',     
            ]
        );

        $this->add_control(
            '_dl_woolist_extra_show_hover', [
                'label' => __('Show In Hover', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Extra Informaiton will be show in Hover', 'droit-addons-pro'),            
            ]
        );
        $this->add_control(
            '_dl_woolist_extra_show_vartical', [
                'label' => __('Show In Vartical', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Extra Informaiton will be show in Vartical Alignment', 'droit-addons-pro'),            
            ]
        );


        $this->start_controls_tabs(
            '_dl_woolist_extra_icon_style_tabs'
        );

        $this->start_controls_tab(
            '_dl_woolist_extra_icon_style_normal_tab',
            [
                'label' => __( 'Normal', 'droit-addons-pro' ),
            ]
        );
        $this->add_control(
            '_dl_woolist_extra_icon_alignment',
            [
                'label'     => __('Item Alignment', 'droit-addons'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'droit-addons-pro'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info'   => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_woolist_extra_position',
            [
                'label' => esc_html__('Position', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'relative'  => __( 'Default', 'droit-addons-pro' ),
                    'absolute' => __( 'Absolute', 'droit-addons-pro' ),
                    'fixed' => __( 'Fixed', 'droit-addons-pro' ),
                ],
                'default' => 'relative',
                'selectors' => [
                '{{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'position: {{VALUE}}',],
            ]
        );

        $this->add_control(
            '_dl_woolist_extra_icon_position',
            [
                'label' => __( '', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'droit-addons-pro' ),
                'label_on' => __( 'Custom', 'droit-addons-pro' ),
                'return_value' => 'yes',
                'condition' => [
                    '_dl_woolist_extra_position' => ['absolute', 'fixed']
                ]
            ]
        );

        $this->start_popover();

        $start = is_rtl() ? __( 'Right', 'droit-addons-pro' ) : __( 'Left', 'droit-addons-pro' );
        $end = ! is_rtl() ? __( 'Right', 'droit-addons-pro' ) : __( 'Left', 'droit-addons-pro' );

        $this->add_control(
            'dl_offset_orientation_h',
            [
                'label' => __( 'Horizontal Orientation', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            
            ]
        );

        $this->add_responsive_control(
            'dl_offset_x',
            [
                'label' => __( 'Offset', 'droit-addons-pro' ),
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
                    'body:not(.rtl) {{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'left: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'dl_offset_x_end',
            [
                'label' => __( 'Offset', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
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
                    'body:not(.rtl) {{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'right: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'dl_offset_orientation_v',
            [
                'label' => __( 'Vertical Orientation', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => __( 'Top', 'droit-addons-pro' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => __( 'Bottom', 'droit-addons-pro' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'dl_offset_y',
            [
                'label' => __( 'Offset', 'droit-addons-pro' ),
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
                    '{{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'dl_offset_y_end',
            [
                'label' => __( 'Offset', 'droit-addons-pro' ),
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
                    '{{WRAPPER}} .dl_woolist_item_thumb .dl_extra_info' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_v' => 'end',
                ],
            ]
        );
    
        $this->end_popover();

        $this->add_responsive_control(
			'_dl_woolist_extra_icon_height',
			[
				'label' => __( 'Height', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'height: {{SIZE}}{{UNIT}};',
				]	
			]
		);

        $this->add_responsive_control(
			'_dl_woolist_extra_icon_width',
			[
				'label' => __( 'Width', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_extra_icon_background',
                'label' => __( 'Icon Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button',
            ]
        );

        $this->add_control(
            'dl_woolist_extra_icon_color',
            [
                'label' => __( 'Icon Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
			'_dl_woolist_extra_icon_size',
			[
				'label' => __( 'Font Size', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_extra_icon_border',
                'label' => esc_html__('Item Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button',
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_extra_icon_Radious',
            [
                'label' => esc_html__('Item Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_extra_icon_margin',
            [
                'label' => esc_html__('Item Margin', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info .button, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            '_dl_woolist_extra_icon_style_hover_tab',
            [
                'label' => __( 'Hover', 'droit-addons-pro' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_extra_icon_background_hover',
                'label' => __( 'Icon Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_extra_info .button:hover, {{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button:hover',
            ]
        );
        $this->add_control(
            'dl_woolist_extra_icon_color_hover',
            [
                'label' => __( 'Icon Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info .button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'dl_woolist_extra_icon_border_hover',
            [
                'label' => __( 'Icon Border Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dl_extra_info .button:hover' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .dl_extra_info .woocommerce.product.compare-button a.compare.button:hover' => 'border-color: {{VALUE}}',
                    
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        

        // Start Button Style 
        $this->start_controls_section(
            'dl_woolist_button_section',
            [
                'label' => __( 'Cart Button', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
			'_dl_woolist_cart_style_tabs'
		);

		$this->start_controls_tab(
			'_dl_woolist_cart_normal_tab',
			[
				'label' => __( 'Normal', 'droit-addons-pro' ),
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_cart_button_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_add_cart a',
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'dl_woolist_cart_typography',
            'label' => __( 'Typography', 'droit-addons-pro' ),
            'selector' => '{{WRAPPER}} .dl_woolist_item .dl_add_cart a',
        ]
        );
    
        $this->add_control(
        'dl_woolist_cart_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_add_cart a' => 'color: {{VALUE}}',
            ],
        ]
        );
        
        $this->add_responsive_control(
            '_dl_woolist_button_margin',
            [
                'label' => esc_html__('Margin', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_add_cart a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_button_padding',
            [
                'label' => esc_html__('Padding', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_add_cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_woolist_button_border',
                'label' => esc_html__('Border', 'droit-addons-pro'),
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_add_cart a',
            ]
        );
        $this->add_responsive_control(
            '_dl_woolist_button_border_Radious',
            [
                'label' => esc_html__('Border Radius', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_woolist_item .dl_add_cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_woolist_icon_button_specing',
            [
                'label' => __('Spacing', 'droit-addons-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => '5',
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_add_cart .product_type_simple.add_to_cart_button:before' =>'margin-right: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );


        $this->end_controls_tab();

		$this->start_controls_tab(
			'dl_woolist_button_hover_style',
			[
				'label' => __( 'Hover', 'droit-addons-pro' ),
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_woolist_cart_button_hover_background',
                'label' => __( 'Background', 'droit-addons-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_woolist_item .dl_add_cart a:hover',
            ]
        );
    
        $this->add_control(
        'dl_woolist_cart_hover_color',
        [
            'label' => __( 'Color', 'droit-addons-pro' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl_woolist_item .dl_add_cart a:hover' => 'color: {{VALUE}}',
            ],
        ]
        );



        $this->end_controls_tab();

		$this->end_controls_tabs();

        $this->end_controls_section();
        // End Button Style 

    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if( !class_exists('\Woocommerce') ){
            echo drdt_kses_html('Please setup WooCommerce Plugin');
            return;
        }
        $query = [];
        $query['post_type'] = 'product';
        $query['post_status'] = 'publish';
        if( !empty($_dl_woolist_per_page) ){
            $query['posts_per_page'] = $_dl_woolist_per_page;
        } else {
            $query['posts_per_page'] = -1;
        }

        if( !empty($_dl_woolist_order_by) ){
            $query['orderby'] = $_dl_woolist_order_by;
        }
        if( !empty($_dl_woolist_order) ){
            $query['order'] = $_dl_woolist_order;
        }
        $query['offset'] = $_dl_woolist_offset;
        if( $_dl_woolist_ignore_sticky_posts != 'yes'){
            $query['ignore_sticky_posts'] = 1;
        }

        if($_dl_woolist_filter == 'category'){
			if( is_array($_dl_woolist_category) && sizeof($_dl_woolist_category) > 0){
				$cate_query = [
					[
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $_dl_woolist_category, 
					],			
					'relation' => 'AND',
				];
				$query['tax_query'] = $cate_query;
			}
		}

		if($_dl_woolist_filter == 'by_id'){
			if( is_array($_dl_woolist_manual_include) && sizeof($_dl_woolist_manual_include) > 0){
				$query['post__in'] = $_dl_woolist_manual_include;
			}
		}

		$post_query = new \WP_Query( $query );
        
        if (in_array($_dl_woo_skin, array(''), true) ) {
            include( __DIR__ .'/style/new.php' );
        }
        ?>

    <?php
    }

    public static function get_posts( $posttype = 'products'){
        $post_args = array(
            'posts_per_page'   => -1,
            'post_status'      => 'publish',
            'post_type'        => $posttype,
        );
        $_posts = get_posts($post_args);
        $posts_list = [];
        foreach ($_posts as $_key => $object) {
            $posts_list[$object->ID] = $object->post_title;
        }
        return $posts_list;
    }

    public static function get_category( $cate = 'product_cat' ){
        $post_cat = self::_get_terms($cate);
        
        $taxonomy	 = isset($post_cat[0]) && !empty($post_cat[0]) ? $post_cat[0] : ['product_cat'];
        $query_args = [
            'taxonomy'      => $taxonomy,
            'orderby'       => 'name', 
            'order'         => 'DESC',
            'hide_empty'    => false,
            'number'        => 1500
        ];
        $terms = get_terms( $query_args );

        $options = [];
        $count = count( (array) $terms);
        if($count > 0):
            foreach ($terms as $term) {
                if( $term->parent == 0 ) {
                    $options[$term->term_id] = $term->name;
                    foreach( $terms as $subcategory ) {
                        if($subcategory->parent == $term->term_id) {
                            $options[$subcategory->term_id] = $subcategory->name;
                        }
                    }
                }
            }
        endif;      
        return $options;
    }
    
    public static function get_taxonomies( $cate = 'product_cat', $type = 0){
        $post_cat = self::_get_terms($cate);
        
        $tag	 = isset($post_cat[$type]) && !empty($post_cat[$type]) ? $post_cat[$type] : 'product_cat';
        $terms = get_terms( array(
            'taxonomy' => $tag, 
            'orderby'       => 'name', 
            'order'         => 'DESC',
            'hide_empty'    => false,
            'number'        => 1500
        ) );
      
        return $terms;
    }

    public static function  _get_terms( $post = 'product_cat'){
        $taxonomy_objects = get_object_taxonomies( $post );
     return $taxonomy_objects;
    }

    public function get_product_attr(){
        // Attributes
        global $product;
        //$product_attributes = $product->get_attributes(); // Get the product attributes
        $product_id = $product->get_id();
        $product_ver = new \WC_Product_Variable( $product_id );
        $variations = $product_ver->get_available_variations();
        //echo '<pre>'; print_r( $variations); echo '</pre>';

        $terms = get_the_terms($product_id , sanitize_title( 'pa_color' ) );

        $product_attributes = $product_ver->get_attributes(); // Get the product attributes
        echo '<pre>'; print_r( $product_attributes); echo '</pre>';
     

    }
    protected function content_template()
    {}
}