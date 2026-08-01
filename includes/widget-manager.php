<?php
/**
 * Elementor widget manager.
 *
 * @package WPRestaurantMenu
 */

namespace WPRestaurantMenu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers Elementor categories, widgets, and assets.
 */
final class Widget_Manager {

	/**
	 * Singleton instance.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
	}

	/**
	 * Register custom Elementor category.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 * @return void
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'wp-restaurant-menu',
			array(
				'title' => esc_html__( 'WP Restaurant Menu', 'wp-restaurant-menu' ),
				'icon'  => 'fa fa-cutlery',
			)
		);
	}

	/**
	 * Register widget assets.
	 *
	 * @return void
	 */
	public function register_styles() {
		wp_register_style(
			'wprm-restaurant-menu',
			WPRM_URL . 'assets/css/restaurant-menu.css',
			array(),
			WPRM_VERSION
		);
	}

	/**
	 * Register widget scripts.
	 *
	 * @return void
	 */
	public function register_scripts() {
		wp_register_script(
			'wprm-restaurant-menu',
			WPRM_URL . 'assets/js/restaurant-menu.js',
			array(),
			WPRM_VERSION,
			true
		);
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		require_once WPRM_PATH . 'includes/widgets/class-restaurant-menu-widget.php';

		$widgets_manager->register( new \WPRestaurantMenu\Widgets\Restaurant_Menu_Widget() );
	}
}
