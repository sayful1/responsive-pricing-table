<p><span id='addNewPackage' class="button button-default"><?php use Sayful\PricingTable\Currency;

		_e( 'Add New Package' ); ?></span></p>
<div id="rpt_manage_plans">
	<?php foreach ( $packages as $package ): ?>

        <div data-id="closed" class="rpt-package responsive-pricing-table-package shapla-toggle shapla-toggle--stroke">
            <span class="shapla-toggle-title">
                <?php esc_html_e( 'Package:', 'responsive-pricing-table' ); ?>
                <span class="package_title"><?php echo $package['package_title']; ?></span>
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
									'std'      => $package['package_title'],
								) );
								$this->text( array(
									'id'       => 'package_subtitle',
									'name'     => __( 'Package Subtitle', 'responsive-pricing-table' ),
									'desc'     => __( 'Set the subheading that appears below the main heading.', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['package_subtitle'],
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
									'std'      => $package['currency_symbol'],
									'options'  => $currency,
								) );
								$this->text( array(
									'id'       => 'price',
									'name'     => __( 'Price', 'responsive-pricing-table' ),
									'desc'     => __( 'Set the exact pricing of your product or service, including cents', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['price'],
								) );
								$this->checkbox( array(
									'id'       => 'sale',
									'class'    => 'on-sale',
									'name'     => __( 'Sale', 'responsive-pricing-table' ),
									'desc'     => __( 'Display the original price with a strikethrough and the new sale price.', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['sale'],
								) );
								$this->text( array(
									'id'       => 'original_price',
									'name'     => __( 'Original Price', 'responsive-pricing-table' ),
									'desc'     => __( 'Set the original price of your product or service, including cents', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['original_price'],
								) );
								$this->text( array(
									'id'       => 'period',
									'name'     => __( 'Period', 'responsive-pricing-table' ),
									'desc'     => __( 'This is the period of time for each payment that appears under the price', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['period'],
								) );
								?>
                            </div>
                            <div id="rpt-tab-features" class="shapla-tab tab-rpt-features">
                                <div class="rpt-feature-wrap">
									<?php foreach ( $package['features'] as $feature ): ?>
                                        <div data-id="closed"
                                             class="rpt-feature shapla-toggle shapla-toggle--stroke">
                                            <span class="shapla-toggle-title">
                                                <?php echo $feature['text']; ?>
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
														'std'      => $feature['text'],
													) );
													$this->text( array(
														'id'       => 'feature_icon',
														'class'    => 'feature_icon',
														'name'     => __( 'Icon', 'responsive-pricing-table' ),
														'desc'     => __( 'Choose icon for feature.', 'responsive-pricing-table' ),
														'multiple' => 'on',
														'std'      => $feature['icon'],
													) );
													$this->color( array(
														'id'       => 'feature_icon_color',
														'class'    => 'feature_icon_color',
														'name'     => __( 'Icon color', 'responsive-pricing-table' ),
														'desc'     => __( 'Choose icon color.', 'responsive-pricing-table' ),
														'multiple' => 'on',
														'std'      => $feature['icon_color'],
													) );
													?>
                                                </div>
                                            </div>
                                        </div>
									<?php endforeach; ?>
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
									'std'      => $package['button_text'],
								) );
								$this->text( array(
									'id'       => 'button_link',
									'name'     => __( 'Link', 'responsive-pricing-table' ),
									'desc'     => __( 'Choose where the button will link to. eg. https://example.com', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['button_link'],
								) );
								$this->text( array(
									'id'       => 'additional_info',
									'name'     => __( 'Additional Info', 'responsive-pricing-table' ),
									'desc'     => __( 'Include a line of additional info below the button', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['additional_info'],
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
									'std'      => $package['show_ribbon'],
								) );
								$this->text( array(
									'id'       => 'ribbon_title',
									'name'     => __( 'Ribbon Title', 'responsive-pricing-table' ),
									'desc'     => __( 'Write ribbon title.', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['ribbon_title'],
								) );
								$this->select( array(
									'id'       => 'ribbon_position',
									'name'     => __( 'Ribbon Horizontal Position', 'responsive-pricing-table' ),
									'desc'     => __( 'Choose ribbon horizontal position.', 'responsive-pricing-table' ),
									'multiple' => 'on',
									'std'      => $package['ribbon_position'],
									'options'  => array(
										'left'  => __( 'Left', 'responsive-pricing-table' ),
										'right' => __( 'Right', 'responsive-pricing-table' ),
									)
								) );
								?>
                            </div>

                            <div id="rpt-tab-style" class="shapla-tab tab-rpt-style">
                                <div class="rpt-style-wrap">

                                    <div data-id="closed" class="shapla-toggle shapla-toggle--stroke">
                                        <span class="shapla-toggle-title"><?php _e( 'Header', 'responsive-pricing-table' ); ?></span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
												<?php
												$this->color( array(
													'id'       => 'header_background_color',
													'class'    => 'header_background_color',
													'name'     => __( 'Background Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose header background color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#555555',
													'std'      => empty( $package['header_background_color'] ) ?: $package['header_background_color'],
												) );
												$this->spacing( array(
													'id'       => 'header_background_padding',
													'class'    => 'header_background_padding',
													'name'     => __( 'Background Padding', 'responsive-pricing-table' ),
													'desc'     => __( 'Write header background padding.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => array(
														'top'    => '20px',
														'wright' => '0',
														'bottom' => '20px',
														'left'   => '0',
													),
													'std'      => empty( $package['header_background_padding'] ) ?: $package['header_background_padding'],
												) );
												$this->color( array(
													'id'       => 'header_title_color',
													'class'    => 'header_title_color',
													'name'     => __( 'Title Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose header title color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#ffffff',
													'std'      => empty( $package['header_title_color'] ) ?: $package['header_title_color'],
												) );
												$this->text( array(
													'id'       => 'header_title_font_size',
													'class'    => 'header_title_font_size',
													'name'     => __( 'Title Font Size', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose header title font size.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '24px',
													'std'      => empty( $package['header_title_font_size'] ) ?: $package['header_title_font_size'],
												) );
												$this->color( array(
													'id'       => 'header_subtitle_color',
													'class'    => 'header_subtitle_color',
													'name'     => __( 'Subtitle Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose header subtitle color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#ffffff',
													'std'      => empty( $package['header_title_color'] ) ?: $package['header_title_color'],
												) );
												$this->text( array(
													'id'       => 'header_subtitle_font_size',
													'class'    => 'header_subtitle_font_size',
													'name'     => __( 'Subtitle Font Size', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose header subtitle font size.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '13px',
													'std'      => empty( $package['header_subtitle_font_size'] ) ?: $package['header_subtitle_font_size'],
												) );
												?>
                                            </div>
                                        </div>
                                    </div><!-- Header -->
                                    <div data-id="closed" class="shapla-toggle shapla-toggle--stroke">
                                        <span class="shapla-toggle-title"><?php _e( 'Pricing', 'responsive-pricing-table' ); ?></span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
												<?php
												$this->color( array(
													'id'       => 'pricing_background_color',
													'class'    => 'pricing_background_color',
													'name'     => __( 'Background Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose pricing background color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#f5f5f5',
													'std'      => empty( $package['pricing_background_color'] ) ?: $package['pricing_background_color'],
												) );
												$this->color( array(
													'id'       => 'pricing_text_color',
													'class'    => 'pricing_text_color',
													'name'     => __( 'Text Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose pricing text color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#555555',
													'std'      => empty( $package['pricing_text_color'] ) ?: $package['pricing_text_color'],
												) );
												$this->spacing( array(
													'id'       => 'pricing_padding',
													'class'    => 'pricing_padding',
													'name'     => __( 'Pricing Padding', 'responsive-pricing-table' ),
													'desc'     => __( 'Write pricing padding.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => array(
														'top'    => '20px',
														'wright' => '0',
														'bottom' => '20px',
														'left'   => '0',
													),
													'std'      => empty( $package['pricing_padding'] ) ?: $package['pricing_padding'],
												) );
												$this->text( array(
													'id'       => 'currency_size',
													'class'    => 'currency_size',
													'name'     => __( 'Currency Symbol Size', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose currency symbol size.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '20px',
													'std'      => empty( $package['currency_size'] ) ? '20px' : $package['currency_size'],
												) );
												$this->vertical_position( array(
													'id'       => 'currency_vertical_position',
													'class'    => 'currency_vertical_position',
													'name'     => __( 'Currency Vertical Position', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose currency symbol vertical position.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => 'top',
													'std'      => empty( $package['currency_vertical_position'] ) ?: $package['currency_vertical_position'],
												) );
												$this->text( array(
													'id'       => 'fractional_size',
													'class'    => 'fractional_size',
													'name'     => __( 'Fractional Part Size', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose fractional part size.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '20px',
													'std'      => empty( $package['fractional_size'] ) ? '20px' : $package['fractional_size'],
												) );
												$this->vertical_position( array(
													'id'       => 'fractional_vertical_position',
													'class'    => 'fractional_vertical_position',
													'name'     => __( 'Fractional Part Vertical Position', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose fractional part vertical position.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => 'top',
													'std'      => empty( $package['fractional_vertical_position'] ) ?: $package['fractional_vertical_position'],
												) );
												$this->color( array(
													'id'       => 'period_text_color',
													'class'    => 'period_text_color',
													'name'     => __( 'Period Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose period text color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#555555',
													'std'      => empty( $package['pricing_text_color'] ) ?: $package['pricing_text_color'],
												) );
												?>
                                            </div>
                                        </div>
                                    </div><!-- Pricing -->
                                    <div data-id="closed" class="shapla-toggle shapla-toggle--stroke">
                                        <span class="shapla-toggle-title"><?php _e( 'Features', 'responsive-pricing-table' ); ?></span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
                                            </div>
                                        </div>
                                    </div><!-- Features -->
                                    <div data-id="closed" class="shapla-toggle shapla-toggle--stroke">
                                        <span class="shapla-toggle-title"><?php _e( 'Footer', 'responsive-pricing-table' ); ?></span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
                                            </div>
                                        </div>
                                    </div><!-- Footer -->
                                    <div data-id="closed" class="shapla-toggle shapla-toggle--stroke">
                                        <span class="shapla-toggle-title"><?php _e( 'Ribbon', 'responsive-pricing-table' ); ?></span>
                                        <div class="shapla-toggle-inner">
                                            <div class="shapla-toggle-content">
												<?php
												$this->color( array(
													'id'       => 'ribbon_background_color',
													'class'    => 'ribbon_background_color',
													'name'     => __( 'Ribbon Background Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose ribbon background color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#000000',
													'std'      => empty( $package['ribbon_background_color'] ) ? '#000000' : $package['ribbon_background_color'],
												) );
												$this->color( array(
													'id'       => 'ribbon_text_color',
													'class'    => 'ribbon_text_color',
													'name'     => __( 'Ribbon Text Color', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose ribbon text color.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '#ffffff',
													'std'      => empty( $package['ribbon_text_color'] ) ? '#ffffff' : $package['ribbon_text_color'],
												) );
												$this->text( array(
													'id'       => 'ribbon_distance',
													'class'    => 'ribbon_distance',
													'name'     => __( 'Ribbon Distance', 'responsive-pricing-table' ),
													'desc'     => __( 'Choose ribbon distance.', 'responsive-pricing-table' ),
													'multiple' => 'on',
													'default'  => '30px',
													'std'      => empty( $package['ribbon_distance'] ) ? '30px' : $package['ribbon_distance'],
												) );
												?>
                                            </div>
                                        </div>
                                    </div><!-- Ribbon -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

	<?php endforeach; ?>
</div>