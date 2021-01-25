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



    }

    protected function layout_options()
    {

        $this->section_layout_options();
        $this->section_query_options();
    }
//todo
    protected function style_options()
    {
//        die;
    }

    protected function extended_option()
    {
//
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
     * Style > Readmore.
     */

    protected function render($instance = [])
    {

        $gg = $this->get_id();
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
//    public function __construct($data = [], $args = null) {
//        parent::__construct($data, $args);
//        wp_register_script( 'script-handlerrr', plugins_url('/post-slick-slider-elementor-addon/assets/js/slick.min.js') ,['elementor-frontend' ],'1.0.0', true);
//
//        wp_register_script( 'script-handlerr', plugins_url('/post-slick-slider-elementor-addon/assets/js/my_script_tf.js'), [ 'elementor-frontend', 'script-handlerrr'], '1.0.0', true );
//    }
//
//    public function get_script_depends() {
//        return [ 'script-handlerr','script-handlerrr' ];
//    }
}

