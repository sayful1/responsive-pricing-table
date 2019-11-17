<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Responsive_Pricing_Table_Admin' ) ) {

	class Responsive_Pricing_Table_Admin {

		use Responsive_Pricing_Table_Form;

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

				add_action( 'init', array( self::$instance, 'pricing_tables' ), 0 );
				add_action( 'save_post', array( self::$instance, 'save_post' ) );
				add_action( 'add_meta_boxes', array( self::$instance, 'add_meta_box' ), 9 );
				add_filter( 'manage_edit-pricing_tables_columns', array( self::$instance, 'columns_head' ) );
				add_action( 'manage_pricing_tables_posts_custom_column',
					[ self::$instance, 'columns_content' ], 10, 2 );

				// Remove view and Quick Edit from list table
				add_filter( 'post_row_actions', array( self::$instance, 'post_row_actions' ), 10, 2 );

				add_action( 'admin_footer', array( self::$instance, 'admin_footer' ) );
			}

			return self::$instance;
		}

		/**
		 * Add javaScript template
		 */
		public function admin_footer() {
			global $post_type;
			if ( 'pricing_tables' !== $post_type ) {
				return;
			}

			require_once RESPONSIVE_PRICING_TABLE_TEMPLATES . '/admin/package.php';
		}

		/**
		 * Save package meta
		 *
		 * @param int $post_id
		 */
		public function save_post( $post_id ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! isset( $_POST['pricing_table_box_nonce'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST['pricing_table_box_nonce'], 'pricing_table_box' ) ) {
				return;
			}

			if ( ! isset( $_POST['post_type'] ) ) {
				return;
			}

			if ( 'pricing_tables' !== $_POST['post_type'] ) {
				return;
			}
			if ( ! current_user_can( 'edit_pages', $post_id ) ) {
				return;
			}

			$rpt = isset( $_POST['responsive_pricing_table'] ) ? $_POST['responsive_pricing_table'] : array();

			$package_title = isset( $rpt['package_title'] ) ? $rpt['package_title'] : array();
			$recurrence    = isset( $rpt['recurrence'] ) ? $rpt['recurrence'] : array();
			$price         = isset( $rpt['price'] ) ? $rpt['price'] : array();
			$recommended   = isset( $rpt['recommended'] ) ? $rpt['recommended'] : array();
			$button_text   = isset( $rpt['button_text'] ) ? $rpt['button_text'] : array();
			$button_url    = isset( $rpt['button_url'] ) ? $rpt['button_url'] : array();
			$features_list = isset( $rpt['features_list'] ) ? $rpt['features_list'] : array();

			$new_array = array();

			for ( $i = 0; $i < count( $package_title ); $i ++ ) {
				$new_array[] = array(
					'package_title' => sanitize_text_field( $package_title[ $i ] ),
					'recurrence'    => sanitize_text_field( $recurrence[ $i ] ),
					'price'         => sanitize_text_field( $price[ $i ] ),
					'recommended'   => sanitize_text_field( $recommended[ $i ] ),
					'button_text'   => sanitize_text_field( $button_text[ $i ] ),
					'button_url'    => esc_url_raw( $button_url[ $i ] ),
					'features_list' => wp_kses_data( $features_list[ $i ] ),
				);
			}

			update_post_meta( $post_id, "responsive_pricing_table", $new_array );
		}

		/**
		 * Add meta box
		 */
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

		/**
		 * Meta box callback
		 *
		 * @param WP_Post $post
		 */
		public function manage_plans( $post ) {
			$rpt_info = get_post_meta( $post->ID, "responsive_pricing_table", true );
			$rpt_info = is_array( $rpt_info ) ? $rpt_info : array();
			ob_start();
			require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/manage_plans.php';
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Meta box callback
		 *
		 * @param WP_Post $post
		 */
		public function preview_meta_box( $post ) {
			$table_id = $post->ID;
			$packages = get_post_meta( $table_id, "responsive_pricing_table", true );
			$packages = is_array( $packages ) ? $packages : array();
			$columns  = count( $packages );
			ob_start();
			require RESPONSIVE_PRICING_TABLE_TEMPLATES . '/shortcode.php';
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Meta box callback
		 *
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

		/**
		 * Register post type
		 */
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
				'menu_icon'           => 'dashicons-editor-table',
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
			);
			register_post_type( 'pricing_tables', $args );
		}

		/**
		 * Add custom list table column head
		 *
		 * @return array
		 */
		public function columns_head() {
			$columns = array(
				'cb'    => '<input type="checkbox">',
				'title' => __( 'Pricing Table Name', 'responsive-pricing-table' ),
				'usage' => __( 'Usage (shortcode)', 'responsive-pricing-table' )
			);

			return $columns;

		}

		/**
		 * Add column content
		 *
		 * @param string $column
		 * @param int $post_id
		 */
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

		/**
		 * Remove list table row actions
		 *
		 * @param array $actions
		 * @param WP_Post $post
		 *
		 * @return array
		 */
		public function post_row_actions( $actions, $post ) {
			global $current_screen;
			if ( $current_screen->post_type != 'pricing_tables' ) {
				return $actions;
			}

			unset( $actions['view'] );
			unset( $actions['inline hide-if-no-js'] );

			return $actions;
		}
	}
}

Responsive_Pricing_Table_Admin::init();
