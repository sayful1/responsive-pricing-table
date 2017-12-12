(function ($) {
    'use strict';

    var plans_container = $('#rpt_manage_plans'),
        template = $('#template-responsive-pricing-table-package').html();

    var updatePackageIndex = function () {
        $(document).find('.rpt-package').each(function (index) {
            var _package = $(this),
                _features = _package.find('.tab-rpt-features').find('.rpt-feature');

            // On Sale
            _package.find('.on-sale').attr('name', 'responsive_pricing_table[sale][' + index + ']');

            // Features
            _features.each(function (index_num) {
                var _feature = $(this);
                _feature.find('.feature_text').attr('name', 'responsive_pricing_table[feature_text][' + index + '][' + index_num + ']');
                _feature.find('.feature_icon').attr('name', 'responsive_pricing_table[feature_icon][' + index + '][' + index_num + ']');
                _feature.find('.feature_icon_color').attr('name', 'responsive_pricing_table[feature_icon_color][' + index + '][' + index_num + ']');
            });

            // Show Ribbon
            _package.find('.show_ribbon').attr('name', 'responsive_pricing_table[show_ribbon][' + index + ']');
        });
    };

    // Add New Package
    $(document).on('click', '#addNewPackage', function () {

        plans_container.append(template);

        // Update package index
        updatePackageIndex();

        var last_package = plans_container.find('.rpt-package').last();
        // Update Accordion
        last_package.accordion({
            collapsible: true,
            heightStyle: "content",
            active: false
        });
        last_package.find(".rpt-feature").each(function () {
            var _this = $(this);

            if (_this.attr('data-id') === 'closed') {
                _this.accordion({
                    collapsible: true,
                    heightStyle: "content",
                    active: false
                });
            } else {
                _this.accordion({
                    collapsible: true,
                    heightStyle: "content"
                });
            }
        });
        // Update tabs
        last_package.find(".shapla-tabs").each(function () {
            $(this).tabs({
                hide: {
                    effect: "fadeOut",
                    duration: 200
                },
                show: {
                    effect: "fadeIn",
                    duration: 200
                }
            });
        });
        // Update color picker
        last_package.find('.color-picker').each(function () {
            $(this).wpColorPicker();
        });
    });

    // Delete package
    $(document).on('click', '.deletePackage', function (e) {
        e.preventDefault();

        var total_packages = plans_container.find('.rpt-package').length;

        if (total_packages === 1) {
            alert('You cannot delete all package.');
            return;
        }

        if (confirm('Are you sure to delete this package?')) {
            var _this = $(this).closest('.rpt-package');
            _this.slideUp('slow', function () {
                _this.remove();
                // Update package index
                updatePackageIndex();
            });
        }
    });

    // Add package feature
    $(document).on('click', '.addPackageFeature', function (e) {
        e.preventDefault();

        var rpt_feature_wrap = $(this).parent().find('.rpt-feature-wrap'),
            rpt_feature = rpt_feature_wrap.find('.rpt-feature').first(),
            new_feature = rpt_feature.clone(true);

        rpt_feature_wrap.append(new_feature);
        // Update index again
        updatePackageIndex();
    });

    // Delete Package Feature
    $(document).on('click', '.deleteFeature', function (e) {
        e.preventDefault();

        var _this = $(this),
            rpt_feature = _this.closest('.rpt-feature'),
            rpt_feature_wrap = _this.closest('.rpt-feature-wrap'),
            total_features = rpt_feature_wrap.find('.rpt-feature').length;

        if (total_features === 1) {
            alert('You cannot delete all features for this package.');
            return;
        }

        if (confirm('Are you sure to delete this package?')) {
            rpt_feature.slideUp('slow', function () {
                rpt_feature.remove();
                // Update package index
                updatePackageIndex();
            });
        }
    });

    // When document ready, update package index number
    $(document).ready(updatePackageIndex);

    // Make package sortable and update package index number
    plans_container.sortable({
        stop: function () {
            updatePackageIndex();
        }
    });

    $(document).find(".shapla-toggle").each(function () {
        var _this = $(this);

        if (_this.attr('data-id') === 'closed') {
            _this.accordion({
                collapsible: true,
                heightStyle: "content",
                active: false
            });
        } else {
            _this.accordion({
                collapsible: true,
                heightStyle: "content"
            });
        }
    });

    // Initializing jQuery UI Tab
    $(document).find(".shapla-tabs").each(function () {
        $(this).tabs({
            hide: {
                effect: "fadeOut",
                duration: 200
            },
            show: {
                effect: "fadeIn",
                duration: 200
            }
        });
    });

    // Initializing WP Color Picker
    $(document).find('.color-picker').each(function () {
        $(this).wpColorPicker();
    });

})(jQuery);