<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! trait_exists( 'Responsive_Pricing_Table_Form' ) ):

	trait Responsive_Pricing_Table_Form {

		public function text( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$class = isset( $args['class'] ) ? $args['class'] . ' sp-input-text' : 'sp-input-text';

			echo $this->field_before( $args );
			echo sprintf( '<input type="text" class="%4$s" value="%1$s" id="%2$s" name="%3$s">', $value,
				$args['id'], $name, $class );
			echo $this->field_after();
		}

		public function vertical_position( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$class = isset( $args['class'] ) ? $args['class'] . ' spacing-text' : 'spacing-text';

			echo $this->field_before( $args );

			?>
            <div class="sp-input-position">

                <label title="Top" class="position-label">
                    <input type="radio" name="<?php echo $name; ?>" value="top" <?php checked( 'top', $value ); ?>>
                    <span class="v-align-top position-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 32 32">
                            <path d="M11.008 14.816c-0.224 0.288-0.128 0.512 0.224 0.512h2.624v12c0 0.384 0.32 0.672 0.672 0.672h2.624c0.352 0 0.64-0.288 0.64-0.672v-12h2.624c0.384 0 0.48-0.224 0.224-0.512l-4.352-4.992c-0.256-0.256-0.64-0.256-0.896 0l-4.384 4.992zM5.984 4c-0.352 0-0.64 0.288-0.64 0.672v2.656c0 0.384 0.288 0.672 0.64 0.672h19.712c0.352 0 0.64-0.288 0.64-0.672v-2.656c0-0.384-0.288-0.672-0.64-0.672h-19.712z"></path>
                        </svg>
                    </span>
                </label>
                <label title="Middle" class="position-label">
                    <input type="radio" name="<?php echo $name; ?>"
                           value="middle" <?php checked( 'middle', $value ); ?>>
                    <span class="v-align-middle position-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 32 32">
                            <path d="M10.976 23.040c-0.256 0.224-0.16 0.384 0.192 0.384h2.688v3.84c0 0.32 0.288 0.544 0.64 0.544h2.688c0.352 0 0.64-0.256 0.64-0.544v-3.84h2.656c0.384 0 0.448-0.16 0.192-0.384l-4.352-3.616c-0.288-0.192-0.704-0.192-0.96 0l-4.384 3.616zM10.976 8.96c-0.256-0.224-0.16-0.384 0.192-0.384h2.688v-3.84c0-0.32 0.288-0.544 0.64-0.544h2.688c0.352 0 0.64 0.256 0.64 0.544v3.84h2.656c0.384 0 0.448 0.16 0.192 0.384l-4.352 3.584c-0.288 0.224-0.704 0.224-0.96 0l-4.384-3.584zM25.504 17.952c0.352 0 0.672-0.288 0.672-0.64v-2.624c0-0.352-0.32-0.672-0.672-0.672h-20c-0.384 0-0.672 0.32-0.672 0.672v2.624c0 0.352 0.32 0.64 0.672 0.64h20z"></path>
                        </svg>
                    </span>
                </label>
                <label title="Bottom" class="position-label">
                    <input type="radio" name="<?php echo $name; ?>"
                           value="bottom" <?php checked( 'bottom', $value ); ?>>
                    <span class="v-align-bottom position-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 32 32">
                            <path d="M20.64 17.152c0.256-0.256 0.16-0.48-0.224-0.48h-2.624v-12c0-0.384-0.288-0.672-0.64-0.672h-2.624c-0.384 0-0.672 0.288-0.672 0.672v12h-2.624c-0.352 0-0.448 0.224-0.224 0.48l4.384 5.024c0.256 0.256 0.64 0.256 0.896 0l4.352-5.024zM25.696 28c0.352 0 0.64-0.288 0.64-0.672v-2.656c0-0.384-0.288-0.672-0.64-0.672h-19.712c-0.352 0-0.64 0.288-0.64 0.672v2.656c0 0.384 0.288 0.672 0.64 0.672h19.712z"></path>
                        </svg>
                    </span>
                </label>
            </div>
			<?php

			echo $this->field_after();
		}

		public function spacing( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			global $post;
			// Meta Name
			$group    = isset( $args['group'] ) ? $args['group'] : 'responsive_pricing_table';
			$multiple = isset( $args['multiple'] ) ? '[]' : '';
			$name     = sprintf( '%s[%s]%s', $group, $args['id'], $multiple );

			// Meta Value
			$std_value = isset( $args['std'] ) ? $args['std'] : null;
			$meta      = get_post_meta( $post->ID, $args['id'], true );
			$value     = ! empty( $meta ) ? $meta : $std_value;

			$_top    = isset( $value['top'] ) ? $value['top'] : null;
			$_right  = isset( $value['right'] ) ? $value['right'] : null;
			$_bottom = isset( $value['bottom'] ) ? $value['bottom'] : null;
			$_left   = isset( $value['left'] ) ? $value['left'] : null;

			$class = isset( $args['class'] ) ? $args['class'] . ' spacing-text' : 'spacing-text';

			echo $this->field_before( $args );

			?>
            <div class="sp-input-spacing">
                <span class="dashicons dashicons-arrow-up-alt"></span>
                <input type="text" name="<?php echo $name; ?>[top]" class="spacing-text" placeholder="Top"
                       value="<?php echo $_top; ?>">

                <span class="dashicons dashicons-arrow-right-alt"></span>
                <input type="text" name="<?php echo $name; ?>[right]" class="spacing-text" placeholder="Right"
                       value="<?php echo $_right; ?>">

                <span class="dashicons dashicons-arrow-down-alt"></span>
                <input type="text" name="<?php echo $name; ?>[bottom]" class="spacing-text" placeholder="Bottom"
                       value="<?php echo $_bottom; ?>">

                <span class="dashicons dashicons-arrow-left-alt"></span>
                <input type="text" name="<?php echo $name; ?>[left]" class="spacing-text" placeholder="Left"
                       value="<?php echo $_left; ?>">
            </div>
			<?php

			echo $this->field_after();
		}

		public function textarea( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$cols = isset( $args['cols'] ) ? $args['cols'] : 35;
			$rows = isset( $args['rows'] ) ? $args['rows'] : 6;

			echo $this->field_before( $args );
			echo sprintf( '<textarea class="sp-input-textarea" id="%2$s" name="%3$s" cols="%4$d" rows="%5$d">%1$s</textarea>',
				esc_textarea( $value ), $args['id'], $name, $cols, $rows );
			echo $this->field_after();
		}

		public function editor( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$rows = isset( $args['rows'] ) ? $args['rows'] : 6;
			// $cols = isset( $args['cols'] ) ? $args['cols'] : 35;

			echo $this->field_before( $args );
			ob_start();
			echo "<div class='sp-wp-editor-container'>";
			wp_editor( $value, $args['id'], array(
				'textarea_name' => $name,
				'tinymce'       => false,
				'media_buttons' => false,
				'textarea_rows' => isset( $rows ) ? $rows : 6,
				'quicktags'     => array( "buttons" => "strong,em,link,img" ),
			) );
			echo "</div>";
			echo ob_get_clean();
			echo $this->field_after();
		}

		public function color( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$std_value = isset( $args['std'] ) ? $args['std'] : '';
			$default   = isset( $args['default'] ) ? $args['default'] : $std_value;
			$class     = isset( $args['class'] ) ? $args['class'] . ' color-picker' : 'color-picker';

			echo $this->field_before( $args );
			echo sprintf( '<input type="text" class="%5$s" value="%1$s" id="%2$s" name="%3$s" data-default-color="%4$s">',
				$value, $args['id'], $name, $default, $class );
			echo $this->field_after();
		}

		public function date( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$std_value = isset( $args['std'] ) ? $args['std'] : '';

			echo $this->field_before( $args );
			echo sprintf( '<input type="text" class="sp-input-text datepicker" value="%1$s" id="%2$s" name="%3$s">',
				$value, $args['id'], $name, $std_value );
			echo $this->field_after();
		}

		public function number( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			echo $this->field_before( $args );
			echo sprintf( '<input type="number" class="sp-input-text" value="%1$s" id="%2$s" name="%3$s">', $value,
				$args['id'], $name );
			echo $this->field_after();
		}

		public function checkbox( array $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );
			$checked = ( $value == 'on' ) ? ' checked' : '';
			$label   = isset( $args['label'] ) ? $args['label'] : '';
			$class   = isset( $args['class'] ) ? 'class="' . $args['class'] . '"' : '';

			echo $this->field_before( $args );
			echo '<label><input type="checkbox" ' . $checked . ' ' . $class . ' value="on" name="' . $name . '">' . $label . '</label>';
			echo $this->field_after();
		}

		public function select( $args ) {
			if ( ! isset( $args['id'], $args['name'] ) ) {
				return;
			}

			list( $name, $value ) = $this->field_common( $args );

			echo $this->field_before( $args );
			echo '<select name="' . $name . '" id="' . $args['id'] . '" class="sp-input-text">';
			foreach ( $args['options'] as $key => $option ) {
				$selected = ( $value == $key ) ? ' selected="selected"' : '';
				echo '<option value="' . $key . '" ' . $selected . '>' . $option . '</option>';
			}
			echo '</select>';
			echo $this->field_after();
		}

		private function field_common( $args ) {
			global $post;
			// Meta Name
			$group    = isset( $args['group'] ) ? $args['group'] : 'responsive_pricing_table';
			$multiple = isset( $args['multiple'] ) ? '[]' : '';
			$name     = sprintf( '%s[%s]%s', $group, $args['id'], $multiple );

			// Meta Value
			$std_value = isset( $args['std'] ) ? $args['std'] : null;
			$meta      = get_post_meta( $post->ID, $args['id'], true );
			$value     = ! empty( $meta ) ? $meta : $std_value;

			if ( $value == 'zero' ) {
				$value = 0;
			}

			return array( $name, $value );
		}

		private function field_before( $args ) {
			$table = sprintf( '<div class="sp-input-group" id="field-%s">', $args['id'] );
			$table .= sprintf( '<div class="sp-input-label">' );
			$table .= sprintf( '<label for="%1$s">%2$s</label>', $args['id'], $args['name'] );
			if ( ! empty( $args['desc'] ) ) {
				if ( is_array( $args['desc'] ) ) {
					foreach ( $args['desc'] as $desc ) {
						$table .= sprintf( '<p class="sp-input-desc">%s</p>', $desc );
					}
				} else {
					$table .= sprintf( '<p class="sp-input-desc">%s</p>', $args['desc'] );
				}
			}
			$table .= '</div>';
			$table .= sprintf( '<div class="sp-input-field">' );

			return $table;
		}

		private function field_after() {
			return '</div></div>';
		}
	}

endif;