<?php
namespace Elementor;

if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Blog_List extends Widget_Base{

    public function get_name()
    {
        return 'drth-blog-list';
    }

    public function get_title()
    {
        return esc_html__( 'Blog List(Theme)', 'donarity-core' );
    }

    public function get_icon()
    {
        return 'eicon-image-before-after addons-icon';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [ 'blog', ];
    }


    protected function register_controls() {

        // ----------------------------------------  Blog Posts  ------------------------------ //
        $this->start_controls_section(
            'blog_select_sec',
            [
                'label' => __('Preset Skin', 'donarity-core'),
            ]
        );

        $this->add_control(
            'style', [
                'label'         => esc_html__('Skins', 'donarity-core'),
                'type'          => Controls_Manager::CHOOSE,
            ]
        );

        $this->end_controls_section();


        //===================================== Title & Subtitle ==============================//
        $this->start_controls_section(
            'sec_title', [
                'label'     => __('Title & Subtitle', 'donarity-core'),
                'condition' => [
                    'style' => '13'
                ]
            ]
        );

        $this->add_control(
            'title', [
                'label' => __( 'Title', 'donarity-core' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'sec_title_color', [
                'label' => __('Text Color', 'donarity-core'),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'sec_title_typo',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'subtitle', [
                'label'     => __( 'Subtitle', 'donarity-core' ),
                'type'      => Controls_Manager::TEXTAREA,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'sec_subtitle_color', [
                'label'                     => __('Text Color', 'donarity-core'),
                'type'                      => Controls_Manager::COLOR,
                'selectors'                 => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'sec_subtitle_typo',
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        );

        $this->end_controls_section(); // End Title & Subtitle


        //===================================== Read More Button ==============================//
        $this->start_controls_section(
            'read_more_button_sec', [
                'label'     => __('Read More Link', 'donarity-core'),
            ]
        );

        $this->add_control(
            'btn_title', [
                'label'       => __('Button Title', 'donarity-core'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Read More'
            ]
        );


        // Button Settings
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'read_more_btn_typo',
                'selector' => '
                    {{WRAPPER}} .agency_learn_btn, 
                    {{WRAPPER}} .trbtn-elementor-style,
                    {{WRAPPER}} .btn_title,
                ',
            ]
        );

        $this->start_controls_tabs('read_more_btn_style');

        $this->start_controls_tab(
            'read_more_btn_normal', [
                'label' => __( 'Normal', 'donarity-core' ),
            ]
        );

        $this->add_control(
            'read_more_btn_font_color',
            [
                'label'                                  => __( 'Text Color', 'donarity-core' ),
                'type'                                   => \Elementor\Controls_Manager::COLOR,
                'selectors'                              => [
                    '{{WRAPPER}} .agency_learn_btn'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .trbtn-elementor-style' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn_title'             => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'read_more_btn_hover', [
                'label' => __( 'Hover', 'donarity-core' ),
            ]
        );

        $this->add_control(
            'read_more_btn_hover_font_color',
            [
                'label'                                          => __( 'Text Color', 'donarity-core' ),
                'type'                                           => \Elementor\Controls_Manager::COLOR,
                'selectors'                                      => [
                    '{{WRAPPER}} .agency_learn_btn:hover'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .agency_learn_btn:before'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .h_text_btn:hover i'            => 'color: {{VALUE}}',
                    '{{WRAPPER}} .trbtn-elementor-style:hover'   => 'color: {{VALUE}}',
                    '{{WRAPPER}} .trbtn-elementor-style:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn_title:hover'               => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Icon Settings
        $this->add_control(
            'is_btn_icon',
            [
                'label' => __( 'Show Icon', 'donarity-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'donarity-core' ),
                'label_off' => __( 'Hide', 'donarity-core' ),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'read_more_icon',
            [
                'label' => __( 'Icon', 'donarity-core' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [
                    'is_btn_icon' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'read_more_icon_color',
            [
                'label' => __( 'Icon Color', 'donarity-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency_learn_btn i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'is_btn_icon' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'read_more_icon_size',
            [
                'label' => __( 'Size', 'donarity-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                ],
                'selectors' => [
                    '{{WRAPPER}} .agency_learn_btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'is_btn_icon' => 'yes',
                ]
            ]
        );

        $this->end_controls_section(); // End Read More Button


        //============================= Filter Options =================================== //
        $this->start_controls_section(
            'filter_sec_opt', [
                'label' => __('Filter', 'donarity-core'),
            ]
        );

        $this->add_control(
            'show_count', [
                'label' => esc_html__('Show Posts Count', 'donarity-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__('Order', 'donarity-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'orderby', [
                'label' => esc_html__( 'Order By', 'donarity-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'None',
                    'ID' => 'ID',
                    'author' => 'Author',
                    'title' => 'Title',
                    'name' => 'Name (by post slug)',
                    'date' => 'Date',
                    'rand' => 'Random',
                ],
                'default' => 'none'
            ]
        );


        $this->add_control(
            'title_length', [
                'label' => esc_html__('Title Word Length', 'donarity-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'style' => [ '5', '15' ]
                ],
                'default' => 10,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'is_post_excerpt', [
                'label' => __( 'Post Excerpt', 'donarity-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'rave-core' ),
                'label_off' => __( 'Hide', 'rave-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'style' => '5'
                ]
            ]
        );

        $this->add_control(
            'excerpt_length', [
                'label' => esc_html__('Excerpt Word Length', 'donarity-core'),
                'type' => Controls_Manager::NUMBER,
                
                // 'default' => 12,
            ]
        );

        

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'include' => [],
                'default' => 'full',
                'condition' => [
                    'style' => [ '2', '5', '11', '13', '14', '15' ]
                ]
            ]
        );

        $this->add_control(
            'is_pagination', [
                'label'        => esc_html__( 'Pagination', 'donarity-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'donarity-core' ),
                'label_off'    => __( 'No', 'donarity-core' ),
                'return_value' => 'yes',
                'condition'    => [
                    'style'    => [ '5', '12', '13', '14' ]
                ],
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'is_pagination_ajax', [
                'label'             => esc_html__( 'Ajax Pagination?', 'donarity-core' ),
                'type'              => Controls_Manager::SWITCHER,
                'label_on'          => __( 'Yes', 'donarity-core' ),
                'label_off'         => __( 'No', 'donarity-core' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'style'         => [ '5', '12', '13', '14' ],
                    'is_pagination' => ['yes']
                ],
                'separator'         => 'before',
            ]
        );

        $this->end_controls_section(); //End Filter


        //========================= Blog Layout
        $this->start_controls_section(
            'blog_layout', [
                'label'     => __('Layout', 'donarity-core'),
                'condition' => [
                    'style' => [ '5', '11', '13' ]
                ]
            ]
        );

        $this->add_responsive_control(
            'column_grid_padding', [
                'label'                      => esc_html__('Padding', 'donarity-core'),
                'type'                       => Controls_Manager::DIMENSIONS,
                'size_units'                 => ['px', '%', 'em'],
                'selectors'                  => [
                    '{{WRAPPER}} .blog-gird' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'                    => [
                    'unit'                   => 'px', // The selected CSS Unit. 'px', '%', 'em',
                ],
                'separator'                  => 'after',
                'condition'                  => [
                    'style'                  => '5'
                ]
            ]
        );

        $this->add_control(
            'column_grid', [
                'label'     => __('Column', 'donarity-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '6'     => __( 'Two Column', 'donarity-core' ),
                    '4'     => __( 'Three Column', 'donarity-core' ),
                    '3'     => __( 'Four Column', 'donarity-core' ),
                    '2'     => __( 'Six Column', 'donarity-core' ),
                ],
                'default'   => 4,
                'condition' => [
                    'style' => [ '5', '11', '13' ],
                ]
            ]
        );

        $this->add_control(
            'is_post_date',
            [
                'label'        => __( 'Show/Hide Post Date', 'donarity-core' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'donarity-core' ),
                'label_off'    => __( 'Hide', 'donarity-core' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before',
                'condition'    => [
                    'style'    => '5'
                ],
            ]
        );

        $this->add_control(
            'is_reading_time',
            [
                'label'        => __( 'Show/Hide Reading Time', 'donarity-core' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'donarity-core' ),
                'label_off'    => __( 'Hide', 'donarity-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
                'condition'    => [
                    'style'    => '5'
                ],
            ]
        );

        $this->end_controls_section(); // End Layout


        /***
         * @@
         * Style Tab
         * @@
         */
        //=========================== Post Title Style ========================= //
        $this->start_controls_section(
            'dl_new_blog_list_title', [
                'label'                       => __('Post Title', 'donarity-core'),
                'tab'                         => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dl_new_blog_list_color', [
                'label' => __('Font Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .media-body h3' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'dl_new_blog_list_hover_color', [
                'label' => __('Hover Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .media-body h3:hover' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dl_new_blog_list_typo',
                'label' => __('Typography', 'donarity-core'),
                'selector' => '
                    {{WRAPPER}} .home_news_list_item .media-body h3
                ',
            ]
        );

        

        $this->end_controls_section(); // Post Title Style

        //=========================== Blog Date Style ========================= //
        $this->start_controls_section(
            'dl_new_blog_list_date', [
                'label'                       => __('Date', 'donarity-core'),
                'tab'                         => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'dl_new_blog_list_date_heading',
			[
				'label' => esc_html__( 'Normal Text', 'donarity-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

        $this->add_control(
            'dl_new_blog_list_date_color', [
                'label' => __('Font Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .news_post_date span' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dl_new_blog_list_date_typo',
                'label' => __('Typography', 'donarity-core'),
                'selector' => '
                    {{WRAPPER}} .home_news_list_item .news_post_date span
                ',
            ]
        );

        $this->add_control(
			'dl_new_blog_list_date_heading_high',
			[
				'label' => esc_html__( 'Highlighted Text', 'donarity-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

        $this->add_control(
            'dl_new_blog_list_date_color_high', [
                'label' => __('Font Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .news_post_date strong' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dl_new_blog_list_date_typo_high',
                'label' => __('Typography', 'donarity-core'),
                'selector' => '
                    {{WRAPPER}} .home_news_list_item .news_post_date strong
                ',
            ]
        );


        $this->end_controls_section(); // Blog Date Style


        //=========================== Blog Button Style ========================= //
        $this->start_controls_section(
            'dl_new_blog_list_button', [
                'label'                       => __('Button', 'donarity-core'),
                'tab'                         => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dl_new_blog_list_color_button', [
                'label' => __('Font Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .media-body .news_btn a' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'dl_new_blog_list_hover_button', [
                'label' => __('Hover Color', 'donarity-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .home_news_list_item .media-body .news_btn a:hover' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dl_new_blog_list_button_typo',
                'label' => __('Typography', 'donarity-core'),
                'selector' => '
                    {{WRAPPER}} .home_news_list_item .media-body .news_btn a
                ',
            ]
        );

        $this->end_controls_section(); // Blog Button Style

    }
    



    protected function render() {

        $settings = $this->get_settings_for_display();
        $id_int = substr( $this->get_id_int(), 0, 3 );
        extract($settings); // Array to variable conversation

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $paged
        ];

        if ( !empty($settings['show_count'] ) ) {
            $args['posts_per_page'] = $settings['show_count'];
        }

        if ( !empty($settings['order'] ) ) {
            $args['order'] = $settings['order'];
        }

        if ( !empty($settings['orderby'] ) ) {
            $args['orderby'] = $settings['orderby'];
        }

        if ( !empty($settings['exclude'] ) ) {
            $args['post__not_in'] = $settings['exclude'];
        }

        $posts = new \WP_Query( $args );

        if ( $posts->have_posts() && !in_array( $style, ['15'])) :

            $data_settings = [];

            $data_settings['excerpt_length'] = $excerpt_length;
            $data_settings['title_length'] = $title_length;
            $data_settings['posts_per_page'] = $settings['show_count'];
            $data_settings['order'] = $settings['order'];
            $data_settings['orderby'] = $settings['orderby'];
            $data_settings['post__not_in'] = $settings['exclude'];
            $data_settings['cat'] = $settings['cats'];
            $data_settings['column_grid'] = $column_grid;
            $data_settings['is_title_divider'] = $is_title_divider;
            $data_settings['is_post_excerpt'] = $is_post_excerpt;
            $data_settings['btn_title'] = $btn_title;
            $data_settings['is_post_date'] = $is_post_date;
            $data_settings['is_reading_time'] = $is_reading_time;
            $data_settings['read_more_icon'] = $read_more_icon;
            $data_settings['btn_icon'] = $is_btn_icon;
            $data_settings['style'] = $style;

            $i = 1;
            $data_wow_delay = 0.2;
            $data_wow_duration = 0.9;

            while ( $posts->have_posts() ) : $posts->the_post();

                $title = get_the_title() ? wp_trim_words(get_the_title(), $title_length. '' ) : wp_trim_words(get_the_title(), $title_length. '' );
                $excerpt = get_the_excerpt(get_the_ID()) ? wp_trim_words(get_the_excerpt(get_the_ID()), $excerpt_length, '') : wp_trim_words(get_the_content(get_the_ID()), $excerpt_length, '');
                
                ?>
                    <div class="media home_news_list_item">
                        <div class="news_post_date">
							<strong><?php the_time('m') ?></strong>
							<span><?php the_time('M Y'); ?></span>
						</div>
                        <div class="media-body">
                            <div class="text">
                                <a href="<?php the_permalink(); ?>">
                                    <h3> <?php the_title() ?> </h3>
                                </a>
                            </div>
                            <div class="news_btn">
                                <?php if ( !empty($btn_title) ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="agency_learn_btn h_text_btn" data-text="<?php echo esc_html($btn_title) ?>">
                                        <?php echo esc_html($btn_title) ?> <i class="dlicon dlicon-arrow-3-right-black"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
            
                
            endwhile;
            wp_reset_postdata();
        endif;
    }

    protected function content_template()
    {}
}