<template id="template-responsive-pricing-table-package" style="display: none;">
    <div data-id="closed" class="rpt-package responsive-pricing-table-package shapla-toggle shapla-toggle--stroke">
    <span class="shapla-toggle-title">
        <?php use Sayful\PricingTable\Currency;

        esc_html_e( 'Package:', 'responsive-pricing-table' ); ?>
        <span class="package_title"></span>
    </span>
        <div class="shapla-toggle-inner">
            <div class="shapla-toggle-content">

                <div class="shapla-section shapla-tabs shapla-tabs--stroke">
                    <div class="shapla-tab-inner">

                        <p><span class="deletePackage">Delete</span></p>

                        <ul class="shapla-nav shapla-clearfix">
                            <li>
                                <a href="#rpt-tab-header"><?php _e( 'Header', 'carousel-slider' ); ?></a>
                            </li>
                            <li>
                                <a href="#rpt-tab-pricing"><?php _e( 'Pricing', 'carousel-slider' ); ?></a>
                            </li>
                            <li>
                                <a href="#rpt-tab-features"><?php _e( 'Features', 'carousel-slider' ); ?></a>
                            </li>
                            <li>
                                <a href="#rpt-tab-footer"><?php _e( 'Footer', 'carousel-slider' ); ?></a>
                            </li>
                            <li>
                                <a href="#rpt-tab-ribbon"><?php _e( 'Ribbon', 'carousel-slider' ); ?></a>
                            </li>
                            <li>
                                <a href="#rpt-tab-style"><?php _e( 'Style', 'carousel-slider' ); ?></a>
                            </li>
                        </ul>

                        <div id="rpt-tab-header" class="shapla-tab tab-rpt-header">
							<?php
							$this->text( array(
								'id'       => 'package_title',
								'name'     => __( 'Package Title', 'responsive-pricing-table' ),
								'desc'     => __( 'Set the main heading of the price package.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'I am title', 'responsive-pricing-table' ),
							) );
							$this->text( array(
								'id'       => 'package_subtitle',
								'name'     => __( 'Package Subtitle', 'responsive-pricing-table' ),
								'desc'     => __( 'Set the subheading that appears below the main heading.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'I am subtitle', 'responsive-pricing-table' ),
							) );
							?>
                        </div>
                        <div id="rpt-tab-pricing" class="shapla-tab tab-rpt-pricing">
							<?php
							$currency = Currency::currency_list();
							$this->select( array(
								'id'       => 'currency_symbol',
								'name'     => __( 'Currency Symbol', 'responsive-pricing-table' ),
								'desc'     => __( 'Switch between the main currencies, or choose a custom symbol.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => 'dollar',
								'options'  => $currency,
							) );
							$this->text( array(
								'id'       => 'price',
								'name'     => __( 'Price', 'responsive-pricing-table' ),
								'desc'     => __( 'Set the exact pricing of your product or service, including cents', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( '39.99', 'responsive-pricing-table' ),
							) );
							$this->checkbox( array(
								'id'       => 'sale',
								'class'    => 'on-sale',
								'name'     => __( 'Sale', 'responsive-pricing-table' ),
								'desc'     => __( 'Display the original price with a strikethrough and the new sale price.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => 'off',
							) );
							$this->text( array(
								'id'       => 'original_price',
								'name'     => __( 'Original Price', 'responsive-pricing-table' ),
								'desc'     => __( 'Set the original price of your product or service, including cents', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( '59', 'responsive-pricing-table' ),
							) );
							$this->text( array(
								'id'       => 'period',
								'name'     => __( 'Period', 'responsive-pricing-table' ),
								'desc'     => __( 'This is the period of time for each payment that appears under the price', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'Monthly', 'responsive-pricing-table' ),
							) );
							?>
                        </div>
                        <div id="rpt-tab-features" class="shapla-tab tab-rpt-features">
                            <div class="rpt-feature-wrap">
								<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
                                    <div data-id="closed"
                                         class="rpt-feature shapla-toggle shapla-toggle--stroke">
                                <span class="shapla-toggle-title">
                                    <?php echo __( 'List Item', 'responsive-pricing-table' ) . " {$i}"; ?>
                                </span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
                                                <p style="margin-bottom: 10px;"><span class="deleteFeature">Delete this feature</span>
                                                </p>
												<?php
												$this->text( array(
													'id'       => 'feature_text',
													'class'    => 'feature_text',
													'name'     => __( 'Text', 'responsive-pricing-table' ),
													'desc'     => __( 'Write feature text.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'std'      => __( 'List Item', 'responsive-pricing-table' ) . " {$i}",
												) );
												$this->text( array(
													'id'       => 'feature_icon',
													'class'    => 'feature_icon',
													'name'     => __( 'Icon', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose icon for feature.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'std'      => '',
												) );
												$this->color( array(
													'id'       => 'feature_icon_color',
													'class'    => 'feature_icon_color',
													'name'     => __( 'Icon color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose icon color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'std'      => '',
												) );
												?>
                                            </div>
                                        </div>
                                    </div>
								<?php endfor; ?>
                            </div>
                            <button class="button button-primary addPackageFeature">Add Item</button>
                        </div>
                        <div id="rpt-tab-footer" class="shapla-tab tab-rpt-footer">
							<?php
							$this->text( array(
								'id'       => 'button_text',
								'name'     => __( 'Button Text', 'responsive-pricing-table' ),
								'desc'     => __( 'Write the text that will appear for the button', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'Buy Now', 'responsive-pricing-table' ),
							) );
							$this->text( array(
								'id'       => 'button_link',
								'name'     => __( 'Link', 'responsive-pricing-table' ),
								'desc'     => __( 'Choose where the button will link to. eg. https://example.com', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => '#',
							) );
							$this->text( array(
								'id'       => 'additional_info',
								'name'     => __( 'Additional Info', 'responsive-pricing-table' ),
								'desc'     => __( 'Include a line of additional info below the button', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'This is text element', 'responsive-pricing-table' ),
							) );
							?>
                        </div>
                        <div id="rpt-tab-ribbon" class="shapla-tab tab-rpt-ribbon">
							<?php
							$this->checkbox( array(
								'id'       => 'show_ribbon',
								'class'    => 'show_ribbon',
								'name'     => __( 'Show Ribbon', 'responsive-pricing-table' ),
								'desc'     => __( 'Check to add a textual ribbon.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => 'on',
							) );
							$this->text( array(
								'id'       => 'ribbon_title',
								'name'     => __( 'Ribbon Title', 'responsive-pricing-table' ),
								'desc'     => __( 'Write ribbon title.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => __( 'Popular', 'responsive-pricing-table' ),
							) );
							$this->select( array(
								'id'       => 'ribbon_position',
								'name'     => __( 'Ribbon Horizontal Position', 'responsive-pricing-table' ),
								'desc'     => __( 'Choose ribbon horizontal position.', 'responsive-pricing-table' ),
								'multiple' => 'on',
								'std'      => 'right',
								'options'  => array(
									'left'  => __( 'Left', 'responsive-pricing-table' ),
									'right' => __( 'Right', 'responsive-pricing-table' ),
								)
							) );
							?>
                        </div>
                        <div id="rpt-tab-style" class="shapla-tab tab-rpt-style">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>