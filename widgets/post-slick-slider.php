<?php

namespace ElementorPostSlickSlider\Widgets;

use Elementor\Core\Responsive\Responsive;
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
    private $ids = '';

    public function get_name()
    {
        return 'elementor-posts-slick-slider';
    }

    public function get_title()
    {
        return __('Post Slick Slider', 'post-grid-elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['AJ'];
    }

//    public function hexToStr()
//    {
//        $continue = true;
//        $hex = hash('md5', uniqid('', true), false);
//        $strr = '';
////        while ($continue) {
//
//            for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
//                $strr .= chr(hexdec($hex[$i] . $hex[$i + 1]));
//
//            }
////            $re = '/[a-zA-Z]+/';
////            preg_match_all($re, $strr, $matches, PREG_SET_ORDER, 0);
////            $continue = false;
////        }
//        return "ss".$strr;
//    }

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
//        = $this->hexToStr();
        if (!wp_doing_ajax()) {
            if (count($data) > 0) {
                $this->ids = $data['id'] !== null ? 'tt' . $data['id'] : '';
            }
        }

    }

    private function wpcap_get_all_post_categories()
    {

        $options = array();

        $taxonomy = 'category';

        if (!empty($taxonomy)) {
            // Get categories for post type.
            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                    'post_type' => 'post',
                    'suppress_filters' => true,
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
//        $this->ss = $this->get_stack();

        $this->layout_options();
        $this->style_options();
        $this->extended_option();


    }

    protected function layout_options()
    {
        $this->section_layout_options();
        $this->section_slick_slider_options();
        $this->section_query_options();
    }

//todo
    protected function style_options()
    {
        $this->section_layout_style();
        $this->section_style_slider_box();
        $this->section_style_arrow();
        $this->section_style_image();
        $this->section_style_content();
//        die;
    }

    protected function extended_option()
    {

    }

    private function section_style_image()
    {
        $name = 'image';
        $label = ucfirst($name);
        $class = ' img';

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Style ' . $label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'size_img',
            [
                'label' => __('Size Image', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $class => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',

                ],
            ]
        );
        $this->box_border($name, $label, $class);
        $this->end_controls_section();


    }

    private function section_style_content()
    {
        $name = 'content_text';
        $label = ucfirst($name);
        $class = '.pssa .content_text';

        $this->start_controls_section(
            'section_content_text' . $name,
            [
                'label' => __('Style content' . $label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->responsive_margin($name, $label, $class);
        $this->htag2('title');
        $this->responsive_margin($name . 'title', $label . ' Title', $class . " .title");
        $this->typography($name . 'title', $label . ' Title', $class . " .title");
        $this->responsive_margin($name . 'excerpt', $label . ' Excerpt', $class . " .excerpt");
        $this->htag2('excerpt');
        $this->typography($name . 'excerpt', $label . ' Excerpt', $class . " .excerpt");
        $this->end_controls_section();
//        die;

    }

    private function section_style_slider_box()
    {
        $name = 'box_slide';
        $label = ucfirst($name);
        $class = '.wrapper-in';

        $this->start_controls_section(
            'section_slider_box_style',
            [
                'label' => __('Style ' . $label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'size_box_slider' . $name,
            [
                'label' => __($label, 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'no',
                'selectors' => [
                    '{{WRAPPER}} .content_text' => 'height: fit-content;',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'size_box_slider_' . 'content',
            [
                'label' => __($label . ' Border', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pssa .content_text' => 'height: {{SIZE}}{{UNIT}}; overflow: hidden',
                ],
                'condition' => [
                    'size_box_slider' . $name => 'yes'
                ],
            ]
        );
        $this->responsive_margin($name, $label, '.pssa article');
        $this->responsive_padding($name, $label, $class);
        $this->background_color($name, $label, '.pssa article');
        $this->box_border($name, $label, '.wrapper');
        $this->end_controls_section();

    }

// todo
    private function section_layout_style()
    {
        $name = 'layout';
        $label = ucfirst($name);
        $class = '.carousel-wrapper';

        $this->start_controls_section(
            'section_layout_style',
            [
                'label' => __('Style ' . $label, 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->background_color($name, $label, $class);
        $this->typography('header', 'Header', '.header');
        $this->responsive_margin('header', 'Header', '.header');;
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
                'label' => esc_html__('Layout', 'post-slick-slider-elementor-addon'),
            ]
        );


        $this->add_control(
            'header',
            [
                'label' => __('Header', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->htag('header');
        $this->text('header');
        $this->add_control(
            'show_meta',
            [
                'label' => __('Show meta', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'img',
            [
                'label' => __('IMG ', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
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
                    'testimonial' => __('Testimonial', 'post-grid-elementor-addon'),
                ],
                'separator' => 'before',
                'condition' => [
                    'show_meta' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show excerpt', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'post-grid-elementor-addon'),
                'label_off' => __('Hide', 'post-grid-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
//        $this->add_group_control(
//            Group_Control_Image_Size::get_type(),
//            [
//                'name' => 'post_thumbnail',
//                'exclude' => ['custom'],
//                'default' => 'full',
//                'prefix_class' => 'post-thumbnail-size-',
////                'condition' => [
////                    'show_image' => 'yes',
////                ],
//            ]
//        );

        $this->end_controls_section();
    }

    protected function section_slick_slider_options()
    {
        $this->start_controls_section(
            'section_slick_slider',
            [
                'label' => __('Slick Slider', 'post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'speed_slider',
            [
                'label' => __('Speed slider', 'plugin-domain'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 3000,
                'step' => 100,
                'default' => 500,
            ]
        );
        $this->add_responsive_control(
            'slidesToShow',
            [
                'label' => __('slidesToShow', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
//                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'scroll',
            [
                'label' => __('slidesToscroll', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '6',
                ],
//                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'dots',
            [
                'label' => __('dots', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'tablet_default' => 'yes',
                'mobile_default' => 'yes',
//                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'arrow',
            [
                'label' => __('arrow', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'tablet_default' => 'yes',
                'mobile_default' => 'yes',
//                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'easing',
            [
                'label' => __('easing', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'easy',
                'options' => [
                    '1' => 'linear',
                    '2' => 'ease-in',
                    '3' => 'ease-in-out',
                ],
//                'prefix_class' => 'elementor-grid%s-',
//            'frontend_available' => true,
            ]
        );
        $this->add_control(
            'infinity',
            [
                'label' => __('Infinity', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('On', 'post-slick-slider-elementor-addon'),
                'label_off' => __('Off', 'post-slick-slider-elementor-addon'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'auto_play',
            [
                'label' => __('AutoPlay', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('On', 'post-slick-slider-elementor-addon'),
                'label_off' => __('Off', 'post-slick-slider-elementor-addon'),
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'speed_auto_play',
            [
                'label' => __('Speed AutoPlay(mS)', 'plugin-domain'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 10000,
                'step' => 100,
                'default' => 1000,
                'condition' => [
                    'auto_play' => "yes",
                ],


            ]
        );
        $this->add_control(
            'center_mode',
            [
                'label' => __('Center mode', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_responsive_control(
            'master_slave',
            [
                'label' => __('Master or Slave', 'post-slick-slider-elementor-addon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'tablet_default' => 'yes',
                'mobile_default' => 'yes',
//                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => false,
            ]
        );
        $this->add_control(
            'name_this_slider',
            [
                'label' => __('Введите имя этого слайдера', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => 'Name slider <span style="font-size: 14px; color: red; font-weight: bold; letter-spacing: 3px; ">MUST BE UNIQUE!!!! </span> for this slider only  [a-zA-Z]',

                'condition' => [
                    'master_slave' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'class_master_slave',
            [
                'label' => __('Введите имя прикрепленного слайдера', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'master_slave' => 'yes',
                ],
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
        // Post categories get_post_types( $args = array(), $output = 'names', $operator = 'and' );
        $this->add_control(
            'type_post',
            [
                'label' => __('Type POST!! ', 'post-grid-elementor-addon'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
//                'options' => [
//                        '1' => 'post',
//                        '2' => 'wpm-testimonial'
//                ],
                'default' => 'post',

                'options' => get_post_types($args = array(), $output = 'names', $operator = 'and'),

            ]
        );

        $this->add_control(
            'post_categories',
            [
                'label' => __('Categories', 'post-grid-elementor-addon'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->wpcap_get_all_post_categories(),

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

//
        ?>
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
        <!--            <div class="wpcap-grid-container elementor-grid --><?php //echo $columns_desktop . $columns_tablet . $columns_mobile . $grid_class;
        ?><!--">-->

        <?php

//                $posts_per_page = (!empty($settings['posts_per_page']) ? $settings['posts_per_page'] : 3);

        $cats = is_array($settings['post_categories']) ? implode(',', $settings['post_categories']) : $settings['post_categories'];

        $query_args = array(
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'post__not_in' => get_option('sticky_posts'),
            'ignore_sticky_posts' => true,
            'category_name' => $cats,
            'post_type' => $this->get_settings()['type_post'],
        );

        // Order by.
        if (!empty($settings['orderby'])) {
            $query_args['orderby'] = $settings['orderby'];
        }

        // Order .
        if (!empty($settings['order'])) {
            $query_args['order'] = $settings['order'];
        }
//         get_post_types( $args = array(), $output = 'names', $operator = 'and' );
        $all_posts = new \WP_Query($query_args);
        $breakpoints = Responsive::get_editable_breakpoints();
        $set_slider = array(
            'arrows' => $settings['arrow'] === 'yes' ? true : false,
            'dots' => $settings['dots'] === 'yes' ? true : false,
            'slidesToShow' => intval($settings['slidesToShow']),
            'slidesToScroll' => intval($settings['scroll']),
            'speed' => intval($settings['speed_slider']),
            'easing' => $settings['easing'],
            'infinity' => $settings['infinity'] === 'yes' ? true : false,
            'autoplay' => $settings['auto_play'] === 'yes' ? true : false,
            'autoplaySpeed' => intval($settings['speed_auto_play']),
            'asNavFor' => $settings['master_slave'] === 'yes' ? '.' . $settings['class_master_slave'] : '',
            'centerMode' => $settings['center_mode'] === 'yes' ? true : false,
            'responsive' => array(
                array(
                    'breakpoint' => $breakpoints['lg'],
                    'settings' => array(
                        'arrow' => $settings['arrow'] === 'yes' ? true : false,
                        'dots' => $settings['dots'] === 'yes' ? true : false,
                        'slidesToShow' => intval($settings['slidesToShow_tablet']),
                        'slidesToScroll' => intval($settings['scroll_tablet']),
                    ),
                ),
                array(
                    'breakpoint' => $breakpoints['md'],
                    'settings' => array(
                        'arrow' => $settings['arrow'] === 'yes' ? true : false,
                        'dots' => $settings['dots'] === 'yes' ? true : false,
                        'slidesToShow' => intval($settings['slidesToShow_mobile']),
                        'slidesToScroll' => intval($settings['scroll_mobile']),
                    ),
                ),
            ),
//            'mobileFirst' => true,
            // appendArrows: $(".content_arrow_slick"),
        );
        if ($all_posts->have_posts()) :


            include(__DIR__ . '/layouts/layout-6.php');


        endif; ?>

        <!--            </div>-->
        <!--        </div>-->
        <?php

    }

    protected function render_header()
    {
        $settings = $this->get_settings();
        if ($settings['header'] != 'yes') return;


        echo '<' . $settings['tag_header'] . ' class="header">' . $settings['text_header'] . '</' . $settings['tag_header'] . '>';


    }

    protected function render_thumbnail()
    {
        $settings = $this->get_settings();
        if ($settings['img'] != 'yes') return;
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
                <div class="wrapper_img">
                    <?php the_post_thumbnail('thumbnail_size'); ?>
                </div>
            </a>

        <?php endif;
    }

    protected function render_title()
    {
        $settings = $this->get_settings();
        if ($settings['show_title'] != 'yes') return;
        $tag = $settings['tag_title'];
        echo sprintf('<%1$s class="title">%2$s</%3$s>', $tag, esc_html(get_the_title()), $tag);

    }

    protected function render_meta()
    {
        $settings = $this->get_settings();
        if ($settings['show_meta'] !== 'yes') return;
        $meta_data = $settings['meta_data'];

//        if (empty($meta_data)) {
//            return;
//        }
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
            if (in_array('testimonial', $meta_data)) {
                $meta = get_post_meta(get_the_ID(), 'testimonial');
                if ($meta) {
                    $meta = $meta[0];
                    ?>

                    <span class="post-testimonia"><?php echo $meta['profession_key'] ?></span>
                    <span class="post-testimonia"><?php echo $meta['company_key'] ?></span>

                    <?php
                }
            }
            ?>
        </div>
        <?php
    }

    protected function render_excerpt()
    {
        $settings = $this->get_settings();
        if ($settings['show_excerpt'] != 'yes') return;
        $tag = $settings['tag_excerpt'];
        echo sprintf('<%1$s class="excerpt">%2$s</%3$s>', $tag, esc_html(get_the_excerpt()), $tag);
    }

    protected function htag($name)
    {
        $this->add_control(
            'tag_' . $name,
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
                'default' => 'h6',
                'condition' => [
                    $name => 'yes',
                ],
            ]
        );
    }

    protected function htag2($name)
    {
        $this->add_control(
            'tag_' . $name,
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
                'default' => 'h6',

            ]
        );
    }

    protected function text($name, $lable = '', $class = '')
    {
        $this->add_control(
            'text_' . $name,
            [
                'label' => __('Header text', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Заголовок слайдера',
                'condition' => [
                    $name => 'yes',
                ],
            ]
        );

    }

    private function responsive_padding($name, $label, $class)
    {
        $this->add_responsive_control(
            'style_padding_' . $name,
            [
                'label' => __(' Padding ' . $label, 'post-grid-elementor-addon'),
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
                'label' => __('Margin ' . $label, 'post-grid-elementor-addon'),
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

    private function box_border($name, $label, $class)
    {


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow'.$name,
                'label' => __('Box Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} '.$class,
            ]
        );
    }

    private function typography($name, $label, $class)
    {
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography_' . $name,
                'label' => __('Typography ' . $label, 'plugin-domain'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} ' . $class,
            ]
        );
    }

    private function section_style_arrow()
    {
        $this->start_controls_section(
            'section_slider_box_styles',
            [
                'label' => __('Style arr','post-grid-elementor-addon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'arrow_img',
            [
                'label' => __( 'Image Arrow', 'post-grid-elementor-addon' ),
                'type' => Controls_Manager::MEDIA,

                'title' => __( 'Background Image', 'post-grid-elementor-addon' ),
                'selectors' => [
//
////                $ss.' > .slick-arrow' => 'top: 50%; position: absolute; z-index: 10;font-size: 0;width: 60px;height: 30px;border: none;',
                   '{{WRAPPER}} .slick-arrow.slick-prev ' => 'background: url("{{URL}}")  no-repeat;left: 0; position: absolute; z-index: 10;font-size: 0;border: none; background-size:contain',
                '{{WRAPPER}} .slick-arrow.slick-next ' => 'background: url("{{URL}}")  no-repeat; right: 0;transform: scale(-1, 1); position: absolute; z-index: 10;font-size: 0;border: none;background-size:contain',
                ],
            ]);
        $this->add_control(
            'h_size_arrow',
            [
                'label' => __('Height Arrov', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-prev ' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}  .slick-arrow.slick-next ' => 'height: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'w_size_arrow',
            [
                'label' => __('Width Arrov', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-prev ' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}  .slick-arrow.slick-next ' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'pos_l_arrow_prev',
            [
                'label' => __('pos left Arrov prev', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-prev ' => 'left: {{SIZE}}{{UNIT}};',
//                    '{{WRAPPER}} ' . $ss.' .slick-arrow.slick-next ' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'pos_t_arrow_prev',
            [
                'label' => __('pos top Arrov prev', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-prev ' => 'top: {{SIZE}}{{UNIT}};',
//                    '{{WRAPPER}} ' . $ss.' .slick-arrow.slick-next ' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'pos_l_arrow_next',
            [
                'label' => __('pos left Arrov next', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-next ' => 'left: {{SIZE}}{{UNIT}};',
//                    '{{WRAPPER}} ' . $ss.' .slick-arrow.slick-next ' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'pos_t_arrow_next',
            [
                'label' => __('pos top Arrov next', 'post-grid-elementor-addon'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .slick-arrow.slick-next ' => 'top: {{SIZE}}{{UNIT}};',
//                    '{{WRAPPER}} ' . $ss.' .slick-arrow.slick-next ' => 'width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );
        $this->end_controls_section();
    }


//    public function __construct($data = [], $args = null)
//    {
//        parent::__construct($data, $args);
//        wp_register_script('script-handlerrr', plugins_url('/post-slick-slider-elementor-addon/assets/js/slick.min.js'), ['elementor-frontend'], '1.0.0', true);
//
//        wp_register_script('script-handlerr', plugins_url('/post-slick-slider-elementor-addon/assets/js/my_script_tf.js'), ['elementor-frontend', 'script-handlerrr'], '1.0.0', true);
//    }
//
//    public function get_script_depends()
//    {
//        return ['script-handlerr', 'script-handlerrr'];
//    }
}

