<?php

namespace Sayful\PricingTable;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

class Assets {

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
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;

			add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'front_scripts' ), 20 );
		}

		return self::$instance;
	}

	/**
	 * Load admin scripts
	 */
	public function admin_scripts() {
		global $post_type;
		if ( Helper::POST_TYPE !== $post_type ) {
			return;
		}

		wp_enqueue_style( RESPONSIVE_PRICING_TABLE . '-admin', RESPONSIVE_PRICING_TABLE_ASSETS . '/css/admin.css',
			array( 'wp-color-picker' ), RESPONSIVE_PRICING_TABLE_VERSION, 'all' );

		wp_enqueue_script( RESPONSIVE_PRICING_TABLE . '-admin', RESPONSIVE_PRICING_TABLE_ASSETS . '/js/admin.js',
			[ 'jquery', 'jquery-ui-accordion', 'jquery-ui-tabs', 'jquery-ui-sortable', 'wp-color-picker' ],
			RESPONSIVE_PRICING_TABLE_VERSION, true );
	}

	/**
	 * Load frontend scripts
	 */
	public function front_scripts() {
		if ( ! Helper::should_load_scripts() ) {
			return;
		}

		wp_enqueue_style( RESPONSIVE_PRICING_TABLE, RESPONSIVE_PRICING_TABLE_ASSETS . '/css/frontend.css',
			array(), RESPONSIVE_PRICING_TABLE_VERSION, 'all' );
	}
}