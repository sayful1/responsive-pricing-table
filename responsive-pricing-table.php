<?php
/**!
 * Plugin Name:         Responsive Pricing Table
 * Plugin URI:          http://wordpress.org/plugins/responsive-pricing-table/
 * Description:         Dynamic responsive pricing table for WordPress.
 * Version:             2.0.0
 * Author:              Sayful Islam
 * Author URI:          https://sayfulislam.com
 * Text Domain:         responsive-pricing-table
 * License:             GPLv3
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

class Responsive_Pricing_Table {

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	private $plugin_name = 'responsive-pricing-table';

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $plugin_version = '2.0.0';

	/**
	 * The instance of the class
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;

			// define constants
			self::$instance->define_constants();

			// Include Classes
			self::$instance->include_classes();

			// initialize the classes
			add_action( 'plugins_loaded', array( self::$instance, 'init_classes' ) );

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			register_activation_hook( __FILE__, array( self::$instance, 'plugin_activation' ) );
			register_deactivation_hook( __FILE__, array( self::$instance, 'plugin_deactivate' ) );
		}

		return self::$instance;
	}

	/**
	 * Define plugin constants
	 */
	private function define_constants() {
		define( 'RESPONSIVE_PRICING_TABLE', $this->plugin_name );
		define( 'RESPONSIVE_PRICING_TABLE_VERSION', $this->get_plugin_version() );
		define( 'RESPONSIVE_PRICING_TABLE_FILE', __FILE__ );
		define( 'RESPONSIVE_PRICING_TABLE_PATH', dirname( RESPONSIVE_PRICING_TABLE_FILE ) );
		define( 'RESPONSIVE_PRICING_TABLE_INCLUDES', RESPONSIVE_PRICING_TABLE_PATH . '/includes' );
		define( 'RESPONSIVE_PRICING_TABLE_TEMPLATES', RESPONSIVE_PRICING_TABLE_PATH . '/templates' );
		define( 'RESPONSIVE_PRICING_TABLE_URL', plugins_url( '', RESPONSIVE_PRICING_TABLE_FILE ) );
		define( 'RESPONSIVE_PRICING_TABLE_ASSETS', RESPONSIVE_PRICING_TABLE_URL . '/assets' );
	}

	/**
	 * Load plugin textdomain
	 */
	public function load_textdomain() {
		$locale_file = sprintf( '%1$s-%2$s.mo', $this->plugin_name, get_locale() );
		$global_file = join( DIRECTORY_SEPARATOR, array( WP_LANG_DIR, $this->plugin_name, $locale_file ) );

		// Look in global /wp-content/languages/carousel-slider folder
		if ( file_exists( $global_file ) ) {
			load_textdomain( $this->plugin_name, $global_file );
		}
	}


	/**
	 * Include classes
	 */
	private function include_classes() {
		spl_autoload_register( function ( $className ) {
			if ( class_exists( $className ) ) {
				return;
			}

			// project-specific namespace prefix
			$prefix = 'Sayful\\PricingTable\\';

			// base directory for the namespace prefix
			$base_dir = RESPONSIVE_PRICING_TABLE_INCLUDES . DIRECTORY_SEPARATOR;

			// does the class use the namespace prefix?
			$len = strlen( $prefix );
			if ( strncmp( $prefix, $className, $len ) !== 0 ) {
				// no, move to the next registered autoloader
				return;
			}

			// get the relative class name
			$relative_class = substr( $className, $len );

			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php
			$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

			// if the file exists, require it
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		} );
	}

	/**
	 * Includes files
	 */
	public function init_classes() {
		Sayful\PricingTable\Admin\Admin::init();
		Sayful\PricingTable\Frontend\Frontend::init();
		Sayful\PricingTable\Assets::init();
		Sayful\PricingTable\REST\PricingTableController::init();
	}

	/**
	 * Register plugin activation action for later use, and
	 * Flush rewrite rules on plugin activation
	 * @return void
	 */
	public function plugin_activation() {
		do_action( 'responsive_pricing_table_activation' );
		flush_rewrite_rules();
	}

	/**
	 * Flush rewrite rules on plugin deactivation
	 * @return void
	 */
	public function plugin_deactivate() {
		do_action( 'responsive_pricing_table_deactivate' );
		flush_rewrite_rules();
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_plugin_version() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$this->plugin_version = $this->plugin_version . '-' . time();
		}

		return $this->plugin_version;
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
Responsive_Pricing_Table::instance();
