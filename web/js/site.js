/**
 * Created by Francois on 11/11/2015.
 */
$(document).on('ready', function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "15000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
});

function ajaxFailed() {
    toastr.error('le site a rencontré un pb.');
}

function toastrSuccess(msg, short) {
    var isShort = short || 0;
    if ( isShort) {
        toastr.options.timeOut = 2000;
    }
    toastr.success(msg);
    if ( isShort) {
        toastr.options.timeOut = 15000;
    }
}