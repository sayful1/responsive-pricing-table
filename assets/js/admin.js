(function ($) {
    "use strict";

    var plans_container = $('#rpt_manage_plans'),
        template = $('#template-responsive-pricing-table-package').html();

    function updatePackageIndex() {
        $('#rpt_manage_plans').find('.responsive-pricing-table-package').each(function (index) {
            $(this)
                .find('.is_recommended_package')
                .attr('name', 'responsive_pricing_table[recommended][' + index + ']');
        });
    }

    // Duplicate Form Fields
    $(document).on('click', '#addNewPackage', function () {
        $("#rpt_manage_plans").append(template);
    });

    // Delete plan by clicking delete button
    $(document).on('click', '.deletePlan', function () {

        var total_packages = plans_container.find('.shapla-toggle').length;

        if (total_packages === 1) {
            alert('You cannot delete all package.');
            return;
        }

        var confirmDelete = confirm('Are you sure to delete this package?');

        if (confirmDelete) {
            var _this = $(this).closest('.shapla-toggle');
            _this.slideUp('slow', function () {
                _this.remove();
            });
        }
    });


    $(document).on('click', '.is_recommended_package', function () {
        var isCheck = $(this).is(':checked');
        $(document).find('.is_recommended_package[type=checkbox]').prop('checked', false);
        $(this).prop('checked', isCheck);
    });

    // Make package sortable
    plans_container.sortable({
        stop: function () {
            updatePackageIndex();
        }
    });

    $(document).ready(function () {
        updatePackageIndex();
    });

})(jQuery);

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
(function ($) {
    'use strict';

    $('body').find(".shapla-toggle").each(function () {
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
    $(".shapla-tabs").tabs({
        hide: {
            effect: "fadeOut",
            duration: 200
        },
        show: {
            effect: "fadeIn",
            duration: 200
        }
    });

    // Initializing WP Color Picker
    $('.colorpicker').each(function () {
        $(this).wpColorPicker();
    });

})(jQuery);