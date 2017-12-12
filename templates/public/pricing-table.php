<div id="table-<?php echo $table_id; ?>"
     class="responsive-pricing-table__wrap rpt_col_<?php echo count( $packages ); ?>">

	<?php foreach ( $packages as $package ): ?>

        <div class="responsive-pricing-table__cell">
            <div class="responsive-pricing-table">

                <div class="responsive-pricing-table__header">
					<?php
					if ( ! empty( $package['package_title'] ) ) {
						echo '<h3 class="responsive-pricing-table__heading">' . esc_attr( $package['package_title'] ) . '</h3>';
					}
					if ( ! empty( $package['package_subtitle'] ) ) {
						echo '<span class="responsive-pricing-table__subheading">' . esc_attr( $package['package_subtitle'] ) . '</span>';
					}
					?>
                </div><!-- .responsive-pricing-table__header -->

                <div class="responsive-pricing-table__price">
					<?php
					$_symbol  = ! empty( $package['currency_symbol'] ) ? $currency->get_symbol( $package['currency_symbol'] ) : '&#36;';
					$price    = explode( '.', $package['price'] );
					$integer  = $price[0];
					$fraction = '';
					if ( 2 === sizeof( $price ) ) {
						$fraction = $price[1];
					}
					$period_position = isset( $package['period_position'] ) && 'beside' == $package['period_position'] ? 'beside' : 'below';
					$period_element  = '<span class="responsive-pricing-table__period responsive-pricing-table-typo-excluded">' . $package['period'] . '</span>';

					if ( 'on' === $package['sale'] && ! empty( $package['original_price'] ) ) {
						echo '<div class="responsive-pricing-table__original-price responsive-pricing-table-typo-excluded">' . $_symbol . $package['original_price'] . '</div>';
					}

					if ( ! empty( $_symbol ) && is_numeric( $integer ) ) {
						echo '<span class="responsive-pricing-table__currency">' . $_symbol . '</span>';
					}

					if ( ! empty( $intpart ) || 0 <= $integer ) {
						echo '<span class="responsive-pricing-table__integer-part">' . $integer . '</span>';
					}

					if ( 0 < $fraction || ( ! empty( $package['period'] ) && 'beside' === $period_position ) ) {
						echo '<div class="responsive-pricing-table__after-price">';
						echo '<span class="responsive-pricing-table__fractional-part">' . $fraction . '</span>';
						if ( ! empty( $package['period'] ) && 'beside' === $period_position ) {
							echo $period_element;
						}
						echo '</div>';
					}

					if ( ! empty( $package['period'] ) && 'below' === $period_position ) {
						echo $period_element;
					}
					?>
                </div><!-- .responsive-pricing-table__price -->

                <ul class="responsive-pricing-table__features-list">
					<?php
					if ( ! empty( $package['features'] ) ) {
						foreach ( $package['features'] as $item_index => $item ) {
							echo '<li class="responsive-pricing-table-repeater-item-' . ( $item_index + 1 ) . '">';
							echo '<div class="responsive-pricing-table__feature-inner">';
							if ( ! empty( $item['icon'] ) ) {
								echo '<i class="' . esc_attr( $item['icon'] ) . '"></i>';
							}

							if ( ! empty( $item['text'] ) ) {
								echo $item['text'];
							} else {
								echo '&nbsp;';
							}

							echo '</div>';
							echo '</li>';
						}
					}
					?>
                </ul><!-- .responsive-pricing-table__features-list -->

				<?php if ( ! empty( $package['button_text'] ) || ! empty( $package['additional_info'] ) ) : ?>
                    <div class="responsive-pricing-table__footer">
						<?php if ( ! empty( $package['button_text'] ) ) : ?>
                            <a class="button responsive-pricing-table-button">
								<?php echo $package['button_text']; ?>
                            </a>
						<?php endif; ?>

						<?php if ( ! empty( $package['additional_info'] ) ) : ?>
                            <div class="responsive-pricing-table__additional_info"><?php echo $package['additional_info']; ?></div>
						<?php endif; ?>
                    </div>
				<?php endif; ?>

				<?php if ( 'on' === $package['show_ribbon'] && ! empty( $package['ribbon_title'] ) ) :
					$_ribbon_class = 'responsive-pricing-table__ribbon';

					if ( ! empty( $package['ribbon_position'] ) ) {
						$_ribbon_class .= ' ribbon-' . $package['ribbon_position'];
					}

					?>
                    <div class="<?php echo $_ribbon_class; ?>">
                        <div class="responsive-pricing-table__ribbon-inner"><?php echo $package['ribbon_title']; ?></div>
                    </div>
				<?php endif; ?>

            </div><!-- .responsive-pricing-table -->
        </div><!-- .responsive-pricing-table__cell -->

	<?php endforeach; ?>

</div>
