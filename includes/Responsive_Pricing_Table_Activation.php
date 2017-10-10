<?php

if( ! class_exists('Responsive_Pricing_Table_Activation') ):

class Responsive_Pricing_Table_Activation {

	public static function activate()
	{
		self::upgrade_to_120();
	}

	public static function upgrade_to_120()
	{
		$pricing_tables = get_posts(
			array(
				'post_type' => 'pricing_tables',
				'meta_key' => '_table_packages'
			)
		);
		foreach ($pricing_tables as $post) {
			update_post_meta($post->ID, "responsive_pricing_table", self::package_data( $post->ID ));
		}

	}

	public static function package_data( $table_id )
	{
		$packages = get_post_meta($table_id, "_table_packages", true);
		$packages = json_decode($packages);

		$packages = array_map(function( $id ){

			$features = json_decode(get_post_meta($id, "_package_features", true));
			return array(
				'package_title' => get_the_title($id),
				'recurrence' 	=> get_post_meta($id, "_package_tenure", true),
				'price' 		=> get_post_meta($id, "_package_price", true),
				'recommended' 	=> 'off',
				'button_text' 	=> get_post_meta($id, "_package_buy_text", true),
				'button_url' 	=> get_post_meta($id, "_package_buy_link", true),
				'features_list' => implode("\n", $features ),
			);
		}, $packages);

		return $packages;
	}
}

endif;