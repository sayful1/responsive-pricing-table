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

        _clone.find("textarea, input").val("");
        _clone.find("input[type='checkbox']").prop('checked', false);
        _clone.find(".shapla-toggle-title").text('Package');

        _clone.appendTo("#rpt_manage_plans");
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

    $(document).on('ready', updatePackageIndex());

})(jQuery);
