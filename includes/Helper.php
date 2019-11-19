<?php

namespace Sayful\PricingTable;

use WP_Post;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

class Helper {

	/**
	 * Post type
	 */
	const POST_TYPE = 'pricing_tables';

	/**
	 * Post type labels
	 *
	 * @return array
	 */
	public static function get_post_type_labels() {
		$labels = array(
			'name'               => _x( 'Pricing Tables', 'Post Type General Name', 'responsive-pricing-table' ),
			'singular_name'      => _x( 'Pricing Table', 'Post Type Singular Name', 'responsive-pricing-table' ),
			'menu_name'          => __( 'Pricing Tables', 'responsive-pricing-table' ),
			'name_admin_bar'     => __( 'Pricing Table', 'responsive-pricing-table' ),
			'archives'           => __( 'Pricing Table Archives', 'responsive-pricing-table' ),
			'attributes'         => __( 'Pricing Table Attributes', 'responsive-pricing-table' ),
			'parent_item_colon'  => __( 'Parent Pricing Table:', 'responsive-pricing-table' ),
			'all_items'          => __( 'All Pricing Tables', 'responsive-pricing-table' ),
			'add_new_item'       => __( 'Add New Pricing Table', 'responsive-pricing-table' ),
			'add_new'            => __( 'Add New', 'responsive-pricing-table' ),
			'new_item'           => __( 'New Pricing Table', 'responsive-pricing-table' ),
			'edit_item'          => __( 'Edit Pricing Table', 'responsive-pricing-table' ),
			'update_item'        => __( 'Update Pricing Table', 'responsive-pricing-table' ),
			'view_item'          => __( 'View Pricing Table', 'responsive-pricing-table' ),
			'view_items'         => __( 'View Pricing Tables', 'responsive-pricing-table' ),
			'search_items'       => __( 'Search Pricing Table', 'responsive-pricing-table' ),
			'not_found'          => __( 'Not found', 'responsive-pricing-table' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'responsive-pricing-table' ),
		);

		return $labels;
	}

	/**
	 * Get tables
	 *
	 * @param array $args
	 *
	 * @return WP_Post[]
	 */
	public static function get_tables( $args = [] ) {
		$args = wp_parse_args( array(
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'orderby'        => 'ID',
			'order'          => 'DESC',
		), $args );

		$args['post_type'] = self::POST_TYPE;

		return get_posts( $args );
	}

	/**
	 * Should load scripts
	 *
	 * @return bool
	 */
	public static function should_load_scripts() {
		global $post;
		if ( is_singular() && has_shortcode( $post->post_content, 'show_pricing_table' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Sanitizes a Hex, RGB or RGBA color
	 *
	 * @param string $color
	 *
	 * @return string
	 */
	public static function sanitize_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// Trim unneeded whitespace
		$color = str_replace( ' ', '', $color );

		// If this is hex color, validate and return it
		if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		// If this is rgb, validate and return it
		if ( 'rgb(' === substr( $color, 0, 4 ) ) {
			list( $red, $green, $blue ) = sscanf( $color, 'rgb(%d,%d,%d)' );

			if ( ( $red >= 0 && $red <= 255 ) &&
			     ( $green >= 0 && $green <= 255 ) &&
			     ( $blue >= 0 && $blue <= 255 )
			) {
				return "rgb({$red},{$green},{$blue})";
			}
		}

		// If this is rgba, validate and return it
		if ( 'rgba(' === substr( $color, 0, 5 ) ) {
			list( $red, $green, $blue, $alpha ) = sscanf( $color, 'rgba(%d,%d,%d,%f)' );

			if ( ( $red >= 0 && $red <= 255 ) &&
			     ( $green >= 0 && $green <= 255 ) &&
			     ( $blue >= 0 && $blue <= 255 ) &&
			     $alpha >= 0 && $alpha <= 1
			) {
				return "rgba({$red},{$green},{$blue},{$alpha})";
			}
		}

		return '';
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public static function is_checked( $value ) {
		return in_array( $value, [ 'yes', 'on', 'true', '1', true, 1 ], true );
	}

	/**
	 * Sanitize package data
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function sanitize_package_data( array $data ) {
		return [
			// Header
			'package_title'    => isset( $data['package_title'] ) ? sanitize_text_field( $data['package_title'] ) : '',
			'package_subtitle' => isset( $data['package_subtitle'] ) ? sanitize_text_field( $data['package_subtitle'] ) : '',
			// Pricing
			'currency_symbol'  => isset( $data['currency_symbol'] ) ? sanitize_text_field( $data['currency_symbol'] ) : '',
			'price'            => isset( $data['price'] ) ? sanitize_text_field( $data['price'] ) : '',
			'original_price'   => isset( $data['original_price'] ) ? sanitize_text_field( $data['original_price'] ) : '',
			'period'           => isset( $data['period'] ) ? sanitize_text_field( $data['period'] ) : '',
			'sale'             => isset( $data['sale'] ) && static::is_checked( $data['sale'] ),
			// Features
			'features'         => isset( $data['features'] ) ? static::sanitize_features_data( $data['features'] ) : [],
			// Footer
			'button_text'      => isset( $data['button_text'] ) ? sanitize_text_field( $data['button_text'] ) : '',
			'button_link'      => isset( $data['button_link'] ) ? esc_url_raw( $data['button_link'] ) : '',
			'additional_info'  => isset( $data['additional_info'] ) ? sanitize_text_field( $data['additional_info'] ) : '',
			// Ribbon
			'show_ribbon'      => isset( $data['show_ribbon'] ) && static::is_checked( $data['show_ribbon'] ),
			'ribbon_title'     => isset( $data['ribbon_title'] ) ? sanitize_text_field( $data['ribbon_title'] ) : '',
			'ribbon_position'  => isset( $data['ribbon_position'] ) ? sanitize_text_field( $data['ribbon_position'] ) : '',
		];
	}

	/**
	 * Sanitize features data
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function sanitize_features_data( array $data ) {
		$features = array();
		foreach ( $data as $_data ) {
			$features[] = array(
				'text'       => isset( $_data['text'] ) ? sanitize_text_field( $_data['text'] ) : '',
				'icon'       => isset( $_data['icon'] ) ? sanitize_text_field( $_data['icon'] ) : '',
				'icon_color' => isset( $_data['icon_color'] ) ? static::sanitize_color( $_data['icon_color'] ) : '',
			);
		}

		return $features;
	}
}