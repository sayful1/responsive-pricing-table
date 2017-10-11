<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Pricing table shortcode
 */

class Responsive_Pricing_Table_ShortCode {

	private static $instance;

	/**
	 * @return Responsive_Pricing_Table_ShortCode
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Responsive_Pricing_Table_ShortCode constructor.
	 */
	public function __construct() {
		add_shortcode( "show_pricing_table", array( $this, "shortcode" ) );
	}

	public function shortcode( $atts ) {

		extract( shortcode_atts( array(
			'table_id' => '',
		), $atts ) );

		if ( ! $table_id ) {
			return;
		}
		$packages = get_post_meta( $table_id, "responsive_pricing_table", true );
		$packages = is_array( $packages ) ? $packages : array();
		$columns  = count( $packages );
		if ( $columns < 1 ) {
			return;
		}

		ob_start();
		require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/shortcode.php';
		$html = ob_get_contents();
		ob_end_clean();

		return apply_filters( 'responsive_pricing_table', $html, $packages );
	}
}
