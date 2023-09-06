<?php
namespace DROIT_ELEMENTOR_PRO\Widgets;

use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Woo_Product_Cat_Grid extends \Elementor\Widget_Base {

    public function get_name() {
        return 'droit-woo-product-cat-grid';
    }

    public function get_title() {
        return esc_html__('Product Category', 'droit-addons-pro');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['droit_addons_pro'];
    }

    public function get_keywords() {
        return [
            'Woocommerces',
            'woocommerces',
            'WC',
            'Woocommerces Category Grid',
            'Woocommerces Woo Product Category Grid',
            'woocommerces woo grid',
            'woo-cat-grid',
            'woo-product-cat-grid',
            'wc grid',
            'wc product cart grid',
            'wc product category grid',
            'category grid',
            'WC grid',
            'category grid',
            'droit Woocommerces',
            'dl Woocommerces',
            'droit',
            'dl',
            'addons',
            'addon',
            'pro',
        ];
    }

    protected function register_controls() {
        do_action('dl_widgets/woo-product-cat-grid/register_control/start', $this);

        if( class_exists('\Woocommerce') ){
            // for layout
            $this->__settings();

            // for style controls
            $this->__styles();

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
       
        do_action('dl_widgets/woo-product-cat-grid/register_control/end', $this);

        do_action('dl_widget/section/style/custom_css', $this);
    }

    // mini cart settings
    protected function __settings() {
        $this->__layout_controls();
        $this->__query_controls();
        $this->__loadmore_controls();
    }

    // define layout controls
    protected function __layout_controls() {

		$this->start_controls_section(
			'dlpro_woocg_layout_settings',
			[
				'label' => __( 'Layout Settings', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'dlpro_woocg_skin',
			[
				'label' => __( 'Skin', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'classic' => __( 'Classic', 'droit-addons-pro' ),
					'minimal' => __( 'Minimal', 'droit-addons-pro' ),
				],
				'default' => 'classic',
			]
		);

        $this->add_responsive_control(
			'dlpro_woocg_columns',
			[
				'label' => __( 'Columns', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'dl-pg-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-wrapper' => 'grid-template-columns: repeat( {{VALUE}}, 1fr );',
				],
			]
		);

		$this->add_control(
            'dlpro_woocg_cat_per_page',
            [
                'label' => __( 'Category Per Page', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
				'max' => 1000,
				'default' => '3',
            ]
		);

		$this->add_control(
			'dlpro_woocg_cat_image_show',
			[
				'label' => __( 'Featured Image', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'droit-addons-pro' ),
				'label_off' => __( 'Hide', 'droit-addons-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'dlpro_woocg_cat_image',
				'default' => 'thumbnail',
				'exclude' => [
					'custom'
				],
				'condition' => [
					'dlpro_woocg_cat_image_show' => 'yes',
				]
			]
		);

		$this->add_control(
			'dlpro_woocg_show_cats_count',
			[
				'label' => __( 'Count Number', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => 'Yes',
				'label_off' => 'No',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'dlpro_woocg_image_overlay',
			[
				'label' => __( 'Image Overlay', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => 'Yes',
				'label_off' => 'No',
				'return_value' => 'yes',
				'prefix_class' => 'dl-image-overlay-',
				'selectors_dictionary' => [
                    'yes' => 'content:\'\';',
                ],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-thumbnail:before' => '{{VALUE}}',
				],
				'condition' => [
					'dlpro_woocg_cat_image_show' => 'yes',
				]
			]
		);

		$this->end_controls_section();

	}

    // define query controls
    protected function __query_controls() {

		$this->start_controls_section(
            'dlpro_woocg_query',
            [
                'label' => __( 'Query', 'droit-addons-pro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
		);

		$this->add_control(
            'dlpro_woocg_query_type',
            [
                'label' => __( 'Type', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
                'options' => [
                    'all' => __( 'All', 'droit-addons-pro' ),
                    'parents' => __( 'Only Parents', 'droit-addons-pro' ),
                    'child' => __( 'Only Child', 'droit-addons-pro' )
                ],
            ]
		);

		$this->start_controls_tabs( 'dlpro_woocg_include_exclude',
			[
				'condition' => [ 'dlpro_woocg_query_type' => 'all' ]
			]
		);
		$this->start_controls_tab(
            'dlpro_woocg_term_include',
            [
				'label' => __( 'Include', 'droit-addons-pro' ),
				'condition' => [ 'dlpro_woocg_query_type' => 'all' ]
            ]
		);

		$this->add_control(
			'dlpro_woocg_include_by_id',
			[
				'label' => __( 'Categories', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'condition' => [
					'dlpro_woocg_query_type' => 'all'
				],
				'options' => self::get_category(),
			]
		);

		$this->end_controls_tab();

        $this->start_controls_tab(
            'dlpro_woocg_term_exclude',
            [
				'label' => __( 'Exclude', 'droit-addons-pro' ),
				'condition' => [ 'dlpro_woocg_query_type' => 'all' ]
            ]
		);

		$this->add_control(
			'dlpro_woocg_exclude_by_id',
			[
				'label' => __( 'Categories', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => true,
				'condition' => [
					'dlpro_woocg_query_type' => 'all'
				],
				'options' => self::get_category(),
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
            'dlpro_woocg_parent_cats',
            [
                'label' => __( 'Child Categories of', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => self::get_parent_category(),
				'condition' => [
					'dlpro_woocg_query_type' => 'child'
				]
            ]
        );

		$this->add_control(
            'dlpro_woocg_order_by',
            [
                'label' => __( 'Order By', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'name',
                'options' => [
                    'name' => __( 'Name', 'droit-addons-pro' ),
                    'count' => __( 'Count', 'droit-addons-pro' ),
                    'slug' => __( 'Slug', 'droit-addons-pro' )
                ],
            ]
		);

		$this->add_control(
            'dlpro_woocg_order',
            [
                'label' => __( 'Order', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
                'options' => [
                    'desc' => __( 'Descending', 'droit-addons-pro' ),
                    'asc' => __( 'Ascending', 'droit-addons-pro' ),
                ],
            ]
		);

		$this->add_control(
			'dlpro_woocg_show_empty_cat',
			[
				'label' => __( 'Show Empty Categories', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => 'Yes',
				'label_off' => 'No',
				'return_value' => 'yes',
			]
		);

        $this->end_controls_section();

	}

    // define loadmore controls
    protected function __loadmore_controls() {
        $this->start_controls_section(
			'dlpro_woocg_more',
			[
				'label' => __( 'Load More', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'dlpro_woocg_show_load_more',
			[
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => __( 'Show Load More Button', 'droit-addons-pro' ),
				'default' => '',
				'return_value' => 'yes',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'dlpro_woocg_load_more_text',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Button Text', 'droit-addons-pro' ),
				'default' => __( 'More category', 'droit-addons-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'dlpro_woocg_show_load_more' => 'yes',
				]
			]
		);

		$this->add_control(
			'dlpro_woocg_load_more_link',
			[
				'type' => \Elementor\Controls_Manager::URL,
				'label' => __( 'Button URL', 'droit-addons-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'dlpro_woocg_show_load_more' => 'yes',
				],
			]
		);

		$this->end_controls_section();
    }

    // define register style controls
    protected function __styles() {
        $this->__layout_style();
        $this->__itembox_style();
        $this->__image_style();
        $this->__content_style();
        $this->__loadmore_style();
    }

    // define layout style controls
    protected function __layout_style() {

		$this->start_controls_section(
			'dlpro_woocg_layout_style',
			[
				'label' => __( 'Layout', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'dlpro_woocg_column_gap',
			[
				'label' => __( 'Columns Gap', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-wrapper' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'dlpro_woo_row_gap',
			[
				'label' => __( 'Rows Gap', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-wrapper' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

    // define item box style Controls
    protected function __itembox_style() {
        $this->start_controls_section(
			'dlpro_woocg_item_box_style',
			[
				'label' => __( 'Item Box', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
            'dlpro_woocg_item_heght',
            [
                'label' => __( 'Height', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-item' => 'height: {{SIZE}}{{UNIT}};'
                ],
            ]
		);

		$this->add_responsive_control(
            'dlpro_woocg_item_padding',
            [
                'label' => __( 'Padding', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
				'name' => 'dlpro_woocg_item_border',
                'selector' => '{{WRAPPER}} .dl-product-cat-grid-item-inner',
            ]
		);

		$this->add_responsive_control(
            'dlpro_woocg_item_border_radius',
            [
                'label' => __( 'Border Radius', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dlpro_woocg_item_box_shadow',
                'selector' => '{{WRAPPER}} .dl-product-cat-grid-item-inner'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dlpro_woocg_item_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .dl-product-cat-grid-item-inner',
            ]
		);

		$this->end_controls_section();
    }

    // define image style controls
    protected function __image_style() {
        $this->start_controls_section(
			'dlpro_woocg_image_style',
			[
				'label' => __( 'Image', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'dlpro_woocg_cat_image_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
            'dlpro_woocg_image_width',
            [
                'label' => __( 'Width', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-thumbnail img' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

		$this->add_responsive_control(
            'dlpro_woocg_image_height',
            [
                'label' => __( 'Height', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-thumbnail img' => 'height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'dlpro_woocg_image_border_radius',
            [
                'label' => __( 'Border Radius', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'dlpro_woocg_image_overlay_color',
			[
				'label' => __( 'Overlay Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'dlpro_woocg_image_overlay' => 'yes',
				],
				'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-thumbnail:before' => 'background-color: {{VALUE}};',
				],
			]
        );

		$this->end_controls_section();
    }

    // define content style controls
    protected function __content_style() {
        $this->start_controls_section(
			'dlpro_woocg_content_style',
			[
				'label' => __( 'Content', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        // start content area
        $this->add_control(
            'dlpro_woocg_content_area_style',
            [
                'label' => __( 'Content Area', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

		$this->add_control(
			'dlpro_woocg_content_align',
			[
				'label' => __( 'Alignment', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'dl-product-cat-grid-content-align-',
                'condition' => [
					'dlpro_woocg_skin' => 'minimal',
                ],
			]
		);

		$this->add_responsive_control(
            'dlpro_woocg_content_margin',
            [
                'label' => __( 'Margin', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-content-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'dlpro_woocg_content_padding',
            [
                'label' => __( 'Padding', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dlpro_woocg_content_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .dl-product-cat-grid-content-inner',
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
				'name' => 'dlpro_woocg_content_item_border',
                'selector' => '{{WRAPPER}} .dl-product-cat-grid-content-inner',
            ]
		);

		$this->add_responsive_control(
            'dlpro_woocg_content_item_border_radius',
            [
                'label' => __( 'Border Radius', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // start title style
        $this->add_control(
            'dlpro_woocg_title_style',
            [
                'label' => __( 'Title', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dlpro_woocg_title_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-title a',
				'scheme' => Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            'dlpro_woocg_title_color',
            [
                'label' => __( 'Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-title a' => 'color: {{VALUE}};'
                ],
            ]
		);

		$this->add_control(
            'dlpro_woocg_title_hover_color',
            [
                'label' => __( 'Hover Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-title a:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        // start counter style
        $this->add_control(
            'dlpro_woocg_count_style',
            [
                'label' => __( 'Count', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'dlpro_woocg_show_cats_count' => 'yes',
                ],
            ]
		);

        $this->add_responsive_control(
            'dlpro_woocg_classic_count_space',
            [
                'label' => __( 'Left Spacing', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                    ],
				],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-count' => 'margin-left: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
					'dlpro_woocg_skin' => 'classic',
					'dlpro_woocg_show_cats_count' => 'yes',
                ],
            ]
		);

        $this->add_responsive_control(
            'dlpro_woocg_minimal_count_space',
            [
                'label' => __( 'Top Spacing', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
				],
                'selectors' => [
                    '{{WRAPPER}} .dl-product-cat-grid-count' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
					'dlpro_woocg_skin' => 'minimal',
					'dlpro_woocg_show_cats_count' => 'yes',
                ],
            ]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dlpro_woocg_count_typography',
                'label' => __( 'Typography', 'droit-addons-pro' ),
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-count',
				'scheme' => Typography::TYPOGRAPHY_3,
                'condition' => [
					'dlpro_woocg_show_cats_count' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dlpro_woocg_count_color',
            [
                'label' => __( 'Color', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-count' => 'color: {{VALUE}};'
                ],
                'condition' => [
					'dlpro_woocg_show_cats_count' => 'yes',
                ],
            ]
        );

		$this->end_controls_section();
    }


    // define loadmore style controls
    protected function __loadmore_style() {

        $this->start_controls_section(
			'dlpro_woocg_loadmore_btn_style',
			[
				'label' => __( 'Load More Button', 'droit-addons-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'dlpro_woocg_show_load_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_align',
			[
				'label' => __( 'Alignment', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'droit-addons-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dlpro_woocg_loadmore_btn_margin_top',
			[
				'label' => __( 'Margin Top', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'dlpro_woocg_loadmore_btn_padding',
			[
				'label' => __( 'Padding', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'dlpro_woocg_loadmore_btn_typography',
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-load-more-btn',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'dlpro_woocg_loadmore_btn_border',
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-load-more-btn',
			]
		);

		$this->add_control(
			'load_more_btn_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'dlpro_woocg_loadmore_btn_style_start' );

		$this->start_controls_tab(
			'dlpro_woocg_loadmore_btn_normal',
			[
				'label' => __( 'Normal', 'droit-addons-pro' ),
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_color',
			[
				'label' => __( 'Text Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_bg_color',
			[
				'label' => __( 'Background Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'dlpro_woocg_loadmore_btn_box_shadow',
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-load-more-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dlpro_woocg_tab_loadmore_btn_hover',
			[
				'label' => __( 'Hover', 'droit-addons-pro' ),
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_hover_color',
			[
				'label' => __( 'Text Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn:hover, {{WRAPPER}} .dl-product-cat-grid-load-more-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_hover_bg_color',
			[
				'label' => __( 'Background Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn:hover, {{WRAPPER}} .dl-product-cat-grid-load-more-btn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dlpro_woocg_loadmore_btn_hover_border_color',
			[
				'label' => __( 'Border Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'btn_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn:hover, {{WRAPPER}} .dl-product-cat-grid-load-more-btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'dlpro_woocg_loadmore_btn_hove_box_shadow',
				'selector' => '{{WRAPPER}} .dl-product-cat-grid-load-more-btn:hover, {{WRAPPER}} .dl-product-cat-grid-load-more-btn:focus',
			]
		);


		$this->add_control(
			'dlpro_woocg_loadmore_btn_hove_border_color',
			[
				'label' => __( 'Border Color', 'droit-addons-pro' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn:hover' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dl-product-cat-grid-load-more-btn:focus' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
    }

    // generate loadmore button
    public function __dlpro_loadmore_btn() { 
        $settings = $this->get_settings_for_display();
        extract($settings);
		if ( $dlpro_woocg_show_load_more !== 'yes' ) {
			return;
		}
		$this->add_link_attributes( 'load_more', $dlpro_woocg_load_more_link );
		$this->add_render_attribute( 'load_more', 'class', 'dl-product-cat-grid-load-more-btn' );
		?>
		<div class="dl-product-cat-grid-load-more">
			<a <?php $this->print_render_attribute_string( 'load_more' ); ?>><?php echo esc_html( $dlpro_woocg_load_more_text ); ?></a>
		</div>
   <?php }

    // define get query settings
    public function get_query_settings() {
		$settings = $this->get_settings_for_display();
        extract($settings);

		$args = array(
			'orderby'    => ( $dlpro_woocg_order_by ) ? $dlpro_woocg_order_by : 'name',
			'order'      => ( $dlpro_woocg_order ) ? $dlpro_woocg_order : 'ASC',
			'hide_empty' => $dlpro_woocg_show_empty_cat == 'yes' ? false : true,
		);

		if ( $dlpro_woocg_query_type == 'all' ) {
			! empty( $dlpro_woocg_include_by_id ) ? $args['include'] = $dlpro_woocg_include_by_id : null;
			! empty( $dlpro_woocg_exclude_by_id ) ? $args['exclude'] = $dlpro_woocg_exclude_by_id : null;
		} elseif ( $dlpro_woocg_query_type == 'parents' ) {
			$args['parent'] = 0;
		} elseif ( $dlpro_woocg_query_type == 'child' ) {
			if ( $dlpro_woocg_parent_cats != 'none' &&  ! empty( $dlpro_woocg_parent_cats ) ) {
				$args['child_of'] = $dlpro_woocg_parent_cats;
			} elseif ( $dlpro_woocg_parent_cats == 'none' ) {
				if ( is_admin() ) {
					return printf( '<div class="dl-category-carousel-error">%s</div>', __( 'Select Parent Category from <strong>Query > Child Categories Dose\'t Exits </strong>.', 'droit-addons-pro' ) );
				}
			}
		}

		$product_cats = get_terms( 'product_cat', $args );

		if ( !empty( $dlpro_woocg_cat_per_page ) && count( $product_cats ) > $dlpro_woocg_cat_per_page ) {
			$product_cats = array_splice( $product_cats, 0, $dlpro_woocg_cat_per_page );
		}

		return $product_cats;
	}

    // define rander preview
    protected function render() {

        $settings = $this->get_settings_for_display();
        extract($settings);

        if( !class_exists('\Woocommerce') ){
            echo drdt_kses_html( 'Please setup WooCommerce Plugin!' );
            return;
        }

        $product_cats = self::get_query_settings();
		if ( empty( $product_cats ) ) {
			if ( is_admin() ) {
				return printf( '<div class="dl-product-cat-grid-error">%s</div>', __( 'Data Not Found. Please Add Category.', 'droit-addons-pro' ) );
			}
		}

        include( __DIR__ .'/style/new.php' );

    }

    // define get all category list
    public static function get_category( $cate = 'product_cat' ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

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

    // define get parent category
    public static function  get_parent_category() {
        if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		$parent_categories = [ 'none' => __( 'None', 'droit-addons-pro' ) ];

		$args = array(
			'parent' => 0
		);
		$parent_cats = get_terms( 'product_cat', $args );

		foreach ( $parent_cats as $parent_cat ) {
			$parent_categories[$parent_cat->term_id] = $parent_cat->name;
		}
		return $parent_categories;
    }

    // define get terms
    public static function  _get_terms( $post = 'product_cat') {
        $taxonomy_objects = get_object_taxonomies( $post );
        return $taxonomy_objects;
    }

}