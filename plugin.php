<?php

namespace ElementorPostSlickSlider;

/**
 * Class Elementor_Post_Grid_Main
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Elementor_Post_Slick_Slider_Main
{

    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return Plugin An instance of the class.
     * @since 1.2.0
     * @access public
     *
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * widget_style
     *
     * Load main style files.
     *
     * @since 1.0.0
     * @access public
     */

    public function widget_styles()
    {
//	    $pp = plugins_url( '/post-slick-slider-elementor-addon/assets/css/aj-slick-slider.css');
        wp_register_style('posts-slick-slider-elementor-addon-main', plugins_url('/post-slick-slider-elementor-addon/assets/css/aj-slick-slider.css'));
        wp_enqueue_style('posts-slick-slider-elementor-addon-main');
    }


    public function widget_scripts()
    {
        wp_enqueue_script('posts-slick-slider-js', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'));

        add_action('elementor/frontend/after_enqueue_scripts', function () {
            if (!wp_script_is('posts-slick-slider-addon', 'registered')) {
                $c ="";
                $path = plugins_url('/assets/js/my_script.js', __FILE__);
                wp_register_script('posts-slick-slider-addon', $path,['posts-slick-slider-js']);

            }
            wp_enqueue_script('posts-slick-slider-addon');
        });
        add_action('elementor/preview/enqueue_styles', function () {
            $c= '';
            $path = plugins_url('/assets/js/my_script_tf.js', __FILE__);
            wp_register_script('posts-slick-slider-addon',$path, ['elementor-frontend','posts-slick-slider-js'] );

        });


//        add_action('elementor/widget/render_content', function ($content) {
//            $p = plugins_url('/assets/js/slick.min.js', __FILE__);
//            if (!wp_script_is('posts-slick-slider-addonss')) {
//                wp_enqueue_script('posts-slick-slider-addonss', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery','elementor-frontend'));
//            }
//            if (!wp_script_is('posts-slick-slider-addon')) {
//                wp_enqueue_script('posts-slick-slider-addon', plugins_url('/assets/js/my_script.js', __FILE__), array('posts-slick-slider-addonss'));
//            }
//            return $content;
//        }, 10, 1);
// вывод фронта
//            wp_register_script('posts-slick-slider-addonss', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'));
//            wp_register_script('posts-slick-slider-addon', plugins_url('/assets/js/my_script_tf.js', __FILE__), array('posts-slick-slider-addonss'));
//            wp_enqueue_script('posts-slick-slider-addonss');
//            wp_enqueue_script('posts-slick-slider-addon');


    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files()
    {
        require_once(__DIR__ . '/widgets/post-slick-slider.php');
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets()
    {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();

        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Elementor_Post_Slick_Slider_Widget());
    }

    public function register_widget_category($elements_manager)
    {

        $elements_manager->add_category(
            'AJ',
            [
                'title' => __('AJ Elements', 'post-slick-slider-elementor-addon'),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct()
    {

        // Register widget style
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

        add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);


    }

}

// Instantiate Plugin Class
Elementor_Post_Slick_Slider_Main::instance();
