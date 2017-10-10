<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Pricing table shortcode
 */

class Responsive_Pricing_Table_Shortcode {
	private $plugin_path;

	public function __construct( $plugin_path ) {

		$this->plugin_path = $plugin_path;

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
		require $this->plugin_path . '/templates/shortcode.php';
		$html = ob_get_contents();
		ob_end_clean();

		return apply_filters( 'responsive_pricing_table', $html, $packages );
	}
}
