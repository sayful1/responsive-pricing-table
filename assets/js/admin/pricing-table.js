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
                _features = _package.find('.tab-rpt-features');

            // On Sale
            _package.find('.on-sale').attr('name', 'responsive_pricing_table[sale][' + index + ']');
        });
    };

    $(document).ready(function () {
        updatePackageIndex();
    });

})(jQuery);