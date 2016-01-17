$(document).on('ready', function() {
   $('.btn-year').on('change', function (e) {
       e.preventDefault();
       window.location = '/dashboard/index/' + $('input[name=year]:checked').val();
   })
});