(function ($) {
    "use strict";

    var plans_container = $('#rpt_manage_plans');

    function updatePackageIndex() {
        $('#rpt_manage_plans').find('.responsive-pricing-table-package').each(function (index) {
            $(this)
                .find('.is_recommended_package')
                .attr('name', 'responsive_pricing_table[recommended][' + index + ']');
        });
    }

    // Initializing Toggle
    $(document).find(".shapla-toggle").each(function () {
        if ($(this).attr('data-id') === 'closed') {
            $(this).accordion({
                collapsible: true,
                heightStyle: "content",
                active: false
            });
        } else {
            $(this).accordion({
                collapsible: true,
                heightStyle: "content"
            });
        }
    });

    // Initializing WP Color Picker
    $('.colorpicker').each(function () {
        $(this).wpColorPicker();
    });

    // Duplicate Form Fields
    $(document).on('click', '#addNewPackage', function () {
        var _clone = $(".shapla-toggle").first().clone(false, false);

        var _order = plans_container.find('.shapla-toggle--stroke').length;

        _clone.find("textarea, input").val("");
        _clone.find("input[type='checkbox']").prop('checked', false);
        _clone.find(".shapla-toggle-title").text('Package');

        _clone.appendTo("#rpt_manage_plans");
    });

    // Delete plan by clicking delete button
    $(document).on('click', '.deletePlan', function () {
        var _this = $(this).closest('.shapla-toggle');
        _this.hide('slow', function () {

            _this.remove();
        });
    });

    // Make package sortable
    plans_container.sortable({
        stop: function () {
            updatePackageIndex();
        }
    });

    $(document).on('ready', updatePackageIndex());

})(jQuery);
