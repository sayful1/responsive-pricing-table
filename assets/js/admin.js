(function ($) {
    "use strict";

    // Initializing Toggle
    $(document).find(".shapla-toggle").each(function () {
        if ($(this).attr('data-id') === 'closed') {
            $(this).accordion({
                header: '.shapla-toggle-title',
                collapsible: true,
                heightStyle: "content",
                active: false
            });
        } else {
            $(this).accordion({
                header: '.shapla-toggle-title',
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

        var _order = $('#rpt_manage_plans').find('.shapla-toggle--stroke').length;

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
    $('#rpt_manage_plans').sortable();

})(jQuery);
