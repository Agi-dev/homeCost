/**
 * Created by Francois on 08/11/2015.
 */
$(document).on('ready', function() {
    $("#excelFile").fileinput({
        language: 'fr',
        browseLabel: " Importer un relevé bancaire",
        browseIcon: "<i class=\"glyphicon glyphicon-folder-open\"></i>&nbsp;&nbsp;",
        browseClass: "btn btn-primary btn-block",
        showCaption: false,
        showRemove: false,
        showUpload: false,
        uploadUrl: "http://localhost.homecost.com/site/upload", // server upload action
        uploadAsync: false,
        showPreview: false,
        allowedFileExtensions: ['xls', 'txt']
    }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        $("#excelFile").fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data) {
       if ( data.response.success) {
           toastr.success(data.response.message);
       } else {
           toastr.error(data.response.message);
       }
    });
});