
Dropzone.options.dropzoneForm = {
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFilesize: 500,
    maxFiles: 5,
    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",

    init: function () {
        var submitButton = document.querySelector("#submit-all");
        myDropzone = this;

        submitButton.addEventListener('click', function () {
            myDropzone.processQueue();

        });
        this.on("complete", function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                var _this = this;
                _this.removeAllFiles();
            }
            load_images();
        });
    }
};
//Alerts
$(document).ready(function(){

    $('.alert-success').fadeIn().delay(3000).fadeOut();
    $('.alert-danger').fadeIn().delay(3000).fadeOut();
    
    });


