<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Responsive_Pricing_Table_ShortCode' ) ) {

	class Responsive_Pricing_Table_ShortCode {

		/**
		 * The instance of the class
		 *
		 * @var self
		 */
		private static $instance;

		/**
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @return self
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_shortcode( "show_pricing_table", array( self::$instance, "pricing_table_html" ) );
			}

			return self::$instance;
		}

		/**
		 * Pricing table html
		 *
		 * @param array $args
		 *
		 * @return string
		 */
		public function pricing_table_html( $args ) {
			$args     = shortcode_atts( [ 'table_id' => '', ], $args );
			$table_id = is_numeric( $args['table_id'] ) ? intval( $args['table_id'] ) : 0;

			if ( empty( $table_id ) ) {
				return '';
			}

			$packages = get_post_meta( $table_id, "responsive_pricing_table", true );
			$packages = is_array( $packages ) ? $packages : array();
			$columns  = count( $packages );
			if ( $columns < 1 ) {
				return '';
			}

			ob_start();
			require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/shortcode.php';
			$html = ob_get_contents();
			ob_end_clean();

			return apply_filters( 'responsive_pricing_table', $html, $packages );
		}
	}
}

Responsive_Pricing_Table_ShortCode::init();
