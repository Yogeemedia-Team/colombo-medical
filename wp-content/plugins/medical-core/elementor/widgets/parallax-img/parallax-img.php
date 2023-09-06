<?php
namespace DROIT_ELEMENTOR_PRO\Widgets;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Parallax_Img extends \Elementor\Widget_Base{

  
    
    public function get_name()
    {
        return 'dladdons-parallax-img';
    }

    public function get_title()
    {
        return esc_html__( 'Parallax Image Pro', 'droit-addons-pro' );
    }

    public function get_icon()
    {
        return 'dlicons-process addons-icon';
    }

    public function get_categories()
    {
        return ['droit_addons_pro'];
    }

    public function get_keywords()
    {
        return [ 'process', 'timer' ];
    }

    protected function register_controls()
    {
        do_action('dl_widgets/process/register_control/start', $this);

        // add content 
        $this-> _dl_pro_parallax_content_control();
        // $this-> dl_parallax_image_control();
        
        do_action('dl_widgets/process/register_control/end', $this);

        // by default
        do_action('dl_widget/section/style/custom_css', $this);
        
    }

    public function _dl_pro_parallax_content_control(){

        $this-> dl_image_control();
        $this-> _dl_pro_par_content_control();

    }

    protected function dl_image_control(){
        //start content layout
        $this->start_controls_section(
            'dl_image_control',
            [
                'label' => __('Image', 'droit-addons-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'dl_image',
			[
				'label' => esc_html__( 'Choose Image', 'elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', 
				'default' => 'large',
				'separator' => 'none',
			]
		);

        $this-> end_controls_section();
    }

    public function _dl_pro_par_content_control(){
        // start subscribe layout
        $this->start_controls_section(
            '_dl_pro_image_content_section',
            [
                'label' => __('Parallax Effect', 'droit-addons-pro'),
            ]
        );
        

        $this-> dl_parallax_image_control();

        $this->end_controls_section();
        //start subscribe layout end
        

    }

    // Process Repeater
    protected function dl_parallax_image_control()
    {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'image',[
                'label' => esc_html__('Choose Image', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
            ]
        );

        $repeater->add_control(
            'dl_item_position',
            [
                'label' => __( 'Position', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'your-plugin' ),
                'label_on' => __( 'Custom', 'your-plugin' ),
                'return_value' => 'yes',
            ]
        );

        $repeater->start_popover();

        $start = is_rtl() ? __( 'Right', 'droit-addons-pro' ) : __( 'Left', 'droit-addons-pro' );
        $end = ! is_rtl() ? __( 'Right', 'droit-addons-pro' ) : __( 'Left', 'droit-addons-pro' );

        $repeater->add_control(
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

        $repeater->add_responsive_control(
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
                    'body:not(.rtl) {{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'left: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $repeater->add_responsive_control(
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
                    'body:not(.rtl) {{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'right: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_h' => 'end',
                ],
            ]
        );

        $repeater->add_control(
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

        $repeater->add_responsive_control(
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
                    '{{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $repeater->add_responsive_control(
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
                    '{{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dl_offset_orientation_v' => 'end',
                ],
            ]
        );
       
        $repeater->end_popover();

        $repeater->add_control(
            'dl_zindex',   [
                'label' => esc_html__('z-index', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Set z-index for the current layer, default 5', 'droit-addons-pro' ),
                'default' => esc_html__('5', 'droit-addons-pro'),
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element" => 'z-index: {{UNIT}}',
                ],
            ]
        );
        $repeater->add_control(
            'dl_item_opacity',
            [
                'label' => esc_html__( 'Opacity', 'droit-addons-pro'  ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Set the layer opacity', 'droit-addons-pro' ),
                'default' => 1,
                'min' => 0,
                'step' => .1,
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}.dl_parallax_img_element > .layer > *" => 'opacity:{{UNIT}}'
                ],
            ]
        );

        $repeater->add_control(
            'dl_parallax_heading',
            [
                'label' => __( 'Parallax Settings', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $repeater->add_control(
            'dl_parallax_data_popup',
            [
                'label' => __( 'Data', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'Default', 'your-plugin' ),
                'label_on' => __( 'Custom', 'your-plugin' ),
                'return_value' => 'yes',
            ]
        );

        $repeater->start_popover();

        $repeater->add_control(
            'dl_parallax_translate_heading',
            [
                'label' => __( 'Translate (X, Y)', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'dl_translate_x_axix', [
                'label' => esc_html__( 'X axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );

        $repeater->add_control(
            'dl_translate_y_axix', [
                'label' => esc_html__( 'Y axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );

        $repeater->add_control(
            'dl_parallax_rotate_heading',
            [
                'label' => __( 'Rotate (X, Y, Z)', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'dl_rotate_x_axix', [
                'label' => esc_html__( 'X axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );

        $repeater->add_control(
            'dl_rotate_y_axix', [
                'label' => esc_html__( 'Y axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );
        $repeater->add_control(
            'dl_rotate_z_axix', [
                'label' => esc_html__( 'Z axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );

        $repeater->add_control(
            'dl_parallax_scale_heading',
            [
                'label' => __( 'Scale (X, Y, Z)', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                
            ]
        );

        $repeater->add_control(
            'dl_scale_x_axix', [
                'label' => esc_html__( 'X axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );

        $repeater->add_control(
            'dl_scale_y_axix', [
                'label' => esc_html__( 'Y axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );
        $repeater->add_control(
            'dl_scale_z_axix', [
                'label' => esc_html__( 'Z axis', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
                'frontend_available' => true,
                'render_type' => 'none',
            ]
        );


        $repeater->add_control(
            'dl_item_depth',
            [
                'label' => esc_html__( 'Depth', 'droit-addons-pro'  ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => __( 'Set the layer Depth', 'droit-addons-pro' ),
                'default' => .10,
                'min' => -10,
                'step' => .1,
                'separator' => 'before',
                'condition' => [
                    'dl_parallax_data_popup' => 'yes',
                ],
            ]
        );

        $repeater->end_popover();


        $repeater->add_control(
            'dl_responsive_description',
            [
                'raw' => __( 'Responsive visibility will take effect only on preview or live page, and not while editing in Elementor.', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $repeater->add_control(
            'dl_hide_tablet',
            [
                'label' => __( 'Hide On Tablet', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __( 'Hide', 'droit-addons-pro' ),
                'label_off' => __( 'Show', 'droit-addons-pro' ),
                'return_value' => 'hidden-tablet',
            ]
        );

        $repeater->add_control(
            'dl_hide_mobile',
            [
                'label' => __( 'Hide On Mobile', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __( 'Hide', 'droit-addons-pro' ),
                'label_off' => __( 'Show', 'droit-addons-pro' ),
                'return_value' => 'hidden-phone',
            ]
        );

        // $repeater->end_controls_tab();

				
		// $repeater->end_controls_tabs();

        do_action('dl_pro_parallax_img', $repeater);
        $this->add_control(
            '_dl_pro_parallax_img_list',
            [
                'label' => __('Parallax Image', 'droit-addons-pro'),
                'show_label' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
    }



    //Html render
    protected function render()
    {   
        $settings = $this->get_settings_for_display();
        extract($settings);
        ?>
            <div class="dl_parallax_img">
                <img src="<?php echo esc_url($settings['dl_image']['url']); ?>" alt="p_img">
                <?php 
                $i = 1;
                foreach ($_dl_pro_parallax_img_list as $p) { 
                    $data = [];
                    if( isset($p['dl_translate_x_axix']) && !empty($p['dl_translate_x_axix']) ){
                        $data['x'] = $p['dl_translate_x_axix'];
                    }

                    if( isset($p['dl_translate_y_axix']) && !empty($p['dl_translate_y_axix'])  ){
                        $data['y'] = $p['dl_translate_y_axix'];
                    }

                    if( isset($p['dl_rotate_x_axix']) && !empty($p['dl_rotate_x_axix'])  ){
                        $data['rotateX'] = $p['dl_rotate_x_axix'];
                    }
                    if( isset($p['dl_rotate_y_axix']) && !empty($p['dl_rotate_y_axix'])  ){
                        $data['rotateY'] = $p['dl_rotate_y_axix'];
                    }
                    if( isset($p['dl_rotate_z_axix']) && !empty($p['dl_rotate_z_axix'])  ){
                        $data['rotateZ'] = $p['dl_rotate_z_axix'];
                    }
                    if( isset($p['dl_scale_x_axix']) && !empty($p['dl_scale_x_axix'])  ){
                        $data['scaleX'] = $p['dl_scale_x_axix'];
                    }

                    if( isset($p['dl_scale_y_axix']) && !empty($p['dl_scale_y_axix'])  ){
                        $data['scaleY'] = $p['dl_scale_y_axix'];
                    }

                    if( isset($p['dl_scale_z_axix']) && !empty($p['dl_scale_z_axix'])  ){
                        $data['scaleZ'] = $p['dl_scale_z_axix'];
                    }
                    
                    ?>
                    <div class="dl_parallax_img_element <?php echo esc_attr_e('elementor-repeater-item-'.$p['_id']);?>">
                        <div class="layer layer<?php echo esc_attr($i);?>" <?php  if( isset($p['dl_item_depth']) && !empty($p['dl_item_depth']) ){?>data-depth="<?php echo esc_attr($p['dl_item_depth']);?>" <?php }?>>
                            <img src="<?php echo esc_url($p['image']['url']); ?>" alt="" data-parallax='<?php echo esc_attr( json_encode($data) );?>'>
                        </div>
                    </div>
                <?php 
                $i++;
            } ?>
            </div>
        <?php
    }
    

    protected function content_template()
    {}
}