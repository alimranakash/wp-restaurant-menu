<?php
/**
 * Plugin Name: WP Restaurant Menu
 * Plugin URI: https://worzen.com
 * Description: Custom Elementor widgets for premium restaurant menu layouts.
 * Version: 1.0.3
 * Author: Al Imran Akash
 * Author URI: https://profiles.wordpress.org/al-imran-akash/
 * Text Domain: wp-restaurant-menu
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Elementor tested up to: 3.24.0
 *
 * @package WPRestaurantMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPRM_VERSION', '1.0.0' );
define( 'WPRM_FILE', __FILE__ );
define( 'WPRM_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPRM_URL', plugin_dir_url( __FILE__ ) );

require_once WPRM_PATH . 'includes/plugin.php';

add_action(
	'plugins_loaded',
	static function () {
		\WPRestaurantMenu\Plugin::instance();
	}
);
