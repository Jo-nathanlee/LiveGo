$("#div_text").css("padding-top", $("#blah").height() / 3);
window.onload = function () {
    var options =
    {
        imageBox: '.imageBox',
        thumbBox: '.thumbBox',
        spinner: '.spinner',
        imgSrc: 'avatar.png'
    }
    var cropper;
    document.querySelector('#imgInp').addEventListener('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            options.imgSrc = e.target.result;
            cropper = new cropbox(options);
            cropper.zoomStart();
        }
        reader.readAsDataURL(this.files[0]);
        this.files = [];
    })
    document.querySelector('#btnCrop').addEventListener('click', function () {
        var img = cropper.getDataURL()
        $('#product_upload_img').attr('src', img);
        $("#activity").addClass("d-none");
    })
    document.querySelector('#btnZoomIn').addEventListener('click', function () {
        cropper.zoomIn();
    })
    document.querySelector('#btnZoomOut').addEventListener('click', function () {
        cropper.zoomOut();
    })
    document.querySelector('#btnDelete_pic').addEventListener('click', function () {
        $("#Upload_div").addClass("invisible");
        $("#imgInp").val('');
        $("#activity").addClass("d-none");
        $("#blah").removeClass("d-none");
    })
    document.querySelector('.activity_close').addEventListener('click', function () {
        $("#activity").addClass("d-none");
    })
    document.querySelector('.editicon_pic').addEventListener('click', function () {
        cropper.zoomStart();
    })
    document.querySelector('#Upload_div').addEventListener('click', function () {
        cropper.zoomStart();
    })
};