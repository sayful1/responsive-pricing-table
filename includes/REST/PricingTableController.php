<?php

namespace Sayful\PricingTable\REST;

use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

defined( 'ABSPATH' ) || exit;

class PricingTableController extends WP_REST_Controller {

	/**
	 * The namespace of this controller's route.
	 *
	 * @var string
	 */
	protected $namespace = 'responsive-pricing-table/v1';

	/**
	 * The instance of the class
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Only one instance of the class can be loaded.
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;

			add_action( 'rest_api_init', array( self::$instance, 'register_routes' ) );
		}

		return self::$instance;
	}

	/**
	 * Registers the routes for the objects of the controller.
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/packages', [
			[
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_items' ],
				'args'     => $this->get_collection_params(),
			],
			[
				'methods'  => WP_REST_Server::CREATABLE,
				'callback' => [ $this, 'create_item' ],
				'args'     => $this->get_create_item_params(),
			],
		] );
	}

	/**
	 * Retrieves a collection of items.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		return parent::get_items( $request );
	}

	/**
	 * Creates one item from the collection.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response Response object on success, or WP_Error object on failure.
	 */
	public function create_item( $request ) {

	}

	/**
	 * Retrieves the query params for creating item.
	 *
	 * @return array Query parameters for the collection.
	 */
	public function get_create_item_params() {
		return [
			'package_title'    => [ 'type' => 'string', ],
			'package_subtitle' => [ 'type' => 'string', ],
			'currency_symbol'  => [ 'type' => 'string', ],
			'price'            => [ 'type' => 'string', ],
			'original_price'   => [ 'type' => 'string', ],
			'period'           => [ 'type' => 'string', ],
			'sale'             => [ 'type' => 'string', ],
			'features'         => [ 'type' => 'array', ],
			'button_text'      => [ 'type' => 'string', ],
			'button_link'      => [ 'type' => 'string', ],
			'additional_info'  => [ 'type' => 'string', ],
			'show_ribbon'      => [ 'type' => 'string', ],
			'ribbon_title'     => [ 'type' => 'string', ],
			'ribbon_position'  => [ 'type' => 'string', ],
		];
	}
}
