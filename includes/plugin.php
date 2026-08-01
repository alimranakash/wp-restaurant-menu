<?php
/**
 * Main plugin class.
 *
 * @package WPRestaurantMenu
 */

namespace WPRestaurantMenu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstraps the plugin.
 */
final class Plugin {

	/**
	 * Plugin singleton instance.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
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
	 * Plugin constructor.
	 */
	private function __construct() {
		$this->includes();

		add_action( 'init', array( $this, 'load_textdomain' ) );

		if ( did_action( 'elementor/loaded' ) ) {
			add_action( 'elementor/init', array( $this, 'init_elementor' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'missing_elementor_notice' ) );
		}
	}

	/**
	 * Include plugin dependencies.
	 *
	 * @return void
	 */
	private function includes() {
		require_once WPRM_PATH . 'includes/widget-manager.php';
	}

	/**
	 * Load plugin translations.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'wp-restaurant-menu', false, dirname( plugin_basename( WPRM_FILE ) ) . '/languages' );
	}

	/**
	 * Initialize Elementor integration.
	 *
	 * @return void
	 */
	public function init_elementor() {
		Widget_Manager::instance();
	}

	/**
	 * Render Elementor missing notice.
	 *
	 * @return void
	 */
	public function missing_elementor_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		printf(
			'<div class="notice notice-warning"><p>%s</p></div>',
			esc_html__( 'WP Restaurant Menu requires Elementor to be installed and activated.', 'wp-restaurant-menu' )
		);
	}
}
