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

if ( ! class_exists('Responsive_Pricing_Table') ):

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
	public static function get_instance(){
		if (null == self::$instance) {
			$instance = new self;
		}

		return $instance;
	}

	public function __construct(){
		// add_action( 'plugins_loaded', array( $this, 'textdomain') );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts') );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts'), 20 );

		$this->includes();
	}

	public function includes(){
		if ( is_admin() ) {
			$this->admin_includes();
		}
		if ( ! is_admin() ) {
			$this->frontend_includes();
		}
	}

	public function admin_includes()
	{
		include_once $this->plugin_path() . '/includes/Responsive_Pricing_Table_Form.php';
		include_once $this->plugin_path() . '/includes/Responsive_Pricing_Table_Admin.php';

		new Responsive_Pricing_Table_Admin( $this->plugin_path() );
	}

	public function frontend_includes()
	{
		include_once $this->plugin_path() . '/includes/Responsive_Pricing_Table_Shortcode.php';

		new Responsive_Pricing_Table_Shortcode( $this->plugin_path() );
	}

	public function textdomain() {
	  load_plugin_textdomain( 'responsive-pricing-table', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function admin_scripts()
	{
		wp_enqueue_style( $this->plugin_name . '-admin', $this->plugin_url() . '/assets/css/admin.css', array(), $this->plugin_version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'livequery', $this->plugin_url() . '/assets/js/jquery.livequery.js', array( 'jquery' ), '1.3.6', true );
	    wp_enqueue_script( $this->plugin_name . '-admin', $this->plugin_url() . '/assets/js/admin.js', array('jquery','livequery', 'wp-color-picker', 'jquery-ui-accordion', 'jquery-ui-sortable'), $this->plugin_version, true);
	        	
        wp_localize_script( $this->plugin_name . '-admin', 'ResponsivePricingTable', array(
            'error_title' 	=> __('Please enter pricing table name.', 'responsive-pricing-table'),
        ));
	}

	public function front_scripts() {
	    wp_enqueue_style( $this->plugin_name, $this->plugin_url() . '/assets/css/style.css',array(), $this->plugin_version, 'all' );
	}

	/**
	 * Plugin path.
	 *
	 * @return string Plugin path
	 */
	private function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string Plugin url
	 */
	private function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
Responsive_Pricing_Table::get_instance();


register_activation_hook( __FILE__, function(){

	include_once plugin_dir_path( __FILE__ ) .'includes/Responsive_Pricing_Table_Activation.php';
	Responsive_Pricing_Table_Activation::activate();
	flush_rewrite_rules();
});

register_deactivation_hook( __FILE__, function(){
	flush_rewrite_rules();
});

endif;