<?php

namespace Sayful\PricingTable;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

class Currency {

	/**
	 * Supported currency list
	 *
	 * @return array
	 */
	public static function currency_list() {
		return [
			''             => __( 'None', 'responsive-pricing-table' ),
			'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'responsive-pricing-table' ),
			'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'responsive-pricing-table' ),
			'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'responsive-pricing-table' ),
			'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'responsive-pricing-table' ),
			'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'responsive-pricing-table' ),
			'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'responsive-pricing-table' ),
			'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'responsive-pricing-table' ),
			'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'responsive-pricing-table' ),
			'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'responsive-pricing-table' ),
			'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'responsive-pricing-table' ),
			'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'responsive-pricing-table' ),
			'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'responsive-pricing-table' ),
			'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'responsive-pricing-table' ),
			'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'responsive-pricing-table' ),
			'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'responsive-pricing-table' ),
			'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'responsive-pricing-table' ),
			'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'responsive-pricing-table' ),
			'bdt'          => '&#2547; ' . _x( 'Taka', 'Currency Symbol', 'responsive-pricing-table' ),
		];
	}

	/**
	 * Get currency symbol by currency name
	 *
	 * @param $symbol_name
	 *
	 * @return mixed|string
	 */
	public static function get_symbol( $symbol_name ) {
		$symbols = [
			'baht'         => '&#3647;',
			'bdt'          => '&#2547;',
			'dollar'       => '&#36;',
			'euro'         => '&#128;',
			'franc'        => '&#8355;',
			'guilder'      => '&fnof;',
			'indian_rupee' => '&#8377;',
			'krona'        => 'kr',
			'lira'         => '&#8356;',
			'peseta'       => '&#8359',
			'peso'         => '&#8369;',
			'pound'        => '&#163;',
			'ruble'        => '&#8381;',
			'real'         => 'R$',
			'rupee'        => '&#8360;',
			'shekel'       => '&#8362;',
			'won'          => '&#8361;',
			'yen'          => '&#165;',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}
}