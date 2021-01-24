<?php
namespace ElementorPostSlickSlider;

/**
 * Class Elementor_Post_Grid_Main
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Elementor_Post_Slick_Slider_Main {

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
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
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

	public function widget_styles() {
		wp_register_style( 'post-grid-elementor-addon-main', plugins_url( '/assets/css/main.css', __FILE__ ) );
		wp_enqueue_style( 'post-grid-elementor-addon-main' );
	}


    public function widget_scripts()
    {
        add_action( 'elementor/widget/render_content', function( ));
        wp_register_script('posts-slick-slider-addonss', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'));
        wp_register_script('posts-slick-slider-addon', plugins_url('/assets/js/my_script.js', __FILE__), array('posts-slick-slider-addonss'));
        wp_enqueue_script('posts-slick-slider-addonss');
        wp_enqueue_script('posts-slick-slider-addon');
//    });
    }

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/post-slick-slider.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Elementor_Post_Slick_Slider_Widget() );
	}

	public function register_widget_category( $elements_manager ) {

		$elements_manager->add_category(
			'aj-items',
			[
				'title' => __( 'AJ Elements', 'post-grid-elementor-addon' ),
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
	public function __construct() {

		// Register widget style
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        // Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );
        add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );


	}

}

// Instantiate Plugin Class
Elementor_Post_Slick_Slider_Main::instance();
