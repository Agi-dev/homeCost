/**
 * Created by Francois on 08/11/2015.
 */
$(document).on('ready', function() {
    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.onText = 'O';
    $.fn.bootstrapSwitch.defaults.offText = 'N';
    $("[name='my-checkbox']").bootstrapSwitch();

    $('.btn-categ').on('click', function () {
        //var $label = $(this).children('span');
        //var bClass = 'label';
        var $label = $(this);
        var bClass = 'btn';
        if ( $label.hasClass(bClass + '-default')){
            $label.removeClass(bClass + '-default');
            $label.addClass(bClass + '-success');
        } else {
            $label.removeClass(bClass + '-success');
            $label.addClass(bClass + '-default');
        }
    });

    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(this); // DOM element
        console.log(event); // jQuery event
        console.log(state); // true | false
    });
});