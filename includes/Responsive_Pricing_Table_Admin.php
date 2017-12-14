<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Responsive_Pricing_Table_Admin' ) ):

	class Responsive_Pricing_Table_Admin {

		private static $instance;

		/**
		 * @return Responsive_Pricing_Table_Admin
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		use Responsive_Pricing_Table_Form;

		public function __construct() {
			add_action( 'init', array( $this, 'pricing_tables' ), 0 );
			add_action( 'save_post', array( $this, 'save_post' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 9 );
			add_filter( 'manage_edit-pricing_tables_columns', array( $this, 'columns_head' ) );
			add_action( 'manage_pricing_tables_posts_custom_column', array( $this, 'columns_content' ), 10, 2 );
			// Remove view and Quick Edit from Carousels
			add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );

			add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		}

		public function admin_footer() {
			global $post_type;
			if ( 'pricing_tables' !== $post_type ) {
				return;
			}

			require_once RESPONSIVE_PRICING_TABLE_TEMPLATES . '/admin/template.php';
		}

		/**
		 * Save responsive pricing table meta values
		 *
		 * @param int $post_id
		 *
		 * @return int
		 */
		public function save_post( $post_id ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			if ( ! isset( $_POST['pricing_table_box_nonce'] ) ) {
				return $post_id;
			}

			if ( ! wp_verify_nonce( $_POST['pricing_table_box_nonce'], 'pricing_table_box' ) ) {
				return $post_id;
			}

			if ( ! isset( $_POST['post_type'] ) ) {
				return $post_id;
			}

			if ( 'pricing_tables' !== $_POST['post_type'] ) {
				return $post_id;
			}

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}

			$rpt = isset( $_POST['responsive_pricing_table'] ) ? $_POST['responsive_pricing_table'] : array();

			$package_title      = isset( $rpt['package_title'] ) ? $rpt['package_title'] : array();
			$package_subtitle   = isset( $rpt['package_subtitle'] ) ? $rpt['package_subtitle'] : array();
			$currency_symbol    = isset( $rpt['currency_symbol'] ) ? $rpt['currency_symbol'] : array();
			$price              = isset( $rpt['price'] ) ? $rpt['price'] : array();
			$sale               = isset( $rpt['sale'] ) ? $rpt['sale'] : array();
			$original_price     = isset( $rpt['original_price'] ) ? $rpt['original_price'] : array();
			$period             = isset( $rpt['period'] ) ? $rpt['period'] : array();
			$feature_text       = isset( $rpt['feature_text'] ) ? $rpt['feature_text'] : array();
			$feature_icon       = isset( $rpt['feature_icon'] ) ? $rpt['feature_icon'] : array();
			$feature_icon_color = isset( $rpt['feature_icon_color'] ) ? $rpt['feature_icon_color'] : array();
			$button_text        = isset( $rpt['button_text'] ) ? $rpt['button_text'] : array();
			$button_link        = isset( $rpt['button_link'] ) ? $rpt['button_link'] : array();
			$additional_info    = isset( $rpt['additional_info'] ) ? $rpt['additional_info'] : array();
			$show_ribbon        = isset( $rpt['show_ribbon'] ) ? $rpt['show_ribbon'] : array();
			$ribbon_title       = isset( $rpt['ribbon_title'] ) ? $rpt['ribbon_title'] : array();
			$ribbon_position    = isset( $rpt['ribbon_position'] ) ? $rpt['ribbon_position'] : array();

			$header_background_color   = isset( $rpt['header_background_color'] ) ? $rpt['header_background_color'] : array();
			$header_title_color        = isset( $rpt['header_title_color'] ) ? $rpt['header_title_color'] : array();
			$header_title_font_size    = isset( $rpt['header_title_font_size'] ) ? $rpt['header_title_font_size'] : array();
			$header_subtitle_color     = isset( $rpt['header_subtitle_color'] ) ? $rpt['header_subtitle_color'] : array();
			$header_subtitle_font_size = isset( $rpt['header_subtitle_font_size'] ) ? $rpt['header_subtitle_font_size'] : array();

			$_table_content = array();

			for ( $i = 0; $i < count( $package_title ); $i ++ ) {
				$_features = array();

				for ( $_i = 0; $_i < count( $feature_text[ $i ] ); $_i ++ ) {
					$_features[] = array(
						'text'       => sanitize_text_field( $feature_text[ $i ][ $_i ] ),
						'icon'       => sanitize_text_field( $feature_icon[ $i ][ $_i ] ),
						'icon_color' => $this->sanitize_color( $feature_icon_color[ $i ][ $_i ] ),
					);
				}

				$_sale        = isset( $sale[ $i ] ) && 'on' == $sale[ $i ] ? 'on' : 'off';
				$_show_ribbon = isset( $show_ribbon[ $i ] ) && 'on' == $show_ribbon[ $i ] ? 'on' : 'off';

				$_table_content[] = array(
					// Header
					'package_title'             => sanitize_text_field( $package_title[ $i ] ),
					'package_subtitle'          => sanitize_text_field( $package_subtitle[ $i ] ),
					// Pricing
					'currency_symbol'           => sanitize_text_field( $currency_symbol[ $i ] ),
					'price'                     => sanitize_text_field( $price[ $i ] ),
					'original_price'            => sanitize_text_field( $original_price[ $i ] ),
					'period'                    => sanitize_text_field( $period[ $i ] ),
					'sale'                      => $_sale,
					// Features
					'features'                  => $_features,
					// Footer
					'button_text'               => sanitize_text_field( $button_text[ $i ] ),
					'button_link'               => esc_url_raw( $button_link[ $i ] ),
					'additional_info'           => sanitize_text_field( $additional_info[ $i ] ),
					// Ribbon
					'show_ribbon'               => $_show_ribbon,
					'ribbon_title'              => sanitize_text_field( $ribbon_title[ $i ] ),
					'ribbon_position'           => sanitize_text_field( $ribbon_position[ $i ] ),
					// Style
					'header_background_color'   => $this->sanitize_color( $header_background_color[ $i ] ),
					'header_title_color'        => $this->sanitize_color( $header_title_color[ $i ] ),
					'header_title_font_size'    => sanitize_text_field( $header_title_font_size[ $i ] ),
					'header_subtitle_color'     => $this->sanitize_color( $header_subtitle_color[ $i ] ),
					'header_subtitle_font_size' => sanitize_text_field( $header_subtitle_font_size[ $i ] ),
				);
			}

			update_post_meta( $post_id, "_pricing_table_content", $_table_content );

			return $post_id;
		}

		public function add_meta_box() {
			add_meta_box(
				"pricing-table-manage-plans",
				__( "Manage Packages", "responsive-pricing-table" ),
				array( $this, 'manage_plans' ),
				"pricing_tables",
				"normal",
				"high"
			);
			add_meta_box(
				"pricing-table-preview",
				__( "Preview", "responsive-pricing-table" ),
				array( $this, 'preview_meta_box' ),
				"pricing_tables",
				"normal",
				"low"
			);
			add_meta_box(
				"pricing-table-usage",
				__( "Usage (Shortcode)", "responsive-pricing-table" ),
				array( $this, 'usages_meta_box' ),
				"pricing_tables",
				"side",
				"high"
			);
		}

		public function manage_plans( $post ) {
			$packages = get_post_meta( $post->ID, "_pricing_table_content", true );
			$packages = is_array( $packages ) ? $packages : array();
			ob_start();
			wp_nonce_field( 'pricing_table_box', 'pricing_table_box_nonce' );
			require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/admin/manage_plans.php';
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		public function preview_meta_box( $post ) {
			$table_id = $post->ID;
			$currency = Responsive_Pricing_Table_Currency::init();
			$packages = get_post_meta( $table_id, "_pricing_table_content", true );
			$packages = is_array( $packages ) ? $packages : array();
			$columns  = count( $packages );
			ob_start();
			require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/public/pricing-table.php';
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * @param WP_Post $post
		 */
		public function usages_meta_box( $post ) {
			?>
            <p>
                <strong><?php echo __( 'Copy the following shortcode and paste in page where you want to show.' ); ?></strong><br>
                <input
                        type="text"
                        onmousedown="this.clicked = 1;"
                        onfocus="if (!this.clicked) this.select(); else this.clicked = 2;"
                        onclick="if (this.clicked === 2) this.select(); this.clicked = 0;"
                        value="[show_pricing_table table_id='<?php echo $post->ID; ?>']"
                        style="background-color: #f1f1f1; width: 100%; padding: 8px;"
                >
            </p>
			<?php
		}

		public static function pricing_tables() {
			$labels = array(
				'name'               => __( 'Pricing Tables', 'responsive-pricing-table' ),
				'singular_name'      => __( 'Pricing Table', 'responsive-pricing-table' ),
				'menu_name'          => __( 'Pricing Tables', 'responsive-pricing-table' ),
				'parent_item_colon'  => __( 'Parent Table:', 'responsive-pricing-table' ),
				'all_items'          => __( 'Pricing Tables', 'responsive-pricing-table' ),
				'view_item'          => __( 'View Table', 'responsive-pricing-table' ),
				'add_new_item'       => __( 'Add New Table', 'responsive-pricing-table' ),
				'add_new'            => __( 'Add New', 'responsive-pricing-table' ),
				'edit_item'          => __( 'Edit Table', 'responsive-pricing-table' ),
				'update_item'        => __( 'Update Table', 'responsive-pricing-table' ),
				'search_items'       => __( 'Search Table', 'responsive-pricing-table' ),
				'not_found'          => __( 'Not found', 'responsive-pricing-table' ),
				'not_found_in_trash' => __( 'Not found in Trash', 'responsive-pricing-table' ),
			);
			$args   = array(
				'label'               => __( 'Pricing Tables', 'responsive-pricing-table' ),
				'description'         => __( 'Pricing Tables', 'responsive-pricing-table' ),
				'labels'              => $labels,
				'supports'            => array( 'title' ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => 'data:image/svg+xml;base64,' . base64_encode( '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><path fill="black" d="M30.656 5.984h-5.984v-1.984c0-0.384-0.288-0.672-0.672-0.672h-16c-0.352 0-0.672 0.288-0.672 0.672v1.984h-5.984c-0.384 0-0.672 0.32-0.672 0.672v18.688c0 0.352 0.288 0.64 0.672 0.64h5.984v2.016c0 0.384 0.32 0.672 0.672 0.672h16c0.384 0 0.672-0.288 0.672-0.672v-2.016h5.984c0.384 0 0.672-0.288 0.672-0.64v-18.688c0-0.352-0.288-0.672-0.672-0.672zM30.016 7.328v2.656h-5.344v-2.656h5.344zM8.672 4.672h14.656v4h-14.656v-4zM7.328 7.328v2.656h-5.312v-2.656h5.312zM2.016 24.672v-13.344h5.312v13.344h-5.312zM23.328 27.328h-14.656v-17.344h14.656v17.344zM24.672 24.672v-13.344h5.344v13.344h-5.344zM16.672 18.144v-2.72c0.736 0.16 1.28 0.64 1.344 1.184 0.032 0.352 0.352 0.608 0.704 0.608 0.384-0.032 0.64-0.384 0.608-0.736-0.096-1.248-1.216-2.208-2.656-2.432v-0.704c0-0.384-0.288-0.672-0.672-0.672s-0.672 0.288-0.672 0.672v0.704c-1.504 0.256-2.656 1.344-2.656 2.624 0 1.248 0.864 2.080 2.656 2.528v2.72c-0.736-0.192-1.28-0.64-1.344-1.184 0-0.352-0.384-0.64-0.704-0.608-0.352 0.032-0.64 0.352-0.608 0.736 0.096 1.216 1.216 2.176 2.656 2.4v0.736c0 0.352 0.32 0.672 0.672 0.672s0.672-0.32 0.672-0.672v-0.736c1.504-0.224 2.656-1.312 2.656-2.592 0-1.248-0.864-2.112-2.656-2.528zM14.016 16.672c0-0.576 0.544-1.056 1.312-1.248v2.4c-0.896-0.256-1.312-0.64-1.312-1.152zM16.672 21.92v-2.4c0.896 0.256 1.344 0.608 1.344 1.152s-0.576 1.056-1.344 1.248z"/></svg>' ),
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
			);
			register_post_type( 'pricing_tables', $args );
		}

		public function columns_head( $columns ) {

			$columns = array(
				'cb'    => '<input type="checkbox">',
				'title' => __( 'Pricing Table Name', 'pricingtable' ),
				'usage' => __( 'Usage (shortcode)', 'pricingtable' )
			);

			return $columns;

		}

		public function columns_content( $column, $post_id ) {

			if ( $column == 'usage' ) {
				?><input
                type="text"
                onmousedown="this.clicked = 1;"
                onfocus="if (!this.clicked) this.select(); else this.clicked = 2;"
                onclick="if (this.clicked === 2) this.select(); this.clicked = 0;"
                value="[show_pricing_table table_id='<?php echo $post_id; ?>']"
                style="background-color: #f1f1f1; width: 300px; padding: 8px;"
                ><?php
			}
		}

		public function post_row_actions( $actions, $post ) {
			global $current_screen;
			if ( $current_screen->post_type != 'pricing_tables' ) {
				return $actions;
			}

			unset( $actions['view'] );
			unset( $actions['inline hide-if-no-js'] );

			return $actions;
		}

		/**
		 * Sanitizes a Hex, RGB or RGBA color
		 *
		 * @param $color
		 *
		 * @return mixed|string
		 */
		private function sanitize_color( $color ) {
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
	}

endif;

Responsive_Pricing_Table_Admin::init();
