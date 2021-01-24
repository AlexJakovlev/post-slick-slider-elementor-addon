<?php

namespace ElementorPostSlickSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Elementor_Post_Slick_Slider_Widget extends Widget_Base
{
    private $key_month = "";
    private $key_badge = "";
    private $buff = "";

    public function get_name()
    {
        return 'elementor-blog-posts';
    }

    public function get_title()
    {
        return __('Post Grid', 'post-grid-elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['wpcap-items'];
    }

    private function wpcap_get_all_post_categories($post_type)
    {

        $options = array();

        $taxonomy = 'category';

        if (!empty($taxonomy)) {
            // Get categories for post type.
            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                )
            );
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if (isset($term)) {
                        if (isset($term->slug) && isset($term->name)) {
                            $options[$term->slug] = $term->name;
                        }
                    }
                }
            }
        }

        return $options;
    }

    protected function _register_controls()
    {

        $this->layout_options();
        $this->style_options();
        $this->extended_option();

//		$this->wpcap_content_layout_options();
//		$this->wpcap_content_query_options();
//
//		$this->wpcap_style_layout_options();
//		$this->wpcap_style_box_options();
//		$this->wpcap_style_image_options();
//
//		$this->wpcap_style_title_options();
//		$this->wpcap_style_meta_options();
//		$this->wpcap_style_content_options();
//		$this->wpcap_style_readmore_options();

    }

    protected function layout_options()
    {

        $this->section_layout_options();
        $this->section_query_options();
    }
//todo
    protected function style_options()
    {
        $this->section_layout_style();
        $this->section_box_style();
        $this->section_header_style();
        $this->section_image_style();
        $this->section_badge_style();
        $this->section_title_style();
        $this->section_content_style();
        $this->section_meta_style();
        $this->section_readmore_style();
//        die;
    }

    protected function extended_option()
    {
//
    }

    private function section_badge_style()
    {
        $name = 'badge';
        $label = ucfirst($name);
        $class = '.wp-cap_meta_badge';
        $this->start_controls_section(
            'section_style_' . $name,
            [
                'label' => __($label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
//                    'show_' . $name => 'yes',
                ]
            ]
        );

        $this->responsive_padding($name, $label, $class);
        $this->border_radius($name, $label, $class);
        $this->background_color($name, $label, $class);
        $this->position($name, $label, $class);
//        $this->align($name,$label,$class);
        $this->typography($name, $class);
        $this->color($name, $label, $class);

        $this->end_controls_section();
    }

    private function section_header_style()
    {
        $name = 'header';
        $label = ucfirst($name);
        $class = '.wp-cap_meta_header';
        $this->start_controls_section(
            'section_style_' . $name,
            [
                'label' => __($label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
//                    'show_' . $name => 'yes',
                ]
            ]
        );

        $this->responsive_margin($name, $label, $class);
        $this->responsive_padding($name, $label, $class);

        $this->align($name, $label, $class);
        $this->typography($name, $class);
        $this->color($name, $label, $class);

        $this->end_controls_section();

    }

    private function section_layout_style()
    {
        $name = 'layout';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post a.read-more-btn';

        $this->start_controls_section(
            'section_layout_style',
            [
                'label' => __('Style ' . $label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Columns margin.
        $this->add_control(
            'grid_style_columns_margin',
            [
                'label' => __('Columns margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 24,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

                ],
            ]
        );
//    $this->responsive_margin();
//        $this->responsive_padding()

        // Row margin.
        $this->add_control(
            'grid_style_rows_margin',
            [
                'label' => __('Rows margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function section_readmore_style()
    {
        $name = 'readmore';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post a.read-more-btn';

        $this->start_controls_section(
            'section_readmore',
            [
                'label' => __('Read More', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
//       todo

        $this->color_gradient($name,$label,$class);

        $this->border_radius_before($name,$label,$class);
        $this->align($name, $label, $class);
        $this->border_gradient($name.'border'," border ". $label, $class);
        $this->responsive_margin($name, $label, $class);
        $this->responsive_padding($name, $label, $class);
//        $this->position($name, $label, $class);
        $this->typography($name, $class);
        $this->end_controls_section();

    }

    protected function section_meta_style()
    {
        $name = 'meta';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post .post-grid-meta span';
        $this->start_controls_section(
            'section_meta_style',
            [
                'label' => __('Meta', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->typography($name, $class);

        $this->color($name, $label, $class);
        $this->responsive_padding($name, $label, $class);
        $this->end_controls_section();

    }

    protected function section_title_style()
    {
        $name = 'title';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post .title';

        $this->start_controls_section(
            'section_style_' . $name,
            [
                'label' => __('Title', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->typography($name, $class);

        $this->start_controls_tabs('section_style_color_' . $name);
        $this->color($name, $label, $class);
        $this->end_controls_tabs();

        $this->responsive_margin($name, $label, $class);

        $this->end_controls_section();
    }

    protected function section_content_style()
    {
        // Tab.
        $name = 'content';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post .post-grid-excerpt';

        $this->start_controls_section(
            'section_style_' . $name,
            [
                'label' => __('Content', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->height($name, $label, 'post-grid-text-wrap');
        $this->typography($name, $class);
        $this->color($name, $label, $class . ' p');
        $this->responsive_margin($name, $label, $class);
        $this->end_controls_section();
    }

    /**
     * Content Layout Options.
     */
    protected function section_layout_options()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'post-grid-elementor-addon'),
            ]
        );
        $this->add_control(
            'grid_style',
            [
                'label' => __('Grid Style', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('Layout 1', 'post-grid-elementor-addon'),
                    '2' => esc_html__('Layout 2', 'post-grid-elementor-addon'),
                    '3' => esc_html__('Layout 3', 'post-grid-elementor-addon'),
                    '4' => esc_html__('Layout 4', 'post-grid-elementor-addon'),
                    '5' => esc_html__('Layout 5', 'post-grid-elementor-addon'),
                    '6' => esc_html__('Layout 6', 'post-grid-elementor-addon'),
                ],
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SELECT,
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
                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
                'selectors' => [
                    '.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
                ],
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->add_control(
            'meta_header',
            [
                'label' => __('Header', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->section_badge_layout('header');
        $this->add_control(
            'meta_badge',
            [
                'label' => __('Badge', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->section_badge_layout('badge');

        $this->add_control(
            'show_image',
            [
                'label' => __('Image', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'post_thumbnail',
                'exclude' => ['custom'],
                'default' => 'full',
                'prefix_class' => 'post-thumbnail-size-',
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->show_text('title');

        $this->add_control(
            'meta_data',
            [
                'label' => __('Meta Data', 'post-grid-elementor-addon'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'default' => ['date', 'comments'],
                'multiple' => true,
                'options' => [
                    'author' => __('Author', 'post-grid-elementor-addon'),
                    'date' => __('Date', 'post-grid-elementor-addon'),
                    'categories' => __('Categories', 'post-grid-elementor-addon'),
                    'comments' => __('Comments', 'post-grid-elementor-addon'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_separator',
            [
                'label' => __('Separator Between', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => '/',
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-meta span + span:before' => 'content: "{{VALUE}}"',
                ],
                'condition' => [
                    'meta_data!' => [],
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Excerpt', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'default' => apply_filters('excerpt_length', 25),
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_read_more',
            [
                'label' => __('Read More', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More Text', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Read More »', 'post-grid-elementor-addon'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'content_align',
            [
                'label' => __('Alignment', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'post-grid-elementor-addon'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'post-grid-elementor-addon'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'post-grid-elementor-addon'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-inner' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Content Query Options.
     */
    protected function section_query_options()
    {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        // Post categories
        $this->add_control(
            'post_categories',
            [
                'label' => __('Categories', 'post-grid-elementor-addon'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->wpcap_get_all_post_categories('post'),

            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date' => __('Date', 'post-grid-elementor-addon'),
                    'post_title' => __('Title', 'post-grid-elementor-addon'),
                    'rand' => __('Random', 'post-grid-elementor-addon'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => __('ASC', 'post-grid-elementor-addon'),
                    'desc' => __('DESC', 'post-grid-elementor-addon'),
                ],
            ]
        );
        $this->end_controls_section();
    }


    /**
     * Style Box Options.
     */
    private function wpcap_style_box_options()
    {


        $this->start_controls_tabs('grid_button_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_button_style_normal',
            [
                'label' => __('Normal', 'post-grid-elementor-addon'),
            ]
        );

        // Normal background color.


        // Normal border color.
        $this->add_control(
            'grid_button_style_normal_border_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Border Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Normal box shadow.
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'grid_button_style_normal_box_shadow',
                'selector' => '{{WRAPPER}} .wpcap-grid-container .wpcap-post',
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_button_style_hover',
            [
                'label' => __('Hover', 'post-grid-elementor-addon'),
            ]
        );

        // Hover background color.
        $this->add_control(
            'grid_button_style_hover_bg_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Background Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover border color.
        $this->add_control(
            'grid_button_style_hover_border_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Border Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Hover box shadow.
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'grid_button_style_hover_box_shadow',
                'selector' => '{{WRAPPER}} .wpcap-grid-container .wpcap-post:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Style Image Options.
     */
    private function wpcap_style_image_options()
    {

        // Box.


        // Image border radius.
        $this->add_control(
            'grid_image_border_radius',
            [
                'label' => __('Border Radius', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-inner .post-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_style_image_margin',
            [
                'label' => __('Margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-inner .post-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Style > Title.
     */
    private function wpcap_style_title_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_title_style',
            [
                'label' => __('Title', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Title typography.
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'grid_title_style_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wpcap-grid-container .wpcap-post .title, {{WRAPPER}} .wpcap-grid-container .wpcap-post .title > a',
            ]
        );

        $this->start_controls_tabs('grid_title_color_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_title_style_normal',
            array(
                'label' => esc_html__('Normal', 'post-grid-elementor-addon'),
            )
        );

        // Title color.
        $this->add_control(
            'grid_title_style_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .title, {{WRAPPER}} .wpcap-grid-container .wpcap-post .title > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_title_style_hover',
            array(
                'label' => esc_html__('Hover', 'post-grid-elementor-addon'),
            )
        );

        // Title hover color.
        $this->add_control(
            'grid_title_style_hover_color',
            array(
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'post-grid-elementor-addon'),
                'scheme' => array(
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .title, {{WRAPPER}} .wpcap-grid-container .wpcap-post .title > a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Title margin.
        $this->add_responsive_control(
            'grid_title_style_margin',
            [
                'label' => __('Margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .title, {{WRAPPER}} .wpcap-grid-container .wpcap-post .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Meta.
     */
    private function wpcap_style_meta_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_meta_style',
            [
                'label' => __('Meta', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Meta typography.
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'grid_meta_style_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-meta span',
            ]
        );

        // Meta color.
        $this->add_control(
            'grid_meta_style_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-meta span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-meta span a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Meta margin.
        $this->add_responsive_control(
            'grid_meta_style_margin',
            [
                'label' => __('Margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Content.
     */
    private function wpcap_style_content_options()
    {


        // Content typography.


        // Content color.
        $this->add_control(
            'grid_content_style_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-excerpt p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Content margin
        $this->add_responsive_control(
            'grid_content_style_margin',
            [
                'label' => __('Margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post .post-grid-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Readmore.
     */
    private function wpcap_style_readmore_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_readmore_style',
            [
                'label' => __('Read More', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Readmore typography.
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'grid_readmore_style_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .wpcap-grid-container .wpcap-post a.read-more-btn',
            ]
        );

        $this->start_controls_tabs('grid_readmore_color_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_readmore_style_normal',
            array(
                'label' => esc_html__('Normal', 'post-grid-elementor-addon'),
            )
        );

        // Readmore color.
        $this->add_control(
            'grid_readmore_style_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post a.read-more-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_readmore_style_color_hover_tab',
            array(
                'label' => esc_html__('Hover', 'post-grid-elementor-addon'),
            )
        );

        // Readmore hover color.
        $this->add_control(
            'grid_readmore_style_hover_color',
            array(
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'post-grid-elementor-addon'),
                'scheme' => array(
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post a.read-more-btn:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Readmore margin
        $this->add_responsive_control(
            'grid_readmore_style_margin',
            [
                'label' => __('Margin', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wpcap-grid-container .wpcap-post a.read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render($instance = [])
    {

        $settings = $this->get_settings();
////
//        $tagString = $settings["__dynamic__"];
//        if (isset($settings["__dynamic__"]['Link_header'])) {
//            $this->get_key_custom_field('Link_header', $tagString['Link_header']);
//            $this->key_month = $this->buff;
//        }
//        if (isset($settings["__dynamic__"]['Link_badge'])) {
//            $this->get_key_custom_field('Link_badge', $tagString['Link_badge']);
//            $this->key_badge = $this->buff;
//        }
//        // Get settings.
//        $settings = $this->get_settings();

//        ?>
<!--        <div class="wpcap-grid">-->
<!--            --><?php
//
//            $columns_desktop = (!empty($settings['columns']) ? 'wpcap-grid-desktop-' . $settings['columns'] : 'wpcap-grid-desktop-3');
//
//            $columns_tablet = (!empty($settings['columns_tablet']) ? ' wpcap-grid-tablet-' . $settings['columns_tablet'] : ' wpcap-grid-tablet-2');
//
//            $columns_mobile = (!empty($settings['columns_mobile']) ? ' wpcap-grid-mobile-' . $settings['columns_mobile'] : ' wpcap-grid-mobile-1');
//
//            $grid_style = $settings['grid_style'];
//
//            $grid_class = '';
//
//            if (5 == $grid_style) {
//
//                $grid_class = ' grid-meta-bottom';
//
//            }
            ?>
<!--            <div class="wpcap-grid-container elementor-grid --><?php //echo $columns_desktop . $columns_tablet . $columns_mobile . $grid_class; ?><!--">-->

                <?php

//                $posts_per_page = (!empty($settings['posts_per_page']) ? $settings['posts_per_page'] : 3);

                $cats = is_array($settings['post_categories']) ? implode(',', $settings['post_categories']) : $settings['post_categories'];

                $query_args = array(
                    'posts_per_page' => -1,
                    'no_found_rows' => true,
                    'post__not_in' => get_option('sticky_posts'),
                    'ignore_sticky_posts' => true,
                    'category_name' => $cats
                );

                // Order by.
                if (!empty($settings['orderby'])) {
                    $query_args['orderby'] = $settings['orderby'];
                }

                // Order .
                if (!empty($settings['order'])) {
                    $query_args['order'] = $settings['order'];
                }

                $all_posts = new \WP_Query($query_args);

                if ($all_posts->have_posts()) :



                        include(__DIR__ . '/layouts/layout-6.php');



                endif; ?>

<!--            </div>-->
<!--        </div>-->
        <?php

    }

    public function wpcap_filter_excerpt_length($length)
    {

        $settings = $this->get_settings();

        $excerpt_length = (!empty($settings['excerpt_length'])) ? absint($settings['excerpt_length']) : 25;

        return absint($excerpt_length);
    }

    public function wpcap_filter_excerpt_more($more)
    {
        return '&hellip;';
    }

    protected function render_thumbnail()
    {

//        $settings = $this->get_settings();
//
//        $show_image = $settings['show_image'];
//
//        if ('yes' !== $show_image) {
//            return;
//        }
//
//        $post_thumbnail_size = $settings['post_thumbnail_size'];

        if (has_post_thumbnail()) : ?>

                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('thumbnail_size'); ?>
                </a>

        <?php endif;
    }

    protected function render_title()
    {

        $settings = $this->get_settings();

        $show_title = $settings['show_title'];

        if ('yes' !== $show_title) {
            return;
        }

        $title_tag = $settings['tag_title'];

        ?>
        <<?php echo $title_tag; ?> class="title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </<?php echo $title_tag; ?>>
        <?php
    }

    protected function render_meta()
    {

        $settings = $this->get_settings();

        $meta_data = $settings['meta_data'];

        if (empty($meta_data)) {
            return;
        }

        ?>
        <div class="post-grid-meta">
            <?php
            if (in_array('author', $meta_data)) { ?>

                <span class="post-author"><?php the_author(); ?></span>

                <?php
            }

            if (in_array('date', $meta_data)) { ?>

                <span class="post-author"><?php echo apply_filters('the_date', get_the_date(), get_option('date_format'), '', ''); ?></span>

                <?php
            }

            if (in_array('categories', $meta_data)) {

                $categories_list = get_the_category_list(esc_html__(', ', 'post-grid-elementor-addon'));

                if ($categories_list) {
                    printf('<span class="post-categories">%s</span>', $categories_list); // WPCS: XSS OK.
                }

            }

            if (in_array('comments', $meta_data)) { ?>

                <span class="post-comments"><?php comments_number(); ?></span>

                <?php
            }
            ?>
        </div>
        <?php

    }

    protected function render_excerpt()
    {

        $settings = $this->get_settings();

        $show_excerpt = $settings['show_excerpt'];

        if ('yes' !== $show_excerpt) {
            return;
        }

        add_filter('excerpt_more', [$this, 'wpcap_filter_excerpt_more'], 20);
        add_filter('excerpt_length', [$this, 'wpcap_filter_excerpt_length'], 9999);

        ?>
        <div class="post-grid-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php

        remove_filter('excerpt_length', [$this, 'wpcap_filter_excerpt_length'], 9999);
        remove_filter('excerpt_more', [$this, 'wpcap_filter_excerpt_more'], 20);
    }

    protected function render_readmore()
    {

        $settings = $this->get_settings();

        $show_read_more = $settings['show_read_more'];
        $read_more_text = $settings['read_more_text'];

        if ('yes' !== $show_read_more) {
            return;
        }
        ?>

        <div>
            <a class="read-more-btn" style="position: relative"  href="<?php the_permalink(); ?>"><?php echo $read_more_text ?></a>
        </div>

        <?php

    }

    private function show_text($name)
    {
        $label = ucfirst($name);
        $this->add_control(
            'show_' . $name,
            [
                'label' => __($label, 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'tag_' . $name,
            [
                'label' => __(' HTML Tag ' . $label, 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
                'condition' => [
                    'show_' . $name => 'yes',
                ],
            ]
        );
    }


    private function section_box_style()
    {
        // Box.
        $name = 'box';
        $label = ucfirst($name);
        $class = '.wpcap-grid-container .wpcap-post';

        $this->start_controls_section(
            'section_box',
            [
                'label' => __($label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->border_style_box($name, $label, $class);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function border_style_box($name, $label, $class)
    {

        $this->border_width($name, $label, $class);
        $this->border_radius($name, $label, $class);
        $this->responsive_padding($name, $label, $class);

    }

    private function border_radius($name, $label, $class)
    {
        $this->add_control(
            'border_radius_' . $name,
            [
                'label' => __($label . ' Border', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class  => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    private function border_width($name, $label, $class)
    {
        $this->add_control(
            'border_width_' . $name,
            [
                'label' => __($label . ' Border Widget', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
    }

    private function responsive_padding($name, $label, $class)
    {
        $this->add_responsive_control(
            'style_padding_' . $name,
            [
                'label' => __($label . ' Padding', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
    }

    private function responsive_margin($name, $label, $class)
    {
        $this->add_responsive_control(
            'style_margin_' . $name,
            [
                'label' => __(' Padding ' . $label, 'post-grid-elementor-addon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
    }

    private function background_color($name, $label, $class)
    {
        $this->add_control(
            'bg_color_' . $name,
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Background Color ' . $label, 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'background-color: {{VALUE}};',
                ],
            ]
        );
    }

    private function section_image_style()
    {
        $name = 'image';
        $label = ucfirst($name);
        $class = '.post-grid-inner .post-grid-thumbnail img';
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_' . $name => 'yes',
                ]
            ]
        );
        $this->border_radius($name, $label, $class);
        $this->responsive_padding($name, $label, ".post-grid-inner .post-grid-thumbnail");
        $this->end_controls_section();
    }

    private function section_head_style()
    {

    }

    private function typography($name, $class)
    {
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'style_typography_' . $name,
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} ' . $class,
            ]
        );
    }

    private function color($name, $label, $class)
    {
        $this->add_control(
            'style_color_' . $name,
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color ' . $label, 'post-grid-elementor-addon'),
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'color: {{VALUE}};',
                ],
            ]
        );
    }

    private function section_badge_layout($name)
    {
//        $this->add_control(
//            'badge_' . $name,
//            [
//                'label' => __('Badge '.$name.'z', 'post-grid-elementor-addon') . $name,
//                'type' => Controls_Manager::SWITCHER,
//                'label_on' => __('Show', 'post-grid-elementor-addon'),
//                'label_off' => __('Hide', 'post-grid-elementor-addon'),
//                'default' => 'yes',
//                'separator' => 'before',
//            ]
//        );
        $this->add_control(
            'Link_' . $name,
            [
                'label' => __('Meta ' . $name, 'elementor'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                ],
                'separator' => 'before',
                'condition' => [
                    'meta_' . $name => 'yes',
                ],
            ]
        );

//        $this->add_control(
//            'size_' . $name,
//            [
//                'label' => __('Size', 'elementor'),
//                'type' => Controls_Manager::SELECT,
//                'default' => 'default',
//                'options' => [
//                    'default' => __('Default', 'elementor'),
//                    'small' => __('Small', 'elementor'),
//                    'medium' => __('Medium', 'elementor'),
//                    'large' => __('Large', 'elementor'),
//                    'xl' => __('XL', 'elementor'),
//                    'xxl' => __('XXL', 'elementor'),
//                ],
//                'condition' => [
//                    'title_' . $name => 'yes',
//                ],
//            ]
//        );

        $this->add_control(
            'meta_tag_' . $name,
            [
                'label' => __('HTML Tag ' . $name, 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
                'condition' => [
                    'meta_' . $name => 'yes',
                ],
            ]
        );


        $this->add_control(
            'view_' . $name,
            [
                'label' => __('View', 'elementor'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
//                    'condition' => [
//                        'title_'.$name => 'yes',
//                    ],
            ]
        );

    }

    private function align($name, $lable, $class)
    {
        $this->add_responsive_control(
            'align_' . $name,
            [
                'label' => __('Alignment ' . $lable, 'elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'elementor'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'text-align: {{VALUE}};',
                ],
//                'condition' => [
//                    'title_' . $name => 'yes',
//                ],
            ]
        );
    }

    private function position($name, $label, $class)
    {

//        $this->start_controls_section(
//            'section_position'.$name,
//            [
//                'label' => __('Position '.$label, 'elementor'),
//                'tab' => Controls_Manager::TAB_ADVANCED,
//            ]
//        );


//        $this->add_responsive_control(
//            '_element_vertical_align'.$name,
//            [
//                'label' => __('Vertical Align '.$label, 'elementor'),
//                'type' => Controls_Manager::CHOOSE,
//                'options' => [
//                    'flex-start' => [
//                        'title' => __('Start', 'elementor'),
//                        'icon' => 'eicon-v-align-top',
//                    ],
//                    'center' => [
//                        'title' => __('Center', 'elementor'),
//                        'icon' => 'eicon-v-align-middle',
//                    ],
//                    'flex-end' => [
//                        'title' => __('End', 'elementor'),
//                        'icon' => 'eicon-v-align-bottom',
//                    ],
//                ],
////                'condition' => [
////                    '_element_width1!' => '',
////                    '_position1' => '',
////                ],
//                'selectors' => [
//                    '{{WRAPPER}} '.$class => 'align-self: {{VALUE}}',
//                ],
//            ]
//        );

//        $this->add_control(
//            '_position_description'.$name,
//            [
//                'raw' => '<strong>' . __('Please note!', 'elementor') . '</strong> ' . __('Custom positioning is not considered best practice for responsive web design and should not be used too frequently.', 'elementor'),
//                'type' => Controls_Manager::RAW_HTML,
//                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
//                'render_type' => 'ui',
////                'condition' => [
////                    '_position1!' => '',
////                ],
//            ]
//        );

//        $this->add_control(
//            '_position1',
//            [
//                'label' => __('Position', 'elementor'),
//                'type' => Controls_Manager::SELECT,
//                'default' => '',
//                'options' => [
//                    '' => __('Default', 'elementor'),
//                    'absolute' => __('Absolute', 'elementor'),
////                    'fixed' => __( 'Fixed', 'elementor' ),
//                ],
//                'selectors' => [
//                    '{{WRAPPER}} ' . $element => 'position: absolute'],
////                'prefix_class' => 'elementor-',
//                'frontend_available' => true,
//            ]
//        );
//
        $start = is_rtl() ? __('Right', 'elementor') : __('Left', 'elementor');
        $end = !is_rtl() ? __('Right', 'elementor') : __('Left', 'elementor');

        $this->add_control(
            '_offset_orientation_h' . $name,
            [
                'label' => __('Horizontal Orientation', 'elementor'),
                'type' => Controls_Manager::CHOOSE,
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
//                'condition' => [
//                    '_position1!' => '',
//                ],
            ]
        );

        $this->add_responsive_control(
            '_offset_x' . $name,
            [
                'label' => __('Offset', 'elementor'),
                'type' => Controls_Manager::SLIDER,
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
                'size_units' => ['px', '%', 'vw', 'vh'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} ' . $class => 'left: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}}' . $class => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    '_offset_orientation_h' . $name . '!' => 'end',
//                    '_position1!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            '_offset_x_end' . $name,
            [
                'label' => __('Offset', 'elementor'),
                'type' => Controls_Manager::SLIDER,
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
                'size_units' => ['px', '%', 'vw', 'vh'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} ' . $class => 'right: {{SIZE}}{{UNIT}}',
                    'body.rtl {{WRAPPER}} ' . $class => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    '_offset_orientation_h' . $name => 'end',
//                    '_position1!' => '',
                ],
            ]
        );

        $this->add_control(
            '_offset_orientation_v' . $name,
            [
                'label' => __('Vertical Orientation', 'elementor'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => __('Top', 'elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => __('Bottom', 'elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
//                'condition' => [
//                    '_position1!' => '',
//                ],
            ]
        );

        $this->add_responsive_control(
            '_offset_y' . $name,
            [
                'label' => __('Offset', 'elementor'),
                'type' => Controls_Manager::SLIDER,
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
                'size_units' => ['px', '%', 'vh', 'vw'],
                'default' => [
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    '_offset_orientation_v' . $name . '!' => 'end',
//                    '_position1!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            '_offset_y_end' . $name,
            [
                'label' => __('Offset', 'elementor'),
                'type' => Controls_Manager::SLIDER,
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
                'size_units' => ['px', '%', 'vh', 'vw'],
                'default' => [
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    '_offset_orientation_v' . $name => 'end',
//                    '_position1!' => '',
                ],
            ]
        );

//        $this->end_controls_section();

    }

    protected function render_month_title($name, $key)
    {

        $settings = $this->get_settings_for_display();
        $element = 'meta_' . $name;
        if ('' === $settings[$element]) {
            return;
        }
        $this->remove_render_attribute($element);
////        $this->add_render_attribute($element, 'class', 'elementor-heading-title');
////        // todo некрасиво!!!!
        $this->add_render_attribute($element, 'class', 'wp-cap_' . $element);
//        if (!empty($settings['size_' . $name])) {
//            $this->add_render_attribute($element, 'class', 'elementor-size-' . $settings['size_'. $name]);
//        }
//
//        $this->add_inline_editing_attributes($element);
//
////        $title = $settings['title_'.$name];

        $meta_key = get_post_meta(get_the_ID());
        // print_r($key);
        // print_r(get_the_ID());
        //    var_dump($meta_key);
        // if  ( (array_key_exists(  $key , $meta_key ))) {
        //    $title = $meta_key[$key][0];
        //  }
        // print_r($title);
//

        // die;
        // print_r(array_key_exists(  $key , $meta_key ));
        // // die;
        $title = array_key_exists($key, $meta_key) ? $meta_key[$key][0] : "";
        $tt = mb_strtoupper($title);
        if ($name === "header") {
            if ($this->buff === $tt) {
                $this->add_render_attribute($element, 'class', "wpcap-hidden");
            } else {
                $this->buff = mb_strtoupper($title);
            }
        }
//        if (!empty($settings['link_' . $name]['url'])) {
//            $this->add_link_attributes('url', $settings['link_' . $name]);
//
//            $title = sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('url'), $title);
//        }

        $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['meta_tag_' . $name], $this->get_render_attribute_string($element), $title);

        echo $title_html;
    }

    private function get_key_custom_field($key, $settings)
    {


//        print_r(urldecode($arr_data));
        preg_match('/name="(.*?(?="))"/', $settings, $tagNameMatch);
        if (!$tagNameMatch || $tagNameMatch[1] === 'post-custom-field') {
            $tagString = $settings;

            preg_replace_callback('/settings="(.*?(?="]))/', function (array $matches) {
                $settings = json_decode(urldecode($matches[1]), true);

                $this->buff = array_key_exists("key", $settings) ? $settings["key"] : $settings["custom_key"];
            }, $tagString);

        }
    }

    private function border_gradient($name, $label, $class)
    {
//        $this->start_controls_tabs('background-gradient' . $name);
//        $this->start_controls_tab(
//            'grid_button_style_normal',
//            [
//                'label' => __('Normal', 'post-grid-elementor-addon'),
//            ]
//        );

        $this->color_gradient($name,$label,$class.':before');
//        $this->color_gradient($name,$label,$class);

        $this->add_control(
            'style_border_color_btn_out_size' . $name,
            [
                'label' => __('Size ', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class . ":before" => ' top: -{{SIZE}}{{UNIT}}; left: -{{SIZE}}{{UNIT}}; right: -{{SIZE}}{{UNIT}}; bottom: -{{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'style_border_radius_btn_' . $name,
            [
                'label' => __('Radius ', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class . ":before" => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $class  => 'border-radius: {{SIZE}}{{UNIT}};',
                ],


            ]
        );


//         $this->add_control(
//             'style_border_color_size_tZ'.$name,
//             [
//                 'label' => __('Size ', 'post-grid-elementor-addon'),
//                 'type' => Controls_Manager::HIDDEN,
//                 'selectors' => [
//                 '{{WRAPPER}} '.$class.":before" => "top: -{{style_border_color_size_ZZVALUE}}px",
//                     ]
//
//             ]
//         );
//        $this->end_controls_tab();
//        $this->start_controls_tab(
//            'grid_button_style_Hover',
//            [
//                'label' => __('Hover', 'post-grid-elementor-addon'),
//            ]
//        );
//
//        $this->end_controls_tab();
//        $this->end_controls_tabs();
    }
    private function height($name, $label, $class){

        $this->add_control(
            'height_block_' . $name,
            [
                'label' => __('Height_ ', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 350,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$name => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

    }
    private function border_radius_before($name, $label, $class)
    {
//        $this->add_control(
//            'border_radius_' . $name,
//            [
//                'label' => __($label . ' Border', 'post-grid-elementor-addon'),
//                'type' => Controls_Manager::SLIDER,
//                'default' => [
//                    'size' => 0,
//                ],
//                'range' => [
//                    'px' => [
//                        'min' => 0,
//                        'max' => 10,
//                    ],
//                ],
//                'selectors' => [
//                    '{{WRAPPER}} ' . $class . 'before' => 'top: -{{SIZE}}{{UNIT}}; left: -{{SIZE}}{{UNIT}};right: -{{SIZE}}{{UNIT}};left: -{{SIZE}}{{UNIT}}',
//                ],
//            ]
//        );
    }
   private function color_widt_hover($name,$label,$class){
//$this->color_widt_hover();
   }
   private function color_gradient($name,$label,$class){
       $this->add_control(
           'style_gradient_color_first_' . $name,
           [
               'type' => Controls_Manager::COLOR,
               'label' => __('First color' . $label, 'post-grid-elementor-addon'),
               'scheme' => [
                   'type' => Scheme_Color::get_type(),
                   'value' => Scheme_Color::COLOR_1,
               ],
               'selectors' => [
                   '{{WRAPPER}} ' . $class  => 'background: linear-gradient(90deg,{{VALUE}}, {{style_gradient_color_second_' . $name . '.VALUE}});',
               ],
           ]
       );
       $this->add_control(
           'style_gradient_color_second_' . $name,
           [
               'type' => Controls_Manager::COLOR,
               'label' => __('Second color' . $label, 'post-grid-elementor-addon'),
               'scheme' => [
                   'type' => Scheme_Color::get_type(),
                   'value' => Scheme_Color::COLOR_1,
               ],
               'selectors' => [
                   '{{WRAPPER}} ' . $class  => 'background: linear-gradient(90deg,{{style_gradient_color_first_' . $name . '.VALUE}}, {{VALUE}});',
               ],
           ]
       );
   }
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script( 'script-handlerrr', plugins_url( '/post-grid-elementor-addon/assets/js/slick.min.js') ,['elementor-frontend' ],'1.0.0', true);

        wp_register_script( 'script-handlerr', plugins_url( '/post-grid-elementor-addon/assets/js/my_script.js'), [ 'elementor-frontend', 'script-handlerrr'], '1.0.0', true );
    }

    public function get_script_depends() {
        return [ 'script-handlerr','script-handlerrr' ];
    }
}

