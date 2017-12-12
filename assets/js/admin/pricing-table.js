(function ($) {
    'use strict';

    $(document).on('click', '.addPackageFeature', function (e) {
        e.preventDefault();

        var rpt_feature_wrap = $(this).parent().find('.rpt-feature-wrap');

        console.log(rpt_feature_wrap);
    });

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
        });
    };

    $(document).ready(updatePackageIndex);

})(jQuery);