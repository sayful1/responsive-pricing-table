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

if ( ! class_exists( 'Responsive_Pricing_Table' ) ):

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

				add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ) );
				add_action( 'wp_enqueue_scripts', array( self::$instance, 'front_scripts' ), 20 );

				self::$instance->includes();

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
			define( 'RESPONSIVE_PRICING_TABLE_VERSION', $this->plugin_version );
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
		 * Includes files
		 */
		private function includes() {
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Currency.php';
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Form.php';
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Admin.php';
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Activation.php';
			include_once RESPONSIVE_PRICING_TABLE_INCLUDES . '/Responsive_Pricing_Table_Shortcode.php';
		}

		/**
		 * Load admin scripts
		 */
		public function admin_scripts() {
			global $post_type;
			if ( 'pricing_tables' !== $post_type ) {
				return;
			}

			wp_enqueue_style(
				$this->plugin_name . '-admin',
				RESPONSIVE_PRICING_TABLE_ASSETS . '/css/admin.css',
				array( 'wp-color-picker' ),
				RESPONSIVE_PRICING_TABLE_VERSION,
				'all'
			);

			wp_enqueue_script(
				$this->plugin_name . '-admin',
				RESPONSIVE_PRICING_TABLE_ASSETS . '/js/admin.js',
				array(
					'jquery',
					'jquery-ui-accordion',
					'jquery-ui-tabs',
					'jquery-ui-sortable',
					'wp-color-picker'
				),
				RESPONSIVE_PRICING_TABLE_VERSION,
				true
			);
		}

		/**
		 * Load frontend scripts
		 */
		public function front_scripts() {
			wp_enqueue_style(
				$this->plugin_name,
				RESPONSIVE_PRICING_TABLE_ASSETS . '/css/style.css',
				array(),
				RESPONSIVE_PRICING_TABLE_VERSION,
				'all'
			);
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
