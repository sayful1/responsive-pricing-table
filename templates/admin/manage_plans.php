<p><span id='addNewPackage' class="button button-default"><?php _e( 'Add New Package' ); ?></span></p>
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
								$currency = Responsive_Pricing_Table_Currency::currency_list();
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

	<?php endforeach; ?>
</div>