/**
 * Created by Francois on 08/11/2015.
 */
$(function() {
    $("#excelFile").fileinput({
        language: 'fr',
        browseLabel: " Importer un relevé bancaire",
        browseIcon: "<i class=\"glyphicon glyphicon-folder-open\"></i>&nbsp;&nbsp;",
        browseClass: "btn btn-primary btn-block",
        showCaption: false,
        showRemove: false,
        showUpload: false,
        uploadUrl: "/site/upload", // server upload action
        uploadAsync: false,
        showPreview: false,
        allowedFileExtensions: ['xls', 'txt', 'csv']
    }).on("filebatchselected", function (event, files) {
        // trigger upload method immediately after files are selected
        $("#excelFile").fileinput("upload");
    }).on('filebatchuploadsuccess', function (event, data) {
        if (data.response.success) {
            window.location = 'site/process'
        } else {
            toastr.error(data.response.message);
        }
    });
});