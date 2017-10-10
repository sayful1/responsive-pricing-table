(function( $ ) {
    "use strict";

    // Initializing Toggle
    $('.shapla-toggle').livequery(function(){
        $(".shapla-toggle").each( function () {
            if($(this).attr('data-id') == 'closed') {
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
    });

    // Initializing WP Color Picker
    $('.colorpicker').each(function(){
        $(this).wpColorPicker();
    });

    // Duplicate Form Fields
    $('#addNewPackage').on('click', function(){
        var _clone = $( ".shapla-toggle" ).first().clone(false, false);

        var _order = $('#rpt_manage_plans').find('.shapla-toggle--stroke').length;

        _clone.find("textarea, input").val("");
        _clone.find("input[type='checkbox']").prop('checked', false);
        _clone.find(".shapla-toggle-title").text('Package');

        _clone.appendTo( "#rpt_manage_plans" );
    });

    // Delete plan by clicking delete button
    $('.shapla-toggle').livequery(function(){
        $( ".shapla-toggle" ).each( function(){
            var _this = $(this);
            _this.on('click', '.deletePlan', function(){
                _this.hide('slow', function(){

                    _this.remove();
                });
            });
        });
    });

    // Make package sortable
    $('#rpt_manage_plans').sortable();

    // Add error class to post body content
    $("#post-body-content")
        .prepend("<div id='pricing_error' class='error' style='display:none'></div>");

    // Show error if title is blank.
    $('#post').submit(function() {

        $(this).find('input[type=checkbox]').each(function () {
            $(this).attr('value', $(this).is(':checked') ? 'on' : 'off');
            $(this).prop('checked', true);
        });

        if( $("#post_type").val() == 'pricing_tables' ){
            var err = 0;
            $("#pricing_error").html("");
            $("#pricing_error").hide();

            if($("#title").val() == ''){
                $("#pricing_error").append("<p>"+ ResponsivePricingTable.error_title +"</p>");
                err++;
            }
            if( err > 0 ){
                $("#publish").removeClass("button-primary-disabled");
                $("#ajax-loading").hide();
                $("#pricing_error").show();
                return false;
            }else{
                return true;
            }
        }
    });

})(jQuery);
