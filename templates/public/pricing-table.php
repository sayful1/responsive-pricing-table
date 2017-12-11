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
					?>

                    <!--<span class="responsive-pricing-table__subheading">I am subtitle</span>-->
                </div>

                <div class="responsive-pricing-table__price">
                    <span class="responsive-pricing-table__currency">$</span>
                    <span class="responsive-pricing-table__integer-part">39</span>

                    <div class="responsive-pricing-table__after-price">
                        <span class="responsive-pricing-table__fractional-part">99</span>
                    </div>

					<?php
					if ( ! empty( $package['recurrence'] ) ) {
						echo '<span class="responsive-pricing-table__period elementor-typo-excluded">' . esc_attr( $package['recurrence'] ) . '</span>';
					}
					?>
                </div>

                <div class="responsive_pricing_table-price">
                    <div class="responsive_pricing_table-price-figure">
                    <span class="responsive_pricing_table-price-number">
                        <?php echo esc_attr( $package['price'] ); ?>
                    </span>
                        <span class="responsive_pricing_table-price-tenure">
                        <?php echo esc_attr( $package['recurrence'] ); ?>
                    </span>
                    </div>
                </div><!-- Price -->
                <ul class="responsive_pricing_table-features">
					<?php foreach ( explode( "\n", $package['features_list'] ) as $feature ): ?>
                        <li><?php echo $feature; ?></li>
					<?php endforeach; ?>
                </ul>
                <div class="responsive_pricing_table-footer">
                    <a href="<?php echo esc_url( $package['button_url'] ); ?>" class="responsive_pricing_table-link"
                       rel="nofollow"><?php echo esc_attr( $package['button_text'] ); ?></a>
                </div>

            </div><!-- .responsive-pricing-table -->
        </div><!-- .responsive-pricing-table__cell -->

	<?php endforeach; ?>

</div>
