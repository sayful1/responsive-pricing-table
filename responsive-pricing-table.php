<?php
/*
Plugin Name: 	Responsive Pricing Table
Plugin URI: 	http://wordpress.org/plugins/responsive-pricing-table/
Description: 	Dynamic responsive pricing table for WordPress.
Version: 		1.2.0
Author: 		Sayful Islam
Author URI: 	http://sayfulit.com
Text Domain: 	responsive-pricing-table
Domain Path: 	/languages/
License: 		GPLv2 or later
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Responsive_Pricing_Table' ) ):

	class Responsive_Pricing_Table {

		private $plugin_name = 'responsive-pricing-table';
		private $plugin_version = '1.2.0';
		private $plugin_url;
		private $plugin_path;

		protected static $instance = null;

		/**
		 * Main Responsive_Pricing_Table Instance
		 * Ensures only one instance of Responsive_Pricing_Table is loaded or can be loaded.
		 */
		public static function instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function __construct() {
			// define constants
			$this->define_constants();

			register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivate' ) );

			// add_action( 'plugins_loaded', array( $this, 'textdomain') );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ), 20 );

			$this->includes();
		}

		/**
		 * Define constants
		 */
		private function define_constants() {
			define( 'RESPONSIVE_PRICING_TABLE_VERSION', $this->plugin_version );
			define( 'RESPONSIVE_PRICING_TABLE_FILE', __FILE__ );
			define( 'RESPONSIVE_PRICING_TABLE_PATH', dirname( RESPONSIVE_PRICING_TABLE_FILE ) );
			define( 'RESPONSIVE_PRICING_TABLE_INCLUDES', RESPONSIVE_PRICING_TABLE_PATH . '/includes' );
			define( 'RESPONSIVE_PRICING_TABLE_TEMPLATES', RESPONSIVE_PRICING_TABLE_PATH . '/templates' );
			define( 'RESPONSIVE_PRICING_TABLE_URL', plugins_url( '', RESPONSIVE_PRICING_TABLE_FILE ) );
			define( 'RESPONSIVE_PRICING_TABLE_ASSETS', RESPONSIVE_PRICING_TABLE_URL . '/assets' );
			define( 'RESPONSIVE_PRICING_TABLE_UPLOAD_DIR', 'dcf-attachments' );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		public function includes() {
			if ( is_admin() ) {
				$this->admin_includes();
			}
			if ( ! is_admin() ) {
				$this->frontend_includes();
			}

			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Activation.php';
		}

		public function admin_includes() {
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Form.php';
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Admin.php';

			new Responsive_Pricing_Table_Admin( $this->plugin_path() );
		}

		public function frontend_includes() {
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Shortcode.php';

			new Responsive_Pricing_Table_Shortcode( $this->plugin_path() );
		}

		public function textdomain() {
			load_plugin_textdomain( 'responsive-pricing-table', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		public function admin_scripts() {
			global $post_type;
			if ( 'pricing_tables' !== $post_type ) {
				return;
			}

			wp_enqueue_style(
				$this->plugin_name . '-admin',
				$this->plugin_url() . '/assets/css/admin.css',
				array( 'wp-color-picker' ),
				$this->plugin_version,
				'all'
			);

			wp_enqueue_script(
				$this->plugin_name . '-admin',
				$this->plugin_url() . '/assets/js/admin.js',
				array(
					'jquery',
					'wp-color-picker',
					'jquery-ui-accordion',
					'jquery-ui-sortable'
				),
				$this->plugin_version,
				true
			);
		}

		public function front_scripts() {
			wp_enqueue_style(
				$this->plugin_name,
				RESPONSIVE_PRICING_TABLE_ASSETS . '/css/style.css',
				array(),
				$this->plugin_version,
				'all'
			);
		}

		/**
		 * Plugin path.
		 *
		 * @return string Plugin path
		 */
		private function plugin_path() {
			if ( $this->plugin_path ) {
				return $this->plugin_path;
			}

			return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Plugin url.
		 *
		 * @return string Plugin url
		 */
		private function plugin_url() {
			if ( $this->plugin_url ) {
				return $this->plugin_url;
			}

			return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
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
	}

endif;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
Responsive_Pricing_Table::instance();
