(function ($) {
    'use strict';

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
    $(document).find('.color-picker').each(function () {
        $(this).wpColorPicker();
    });

})(jQuery);